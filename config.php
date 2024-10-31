<?php 

$server='localhost';
$user = 'root';
<<<<<<< HEAD
$pass = 'cocodrilo122';
=======
$pass = '';
>>>>>>> 955a2b22cd683c9f21966466fd1dad45f7e11cf9
$db = 'cinemark_db';

$conexion = new mysqli($server, $user, $pass, $db);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}