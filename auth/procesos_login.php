<?php
session_start();
include_once '../config.php';
include_once '../functions/gestionar.php';

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
        echo "Credenciales incorrectas";
    }
}
?>
