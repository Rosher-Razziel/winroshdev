console.log("LLEGUE A DASHBOARD");

$(document).ready(function () {
  // Llamar a todas las funciones necesarias en una sola línea
  ["productosMasVendidos", "productosPocoStock", "productosVentaDia", "productosVentaSemana", "productosVentaMes", "productosGanancias"].forEach(func => window[func]());
});

// GRAFICA PRODUCTO MAS VENDIDOS
function productosMasVendidos() {
  const url = base_url + "DashBoard/obtenerDatos";
  $.post(url, function (response) {
    const res = JSON.parse(response);
    const nombre = res.map(item => item['PRODUCTO'].substr(0, 30)).reverse();
    const cantidad = res.map(item => parseInt(item['TOTALVENTAS'])).reverse();

    renderChart("graficaMasVendidos", "Total Vendidos", nombre, cantidad, 'rgba(255, 20, 147, 1)');
  });
}

// GRAFICA PRODUCTOS CON POCO STOCK
function productosPocoStock() {
  const url = base_url + "DashBoard/obtenerProdPocoStock";
  $.post(url, function (response) {
    const res = JSON.parse(response);
    const nombre = res.map(item => item['PRODUCTO'].substr(0, 15));
    const cantidad = res.map(item => parseInt(item['EXISTENCIAS']));

    renderChart("graficaPocoStock", "Existencias", nombre, cantidad, 'rgba(0, 128, 255, 1)');
  });
}

// GRAFICA VENTA DEL DIA
function productosVentaDia() {
  const url = base_url + "DashBoard/obtenerVentasDia";
  $.post(url, function (response) {
    const res = JSON.parse(response);
    const nombre = res.map(item => item['FECHA_VENTA'].substr(0, 15)).reverse();
    const cantidad = res.map(item => parseFloat(item['TOTAL_TICKET'])).reverse();

    renderChart("graficaVentasDia", "Venta", nombre, cantidad, 'rgba(255, 0, 0, 1)');
  });
}

// GRAFICA VENTA DEL SEMANA
function productosVentaSemana() {
  const url = base_url + "DashBoard/obtenerVentasSemana";
  $.post(url, function (response) {
    const res = JSON.parse(response);
    const nombre = res.map(item => 'Sem: ' + item['SEMANA']).reverse();
    const cantidad = res.map(item => parseFloat(item['TOTAL_SEMANA'])).reverse();

    renderChart("graficaVentaMes", "Venta", nombre, cantidad, 'rgba(50, 205, 50, 1)');
  });
}

// GRAFICA VENTA DEL MES
function productosVentaMes() {
  const url = base_url + "DashBoard/obtenerVentasAnio";
  $.post(url, function (response) {
    const res = JSON.parse(response);
    const meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    const nombre = res.map(item => meses[item['MES'] - 1]);
    const cantidad = res.map(item => parseFloat(item['TOTAL']));

    renderChart("graficaVentasanio", "Venta", nombre, cantidad, 'rgba(135, 206, 235, 1)');
  });
}

// GRAFICA DE GANANCIAS
function productosGanancias() {
  const url = base_url + "DashBoard/obtenerGanancias";
  $.post(url, function (response) {
    const res = JSON.parse(response);
    const nombre = res.map(item => item['FECHA_CORTE'].substr(0, 15)).reverse();
    const cantidad = res.map(item => parseFloat(item['GANANCIA_DEL_DIA'])).reverse();

    renderChart("graficaGanancias", "Ganancia", nombre, cantidad, 'rgba(255, 165, 0, 1)');
  });
}

// FUNCION GENERICA PARA RENDERIZAR CHARTS
function renderChart(id, label, labels, data, borderColor) {
  const ctx = document.getElementById(id);
  new Chart(ctx, {
    type: 'line',
    data: {
      labels: labels,
      datasets: [{
        label: label,
        data: data,
        borderColor: borderColor,
        backgroundColor: 'white',
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      tooltips: {
        backgroundColor: '#000000',
        titleFontSize: 20,
        xPadding: 20,
        yPadding: 20,
        bodyFontSize: 15,
        bodySpacing: 10,
        mode: 'x',
      },
      elements: {
        line: {
          borderWidth: 4,
          fill: false,
        },
        point: {
          radius: 6,
          borderWidth: 2,
          backgroundColor: 'white',
          hoverRadius: 8,
          hoverBorderWidth: 2,
        }
      },
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true
          }
        }],
      },
    }
  });
}
