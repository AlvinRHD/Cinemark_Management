<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <script src="https://code.highcharts.com/modules/series-label.js"></script>
  <script src="https://code.highcharts.com/modules/exporting.js"></script>
  <script src="https://code.highcharts.com/modules/export-data.js"></script>
  <script src="https://code.highcharts.com/modules/accessibility.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="../assets/css/app.css">
  <link rel="stylesheet" href="../assets/css/grid.css">
  <link rel="stylesheet" href="style.css">
  <title>Gráfico de Asistentes al Cine</title>
</head>

<body>
  <!-- Header con el botón de inicio -->
  <header style="width: 100%; display: flex; justify-content: space-between; align-items: center; padding: 10px;">
    <h1 style="margin: 0;">Análisis de Asistencia al Cine</h1>
    <button onclick="window.location.href='../index.php'" style="background-color: #8a6f97; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">
      Inicio
    </button>
  </header>

  <!-- Formulario de selección de fechas -->
  <form>
    <input type="date" name="fecha_inicio" id="fecha_inicio" placeholder="Fecha de inicio">
    <input type="date" name="fecha_fin" id="fecha_fin" placeholder="Fecha de fin">
  </form>

  <!-- Contenedor del gráfico -->
  <figure class="highcharts-figure">
    <div id="container"></div>
  </figure>

  <!-- Botón para descargar PDF -->
  <button id="descargar_pdf" style="width: 100%; max-width: 400px; padding: 12px; margin-top: 15px; background-color: #8a6f97; color: #ffffff; border: none; border-radius: 4px; cursor: pointer;">
    Descargar Análisis en PDF
  </button>

  <script>
    $(document).ready(function () {
      // Actualizar gráfico automáticamente al seleccionar ambas fechas
      $('#fecha_inicio, #fecha_fin').on('change', function () {
        var fechaInicio = $('#fecha_inicio').val();
        var fechaFin = $('#fecha_fin').val();
        
        // Ejecutar AJAX solo si ambas fechas están seleccionadas
        if (fechaInicio && fechaFin) {
          $.ajax({
            url: 'grafico.php',
            type: 'POST',
            data: { fecha_inicio: fechaInicio, fecha_fin: fechaFin },
            success: function (response) {
              $('#container').html(response);
            }
          });
        }
      });

      // Evento para generar PDF al hacer clic en el botón
      $('#descargar_pdf').on('click', function () {
        var fechaInicio = $('#fecha_inicio').val();
        var fechaFin = $('#fecha_fin').val();

        if (fechaInicio && fechaFin) {
          window.location.href = 'generar_pdf.php?fecha_inicio=' + fechaInicio + '&fecha_fin=' + fechaFin;
        } else {
          alert('Por favor selecciona ambas fechas para generar el análisis en PDF.');
        }
      });
    });
  </script>
</body>
</html>
