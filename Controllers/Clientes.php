<?php

  class Clientes extends Controller{
    // FUNCCIONES CONTRUCTOR
    public function __construct(){
      session_start();
      if (empty($_SESSION['activo'])) {
        header('location: ' . base_url);
      }
      parent::__construct();
    }
    // FUNCION INDEX 
    public function index(){
      $this->views->getView($this, "index");
    }
    // FUNCION PARA LISTAR USUARIOS
    public function listar(){
      $data = $this->model->getClientes();

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

        $data[$i]['ACCIONES'] =  '<div>
        <button class="btn btn-primary mb-2" type="button" onclick="btnEditarCliente('.$data[$i]['ID_CLIENTE'].');"><i class="fa-solid fa-pen-to-square"></i></button>
        <button class="btn btn-danger mb-2" '.$btnEliminarEstado.' type="button" onclick="btnEliminarCliente('.$data[$i]['ID_CLIENTE'].');"><i class="fa-solid fa-trash"></i></button>
        <button class="btn btn-success mb-2" '.$btnActivarEstado.' type="button" onclick="btnActivarCliente('.$data[$i]['ID_CLIENTE'].');"><i class="fa-solid fa-circle-check"></i></button>
        </div>';
     
        $data[$i]['NOMBRECOMPLETO'] = $data[$i]['NOMBRE'] . ' ' . $data[$i]['APPAT'] . ' ' . $data[$i]['APMAT'];

      }

      echo json_encode($data, JSON_UNESCAPED_UNICODE);
      die();
    }
    // FUNCION PARA REGISTRAR USUARIOS
    public function regsitrar(){
     
      $idCliente = $_POST['idCliente'];
      $nombre = $_POST['nombre'];
      $appat = $_POST['appat'];
      $apmat = $_POST['apmat'];
      $num_tel = $_POST['num_tel'];
      $correo = $_POST['correo'];
      $lim_cred = $_POST['lim_cred'];

      if (empty($nombre) || empty($appat) || empty($apmat) || empty($num_tel) || empty($correo) || empty($lim_cred)) {
        $msg = "Los campos estan vacios";
      }else{
        if($idCliente == ""){

          $data = $this->model->registrarCliente($nombre, $appat, $apmat, $num_tel, $correo, $lim_cred);

          if ($data == "Ok") {
            $msg = "Correcto";
          }else if($data == "Existe"){
            $msg = "El cliente ya existe";
          }else{
            $msg = "Error al registrar al cliente";
          }
        }else{
          $data = $this->model->modificarUsuario($nombre, $appat, $apmat, $num_tel, $correo, $lim_cred, $idCliente);

            if ($data == "Ok") {
              $msg = "Correcto";
            }else{
              $msg = "Error al editar al cliente";
            }
        }
        
      }    
      echo json_encode($msg, JSON_UNESCAPED_UNICODE);
      die();
    }
    // FUNCION PARA EDITAR USUARIOS
    public function editar(int $id){ 
      $data = $this->model->editarCliente($id);
      echo json_encode($data, JSON_UNESCAPED_UNICODE);
      die();
    }
    // FUNCION PARA ELIMINAR USUARIOS
    public function eliminar(int $id){ 
      $data = $this->model->eliminarCliente($id);
      echo json_encode($data, JSON_UNESCAPED_UNICODE);
      die();
    }
    // FUNCION PARA ACTIVAR USUARIOS
    public function activar(int $id){ 
      $data = $this->model->activarCliente($id);
      echo json_encode($data, JSON_UNESCAPED_UNICODE);
      die();
    }
  }
?>