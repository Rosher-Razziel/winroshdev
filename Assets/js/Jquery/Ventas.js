let productosVenta = [];

console.log("LLEGUE A VENTAS");

$(document).ready(function() {
  // Foco automático en el campo de código de barras al cargar
  $("#codigo_barras").focus(); 
  
  // Refuerzo del foco en el campo de código de barras cuando se hace clic en la tabla
  $('#cot_productos').on('click', function(){
    $("#codigo_barras").focus();
  });
});

// Configuración general del Toast para notificaciones
const Toast = Swal.mixin({
  toast: true,
  position: "top-end",
  showConfirmButton: false,
  timer: 2000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.onmouseenter = Swal.stopTimer;
    toast.onmouseleave = Swal.resumeTimer;
  }
});

$('#codigo_barras').on('keyup', function (e){
  const urlAutocomplete = base_url + "Ventas/autocomplete"; 
  let codigo = $('#codigo_barras').val();
  
  if (e.which === 13 && codigo !== "") {
    const urlAgregar = base_url + "Ventas/agregar";
    let multiplicador = codigo.lastIndexOf('*');
    let cantidad = multiplicador > 0 ? codigo.split("*")[0] : 1;
    codigo = multiplicador > 0 ? codigo.split("*")[1] : codigo;

    // Solicitud para agregar producto
    $.post(urlAgregar, {'codigo': codigo}, function (response){
      let res = JSON.parse(response);

      if (res) {
        let productoExistente = productosVenta.findIndex(p => p[0] === codigo);
        if (productoExistente !== -1) {
          productosVenta[productoExistente][3] += parseInt(cantidad);
        } else {
          res.forEach(row => {
            productosVenta.push([row['COD_BARRAS'], row['PRODUCTO'], parseFloat(row['PRECIO_VENTA']), parseInt(cantidad), row['ID_PRODUCTO']]);
          });
        }

        res.forEach(row => {
          if (row['EXISTENCIAS'] < row['EXISTENCIA_MINIMA']) {
            Toast.fire({
              icon: "warning",
              title: "Stock bajo."
            });
          }
        });

        mostrarProductos();
        obtenerCambio();
      } else {
        Swal.fire({
          title: "Advertencia",
          text: "Código de barras no registrado",
          icon: "warning",
          showConfirmButton: false,
          timer: 1500
        });
      }
    });

    $('#codigo_barras').val('');
  }

  // Autocompletar productos
  if (codigo !== "") {
    $.post(urlAutocomplete, {'codigo': codigo}, function (response){
      let res = JSON.parse(response);
      let items = res.map(row => ({
        label: row['PRODUCTO'],
        value: row['COD_BARRAS']
      }));

      $("#codigo_barras").autocomplete({
        source: items,
        autoFocus: true
      });
    });
  }
});

// Mostrar productos en la tabla
function mostrarProductos(){
  let template = '', btnCantidad = '', total = 0, porcentaje = 0.035, iva = 0.209;
  productosVenta.forEach(producto => {
    let importe = parseFloat(producto[2]) * parseFloat(producto[3]);

    template += `
      <tr>
        <td class="text-center">${producto[3]}</td>
        <td>${producto[1]}</td>
        <td class="text-center">${producto[2]}</td>
        <td class="text-center">$${importe.toFixed(2)}</td>
        <td>
          <button class="btn btn-warning mb-2" onclick="btnDescontarItem(${producto[4]});">
            <i class="fa-solid fa-minus"></i>
          </button>
          <button class="btn btn-danger mb-2" onclick="btnEliminarItem(${producto[4]});">
            <i class="fa-solid fa-trash"></i>
          </button>
          <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@fat" onclick="btnAsignarId(${producto[4]});">
            <i class="fa-solid fa-marker"></i>
          </button>
        </td>
      </tr>`;
    total += importe;
  });

  let porcentajeEnPesos = total * porcentaje;
  let ivaEnPesos = porcentajeEnPesos * iva;
  let pagoTarjeta = total + porcentajeEnPesos + ivaEnPesos;

  $('#total').val(total);
  $('#totalProductos').html(`$${total.toFixed(2)}`);
  $('#pagoTarjeta').html(`$${pagoTarjeta.toFixed(2)}`);
  $('#bodyProductos').html(template);
}

// Calcular cambio
$('#pagaCon').on('keyup', obtenerCambio);

function obtenerCambio(){
  let total = parseFloat($('#total').val());
  let pagaCon = parseFloat($('#pagaCon').val());
  let cambio = pagaCon >= total ? pagaCon - total : 0;
  $('#cambio').val(cambio.toFixed(2));
}

// Descontar productos
function btnDescontarItem(idItem){
  let indice = productosVenta.findIndex(p => p[4] === idItem);
  if (indice !== -1) {
    productosVenta[indice][3] -= 1; 
    if (productosVenta[indice][3] === 0) {
      productosVenta.splice(indice, 1);
    }
    mostrarProductos();
    resetPago();
  }
}

// Eliminar productos
function btnEliminarItem(idItem){
  let indice = productosVenta.findIndex(p => p[4] === idItem);
  if (indice !== -1) {
    productosVenta.splice(indice, 1);
    mostrarProductos();
    resetPago();
  }
}

function btnAsignarId(idItem){
  let indice = productosVenta.findIndex(p => p[4] === idItem);
  $('#indice').val(indice);
}

// Descontar productos
function btnCambiarCantidad(){
  let indice = $('#indice').val();
  let cantidadUser = $('#cantidad').val();

  if (indice !== -1) {
    productosVenta[indice][3] = cantidadUser; 
    if (productosVenta[indice][3] === 0) {
      productosVenta.splice(indice, 1);
    }
    mostrarProductos();
    resetPago();
  }
}

// Función auxiliar para reiniciar campos de pago
function resetPago(){
  $('#pagaCon').val('');
  $('#cambio').val('');
  $("#codigo_barras").focus();
}

// Cobrar venta
$("#frmCobrar").on('submit', function(e){
  e.preventDefault();
  const urlVender = base_url + "Ventas/vender";
  let totalVenta = $('#total').val();
  let pagoCon = $('#pagaCon').val();
  let cambio = $('#cambio').val();

  if (parseFloat(pagoCon) >= parseFloat(totalVenta)) {
    $.post(urlVender, {"productosVenta": productosVenta, "totalVenta": totalVenta, "cambio": cambio, "pagoCon": pagoCon}, function (response){
      let res = JSON.parse(response);
      if (res.msg === "Ok") {
        productosVenta = [];
        mostrarProductos();
        resetPago();

        Swal.fire({
          title: "Abrir Ticket",
          text: "¿Quiere abrir ticket para imprimir?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Sí, abrir.",
          cancelButtonText: "Cancelar",
        }).then((result) => {
          if (result.isConfirmed) {
            const ruta = base_url + 'Ventas/generarPdf/' + res.idVenta;
            window.open(ruta);
          }
        });
      } else {
        Swal.fire({
          title: "Error",
          text: "Error al generar la venta",
          icon: "error",
          showConfirmButton: false,
          timer: 1500
        });
      }
    });
  } else {
    Toast.fire({
      icon: "warning",
      title: "Importe insuficiente."
    });
  }
});
