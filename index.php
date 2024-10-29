<?php
session_start(); // Iniciar sesión

// Si el usuario no ha iniciado sesión, redirigir a login.php
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login/login.php");
    exit(); // Asegurarse de detener la ejecución del script
}
?>



<!DOCTYPE html>
<html>
<head>
    <title>Gestión de Cine</title>
</head>
<body>
    <h1>Bienvenido al Sistema de Gestión de Cine</h1>
    <ul>
        <li><a href="pages/peliculas.php">Administrar Películas</a></li>
        <li><a href="pages/salas.php">Administrar Salas</a></li>
        <li><a href="pages/funciones.php">Administrar Funciones</a></li>
        <li><a href="pages/usuarios.php">Administrar Usuarios</a></li>
        <li><a href="login/logout.php">Cerrar Sesión</a></li> 

    </ul>
</body>
</html>
