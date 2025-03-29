<?php include("Views/Templates/header.php"); ?>

<ol class="breadcrumb mb-2">
  <li class="breadcrumb-item active">Clientes</li>
</ol>

<button class="btn btn-success mb-2" type="button" onclick="frmCliente();"><i class="fa-solid fa-plus"></i></button>

<div class="card mb-4">
  <div class="card-body">
    <table id="TblClientes" class="table table-light">
      <thead class="thead-dark">
        <tr>
          <th>ESTADO</th>
          <th>NOMBRE</th>
          <th>TELEFONO</th>
          <th>CORREO</th>
          <th>CREDITO</th>
          <th>ACCIONES</th>
        </tr>
      </thead>
        <tbody>
      </tbody>
    </table>
  </div>
</div>

<div id="nuevo_cliente" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="my-modal-title">Registrar Nuevo Cliente</h5>
      </div>
      <div class="modal-body">
        <form method="POST" id="frmClientes">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group mt-2">
                <input type="hidden" name="idCliente" id="idCliente">
                <label for="Nombre">Nombre</label>
                <input id="nombre" class="form-control mt-2" type="text" name="nombre" placeholder="Nombre">
              </div>
            </div>  
            <div class="col-md-6">
              <div class="form-group mt-2">
                <label for="appat">Apellido Paterno</label>
                <input id="appat" class="form-control mt-2" type="text" name="appat" placeholder="Apellido Paterno">
              </div>
            </div>
          </div>
          <div class="row">  
            <div class="col-md-6">
              <div class="form-group mt-2">
                <label for="apmat">Apellido Materno</label>
                <input id="apmat" class="form-control mt-2" type="text" name="apmat" placeholder="Apellido Materno">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mt-2">
                <label for="num_tel">Numero Telefonico</label>
                <input id="num_tel" class="form-control mt-2" type="tel" name="num_tel" pattern="[0-9]{10}" maxlength="10" placeholder="Numero Telefonico">
              </div>
            </div>
          </div>
          <div class="row" id="claves">
            <div class="col-md-6">
              <div class="form-group mt-2">
                <label for="correo">Correo Electronico</label>
                <input id="correo" class="form-control mt-2" type="email" name="correo" placeholder="Correo Electronico" required>
              </div>
            </div>  
            <div class="col-md-6">
              <div class="form-group mt-2">
                <label for="lim_cred">Limite de Credico</label>
                <input id="lim_cred" class="form-control mt-2" type="number" name="lim_cred" pattern="[0-9]{10}" maxlength="5" placeholder="Limite de Credito">
              </div>
            </div>
          </div>
          <div class="form-group mt-2">
           <button class="btn btn-primary mt-2" id="btnAccion" type="button" onclick="registrarCliente();">Agregar</button>
           <button class="btn btn-danger mt-2" type="button" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php  include("Views/Templates/footer.php"); ?>