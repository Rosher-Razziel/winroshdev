<?php
class VentasModel extends Query{
  
  private $codigo, $folio, $pagaCon, $totalVenta, $cambio, $fecha, $hora, $idUsuario, $idProducto, $cantidad, $precio, $subTotal,$idVenta;

  public function __construct(){
    date_default_timezone_set("America/Mexico_City");
    parent::__construct();
  }

  public function getProductos(string $codigo): array {
    $sql = "SELECT p.COD_BARRAS, p.PRODUCTO FROM producto p WHERE p.COD_BARRAS = '$codigo' OR p.PRODUCTO LIKE '%$codigo%' ORDER BY COD_BARRAS ASC LIMIT 10";
    return $this->selectAll($sql);
  }

  public function obtenerProducto(string $codigo){
    $sql = "SELECT * FROM producto WHERE COD_BARRAS = '$codigo'";
    $data = $this->selectAll($sql);
    return $data;
  }

  public function ingresarVenta(string $folio, float $pagaCon, float $totalVenta, float $cambio, int $idUsuario){
    $fecha = date('Y-m-d');
    $hora = date('H:i:s');
  
    $sql = "INSERT INTO venta (FOLIO_TICKET, PAGO_CON, TOTAL_TICKET, CAMBIO, FECHA_VENTA, HORA_VENTA, ID_USUARIO_VENTA, ID_CLIENTE_VENTA) VALUES (?,?,?,?,?,?,?,?)";
    $datos = array($folio, $pagaCon, $totalVenta, $cambio, $fecha, $hora, $idUsuario, '1');
    $data = $this->save($sql, $datos);
  
    return $this->manejarRespuesta($data);
  }


  // OBTENER ULTIMO ID
  public function getUltimoId(string  $tabla){

    $sql = "SELECT MAX(ID_VENTA) AS ID_VENTA FROM $tabla";
    $data = $this->select($sql);
    return $data;
  }

  public function registrarDetalleVenta(int $idProducto, int $cantidad, float $precio, float $subTotal, int $idVenta){
    $this->idProducto = $idProducto;
    $this->cantidad = $cantidad;
    $this->precio = $precio;
    $this->subTotal = $subTotal;
    $this->idVenta = $idVenta;
    
    $sql = "INSERT INTO detalle_venta (ID_PROD, CANTIDAD, PRECIO, SUB_TOTAL, ID_VENTA) VALUES (?,?,?,?,?)";
    $datos = array($this->idProducto, $this->cantidad, $this->precio, $this->subTotal, $this->idVenta);
    $data = $this->save($sql, $datos);
    
    return $this->manejarRespuesta($data);
  }

  // OBTENER DATOS DE LA EMPRESA
  public function getEmpresa(){
    $sql = "SELECT * FROM datos_empresa";
    $data = $this->selectAll($sql);
    return $data;
  }

  // OBTENER DETALLE DE PEDIDO 
  public function getDetalleVenta(int $idVenta){
    $this->idVenta = $idVenta;
    $sql = "SELECT dv.CANTIDAD, p.PRODUCTO, dv.PRECIO, dv.SUB_TOTAL, v.TOTAL_TICKET, v.CAMBIO, v.PAGO_CON FROM detalle_venta dv
    INNER JOIN producto p ON dv.ID_PROD = p.ID_PRODUCTO
    INNER JOIN venta v ON dv.ID_VENTA = v.ID_VENTA
    WHERE v.ID_VENTA = $this->idVenta";
    $data = $this->selectAll($sql);
    return $data;
  }

  // MANEJAR RESPUESTA 
  private function manejarRespuesta($data){
    return $data == 1 ? 'Ok' : 'Error';
  }

}