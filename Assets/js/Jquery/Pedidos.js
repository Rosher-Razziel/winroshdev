const URL_LISTAR_PEDIDOS = `${base_url}Pedidos/listar`;
const URL_BUSCAR_PRODUCTOS_PEDIDO = `${base_url}Pedidos/buscarProductosPedido/`;
const URL_REGISTRAR_PEDIDO = `${base_url}Pedidos/registrar`;
const URL_CANCELAR_PEDIDO = `${base_url}Pedidos/canelarPedido`;

$(document).ready(function() {

  const tblPedidos = $('#TblPedidos').DataTable({
    ajax: {
      url: URL_LISTAR_PEDIDOS,
      dataSrc: ""
    },
    columns: [
      { data: "ID_PEDIDO_PROVEEDOR" },
      { data: "DES_PROVEEDOR" },
      { data: "TOTAL_PEDIDO" },
      { data: "FECHA_PEDIDO" },
      { data: "ESTADO" },
      { data: "ACCIONES" }
    ],
    language: { url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json" },
    order: [[0, "desc"]],
    responsive: true
  });
});
  function showAlert(title, text, icon) {
    Swal.fire({
      title: title,
      text: text,
      icon: icon,
      showConfirmButton: false,
      timer: 1500
    });
  }

  function btnDetallesPedidos(idPedido, estado) {
    $('#btnBack').removeClass('d-none');
    $('#titlePedido').text('Pedido Detalles');
    $('#contenido').empty();

    $.post(`${URL_BUSCAR_PRODUCTOS_PEDIDO}${idPedido}`, function(response) {
      try {
        const res = JSON.parse(response);
        if (res) {
          let html = `<table id="TblDetallesProductos" class="table table-light">
            <thead class="thead-dark">
              <tr>
                <th>ID</th>
                <th>PROVEEDOR</th>
                <th>PRODUCTO</th>
                <th>CANTIDAD</th>
                <th>ESTADO</th>
              </tr>
            </thead>
            <tbody id="TblDetalles">`;

          res.forEach(row => {
            const estadoBadge = row['ESTADO'] === 0 ? 'En Proceso' : row['ESTADO'] === 1 ? 'Entregado' : 'No recibido';
            const estadoClass = row['ESTADO'] === 0 ? 'btn-warning' : row['ESTADO'] === 1 ? 'btn-success' : 'btn-danger';

            html += `<tr id="${row['ID_DETALLE_PEDIDO']}">
              <td>${row['ID_DETALLE_PEDIDO']}</td>
              <td>${row['DES_PROVEEDOR']}</td>
              <td id="idProducto_${row['ID_DETALLE_PEDIDO']}" idproducto="${row['ID_PRODUCTO']}">${row['PRODUCTO']}</td>
              <td><input id="cantidadP${row['ID_DETALLE_PEDIDO']}" class="form-control" type="number" value="${row['CANTIDAD']}"></td>
              <td><span class="badge ${estadoClass}">${estadoBadge}</span></td>
            </tr>`;
          });

          html += `</tbody></table>`;
          $('#recibirProducto').attr('onclick', `recibido(${idPedido},${ estado})`);
          $('#contenido').html(html);
        } else {
          showAlert("Advertencia", "Proveedor sin productos o El stock mínimo está completo", "warning");
        }
      } catch (error) {
        console.error(error);
      }
    }).fail(function(xhr, status, error) {
      console.error(xhr.responseText);
    });
  }

  function recibido(idPedido, estado) {
    const productos = [];

    $("#TblDetalles tr").each(function() {
      const idDetallesP = $(this).find('td').eq(0).text();
      const cantidad = parseInt($(`#cantidadP${idDetallesP}`).val());
      const idProducto = parseInt($(`#idProducto_${idDetallesP}`).attr('idproducto'));

      productos.push({ idDetallesP, cantidad, idProducto });
    });

    $.post(URL_REGISTRAR_PEDIDO, { productos, idPedido, estado }, function(response) {
      try {
        const res = JSON.parse(response);
        const message = res === "Ok" ? "Stock actualizado" : "Error al actualizar el stock";
        const icon = res === "Ok" ? "success" : "error";

        showAlert(message, "", icon);

        if (res === "Ok") {
          setTimeout(() => {
            location.reload();
          }, 2000);
        }
      } catch (error) {
        console.error(error);
      }
    }).fail(function(xhr, status, error) {
      console.error(xhr.responseText);
    });
  }

  function btnEliminarPedidos(idPedido, estado) {
    $.post(URL_CANCELAR_PEDIDO, { idPedido, estado }, function(response) {
      try {
        const res = JSON.parse(response);
        const message = res === "Ok" ? "Pedido Cancelado" : "Error al cancelar";
        const icon = res === "Ok" ? "success" : "error";

        showAlert(message, "", icon);
        
        if (res === "Ok") {
          setTimeout(() => {
            location.reload();
          }, 2000);
        }
      } catch (error) {
        console.error(error);
      }
    }).fail(function(xhr, status, error) {
      console.error(xhr.responseText);
    });
  }
