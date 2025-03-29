<?php
class ComprasModel extends Query{
  
  private $idProveedor, $idFolio, $productos, $rutaPedidoPdf, $totalP;

  public function __construct(){
    date_default_timezone_set("America/Mexico_City");
    parent::__construct();
  }

  // BUSCAR PRODUCTOS PROVEEDOR
  public function buscarProductosProv(int $idProv){
    $sql = "SELECT P.*, PR.DES_PROVEEDOR FROM producto P INNER JOIN proveedor PR ON P.ID_PROV = PR.ID_PROVEEDOR
    WHERE P.ID_PROV = $idProv AND P.ESTADO = 1 ORDER BY P.PRODUCTO ASC";
    $data = $this->selectAll($sql);
    return $data;
  }

  // REGISTRAR PRODUCTOS
  public function registrarPedidoProveedor(int $idProveedor, string $idFolio, array $productos, float $totalP): string {
    $this->idProveedor = $idProveedor;
    $this->idFolio = $idFolio;
    $this->totalP = $totalP;
    $this->productos = $productos;
    $this->rutaPedidoPdf = sprintf('%s_%s.pdf', $productos[0]['proveedor'], $idFolio);
    $fecha = date('Y-m-d');
    $hora = date('H:i:s');

    $sql = "INSERT INTO pedido_proveedor (RUTA_PEDIDO_PDF, TOTAL_PEDIDO, ESTADO, FECHA_PEDIDO, HORA_PEDIDO, ID_PEDIDO_PROV) VALUES (?, ?, '0', ?, ?, ?)";
    $datos = [$this->rutaPedidoPdf, $this->totalP, $fecha, $hora, $this->idProveedor];
    $data = $this->save($sql, $datos);
    return $data === 1 ? "Ok" : "Error";
  }

  // REGISTRAR DETALLE PEDIDO PROVEEDOR
  public function registrarDetallePedido(int $idProducto, float $cantidad, float $precio, float $subtotal, int $idUsuario, int $idPedido): string {
    $sql = "INSERT INTO detalle_pedido (ID_PRODUCTO, CANTIDAD, PRECIO, SUB_TOTAL, ID_USUARIO, ID_DETALLE_PROV) VALUES (?, ?, ?, ?, ?, ?)";
    $datos = [$idProducto, $cantidad, $precio, $subtotal, $idUsuario, $idPedido];
    $data = $this->save($sql, $datos);
    return $data === 1 ? "Ok" : "Error";
  }

  // OBTENER ÚLTIMO ID
  public function getUltimoId() {
    $sql = "SELECT MAX(ID_PEDIDO_PROVEEDOR) AS ID_PEDIDO FROM pedido_proveedor";
    $data = $this->select($sql);
    return $data ?? null;
  }

  // OBTENER DATOS DE LA EMPRESA
  public function getEmpresa(): array {
    $sql = "SELECT * FROM datos_empresa";
    return $this->selectAll($sql);
  }

  // OBTENER DATOS DEL PROVEEDOR
  public function getProveedor(int $idPedido): array {
    $sql = "SELECT * FROM pedido_proveedor PP 
      INNER JOIN proveedor P ON PP.ID_PEDIDO_PROV = P.ID_PROVEEDOR 
      WHERE PP.ID_PEDIDO_PROVEEDOR = $idPedido";
    return $this->selectAll($sql);
  }

  // OBTENER DETALLE DE PEDIDO
  public function getDetallePedido(int $idPedido): array {
    $sql = "SELECT DP.*, P.PRODUCTO, PP.TOTAL_PEDIDO 
      FROM detalle_pedido DP
      INNER JOIN producto P ON DP.ID_PRODUCTO = P.ID_PRODUCTO
      INNER JOIN pedido_proveedor PP ON DP.ID_DETALLE_PROV = PP.ID_PEDIDO_PROVEEDOR
      WHERE ID_DETALLE_PROV = $idPedido 
      ORDER BY P.PRODUCTO";
    return $this->selectAll($sql);
  }

  // OBTENER PRODUCTOS
  public function getProductos(): array {
    $sql = "SELECT P.*, PR.DES_PROVEEDOR, C.DES_CATEGORIA 
      FROM producto P 
      INNER JOIN proveedor PR ON P.ID_PROV = PR.ID_PROVEEDOR
      INNER JOIN categoria C ON P.ID_CAT = C.ID_CATEGORIA";
    return $this->selectAll($sql);
  }

  // OBTENER PROVEEDORES
  public function getProveedores(): array {
    $sql = "SELECT * FROM proveedor ORDER BY DES_PROVEEDOR ASC";
    return $this->selectAll($sql);
  }
}