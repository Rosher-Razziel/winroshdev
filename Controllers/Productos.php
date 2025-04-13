<?php

class Productos extends Controller {
  public function __construct() {
    // Iniciar sesión solo si no ha sido iniciada
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }

    if (empty($_SESSION['activo'])) {
      header('Location: ' . base_url);
      exit;
   }

    parent::__construct();
  }

  public function index() {
    $data = [
      'Proveedores' => $this->model->getProveedores(),
      'Categorias' => $this->model->getCategorias(),
      'Medidas' => $this->model->getMedidas()
    ];

    $this->views->getView($this, "index", $data);
  }

  // Función genérica para listar productos con sus acciones
  private function prepareProductosData($productos) {
    foreach ($productos as &$producto) {
      $producto['IMAGEN'] = $this->getImagenHTML($producto['FOTO']);
      $producto['PROV_CAT'] = htmlspecialchars($producto['DES_PROVEEDOR']) . ' - ' . htmlspecialchars($producto['DES_CATEGORIA']);
      $producto['PRECIO_COMPRA'] = '$' . number_format($producto['PRECIO_COMPRA'], 2);
      $producto['PRECIO_VENTA'] = '$' . number_format($producto['PRECIO_VENTA'], 2);
      $producto['ACCIONES'] = $this->getAccionesHTML($producto['ID_PRODUCTO'], $producto['ESTADO']);
    }
    return $productos;
  }

  // Genera el HTML de la imagen
  private function getImagenHTML($foto) {
    return '<img class="img-thumbnail" width="100" height="100" src="' . base_url . "Assets/img/" . htmlspecialchars($foto) . '">';
  }

// Genera el HTML de las acciones según el estado
private function getAccionesHTML($idProducto, $estado) {
  $acciones = '<div>';
  if ($estado == 1) {
    $acciones .= sprintf(
      '<button class="btn btn-primary m-1" onclick="btnEditarProducto(%d);"><i class="fa-solid fa-pen-to-square"></i></button>',
      $idProducto);
    $acciones .= sprintf(
      '<button class="btn btn-warning m-1" onclick="btnCambiarStatus(%d);"><i class="fa-solid fa-bolt"></i></button>',
      $idProducto);
    // $acciones .= sprintf(
        // '<button class="btn btn-danger m-1" onclick="btnEliminar(%d);"><i class="fa-solid fa-trash"></i></button>',
        // $idProducto);
    $acciones .= '<span class="badge btn-success">Activo</span>';
  } else {
    $acciones .= sprintf(
      '<button class="btn btn-success m-1" onclick="btnActivarProducto(%d);"><i class="fa-solid fa-circle-check"></i></button>',
      $idProducto);
    $acciones .= '<span class="badge btn-danger">Inactivo</span>';
  }
  $acciones .= '</div>';
  return $acciones;
}

  // FUNCION PARA LISTAR PRODUCTOS
  public function listar() {
    $data = $this->model->getProductos();
    $data = $this->prepareProductosData($data);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    die();
  }
  // FUNCION PARA REGISTRAR PRODUCTOS
  public function registrar() {
    $idProducto = $_POST['idProducto'];
    $cod_barras = htmlspecialchars(trim($_POST['cod_barras']));
    $nombre_producto = strtoupper(trim($_POST['nombre_producto']));
    $precio_compra = floatval($_POST['precio_compra']);
    $existencia = intval($_POST['existencia']);
    $precio_venta = floatval($_POST['precio_venta']);
    $existencia_minima = intval($_POST['existencia_minima']);
    $proveedor = intval($_POST['proveedor']);
    $categoria = intval($_POST['categoria']);
    $medida = intval($_POST['medida']);
    $imagen = $_FILES['imagen'];
    $fecha = date('YmdHis');
      
    // Verificar si faltan datos
    if (empty($cod_barras) || empty($nombre_producto) || empty($precio_compra) || empty($precio_venta) || empty($proveedor) || empty($categoria) || empty($medida)) {
      $msg = "Los campos están vacíos";
    } else {
      // Validar y gestionar imagen
      $imgNombre = $this->handleImage($imagen, $fecha);
      
      // Insertar o actualizar producto
      if (empty($idProducto)) {
        $data = $this->model->registrarProducto($cod_barras, $nombre_producto, $precio_compra, $existencia, $precio_venta, $existencia_minima, $proveedor, $categoria, $medida, $imgNombre);
      } else {
        $this->deleteOldImageIfNecessary($idProducto);
        $data = $this->model->modificarProducto($cod_barras, $nombre_producto, $precio_compra, $existencia, $precio_venta, $existencia_minima, $proveedor, $categoria, $medida, $idProducto, $imgNombre);
      }

      $msg = $data == "Ok" ? "Correcto" : ($data == "Existe" ? "El producto ya existe" : "Error al registrar el producto");

      if (!empty($imagen['tmp_name'])) {
        move_uploaded_file($imagen['tmp_name'], "Assets/img/" . $imgNombre);
      }
    }
      echo json_encode($msg, JSON_UNESCAPED_UNICODE);
      die();
  }

  // FUNCION PARA EDITAR PRODUCTOS
  public function editar(int $idProducto) {
    $data = $this->model->editarProductos($idProducto);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    die();
  }

  // FUNCION PARA DESACTIVAR PRODUCTOS
  public function descativar(int $id) {
    $data = $this->model->desactivarProducto($id);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    die();
  }

  // FUNCION PARA ACTIVAR PRODUCTOS
  public function activar(int $id) {
    $data = $this->model->activarProducto($id);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    die();
  }

  public function eliminar(int $id){
    //TODO: NO SE PUEDE ELIMINAR POR LAS LLAVES FORANEAS
    $data = $this->model->eliminarProducto($id);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    die();
  }

  // Eliminar imagen antigua si es necesario
  private function deleteOldImageIfNecessary($idProducto) {
    $imgDelete = $this->model->editarProductos($idProducto);
    if ($imgDelete['FOTO'] != 'default.png' && $_POST['foto_actual'] != $imgDelete['FOTO']) {
      $imgPath = "Assets/img/" . $imgDelete['FOTO'];
      if (file_exists($imgPath)) {
        unlink($imgPath);
      }
    }
  }

  // Manejo de imágenes
  private function handleImage($imagen, $fecha) {
    // Verificar si se subió una imagen
    if (!empty($imagen['name'])) {
      $allowedTypes = ['image/jpeg', 'image/png'];
      // Validar tipo de imagen permitido
      if (!in_array($imagen['type'], $allowedTypes)) {
        $this->sendErrorResponse("Formato de imagen no permitido");
      } 
      // Obtener la extensión de la imagen
      $extension = pathinfo($imagen['name'], PATHINFO_EXTENSION);
      return $fecha . "." . $extension;
    }
    // Si no se sube una imagen, devolver la imagen actual o default
    return !empty($_POST['foto_actual']) ? $_POST['foto_actual'] : "default.png";
  }

  // Función para enviar una respuesta de error
  private function sendErrorResponse($message) {
    echo json_encode($message, JSON_UNESCAPED_UNICODE);
    die();
  }

}
?>