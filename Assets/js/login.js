function frmLogin(e) {
  e.preventDefault(); // Prevenir el envío del formulario por defecto

  const usuario = $('#usuario').val().trim();
  const clave = $('#clave').val().trim();
  let valid = true;
  
  if (usuario === "") { $('#usuario').addClass("is-invalid"); valid = false;
  } else { $('#usuario').removeClass("is-invalid"); }

  if (clave === "") { $('#clave').addClass("is-invalid"); valid = false;
  } else { $('#clave').removeClass("is-invalid"); }

  if (!valid) { return; } // Si hay errores, salir de la función

  const url = base_url + "Usuarios/validar";
  const postData = {
    usuario: usuario,
    clave: clave,
  };

  $.post(url, postData, function (response) {
    try {
      const ress = JSON.parse(response);
      console.log(ress['error']);
      if (ress['mensaje'] === "Correcto") {
        window.location = base_url + "Ventas";
      } else {
        sweetAlert('orange', 'success', ress['error']);
      }
    } catch (error) {
      console.error('Error al procesar la respuesta del servidor:', error);
      sweetAlert('orange', 'warning', 'Error en el servidor. Inténtelo de nuevo más tarde');
    }
  }).fail(function () {
    sweetAlert('red', 'error', 'Error de red. Por favor, revise su conexión');
  });
}

// Función para mostrar sweet alert
function sweetAlert(background, icon, title){
  let Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 1500,
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