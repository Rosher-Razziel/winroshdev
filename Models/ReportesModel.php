<?php
class ReportesModel extends Query{
  
  private $cambioInicial, $idVenta, $ventaDia, $resurtirTotal, $gananciaTotal, $fecha, $hora, $idUsuario;

  public function __construct(){
    date_default_timezone_set("America/Mexico_City");
    parent::__construct();
  }

  // OBTENER DATOS DE LA EMPRES 
  public function generarCorte(float $cambioInicial, string $fecha){
    $this->cambioInicial = $cambioInicial;
    $this->fecha =$fecha;

    $sql = "SELECT * FROM venta WHERE FECHA_VENTA = '$fecha'";
    $data = $this->selectAll($sql);
    return $data;
  }

  // OBTENER DATOS DE LA EMPRES 
  public function registrarDetalleVenta(int $idVenta){
    $this->idVenta =$idVenta;

    $sql = "SELECT p.PRODUCTO, dv.CANTIDAD, p.PRECIO_COMPRA, dv.PRECIO FROM detalle_venta dv
    INNER JOIN producto p ON dv.ID_PROD = p.ID_PRODUCTO
    WHERE dv.ID_VENTA = '$idVenta'";
    $data = $this->selectAll($sql);
    return $data;
  }

  public function agregarCorte(float $cambioInicial, float $ventaDia, float $resurtirTotal, float $gananciaTotal, string $fecha, string $hora, int $idUsuario){
    $this->cambioInicial = $cambioInicial;
    $this->ventaDia = $ventaDia;
    $this->resurtirTotal = $resurtirTotal;
    $this->gananciaTotal = $gananciaTotal;
    $this->fecha = $fecha;
    $this->hora = $hora;
    $this->idUsuario = $idUsuario;

    $verificar = "SELECT * FROM corte_caja WHERE FECHA_CORTE = '$this->fecha'";
    $existe = $this->select($verificar);

    if (empty($existe)) {
      $sql = 'INSERT INTO corte_caja (SALDO_CAJA, VENTA_DEL_DIA, RESURTIR, GANANCIA_DEL_DIA, FECHA_CORTE, HORA_CORTE, ID_USUARIO) VALUES (?,?,?,?,?,?,?)';
      $datos = array($this->cambioInicial, $this->ventaDia, $this->resurtirTotal, $this->gananciaTotal, $this->fecha, $this->hora, $this->idUsuario);
      $data = $this->save($sql, $datos);
      
      if ($data == 1) {
        $msg = "Ok";
      }else{
        $msg = "Error";
      }  
    }else{
      $idExistente = $existe['ID_CORTE_CAJA'];

      $sql = "UPDATE corte_caja SET SALDO_CAJA = ?, VENTA_DEL_DIA = ?, RESURTIR = ?, GANANCIA_DEL_DIA = ?, HORA_CORTE = ? WHERE ID_CORTE_CAJA = $idExistente";
      
      $datos = array($this->cambioInicial, $this->ventaDia, $this->resurtirTotal, $this->gananciaTotal, $this->hora);
      $data = $this->save($sql, $datos);

      if ($data == 1) {
        $msg = "Ok";
      }else{
        $msg = "Error";
      }  

      // $msg = "Existe";
    }
    return $msg;
  }

  public function getCorteCaja(){
    $sql = "SELECT * FROM corte_caja ORDER BY ID_CORTE_CAJA DESC";
    $data = $this->selectAll($sql);
    return $data;
  }

  public function getProveedores(){
    $sql = "SELECT * FROM proveedor ORDER BY DES_PROVEEDOR DESC";
    $data = $this->selectAll($sql);
    return $data;
  }

  public function verDetallesCorte(int $idCorte, int $idProveedor){

    $sql = "SELECT dv.ID_PROD, p.PRODUCTO, dv.CANTIDAD, p.PRECIO_COMPRA, p.PRECIO_VENTA, dv.SUB_TOTAL, v.FECHA_VENTA, pr.DES_PROVEEDOR FROM venta v
    INNER JOIN detalle_venta dv ON v.ID_VENTA = dv.ID_VENTA
    INNER JOIN producto p ON dv.ID_PROD = p.ID_PRODUCTO
    INNER JOIN proveedor pr ON p.ID_PROV = pr.ID_PROVEEDOR
    WHERE v.FECHA_VENTA = (SELECT cc.FECHA_CORTE FROM corte_caja cc WHERE cc.ID_CORTE_CAJA = $idCorte) AND pr.ID_PROVEEDOR = $idProveedor";
    $data = $this->selectAll($sql);
    return $data;
  }
}