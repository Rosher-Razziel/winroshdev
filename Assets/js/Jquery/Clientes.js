console.log("LLEGUE A LOS CLIENTES")
$(document).ready(function() {
  // ===========================================================
  // ========== TABLA DE CLIENTES ==========
  // ===========================================================
  var TblClientes = $('#TblClientes').DataTable({
    ajax: {
      url: base_url + 'Clientes/listar',
      dataSrc : ""
    },
    columns: [
      {"data" : "ESTADO"},
      {"data" : "NOMBRECOMPLETO"},
      {"data" : "NUMERO_TELEFONICO"},
      {"data" : "CORREO"},
      {"data" : "LIMITE_CREDITO"},
      {"data" : "ACCIONES"}      
    ],
    language: {"url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"},
    order: [[ 1, "acs" ]],
    responsive: true
  });
});

// ===========================================================
// ========== METODOS DE CLIENTES ==========
// ===========================================================

// ABRIR FORMULARIO
function frmCliente(){
  $('#my-modal-title').html("Nuevo Cliente");
  $('#btnAccion').html("Agregar");
  $('#frmClientes')[0].reset();
  $('#nuevo_cliente').modal("show");
  $('#idCliente').val("");
}

// REGISTAR USUARIO NUEVO
function registrarCliente(e){

  const url = base_url + "Clientes/regsitrar"; 

  const postData = {
    idCliente :$('#idCliente').val(),
    nombre: $('#nombre').val(),
    appat: $('#appat').val(),
    apmat: $('#apmat').val(),
    num_tel: $('#num_tel').val(),
    correo: $('#correo').val(),
    lim_cred: $('#lim_cred').val()
  };

  if(postData.nombre == "" || postData.appat == "" || postData.apmat == "" || postData.num_tel == "" || postData.correo == "" || postData.lim_cred == ""){
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Todos los campos son obligatorios",
      showConfirmButton: false,
      timer: 1500
    });
  }else{
    if(postData.idCliente == ""){ //REGISTAR CLIENTE
      $.post(url, postData, function (response){
        // console.log(response);
        ress = JSON.parse(response);
        if (ress === "Correcto") {
          Swal.fire({
            position: "center",
            icon: "success",
            title: "Cliente registrado exitosamente",
            showConfirmButton: false,
            timer: 1500
          });
          // RECARGAMOS DATOS DE DATA TABLES AL REGISTRAR USUARIO
          $('#TblClientes').DataTable().ajax.reload();

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
    }else{ //EDITAR CLIENTE
      $.post(url, postData, function (response){
        // console.log(response);
        ress = JSON.parse(response);
        if (ress === "Correcto") {
          Swal.fire({
            position: "center",
            icon: "success",
            title: "Usuario Editado Exitosamente",
            showConfirmButton: false,
            timer: 1500
          });
          // RECARGAMOS DATOS DE DATA TABLES AL REGISTRAR USUARIO
          $('#TblClientes').DataTable().ajax.reload();

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
    $('#nuevo_cliente').modal('hide');
  }
}

// ABRIR FORMULARIO EDITAR
function btnEditarCliente(id){
  $('#my-modal-title').html("Editar Usuario");
  $('#btnAccion').html("Editar");

  const url = base_url + "Clientes/editar/" + id;  

  $.post(url, function (response){
    // console.log(response);
    res = JSON.parse(response);
    if(res != false){
      $('#idCliente').val(res.ID_CLIENTE);
      $('#nombre').val(res.NOMBRE);
      $('#appat').val(res.APPAT);
      $('#apmat').val(res.APMAT);
      $('#num_tel').val(res.NUMERO_TELEFONICO);
      $('#correo').val(res.CORREO);
      $('#lim_cred').val(res.LIMITE_CREDITO);

      $('#nuevo_cliente').modal("show");
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

// BTN PARA ELIMINAR USUARIO
function btnEliminarCliente(id){
  // console.log(id);
  const url = base_url + "Clientes/eliminar/" + id; 
  
  Swal.fire({
    title: "Estas seguro?",
    text: "El cliente se dara de baja del sistema.",
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
            text: "Cliente dado de baja.",
            icon: "success",
            showConfirmButton: false,
            timer: 1500
          });
          // RECARGAMOS DATOS DE DATA TABLES AL REGISTRAR CLIENTE
          $('#TblClientes').DataTable().ajax.reload();
        }else{
          Swal.fire({
            title: "Eliminado",
            text: "Error al eliminar Usuario",
            icon: "error",
            showConfirmButton: false,
            timer: 1500
          });
        }
      });
    }
  });
}

// BTN PARA ACTIVAR USUARIO
function btnActivarCliente(id){
  // console.log(id);
  const url = base_url + "Clientes/activar/" + id; 
 
  Swal.fire({
    title: "Estas seguro?",
    text: "El cliente se activara en el sistema.",
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
            title: "Activar Cliente",
            text: "Cliente ha sido activado",
            icon: "success",
            showConfirmButton: false,
            timer: 1500
          });
          // RECARGAMOS DATOS DE DATA TABLES AL REGISTRAR CLIENTE
          $('#TblClientes').DataTable().ajax.reload();
        }else{
          Swal.fire({
            title: "Activar Cliente",
            text: "Error al activar el cliente",
            icon: "error",
            showConfirmButton: false,
            timer: 1500
          });
        }
      });
    }
  });
}