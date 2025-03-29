<?php include("Views/Templates/header.php"); ?>
<ol class="breadcrumb mb-4">
  <li class="breadcrumb-item active">Perfil</li>
</ol>

<div class="perfil">
  <div class="card-perfil">
    <div class="row">
      <div class="col-lg-4 col-md-6">
          <div class="card text-center mb-3 border-success" >
              <div class="card-body">
              <i class="fa-solid fa-circle-user" style="font-size: 7rem; color: #3b8854;"></i>
                <h5 class="card-title" style="font-size: 32px;"><?php print_r($data['datosUsuarios']['USUARIO']); ?> <i class="fa-solid fa-pen-to-square" style="font-size: 15px;"></i></h5>
                <a class="btn btn-success" type="button" onclick="frmContraseña();">Cambiar Contraseña</a>
              </div>
            </div>
      </div>
      <div class="col-lg-8 col-md-6" >
          <div class="card mb-3 border-success">
              <div class="card-body" style="font-size: 17px;">
                <h5 class="card-title text-center">Informacion</h5>
                <p><strong>Nombre:</strong> <?php print_r($data['datosUsuarios']['NOMBRE']); ?></p>
                <p><strong> Apellidos:</strong> <?php print_r($data['datosUsuarios']['AP_PAT']); ?>  <?php  print_r($data['datosUsuarios']['AP_MAT']); ?> </p>
                <p><strong>Caja:</strong> <?php print_r($data['datosUsuarios']['CAJA']); ?> </p>
                <p><strong>Rol:</strong> <?php print_r($data['datosUsuarios']['DESC_ROL']); ?></p>
              </div>
              <!-- <?php print_r($data['datosUsuarios']); ?> -->
          </div>
      </div>
    </div>
    <!-- <div class="row">
      <div class="col-lg-12 col-md-12" >
          <div class="card mb-3 border-success">
              <div class="card-body" style="font-size: 17px;">
                <h5 class="card-title text-center">Informacion de la Empresa</h5>
                <p><strong>Nombre Empresa:</strong> LA VENTANITA</p>
                <p><strong> Direccion:</strong>  Av. congreso de la union 113 </p>
                <p><strong>Correo:</strong> laventanitaespinosa@gmail.com </p>
                <p><strong>Nuemero:</strong> 5568920917</p>
                <p><strong>Fecha de Registro:</strong> 2024-01-27</p>
                <p><strong>Pagina:</strong> www.laventanitaespinosa.com.mx </p>
              </div>
          </div>
      </div>
    </div> -->
  </div>
</div>

         <!-- NUEVA CONTRASEÑA -->
<div id="nueva_contraseña" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-success">
        <h5 class="modal-title text-white" id="my-modal-title">Registrar Nueva Contraseña</h5>
      </div>
      <div class="modal-body">
        <form method="POST" id="frmContraseña">

          <div class="row" id="claves">
              <input type="hidden" name="idUsuario" id="idUsuario" value="<?php echo $_SESSION['Id_usuario']; ?>">
              <div class="form-group mt-2">
                <label for="clave">Contraseña</label>
                <input id="clave" class="form-control mt-2" type="password" name="clave" placeholder="Contrasña">
              </div>

              <div class="form-group mt-2">
                <label for="clave">Nueva Contraseña</label>
                <input id="newclave" class="form-control mt-2" type="password" name="newclave" placeholder="Nueva Contrasña">
              </div>

              <div class="form-group mt-2">
                <label for="confirmarClave">Confirmar Contraseña</label>
                <input id="confirmarClave" class="form-control mt-2" type="password" name="confirmarClave" placeholder="Confirmar Contraseña">
              </div>

          </div>

          <div class="form-group mt-2">
           <button class="btn btn-success mt-2" id="btnAccion" type="button" onclick="btnEditarClave();">Editar</button>
           <button class="btn btn-danger mt-2" type="button" onclick="$('#nueva_contraseña').modal('hide');">Cancelar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<?php  include("Views/Templates/footer.php"); ?>