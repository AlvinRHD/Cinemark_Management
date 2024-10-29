<?php

include_once '../config.php';
include_once '../functions/gestionar.php';

//USUARIOS
function agregarUsuario($nombre, $email, $contrasena, $rol) {
    global $conexion;
    $hash_contrasena = password_hash($contrasena, PASSWORD_DEFAULT); // Encriptar contraseña
    $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, email, contrasena, rol) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nombre, $email, $hash_contrasena, $rol);
    $stmt->execute();
    $stmt->close();
}
function autenticarUsuario($email, $password) {
    global $conexion;
    $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $usuario = $result->fetch_assoc();

    if ($usuario && password_verify($password, $usuario['contrasena'])) {
        return $usuario;
    }
    return false;
}

function obtenerUsuarios() {
    global $conexion;
    $result = $conexion->query("SELECT id_usuario, nombre, email, rol FROM usuarios");
    return $result->fetch_all(MYSQLI_ASSOC);
}
//USUARIOS



function agregarPelicula($titulo, $descripcion, $duracion, $clasificacion, $genero) {
    global $conexion;
    $stmt = $conexion->prepare("INSERT INTO peliculas (titulo, descripcion, duracion, clasificacion, genero) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiss", $titulo, $descripcion, $duracion, $clasificacion, $genero);
    $stmt->execute();
    $stmt->close();
}


function agregarSala($nombre, $capacidad) {
    global $conexion;
    $stmt = $conexion->prepare("INSERT INTO salas (nombre, capacidad) VALUES (?, ?)");
    $stmt->bind_param("si", $nombre, $capacidad);
    $stmt->execute();
    $stmt->close();
}


function agregarFuncion($id_pelicula, $id_sala, $horario, $fecha) {
    global $conexion;
    $stmt = $conexion->prepare("INSERT INTO funciones (id_pelicula, id_sala, horario, fecha) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $id_pelicula, $id_sala, $horario, $fecha);
    $stmt->execute();
    $stmt->close();
}


function obtenerPeliculas() {
    global $conexion;
    $result = $conexion->query("SELECT * FROM peliculas");
    return $result->fetch_all(MYSQLI_ASSOC);
}

function obtenerSalas() {
    global $conexion;
    $result = $conexion->query("SELECT * FROM salas");
    return $result->fetch_all(MYSQLI_ASSOC);
}

function obtenerFunciones() {
    global $conexion;
    $query = "
        SELECT f.*, p.titulo as pelicula, s.nombre as sala
        FROM funciones f
        JOIN peliculas p ON f.id_pelicula = p.id_pelicula
        JOIN salas s ON f.id_sala = s.id_sala
    ";
    $result = $conexion->query($query);
    return $result->fetch_all(MYSQLI_ASSOC);
}



?>
