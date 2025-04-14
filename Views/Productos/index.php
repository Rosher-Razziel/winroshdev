<?php include("Views/Templates/header.php"); ?>
<ol class="breadcrumb mb-4">
  <li class="breadcrumb-item active">Productos test new rama</li>
</ol>

<button class="btn btn-success mb-2 " type="button" onclick="frmProducto();"><i class="fa-solid fa-plus"></i></button>

<div class="card-body">
  <table id="TblProductos" class="table table-striped">
    <thead>
      <tr>
        <?php
          $columns = ['FOTO', 'CODIGO', 'NOMBRE', 'COMPRA', 'VENTA', 'STOCK MIN', 'STOCK', 'PROV Y CAT', 'ACCIONES'];
          foreach ($columns as $col) {
            echo "<th>{$col}</th>";
          }
        ?>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <?php
          foreach ($columns as $col) {
            echo "<th>{$col}</th>";
          }
        ?>
      </tr>
    </tfoot>
    <tbody>
    </tbody>
  </table>
</div>

<div id="nuevo_producto" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="my-modal-title">Registrar Nuevo Producto</h5>
      </div>
      <div class="modal-body">
        <form method="POST" id="frmProductos">
          <!-- Row for product code -->
          <div class="form-group">
            <input type="hidden" name="idProducto" id="idProducto">
            <label for="cod_barras">Código de Barras</label>
            <input id="cod_barras" class="form-control mt-2" type="text" name="cod_barras"
              placeholder="Código de Barras" required>
          </div>

          <!-- Row for product name and purchase price -->
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="nombre_producto">Nombre del Producto</label>
                <input id="nombre_producto" class="form-control mt-2" type="text" name="nombre_producto"
                  placeholder="Nombre del Producto" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="precio_compra">Precio de Compra</label>
                <input id="precio_compra" class="form-control mt-2" type="number" name="precio_compra"
                  placeholder="Precio de Compra" onkeyup="calcularPrecioVenta(event)" min="0" step="0.01" required
                  <?php echo ($_SESSION['Id_usuario'] == 1) ? '' : 'disabled'; ?>>
              </div>
            </div>
          </div>

          <!-- Row for stock and selling price -->
          <div class="row">
            <div class="col-md-6">
              <div class="form-group mt-2">
                <label for="existencia">Existencias</label>
                <input id="existencia" class="form-control mt-2" type="number" name="existencia"
                  placeholder="Existencias" required <?php echo ($_SESSION['Id_usuario'] == 1) ? '' : 'disabled'; ?>>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mt-2">
                <label for="precio_venta">Precio de Venta</label>
                <input id="precio_venta" class="form-control mt-2" type="number" name="precio_venta"
                  placeholder="Precio de Venta" min="0" step="0.01" required
                  <?php echo ($_SESSION['Id_usuario'] == 1) ? '' : 'disabled'; ?>>
              </div>
            </div>
          </div>

          <!-- Row for minimum stock -->
          <div class="form-group">
            <label for="existencia_minima">Existencia Mínima</label>
            <input id="existencia_minima" class="form-control mt-2" type="number" name="existencia_minima"
              placeholder="Existencia Mínima" required>
          </div>

          <!-- Dynamic dropdowns for supplier, category, and unit -->
          <div class="row">
            <?php
              $selects = [
                ['proveedor', 'Proveedor', $data['Proveedores'], 'ID_PROVEEDOR', 'DES_PROVEEDOR'],
                ['categoria', 'Categoria', $data['Categorias'], 'ID_CATEGORIA', 'DES_CATEGORIA'],
                ['medida', 'Medida', $data['Medidas'], 'ID_MEDIDA', 'MEDIDA']
              ];
              foreach ($selects as $select) {
                list($id, $label, $options, $optionId, $optionDesc) = $select;
                echo "<div class='col-md-6'>
                        <label for='{$id}'>{$label}</label>
                        <select id='{$id}' class='form-control mt-2' name='{$id}'>";
                foreach ($options as $row) {
                  echo "<option value='{$row[$optionId]}'>{$row[$optionDesc]}</option>";
                }
                echo "</select></div>";
              }
            ?>
          </div>

          <!-- Section for product image -->
          <div class="row">
            <div class="col-md-6 offset-md-3">
              <div class="form-group">
                <label>Foto</label>
                <div class="card border-primary">
                  <div class="card-body">
                    <label for="imagen" class="btn btn-primary mb-2" id="icon_image"><i
                        class="fas fa-image"></i></label>
                    <span id="icon_cerrar"></span>
                    <input id="imagen" class="d-none" type="file" name="imagen" onchange="preview(event)">
                    <input type="hidden" id="foto_actual" name="foto_actual">
                    <img id="img_preview" class="img-thumbnail d-none" width="140" height="140">
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Action buttons -->
          <div class="form-group mt-2 text-center">
            <button class="btn btn-primary mt-2" id="btnAccion" type="submit">Agregar</button>
            <button class="btn btn-danger mt-2" type="button" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php  include("Views/Templates/footer.php"); ?>