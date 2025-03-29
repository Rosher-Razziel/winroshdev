<?php
class PerfilModel extends Query{
  
  public function __construct(){
    parent::__construct();
  }

  public function getUser(int $id){
      $sql = "SELECT u.USUARIO, u.NOMBRE, u.AP_PAT, u.AP_MAT, u.CLAVE, r.DESC_ROL , c.CAJA FROM usuario AS u
      INNER JOIN caja AS c ON u.ID_CAJA = c.ID_CAJA
      INNER JOIN rol AS r ON u.ID_ROL = r.ID_ROL
      WHERE ID_USUARIO = $id";
      $data = $this->select($sql);
      return $data;
  }


  public function modificarClave(string $clave, int $idUsuario){
    $this->idUsuario = $idUsuario;
    $this->clave = $clave;

    $sql = "UPDATE usuario SET CLAVE = ? WHERE ID_USUARIO = ?";
    $datos = array($this->clave, $this->idUsuario);
    $data = $this->save($sql, $datos);
    
    if ($data == 1) {
      $msg = "Ok";
    }else{
      $msg = "Error";
    }  
    
    return $msg;
  }

  public function getClave (int $idUsuario){
    if($idUsuario != ''){
      $sql = "SELECT CLAVE FROM usuario WHERE ID_USUARIO = $idUsuario";
      $data = $this->select($sql);
      return $data;
    }else{
      return "Error";
    }

  }
} 