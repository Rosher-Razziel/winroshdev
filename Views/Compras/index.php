<?php include("Views/Templates/header.php"); ?>
<ol class="breadcrumb mb-4">
  <li class="breadcrumb-item active">Compras</li>
</ol>

<div class="card">
  <div class="card">
    <div class="card-header bg-primary">
      <h5 class="text-white">Selecciona Proveedor</h5>
    </div>
    <div class="card-body">
      <form method="post" id="frmCompras">
        <div class="row">
          <!-- Proveedor Selection -->
          <div class="col-md-4">
            <label for="proveedor">Proveedor</label>
            <select id="proveedor" class="form-control mt-2" name="proveedor" onchange="buscarProductosProv(event);">
              <option value="0">Selecciona un proveedor</option>
              <?php foreach ($data['Proveedores'] as $row): ?>
                <option value="<?= $row['ID_PROVEEDOR'] ?>"><?= htmlspecialchars($row['DES_PROVEEDOR']) ?></option>
              <?php endforeach; ?>
            </select> 
          </div>
          
          <!-- Fecha Pedido -->
          <div class="col-md-4">
            <div class="form-group">
              <label for="fecha_prod">Fecha Pedido</label>
              <input id="fecha_prod" class="form-control mt-2" value="<?= date('Y-m-d'); ?>" type="date" disabled name="fecha_prod">
            </div>
          </div>   
          
          <!-- Folio Pedido -->
          <div class="col-md-4">
            <div class="form-group">
              <label for="folioPedido">Folio Pedido</label>
              <input id="folioPedido" class="form-control mt-2" type="text" disabled name="folioPedido">
            </div>
          </div>   
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Tabla de compras -->
<div class="card-body mt-2">
  <table id="TblCompras" class="table table-striped">
    <thead class="thead-dark">
      <tr>
        <th>PROVEEDOR</th>
        <th>NOMBRE PRODUCTO</th>
        <th>STOCK MÍNIMO</th>
        <th>STOCK ACTUAL</th>
        <th>COMPRA RECOMENDADA</th>
        <th>COMPRA</th>
        <th>SUBTOTAL</th>
      </tr>
    </thead>
    <tbody id="tblContenido"></tbody>
  </table>
</div>

<!-- Total y botón de PDF -->
<div class="row">
  <div class="col-md-10"></div>
  <div class="col-md-2">
    <div class="form-group">
      <label for="total"><b>Total</b></label>
      <input id="total" class="form-control" disabled type="text" name="total" value="0.00">
    </div>
    <button class="btn btn-primary mt-2" type="button" onclick="generarPedidoPdf()"><b>Convertir Pedido PDF</b></button>
  </div>
</div>

<?php include("Views/Templates/footer.php"); ?>
