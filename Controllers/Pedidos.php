<?php
class Pedidos extends Controller{
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

  const ESTADO_EN_PROCESO = 0;
  const ESTADO_ENTREGADO = 1;
  const ESTADO_CANCELADO = 2;

  private function generarAcciones($idPedidoProveedor, $disabled) {
    return '<div>' .
      '<a class="btn btn-warning mb-2" href="' . base_url . 'Compras/generarPdf/' . htmlspecialchars($idPedidoProveedor) . '" target="_blank"><i class="fa-solid fa-file-pdf"></i></a>' .
      '<button class="btn btn-primary mb-2 ' . htmlspecialchars($disabled) . '" type="button" onclick="btnDetallesPedidos(' . htmlspecialchars($idPedidoProveedor) . ', 1);"><i class="fa-solid fa-eye"></i></button>' .
      '<button class="btn btn-danger mb-2 ' . htmlspecialchars($disabled) . '" type="button" onclick="btnEliminarPedidos(' . htmlspecialchars($idPedidoProveedor) . ', 2);"><i class="fa-solid fa-trash"></i></button>' .
      '</div>';
  }

  public function listar() {
    $data = $this->model->getPedidoProveedor();
    $estados = [
      self::ESTADO_ENTREGADO => '<span class="badge btn-success">Entregado</span>',
      self::ESTADO_EN_PROCESO => '<span class="badge btn-warning">En Proceso</span>',
      self::ESTADO_CANCELADO => '<span class="badge btn-danger">Cancelado</span>',
    ];

    foreach ($data as &$pedido) {
      $disabled = $pedido['ESTADO'] == self::ESTADO_ENTREGADO ? 'd-none' : ($pedido['ESTADO'] == self::ESTADO_CANCELADO ? 'd-none' : '');
      $pedido['ESTADO'] = $estados[$pedido['ESTADO']];
      $pedido['ACCIONES'] = $this->generarAcciones($pedido['ID_PEDIDO_PROVEEDOR'], $disabled);
    }

    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    die();
  }

  public function buscarProductosPedido($idPedido){
    $data = $this->model->buscarProductosPedido($idPedido);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    die();
  }

  public function registrar() {
    $datos = $_POST;
    $errores = $this->validarDatos($datos);
    if ($errores) {
      $msg = 'Los campos están vacíos o incorrectos';
    } else {
      try {
        $this->cambiarEstadoPedido($datos['idPedido'], $datos['estado']);
        $this->registrarDetalleProductos($datos['productos']);
        $msg = 'Ok';
      } catch (Exception $e) {
        $msg = 'Error al registrar el producto: ' . $e->getMessage();
      }
    }
    echo json_encode($msg, JSON_UNESCAPED_UNICODE);
    die();
  }

  private function validarDatos($datos) {
    $errores = [];
    if (!isset($datos['idPedido'])) {
      $errores[] = 'idPedido debe ser un número entero';
    }
    if (!isset($datos['productos'])) {
      $errores[] = 'productos debe ser un arreglo';
    }
    return $errores;
  }

  private function cambiarEstadoPedido($idPedido, $estado) {
    $data = $this->model->cambiarEstado($idPedido, $estado);
    if ($data != 'Ok') {
      throw new Exception('Error al cambiar el estado del pedido');
    }
  }

  private function registrarDetalleProductos($productos) {
    foreach ($productos as $producto) {
      if ($producto['cantidad'] > 0) {
        $this->model->registrarDetalleProducto($producto['idProducto'], $producto['cantidad'], $producto['idDetallesP']);
      }
    }
  }

  public function canelarPedido() {
    $datos = $_POST;
    $data =  $data = $this->model->cambiarEstado($datos['idPedido'], $datos['estado']);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    die();
  }
}
?>