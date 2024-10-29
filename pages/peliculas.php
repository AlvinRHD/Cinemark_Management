<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../auth/login.php");
    exit();
}

include_once '../config.php';
include_once '../functions/gestionar.php';
include_once '../functions/editar.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['editar'])) {
        // Editar película
        $id = $_POST['id_pelicula'];
        $titulo = $_POST['titulo'];
        $descripcion = $_POST['descripcion'];
        $duracion = $_POST['duracion'];
        $clasificacion = $_POST['clasificacion'];
        $genero = $_POST['genero'];
        actualizarPelicula($id, $titulo, $descripcion, $duracion, $clasificacion, $genero);
    } else {
        // Agregar película
        $titulo = $_POST['titulo'];
        $descripcion = $_POST['descripcion'];
        $duracion = $_POST['duracion'];
        $clasificacion = $_POST['clasificacion'];
        $genero = $_POST['genero'];
        agregarPelicula($titulo, $descripcion, $duracion, $clasificacion, $genero);
    }
}

$peliculas = obtenerPeliculas();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Administrar Películas</title>
    <link rel="stylesheet" href="../assets/styles.css">
    
</head>
<body>
    <h1>Administrar Películas</h1>
    <form method="post">
        <input type="text" name="titulo" placeholder="Título" required>
        <textarea name="descripcion" placeholder="Descripción"></textarea>
        <input type="number" name="duracion" placeholder="Duración" required>
        <input type="text" name="clasificacion" placeholder="Clasificación" required>
        <input type="text" name="genero" placeholder="Género" required>
        <button type="submit">Agregar Película</button>
    </form>
    
    <h2>Listado de Películas</h2>
    <ul>
        <?php foreach ($peliculas as $pelicula): ?>
            <li>
                <?php echo "{$pelicula['titulo']} - {$pelicula['duracion']} min - Clasificación: {$pelicula['clasificacion']} - Género: {$pelicula['genero']}"; ?>
                <button onclick="abrirModal(<?php echo $pelicula['id_pelicula']; ?>)">Editar</button>
            </li>
        <?php endforeach; ?>
    </ul>

    <!-- Modal de edición -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <h2>Editar Película</h2>
            <form method="post">
                <input type="hidden" name="id_pelicula" id="id_pelicula">
                <input type="text" name="titulo" id="titulo" placeholder="Título" required>
                <textarea name="descripcion" id="descripcion" placeholder="Descripción"></textarea>
                <input type="number" name="duracion" id="duracion" placeholder="Duración" required>
                <input type="text" name="clasificacion" id="clasificacion" placeholder="Clasificación" required>
                <input type="text" name="genero" id="genero" placeholder="Género" required>
                <button type="submit" name="editar">Guardar Cambios</button>
                <button type="button" onclick="cerrarModal()">Cancelar</button>
            </form>
        </div>
    </div>

    <script>
        // Funciones para abrir y cerrar el modal
        function abrirModal(id) {
            const peliculas = <?php echo json_encode($peliculas); ?>;
            const peliculaSeleccionada = peliculas.find(p => p.id_pelicula == id);

            document.getElementById('id_pelicula').value = peliculaSeleccionada.id_pelicula;
            document.getElementById('titulo').value = peliculaSeleccionada.titulo;
            document.getElementById('descripcion').value = peliculaSeleccionada.descripcion;
            document.getElementById('duracion').value = peliculaSeleccionada.duracion;
            document.getElementById('clasificacion').value = peliculaSeleccionada.clasificacion;
            document.getElementById('genero').value = peliculaSeleccionada.genero;

            document.getElementById('modal').style.display = 'flex';
        }

        function cerrarModal() {
            document.getElementById('modal').style.display = 'none';
        }
    </script>
</body>
</html>
