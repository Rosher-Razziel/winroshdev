<?php
class MedidasModel extends Query{
  
  private $medida, $medida_corto, $idMedida;

  public function __construct(){
    parent::__construct();
  }

    // OBTENER CAJAS
    public function getMedidas(){
      $sql = "SELECT * FROM medida";
      $data = $this->selectAll($sql);
      return $data;
    }
  
    // REGISTRAR CAJA
    public function registrarMedida(string $medida, string $medida_corto){
      $this->medida = $medida;
      $this->medida_corto = $medida_corto;
      $fecha = date('Y-m-d');
  
      $verificar = "SELECT * FROM medida WHERE MEDIDA = '$this->medida'";
      $existe = $this->select($verificar);
  
      if (empty($existe)) {
        $sql = "INSERT INTO medida (MEDIDA, NOMBRE_CORTO, ESTADO, FECHA_REGISTRO) VALUES (?,?,?,?)";
        $datos = array($this->medida, $this->medida_corto, '1', $fecha);
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
    public function editarMedida(int $id){
      $sql = "SELECT * FROM medida WHERE ID_MEDIDA = $id";
      $data = $this->select($sql);
      return $data;
    }
  
    //MODIDICAR CAJA
    public function modificarMedida(string $medida, string $medida_corto, int $idMedida){
      $this->idMedida = $idMedida;
      $this->medida_corto = $medida_corto;
      $this->medida = $medida;
      
      $sql = "UPDATE medida SET MEDIDA = ?, NOMBRE_CORTO = ? WHERE ID_MEDIDA = ?";
      $datos = array($this->medida, $this->medida_corto, $this->idMedida);
      $data = $this->save($sql, $datos);
      
      if ($data == 1) {
        $msg = "Ok";
      }else{
        $msg = "Error";
      }  
      
      return $msg;
    }
  
    // ELIMINAR CAJA
    public function eliminarMedida(int $id){
      $this->idMedida = $id; 
  
      $sql = "UPDATE medida SET ESTADO = ? WHERE ID_MEDIDA = ?";
      $datos = array('0', $this->idMedida);
      $data = $this->save($sql, $datos);
      
      if ($data == 1) {
        $msg = "Ok";
      }else{
        $msg = "Error";
      }
  
      return $msg;
    }
  
    // ACTIVAR CAJA
    public function activarMedida(int $id){
      $this->idMedida = $id; 
  
      $sql = "UPDATE medida SET ESTADO = ? WHERE ID_MEDIDA = ?";
      $datos = array('1', $this->idMedida);
      $data = $this->save($sql, $datos);
      
      if ($data == 1) {
        $msg = "Ok";
      }else{
        $msg = "Error";
      }
  
      return $msg;
    }
}