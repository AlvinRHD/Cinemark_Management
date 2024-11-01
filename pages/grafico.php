<?php
include_once '../config.php';

session_start();



if (!isset($_SESSION['id_usuario'])) {
  
    header("Location: ../auth/login.php"); 
    exit();}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $con = new mysqli("localhost", "root", "witty", "cinemark_db");
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
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Gráfico de Asistencias</title>
</head>
<body>
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <script>
   
    Highcharts.chart('container', {
        title: {
            text: 'Cantidad de asistencias al cine por día',
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
            name: 'Asistencias',
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
</body>
</html>
<?php } ?>
