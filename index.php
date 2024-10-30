<?php
include_once 'config.php';
include_once 'functions/gestionar.php';

session_start();

// Obtener funciones de la semana actual
$funcionesSemana = obtenerFuncionesSemanaActual();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Cine</title>
</head>
<body>
    <h1>Bienvenido al Sistema de Gestión de Cine</h1>
    <ul>
        <?php 
            if ($_SESSION['rol'] == 'empleado'){
                echo '<li><a href="pages/salas.php">Administrar Salas</a></li>';
                echo '<li><a href="pages/ventas.php">Administrar Ventas</a></li>';
            }
            if ($_SESSION['rol'] == 'gerente'){
                echo '<li><a href="pages/peliculas.php">Administrar Películas</a></li>';
                echo '<li><a href="pages/salas.php">Administrar Salas</a></li>';
                echo '<li><a href="pages/funciones.php">Administrar Funciones</a></li>';
                echo '<li><a href="pages/ventas.php">Administrar Ventas</a></li>';
                //echo '<li><a href="pages/usuarios.php">Administrar Usuarios</a></li>';
                echo '<li><a href="#">Analisis de datos</a></li>';
            }
            else if ($_SESSION['rol'] == 'administrador') {
                echo '<li><a href="pages/peliculas.php">Administrar Películas</a></li>';
                echo '<li><a href="pages/salas.php">Administrar Salas</a></li>';
                echo '<li><a href="pages/funciones.php">Administrar Funciones</a></li>';
                echo '<li><a href="pages/ventas.php">Administrar Ventas</a></li>';
                echo '<li><a href="pages/usuarios.php">Administrar Usuarios</a></li>';
                echo '<li><a href="#">Analisis de datos</a></li>';

            }   
        ?>
        <li><a href="auth/logout.php">Cerrar Sesión</a></li> 
    </ul>

    <h2>Funciones de esta Semana</h2>
    <?php if (!empty($funcionesSemana)): ?>
        <ul>
            <?php foreach ($funcionesSemana as $funcion): ?>
                <li>
                <img src="uploads/<?php echo $funcion['imagen']; ?>" alt="<?php echo $funcion['pelicula']; ?>" style="width:100px;"><br>
                    <strong><?php echo $funcion['pelicula']; ?></strong><br>
                    Sala: <?php echo $funcion['sala']; ?><br>
                    Fecha: <?php echo date('d-m-Y', strtotime($funcion['fecha'])); ?><br>
                    Horario: <?php echo $funcion['horario']; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No hay funciones programadas para esta semana.</p>
    <?php endif; ?>
</body>
</html>



