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
  <title>Gráfico de Asistentes al Cine</title>
</head>

<body>
  <form>
    <input type="date" name="fecha_inicio" id="fecha_inicio" placeholder="Fecha de inicio">
    <input type="date" name="fecha_fin" id="fecha_fin" placeholder="Fecha de fin">
  </form>

  <figure class="highcharts-figure">
    <div id="container"></div>
  </figure>

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
              // Insertar el nuevo gráfico en el contenedor
              $('#container').html(response);
            },
            error: function() {
              alert("Error al cargar el gráfico. Verifica los datos o revisa la conexión.");
            }
          });
        }
      });
    });
  </script>
</body>
</html>
