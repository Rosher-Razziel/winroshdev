<?php include("Views/Templates/header.php"); ?>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Proveedores</li>
</ol>

<button class="btn btn-success mb-2" type="button" onclick="frmProveedor();">
    <i class="fa-solid fa-plus"></i>
</button>

<div class="card-body">
    <table id="TblProveedor" class="table table-light">
        <thead class="thead-dark">
            <tr>
              <th>ID</th>
              <th>Proveedor</th>
              <th>Día Visita</th>
              <th>Nombre</th>
              <th>Correo</th>
              <th>Teléfono</th>
              <th>Estado</th>
              <th>Acciones</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<div id="nuevo_proveedor" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="my-modal-title">Registrar Nuevo Proveedor</h5>
            </div>
            <div class="modal-body">
                <form id="frmProveedor" method="POST">
                    <input type="hidden" name="idProveedor" id="idProveedor">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mt-2">
                                <label for="desc_proveedor">Descripción Proveedor</label>
                                <input id="desc_proveedor" class="form-control mt-2" type="text" name="desc_proveedor" placeholder="Descripción Proveedor" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mt-2">
                                <label for="dia_visita">Día Visita</label>
                                <input id="dia_visita" class="form-control mt-2" type="text" name="dia_visita" placeholder="Día Visita" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mt-2">
                                <label for="nombre_proveedor">Nombre</label>
                                <input id="nombre_proveedor" class="form-control mt-2" type="text" name="nombre_proveedor" placeholder="Nombre" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mt-2">
                                <label for="appat">Apellido Paterno</label>
                                <input id="appat" class="form-control mt-2" type="text" name="appat" placeholder="Apellido Paterno" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mt-2">
                                <label for="apmat">Apellido Materno</label>
                                <input id="apmat" class="form-control mt-2" type="text" name="apmat" placeholder="Apellido Materno" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mt-2">
                                <label for="correo">Correo Electrónico</label>
                                <input id="correo" class="form-control mt-2" type="email" name="correo" placeholder="Correo Electrónico" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mt-2">
                                <label for="num_tel">Número Telefónico</label>
                                <input id="num_tel" class="form-control mt-2" type="tel" name="num_tel" placeholder="Número Telefónico" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-2 text-right">
                        <button class="btn btn-primary" id="btnAccion" type="button" onclick="registrarProveedor();">Agregar</button>
                        <button class="btn btn-danger mt-2" type="button" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include("Views/Templates/footer.php"); ?>
