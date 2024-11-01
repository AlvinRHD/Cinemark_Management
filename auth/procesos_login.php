<?php
session_start();
include_once '../config.php';
include_once '../functions/gestionar.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $usuario = autenticarUsuario($email, $password);

    if ($usuario) {
        $_SESSION['id_usuario'] = $usuario['id_usuario'];
        $_SESSION['nombre'] = $usuario['nombre'];
        $_SESSION['rol'] = $usuario['rol'];
        header("Location: ../index.php");
        exit();
    } else {
        // Guardar un mensaje de error en la sesión
        $_SESSION['error'] = "Credenciales incorrectas";
        header("Location: ../index.php"); // Redirigir al formulario de inicio de sesión
        exit();
    }
}
