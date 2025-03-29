<?php include("Views/Templates/header.php"); ?>

<style>
  #cot_productos {
    overflow-y: auto;
    height: 68vh;
  }
</style>

<ol class="breadcrumb">
  <li class="breadcrumb-item active">Ventas</li>
</ol>

<div class="row">
  <div class="col-md-3">
    <input id="cliente" class="form-control" type="text" name="cliente" disabled placeholder="Cliente" value="Cliente Frecuente">
  </div>
  <div class="col-md-9">
   <input id="codigo_barras" class="form-control" type="text" name="codigo_barras" placeholder="Codigo de barras" aria-label="Código de barras">
  </div>
</div>

<div class="row">
   <!-- TABLA DE TOTAL Y MAS -->
   <div class="col-md-3">
    <div class="card border-primary mb-1 mt-2">
      <div class="card-header text-center bg-primary text-white p-0 m-0 fs-2"><b>Total</b></div>
      <div class="card-body fs-2 p-0 m-0 text-center"><b id="totalProductos">$0.00</b></div>
      </div>

    <div class="card border-primary mb-1 mt-2">
      <div class="card-header text-center bg-secondary text-white p-0 m-0 fs-4"><b>Pago Tarjeta</b></div>
      <div class="card-body fs-4 p-0 m-0 text-center"><b id="pagoTarjeta">$0.00</b></div>
    </div>

    <div class="card border-primary">
      <div class="card-body">
        <form id="frmCobrar" class="form">
          <div class="form-group">
            <input type="hidden" name="total" id="total">
            <label class="col-form-label col-form-label-lg">Importe Recibido</label>
            <input class="form-control form-control-lg" id="pagaCon" name="pagaCon" type="number" placeholder="Importe Recibido" step="any" required>
            <label class="col-form-label col-form-label-lg">Cambio</label>
            <input class="form-control form-control-lg" id="cambio" name="cambio" type="number" placeholder="Cambio" disabled="">
            <div class="d-grid gap-2 mt-3">
              <button type="submit" class="btn btn-primary" id="cobrarPedido" name="cobrarPedido" value="Cobrar Venta">Cobrar Venta</button>
            </div>
          </div>
        </form>
      </div>
    </div>

  </div>
  <div class="col-md-9 mt-2 border" id="cot_productos">
    <table id="tblProducts" class="table table-striped">
      <thead>
        <tr>
          <th scope="col" class="text-center">CANTIDAD</th>
          <th scope="col" class="text-left">DESCRIPCION</th>
          <th scope="col" class="text-center">PRECIO</th>
          <th scope="col" class="text-center">SUB TOTAL</th>
          <th scope="col" class="text-center">ACCIONES</th>
        </tr>
      </thead>
      <tbody id="bodyProductos">
      </tbody>
    </table>
  </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cantidad en garmos</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="cantidad" class="col-form-label">Cantidad</label>
          <input type="hidden" id="indice" name="indice">
          <input type="number" class="form-control" id="cantidad" name="cantidad">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="btnCambiarCantidad();">Cambiar</button>
      </div>
    </div>
  </div>
</div>

<?php  include("Views/Templates/footer.php"); ?>