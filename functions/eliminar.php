<?php
include_once '../config.php';


// Función para eliminar un usuario
function eliminarUsuario($id) {
    global $conexion;
    $stmt = $conexion->prepare("DELETE FROM usuarios WHERE id_usuario = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// Función para eliminar una película
function eliminarPelicula($id) {
    global $conexion;
    $stmt = $conexion->prepare("DELETE FROM peliculas WHERE id_pelicula = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// Función para eliminar una sala
function eliminarSala($id) {
    global $conexion;
    $stmt = $conexion->prepare("DELETE FROM salas WHERE id_sala = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// Función para eliminar una función
function eliminarFuncion($id) {
    global $conexion;
    $stmt = $conexion->prepare("DELETE FROM funciones WHERE id_funcion = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}


?>