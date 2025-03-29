console.log("LLEGUE A LAS MEDIDAS")
$(document).ready(function() {
  // ===========================================================
  // ========== TABLA DE MEDIDAS ==========
  // ===========================================================
  var TblMedidas = $('#TblMedidas').DataTable({
    ajax: {
      url: base_url + 'Medidas/listar',
      dataSrc : ""
    },
    columns: [
      {"data" : "ID_MEDIDA"},
      {"data" : "MEDIDA"},
      {"data" : "NOMBRE_CORTO"},
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
// ========== METODOS DE MEDIDAS ==========
// ===========================================================

// ABRIR FORMULARIO
function frmMedida(){
  $('#my-modal-title').html("Nueva Medida");
  $('#btnAccion').html("Agregar");
  $('#frmMedidas')[0].reset();
  $('#nueva_medida').modal("show");
  $('#idMedida').val("");
}

// REGISTAR CAJA NUEVA
function registrarMedida(e){

  const url = base_url + "Medidas/registrar"; 

  const postData = {
    idMedida :$('#idMedida').val(),
    medida_prod: $('#medida_prod').val(),
    medida_corto: $('#medida_corto').val()
  };

  // console.log(postData);

  if(postData.medida_prod == "" || postData.medida_corto == ""){
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Todos los campos son obligatorios",
      showConfirmButton: false,
      timer: 1500
    });
  }else{
    if(postData.idMedida == ""){ //REGISTAR CLIENTE
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
          $('#TblMedidas').DataTable().ajax.reload();

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
          $('#TblMedidas').DataTable().ajax.reload();

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
    $('#nueva_medida').modal('hide');
  }
}

// ABRIR FORMULARIO EDITAR CAJA
function btnEditarMedida(id){
  $('#my-modal-title').html("Editar Medida");
  $('#btnAccion').html("Editar");

  const url = base_url + "Medidas/editar/" + id;  

  $.post(url, function (response){
    // console.log(response);
    res = JSON.parse(response);
    if(res != false){
      $('#idMedida').val(res.ID_MEDIDA);
      $('#medida_prod').val(res.MEDIDA);
      $('#medida_corto').val(res.NOMBRE_CORTO);

      $('#nueva_medida').modal("show");
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
function btnEliminarMedida(id){
  // console.log(id);
  const url = base_url + "Medidas/eliminar/" + id; 
  
  Swal.fire({
    title: "Estas seguro?",
    text: "La medida se dara de baja del sistema.",
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
            text: "Medida dado de baja.",
            icon: "success",
            showConfirmButton: false,
            timer: 1500
          });
          // RECARGAMOS DATOS DE DATA TABLES AL REGISTRAR CLIENTE
          $('#TblMedidas').DataTable().ajax.reload();
        }else{
          Swal.fire({
            title: "Eliminado",
            text: "Error al eliminar medida",
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
function btnActivarMedida(id){
  // console.log(id);
  const url = base_url + "Medidas/activar/" + id; 
 
  Swal.fire({
    title: "Estas seguro?",
    text: "La medida se activara en el sistema.",
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
            text: "Medida ha sido activado",
            icon: "success",
            showConfirmButton: false,
            timer: 1500
          });
          // RECARGAMOS DATOS DE DATA TABLES AL REGISTRAR CLIENTE
          $('#TblMedidas').DataTable().ajax.reload();
        }else{
          Swal.fire({
            title: "Activar Caja",
            text: "Error al activar el Medida",
            icon: "error",
            showConfirmButton: false,
            timer: 1500
          });
        }
      });
    }
  });
}
