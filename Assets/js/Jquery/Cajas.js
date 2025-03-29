console.log("LLEGUE A LAS CAJAS")
$(document).ready(function() {
  // ===========================================================
  // ========== TABLA DE CAJAS ==========
  // ===========================================================
  var TblCajas = $('#TblCajas').DataTable({
    ajax: {
      url: base_url + 'Cajas/listar',
      dataSrc : ""
    },
    columns: [
      {"data" : "ID_CAJA"},
      {"data" : "CAJA"},
      {"data" : "ESTADO"},
      {"data" : "FECHA_REGISTRO"},
      {"data" : "ACCIONES"}      
    ],
    language: {"url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"},
    order: [[ 0, "acs" ]],
    responsive: true
  });
});

// ===========================================================
// ========== METODOS DE CAJAS ==========
// ===========================================================

// ABRIR FORMULARIO
function frmCaja(){
  $('#my-modal-title-caja').html("Nueva Caja");
  $('#btnAccion').html("Agregar");
  $('#frmCajas')[0].reset();
  $('#nueva_caja').modal("show");
  $('#idCaja').val("");
}

// REGISTAR CAJA NUEVA
function registrarCaja(e){

  const url = base_url + "Cajas/regsitrar"; 

  const postData = {
    idCaja :$('#idCaja').val(),
    caja: $('#caja').val()
  };

  if(postData.caja == ""){
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Todos los campos son obligatorios",
      showConfirmButton: false,
      timer: 1500
    });
  }else{
    if(postData.idCaja == ""){ //REGISTAR CLIENTE
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
          $('#TblCajas').DataTable().ajax.reload();

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
            title: "Caja Editada Exitosamente",
            showConfirmButton: false,
            timer: 1500
          });
          // RECARGAMOS DATOS DE DATA TABLES AL REGISTRAR USUARIO
          $('#TblCajas').DataTable().ajax.reload();

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
    $('#nueva_caja').modal('hide');
  }
}

// ABRIR FORMULARIO EDITAR CAJA
function btnEditarCaja(id){
  $('#my-modal-title').html("Editar Caja");
  $('#btnAccion').html("Editar");

  const url = base_url + "Cajas/editar/" + id;  

  $.post(url, function (response){
    // console.log(response);
    res = JSON.parse(response);
    if(res != false){
      $('#idCaja').val(res.ID_CAJA);
      $('#caja').val(res.CAJA);

      $('#nueva_caja').modal("show");
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

// BTN PARA ELIMINAR CAJA
function btnEliminarCaja(id){
  // console.log(id);
  const url = base_url + "Cajas/eliminar/" + id; 
  
  Swal.fire({
    title: "Estas seguro?",
    text: "La caja se dara de baja del sistema.",
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
            text: "Caja dado de baja.",
            icon: "success",
            showConfirmButton: false,
            timer: 1500
          });
          // RECARGAMOS DATOS DE DATA TABLES AL REGISTRAR CLIENTE
          $('#TblCajas').DataTable().ajax.reload();
        }else{
          Swal.fire({
            title: "Eliminado",
            text: "Error al eliminar caja",
            icon: "error",
            showConfirmButton: false,
            timer: 1500
          });
        }
      });
    }
  });
}

// BTN PARA ACTIVAR CAJA
function btnActivarCaja(id){
  // console.log(id);
  const url = base_url + "Cajas/activar/" + id; 
 
  Swal.fire({
    title: "Estas seguro?",
    text: "La caja se activara en el sistema.",
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
            text: "Caja ha sido activado",
            icon: "success",
            showConfirmButton: false,
            timer: 1500
          });
          // RECARGAMOS DATOS DE DATA TABLES AL REGISTRAR CLIENTE
          $('#TblCajas').DataTable().ajax.reload();
        }else{
          Swal.fire({
            title: "Activar Caja",
            text: "Error al activar el caja",
            icon: "error",
            showConfirmButton: false,
            timer: 1500
          });
        }
      });
    }
  });
}