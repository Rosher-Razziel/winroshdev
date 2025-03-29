console.log("LLEGUE A LOS ROLES")
$(document).ready(function() {
  // ===========================================================
  // ========== TABLA DE ROLES ==========
  // ===========================================================
  var TblRoles = $('#TblRoles').DataTable({
    ajax: {
      url: base_url + 'Roles/listar',
      dataSrc : ""
    },
    columns: [
      // {"data" : "ID_PRODUCTO"},
      {"data" : "ID_ROL"},
      {"data" : "DESC_ROL"},
      {"data" : "ESTADO"},
      {"data" : "FECHA_REGISTRO"},
      {"data" : "ACCIONES"}    
    ],
    language: {"url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"},
    order: [[0, "asc" ]],
    responsive: true
  });
});

// ===========================================================
// ========== METODOS DE ROLES ==========
// ===========================================================

// ABRIR FORMULARIO
function frmRoles(){
  $('#my-modal-title').html("Nuevo Rol");
  $('#btnAccion').html("Agregar");
  $('#frmRoles')[0].reset();
  $('#nuevo_rol').modal("show");
  $('#idRol').val("");
}

// REGISTAR ROL NUEVO
function registrarRoles(e){

  const url = base_url + "Roles/registrar"; 

  const postData = {
    idRol :$('#idRol').val(),
    rol: $('#rol').val()  
  };

  if(postData.rol == ""){
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Todos los campos son obligatorios",
      showConfirmButton: false,
      timer: 1500
    });
  }else{
    if(postData.idRol == ""){ //REGISTAR ROLES
      $.post(url, postData, function (response){
        // console.log(response);
        ress = JSON.parse(response);
        if (ress === "Correcto") {
          Swal.fire({
            position: "center",
            icon: "success",
            title: "Categoria registrado exitosamente",
            showConfirmButton: false,
            timer: 1500
          });
          // RECARGAMOS DATOS DE DATA TABLES AL REGISTRAR USUARIO
          $('#TblRoles').DataTable().ajax.reload();

        }else{
          Swal.fire({
            position: "center",
            icon: "warning",
            title: ress,
            showConfirmButton: false,
            timer: 1500
          });
        }
      });
    }else{ //EDITAR ROLES
      $.post(url, postData, function (response){
        // console.log(response);
        ress = JSON.parse(response);
        if (ress === "Correcto") {
          Swal.fire({
            position: "center",
            icon: "success",
            title: "Categoria Editada Exitosamente",
            showConfirmButton: false,
            timer: 1500
          });
          // RECARGAMOS DATOS DE DATA TABLES AL REGISTRAR USUARIO
          $('#TblRoles').DataTable().ajax.reload();

        }else{
          Swal.fire({
            position: "center",
            icon: "warning",
            title: ress,
            showConfirmButton: false,
            timer: 1500
          });
        }
      });
    }
    // CERRAMOS MODAL
    $('#nuevo_rol').modal('hide');
  }
}

// ABRIR FORMULARIO EDITAR ROL
function btnEditarRoles(id){
  $('#my-modal-title').html("Editar Roles");
  $('#btnAccion').html("Editar");

  const url = base_url + "Roles/editar/" + id;  

  $.post(url, function (response){
    // console.log(response);
    res = JSON.parse(response);
    if(res != false){
      $('#idRol').val(res.ID_ROL);
      $('#rol').val(res.DESC_ROL);

      $('#nuevo_rol').modal("show");
    }else{
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

// BTN PARA ELIMINAR ROL
function btnEliminarRoles(id){
  // console.log(id);
  const url = base_url + "Roles/eliminar/" + id; 
  
  Swal.fire({
    title: "Estas seguro?",
    text: "El rol se dara de baja del sistema.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, estoy seguro.",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      $.post(url, function (response){
        // console.log(response);
        res = JSON.parse(response);
        if (res === "Ok") {
          Swal.fire({
            title: "Eliminado",
            text: "Rol dado de baja.",
            icon: "success",
            showConfirmButton: false,
            timer: 1500
          });
          // RECARGAMOS DATOS DE DATA TABLES AL REGISTRAR CLIENTE
          $('#TblRoles').DataTable().ajax.reload();
        }else{
          Swal.fire({
            title: "Eliminado",
            text: "Error al eliminar rol",
            icon: "error",
            showConfirmButton: false,
            timer: 1500
          });
        }
      });
    }
  });
}

// BTN PARA ACTIVAR ROL
function btnActivarRoles(id){
  // console.log(id);
  const url = base_url + "Roles/activar/" + id; 
 
  Swal.fire({
    title: "Estas seguro?",
    text: "El rol se activara en el sistema.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, estoy seguro.",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      $.post(url, function (response){
        // console.log(response);
        res = JSON.parse(response);
        if (res === "Ok") {
          Swal.fire({
            title: "Activar Caja",
            text: "Rol ha sido activado",
            icon: "success",
            showConfirmButton: false,
            timer: 1500
          });
          // RECARGAMOS DATOS DE DATA TABLES AL REGISTRAR CLIENTE
          $('#TblRoles').DataTable().ajax.reload();
        }else{
          Swal.fire({
            title: "Activar Caja",
            text: "Error al activar el rol",
            icon: "error",
            showConfirmButton: false,
            timer: 1500
          });
        }
      });
    }
  });
}