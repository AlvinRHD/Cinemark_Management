<?php
include_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $con = new mysqli("localhost", "root", "", "cinemark_db");
    $fecha_inicio = isset($_POST["fecha_inicio"]) ? $_POST["fecha_inicio"] : "";
    $fecha_fin = isset($_POST["fecha_fin"]) ? $_POST["fecha_fin"] : "";

    // Consulta SQL para obtener la cantidad de boletos vendidos en el rango de fechas
    $consulta = "SELECT fecha, SUM(cantidad_boletos) AS total_asistentes
                 FROM ventas
                 WHERE fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'
                 GROUP BY fecha
                 ORDER BY fecha ASC";

    $ejecutar = mysqli_query($con, $consulta);

    $data = [];
    $fechas = [];
    // Corrección: Aseguramos que el resultado de la consulta se recorra adecuadamente
    while ($fila = mysqli_fetch_assoc($ejecutar)) {
        $data[] = $fila['total_asistentes'];
        $fechas[] = "'" . $fila['fecha'] . "'";
    }
    // Cierre de la conexión
    mysqli_close($con);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Gráfico de Asistentes</title>
</head>
<body>
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <script>
    // Generación del gráfico con los datos obtenidos de la consulta
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
            categories: [<?php echo implode(",", $fechas); ?>], // Corrección aplicada aquí
            title: {
                text: 'Fecha'
            }
        },
        series: [{
            name: 'Asistentes',
            data: [<?php echo implode(",", $data); ?>] // Corrección aplicada aquí
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
</body>
</html>
<?php } ?>
