<?php

  class Fiados extends Controller{
    public function __construct(){
      session_start();
      if (empty($_SESSION['activo'])) {
        header('location: ' . base_url);
      }
      parent::__construct();
    }

    public function index(){
      $data['Tickets'] = $this->model->getTickets();
      $data['SumaTotal'] = $this->model->getSumaTickets();
      $data['VentaDia'] = $this->model->getDatosVentasDia();
      $this->views->getView($this, "index", $data);
    }

    public function getTicketsFecha($fechaTickets){

      if (empty($fechaTickets)) {
        $data = "Los campos estan vacios";
      }else{
        $data = $this->model->obtenerTicketsPorFecha($fechaTickets);
      }    
      echo json_encode($data, JSON_UNESCAPED_UNICODE);
      die();
    }

    public function getTicketsFolio($folioTicket){

      if (empty($folioTicket)) {
        $data = "Los campos estan vacios";
      }else{
        $data = $this->model->obtenerTicketsPorFolio($folioTicket);
      }    
      echo json_encode($data, JSON_UNESCAPED_UNICODE);
      die();
    }
  }
?>
