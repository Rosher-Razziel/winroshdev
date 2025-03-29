<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title><?= $_GET['url']; ?> | WIN ROSH</title>
  <link href="<?= base_url; ?>Assets/css/styles.css" rel="stylesheet" />
  <!-- BOOTSTRAP -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/responsive/3.0.3/css/responsive.bootstrap5.css" rel="stylesheet">
  <!-- DATATABLE -->
  <link rel="stylesheet" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
  <!-- ALL -->
  <script src="https://kit.fontawesome.com/ae5f698689.js" crossorigin="anonymous"></script>
  <!-- SWEET ALERT 2 -->
  <link href="<?= base_url; ?>Assets/css/sweetalert2.min.css" rel="stylesheet">
  <!-- JQUERY UI CSS -->
  <link href="<?= base_url; ?>Assets/css/jquery-ui.css" rel="stylesheet">
  <!-- FAVICON -->
  <link rel="shortcut icon" href="<?= base_url; ?>Assets/img/Favicon.ico">
</head>

<body class="sb-nav-fixed" id="menu">
  <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3">Win Rosh</a>
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" onclick="desplegarMenu();" id="sidebarToggle" href="#!"><i
        class="fas fa-bars"></i></button>
    <ul class="navbar-nav ms-auto me-3 me-lg-4">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
          aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
          <li><a class="dropdown-item" href="<?= base_url; ?>Perfil"><?= $_SESSION['Usuario']; ?></a></li>
          <!-- <li><a class="dropdown-item" href="#!">Activity Log</a></li> -->
          <li>
            <hr class="dropdown-divider" />
          </li>
          <li><a class="dropdown-item" href="<?= base_url; ?>Usuarios/salir">Cerrar Sesion</a></li>
        </ul>
      </li>
    </ul>
  </nav>
  <div id="layoutSidenav">
    <div id="layoutSidenav_nav">
      <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
          <div class="nav">
            <a class="nav-link" href="<?= base_url; ?>DashBoard">
              <div class="sb-nav-link-icon"><i class="fa-solid fa-gauge-simple-high"></i></div>DashBoard
            </a>
            <a class="nav-link" href="<?= base_url; ?>Ventas">
              <div class="sb-nav-link-icon"><i class="fa-solid fa-cash-register"></i></div>Punto Venta
            </a>
            <a class="nav-link" href="<?= base_url; ?>HistorialVentas">
              <div class="sb-nav-link-icon"><i class="fa-solid fa-clock-rotate-left"></i></div>Historial Ventas
            </a>
            <a class="nav-link" href="<?= base_url; ?>Productos">
              <div class="sb-nav-link-icon"><i class="fa-solid fa-boxes-stacked"></i></div>Productos
            </a>
            <a class="nav-link" href="<?= base_url; ?>Categorias">
              <div class="sb-nav-link-icon"><i class="fa-solid fa-icons"></i></div>Categorias
            </a>
            <a class="nav-link" href="<?= base_url; ?>Proveedores">
              <div class="sb-nav-link-icon"><i class="fa-solid fa-truck-field"></i></div>Proveedores
            </a>

            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseCompras"
              aria-expanded="false" aria-controls="collapseCompras">
              <div class="sb-nav-link-icon"><i class="fa-solid fa-cart-shopping"></i></div>
              Entradas
              <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseCompras" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
              <nav class="sb-sidenav-menu-nested nav">
                <a class="nav-link" href="<?= base_url; ?>Compras"><div class="sb-nav-link-icon"><i class="fa-solid fa-cart-shopping"></i></div>Compras</a>
                <a class="nav-link" href="<?= base_url; ?>Pedidos"><div class="sb-nav-link-icon"><i class="fa-solid fa-store"></i></div>Pedidos</a>
                <a class="nav-link" href="<?= base_url; ?>Fiados"><div class="sb-nav-link-icon"><i class="fa-solid fa-receipt"></i></div>Fiados</a>
              </nav>
            </div>

            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts"
              aria-expanded="false" aria-controls="collapseLayouts">
              <div class="sb-nav-link-icon"><i class="fa-solid fa-screwdriver-wrench"></i></div>
              Administracion
              <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
              <nav class="sb-sidenav-menu-nested nav">
                <a class="nav-link" href="<?= base_url; ?>Usuarios"><div class="sb-nav-link-icon"><i class="fa-solid fa-user"></i></div>Usuarios</a>
                <a class="nav-link" href="<?= base_url; ?>Clientes"><div class="sb-nav-link-icon"><i class="fa-solid fa-users"></i></div>Clientes</a>
                <a class="nav-link" href="<?= base_url; ?>Cajas"><div class="sb-nav-link-icon"><div class="sb-nav-link-icon"><i class="fa-solid fa-box-archive"></i></div></div>Cajas</a>
                <a class="nav-link" href="<?= base_url; ?>Medidas"><div class="sb-nav-link-icon"><i class="fa-solid fa-scale-balanced"></i></div>Medidas</a>
                <a class="nav-link" href="<?= base_url; ?>Roles"><div class="sb-nav-link-icon"><i class="fa-solid fa-lock-open"></i></div>Roles</a>
                <a class="nav-link" href="<?= base_url; ?>Reportes" id="btnReportes"><div class="sb-nav-link-icon"><i class="fa-solid fa-file-pdf"></i></div>Reportes</a>
                <a class="nav-link" href="<?= base_url; ?>Configuracion"><div class="sb-nav-link-icon"><i class="fa-solid fa-gears"></i></div>Configuracion</a>
              </nav>
            </div>
          </div>
        </div>
        <div class="sb-sidenav-footer">
          <div class="small">Inicio de sesion de:</div>
          <?= $_SESSION['Nombre']; ?>
        </div>
      </nav>
    </div>
    <div id="layoutSidenav_content">
      <main>
        <div class="container-fluid px-4 mt-2">