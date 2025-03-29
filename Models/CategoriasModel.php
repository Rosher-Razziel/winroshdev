<?php
class CategoriasModel extends Query{
  
  private $categoria, $idCategoria;

  public function __construct(){
    parent::__construct();
  }

  // OBTENER CATEGORIAS
  public function getCategorias(){
    $sql = "SELECT * FROM categoria";
    $data = $this->selectAll($sql);
    return $data;
  }

  // REGISTRAR CATEGORIA
  public function registrarCategoria(string $categoria){
    $this->categoria = $categoria;
    $fecha = date('Y-m-d');

    $verificar = "SELECT * FROM categoria WHERE DES_CATEGORIA = '$this->categoria'";
    $existe = $this->select($verificar);

    if (empty($existe)) {
      $sql = "INSERT INTO categoria (DES_CATEGORIA, ESTADO, FECHA_REGISTRO) VALUES (?,?,?)";
      $datos = array($this->categoria, '1', $fecha);
      return $this->save($sql, $datos) === 1 ? "Correcto" : "Error";
    }
    return "Existe";
  }

   // EDITAR CATEGORIA
   public function editarCategoria(int $id){
    $sql = "SELECT * FROM categoria WHERE ID_CATEGORIA = $id";
    $data = $this->select($sql);
    return $data;
  }

  //MODIDICAR CATEGORIA
  public function modificarCategoria(string $categoria, int $idCategoria){    
    $sql = "UPDATE categoria SET DES_CATEGORIA = ? WHERE ID_CATEGORIA = ?";
    $datos = array($categoria, $idCategoria);
    return $this->save($sql, $datos) === 1 ? "Correcto" : "Error";
  }

  // CAMBIAR ESTADO DE CATEGORIA (ELIMINAR O ACTIVAR)
  private function cambiarEstadoCategoria(int $id, string $estado) {
    $sql = "UPDATE categoria SET ESTADO = ? WHERE ID_CATEGORIA = ?";
    return $this->save($sql, [$estado, $id]) === 1 ? "Correcto" : "Error";
  }

  // ELIMINAR CATEGORIA (Cambiar estado a 0)
  public function eliminarCategoria(int $id) {
    return $this->cambiarEstadoCategoria($id, '0');
  }

  // ACTIVAR CATEGORIA (Cambiar estado a 1)
  public function activarCategoria(int $id) {
    return $this->cambiarEstadoCategoria($id, '1');
  }
}