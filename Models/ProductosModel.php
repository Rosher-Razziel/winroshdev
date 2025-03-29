<?php
class ProductosModel extends Query{
  
  public function __construct(){
    parent::__construct();
  }

  // OBTENER PRODUCTOS ACTIVOS E INACTIVOS
  private function obtenerProductos() {
    $sql = "SELECT P.*, PR.DES_PROVEEDOR, C.DES_CATEGORIA FROM producto P 
      INNER JOIN  proveedor PR  ON P.ID_PROV = PR.ID_PROVEEDOR
      INNER JOIN categoria C ON P.ID_CAT = C.ID_CATEGORIA";
    return $this->selectAll($sql);
  }

  public function getProductos() {
    return $this->obtenerProductos(); // Activos
  }

  // OBTENER ENTIDADES (PROVEEDORES, CATEGORÍAS, MEDIDAS)
  private function obtenerEntidad($tabla) {
    $sql = "SELECT * FROM $tabla";
    return $this->selectAll($sql);
  }

  public function getProveedores() {
    return $this->obtenerEntidad('proveedor');
  }

  public function getCategorias() {
    return $this->obtenerEntidad('categoria');
  }

  public function getMedidas() {
    return $this->obtenerEntidad('medida');
  }

  // REGISTRAR PRODUCTOS
  public function registrarProducto(string $cod_barras, string $nombre_producto, string $precio_compra, string $existencia, string $precio_venta, string $existencia_minima, string $proveedor, string $categoria, string $medida, string $nameImg){

    $fecha = date('Y-m-d');

    $verificar = "SELECT * FROM producto WHERE COD_BARRAS = '$this->cod_barras'";
    $existe = $this->select($verificar);

    if (empty($existe)) {

      $sql = "INSERT INTO producto (FOTO, COD_BARRAS, PRODUCTO, PRECIO_COMPRA, PRECIO_VENTA, EXISTENCIAS, EXISTENCIA_MINIMA, FECHA_REGISTRO, ESTADO, ID_PROV, ID_CAT, ID_MED) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
      
      $datos = array($nameImg, $cod_barras, $nombre_producto, $precio_compra, $precio_venta, $existencia, $existencia_minima, $fecha, '1', $proveedor, $categoria, $medida);

      return $this->save($sql, $datos) === 1 ? "Ok" : "Error"; 
    }else{
      return "Existe";
    }
  }

  //MODIDICAR PRODUCTO
  public function modificarProducto(string $cod_barras, string $nombre_producto, string $precio_compra, string $existencia, string $precio_venta, string $existencia_minima, string $proveedor, string $categoria, string $medida, int $idProducto, string $nameImg){
    $fecha = date('Y-m-d');

    $sql = "UPDATE producto SET FOTO = ?, COD_BARRAS = ?, PRODUCTO = ?, PRECIO_COMPRA = ?, PRECIO_VENTA = ?, EXISTENCIAS = ?, EXISTENCIA_MINIMA = ?, FECHA_REGISTRO = ?, ESTADO = ?, ID_PROV = ?, ID_CAT = ?, ID_MED = ? WHERE ID_PRODUCTO = ?";

    $datos = array($nameImg, $cod_barras, $nombre_producto, $precio_compra, $precio_venta, $existencia, $existencia_minima, $fecha, '1', $proveedor, $categoria, $medida, $idProducto);

    return $this->save($sql, $datos) === 1 ? "Ok" : "Error"; 
  }

  // EDITAR PRODUCTOS
  public function editarProductos(int $id){
    $sql = "SELECT * FROM producto WHERE ID_PRODUCTO = $id";
    $data = $this->select($sql);
    return $data;
  }

  // CAMBIAR ESTADO DEL PRODUCTO
  private function cambiarEstadoProducto(int $id, int $estado) {
    $sql = "UPDATE producto SET ESTADO = ? WHERE ID_PRODUCTO = ?";
    $datos = [$estado, $id];
    $data = $this->save($sql, $datos);

    return $data === 1 ? "Ok" : "Error";
  }

  // ELIMINAR PRODUCTO
  public function eliminarProducto(int $id) {
    return $this->cambiarEstadoProducto($id, 0);
  }

  // ACTIVAR PRODUCTO
  public function activarProducto(int $id) {
    return $this->cambiarEstadoProducto($id, 1);
  }
}