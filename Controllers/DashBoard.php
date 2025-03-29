<?php

class DashBoard extends Controller
{
  public function __construct()
  {
    // Iniciar sesión solo si no ha sido iniciada
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }
    if (empty($_SESSION['activo'])) {
      header('location: ' . base_url);
      exit;
    }
    parent::__construct();
  }

  public function index(){
    $this->views->getView($this, "index", $this->model->getResumenDatos());
  }

  public function obtenerDatos(){
      $this->respuestaJson($this->model->getDatosProductoMasVendido());
  }

  public function obtenerProdPocoStock(){
    $this->respuestaJson($this->model->getDatosPocoStock());
  }

  public function obtenerVentasDia(){
    $this->respuestaJson($this->model->getDatosVentasDia());
  }

  public function obtenerVentasSemana(){
    $this->respuestaJson($this->model->getDatosVentasSemana());
  }

  public function obtenerVentasAnio(){
    $this->respuestaJson($this->model->getDatosVentasAnio());
  }

  public function obtenerGanancias(){
    $this->respuestaJson($this->model->getDatosGanancias());
  }

  private function respuestaJson($data){
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
  }
}