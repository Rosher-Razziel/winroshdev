<?php
  class Categorias extends Controller{
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

    // FUNCION PARA LISTAR CATEGORÍAS
    public function listar(){
      $data = $this->model->getCategorias();

      foreach ($data as &$categoria) {
        $estado = $categoria['ESTADO'] == 1;
        
        $categoria['ESTADO'] = $estado 
            ? '<span class="badge btn-success">Activo</span>' 
            : '<span class="badge btn-danger">Inactivo</span>';

        $btnEliminarEstado = $estado ? "" : "disabled";
        $btnActivarEstado = $estado ? "disabled" : "";

        $categoria['ACCIONES'] = '
          <div>
            <button class="btn btn-primary mb-2" type="button" onclick="btnEditarCategoria(' . $categoria['ID_CATEGORIA'] . ');">
              <i class="fa-solid fa-pen-to-square"></i>
            </button>
            <button class="btn btn-danger mb-2" ' . $btnEliminarEstado . ' type="button" onclick="btnEliminarCategoria(' . $categoria['ID_CATEGORIA'] . ');">
              <i class="fa-solid fa-trash"></i>
            </button>
            <button class="btn btn-success mb-2" ' . $btnActivarEstado . ' type="button" onclick="btnActivarCategoria(' . $categoria['ID_CATEGORIA'] . ');">
              <i class="fa-solid fa-circle-check"></i>
            </button>
          </div>';
      }

      echo json_encode($data, JSON_UNESCAPED_UNICODE);
      die();
    }

  // FUNCION PARA REGISTRAR O MODIFICAR CATEGORÍAS
  public function registrar(){
    $idCategoria = $_POST['idCategoria'] ?? null;
    $categoria = $_POST['categoria'] ?? null;

    if (empty($categoria)) {
      $msg = "Los campos están vacíos";
    } else {
      if (empty($idCategoria)) {
        $msg = $this->procesarRegistro($categoria);
      } else {
        $msg = $this->procesarModificacion($categoria, $idCategoria);
      }
    }

    echo json_encode($msg, JSON_UNESCAPED_UNICODE);
    die();
  }

  // PROCESAR NUEVO REGISTRO
  private function procesarRegistro($categoria) {
    $data = $this->model->registrarCategoria($categoria);

    return $data == "Correcto" ? "Correcto" : ($data == "Existe" ? "Existe" : "Error");
  }

  // PROCESAR MODIFICACIÓN
  private function procesarModificacion($categoria, $idCategoria) {
    $data = $this->model->modificarCategoria($categoria, $idCategoria);

    return $data == "Correcto" ? "Correcto" : "Error";
  }

  // FUNCION PARA EDITAR CATEGORIAS
  public function editar(int $idCategoria){ 
    $data = $this->model->editarCategoria($idCategoria);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    die();
  }

  // FUNCION PARA ELIMINAR USUARIOS
  public function eliminar(int $id){ 
    $data = $this->model->eliminarCategoria($id);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    die();
  }
  // FUNCION PARA ACTIVAR USUARIOS
  public function activar(int $id){ 
    $data = $this->model->activarCategoria($id);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    die();
  }
}
?>