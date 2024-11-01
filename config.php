<?php 

$server='localhost';
$user = 'root';
<<<<<<< HEAD
$pass = '';
=======
$pass = 'witty';
>>>>>>> 7f23520cdc49e0a6e6da4c4fc5f24bc6b0a19642
$db = 'cinemark_db';

$conexion = new mysqli($server, $user, $pass, $db);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}