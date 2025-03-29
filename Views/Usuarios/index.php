<?php include("Views/Templates/header.php"); ?>
<ol class="breadcrumb mb-2">
  <li class="breadcrumb-item active">Usuarios <?= $_SESSION['timeout']; ?></li>
</ol>

<button class="btn btn-success mb-2" type="button" onclick="frmUsuario();"><i class="fa-solid fa-plus"></i></button>

<div class="card mb-4">
  <div class="card-body">
    <table id="TblUsuarios" class="table table-light">
      <thead class="thead-dark">
        <tr>
          <th>ID</th>
          <th>USUARIO</th>
          <th>NOMBRE</th>
          <th>ROL</th>
          <th>CAJA</th>
          <th>ESTADO</th>
          <th>ACCIONES</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>
</div>

<!-- MODAL PARA REGISTRAR O EDITAR USUARIOS -->
<div id="nuevo_usuario" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="my-modal-title">Registrar Nuevo Usuario</h5>
      </div>
      <div class="modal-body">
        <form method="POST" id="frmUsuarios" onsubmit="registrarUser(event);">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group mt-2">
                <input type="hidden" name="idUsuario" id="idUsuario">
                <label for="usuario">Usuario</label>
                <input id="usuario" class="form-control mt-2" type="text" name="usuario" placeholder="Usuario" required>
              </div>
            </div>  
            <div class="col-md-6">
              <div class="form-group mt-2">
                <label for="nombre">Nombre</label>
                <input id="nombre" class="form-control mt-2" type="text" name="nombre" placeholder="Nombre" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group mt-2">
                <label for="appat">Apellido Paterno</label>
                <input id="appat" class="form-control mt-2" type="text" name="appat" placeholder="Apellido Paterno" required>
              </div>
            </div>  
            <div class="col-md-6">
              <div class="form-group mt-2">
                <label for="apmat"> Apellido Materno</label>
                <input id="apmat" class="form-control mt-2" type="text" name="apmat" placeholder="Apellido Materno" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group mt-2">
                <label for="clave">Contraseña</label>
                <input id="clave" class="form-control mt-2" type="password" name="clave" placeholder="Contrasña" required>
              </div>
            </div>  
            <div class="col-md-6">
              <div class="form-group mt-2">
                <label for="confirmarClave">Confirmar Contraseña</label>
                <input id="confirmarClave" class="form-control mt-2" type="password" name="confirmarClave" placeholder="Confirmar Contraseña" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label for="caja">Caja</label>
              <select id="caja" class="form-control mt-2" name="caja" required>
                <?php foreach ($data['caja'] as $row) { ?>
                  <option value="<?php echo $row['ID_CAJA'] ?>"><?php echo $row['CAJA'] ?></option>  
                <?php } ?>
              </select> 
            </div>
            <div class="col-md-6">
              <label for="rol">Rol</label>
              <select id="rol" class="form-control mt-2" name="rol" required>
                <?php foreach ($data['rol'] as $row) { ?>
                  <option value="<?php echo $row['ID_ROL'] ?>"><?php echo $row['DESC_ROL'] ?></option>  
                <?php } ?>
              </select> 
            </div>
          </div>
          <div class="form-group mt-2">
           <button class="btn btn-primary mt-2" id="btnAccion" type="submit">Agregar</button>
           <button class="btn btn-danger mt-2" type="button" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- MODAL PARA ASIGNAR PERMISOS A USUARIOS -->
<div id="permisos_usuarios" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="my-modal-title">Permisos Usuarios</h5>
      </div>
      <div class="modal-body">
        <form method="POST" id="frmPermisosUsuarios">
          <div class="row" id="contenido">

          </div>
          <div class="form-group mt-2">
           <button class="btn btn-primary mt-2" id="btnAgregar" type="submit">Agregar</button>
           <button class="btn btn-danger mt-2" type="button" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php  include("Views/Templates/footer.php"); ?>