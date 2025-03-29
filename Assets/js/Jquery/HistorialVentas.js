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

const REFRESH_INTERVAL = 300000; // 5 minutos
setInterval(() => {
  let fecha = new Date().toISOString().split('T')[0];
  $('#fechaTickets').val(fecha);
  obtenerTickets(fecha);
}, REFRESH_INTERVAL);

$("#fechaTickets").on("change", function() {
  let fechaTickets = $('#fechaTickets').val();
  obtenerTickets(fechaTickets);
});

async function obtenerTickets(fechaTickets) {
  if (fechaTickets) {
    const url = `${base_url}HistorialVentas/getTicketsFecha/${fechaTickets}`;
    try {
      const response = await fetch(url, { method: 'POST' });
      const res = await response.json();
      actualizarVistaTickets(res);
    } catch (error) {
      console.error("Error fetching tickets:", error);
    }
  }
}

$("#ticketFolio").on("keyup", function(e) {
  let fechaTickets = $('#fechaTickets').val();
  let folioTickets = $('#ticketFolio').val();
  const url = `${base_url}HistorialVentas/getTicketsFolio/${folioTickets}`;

  if (e.which === 13 && folioTickets !== "") {
    obtenerTicketsPorFolio(url);
  }else{
    if(folioTickets === '' && e.which === 13){
      obtenerTickets(fechaTickets);
    }
  }
});

function actualizarVistaTickets(tickets) {
  let sumaTotal = tickets.reduce((acumulador, row) => acumulador + parseFloat(row['TOTAL_TICKET']), 0);
  let html = tickets.map(generarHtmlTicket).join('');

  $('#ventaTotalDia').html(`$ ${sumaTotal.toFixed(2)}`);
  $('#totalTickets').html(tickets.length);
  $('#contenidoTickets').html(html);

  if (tickets.length === 0) {
    mostrarAlerta("Sin tickets en la fecha seleccionada", "warning");
  }
}


function generarHtmlTicket(row) {
  return `
    <div class="col-sm-6 col-md-4 col-lg-4 mt-2">
      <div class="card border-secondary mb-2 text-center">
        <div class="card-header">Folio: ${row.FOLIO_TICKET}</div>
        <div class="card-body text-secondary">
          <div class="row mb-2">
            <div class="col-md-12">
              <h5 class="card-title">La Ventanita</h5>
            </div>
            <div class="col-md-4">
              <p class="card-text"># ${row.ID_VENTA}</p>
            </div>
            <div class="col-md-4">
              <p class="card-text">${row.HORA_VENTA.substring(0, 5)} hrs</p>
            </div>
            <div class="col-md-4">
              <p class="card-text">$${row.TOTAL_TICKET}</p>
            </div>
          </div>
          <button type="button" class="btn btn-secondary" onclick="verTicket(${row.ID_VENTA})">Imprimir</button>
          <button type="button" class="btn btn-primary" onclick="obtenerTicketModel(${row.ID_VENTA})">Ver</button>
        </div>
      </div>
    </div>`;
}

function verTicket(idVenta) {
  const url = `${base_url}Ventas/generarPdf/${idVenta}`;
  window.open(url);
}

async function obtenerTicketsPorFolio(url) {
  try {
    const response = await fetch(url, { method: 'POST' });
    const res = await response.json();
    actualizarVistaTickets(res);
  } catch (error) {
    console.error("Error fetching tickets:", error);
  }
}

function obtenerTicketModel(idVenta) {
  console.log(idVenta);
  const url = `${base_url}Ventas/generarPdf/${idVenta}`;
  console.log("abrir modal");
  $('#ticket_modal').modal("show");
}

function mostrarAlerta(mensaje, tipo) {
  Swal.fire({
    title: tipo === "warning" ? "Advertencia" : "Información",
    text: mensaje,
    icon: tipo,
    showConfirmButton: false,
    timer: 1500
  });
}
