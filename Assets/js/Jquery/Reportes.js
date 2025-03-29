console.log("LLEGUE  A REPORTES");
$(document).ready(function() {
  $('#cambioInicial').focus();

  // ===========================================================
  // ========== TABLA DE USUARIOS ==========
  // ===========================================================
  var TblUsuarios = $('#TblCorteCaja').DataTable({
    ajax: {
      url: base_url + 'Reportes/listar',
      dataSrc : ""
    },
    columns: [
      {"data" : "ID_CORTE_CAJA"},
      {"data" : "SALDO_CAJA"},
      {"data" : "VENTA_DEL_DIA"},
      {"data" : "VENTA_DEL_DIA"},
      {"data" : "RESURTIR"},
      {"data" : "GANANCIA_DEL_DIA"},
      {"data" : "FECHA_CORTE"},
      {"data" : "ACCIONES"}      
    ],
    language: {"url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"},
    order: [[ 0, "desc" ]],
    responsive: true
  });
});

function generarReporte(){
  const url = base_url + "Reportes/generarCorte";
  let saldoIniciar = $('#cambioInicial').val();

  if (saldoIniciar >= 300) {
    Swal.fire({
      title: "Generar Corte",
      text: "Desea generar corte de caja",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "SI, generar",
      confirmButtonCancel: "Cancelar"
    }).then((result) => {
      if (result.isConfirmed) {
        $.post(url,{"saldoIniciar": saldoIniciar},function (response){
          // console.log(response);
          res = JSON.parse(response);
          if(res=== "Ok"){
            Swal.fire({
              title: "Corte Caja",
              text: "Corte creado exitosamente.",
              icon: "success",
              showConfirmButton: false,
              timer: 1500
            });
            $('#TblCorteCaja').DataTable().ajax.reload();
          }else{
            Swal.fire({
              title: "Advertencia",
              text: "El dia de hoy ya se hizo el corte.",
              icon: "warning",
              showConfirmButton: false,
              timer: 1500
            });
          }
          $('#cambioInicial').focus();
          $('#cambioInicial').val('');
        });
      }
    });
  }else{
    Swal.fire({
      title: "Advertencia",
      text: "El cambio Inicial debe ser mayor o igual a 300 pesos",
      icon: "warning",
      showConfirmButton: false,
      timer: 1500
    });
  }
}

function btnVerDetalles(idCorte){
  // console.log('VER DETALLES: ' + fechaCorte);
  $('#contenidoTabla').html('');
  $('#regreso').removeClass('d-none');

  const url = base_url + "Reportes/verProveedores";
  let gananciaProv = 0;
  let resusrtirPro = 0;

  htmlContent = `<table id="TblCorteCaja" class="table table-light">
  <thead class="thead-dark">
    <tr>
      <th>PROVEEDOR</th>
      <th>RESURTIR</th>
      <th>GANANCIA</th>
    </tr>
  </thead>
  <tbody>`;


  $.post(url,{"idCorte": idCorte},function (response){
    // console.log(response);
    res = JSON.parse(response);

    const url = base_url + "Reportes/verDetalles";

    res.forEach(row => {
      $.post(url,{"idCorte": idCorte, "idProveedor": row['ID_PROVEEDOR']},function (response){
        // console.log(response);
        resDetalles = JSON.parse(response);

        resDetalles.forEach(fila => {
          gananciaProv += (fila['CANTIDAD'] * fila['PRECIO_VENTA']) - (fila['CANTIDAD'] * fila['PRECIO_COMPRA']) ; 
          resusrtirPro += (fila['CANTIDAD'] * fila['PRECIO_COMPRA']);
        });

        htmlContent += `<tr>
          <td>${row['DES_PROVEEDOR']}</td>
          <td>$ ${resusrtirPro.toFixed(2)}</td>
          <td>$ ${gananciaProv.toFixed(2)}</td>
        </tr>`;

        $('#contenidoTabla').html(htmlContent);
        gananciaProv = 0;
        resusrtirPro = 0;
      });
    });
  });
}
