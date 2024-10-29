<?php
include_once '../config.php';

// Actualizar usuario
function actualizarUsuario($id, $nombre, $email, $contrasena, $rol) {
    global $conexion;
    $hash_contrasena = password_hash($contrasena, PASSWORD_DEFAULT); // Encriptar contraseña
    $stmt = $conexion->prepare("UPDATE usuarios SET nombre = ?, email = ?, contrasena = ?, rol = ? WHERE id_usuario = ?");
    $stmt->bind_param("ssssi", $nombre, $email, $hash_contrasena, $rol, $id);
    $stmt->execute();
    $stmt->close();
}

// Actualizar película
function actualizarPelicula($id, $titulo, $descripcion, $duracion, $clasificacion, $genero) {
    global $conexion;
    $stmt = $conexion->prepare("UPDATE peliculas SET titulo = ?, descripcion = ?, duracion = ?, clasificacion = ?, genero = ? WHERE id_pelicula = ?");
    $stmt->bind_param("ssissi", $titulo, $descripcion, $duracion, $clasificacion, $genero, $id);
    $stmt->execute();
    $stmt->close();
}



// Actualizar sala
function actualizarSala($id, $nombre, $capacidad, $estado) {
    global $conexion;
    $stmt = $conexion->prepare("UPDATE salas SET nombre = ?, capacidad = ?, estado = ? WHERE id_sala = ?");
    $stmt->bind_param("sisi", $nombre, $capacidad, $estado, $id);
    $stmt->execute();
    $stmt->close();
}



// Actualizar función
function actualizarFuncion($id, $id_pelicula, $id_sala, $horario, $fecha) {
    global $conexion;
    $stmt = $conexion->prepare("UPDATE funciones SET id_pelicula = ?, id_sala = ?, horario = ?, fecha = ? WHERE id_funcion = ?");
    $stmt->bind_param("iissi", $id_pelicula, $id_sala, $horario, $fecha, $id);
    $stmt->execute();
    $stmt->close();
}
?>
