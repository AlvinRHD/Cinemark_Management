<?php
header('Content-Type: application/json'); // Asegura que el tipo de contenido sea JSON
include_once '../config.php';
include_once '../functions/gestionar.php';

if (isset($_GET['id_funcion'])) {
    $id_funcion = $_GET['id_funcion'];
    $funcion = obtenerFuncionPorId($id_funcion);  // Asegúrate de que esta función esté correctamente implementada

    if ($funcion) {
        $capacidad = $funcion['capacidad'];
        $asientosOcupados = json_decode($funcion['asientos_ocupados'], true) ?? [];
        
        echo json_encode([
            'capacidad' => $capacidad,
            'asientosOcupados' => $asientosOcupados
        ]);
    } else {
        echo json_encode(['error' => 'Función no encontrada']);
    }
} else {
    echo json_encode(['error' => 'ID de función no especificado']);
}
?>
