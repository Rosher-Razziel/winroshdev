<?php include("Views/Templates/header.php"); ?>
<ol class="breadcrumb">
  <li class="breadcrumb-item active">Reportes</li>
</ol>
<div class="col-md-6 d-none" id="regreso">
  <a class="btn btn-success mb-2" href="<?php echo base_url; ?>Reportes"><i class="fa-solid fa-circle-left"></i></a>
</div>
<div class="row">
  <div class="col-xl-12" id="contenidoTabla">
    <div class="card">
      <div class="card">
        <div class="card-header bg-primary">
          <h5 class="text-white">Corte de Caja</h5>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-10">
              <div class="form-group">
                <input id="cambioInicial" class="form-control" type="text" name="cambioInicial"
                  placeholder="Ingresa Saldo Inicial">
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <button class="btn btn-primary" type="button" onclick="generarReporte()">Generar Corte</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row mt-2">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-header bg-dark text-white" id="titleTabla">
            Cortes de caja
          </div>
          <div class="card-body">
            <table id="TblCorteCaja" class="table table-light">
              <thead class="thead-dark">
                <tr>
                  <th>ID</th>
                  <th>SALDO CAJA</th>
                  <th>EFECTIVO</th>
                  <th>P. TARJETA</th>
                  <th>RESURTIR</th>
                  <th>GANANCIA DEL DIA</th>
                  <th>FECHA CORTE</th>
                  <th>ACCIONES</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>ID</th>
                  <th>SALDO CAJA</th>
                  <th>EFECTIVO</th>
                  <th>P. TARJETA</th>
                  <th>RESURTIR</th>
                  <th>GANANCIA DEL DIA</th>
                  <th>FECHA CORTE</th>
                  <th>ACCIONES</th>
                </tr>
              </tfoot>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php  include("Views/Templates/footer.php"); ?>