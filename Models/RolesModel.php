<?php
class RolesModel extends Query{
  
  private $rol, $idRol;

  public function __construct(){
    parent::__construct();
  }

  // OBTENER CATEGORIAS
  public function getRoles(){
    $sql = "SELECT * FROM rol";
    $data = $this->selectAll($sql);
    return $data;
  }

  // REGISTRAR CATEGORIA
  public function registrarRol(string $rol){
    $this->rol = $rol;
    $fecha = date('Y-m-d');

    $verificar = "SELECT * FROM rol WHERE DESC_ROL = '$this->rol'";
    $existe = $this->select($verificar);

    if (empty($existe)) {
      $sql = "INSERT INTO rol (DESC_ROL, ESTADO, FECHA_REGISTRO) VALUES (?,?,?)";
      $datos = array($this->rol, '1', $fecha);
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

   // EDITAR CATEGORIA
   public function editarRol(int $id){
    $sql = "SELECT * FROM rol WHERE ID_ROL = $id";
    $data = $this->select($sql);
    return $data;
  }

  //MODIDICAR CATEGORIA
  public function modificarRol(string $rol, int $idRol){
    $this->idRol = $idRol;
    $this->rol = $rol;
    
    $sql = "UPDATE rol SET DESC_ROL = ? WHERE ID_ROL = ?";
    $datos = array($this->rol, $this->idRol);
    $data = $this->save($sql, $datos);
    
    if ($data == 1) {
      $msg = "Ok";
    }else{
      $msg = "Error";
    }  
    
    return $msg;
  }

   // ELIMINAR CAJA
   public function eliminarRol(int $id){
    $this->idRol = $id; 

    $sql = "UPDATE rol SET ESTADO = ? WHERE ID_ROL = ?";
    $datos = array('0', $this->idRol);
    $data = $this->save($sql, $datos);
    
    if ($data == 1) {
      $msg = "Ok";
    }else{
      $msg = "Error";
    }

    return $msg;
  }

  // ACTIVAR CAJA
  public function activarRol(int $id){
    $this->idRol = $id; 

    $sql = "UPDATE rol SET ESTADO = ? WHERE ID_ROL = ?";
    $datos = array('1', $this->idRol);
    $data = $this->save($sql, $datos);
    
    if ($data == 1) {
      $msg = "Ok";
    }else{
      $msg = "Error";
    }  

    return $msg;
  }

}