<?php
class CajasModel extends Query{
  
  private $caja, $idCaja;

  public function __construct(){
    parent::__construct();
  }

  // OBTENER CAJAS
  public function getCajas(){
    $sql = "SELECT * FROM caja";
    $data = $this->selectAll($sql);
    return $data;
  }

  // REGISTRAR CAJA
  public function registrarCaja(string $caja){
    $this->caja = $caja;
    $fecha = date('Y-m-d');

    $verificar = "SELECT * FROM caja WHERE CAJA = '$this->caja'";
    $existe = $this->select($verificar);

    if (empty($existe)) {
      $sql = "INSERT INTO caja (CAJA, ESTADO, FECHA_REGISTRO) VALUES (?,?,?)";
      $datos = array($this->caja, '1', $fecha);
      $data = $this->save($sql, $datos);
      
      if ($data == 1) {
        $msg = "Ok";
      }else{
        $msg = "Error";
      }  
    }else{
      $msg = "Existe";
    }
    
    return $msg;
  }

  // EDITAR CAJA
  public function editarCaja(int $id){
    $sql = "SELECT * FROM caja WHERE ID_CAJA = $id";
    $data = $this->select($sql);
    return $data;
  }

  //MODIDICAR CAJA
  public function modificarCaja(string $caja, int $idCaja){
    $this->idCaja = $idCaja;
    $this->caja = $caja;
    
    $sql = "UPDATE caja SET CAJA = ? WHERE ID_CAJA = ?";
    $datos = array($this->caja, $this->idCaja);
    $data = $this->save($sql, $datos);
    
    if ($data == 1) {
      $msg = "Ok";
    }else{
      $msg = "Error";
    }  
    
    return $msg;
  }

  // ELIMINAR CAJA
  public function eliminarCaja(int $id){
    $this->idCaja = $id; 

    if($this->idCaja != 1){
      $sql = "UPDATE caja SET ESTADO = ? WHERE ID_CAJA = ?";
      $datos = array('0', $this->idCaja);
      $data = $this->save($sql, $datos);
      
      if ($data == 1) {
        $msg = "Ok";
      }else{
        $msg = "Error";
      }
    }else{
      $msg = "Error";
    }

    return $msg;
  }

  // ACTIVAR CAJA
  public function activarCaja(int $id){
    $this->idCaja = $id; 

    $sql = "UPDATE caja SET ESTADO = ? WHERE ID_CAJA = ?";
    $datos = array('1', $this->idCaja);
    $data = $this->save($sql, $datos);
    
    if ($data == 1) {
      $msg = "Ok";
    }else{
      $msg = "Error";
    }  

    return $msg;
  }

}