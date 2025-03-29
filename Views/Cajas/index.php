<?php include("Views/Templates/header.php"); ?>

<ol class="breadcrumb mb-2">
  <li class="breadcrumb-item active">Cajas</li>
  <!-- <h1 class="mt-0">Cajas</h1> -->
</ol>

<button class="btn btn-success mb-2" type="button" onclick="frmCaja();"><i class="fa-solid fa-plus"></i></button>

<div class="card-body">
  <table id="TblCajas" class="table table-light">
    <thead class="thead-dark">
      <tr>
        <th>ID</th>
        <th>NOMBRE CAJA</th>
        <th>ESTADO</th>
        <th>FECHA REG.</th>
        <th>ACCCIONES</th>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <th>ID</th>
        <th>NOMBRE CAJA</th>
        <th>ESTADO</th>
        <th>FECHA REG.</th>
        <th>ACCIONES</th>
      </tr>
    </tfoot>
    <tbody>
    </tbody>
  </table>
</div>

<div id="nueva_caja" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="my-modal-title">Registrar Nueva Caja</h5>
      </div>
      <div class="modal-body">
        <form method="POST" id="frmCajas">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group mt-2">
                <input type="hidden" name="idCaja" id="idCaja">
                <label for="usuario">Nombre Caja</label>
                <input id="caja" class="form-control mt-2" type="text" name="caja" placeholder="Nombre Caja">
              </div>
            </div>
          </div>
          <div class="form-group mt-2">
            <button class="btn btn-primary mt-2" id="btnAccion" type="button" onclick="registrarCaja();">Agregar</button>
            <button class="btn btn-danger mt-2" type="button" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php  include("Views/Templates/footer.php"); ?>