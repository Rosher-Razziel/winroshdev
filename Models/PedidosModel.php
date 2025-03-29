<?php
class PedidosModel extends Query{
  
  private $idPedido, $idProducto, $cantidad, $idDetalleP;

  public function __construct(){
    date_default_timezone_set("America/Mexico_City");
    parent::__construct();
  }

  // OBTENER PROVEEDORES
  public function getPedidoProveedor(){
    $sql = "SELECT pp.*, p.DES_PROVEEDOR FROM pedido_proveedor pp INNER JOIN proveedor p ON pp.ID_PEDIDO_PROV = p.ID_PROVEEDOR";
    return $this->selectAll($sql);
  }

  // BUSCAR PRODUCTOS PROVEEDOR
  public function buscarProductosPedido(int $idPedido){
    $sql = "SELECT dp.*, pp.TOTAL_PEDIDO, p.DES_PROVEEDOR, pr.ID_PRODUCTO, pr.PRODUCTO 
            FROM detalle_pedido dp 
            INNER JOIN pedido_proveedor pp ON dp.ID_DETALLE_PROV = pp.ID_PEDIDO_PROVEEDOR 
            INNER JOIN proveedor p ON pp.ID_PEDIDO_PROV = p.ID_PROVEEDOR 
            INNER JOIN producto pr ON dp.ID_PRODUCTO = pr.ID_PRODUCTO
            WHERE ID_DETALLE_PROV = $idPedido 
            ORDER BY pr.PRODUCTO ASC";
    return $this->selectAll($sql);
  }

  public function cambiarEstado(int $idPedido, int $estado){
    $sql = "UPDATE pedido_proveedor SET ESTADO = ? WHERE ID_PEDIDO_PROVEEDOR = ?";
    return $this->save($sql, [$estado, $idPedido]) === 1 ? "Ok" : "Error";
  }

  public function registrarDetalleProducto(int $idProducto, int $cantidad, int $idDetalleP){
    $sql = "SELECT * FROM producto WHERE ID_PRODUCTO = $idProducto";
    $data = $this->select($sql);
    if (!$data) {
      return "Error: Producto no encontrado";
    }

    // Actualizar existencias
    $cantidadTotal = $data['EXISTENCIAS'] + $cantidad;
    $sql = "UPDATE producto SET EXISTENCIAS = ? WHERE ID_PRODUCTO = ?";
    if ($this->save($sql, [$cantidadTotal, $idProducto]) !== 1) {
      return "Error: No se pudo actualizar las existencias";
    }

    // Actualizar estado del detalle del pedido
    $sql = "UPDATE detalle_pedido SET ESTADO = 1 WHERE ID_DETALLE_PEDIDO = ?";
      return $this->save($sql, [$idDetalleP]) === 1 ? "Ok" : "Error";
  }

}