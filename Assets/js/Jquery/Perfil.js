console.log("LLEGUE A LOS PERFILES");

// ABRIR FORMULARIO
function frmContraseña(){
  $('#frmContraseña')[0].reset();
  $('#nueva_contraseña').modal("show"); 

}

function btnEditarClave (){

  let idUsuario = $('#idUsuario').val();

   const url = base_url + "Perfil/editarClave/" + idUsuario;  

   const postData = {
    clave: $('#clave').val(),
    newclave: $('#newclave').val(),
    confirmarClave: $('#confirmarClave').val()
  };

  if(postData.calve == "" || postData.newclave== "" || postData.confirmarClave == "" ){
    Swal.fire({
      position: "center",
      icon: "error",
      title: "Todos los campos son obligatorios",
      showConfirmButton: false,
      timer: 1500
    });
  }else{
    if(idUsuario != ""){
      $.post(url, postData, function (response){
        // console.log(response);
        //MENSAJES DE LAERTAS
        Swal.fire({
          position: "center",
          icon: "alert",
          title: response,
          showConfirmButton: false,
          timer: 1500
        });
      });
    }else{
      Swal.fire({
        position: "center",
        icon: "error",
        title: "El Usuario que quiere editar no cuenta con ID.",
        showConfirmButton: false,
        timer: 1500
      });
    }
  }
}
