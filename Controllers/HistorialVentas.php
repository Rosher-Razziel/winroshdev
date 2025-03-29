<?php

  class HistorialVentas extends Controller{
    public function __construct(){
      session_start();
      if (empty($_SESSION['activo'])) {
        header('location: ' . base_url);
      }
      parent::__construct();
    }

    public function index(){
      $data = $this->model->getResumenVentas();
      $this->views->getView($this, "index", $data);
    }

    public function getTicketsFecha($fechaTickets){

      if (empty($fechaTickets)) {
        $data = "Los campos estan vacios";
      }else{
        $data = $this->model->obtenerTickets($fechaTickets, 'fecha');
      }    
      echo json_encode($data, JSON_UNESCAPED_UNICODE);
      die();
    }

    public function getTicketsFolio($folioTicket){

      if (empty($folioTicket)) {
        $data = "Los campos estan vacios";
      }else{
        $data = $this->model->obtenerTickets($folioTicket, 'folio');
      }    
      echo json_encode($data, JSON_UNESCAPED_UNICODE);
      die();
    }
  }
?>
