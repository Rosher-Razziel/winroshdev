<?php

  class Roles extends Controller{
    public function __construct(){
      session_start();
      if (empty($_SESSION['activo'])) {
        header('location: ' . base_url);
      }
      parent::__construct();
    }

    public function index(){
      $this->views->getView($this, "index");
    }

    // FUNCION PARA LISTAR CAJAS
    public function listar(){
      $data = $this->model->getRoles();

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
        <button class="btn btn-primary mb-2" type="button" onclick="btnEditarRoles('.$data[$i]['ID_ROL'].');"><i class="fa-solid fa-pen-to-square"></i></button>
        <button class="btn btn-danger mb-2"'.$btnEliminarEstado.' type="button" onclick="btnEliminarRoles('.$data[$i]['ID_ROL'].');"><i class="fa-solid fa-trash"></i></button>
        <button class="btn btn-success mb-2" '.$btnActivarEstado.' type="button" onclick="btnActivarRoles('.$data[$i]['ID_ROL'].');"><i class="fa-solid fa-circle-check"></i></button>
        </div>';

      }

      echo json_encode($data, JSON_UNESCAPED_UNICODE);
      die();
    }

    // FUNCION PARA REGISTRAR USUARIOS
    public function registrar(){
     
      $idRol = $_POST['idRol'];
      $rol = $_POST['rol'];

      if (empty($rol)) {
        $msg = "Los campos estan vacios";
      }else{
        if($idRol == ""){
          $data = $this->model->registrarRol($rol);

          if ($data == "Ok") {
            $msg = "Correcto";
          }else if($data == "Existe"){
            $msg = "El usuario ya existe";
          }else{
            $msg = "Error al registrar al caja";
          }
        }else{
          $data = $this->model->modificarRol($rol, $idRol);

            if ($data == "Ok") {
              $msg = "Correcto";
            }else{
              $msg = "Error al editar al caja";
            }
        }
        
      }    
      echo json_encode($msg, JSON_UNESCAPED_UNICODE);
      die();
    }

    // FUNCION PARA EDITAR CATEGORIAS
    public function editar(int $idRol){ 
      $data = $this->model->editarRol($idRol);
      echo json_encode($data, JSON_UNESCAPED_UNICODE);
      die();
    }

    // FUNCION PARA ELIMINAR USUARIOS
    public function eliminar(int $id){ 
      $data = $this->model->eliminarRol($id);
      echo json_encode($data, JSON_UNESCAPED_UNICODE);
      die();
    }
    // FUNCION PARA ACTIVAR USUARIOS
    public function activar(int $id){ 
      $data = $this->model->activarRol($id);
      echo json_encode($data, JSON_UNESCAPED_UNICODE);
      die();
    }

  }

?>