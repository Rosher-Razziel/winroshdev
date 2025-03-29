console.log("LLEGUE  A COMPRAS")
$(document).ready(function() {
  $("#codigo_bar").focus();
});

// BUSCAR PRODUCTOS PARA COMPRAS
function buscarProductosProv(e) {
  e.preventDefault();

  const idProv = $('#proveedor').val();
  
  if (idProv == 0) {
    $('#tblContenido').html('');
    return;
  }

  const url = `${base_url}Compras/buscarProductosProv/${idProv}`;
  const fecha = new Date();
  const nombre = `F-${fecha.getDate()}${fecha.getHours()}${fecha.getSeconds()}${idProv}`;
  
  $('#folioPedido').val(nombre);
  
  $.post(url, function(response) {
    const res = JSON.parse(response);
    if (!res) {
      Swal.fire({
        title: "Advertencia",
        text: "Proveedor sin productos o el stock mínimo está completo",
        icon: "warning",
        showConfirmButton: false,
        timer: 1500
      });
      $('#proveedor').val(0);
      $('#tblContenido').html('');
      return;
    }
    
    let html = '';
    let sumaTotal = 0;
    
    res.forEach(row => {
      const comprar = Math.max(row['EXISTENCIA_MINIMA'] - row['EXISTENCIAS'], 0);
      const sub_total = (comprar * row['PRECIO_COMPRA']).toFixed(2);
      
      html += `
        <tr id="${row['ID_PRODUCTO']}">
          <td>${row['DES_PROVEEDOR']}</td>
          <td>${row['PRODUCTO']}</td>
          <td style="text-align: center;">${row['EXISTENCIA_MINIMA']}</td>
          <td style="text-align: center;">${row['EXISTENCIAS']}</td>
          <td>
            <input id="cantidadP${row['ID_PRODUCTO']}" value="${comprar}" class="form-control" type="number" onkeyup="calcularSubTotal(event, ${row['ID_PRODUCTO']}, ${row['PRECIO_COMPRA']})">
          </td>
          <td style="text-align: center;">$${row['PRECIO_COMPRA']}</td>
          <td style="text-align: center;" id="subTotal${row['ID_PRODUCTO']}">
            $ ${sub_total}
          </td>
        </tr>`;
      
      sumaTotal += parseFloat(sub_total);
    });
    
    $('#tblContenido').html(html);
    $('#total').val(sumaTotal.toFixed(2));
  });
}

// CALCULAR SUBTOTAL
function calcularSubTotal(e, idFila, precio_compra) {
  let cantidad = Math.max(0, parseInt($('#cantidadP' + idFila).val()) || 0);
  $('#cantidadP' + idFila).val(cantidad);
  
  const subTotal = (cantidad * precio_compra).toFixed(2);
  $('#subTotal' + idFila).html(`$ ${subTotal}`);
  
  let sumaTotal = 0;
  $("#tblContenido tr").each(function() {
    const subtotal = parseFloat($(this).find('td').eq(6).text().replace('$', '')) || 0;
    sumaTotal += subtotal;
  });
  
  $('#total').val(sumaTotal.toFixed(2));
}

// OBTENER DATOS DE LA TABLA
function generarPedidoPdf() {
  if ($('#proveedor').val() == 0) {
    Swal.fire({
      title: "Advertencia",
      text: "No se ha seleccionado ningún proveedor",
      icon: "warning",
      showConfirmButton: false,
      timer: 1500
    });
    return;
  }

  let productos = [];
  let sumaTotal = 0;
  
  $("#tblContenido tr").each(function() {
    const idProducto = $(this).attr("id");
    const prov = $(this).find('td').eq(0).text();
    const nombreP = $(this).find('td').eq(1).text();
    const exis_min = parseInt($(this).find('td').eq(2).text());
    const existencias = parseInt($(this).find('td').eq(3).text());
    const cantidad = parseInt($('#cantidadP' + idProducto).val());
    const compra = parseFloat($(this).find('td').eq(5).text().replace('$', ''));
    const subtotal = parseFloat($(this).find('td').eq(6).text().replace('$', ''));

    sumaTotal += subtotal;
    
    productos.push({ idProducto, proveedor: prov, nombreP, exis_min, existencia: existencias, cantidad, compra, subtotal });
  });

  const url = `${base_url}Compras/registrar`;
  const idProveedor = $('#proveedor').val();
  const folio = $('#folioPedido').val();
  const totalP = sumaTotal.toFixed(2);

  Swal.fire({
    title: "GENERAR PDF",
    text: "¿Desea generar en PDF?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "SI, Abrirlo"
  }).then(result => {
    if (result.isConfirmed) {
      $.post(url, { productos, idProveedor, idFolio: folio, totalP }, function(response) {
        const res = JSON.parse(response);
        if (res.msg === "Correcto") {
          const ruta = `${base_url}Compras/generarPdf/${res.idPedido}`;
          window.open(ruta);
          
          $('#total').val('');
          $('#proveedor').val(0);
          $('#folioPedido').val('');
          $('#tblContenido').html('');
        } else {
          Swal.fire({
            title: "Error",
            text: "Error al mostrar datos.",
            icon: "error",
            showConfirmButton: false,
            timer: 1500
          });
        }
      });
    }
  });
}