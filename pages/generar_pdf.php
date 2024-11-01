<?php
require 'dompdf/autoload.inc.php'; 
use Dompdf\Dompdf;


$fecha_inicio = $_GET['fecha_inicio'];
$fecha_fin = $_GET['fecha_fin'];


$con = new mysqli("localhost", "root", "witty", "cinemark_db");

$consulta = "SELECT fecha, SUM(cantidad_boletos) AS total_boletos
             FROM ventas
             WHERE fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'
             GROUP BY fecha
             ORDER BY total_boletos DESC";

$ejecutar = mysqli_query($con, $consulta);

$dias_ventas = [];
while ($fila = mysqli_fetch_assoc($ejecutar)) {
    $dias_ventas[] = $fila;
}


$dia_mayor_venta = $dias_ventas[0] ?? null;
$dia_menor_venta = end($dias_ventas) ?? null;


$html = "<h1>Analisis de Ventas</h1>";
$html .= "<p><strong>Periodo de análisis:</strong> $fecha_inicio a $fecha_fin</p>";

if ($dia_mayor_venta && $dia_menor_venta) {
    $html .= "<p><strong>Día con mayor venta:</strong> {$dia_mayor_venta['fecha']} - {$dia_mayor_venta['total_boletos']} boletos vendidos.</p>";
    $html .= "<p><strong>Día con menor venta:</strong> {$dia_menor_venta['fecha']} - {$dia_menor_venta['total_boletos']} boletos vendidos.</p>";
} else {
    $html .= "<p>No se encontraron datos en el periodo seleccionado.</p>";
}


$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();


$dompdf->stream("Analisis_Ventas_$fecha_inicio-$fecha_fin.pdf", ["Attachment" => 1]);

mysqli_close($con);
?>
