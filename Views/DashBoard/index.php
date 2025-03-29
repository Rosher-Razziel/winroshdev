<?php 
include("Views/Templates/header.php"); 

// Definir una variable para la URL base y evitar repetición
$baseUrl = base_url;

?>
<ol class="breadcrumb mb-4">
  <li class="breadcrumb-item active">DashBoard</li>
</ol>

<div class="row">

  <!-- Función para generar tarjetas dinámicamente -->
  <?php 
  function generarTarjeta($bgColor, $titulo, $icono, $link, $total) {
    echo "
      <div class='col-xl-3 col-md-6 mt-2'>
        <div class='card $bgColor'>
          <div class='card-body d-flex align-items-center justify-content-between text-white'>
            <span class='fa-2x ml-auto'><i>$titulo</i></span>
            <i class='$icono fa-2x ml-auto'></i>
          </div>
          <div class='card-footer d-flex align-items-center justify-content-between'>
            <a href='$link' class='text-white'>Ver detalle</a>
            <span class='text-white'>$total</span>
          </div>
        </div>
      </div>
    ";
  }

  // Generar las tarjetas con datos dinámicos
  generarTarjeta("bg-primary", "Usuarios", "fas fa-user", "$baseUrl/Usuarios", isset($data['CountUsuarios']) ? count($data['CountUsuarios']) : 0);
  generarTarjeta("bg-success", "Clientes", "fas fa-users", "$baseUrl/Clientes", isset($data['CountClientes']) ? count($data['CountClientes']) : 0);
  generarTarjeta("bg-danger", "Productos", "fa-brands fa-product-hunt", "$baseUrl/Productos", isset($data['CountProductos']) ? count($data['CountProductos']) : 0);
  generarTarjeta("bg-warning", "Ventas", "fa-solid fa-cash-register", "$baseUrl/HistorialVentas", isset($data['CountVentas']) ? count($data['CountVentas']) : 0);

  // // Datos de inversión y ganancias
  generarTarjeta("bg-info", "Inv. Total", "fa-solid fa-cash-register", "#", '$ ' . number_format(isset($data['InvTotal']) ? $data['InvTotal'] : 0, 2, '.'));
  generarTarjeta("bg-secondary", "Inv. Real", "fa-solid fa-cash-register", "#", '$ ' . number_format(isset($data['InvReal']) ? $data['InvReal'] : 0, 2 , '.'));
  generarTarjeta("bg-dark", "Utilidad", "fa-solid fa-cash-register", "#", '$ ' . number_format(isset($data['Utilidad']) ? $data['Utilidad'] : 0, 2 , '.'));
  generarTarjeta("bg-primary", "Ganancia", "fa-solid fa-cash-register", "#", '$ ' . number_format(isset($data['GananciaTotal']) ? $data['GananciaTotal'] : 0, 2 , '.'));
  // ?>

</div>

<!-- Gráficos -->
<div class="row mt-2">
  <div class="col-xl-6">
    <div class="card">
      <div class="card-header bg-dark text-white">Productos más vendidos</div>
      <div class="card-body">
        <canvas id="graficaMasVendidos" width="100%" height="300"></canvas>
      </div>
    </div>
  </div>
  <div class="col-xl-6">
    <div class="card">
      <div class="card-header bg-dark text-white">Productos con Poco Stock</div>
      <div class="card-body">
        <canvas id="graficaPocoStock" width="100%" height="300"></canvas>
      </div>
    </div>
  </div>
</div>

<div class="row mt-2">
  <div class="col-xl-6">
    <div class="card">
      <div class="card-header bg-dark text-white">Venta del día</div>
      <div class="card-body">
        <canvas id="graficaVentasDia" width="100%" height="300"></canvas>
      </div>
    </div>
  </div>
  <div class="col-xl-6">
    <div class="card">
      <div class="card-header bg-dark text-white">Venta de la semana</div>
      <div class="card-body">
        <canvas id="graficaVentaMes" width="100%" height="300"></canvas>
      </div>
    </div>
  </div>
</div>

<div class="row mt-2">
  <div class="col-xl-6">
    <div class="card">
      <div class="card-header bg-dark text-white">Venta del mes</div>
      <div class="card-body">
        <canvas id="graficaVentasanio" width="100%" height="300"></canvas>
      </div>
    </div>
  </div>
  <div class="col-xl-6">
    <div class="card">
      <div class="card-header bg-dark text-white">Ganancias</div>
      <div class="card-body">
        <canvas id="graficaGanancias" width="100%" height="300"></canvas>
      </div>
    </div>
  </div>
</div>

<?php include("Views/Templates/footer.php"); ?>