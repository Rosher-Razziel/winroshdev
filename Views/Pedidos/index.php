<?php include("Views/Templates/header.php"); ?>

<ol class="breadcrumb mb-2">
  <li class="breadcrumb-item active" id="titlePedido">Pedidos</li>
</ol>

<div class="row d-none" id="btnBack">
  <div class="col-md-6">
    <a class="btn btn-success mb-2" href="<?= base_url; ?>Pedidos"><i class="fa-solid fa-circle-left"></i></a>
  </div>
  <div class="col-md-6">
    <button class="btn btn-primary mb-2" id="recibirProducto" type="button">Marcar como recibido</button>
  </div>
</div>

<div class="card-body" id="contenido">
  <table id="TblPedidos" class="table table-striped">
    <thead class="thead-dark">
      <tr>
        <th>ID</th>
        <th>Proveedor</th>
        <th>Total Pedido</th>
        <th>Fecha</th>
        <th>Estado</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
    </tbody>
  </table>
</div>

<?php include("Views/Templates/footer.php"); ?>