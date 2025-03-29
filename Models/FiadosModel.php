<?php
class FiadosModel extends Query{
  
  private $fecha, $folio;

  public function __construct(){
    date_default_timezone_set("America/Mexico_City");
    parent::__construct();
  }

  public function getTickets(){
    $fecha = date('Y-m-d');
    $sql = "SELECT * FROM venta WHERE FECHA_VENTA = '$fecha' ORDER BY ID_VENTA DESC";
    $data = $this->selectAll($sql);
    return $data;
  }

  public function getSumaTickets(){
    $fecha = date('Y-m-d');
    $sql = "SELECT SUM(TOTAL_TICKET) AS SUMATOTAL FROM venta WHERE FECHA_VENTA = '$fecha'";
    $data = $this->selectAll($sql);
    return $data;
  }

  public function obtenerTicketsPorFecha(string $fecha){
    $this->$fecha = $fecha;
    $sql = "SELECT * FROM venta WHERE FECHA_VENTA = '$fecha' ORDER BY ID_VENTA DESC";
    $data = $this->selectAll($sql);
    return $data;
  }

  public function obtenerTicketsPorFolio(string $folio){
    $this->$folio = $folio;
    $sql = "SELECT * FROM venta WHERE FOLIO_TICKET LIKE '%$folio%' ORDER BY ID_VENTA DESC";
    $data = $this->selectAll($sql);
    return $data;
  }

  public function getDatosVentasDia(){
    $sql = "SELECT FECHA_VENTA, SUM(TOTAL_TICKET) AS TOTAL_TICKET FROM venta GROUP BY FECHA_VENTA ASC LIMIT 30";
    $data = $this->selectAll($sql);
    
    $n = count($data);

    for ($i=0; $i < $n; $i++) { 
      $x[$i] = $i+1;
      $y[$i] = $data[$i]['TOTAL_TICKET'];
    }

    $sumaX = array_sum($x);
    $sumaY = array_sum($y);
    $sumaXporX = 0;
    $sumaXporY = 0;
    for ($i = 0; $i < $n; $i++) {
        $sumaXporX = $sumaXporX + ($x[$i] * $x[$i]);
        $sumaXporY = $sumaXporY + ($x[$i] * $y[$i]);
    }
    $w = round((($n * $sumaXporY) - ($sumaX * $sumaY)) / (($n * $sumaXporX) - ($sumaX * $sumaX)), 2);
    $b = round(($sumaY - ($w * $sumaX)) / $n, 2);

    $nuevaP = round(($w*($n+1)) + $b, 2);

    return $nuevaP;
  }

}