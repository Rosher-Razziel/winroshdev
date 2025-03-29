<?php
  class Reportes extends Controller{
    public function __construct(){
      session_start();
      if (empty($_SESSION['activo'])) {
        header('location: ' . base_url);
      }
      parent::__construct();
    }

    public function index(){
      $this->views->getView($this, "index");
    }

    public function generarCorte(){
      // print_r($_POST);
      $saldoIniciar = $_POST['saldoIniciar'];
      $fecha =  date('Y-m-d');
      $hora = date('H:m:s');
      $idUsuario = $_SESSION['Id_usuario'];
      $gananciaTicket = 0;
      $resurtirTicket = 0;
      $gananciaTotal = 0;
      $resurtirTotal = 0;
      $ventaDia = 0;
      $data = $this->model->generarCorte($saldoIniciar, $fecha);

      foreach ($data as &$row) {
        $detalleVenta = $this->model->registrarDetalleVenta($row['ID_VENTA']);
        foreach ($detalleVenta as &$fila){
          $gananciaTicket += ($fila['CANTIDAD']*$fila['PRECIO']) - ($fila['CANTIDAD']*$fila['PRECIO_COMPRA']);
          $resurtirTicket += $fila['CANTIDAD']*$fila['PRECIO_COMPRA'];
          $ventaDia += $fila['CANTIDAD']*$fila['PRECIO'];
        }
        $gananciaTotal += $gananciaTicket;
        $resurtirTotal += $resurtirTicket;

        $gananciaTicket = 0;
        $resurtirTicket = 0;
      }

      $insertarCorte = $this->model->agregarCorte($saldoIniciar, $ventaDia, $resurtirTotal, $gananciaTotal, $fecha, $hora, $idUsuario);

      echo json_encode($insertarCorte, JSON_UNESCAPED_UNICODE);
      die();
    }

    public function listar(){
      $data = $this->model->getCorteCaja();

      for ($i=0; $i < count($data); $i++) { 

        $data[$i]['ACCIONES'] =  '<div>
        <button class="btn btn-primary mb-2" disabled type="button" onclick="btnEditarCorte('.$data[$i]['ID_CORTE_CAJA'].')"><i class="fa-solid fa-pen-to-square"></i></button>
        <button class="btn btn-warning mb-2" type="button" onclick="btnVerDetalles('.$data[$i]['ID_CORTE_CAJA'].')"><i class="fa-solid fa-eye"></i></button>
        </div>';
      }

      echo json_encode($data, JSON_UNESCAPED_UNICODE);
      die();
    }

    public function verProveedores(){
      $idCorte = $_POST['idCorte'];
      $data = $this->model->getProveedores();
      echo json_encode($data, JSON_UNESCAPED_UNICODE);
      die();
    }

    public function verDetalles(){
      $idCorte = $_POST['idCorte'];
      $idProveedor = $_POST['idProveedor'];
      $data = $this->model->verDetallesCorte($idCorte, $idProveedor);
      echo json_encode($data, JSON_UNESCAPED_UNICODE);
      die();

    }

  }
?>