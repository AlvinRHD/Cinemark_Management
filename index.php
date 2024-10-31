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
    <link rel="stylesheet" href="./assets/css/app.css">
    <link rel="stylesheet" href="./assets/css/grid.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/index.css">
</head>
<body>
    <!-- NAV -->
    <div class="nav-wrapper">
        <div class="container">
            <div class="nav">
                <a href="#" class="logo"><i class="bx bx-movie-play bx-tada main-color"></i> Gestión <span class="main-color">Cine</span></a>
                <ul class="nav-menu" id="nav-menu">
                    <?php if ($_SESSION['rol'] == 'empleado'): ?>
                        <li><a href="pages/salas.php">Administrar Salas</a></li>
                        <li><a href="pages/ventas.php">Administrar Ventas</a></li>
                    <?php elseif ($_SESSION['rol'] == 'gerente'): ?>
                        <li><a href="pages/peliculas.php">Administrar Películas</a></li>
                        <li><a href="pages/salas.php">Administrar Salas</a></li>
                        <li><a href="pages/funciones.php">Administrar Funciones</a></li>
                        <li><a href="pages/ventas.php">Administrar Ventas</a></li>
                        <li><a href="pages/index.php" class="analisis-datos">Análisis<br>de Datos</a></li>
                    <?php elseif ($_SESSION['rol'] == 'administrador'): ?>
                        <li><a href="pages/peliculas.php">Administrar Películas</a></li>
                        <li><a href="pages/salas.php">Administrar Salas</a></li>
                        <li><a href="pages/funciones.php">Administrar Funciones</a></li>
                        <li><a href="pages/ventas.php">Administrar Ventas</a></li>
                        <li><a href="pages/usuarios.php">Administrar Usuarios</a></li>
                        <li><a href="pages/index.php" class="analisis-datos">Análisis <br>de Datos</a></li>
                    <?php endif; ?>
                    <li><a href="auth/logout.php" class="btn btn-hover"><span>Cerrar Sesión</span></a></li>
                </ul>
                <!-- MENÚ PARA CELULAR -->
                <div class="hamburger-menu" id="hamburger-menu">
                    <div class="hamburger"></div>
                </div>
            </div>
        </div>
    </div>


                           

    <!-- CONTENIDO PRINCIPAL -->
    <div class="container section">
        <h2 class="section-header">Funciones de esta Semana</h2>
        <?php if (!empty($funcionesSemana)): ?>
            <div class="row">
                <?php foreach ($funcionesSemana as $funcion): ?>
                    <div class="col-3 col-md-4 col-sm-6">
                        <a href="#" class="movie-item">
                            <img src="uploads/<?php echo $funcion['imagen']; ?>" alt="<?php echo $funcion['pelicula']; ?>" class="movie-item-img">
                            <div class="movie-item-content">
                                <h3 class="movie-item-title"><?php echo $funcion['pelicula']; ?></h3>
                                <div class="movie-infos">
                                    <span class="movie-info"><i class="bx bx-movie-play"></i> Sala: <?php echo $funcion['sala']; ?></span>
                                    <span class="movie-info"><i class="bx bx-calendar"></i> Fecha: <?php echo date('d-m-Y', strtotime($funcion['fecha'])); ?></span>
                                    <span class="movie-info"><i class="bx bx-time"></i> Horario: <?php echo $funcion['horario']; ?></span>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-center">No hay funciones programadas para esta semana.</p>
        <?php endif; ?>
    </div>

    <!-- FOOTER -->
    <footer class="section">
        <div class="container">
            <div class="row">
                <div class="col-4 col-md-6 col-sm-12 content">
                    <a href="#" class="logo"><i class="bx bx-movie-play bx-tada main-color"></i>Gestión <span class="main-color">Cine</span></a>
                    <p>Disfruta de las mejores películas en nuestro cine.</p>
                </div>
                <div class="col-8 col-md-6 col-sm-12 social-list">
                    <a href="#" class="social-item"><i class="bx bxl-facebook"></i></a>
                    <a href="#" class="social-item"><i class="bx bxl-twitter"></i></a>
                    <a href="#" class="social-item"><i class="bx bxl-instagram"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- SCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="js/app.js"></script>
</body>
</html>