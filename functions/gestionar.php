<?php

include_once(__DIR__ . '/../config.php');

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



// function agregarPelicula($titulo, $descripcion, $duracion, $clasificacion, $genero) {
//     global $conexion;
//     $stmt = $conexion->prepare("INSERT INTO peliculas (titulo, descripcion, duracion, clasificacion, genero) VALUES (?, ?, ?, ?, ?)");
//     $stmt->bind_param("ssiss", $titulo, $descripcion, $duracion, $clasificacion, $genero);
//     $stmt->execute();
//     $stmt->close();
// }
function agregarPelicula($titulo, $descripcion, $duracion, $clasificacion, $genero, $imagen) {
    global $conexion;
    
    // Mueve la imagen subida a una carpeta específica
    $nombreImagen = basename($imagen['name']);
    $rutaImagen = "../uploads/" . $nombreImagen;
    move_uploaded_file($imagen['tmp_name'], $rutaImagen);

    $stmt = $conexion->prepare("INSERT INTO peliculas (titulo, descripcion, duracion, clasificacion, genero, imagen) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssisss", $titulo, $descripcion, $duracion, $clasificacion, $genero, $nombreImagen);
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


// function agregarFuncion($id_pelicula, $id_sala, $horario, $fecha) {
//     global $conexion;
//     $stmt = $conexion->prepare("INSERT INTO funciones (id_pelicula, id_sala, horario, fecha) VALUES (?, ?, ?, ?)");
//     $stmt->bind_param("iiss", $id_pelicula, $id_sala, $horario, $fecha);
//     $stmt->execute();
//     $stmt->close();
// }

function agregarFuncion($id_pelicula, $id_sala, $horario, $fecha) {
    global $conexion;

    // Verificar si la sala está ocupada
    $salaSeleccionada = obtenerSalaPorId($id_sala);
    if ($salaSeleccionada['estado'] === 'ocupada') {
        echo "<script>alert('La sala seleccionada está ocupada. Por favor, elige otra sala.');</script>";
        return; // Termina la ejecución si la sala está ocupada
    }

    // Si la sala está disponible, agrega la función
    $stmt = $conexion->prepare("INSERT INTO funciones (id_pelicula, id_sala, horario, fecha) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $id_pelicula, $id_sala, $horario, $fecha);
    $stmt->execute();
    $stmt->close();
}

function obtenerFuncionesSemanaActual() {
    global $conexion;
    $query = "
        SELECT f.*, p.titulo as pelicula, p.imagen as imagen, s.nombre as sala
        FROM funciones f
        JOIN peliculas p ON f.id_pelicula = p.id_pelicula
        JOIN salas s ON f.id_sala = s.id_sala
        WHERE YEARWEEK(f.fecha, 1) = YEARWEEK(CURDATE(), 1)
        ORDER BY f.fecha, f.horario";
    $result = $conexion->query($query);
    return $result->fetch_all(MYSQLI_ASSOC);
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

function obtenerSalaPorId($id_sala) {
    global $conexion;
    $stmt = $conexion->prepare("SELECT * FROM salas WHERE id_sala = ?");
    $stmt->bind_param("i", $id_sala);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function obtenerFunciones() {
    global $conexion;
    $query = "
        SELECT f.id_funcion, f.id_pelicula, f.id_sala, f.horario, f.fecha,
               p.titulo AS pelicula, p.imagen AS imagen_pelicula,
               s.nombre AS sala
        FROM funciones f
        JOIN peliculas p ON f.id_pelicula = p.id_pelicula
        JOIN salas s ON f.id_sala = s.id_sala
    ";
    $result = $conexion->query($query);
    return $result->fetch_all(MYSQLI_ASSOC);
}



?>
