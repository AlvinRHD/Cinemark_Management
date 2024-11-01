<?php
include_once '../config.php';
include_once '../functions/gestionar.php';
include_once '../functions/editar.php';
include_once '../functions/eliminar.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['editar'])) {
        $id = $_POST['id_pelicula'];
        $titulo = $_POST['titulo'];
        $descripcion = $_POST['descripcion'];
        $duracion = $_POST['duracion'];
        $clasificacion = $_POST['clasificacion'];
        $genero = $_POST['genero'];
        $imagen = $_FILES['imagen'];

        actualizarPelicula($id, $titulo, $descripcion, $duracion, $clasificacion, $genero, $imagen);
    } elseif (isset($_POST['eliminar'])) {
        $id = $_POST['id_pelicula'];
        eliminarPelicula($id);
    } else {
        $titulo = $_POST['titulo'];
        $descripcion = $_POST['descripcion'];
        $duracion = $_POST['duracion'];
        $clasificacion = $_POST['clasificacion'];
        $genero = $_POST['genero'];
        $imagen = $_FILES['imagen'];

        agregarPelicula($titulo, $descripcion, $duracion, $clasificacion, $genero, $imagen);
    }
}

$peliculas = obtenerPeliculas();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Películas</title>
    <link rel="stylesheet" href="../assets/css/peliculas.css">
</head>
<body>
    <!-- Botón para regresar al index -->
    <div class="back-button">
        <a href="../index.php" class="btn btn-hover">Regresar al inicio</a>
    </div>

    <h1>Administrar Películas</h1>

    <!-- Formulario para agregar película -->
    <form method="post" enctype="multipart/form-data">
        <input type="text" name="titulo" placeholder="Título" required>
        <textarea name="descripcion" placeholder="Descripción"></textarea>
        <input type="number" name="duracion" placeholder="Duración" required>
        
        <!-- Clasificación -->
        <label for="clasificacion">Clasificación:</label>
        <select name="clasificacion" required>
            <option value="G">G - General</option>
            <option value="PG">PG - Supervisión parental</option>
            <option value="PG-13">PG-13 - Mayores de 13</option>
            <option value="R">R - Restringido</option>
            <option value="NC-17">NC-17 - Solo adultos</option>
        </select>

        <!-- Género -->
        <label for="genero">Género:</label>
        <select name="genero" required>
            <!-- Lista de géneros -->
        </select>
        <input type="file" name="imagen" accept="image/*" required>
        <button type="submit">Agregar Película</button>
    </form>

    <!-- Listado de películas -->
    <h2>Listado de Películas</h2>
    <ul>
        <?php foreach ($peliculas as $pelicula): ?>
            <li>
                <img src="../uploads/<?php echo $pelicula['imagen']; ?>" alt="<?php echo $pelicula['titulo']; ?>">
                <?php echo "{$pelicula['titulo']} -  {$pelicula['descripcion']} - {$pelicula['duracion']} min - Clasificación: {$pelicula['clasificacion']} - Género: {$pelicula['genero']}"; ?>
                <button onclick="abrirModal(<?php echo $pelicula['id_pelicula']; ?>)">Editar</button>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="id_pelicula" value="<?php echo $pelicula['id_pelicula']; ?>">
                    <button type="submit" name="eliminar" onclick="return confirm('¿Estás seguro de eliminar esta película?');">Eliminar</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>

    <!-- Modal de edición -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <h2>Editar Película</h2>
            <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="id_pelicula" id="id_pelicula">
                <input type="text" name="titulo" id="titulo" placeholder="Título" required>
                <textarea name="descripcion" id="descripcion" placeholder="Descripción"></textarea>
                <input type="number" name="duracion" id="duracion" placeholder="Duración" required>
                <input type="text" name="clasificacion" id="clasificacion" placeholder="Clasificación" required>
                <input type="text" name="genero" id="genero" placeholder="Género" required>
                <input type="file" name="imagen" accept="image/*">
                <button type="submit" name="editar">Guardar Cambios</button>
                <button type="button" onclick="cerrarModal()">Cancelar</button>
            </form>
        </div>
    </div>

    <script>
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