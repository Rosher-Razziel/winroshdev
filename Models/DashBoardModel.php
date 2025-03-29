<?php 
class DashBoardModel extends Query {
    public function __construct() {
      parent::__construct();
    }

    public function getResumenDatos() {
       // Consultas SQL
      $sqlCountUsuarios = "SELECT * FROM usuario";
      $sqlCountClientes = "SELECT * FROM cliente";
      $sqlCountProductos = "SELECT * FROM producto";
      $sqlCountVentas = "SELECT * FROM venta";

      $sqlInvTotal = "SELECT SUM(PRECIO_VENTA * EXISTENCIAS) AS SUMATOTAL FROM producto";
      $sqlInvReal = "SELECT SUM(PRECIO_COMPRA * EXISTENCIAS) AS SUMATOTAL FROM producto";
      $sqlUtilidad = "SELECT SUM((PRECIO_VENTA * EXISTENCIAS) - (PRECIO_COMPRA * EXISTENCIAS)) AS SUMATOTAL FROM producto";
      $sqlGananciaTotal = "SELECT SUM(GANANCIA_DEL_DIA)  as GANANCIA FROM corte_caja";
      
      // Ejecutamos las consultas
      $CountUsuarios = $this->selectAll($sqlCountUsuarios);
      $CountClientes = $this->selectAll($sqlCountClientes);
      $CountProductos = $this->selectAll($sqlCountProductos);
      $CountVentas = $this->selectAll($sqlCountVentas);

      $InvTotal = $this->select($sqlInvTotal)['SUMATOTAL'] ?? 0;
      $InvReal = $this->select($sqlInvReal)['SUMATOTAL'] ?? 0;
      $Utilidad = $this->select($sqlUtilidad)['SUMATOTAL'] ?? 0;
      $GananciaTotal = $this->select($sqlGananciaTotal)['GANANCIA'] ?? 0;

      // Retornar los datos combinados
      return [
        'CountUsuarios' => $CountUsuarios,
        'CountClientes' => $CountClientes,
        'CountProductos' => $CountProductos,
        'CountVentas' => $CountVentas,
        'InvTotal' => $InvTotal,
        'InvReal' => $InvReal,
        'Utilidad' => $Utilidad,
        'GananciaTotal' => $GananciaTotal
      ];
    }

    public function getDatosProductoMasVendido() {
      return $this->obtenerDatosConLimite(
        "SELECT p.PRODUCTO, SUM(dv.CANTIDAD) AS TOTALVENTAS 
        FROM detalle_venta dv
        INNER JOIN producto p ON dv.ID_PROD = p.ID_PRODUCTO
        GROUP BY dv.ID_PROD
        ORDER BY TOTALVENTAS DESC", 15);
    }

    public function getDatosPocoStock() {
      return $this->obtenerDatosConLimite(
        "SELECT PRODUCTO, EXISTENCIAS 
        FROM producto 
        WHERE EXISTENCIAS < EXISTENCIA_MINIMA", 10);
    }

    public function getDatosVentasDia() {
      return $this->obtenerDatosConLimite(
        "SELECT FECHA_VENTA, SUM(TOTAL_TICKET) AS TOTAL_TICKET 
        FROM venta 
        GROUP BY FECHA_VENTA 
        ORDER BY FECHA_VENTA DESC", 15);
    }

    public function getDatosVentasSemana() {
      $sql = "SELECT yearweek(FECHA_VENTA) AS SEMANA, SUM(TOTAL_TICKET) AS TOTAL_SEMANA 
        FROM venta 
        GROUP BY SEMANA 
        ORDER BY SEMANA DESC 
        LIMIT 4";
      return $this->selectAll($sql);
    }

    public function getDatosVentasAnio() {
      $year = date('Y');
      $sql = "SELECT MONTH(FECHA_VENTA) AS MES, SUM(TOTAL_TICKET) AS TOTAL 
        FROM venta 
        WHERE YEAR(FECHA_VENTA) = $year 
        GROUP BY MES 
        ORDER BY MES ASC";
      return $this->selectAll($sql);
    }

    public function getDatosGanancias() {
      return $this->obtenerDatosConLimite("SELECT FECHA_CORTE, GANANCIA_DEL_DIA 
        FROM corte_caja 
        GROUP BY FECHA_CORTE 
        ORDER BY FECHA_CORTE DESC", 15);
    }

    private function obtenerDatosConLimite($sql, $limite) {
      $sql .= " LIMIT $limite";
      return $this->selectAll($sql);
    }
}
