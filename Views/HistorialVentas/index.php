<?php include("Views/Templates/header.php"); ?>
<ol class="breadcrumb">
  <li class="breadcrumb-item active">Consulta Tickets</li>
</ol>

<div class="row g-0 text-left border-bottom shadow mb-2 bg-body-tertiary rounded">
  <div class="col-sm-6 col-md-4 mb-2">
    <p class="text-center">Monto Total</p>
    <p class="text-center fs-4" id="ventaTotalDia">
      $ <?= isset($data['sumaTotal']) ? $data['sumaTotal'] : 0; ?>
    </p>
  </div>
  <div class="col-sm-6 col-md-4 mb-2">
    <p class="text-center">Tickets encontrados</p>
    <p class="text-center fs-4 font-weight-bold" id="totalTickets">
      <?= isset($data['tickets']) ? count($data['tickets']) : 0; ?>
    </p>
    </div>
  <div class="col-sm-6 col-md-4 mb-2">
    <p class="text-center">Meta de Venta</p>
    <p class="text-center fs-4">$ <?= $data['proyeccionVentaDia'] ?? 0; ?></p>
  </div>
</div>

<div class="container overflow-hidden text-left">
  <div class="row gy-1">
    <div class="col-6 col-md-6 bg-secondary text-white p-3">
      <div class="form-group">
      <input id="fechaTickets" class="form-control" type="date" name="fechaTickets" value="<?php echo date('Y-m-d'); ?>" placeholder="Buscar Ticket">
      </div>
    </div>
    <div class="col-6 col-md-6 bg-secondary text-white p-3">
      <div class="form-group">
        <input id="ticketFolio" class="form-control" type="text" name="ticketFolio" placeholder="Buscar Ticket">
      </div>
    </div>
    <div class="col-12 border">
      <div class="">
        <div class="row" id="contenidoTickets">
        <?php 
          foreach ($data['tickets'] as $row) {
            echo generarTarjeta($row);
          }
          
          function generarTarjeta($row) {
            return '
            <div class="col-sm-6 col-md-4 col-lg-4 mt-2">
              <div class="card border-secondary mb-2 text-center">
                <div class="card-header">Folio: ' . htmlspecialchars($row['FOLIO_TICKET']) . '</div>
                <div class="card-body text-secondary">
                  <div class="row mb-2">
                    <div class="col-md-12">
                      <h5 class="card-title">La Ventanita</h5>
                    </div>
                    <div class="col-md-4">
                      <p class="card-text">#' . htmlspecialchars($row['ID_VENTA']) . '</p>
                    </div>
                    <div class="col-md-4">
                      <p class="card-text">' . substr(htmlspecialchars($row['HORA_VENTA']), 0, 5) . ' hrs</p>
                    </div>
                    <div class="col-md-4">
                      <p class="card-text">$' . htmlspecialchars($row['TOTAL_TICKET']) . '</p>
                    </div>
                  </div>
                  <button type="button" class="btn btn-secondary" onclick="verTicket(' . htmlspecialchars($row['ID_VENTA']) . ')">Imprimir</button>
                  <button type="button" class="btn btn-primary" onclick="obtenerTicketModel(' . htmlspecialchars($row['ID_VENTA']) . ')">Ver</button>
                </div>
              </div>
            </div>';
          }
        ?>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- MODAL PARA ASIGNAR PERMISOS A USUARIOS -->
<div id="ticket_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="ticket_modal_title" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="ticket_modal_title">Permisos Usuarios</h5>
      </div>
      <div class="modal-body">
        <form method="POST" id="frmUsuarios">
          <div class="row" id="contenido">
            
          </div>
          <div class="form-group mt-2">
           <button class="btn btn-primary mt-2" id="btnAgregar" type="button" onclick="registrarUser();">Agregar</button>
           <button class="btn btn-danger mt-2" type="button" onclick="$('#ticket_modal').modal('hide');">Cancelar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php  include("Views/Templates/footer.php"); ?>