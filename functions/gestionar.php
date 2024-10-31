<?php

include_once(__DIR__ . '/../config.php');




///////////////////////////////////
function agregarVenta($id_funcion, $cantidad_boletos, $total) {
    global $conexion;

    // Obtener la capacidad y asientos ocupados de la función
    $funcion = obtenerFuncionPorId($id_funcion);
    $asientosOcupados = json_decode($funcion['asientos_ocupados'], true) ?? [];

    if (count($asientosOcupados) + $cantidad_boletos > $funcion['capacidad']) {
        echo "No hay suficientes asientos disponibles.";
        return false;
    }

    // Marcar nuevos asientos ocupados
    for ($i = 0; $i < $cantidad_boletos; $i++) {
        $asientosOcupados[] = $i;
    }

    // Actualizar asientos ocupados
    $stmt = $conexion->prepare("UPDATE funciones SET asientos_ocupados = ? WHERE id_funcion = ?");
    $stmt->bind_param("si", json_encode($asientosOcupados), $id_funcion);
    $stmt->execute();

    // Insertar la venta
    $stmt = $conexion->prepare("INSERT INTO ventas (id_funcion, cantidad_boletos, total, fecha) VALUES (?, ?, ?, CURDATE())");
    $stmt->bind_param("iid", $id_funcion, $cantidad_boletos, $total);
    $stmt->execute();
    $stmt->close();
    return true;
}
////////////////////////



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



function agregarFuncion($id_pelicula, $id_sala, $horario, $fecha, $precio) {
    global $conexion;

    // Verificar si la sala está ocupada
    $salaSeleccionada = obtenerSalaPorId($id_sala);
    if ($salaSeleccionada['estado'] === 'ocupada') {
        echo "<script>alert('La sala seleccionada está ocupada. Por favor, elige otra sala.');</script>";
        return;
    }

    

    // Insertar la función con el precio
    $stmt = $conexion->prepare("INSERT INTO funciones (id_pelicula, id_sala, horario, fecha, precio) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iissd", $id_pelicula, $id_sala, $horario, $fecha, $precio);
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


function obtenerSalasDisponibles() {
    global $conexion;
    $query = "SELECT * FROM salas WHERE estado = 'disponible'";
    $resultado = $conexion->query($query);
    return $resultado->fetch_all(MYSQLI_ASSOC);
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
                f.precio,
               p.titulo AS pelicula, p.imagen AS imagen_pelicula,
               s.nombre AS sala
        FROM funciones f
        JOIN peliculas p ON f.id_pelicula = p.id_pelicula
        JOIN salas s ON f.id_sala = s.id_sala
    ";
    $result = $conexion->query($query);
    return $result->fetch_all(MYSQLI_ASSOC);
}

function obtenerFuncionPorId($id_funcion) {
    global $conexion;
    $stmt = $conexion->prepare("SELECT f.*, s.capacidad FROM funciones f JOIN salas s ON f.id_sala = s.id_sala WHERE f.id_funcion = ?");
    $stmt->bind_param("i", $id_funcion);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}


function obtenerPrecioFuncion($id_funcion) {
    global $conexion;
    $stmt = $conexion->prepare("SELECT precio FROM funciones WHERE id_funcion = ?");
    $stmt->bind_param("i", $id_funcion);
    $stmt->execute();
    $result = $stmt->get_result();
    $funcion = $result->fetch_assoc();
    return $funcion['precio'];
}

// function procesarVenta($id_funcion, $asientosSeleccionados, $precioTotal) {
//     global $conexion;

//     // Obtener asientos ocupados actuales de la función
//     $funcion = obtenerFuncionPorId($id_funcion);
//     $asientosOcupados = json_decode($funcion['asientos_ocupados'], true) ?? [];

//     // Verificar si los asientos seleccionados ya están ocupados
//     foreach ($asientosSeleccionados as $asiento) {
//         if (in_array($asiento, $asientosOcupados)) {
//             echo "El asiento $asiento ya está ocupado. Selecciona otros asientos.";
//             return false;
//         }
//     }

//     // Actualizar la lista de asientos ocupados con los seleccionados en esta venta
//     $asientosOcupados = array_merge($asientosOcupados, $asientosSeleccionados);
//     $asientosOcupadosJson = json_encode($asientosOcupados);

//     // Guardar los nuevos asientos ocupados en la base de datos
//     $stmt = $conexion->prepare("UPDATE funciones SET asientos_ocupados = ? WHERE id_funcion = ?");
//     $stmt->bind_param("si", $asientosOcupadosJson, $id_funcion);
//     $stmt->execute();

//     // Registrar la venta en la tabla de ventas
//     $cantidadBoletos = count($asientosSeleccionados);
//     $stmt = $conexion->prepare("INSERT INTO ventas (id_funcion, cantidad_boletos, total, fecha) VALUES (?, ?, ?, CURDATE())");
//     $stmt->bind_param("iid", $id_funcion, $cantidadBoletos, $precioTotal);
//     $stmt->execute();
//     $stmt->close();

//     return true;
// }

function procesarVenta($id_funcion, $asientosSeleccionados, $precioTotal) {
    global $conexion;

    // Obtener asientos ocupados actuales de la función
    $funcion = obtenerFuncionPorId($id_funcion);
    $asientosOcupados = json_decode($funcion['asientos_ocupados'], true) ?? [];

    // Verificar si los asientos seleccionados ya están ocupados
    foreach ($asientosSeleccionados as $asiento) {
        if (in_array($asiento, $asientosOcupados)) {
            // Mostrar alerta y detener el procesamiento de la venta
            echo "<script>alert('El asiento $asiento ya está ocupado. Por favor, selecciona otros asientos.');</script>";
            return false;
        }
    }

    // Actualizar la lista de asientos ocupados con los seleccionados en esta venta
    $asientosOcupados = array_merge($asientosOcupados, $asientosSeleccionados);
    $asientosOcupadosJson = json_encode($asientosOcupados);

    // Guardar los nuevos asientos ocupados en la base de datos
    $stmt = $conexion->prepare("UPDATE funciones SET asientos_ocupados = ? WHERE id_funcion = ?");
    $stmt->bind_param("si", $asientosOcupadosJson, $id_funcion);
    $stmt->execute();

    // Registrar la venta en la tabla de ventas
    $cantidadBoletos = count($asientosSeleccionados);
    $stmt = $conexion->prepare("INSERT INTO ventas (id_funcion, cantidad_boletos, total, fecha) VALUES (?, ?, ?, CURDATE())");
    $stmt->bind_param("iid", $id_funcion, $cantidadBoletos, $precioTotal);
    $stmt->execute();
    $stmt->close();

    // Confirmación de compra exitosa
    echo "<script>alert('Compra realizada con éxito.'); window.location.href = 'pagina_de_exito.php';</script>";
    return true;
}





?>
