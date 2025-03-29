<?php
class HistorialVentasModel extends Query{

  public function __construct(){
    date_default_timezone_set("America/Mexico_City");
    parent::__construct();
  }

  public function getResumenVentas() {
    // Obtener la fecha actual
    $fecha = date('Y-m-d');
    
    // Consultas SQL
    $sqlTickets = "SELECT * FROM venta WHERE FECHA_VENTA = '$fecha' ORDER BY ID_VENTA DESC";
    $sqlSumaTotal = "SELECT SUM(TOTAL_TICKET) AS SUMATOTAL FROM venta WHERE FECHA_VENTA = '$fecha'";
    $sqlDatosVentasDia = "SELECT FECHA_VENTA, SUM(TOTAL_TICKET) AS TOTAL_TICKET FROM venta GROUP BY FECHA_VENTA DESC LIMIT 30";
    
    // Ejecutamos las consultas
    $tickets = $this->selectAll($sqlTickets);
    $sumaTotal = $this->select($sqlSumaTotal)['SUMATOTAL'] ?? 0;
    $ventasDia = $this->selectAll($sqlDatosVentasDia);
    
    // Verificación de datos para el cálculo de proyección
    $n = count($ventasDia) - 2;

    if ($n <= 0) {
      $nuevaProyeccion = 0; // Si no hay suficientes datos para calcular la proyección
    } else {
      $x = [];
      $y = [];

      // Asignar valores de x (días) e y (ventas por día)
      for ($i = 0; $i < $n; $i++) {
        $x[$i] = $i + 1;
        $y[$i] = $ventasDia[$i]['TOTAL_TICKET'];
      }
      
      // Cálculos para regresión lineal
      $sumaX = array_sum($x);
      $sumaY = array_sum($y);
      $sumaXporX = 0;
      $sumaXporY = 0;
      
      for ($i = 0; $i < $n; $i++) {
        $sumaXporX += ($x[$i] * $x[$i]);
        $sumaXporY += ($x[$i] * $y[$i]);
      }
          
      // Cálculo de los coeficientes de la regresión (pendiente w y constante b)
      $w = round((($n * $sumaXporY) - ($sumaX * $sumaY)) / (($n * $sumaXporX) - ($sumaX * $sumaX)), 2);
      $b = round(($sumaY - ($w * $sumaX)) / $n, 2);
        
      // Proyección de la próxima venta
      $nuevaProyeccion = round(($w * ($n + 1)) + $b, 2);
    }
      
    // Retornar los datos combinados
    return [
      'tickets' => $tickets,
      'sumaTotal' => $sumaTotal,
      'proyeccionVentaDia' => $nuevaProyeccion
    ];
  }

  public function obtenerTickets(string $param, string $tipo = 'fecha') {
    // Definir la consulta SQL basada en el tipo de búsqueda
    if ($tipo === 'fecha') {
      $sql = "SELECT * FROM venta WHERE FECHA_VENTA = '$param' ORDER BY ID_VENTA DESC";
    } elseif ($tipo === 'folio') {
      $sql = "SELECT * FROM venta WHERE FOLIO_TICKET LIKE '%$param%' ORDER BY ID_VENTA DESC";
    }

    // Ejecutar la consulta
    $data = $this->selectAll($sql);
    return $data;
}

}