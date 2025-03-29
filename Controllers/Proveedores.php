<?php

class Proveedores extends Controller{
  public function __construct(){
    // Iniciar sesión solo si no ha sido iniciada
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }
    if (empty($_SESSION['activo'])) {
        header('location: ' . base_url);
        exit;
    }
    parent::__construct();
  }

  public function index(){
    $this->views->getView($this, "index");
  }

  public function listar() {
    $data = $this->model->getProveedores();

    foreach ($data as &$proveedor) { 
      $estadoActivo = $proveedor['ESTADO'] == 1;

      // Asignar estado con badges
      $proveedor['ESTADO'] = $estadoActivo
          ? '<span class="badge btn-success">Activo</span>'
          : '<span class="badge btn-danger">Inactivo</span>';

      // Botones según el estado
      $proveedor['ACCIONES'] = sprintf('
        <div>
            <button class="btn btn-primary mb-2" type="button" onclick="btnEditarProveedor(%d);">
                <i class="fa-solid fa-pen-to-square"></i>
            </button>
            <button class="btn btn-danger mb-2" %s type="button" onclick="btnEliminarProveedor(%d);">
                <i class="fa-solid fa-trash"></i>
            </button>
            <button class="btn btn-success mb-2" %s type="button" onclick="btnActivarProveedor(%d);">
                <i class="fa-solid fa-circle-check"></i>
            </button>
        </div>',
        $proveedor['ID_PROVEEDOR'],
        $estadoActivo ? '' : 'disabled',
        $proveedor['ID_PROVEEDOR'],
        $estadoActivo ? 'disabled' : '',
        $proveedor['ID_PROVEEDOR']
      );

      // Concatenar el nombre completo
      $proveedor['NOMBRECOMPLETO'] = implode(' ', [$proveedor['NOMBRE'], $proveedor['APPAT'], $proveedor['APMAT']]);
    }

    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    die();
  }
  
  // FUNCION PARA REGISTRAR USUARIOS
  public function registrar(){
     
    // Obtener los valores del formulario
    $idProveedor = $_POST['idProveedor'] ?? null;
    $desc_proveedor = $_POST['desc_proveedor'] ?? '';
    $dia_visita = $_POST['dia_visita'] ?? '';
    $nombre_proveedor = $_POST['nombre_proveedor'] ?? '';
    $appat = $_POST['appat'] ?? '';
    $apmat = $_POST['apmat'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $num_tel = $_POST['num_tel'] ?? '';

    if (empty($desc_proveedor) || empty($dia_visita) || empty($nombre_proveedor) || empty($appat) || empty($apmat) || empty($correo) || empty($num_tel)) {
      $msg = "Los campos estan vacios";
    }else{
      if(empty($idProveedor)){
        $data = $this->model->registrarProveedor($desc_proveedor, $dia_visita, $nombre_proveedor, $appat, $apmat, $correo, $num_tel);
      }else{
        $data = $this->model->modificarProveedor($desc_proveedor, $dia_visita, $nombre_proveedor, $appat, $apmat, $correo, $num_tel, $idProveedor);
      }
      
      $msg = ($data == "Correcto") ? "Correcto" : (($data == "Existe") ? "Existe" : "Error");

    }    
    echo json_encode($msg, JSON_UNESCAPED_UNICODE);
    die();
  }

  // Función genérica para manejar operaciones en Proveedores
  private function manejarOperacionProveedor(callable $operacion, int $id) {
    $data = $operacion($id);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    die();
  }

  // Función para editar categorías
  public function editar(int $id) {
    $this->manejarOperacionProveedor([$this->model, 'editarProveedor'], $id);
  }

  // Función para eliminar usuarios
  public function eliminar(int $id) {
    $this->manejarOperacionProveedor([$this->model, 'eliminarProveedor'], $id);
  }

  // Función para activar usuarios
  public function activar(int $id) {
    $this->manejarOperacionProveedor([$this->model, 'activarProveedor'], $id);
  }


}

?>