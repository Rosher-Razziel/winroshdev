<?php
class UsuariosModel extends Query{
  
  private $nombre, $appat, $apmat, $usuario, $clave, $id_caja, $id_rol, $idUsuario;

  public function __construct(){
    parent::__construct();
  }
  public function getUsuario(string $usuario){
    $sql = "SELECT * FROM usuario WHERE USUARIO = ? AND ESTADO = ?";
    $datos = [$usuario, 1];
    return $this->select_v2($sql, $datos);
  }
  public function getUsuarios(){
    $sql = "SELECT U.*, C.CAJA, R.DESC_ROL FROM usuario U INNER JOIN caja C ON U.ID_CAJA = C.ID_CAJA INNER JOIN rol R ON U.ID_ROL = R.ID_ROL";
    return $this->selectAll_v2($sql);
  }
  public function getData(){
    $sql = "SELECT * FROM {table} WHERE ESTADO = ?";
    $data = [];
    $tables = ['caja', 'rol'];
  
    foreach ($tables as $table) {
      $data[$table] = $this->selectAll_v2(str_replace('{table}', $table, $sql), [1]);
    }
  
    return $data;
  }
  public function registrarUsuario(string $usuario, string $nombre, string $appat, string $apmat, string $clave, int $id_rol, int $id_caja){
    $this->usuario = $usuario;
    $this->nombre = $nombre;
    $this->appat = $appat;
    $this->apmat = $apmat;
    $this->clave = $clave;
    $this->id_caja = $id_caja;
    $this->id_rol = $id_rol;
    
    $verificar = "SELECT * FROM usuario WHERE USUARIO = '$usuario'";
    $existe = $this->select($verificar);

    if (empty($existe)) {
      $sql = "INSERT INTO usuario (USUARIO, NOMBRE, AP_PAT, AP_MAT, CLAVE, ID_ROL, ID_CAJA, ESTADO) VALUES (?,?,?,?,?,?,?,?)";
      $datos = array($this->usuario, $this->nombre, $this->appat, $this->apmat, $this->clave, $this->id_rol, $this->id_caja, '1');
      $data = $this->save($sql, $datos);
      $respuesa = $data == 1 ? 'Ok' : 'Error';
    }else{
      $respuesa = "Existe";
    }
    return $respuesa;
  }
  public function editarUser(int $id){
    if($id != 1){
      $sql = "SELECT * FROM usuario WHERE ID_USUARIO = $id";
      $data = $this->select($sql);
      return $data;
    }else{
      return "Error";
    }
  }
  public function modificarUsuario(string $usuario, string $nombre, string $appat, string $apmat, int $id_rol, int $id_caja, int $idUsuario){
    $this->idUsuario = $idUsuario;
    $this->usuario = $usuario;
    $this->nombre = $nombre;
    $this->appat = $appat;
    $this->apmat = $apmat;
    $this->id_caja = $id_caja;
    $this->id_rol = $id_rol;
    
    $sql = "UPDATE usuario SET USUARIO = ?, NOMBRE = ?, AP_PAT = ?, AP_MAT = ?, ID_ROL = ?, ID_CAJA = ? WHERE ID_USUARIO = ?";
    $datos = array($this->usuario, $this->nombre, $this->appat, $this->apmat, $this->id_rol, $this->id_caja, $this->idUsuario);
    $data = $this->save($sql, $datos);
    $respuesa = $data == 1 ? 'Ok' : 'Error';
    return $respuesa;
  }
  public function cambiarEstadoUser(int $id, int $estado){
    if($id != 1){
      $sql = "UPDATE usuario SET ESTADO = ? WHERE ID_USUARIO = ?";
      $datos = [$estado, $id];
      $data = $this->save($sql, $datos);
      $respuesa = $data == 1 ? 'Ok' : 'Error';
    }else{
      $respuesa ="Error";
    }
    return $respuesa;
  }
  // PENDIENTE POR TERMINAR
  public function permisosUser(int $id){
    $sql = "SELECT * FROM detalle_permisos";
    $data = $this->selectAll($sql);
    $data_3 = [];

    $sql = "SELECT pu.ID_USUARIO, dp.PERMISO, dp.ID_DETALLE_PERMISOS FROM permisos_usuarios pu
    INNER JOIN detalle_permisos dp ON pu.ID_PERMISO = dp.ID_DETALLE_PERMISOS
    WHERE pu.ID_USUARIO = $id"; 
    $data_2 = $this->selectAll($sql);

    $n = count($data);
    $m = count($data_2);

    for ($i = 0; $i < $m; $i++) {
      for($j = 0; $j <$n; $j++ ){
        $nombre = $data[$j]['PERMISO'];
        if($data_2[$i]['ID_DETALLE_PERMISOS'] == $data[$j]['ID_DETALLE_PERMISOS']){
          $data_3[$nombre] = 1;
        }else{
          if ($data_3[$nombre] == 1) {
            $data_3[$nombre] = 1;
          }else{
            $data_3[$nombre] = 0;
          }  
        }
      }
    }
    return $data_3;
  }
}