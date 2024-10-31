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
    <button type="button" id="mostrar_datos">Mostrar Datos</button>
  </form>

  <figure class="highcharts-figure">
    <div id="container"></div>
  </figure>

  <script>
    $(document).ready(function () {
      $('#mostrar_datos').on('click', function () {
        var fechaInicio = $('#fecha_inicio').val();
        var fechaFin = $('#fecha_fin').val();
        
        $.ajax({
          url: window.location.href,
          type: 'POST',
          data: { fecha_inicio: fechaInicio, fecha_fin: fechaFin },
          success: function (response) {
            $('#container').html($(response).find('#container').html());
          }
        });
      });
    });
  </script>

  <?php
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $con = new mysqli("localhost", "root", "", "cinemark_db");
      $fecha_inicio = isset($_POST["fecha_inicio"]) ? $_POST["fecha_inicio"] : "";
      $fecha_fin = isset($_POST["fecha_fin"]) ? $_POST["fecha_fin"] : "";

      $consulta = "SELECT fecha, SUM(cantidad_boletos) AS total_asistentes
                   FROM ventas
                   WHERE fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'
                   GROUP BY fecha
                   ORDER BY fecha ASC";

      $ejecutar = mysqli_query($con, $consulta);

      $data = [];
      $fechas = [];
      while ($fila = mysqli_fetch_assoc($ejecutar)) {
          $data[] = $fila['total_asistentes'];
          $fechas[] = "'" . $fila['fecha'] . "'";
      }
      mysqli_close($con);
  ?>
  <script>
    Highcharts.chart('container', {
        title: {
            text: 'Cantidad de asistentes al cine por día',
            align: 'left'
        },
        subtitle: {
            text: 'Fuente: cinemark_db',
            align: 'left'
        },
        yAxis: {
            title: {
                text: 'Total de Asistentes'
            }
        },
        xAxis: {
            categories: [<?php echo implode(",", $fechas); ?>],
            title: {
                text: 'Fecha'
            }
        },
        series: [{
            name: 'Asistentes',
            data: [<?php echo implode(",", $data); ?>]
        }],
        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    }
                }
            }]
        }
    });
  </script>
  <?php } ?>

</body>
</html>
