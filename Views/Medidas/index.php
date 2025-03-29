<?php include("Views/Templates/header.php"); ?>

<ol class="breadcrumb mb-2">
  <li class="breadcrumb-item active">Medidas</li>
  <!-- <h1 class="mt-0">Cajas</h1> -->
</ol>

<button class="btn btn-success mb-2" type="button" onclick="frmMedida();"><i class="fa-solid fa-plus"></i></button>

<div class="card-body">
  <table id="TblMedidas" class="table table-light">
    <thead class="thead-dark">
      <tr>
        <th>ID</th>
        <th>NOMBRE MEDIDA</th>
        <th>NOMBRE CORTO</th>
        <th>ESTADO</th>
        <th>FECHA REG.</th>
        <th>ACCCIONES</th>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <th>ID</th>
        <th>NOMBRE MEDIDA</th>
        <th>NOMBRE CORTO</th>
        <th>ESTADO</th>
        <th>FECHA REG.</th>
        <th>ACCIONES</th>
      </tr>
    </tfoot>
    <tbody>
    </tbody>
  </table>
</div>

<div id="nueva_medida" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="my-modal-title">Registrar Nueva Medida</h5>
      </div>
      <div class="modal-body">
        <form method="POST" id="frmMedidas">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group mt-2">
                <input type="hidden" name="idMedida" id="idMedida">
                <label for="medida">Nombre Medida</label>
                <input id="medida_prod" class="form-control mt-2" type="text" name="medida_prod" placeholder="Nombre Medida">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mt-2">
                <input type="hidden" name="idMedida" id="idMedida">
                <label for="medida_corto">Nombre Corto</label>
                <input id="medida_corto" class="form-control mt-2" type="text" name="medida_corto" placeholder="Nombre Corto">
              </div>
            </div>
          </div>
          <div class="form-group mt-2">
            <button class="btn btn-primary mt-2" id="btnAccion" type="button" onclick="registrarMedida();">Agregar</button>
            <button class="btn btn-danger mt-2" type="button" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php  include("Views/Templates/footer.php"); ?>