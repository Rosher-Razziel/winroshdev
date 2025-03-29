<?php
class Query extends Conexion {

  private $con;

  public function __construct() {
    $this->con = (new Conexion())->connet();
  }

  public function select(string $sql) {
    $stmt = $this->con->prepare($sql);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function select_v2(string $sql, array $datos) {
    $stmt = $this->con->prepare($sql);
    $stmt->execute($datos);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function selectAll(string $sql) {
    $stmt = $this->con->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function selectAll_v2(string $sql, array $datos = []) {
    $stmt = $this->con->prepare($sql);
    $stmt->execute($datos);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function save(string $sql, array $datos) {
    $stmt = $this->con->prepare($sql);
    return $stmt->execute($datos) ? 1 : 0;
  }
}
