<?php

  class Medidas extends Controller{

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
      $data = $this->model->getMedidas();

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
        <button class="btn btn-primary mb-2" type="button" onclick="btnEditarMedida('.$data[$i]['ID_MEDIDA'].');"><i class="fa-solid fa-pen-to-square"></i></button>
        <button class="btn btn-danger mb-2"'.$btnEliminarEstado.' type="button" onclick="btnEliminarMedida('.$data[$i]['ID_MEDIDA'].');"><i class="fa-solid fa-trash"></i></button>
        <button class="btn btn-success mb-2" '.$btnActivarEstado.' type="button" onclick="btnActivarMedida('.$data[$i]['ID_MEDIDA'].');"><i class="fa-solid fa-circle-check"></i></button>
        </div>';

      }

      echo json_encode($data, JSON_UNESCAPED_UNICODE);
      die();
    }
    // FUNCION PARA REGISTRAR USUARIOS
    public function registrar(){
     
      $idMedida = $_POST['idMedida'];
      $medida_prod = $_POST['medida_prod'];
      $medida_corto = $_POST['medida_corto'];


      if (empty($medida_prod) || empty($medida_corto)) {
        $msg = "Los campos estan vacios";
      }else{
        if($idMedida == ""){
          $data = $this->model->registrarMedida($medida_prod, $medida_corto);

          if ($data == "Ok") {
            $msg = "Correcto";
          }else if($data == "Existe"){
            $msg = "La Medida ya existe";
          }else{
            $msg = "Error al registrar la medida";
          }
        }else{
          $data = $this->model->modificarMedida($medida_prod, $medida_corto, $idMedida);

            if ($data == "Ok") {
              $msg = "Correcto";
            }else{
              $msg = "Error al editar la medida";
            }
        }
        
      }    
      echo json_encode($msg, JSON_UNESCAPED_UNICODE);
      die();
    }
    // FUNCION PARA EDITAR USUARIOS
    public function editar(int $idMedida){ 
      $data = $this->model->editarMedida($idMedida);
      echo json_encode($data, JSON_UNESCAPED_UNICODE);
      die();
    }
    // FUNCION PARA ELIMINAR USUARIOS
    public function eliminar(int $id){ 
      $data = $this->model->eliminarMedida($id);
      echo json_encode($data, JSON_UNESCAPED_UNICODE);
      die();
    }
    // FUNCION PARA ACTIVAR USUARIOS
    public function activar(int $id){ 
      $data = $this->model->activarMedida($id);
      echo json_encode($data, JSON_UNESCAPED_UNICODE);
      die();
    }

  }

?>