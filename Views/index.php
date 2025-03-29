<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="Página de inicio de sesión de WinRosh" />
  <meta name="author" content="WinRosh" />
  <title>Inicio de Sesión - WinRosh</title>
  <link href="<?= base_url; ?>Assets/css/styles.css" rel="stylesheet" />
  <script src="<?= base_url; ?>Assets/js/all.js" crossorigin="anonymous"></script>
  <!-- SWEET ALERT 2 -->
  <link href="<?= base_url; ?>Assets/css/sweetalert2.min.css" rel="stylesheet">
  <link rel="shortcut icon" href="<?= base_url; ?>Assets/img/Favicon.ico">
</head>
<body class="bg-primary">
  <div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
      <main>
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-5">
              <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header">
                  <h3 class="text-center font-weight-light my-4">
                    <img class="img-thumbnail" src="<?= base_url; ?>Assets/img/WR.png" alt="WinRosh Logo" width="400" height="200">
                  </h3>
                </div>
                <div class="card-body">
                  <form id="frmLogin" onsubmit="frmLogin(event);">
                    <div class="form-floating mb-3">
                      <input class="form-control" id="usuario" name="usuario" type="text" placeholder="Juan" required/>
                      <label for="usuario"><i class="fa-solid fa-user"></i> Usuario</label>
                    </div>
                    <div class="form-floating mb-3">
                      <input class="form-control" id="clave" name="clave" type="password" placeholder="Password" required/>
                      <label for="clave"><i class="fas fa-key"></i> Contraseña</label>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                      <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
    <div id="layoutAuthentication_footer">
      <footer class="py-4 bg-light mt-auto">
        <div class="container-fluid px-4">
          <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted p-2">Copyright &copy; WinRosh <?= date("Y"); ?></div>
            <div>
              <a href="#">Políticas y privacidad</a>
              &middot;
              <a href="#">Términos &amp; Condiciones</a>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>
  <script src="<?= base_url; ?>Assets/js/jquery.min.js" crossorigin="anonymous"></script>
  <script src="<?= base_url; ?>Assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="<?= base_url; ?>Assets/js/scripts.js"></script>
  <!-- SWEET ALERT 2 -->
  <script src="<?= base_url; ?>Assets/js/sweetalert2.all.min.js"></script>
  <script> base_url = "<?= base_url; ?>";</script>
  <script src="<?= base_url; ?>Assets/js/login.js"></script>
</body>
</html>
