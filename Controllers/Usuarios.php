<?php

  class Usuarios extends Controller{
    const MSG_CAMPOS_VACIOS = 'Los campos estan vacios';
    const MSG_CLAVES_NO_COINCIDEN = 'Las claves no coinciden';
    const MSG_USUARIO_YA_EXISTE = 'El usuario ya existe';
    const MSG_ERROR_REGISTRAR_USUARIO = 'Error registrando al usuario';
    const MSG_ERROR_EDITAR_USUARIO = 'Error al editar al usuario';
    const MSG_ERROR_SERVIDOR = 'Error en el servidor intente mas tarde';
    protected $model;
    // FUNCCIONES CONTRUCTOR
    public function __construct(){
      // Iniciar sesión solo si no ha sido iniciada
      if (session_status() == PHP_SESSION_NONE) {
        session_start();
      }
      parent::__construct();
    }
    // FUNCION INDEX 
    public function index(){

      if (empty($_SESSION['activo'])) {
        header('location: ' . base_url);
        exit;
      }
      $data = $this->model->getData();
      $this->views->getView($this, "index", $data);
    }
    // FUNCION PARA LISTAR USUARIOS
    public function listar(){
      $data = $this->model->getUsuarios();

      for ($i=0; $i < count($data); $i++) { 
        if ($data[$i]['ESTADO'] == 1) {
          $data[$i]['ESTADO'] = '<span class="badge btn-success">Activo</span>';
          $btnEliminarEstado = "";
          $btnActivarEstado = "disabled";     
        }else{
          $data[$i]['ESTADO'] = '<span class="badge btn-danger">Inactivo</span>';         
          $btnEliminarEstado = "disabled";      
          $btnActivarEstado = "";      
        }

       if($data[$i]['ID_USUARIO'] != 1){
          $data[$i]['ACCIONES'] =  '<div>
          <button class="btn btn-dark mb-2" type="button" onclick="btnPermisosUsuario('.$data[$i]['ID_USUARIO'].');"><i class="fa-solid fa-key"></i></button>
          <button class="btn btn-primary mb-2" type="button" onclick="btnEditarUsario('.$data[$i]['ID_USUARIO'].');"><i class="fa-solid fa-pen-to-square"></i></button>
          <button class="btn btn-danger mb-2"'.$btnEliminarEstado.' type="button" onclick="cambiarEstadoUsuario('.$data[$i]['ID_USUARIO'].', 0);"><i class="fa-solid fa-trash"></i></button>
          <button class="btn btn-success mb-2" '.$btnActivarEstado.' type="button" onclick="cambiarEstadoUsuario('.$data[$i]['ID_USUARIO'].', 1);"><i class="fa-solid fa-circle-check"></i></button>
          </div>';
        }else{
          $data[$i]['ACCIONES'] = '<span class="badge btn-warning">Usuario Administrador</span>';
        }

        $data[$i]['NOMBRECOMPLETO'] = $data[$i]['NOMBRE'] . ' ' . $data[$i]['AP_PAT'] . ' ' . $data[$i]['AP_MAT'];

      }

      echo json_encode($data, JSON_UNESCAPED_UNICODE);
      die();
    }
    // FUNCION VALIDAR USUARIO
    public function validar(){

      if (empty($_POST['usuario']) || empty($_POST['clave'])) {
        $msg = ['error' => MSG_CAMPOS_VACIOS];
      }else{
        $usuario = $_POST['usuario'];
        $clave = $_POST['clave'];

        $data = $this->model->getUsuario($usuario);
        
        if (password_verify($clave, $data['CLAVE'])) {
          $_SESSION['Id_usuario'] = $data['ID_USUARIO'];
          $_SESSION['Usuario'] = $data['USUARIO'];
          $_SESSION['Nombre'] = $data['NOMBRE'] . " " . $data['AP_PAT'] . " " . $data['AP_MAT'];
          $_SESSION['Id_rol'] = $data['ID_ROL'];
          $_SESSION['activo'] = true;

          $msg = ['mensaje' => 'Correcto'];

        }else{
          $msg = ['error' => "Usuario o clave incorrectos"];
        }
      }    
      echo json_encode($msg, JSON_UNESCAPED_UNICODE);
      die();
    }
    // FUNCION PARA REGISTRAR USUARIOS
    public function regsitrar(){
      // Obtener los datos del usuario
      $idUsuario = $_POST['id'];
      $usuario = filter_var($_POST['usuario'], FILTER_SANITIZE_STRING);
      $nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
      $appat = filter_var($_POST['appat'], FILTER_SANITIZE_STRING);
      $apmat = filter_var($_POST['apmat'], FILTER_SANITIZE_STRING);
      $clave = filter_var($_POST['clave'], FILTER_SANITIZE_STRING);
      $confirmarClave = filter_var($_POST['confirmarClave'], FILTER_SANITIZE_STRING);
      $caja = filter_var($_POST['caja'], FILTER_SANITIZE_STRING);
      $rol = filter_var($_POST['rol'], FILTER_SANITIZE_STRING);

      if (empty($usuario) || empty($nombre) || empty($appat) || empty($apmat) || empty($caja) || empty($rol)) {
        $respuesta = ['error' => MSG_CAMPOS_VACIOS];
      }else{
        if($idUsuario == ""){

          if($clave != $confirmarClave){
            $respuesta = ['error' => MSG_CLAVES_NO_COINCIDEN];
          }else{
            $hash = password_hash($clave, PASSWORD_BCRYPT);
            try {
              $data = $this->model->registrarUsuario($usuario, $nombre, $appat, $apmat, $hash, $rol, $caja);
              $respuesta = $data == 'Ok' ? ['mensaje' => 'Correcto'] : ($data == 'Existe' ? ['error' => MSG_USUARIO_YA_EXISTE] : ['error' => MSG_ERROR_REGISTRAR_USUARIO]);
          } catch (Exception $e) {
              $respuesta = ['error' => MSG_ERROR_SERVIDOR];
          }
          }
        }else{
          try {
            $data = $this->model->modificarUsuario($usuario, $nombre, $appat, $apmat, $rol, $caja, $idUsuario);
            $respuesta = $data == 'Ok' ? ['mensaje' => 'Correcto'] : ['error' => MSG_ERROR_EDITAR_USUARIO];
          } catch (Exception $e) {
            $respuesta = ['error' => MSG_ERROR_SERVIDOR];
          }
        }
        
      }    
      echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
      die();
    }
    // FUNCION PARA EDITAR USUARIOS
    public function editar(int $id){ 
      $data = $this->model->editarUser($id);
      echo json_encode($data, JSON_UNESCAPED_UNICODE);
      die();
    }
    // FUNCION PARA CAMBIAR EL ESTADO DE UN USUARIO
    public function cambiarEstado(){ 
      $idUsuario = $_POST['idUsuario'];
      $estado = $_POST['estado'];
      $data = $this->model->cambiarEstadoUser($idUsuario, $estado);
      echo json_encode($data, JSON_UNESCAPED_UNICODE);
      die();
    }
    // FUNCION PARA PERMISOS USUARIOS
    public function permisos(int $id){ 
      $data = $this->model->permisosUser($id);
      echo json_encode($data, JSON_UNESCAPED_UNICODE);
      die();
    }
    // FUNCION PARA SALIR DEL SISTEMA
    public function salir(){ 
      session_unset();
      session_destroy();
      header('location: ' . base_url);
      die();
    }
  }
?>