<?php
  class Compras extends Controller{
    public function __construct(){
      session_start();
      header('Content-Type: text/html; charset=UTF-8');  

      if (empty($_SESSION['activo'])) {
        header('location: ' . base_url);
      }
      parent::__construct();
    }

    public function index(){
      $data['Proveedores'] = $this->model->getProveedores();
      $this->views->getView($this, "index", $data);
    }
    //BUSCAR PRODUCTOS DE ESTE PROVEEDOR
    public function buscarProductosProv($idProv){
      $data = $this->model->buscarProductosProv($idProv);
      echo json_encode($data, JSON_UNESCAPED_UNICODE);
      die();
    }

    // FUNCION PARA REGISTRAR USUARIOS
    public function registrar(){

      $idProveedor = $_POST['idProveedor'];
      $idFolio = $_POST['idFolio'];
      $totalP = $_POST['totalP'];
      $productos = $_POST['productos'];
      $idUsuario = $_SESSION['Id_usuario'];

      if (empty($idProveedor) || empty($idFolio) || empty($productos)) {
        $msg = "Los campos estan vacios";
      }else{

        $data = $this->model->registrarPedidoProveedor($idProveedor, $idFolio, $productos, $totalP);
        $ultimoID = $this->model->getUltimoId();

        if ($data == "Ok") {
          foreach ($productos as &$producto) {
            if ($producto['cantidad'] > 0) {
              $data = $this->model->registrarDetallePedido($producto['idProducto'], $producto['cantidad'], $producto['compra'], $producto['subtotal'], $idUsuario, $ultimoID['ID_PEDIDO']);
            }
          }
          if ($data == "Ok") {
            $msg = ['msg' => 'Correcto', 'idPedido' => $ultimoID['ID_PEDIDO']];
          }else{
            $msg = ['msg' => 'Error', 'idPedido' => $ultimoID['ID_PEDIDO']];
          }
        }else{
          $msg = "Error al registrar al producto";
        }
      }    
      echo json_encode($msg, JSON_UNESCAPED_UNICODE);
      exit();
    }

    //GENERAR PDF
    public function generarPdf($idPedido){

      $dataEmpresa = $this->model->getEmpresa();
      $dataProveedor = $this->model->getProveedor($idPedido);
      $dataDetallePedido = $this->model->getDetallePedido($idPedido);
  
      // Evitar cargar repetidamente la misma clase
      require('Libraries/fpdf/fpdf.php');
      header('Content-Type: text/html; charset=UTF-8'); 

      // Utilizar variables más legibles para el tamaño de la página
      $pdf = new FPDF('P','mm', array(220, 270));
      $pdf->AddPage();
      $pdf->SetTitle('La Ventanita.pdf');
      
      // Título e imagen del encabezado
      $pdf->SetFont('Arial', 'B', 16);
      $pdf->Image(base_url . 'Assets/img/WR.png', 10, 12, 30, 10);
      $pdf->Cell(0, 15, utf8_decode($dataEmpresa[0]['NOMBRE_EMPRESA']), 0, 1, 'C');
      
      // Fecha actual
      $pdf->SetFont('Arial','',10);
      $meses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
      $mesNumero = date('n') - 1; // date('n') devuelve el mes sin ceros, va de 1 a 12}
      $fechaActual = date('d') . ' de ' . $meses[$mesNumero] . ' del ' . date('Y');
      $pdf->Cell(0, 10, $fechaActual, 0, 1, 'R');
      
      // Datos de la empresa
      $this->agregarDatosSeccion($pdf, 'DATOS DE EMPRESA', [
        ['DIRECCION: ', $dataEmpresa[0]['DIRECCION'], 'FOLIO: ', 'F-012345'],
        ['CORREO: ', $dataEmpresa[0]['CORREO_EMPRESA'], 'TELEFONO: ', $dataEmpresa[0]['NUMERO_EMPRESA']],
      ]);

      // Datos del proveedor
      $this->agregarDatosSeccion($pdf, 'DATOS DE PROVEEDOR', [
        ['NOMBRE: ', $dataProveedor[0]['NOMBRE'] . ' ' . $dataProveedor[0]['APPAT'] . ' ' . $dataProveedor[0]['APMAT'], 'PROVEEDOR: ', $dataProveedor[0]['DES_PROVEEDOR']],
        ['CORREO: ', $dataProveedor[0]['CORREO'], 'TELEFONO: ', $dataProveedor[0]['NUMERO_TELEFONO']],
      ]);

      // Encabezados de la tabla
      $header = ['Cantidad', 'Nombre Producto', 'Precio Compra', 'Sub Total'];
      $w = [30, 110, 30, 30];
      
      $pdf->SetFillColor(0, 193, 137);
      $pdf->SetTextColor(255);
      $pdf->SetDrawColor(128, 0, 0);
      $pdf->SetLineWidth(.3);
      $pdf->SetFont('Arial', 'B');
      
      foreach ($header as $i => $col) {
          $pdf->Cell($w[$i], 7, $col, 1, 0, 'C', true);
      }
      $pdf->Ln();

      // Restaurar colores y fuentes
      $pdf->SetFillColor(224, 235, 255);
      $pdf->SetTextColor(0);
      $pdf->SetFont('');

      // Cuerpo de la tabla str_pad($row['CANTIDAD'], 2, "0", STR_PAD_LEFT) . "Pz"
      $fill = false;
      foreach ($dataDetallePedido as $row) {
          $pdf->Cell($w[0], 6, str_pad($row['CANTIDAD'], 2, "0", STR_PAD_LEFT) . " pzas", 'LR', 0, 'C', $fill);
          $pdf->Cell($w[1], 6, utf8_decode($row['PRODUCTO']), 'LR', 0, 'L', $fill);
          $pdf->Cell($w[2], 6, '$ ' . number_format($row['PRECIO'], 2, '.', ','), 'LR', 0, 'C', $fill);
          $pdf->Cell($w[3], 6, '$ ' . number_format($row['SUB_TOTAL'], 2, '.', ','), 'LR', 0, 'C', $fill);
          $pdf->Ln();
          $fill = !$fill;
      }

      // Total del pedido
      $pdf->SetFont('Arial', 'B', 10);
      $pdf->Cell($w[0], 6, '', 'LR', 0, 'L', $fill);
      $pdf->Cell($w[1], 6, '', 'LR', 0, 'R', $fill);
      $pdf->Cell($w[2], 6, 'TOTAL', 'LR', 0, 'C', $fill);
      $pdf->Cell($w[3], 6, '$ ' . number_format($dataProveedor[0]['TOTAL_PEDIDO'], 2, '.', ','), 'LR', 0, 'C', $fill);
      $pdf->Ln();

      // Línea de cierre
      $pdf->Cell(array_sum($w), 0, '', 'T');
      $pdf->Output();
    }

    private function agregarDatosSeccion($pdf, $titulo, $datos){
      $pdf->SetFont('Arial', 'B', 10);
      $pdf->Cell(0, 5, $titulo, 1, 1, 'C');
      
      foreach ($datos as $dato) {
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(30, 5, $dato[0], 1, 0, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(110, 5, utf8_decode($dato[1]), 1, 0, 'L');

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(30, 5, $dato[2], 1, 0, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(30, 5, utf8_decode($dato[3]), 1, 0, 'L');

        $pdf->Ln();
      } 
    }
  }
?>