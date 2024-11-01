<?php 

$server='localhost';
$user = 'root';
$pass = '';
$db = 'cinemark_db';

$conexion = new mysqli($server, $user, $pass, $db);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}