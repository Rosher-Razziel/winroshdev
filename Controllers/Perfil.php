<?php

  class Perfil extends Controller{
    public function __construct(){
      session_start();
      if (empty($_SESSION['activo'])) {
        header('location: ' . base_url);
      }
      parent::__construct();
    }
    // FUNCION PRINCIPAL
    public function index(){
      if (empty($_SESSION['activo'])) {
        header('location: ' . base_url);
      }
      
      $data['datosUsuarios'] = $this->model->getUser($_SESSION['Id_usuario']);
      $this->views->getView($this, "index", $data);
    }

  //EDUTAR LA CLAVE DEL USUARIO
  public function editarClave(int $idUsuario){ 
  
    $clave = $_POST['clave'];
    $newclave = $_POST['newclave'];
    $hash = hash("SHA256", $newclave);
    $hash2 = hash("SHA256", $clave);
    $confirmarClave = $_POST['confirmarClave'];

    $data = $this->model->getClave($idUsuario);
      
    if ($data['CLAVE'] == $hash2) {
          
      if (empty($_POST['clave']) || empty($_POST['newclave']) || empty($_POST['confirmarClave'])) {
        $msg = "Los campos estan vacios";
      }else{
        if($idUsuario != ""){
          if($newclave == $confirmarClave){

            $data = $this->model->modificarClave($hash, $idUsuario);
  
            if ($data == "Ok") {
              $msg = "Cotraseña Actualizada";
            }else{
              $msg = "Error al editar al clave";
            }

          }else{
            $msg = "Las claves no coinciden";
          }
        }
      }
    }else{
      $msg = "La contraseña es incorerecta";
    }
    echo json_encode($msg, JSON_UNESCAPED_UNICODE);
    die();
  }
}

?>