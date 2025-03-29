$(document).ready(function() {
  // TABLA DE CATEGORIAS 
  const TblCategorias = $('#TblCategorias').DataTable({
    ajax: {
      url: `${base_url}Categorias/listar`,
      dataSrc: ""
    },
    columns: [
      { "data": "ID_CATEGORIA" },
      { "data": "DES_CATEGORIA" },
      { "data": "ESTADO" },
      { "data": "FECHA_REGISTRO" },
      { "data": "ACCIONES" }
    ],
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
    },
    order: [[0, "asc"]],
    responsive: true
  });
});

// ABRIR FORMULARIO
function frmCategoria() {
  resetForm("Nueva Categoría", "Agregar");
}

// REGISTRAR CATEGORÍA NUEVA
function registrarCategoria() {
  const url = `${base_url}Categorias/registrar`;
  const postData = {
    idCategoria: $('#idCategoria').val(),
    categoria: $('#categoria').val()
  };

  if (!postData.categoria) {
    showAlert("warning", "Todos los campos son obligatorios");
  } else {
    const isEdit = !!postData.idCategoria;
    $.post(url, postData, function(response) {
      handlePostResponse(response, isEdit ? "Categoria Editada Exitosamente" : "Categoria registrada exitosamente");
    });
  }
}

// ABRIR FORMULARIO EDITAR CATEGORÍA
function btnEditarCategoria(id) {
  resetForm("Editar Categoría", "Editar");
  const url = `${base_url}Categorias/editar/${id}`;
  $.post(url, function(response) {
    const res = JSON.parse(response);
    if (res) {
      $('#idCategoria').val(res.ID_CATEGORIA);
      $('#categoria').val(res.DES_CATEGORIA);
      $('#nueva_categoria').modal("show");
    } else {
      showAlert("error", "Error al mostrar datos.");
    }
  });
}

// BTN PARA ELIMINAR CATEGORÍA
function btnEliminarCategoria(id) {
  const url = `${base_url}Categorias/eliminar/${id}`;
  showConfirmAlert("¿Estás seguro?", "La categoría se dará de baja del sistema.", "warning")
    .then((result) => {
      if (result.isConfirmed) {
        $.post(url, function(response) {
          handlePostResponse(response, "Categoría dada de baja.");
        });
      }
    });
}

// BTN PARA ACTIVAR CATEGORÍA
function btnActivarCategoria(id) {
  const url = `${base_url}Categorias/activar/${id}`;
  showConfirmAlert("¿Estás seguro?", "La categoría se activará en el sistema.", "warning")
    .then((result) => {
      if (result.isConfirmed) {
        $.post(url, function(response) {
          handlePostResponse(response, "Categoría activada.");
        });
      }
    });
}

// FUNCIONES AUXILIARES
function resetForm(title, buttonText) {
  $('#my-modal-title').html(title);
  $('#btnAccion').html(buttonText);
  $('#frmCategoria')[0].reset();
  $('#idCategoria').val("");
  $('#nueva_categoria').modal("show");
}

function showAlert(icon, title) {
  Swal.fire({
    position: "center",
    icon,
    title,
    showConfirmButton: false,
    timer: 1500
  });
}

function handlePostResponse(response, successMessage) {
  const res = JSON.parse(response);
  if (res === "Correcto") {
    showAlert("success", successMessage);
    $('#TblCategorias').DataTable().ajax.reload();
  } else {
    if (res === "Existe") {
      showAlert("warning", "La categoria ya existe");
    }else{
      showAlert("error", "Error al registrar");
    }
  }
  $('#nueva_categoria').modal('hide');
}

function showConfirmAlert(title, text, icon) {
  return Swal.fire({
    title,
    text,
    icon,
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí, estoy seguro.",
    cancelButtonText: "Cancelar"
  });
}
