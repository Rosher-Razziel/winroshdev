$(document).ready(function() {
  // Inicializar DataTable de Proveedores
  var TblProveedor = $('#TblProveedor').DataTable({
    ajax: {
      url: `${base_url}Proveedores/listar`,
      dataSrc: ""
    },
    columns: [
      { data: "ID_PROVEEDOR" },
      { data: "DES_PROVEEDOR" },
      { data: "DIA_VISITA" },
      { data: "NOMBRECOMPLETO" },
      { data: "CORREO" },
      { data: "NUMERO_TELEFONO" },
      { data: "ESTADO" },
      { data: "ACCIONES" }
    ],
    language: { url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json" },
    order: [[0, "asc"]],
    responsive: true
  });
});

// Abrir formulario para nuevo proveedor
function frmProveedor() {
  $('#my-modal-title').text("Nuevo Proveedor");
  $('#btnAccion').text("Agregar");
  $('#frmProveedor')[0].reset();
  $('#idProveedor').val("");
  $('#nuevo_proveedor').modal("show");
}

// REGISTRAR CATEGORIA NUEVA
function registrarProveedor() {
  const url = base_url + "Proveedores/registrar";

  const postData = {
    idProveedor: $('#idProveedor').val(),
    desc_proveedor: $('#desc_proveedor').val(),
    dia_visita: $('#dia_visita').val(),
    nombre_proveedor: $('#nombre_proveedor').val(),
    appat: $('#appat').val(),
    apmat: $('#apmat').val(),
    correo: $('#correo').val(),
    num_tel: $('#num_tel').val(),
  };

  const requiredFields = ['desc_proveedor', 'dia_visita', 'nombre_proveedor', 'appat', 'apmat', 'correo', 'num_tel'];
  // Verificar si todos los campos requeridos están llenos
  const allFieldsFilled = requiredFields.every(field => postData[field] !== "");

  if (!allFieldsFilled) {
    showAlert("Error", "Todos los campos son obligatorios", "error");
    return; // Salir de la función si hay campos vacíos
  }
  // Definir el mensaje de éxito y el título según si se está registrando o editando
  const actionType = postData.idProveedor === "" ? "registrar" : "editar";
  const successMessage = actionType === "registrar" ? "Proveedor registrado exitosamente" : "Proveedor editado exitosamente";
  
  // Realizar la solicitud POST
  $.post(url, postData, function (response) {
    const ress = JSON.parse(response);
    showAlert(actionType === "registrar" ? "Registrar":  "Editar", ress === "Correcto" ? successMessage : "Error intente de nuevo", ress === "Correcto" ? "success" : "error");

    // Recargar los datos de DataTables al registrar o editar proveedores
    if (ress === "Correcto") {
      $('#TblProveedor').DataTable().ajax.reload();
    }
  });

  // Cerrar modal
  $('#nuevo_proveedor').modal('hide');
}

// ABRIR FORMULARIO EDITAR PROVEEDOR
function btnEditarProveedor(id) {
  $('#my-modal-title').text("Editar Proveedor");
  $('#btnAccion').text("Editar");

  const url = `${base_url}Proveedores/editar/${id}`;

  $.post(url, function (response) {
    try {
      const res = JSON.parse(response);

      if (res) {
        $('#idProveedor').val(res.ID_PROVEEDOR);
        $('#desc_proveedor').val(res.DES_PROVEEDOR);
        $('#dia_visita').val(res.DIA_VISITA);
        $('#nombre_proveedor').val(res.NOMBRE);
        $('#appat').val(res.APPAT);
        $('#apmat').val(res.APMAT);
        $('#correo').val(res.CORREO);
        $('#num_tel').val(res.NUMERO_TELEFONO);

        $('#nuevo_proveedor').modal("show");
      } else {
        showAlert("Error", "Error al mostrar datos.", "error");
      }
    } catch (error) {
      showAlert("Error", "Respuesta inválida del servidor.", "error");
      console.error("Error al procesar la respuesta:", error);
    }
  }).fail(function () {
    showAlert("Error", "No se pudo realizar la solicitud.", "error");
  });
}

// BTN PARA ELIMINAR PROVEEDOR
function btnEliminarProveedor(id) {
  const url = `${base_url}Proveedores/eliminar/${id}`;

  Swal.fire({
    title: "¿Estás seguro?",
    text: "El proveedor se dará de baja del sistema.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí, estoy seguro.",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      $.post(url, function (response) {
        try {
          const res = JSON.parse(response);

          if (res === "Correcto") {
            showAlert("Eliminado", "Proveedor dado de baja.", "success");
            // Recargamos los datos de DataTables tras eliminar el proveedor
            $('#TblProveedor').DataTable().ajax.reload();
          } else {
            showAlert("Error", "Error al eliminar proveedor.", "error");
          }
        } catch (error) {
          showAlert("Error", "Respuesta inválida del servidor.", "error");
          console.error("Error al procesar la respuesta:", error);
        }
      }).fail(function () {
        showAlert("Error", "No se pudo realizar la solicitud.", "error");
      });
    }
  });
}

// BTN PARA ACTIVAR PROVEEDOR
function btnActivarProveedor(id) {
  const url = `${base_url}Proveedores/activar/${id}`;

  Swal.fire({
    title: "¿Estás seguro?",
    text: "El proveedor se activará en el sistema.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí, estoy seguro.",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      $.post(url, function (response) {
        try {
          const res = JSON.parse(response);

          if (res === "Correcto") {
            showAlert("Activado", "Proveedor ha sido activado.", "success");
            // Recargamos los datos de DataTables tras activar el proveedor
            $('#TblProveedor').DataTable().ajax.reload();
          } else {
            showAlert("Error", "Error al activar el proveedor.", "error");
          }
        } catch (error) {
          showAlert("Error", "Respuesta inválida del servidor.", "error");
          console.error("Error al procesar la respuesta:", error);
        }
      }).fail(function () {
        showAlert("Error", "No se pudo realizar la solicitud.", "error");
      });
    }
  });
}

// Función auxiliar para mostrar alertas
function showAlert(title, text, icon) {
  Swal.fire({
    title: title,
    text: text,
    icon: icon,
    showConfirmButton: false,
    timer: 1500
  });
}