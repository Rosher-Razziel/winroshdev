<?php

class Ventas extends Controller {
  public function __construct() {
    session_start();
    if (empty($_SESSION['activo'])) {
      header('location: ' . base_url);
      exit(); // Evitar que el código continúe ejecutándose después de redireccionar.
    }
    parent::__construct();
  }

    public function index() {
      $this->views->getView($this, "index");
    }

    public function autocomplete() {
      if (isset($_POST['codigo']) && !empty($_POST['codigo'])) {
        $codigo = $_POST['codigo'];
        $data = $this->model->getProductos($codigo);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
      } else {
        echo json_encode(['error' => 'Código vacío'], JSON_UNESCAPED_UNICODE);
      }
      die();
    }

    public function agregar() {
        if (isset($_POST['codigo']) && !empty($_POST['codigo'])) {
          $codigo = $_POST['codigo'];
          $data = $this->model->obtenerProducto($codigo);
          echo json_encode($data, JSON_UNESCAPED_UNICODE);
        } else {
          echo json_encode(['error' => 'Código vacío'], JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function vender() {
      // Sanitización y validación de entradas
      $totalVenta = isset($_POST['totalVenta']) ? floatval($_POST['totalVenta']) : 0;
      $cambio = isset($_POST['cambio']) ? floatval($_POST['cambio']) : 0;
      $pagoCon = isset($_POST['pagoCon']) ? floatval($_POST['pagoCon']) : 0;
      $productosVenta = isset($_POST['productosVenta']) ? $_POST['productosVenta'] : [];

      if (empty($totalVenta) || empty($productosVenta)) {
        $msg = "Los campos están vacíos";
        echo json_encode(['msg' => $msg], JSON_UNESCAPED_UNICODE);
        die();
      }

      $ultimoID = $this->model->getUltimoId('venta');
      $folio = 'F-' . str_pad($ultimoID['ID_VENTA'] + 1, 7, '0', STR_PAD_LEFT);
      $idUsuario = $_SESSION['Id_usuario'];

      $data = $this->model->ingresarVenta($folio, $pagoCon, $totalVenta, $cambio, $idUsuario);
      $ultimoIdVenta = $ultimoID['ID_VENTA'] + 1;
      
      if ($data == "Ok") {
        foreach ($productosVenta as $producto) {
          $productoId = $producto[4];
          $cantidad = intval($producto[3]);
          $precio = floatval($producto[2]);
          $subTotal = $cantidad * $precio;

          $this->model->registrarDetalleVenta($productoId, $cantidad, $precio, $subTotal, $ultimoIdVenta);
        }
        $msg = ["msg" => "Ok", "idVenta" => $ultimoIdVenta];
      } else {
        $msg = "Error al registrar el producto";
      }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    // GENERAR PDF
    public function generarPdf($idVenta) {
      $dataEmpresa = $this->model->getEmpresa();
      $dataDetallePedido = $this->model->getDetalleVenta($idVenta);

      require('Libraries/fpdf/fpdf.php');

      $pdf = new FPDF('P', 'mm', [60, 150]);
      $pdf->AddPage();
      $pdf->SetTitle('La Ventanita_F-' . $idVenta . '.pdf');
      $pdf->SetFont('Arial', 'B', 16);
      $pdf->Image(base_url . 'Assets/img/WR.png', 14, 2, 29, 10);
      $pdf->Cell(0, 15, utf8_decode($dataEmpresa[0]['NOMBRE_EMPRESA']), 0, 1, 'C');

      $pdf->SetFont('Arial', '', 10);
      $mes = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
      $mesNumero = intval(date('m')) - 1;

      $pdf->Cell(0, 5, date('d') . ' de ' . $mes[$mesNumero] . ' del ' . date('Y'), 0, 1, 'C');

      $pdf->SetFont('Arial', 'B', 8);
      $header = ['Cant.', 'Descrip.', 'Prec.', 'S.Total'];
      $w = [8, 15, 10, 10];

      foreach ($header as $i => $col) {
        $pdf->Cell($w[$i], 5, $col, 0, 0, 'L');
      }
      $pdf->Ln();
      $pdf->Cell(43, 2, '', 'T');
      $pdf->Ln();

      $pdf->SetFont('');
      foreach ($dataDetallePedido as $row) {
        $pdf->Cell($w[0], 3, $row['CANTIDAD']);
        $pdf->Cell($w[1], 3, substr($row['PRODUCTO'], 0, 20), 0, 1);
        $pdf->Cell(25, 3, '$ ' . number_format($row['PRECIO'], 2, '.', ','), 0, 0, 'R');
        $pdf->Cell(15, 3, '$ ' . number_format($row['SUB_TOTAL'], 2, '.', ','), 0, 0, 'R');
        $pdf->Ln();
      }
      $pdf->Cell(43, 2, '', 'T');
      $pdf->Ln();

      $this->agregarInfoPago($pdf, $w, $row);

      $pdf->Output();
    }

    private function agregarInfoPago($pdf, $w, $row) {
      $pdf->Cell($w[0], 3, '');
      $pdf->Cell($w[1], 3, '', 0, 1);
      $pdf->Cell(25, 3, 'Pago Con', 0, 0, 'R');
      $pdf->Cell(15, 5, '$ ' . number_format($row['PAGO_CON'], 2, '.', ','), 0, 0, 'R');
      $pdf->Ln();
      $pdf->Cell(25, 3, 'Total', 0, 0, 'R');
      $pdf->Cell(15, 5, '$ ' . number_format($row['TOTAL_TICKET'], 2, '.', ','), 0, 0, 'R');
      $pdf->Ln();
      $pdf->Cell(25, 3, 'Cambio', 0, 0, 'R');
      $pdf->Cell(15, 5, '$ ' . number_format($row['CAMBIO'], 2, '.', ','), 0, 0, 'R');
      $pdf->Ln();
    }
}
?>
