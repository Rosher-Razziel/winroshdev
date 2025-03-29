<?php include("Views/Templates/header.php"); ?>

<ol class="breadcrumb mb-4">
  <li class="breadcrumb-item active">Categorías</li>
</ol> 

<button class="btn btn-success mb-2" type="button" onclick="frmCategoria();"><i class="fa-solid fa-plus"></i></button>

<div class="card-body">
  <table id="TblCategorias" class="table table-light table-striped table-bordered">
    <thead class="thead-dark">
      <tr>
        <th>ID</th>
        <th>NOMBRE CATEGORÍA</th>
        <th>ESTADO</th>
        <th>FECHA REG.</th>
        <th>ACCIONES</th>
      </tr>
    </thead>
    <tbody>
    </tbody>
  </table>
</div>

<!-- Modal para registrar nueva categoría -->
<div id="nueva_categoria" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalCategoriaTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="modalCategoriaTitle">Registrar Nueva Categoría</h5>
      </div>
      <div class="modal-body">
        <form id="frmCategoria">
          <input type="hidden" name="idCategoria" id="idCategoria">
          <div class="form-group">
            <label for="categoria">Nombre Categoría</label>
            <input id="categoria" class="form-control" type="text" name="categoria" placeholder="Nombre Categoría" required>
          </div>
          <div class="modal-footer">
            <button class="btn btn-primary" id="btnAccion" type="button" onclick="registrarCategoria();">Agregar</button>
            <button class="btn btn-danger mt-2" type="button" data-bs-dismiss="modal">Cancelar</button>          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include("Views/Templates/footer.php"); ?>