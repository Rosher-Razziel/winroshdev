console.log("LLEGUE  A HISTORIAL DE VENTAS");

const Toast = Swal.mixin({
  toast: true,
  position: "bottom-end",
  showConfirmButton: false,
  timer: 2000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.onmouseenter = Swal.stopTimer;
    toast.onmouseleave = Swal.resumeTimer;
  }
});

setInterval(function() { 
 let today = new Date();
 let day = today.getDate();
 let month = today.getMonth() + 1;
 let year = today.getFullYear();
 let fecha = year + '-' + month + '-' + day;
  obtenerTickets(fecha);    
}, 300000);

$( "#fechaTickets" ).on( "change", function() {
  let fechaTickets = $('#fechaTickets').val();
  obtenerTickets(fechaTickets);
});

function obtenerTickets(fechaTickets){
  const url = base_url + 'HistorialVentas/getTicketsFecha/' + fechaTickets;
  // console.log(fechaTickets);
  if(fechaTickets != ""){
    $.post(url, function (response){
      // console.log(response);
      res = JSON.parse(response);
      let html = '', sumaTotal = 0;
      let ticketsCount = res.length;

      if(res != false){
        res.forEach(row => {
          html += `<div class="col-sm-6 col-md-4 col-lg-4 mt-2">
            <div class="card border-secondary mb-2 text-center">
              <div class="card-header">Folio: ${row['FOLIO_TICKET']}</div>
              <div class="card-body text-secondary">
                <div class="row mb-2">
                  <div class="col-md-12">
                    <h5 class="card-title">La Ventanita</h5>
                  </div>
                  <div class="col-md-4">
                    <p class="card-text"># ${row['ID_VENTA']}</p>
                  </div>
                  <div class="col-md-4">
                    <p class="card-text">${row['HORA_VENTA'].substring(0, 5)} hrs</p>
                  </div>
                  <div class="col-md-4">
                    <p class="card-text">$${row['TOTAL_TICKET']}</p>
                  </div>
                </div>
                <button type="button" class="btn btn-secondary" onclick="verTicket(${row['ID_VENTA']})">Imprimir</button>
                <button type="button" class="btn btn-primary" onclick="obtenerTicketModel(${row['ID_VENTA']})">Ver</button>
              </div>
            </div>
          </div>`;

          sumaTotal += parseFloat(row['TOTAL_TICKET']) + 0;

        });
        
        $('#ventaTotalDia').html('$' + sumaTotal.toFixed(2));
        $('#totalTickets').html(ticketsCount);
        $('#contenidoTickets').html(html);

      }else{
        Swal.fire({
          title: "Advertencia",
          text: "Sin tickets la fecha seleccionada",
          icon: "warning",
          showConfirmButton: false,
          timer: 1500
        });
        $('#proveedor').val(0);
        $('#tblContenido').html('');
      }
    });
  }
}

function verTicket(idVenta){
  const url = base_url + 'Ventas/generarPdf/' + idVenta;
  window.open(url);
}

$("#ticketFolio" ).on( "keyup", function() {
  // console.log("BISCAMOS TICKET POR FOLIO");
  let fechaTickets = $('#fechaTickets').val();
  let folioTickets = $('#ticketFolio').val();
  const url = base_url + 'HistorialVentas/getTicketsFolio/' + folioTickets;
  if(folioTickets == ""){
    obtenerTickets(fechaTickets);
  }

  if (folioTickets.length >= 5) {
    $.post(url, function (response){
      // console.log(response);
      res = JSON.parse(response);
      let html = '', sumaTotal = 0;
      let ticketsCount = res.length;
  
      if(res != false){
        res.forEach(row => {
          html += `<div class="col-sm-6 col-md-4 col-lg-4 mt-2">
            <div class="card border-secondary mb-2 text-center">
              <div class="card-header">Folio: ${row['FOLIO_TICKET']}</div>
              <div class="card-body text-secondary">
                <div class="row mb-2">
                  <div class="col-md-12">
                    <h5 class="card-title">La Ventanita</h5>
                  </div>
                  <div class="col-md-4">
                    <p class="card-text"># ${row['ID_VENTA']}</p>
                  </div>
                  <div class="col-md-4">
                    <p class="card-text">${row['HORA_VENTA'].substring(0, 5)} hrs</p>
                  </div>
                  <div class="col-md-4">
                    <p class="card-text font-weight-bold">$${row['TOTAL_TICKET']}</p>
                  </div>
                </div>
                <button type="button" class="btn btn-secondary" onclick="verTicket(${row['ID_VENTA']})">Imprimir</button>
                <button type="button" class="btn btn-primary" onclick="obtenerTicketModel(${row['ID_VENTA']})">Ver</button>
              </div>
            </div>
          </div>`;
  
          sumaTotal += parseFloat(row['TOTAL_TICKET']);
  
        });
        $('#ventaTotalDia').html('$ '+sumaTotal.toFixed(2));
        $('#totalTickets').html(ticketsCount);
        $('#contenidoTickets').html(html);
  
      }else{
        Toast.fire({
          icon: "warning",
          title: "Toicket no encotrado."
        });
        $('#proveedor').val(0);
        $('#tblContenido').html('');
      }
    }); 
  }
} );

function obtenerTicketModel(idVenta){
  // $('#contenido').html(html);  
  console.log(idVenta);
  $('#ticket_modal').modal("show");
}