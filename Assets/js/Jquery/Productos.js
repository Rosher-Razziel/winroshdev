console.log("LLEGUE A PRODUCTOS");

$(document).ready(function () {
  // =================== CONFIGURACIÓN COMÚN PARA LAS TABLAS ===================
  const tableConfig = {
    columns: [
      { data: "IMAGEN" },
      { data: "COD_BARRAS" },
      { data: "PRODUCTO" },
      { data: "PRECIO_COMPRA" },
      { data: "PRECIO_VENTA" },
      { data: "EXISTENCIA_MINIMA" },
      { data: "EXISTENCIAS" },
      { data: "PROV_CAT" },
      { data: "ACCIONES" },
    ],
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
    },
    order: [[2, "asc"]],
    responsive: true,
    fnRowCallback: function (nRow, aData) {
      const existencias = parseFloat(aData["EXISTENCIAS"]);
      const minExistencias = parseFloat(aData["EXISTENCIA_MINIMA"]);
      if (existencias < 0) {
        $("td", nRow).css("background-color", "#CA0000");
      } else if (existencias < minExistencias) {
        $("td", nRow).css("background-color", "#FFFF00");
      }
    },
  };

  // ========== TABLA DE PRODUCTOS ACTIVOS ==========
  $("#TblProductos").DataTable({
    ...tableConfig,
    ajax: { url: `${base_url}Productos/listar`, dataSrc: "" },
  });
});

// ABRIR FORMULARIO
function frmProducto() {
  $("#my-modal-title").html("Nuevo Producto");
  $("#btnAccion").html("Agregar");
  $("#frmProductos")[0].reset();
  $("#nuevo_producto").modal("show");
  $("#idProducto").val("");
  deleteImg();
}

// ENVIAR FORMULARIO
$("#frmProductos").on("submit", function (e) {
  const url = base_url + "Productos/registrar";
  const Form = new FormData($("#frmProductos")[0]);

  const postData = {
    idProducto: $("#idProducto").val(),
    cod_barras: $("#cod_barras").val(),
    nombre_producto: $("#nombre_producto").val(),
    precio_compra: $("#precio_compra").val(),
    existencia: $("#existencia").val(),
    precio_venta: $("#precio_venta").val(),
    existencia_minima: $("#existencia_minima").val(),
    proveedor: $("#proveedor").val(),
    categoria: $("#categoria").val(),
    medida: $("#medida").val(),
  };

  if (
    postData.cod_barras == "" ||
    postData.nombre_producto == "" ||
    postData.precio_compra == "" ||
    postData.existencia == "" ||
    postData.precio_venta == "" ||
    postData.existencia_minima == "" ||
    postData.proveedor == "" ||
    postData.categoria == "" ||
    postData.medida == ""
  ) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Todos los campos son obligatorios",
      showConfirmButton: false,
      timer: 1500,
    });
  } else {
    if (postData.idProducto == "") {
      $.ajax({
        type: "POST",
        url: url,
        data: Form,
        contentType: false,
        cache: false,
        processData: false,
        success: function (response) {
          console.log(response);
          ress = JSON.parse(response);
          if (ress === "Correcto") {
            Swal.fire({
              position: "center",
              icon: "success",
              title: "Producto registrado exitosamente",
              showConfirmButton: false,
              timer: 1500,
            });
            // RECARGAMOS DATOS DE DATA TABLES AL REGISTRAR PROVEEDORES
            $("#TblProductos").DataTable().ajax.reload();
          } else {
            Swal.fire({
              position: "center",
              icon: "warning",
              title: ress,
              showConfirmButton: false,
              timer: 1500,
            });
          }
        },
      });
    } else {
      $.ajax({
        type: "POST",
        url: url,
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        success: function (response) {
          // console.log(response);
          ress = JSON.parse(response);
          if (ress === "Correcto") {
            Swal.fire({
              position: "center",
              icon: "success",
              title: "Producto Editado Exitosamente",
              showConfirmButton: false,
              timer: 1500,
            });
            // RECARGAMOS DATOS DE DATA TABLES AL REGISTRAR PROVEEDORES
            $("#TblProductos").DataTable().ajax.reload();
          } else {
            Swal.fire({
              position: "center",
              icon: "warning",
              title: ress,
              showConfirmButton: false,
              timer: 1500,
            });
          }
        },
      });
    }
  }
  //CERRAMOS MODAL
  $("#nuevo_producto").modal("hide");
  e.preventDefault();
});

// ABRIR FORMULARIO EDITAR PRODUCTO
function btnEditarProducto(id) {
  $("#my-modal-title").html("Editar Proveedor");
  $("#btnAccion").html("Editar");

  const url = base_url + "Productos/editar/" + id;

  $.post(url, function (response) {
    // console.log(response);
    res = JSON.parse(response);
    if (res != false) {
      $("#idProducto").val(res.ID_PRODUCTO);
      $("#cod_barras").val(res.COD_BARRAS);
      $("#nombre_producto").val(res.PRODUCTO);
      $("#precio_compra").val(res.PRECIO_COMPRA);
      $("#existencia").val(res.EXISTENCIAS);
      $("#precio_venta").val(res.PRECIO_VENTA);
      $("#existencia_minima").val(res.EXISTENCIA_MINIMA);
      $("#proveedor").val(res.ID_PROV);
      $("#categoria").val(res.ID_CAT);
      $("#medida").val(res.ID_MED);
      // FOTO
      $("#icon_image").addClass("d-none");
      $("#img_preview").removeClass("d-none");
      $("#img_preview").attr("src", base_url + "Assets/img/" + res.FOTO);
      $("#icon_cerrar").html(
        `<button class="btn btn-danger mb-2" onclick="deleteImg()"><i class="fas fa-times"></i></button>`
      );

      $("#foto_actual").val(res.FOTO);

      $("#nuevo_producto").modal("show");
    } else {
      Swal.fire({
        title: "Error",
        text: "Error al mostrar datos.",
        icon: "error",
        showConfirmButton: false,
        timer: 1500,
      });
    }
  });
}

// BTN PARA ELIMINAR PRODUCTO
function btnEliminarProducto(id) {
  // console.log(id);
  const url = base_url + "Productos/eliminar/" + id;

  Swal.fire({
    title: "Estas seguro?",
    text: "El producto se dara de baja del sistema.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, estoy seguro.",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      $.post(url, function (response) {
        // console.log(response);
        res = JSON.parse(response);
        if (res === "Ok") {
          Swal.fire({
            title: "Eliminado",
            text: "Producto dado de baja.",
            icon: "success",
            showConfirmButton: false,
            timer: 1500,
          });
          // RECARGAMOS DATOS DE DATA TABLES AL REGISTRAR CLIENTE
          $("#TblProductos").DataTable().ajax.reload();
          $("#ProductosInactivos").DataTable().ajax.reload();
        } else {
          Swal.fire({
            title: "Eliminado",
            text: "Error al eliminar proveedor",
            icon: "error",
            showConfirmButton: false,
            timer: 1500,
          });
        }
      });
    }
  });
}

// BTN PARA ACTIVAR PRODUCTO
function btnActivarProducto(id) {
  // console.log(id);
  const url = base_url + "Productos/activar/" + id;

  Swal.fire({
    title: "Estas seguro?",
    text: "El producto se activara en el sistema.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, estoy seguro.",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      $.post(url, function (response) {
        // console.log(response);
        res = JSON.parse(response);
        if (res === "Ok") {
          Swal.fire({
            title: "Activar Proveedor",
            text: "Producto ha sido activado",
            icon: "success",
            showConfirmButton: false,
            timer: 1500,
          });
          // RECARGAMOS DATOS DE DATA TABLES AL REGISTRAR CLIENTE
          $("#TblProductos").DataTable().ajax.reload();
          $("#ProductosInactivos").DataTable().ajax.reload();
        } else {
          Swal.fire({
            title: "Activar Proveedor",
            text: "Error al activar el producto",
            icon: "error",
            showConfirmButton: false,
            timer: 1500,
          });
        }
      });
    }
  });
}

// FUNCINO PARA PREVISUALIZAR IMAGEN
function preview(e) {
  const url = e.target.files[0];
  const urlTmp = URL.createObjectURL(url);
  const imagefile = url.type;
  const match = ["image/jpeg", "image/png", "image/jpg"];

  if (
    !(imagefile == match[0] || imagefile == match[1] || imagefile == match[2])
  ) {
    Swal.fire({
      title: "Formato Incorrecto",
      text: "El formato es erroneo favor de cargar imagen con formago (JPEG/JPG/PNG).",
      icon: "warning",
      showConfirmButton: false,
      timer: 2000,
    });
    $("#imagen").val("");
    return false;
  } else {
    $("#img_preview").attr("src", urlTmp);
    $("#icon_image").addClass("d-none");
    $("#img_preview").removeClass("d-none");
    $("#icon_cerrar").html(
      `<button class="btn btn-danger mb-2" onclick="deleteImg()"><i class="fas fa-times"></i></button>`
    );
  }
}

function deleteImg() {
  $("#icon_cerrar").html("");
  $("#icon_image").removeClass("d-none");
  $("#img_preview").addClass("d-none");
  $("#img_preview").attr("src", "");
  $("#imagen").val("");
  $("#foto_actual").val("");
}

// CALCULAR PRECIO VENTA PRODUCTOS
function calcularPrecioVenta(e) {
  e.preventDefault();
  const precioCompra = parseFloat($("#precio_compra").val());

  if (isNaN(precioCompra) || precioCompra < 0) {
    return; // Si el precio de compra no es un número válido, salimos de la función
  }

  let precioVenta = calcularPrecio(precioCompra);
  precioVenta = redondearPrecio(precioVenta);

  $("#precio_venta").val(precioVenta.toFixed(2));
}

// Función auxiliar para calcular el precio de venta
function calcularPrecio(precioCompra) {
  if (precioCompra <= 6.99) {
    return precioCompra / 0.7;
  } else if (precioCompra <= 19.99) {
    return precioCompra + 4;
  } else if (precioCompra <= 29.99) {
    return precioCompra + 5;
  } else if (precioCompra <= 39.99) {
    return precioCompra + 6;
  } else if (precioCompra <= 69.99) {
    return precioCompra + 7;
  } else if (precioCompra <= 79.99) {
    return precioCompra + 11;
  } else {
    return precioCompra / 0.85;
  }
}

// Función auxiliar para redondear el precio
function redondearPrecio(precio) {
  const precioDecimal = precio - Math.floor(precio);
  if (precioDecimal > 0 && precioDecimal < 0.5) {
    return Math.floor(precio) + 0.5;
  } else {
    return Math.ceil(precio);
  }
}
