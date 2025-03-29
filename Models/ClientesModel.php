<?php
class ClientesModel extends Query{
  
  private $nombre, $appat, $apmat, $num_tel, $correo, $lim_cred, $fecha_reg, $hora_reg, $idCLiente;

  public function __construct(){
    date_default_timezone_set("America/Mexico_City");
    parent::__construct();
  }

  public function getClientes(){
    $sql = "SELECT * FROM cliente";
    $data = $this->selectAll($sql);
    return $data;
  }

  public function registrarCliente(string $nombre, string $appat, string $apmat, string $num_tel, string $correo, int $lim_cred){
    $this->nombre = $nombre;
    $this->appat = $appat;
    $this->apmat = $apmat;
    $this->num_tel = $num_tel;
    $this->correo = $correo;
    $this->lim_cred = $lim_cred;
    $this->fecha_reg = date("Y-m-d");
    $this->hora_reg = date("H:i:s");
    // $ahora = date("Y-m-d H:i:s");
    
    $verificar = "SELECT * FROM cliente WHERE CORREO = '$this->correo' OR NUMERO_TELEFONICO = '$this->num_tel'";
    $existe = $this->select($verificar);

    if (empty($existe)) {
      $sql = "INSERT INTO cliente (NOMBRE, APPAT, APMAT, NUMERO_TELEFONICO, CORREO, LIMITE_CREDITO, FECHA_REGISTRO, HORA_REGISTRO) VALUES(?,?,?,?,?,?,?,?);
      ";
      $datos = array($this->nombre, $this->appat, $this->apmat, $this->num_tel, $this->correo, $this->lim_cred, $this->fecha_reg, $this->hora_reg);
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

  public function editarCliente(int $id){
    $sql = "SELECT * FROM cliente WHERE ID_CLIENTE = $id";
    $data = $this->select($sql);
    return $data;
  }

  public function modificarUsuario(string $nombre, string $appat, string $apmat, string $num_tel, string $correo, int $lim_cred, int $idCliente){
    $this->idCliente = $idCliente;
    $this->nombre = $nombre;
    $this->appat = $appat;
    $this->apmat = $apmat;
    $this->num_tel = $num_tel;
    $this->correo = $correo;
    $this->lim_cred = $lim_cred;
    // $this->fecha_reg = date("Y-m-d");
    // $this->hora_reg = date("H:i:s");
    
    $sql = "UPDATE cliente SET NOMBRE = ?, APPAT = ?, APMAT = ?, NUMERO_TELEFONICO = ?, CORREO = ?, LIMITE_CREDITO = ? WHERE ID_CLIENTE = ?";
    $datos = array($this->nombre, $this->appat, $this->apmat, $this->num_tel, $this->correo, $this->lim_cred, $this->idCliente);
    $data = $this->save($sql, $datos);
    
    if ($data == 1) {
      $msg = "Ok";
    }else{
      $msg = "Error";
    }  
    
  return $msg;
  }

  public function eliminarCliente(int $id){
    $this->idCliente = $id; 

    $sql = "UPDATE cliente SET ESTADO = ? WHERE ID_CLIENTE = ?";
    $datos = array('0', $this->idCliente);
    $data = $this->save($sql, $datos);
    
    if ($data == 1) {
      $msg = "Ok";
    }else{
      $msg = "Error";
    }

    return $msg;
  }

  public function activarCliente(int $id){
    $this->idCliente = $id; 

    $sql = "UPDATE cliente SET ESTADO = ? WHERE ID_CLIENTE = ?";
    $datos = array('1', $this->idCliente);
    $data = $this->save($sql, $datos);
    
    if ($data == 1) {
      $msg = "Ok";
    }else{
      $msg = "Error";
    }

    return $msg;
  }

}