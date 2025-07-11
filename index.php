<?php
require_once "Config/Config.php";

$ruta = !empty($_GET['url']) ? $_GET['url'] : 'Home/index';
$array = explode('/', $ruta);
$controller = $array[0];
$metodo = 'index';
$parametro = '';

if (!empty($array[1])) {
  if (!empty($array[1]) != '') {
    $metodo = $array[1];
  }
}

if (!empty($array[2])) {
  if (!empty($array[1] != '')) {
    for ($i = 2; $i < count($array); $i++) {
      $parametro .= $array[$i] . ',';
    }
    $parametro = trim($parametro, ',');
  }
}

require_once "Config/App/Autoload.php";
$dirControlador = "Controllers/" . $controller . '.php';

if (file_exists($dirControlador)) {
  require_once $dirControlador;
  $controller = new $controller();
  if (method_exists($controller, $metodo)) {
    $controller->$metodo($parametro);
  } else {
    header('Location: ' . base_url . 'Errors');
  }
} else {
  header('Location: ' . base_url . 'Errors');
}
