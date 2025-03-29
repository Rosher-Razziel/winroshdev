<?php
class ProveedoresModel extends Query{
  
  public function __construct(){
    parent::__construct();
  }

  // OBTENER PROVEEDORES
  public function getProveedores(){
    $sql = "SELECT * FROM proveedor";
    $data = $this->selectAll($sql);
    return $data;
  }

 // REGISTRAR PROVEEDORES
  public function registrarProveedor(string $desc_proveedor, string $dia_visita, string $nombre_proveedor, string $appat, string $apmat, string $correo, string $num_tel){
    
    $verificar = "SELECT * FROM proveedor WHERE DES_PROVEEDOR = '$desc_proveedor'";
    $existe = $this->select($verificar);

    if (empty($existe)) {
      $fecha = date('Y-m-d');
      $sql = "INSERT INTO proveedor (DES_PROVEEDOR, DIA_VISITA, NOMBRE, APPAT, APMAT, CORREO, NUMERO_TELEFONO, ESTADO, FECHA_REGISTRO) VALUES (?,?,?,?,?,?,?,?,?)";
      
      $datos = array($desc_proveedor, $dia_visita, $nombre_proveedor, $appat, $apmat, $correo, $num_tel, '1', $fecha);
      
      $data = $this->save($sql, $datos);
      
      return $data == 1 ? "Correcto" : "Error";
    }else{
      return "Existe";
    }
  }

  // EDITAR CATEGORIA
  public function editarProveedor(int $id){
    $sql = "SELECT * FROM proveedor WHERE ID_PROVEEDOR = $id";
    $data = $this->select($sql);
    return $data;
  }
 
  //MODIDICAR CATEGORIA
  public function modificarProveedor(string $desc_proveedor, string $dia_visita, string $nombre_proveedor, string $appat, string $apmat, string $correo, string $num_tel, int $idProveedor){
    $fecha = date('Y-m-d');

    $sql = "UPDATE proveedor SET DES_PROVEEDOR = ?, DIA_VISITA = ?, NOMBRE = ?, APPAT = ?, APMAT = ?, CORREO = ?, NUMERO_TELEFONO = ?, ESTADO = ?, FECHA_REGISTRO = ? WHERE ID_PROVEEDOR = ?";
    $datos = array($desc_proveedor, $dia_visita, $nombre_proveedor, $appat, $apmat, $correo, $num_tel, '1', $fecha, $idProveedor);
    $data = $this->save($sql, $datos);
    
    return $data == 1 ? "Correcto" : "Error";
  }

  // Cambiar estado del proveedor (generalizado para activar/desactivar)
  public function cambiarEstadoProveedor(int $id, int $estado){
    $sql = "UPDATE proveedor SET ESTADO = ? WHERE ID_PROVEEDOR = ?";
    $data = $this->save($sql, [$estado, $id]);

    return $data == 1 ? "Correcto" : "Error";
  }

  // Eliminar proveedor (desactivar)
  public function eliminarProveedor(int $id){
    return $this->cambiarEstadoProveedor($id, 0);
  }

  // Activar proveedor
  public function activarProveedor(int $id){
    return $this->cambiarEstadoProveedor($id, 1);
  }
}