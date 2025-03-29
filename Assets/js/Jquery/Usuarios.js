$(document).ready(function() {

  var TblUsuarios = $('#TblUsuarios').DataTable({
    ajax: {
      url: base_url + 'Usuarios/listar',
      dataSrc : ""
    },
    columns: [
      {"data" : "ID_USUARIO"},
      {"data" : "USUARIO"},
      {"data" : "NOMBRECOMPLETO"},
      {"data" : "DESC_ROL"},
      {"data" : "CAJA"},
      {"data" : "ESTADO"},
      {"data" : "ACCIONES"}      
    ],
    language: {"url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"},
    order: [[ 0, "desc" ]],
    responsive: true
  });
});
// Función para registrar un nuevo usuario
function registrarUser  (e) {
  e.preventDefault();
  const url = base_url + "Usuarios/regsitrar";

  const postData = {
    id: $('#idUsuario').val(),
    usuario: $('#usuario').val(),
    nombre: $('#nombre').val(),
    appat: $('#appat').val(),
    apmat: $('#apmat').val(),
    clave: $('#clave').val(),
    confirmarClave: $('#confirmarClave').val(),
    caja: $('#caja').val(),
    rol: $('#rol').val()
  };

  // Validar campos
  if (!postData.usuario || !postData.nombre || !postData.appat || !postData.apmat || !postData.caja || !postData.rol) {
    sweetAlert('orange', 'warning', 'Todos los campos obligatorios');
    return;
  }

  if (postData.id === '') {
    // Registrar nuevo usuario
    if (postData.clave !== postData.confirmarClave) {
      sweetAlert('orange', 'warning', 'Las claves no coinciden');
      return;
    }

    $.ajax({
      type: 'POST',
      url: url,
      data: postData,
      success: function(response) {
        const res = JSON.parse(response);
        if (res['mensaje'] === 'Correcto') {
          sweetAlert('green', 'success', 'Usuario registrado exitosamente');
          // CERRAMOS MODAL
          $('#nuevo_usuario').modal('hide');
          // RECARGAMOS DATOS DE DATA TABLES AL REGISTRAR USUARIO
          $('#TblUsuarios').DataTable().ajax.reload();
        } else {
          sweetAlert('orange', 'error', res['error']);
        }
      },
      error: function(xhr, status, error) {
        sweetAlert('red', 'error', res['error']);
      }
    });
  } else {
    // Editar usuario existente
    $.ajax({
      type: 'POST',
      url: url,
      data: postData,
      success: function(response) {
        const res = JSON.parse(response);
        if (res['mensaje'] === 'Correcto') {
          sweetAlert('green', 'success', 'Usuario editado exitosamente');
          // CERRAMOS MODAL
          $('#nuevo_usuario').modal('hide');
          // RECARGAMOS DATOS DE DATA TABLES AL REGISTRAR USUARIO
          $('#TblUsuarios').DataTable().ajax.reload();
        } else {
          sweetAlert('orange', 'error', res['error']);
        }
      },
      error: function(xhr, status, error) {
        sweetAlert('red', 'error', res['error']);
      }
    });
  }
}
// Función para abrir formulario
function frmUsuario(){
  $('#my-modal-title').html("Registrar Nuevo Usuario");
  $('#claves').removeClass("d-none");
  $('#btnAccion').html("Agregar");
  $('#frmUsuarios')[0].reset();
  $('#nuevo_usuario').modal("show");
  $('#idUsuario').val("");
}
// Función para abrir formulario editar
function btnEditarUsario(id){
  $('#my-modal-title').html("Editar Usuario");
  $('#btnAccion').html("Editar");

  const url = base_url + "Usuarios/editar/" + id;  

  if(id != 1){
    $.post(url, function (response){
      // console.log(response);
      res = JSON.parse(response);
      if(res != "Error"){
        $('#idUsuario').val(res.ID_USUARIO);
        $('#usuario').val(res.USUARIO);
        $('#nombre').val(res.NOMBRE);
        $('#appat').val(res.AP_PAT);
        $('#apmat').val(res.AP_MAT);
        $('#caja').val(res.ID_CAJA);
        $('#rol').val(res.ID_ROL);
        $('#claves').addClass("d-none");
  
        $('#nuevo_usuario').modal("show");
      }else{
        sweetAlert('orange', 'warning', 'Error obteniendo datos');
      }
    });
  }
}
// Función para cambiar el estado de un usuario
function cambiarEstadoUsuario(id, estado) {
  const url = base_url + "Usuarios/cambiarEstado";

  Swal.fire({
    title: "Estas seguro?",
    text: estado === 0 ? "El usuario se desactivara" : "El usuario se activara",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, estoy seguro.",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: 'POST',
        url: url,
        data: {'idUsuario': id, 'estado': estado},
        success: function(response) {
          const res = JSON.parse(response);
          if (res === 'Ok') {
            sweetAlert(estado === 0 ? 'orange' : 'green', 'success', estado === 0 ? 'Usuario desactivado exitosamente' : 'Usuario activado exitosamente');
            // RECARGAMOS DATOS DE DATA TABLES AL REGISTRAR USUARIO
            $('#TblUsuarios').DataTable().ajax.reload();
          } else {
            sweetAlert('red', 'error', 'Error al cambiar el estado del usuario');
          }
        },
        error: function(xhr, status, error) {
          sweetAlert('red', 'error', 'Error en el servidor');
        }
      });
    }
  });
}
// Función para mostrar sweet alert
function sweetAlert(background, icon, title){
  let Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: false,
    background: background,
    color: '#fff',
    iconColor: '#fff',
    didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
    }
  });
  
  Toast.fire({
    icon: icon,
    title: title
  });
}