<?php include("Views/Templates/header.php"); ?>
<ol class="breadcrumb mb-4">
  <li class="breadcrumb-item active">Roles</li>
</ol> 

<button class="btn btn-success mb-2" type="button" onclick="frmRoles();"><i class="fa-solid fa-plus"></i></button>

<div class="card-body">
  <table id="TblRoles" class="table table-light">
    <thead class="thead-dark">
      <tr>
        <th>ID</th>
        <th>DESCRIPCION ROL</th>
        <th>ESTADO</th>
        <th>FECHA REG.</th>
        <th>ACCCIONES</th>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <th>ID</th>
        <th>DESCRIPCION ROL</th>
        <th>ESTADO</th>
        <th>FECHA REG.</th>
        <th>ACCIONES</th>
      </tr>
    </tfoot>
    <tbody>
    </tbody>
  </table>
</div>

<div id="nuevo_rol" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="my-modal-title">Registrar Nueva Categoria</h5>
      </div>
      <div class="modal-body">
        <form method="POST" id="frmRoles">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group mt-2">
                <input type="hidden" name="idRol" id="idRol">
                <label for="rol">Nombre Rol</label>
                <input id="rol" class="form-control mt-2" type="text" name="rol" placeholder="Nombre Rol">
              </div>
            </div>
          </div>
          <div class="form-group mt-2">
            <button class="btn btn-primary mt-2" id="btnAccion" type="button" onclick="registrarRoles();">Agregar</button>
            <button class="btn btn-danger mt-2" type="button" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php  include("Views/Templates/footer.php"); ?>