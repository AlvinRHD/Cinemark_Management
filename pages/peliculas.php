<?php
include_once '../config.php';
include_once '../functions/gestionar.php';
include_once '../functions/editar.php';
include_once '../functions/eliminar.php';

session_start();


// Verifica si la sesión existe y si el usuario está autenticado
if (!isset($_SESSION['id_usuario'])) {
    // Si no está autenticado, redirige al formulario de inicio de sesión
    header("Location: ../auth/login.php"); // Cambia 'login.php' por la ruta de tu formulario de inicio de sesión
    exit();}


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
    <div class="back-button">
        <a href="../index.php" class="btn btn-hover">Regresar al inicio</a>
    </div>

    <br>
    <h1>Administrar <span class="letra">Películas<span></h1>
    <br>

    <form method="post" enctype="multipart/form-data">
        <input type="text" name="titulo" placeholder="Título" required>
        <textarea name="descripcion" placeholder="Descripción"></textarea>
        <input type="number" name="duracion" placeholder="Duración" required>
        
        <label for="clasificacion">Clasificación:</label>
        <select name="clasificacion" required>
            <option value="G">G - General</option>
            <option value="PG">PG - Supervisión parental</option>
            <option value="PG-13">PG-13 - Mayores de 13</option>
            <option value="R">R - Restringido</option>
            <option value="NC-17">NC-17 - Solo adultos</option>
        </select>

        <label for="genero">Género:</label>
        <select name="genero" required>
            <option value="accion">Acción</option>
            <option value="comedia">Comedia</option>
            <option value="drama">Drama</option>
            <option value="fantasia">Fantasía</option>
            <option value="terror">Terror</option>
            <option value="accion/aventura">Acción/Aventura</option>
            <option value="comedia/romantica">Comedia/Romántica</option>
            <option value="drama/romantico">Drama/Romántico</option>
            <option value="ciencia_ficcion">Ciencia Ficción</option>
            <option value="suspenso">Suspenso</option>
            <option value="musical">Musical</option>
            <option value="animacion">Animación</option>
            <option value="documental">Documental</option>
            <option value="fantasia/aventura">Fantasía/Aventura</option>
            <option value="accion/terror">Acción/Terror</option>
            <option value="comedia/drama">Comedia/Drama</option>
            <option value="fantasia/romantica">Fantasía/Romántica</option>
            <option value="aventura/terror">Aventura/Terror</option>
            <option value="historia">Historia</option>
            <!-- Puedes agregar más opciones de género aquí -->
        </select>

        <input type="file" name="imagen" accept="image/*" required class="file-input">
        <button type="submit">Agregar Película</button>
    </form>

    <br>
    <br>
    <br>
    <br>
    <h2>Listado de <span class="letra">Películas<span></h2>
        <ul>
            <?php foreach ($peliculas as $pelicula): ?>
                <li>
                    <img src="../uploads/<?php echo $pelicula['imagen']; ?>" alt="<?php echo $pelicula['titulo']; ?>">
                    <div>
                        <?php echo "{$pelicula['titulo']} -  {$pelicula['descripcion']} - {$pelicula['duracion']} min - Clasificación: {$pelicula['clasificacion']} - Género: {$pelicula['genero']}"; ?>
                    </div>
                    <div class="user-actions">
                        <button class="edit-button" onclick="abrirModal(<?php echo $pelicula['id_pelicula']; ?>)">✏️ Editar</button>
                        <button class="delete-button" onclick="confirmDelete(<?php echo $pelicula['id_pelicula']; ?>)">🗑️ Eliminar</button>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>

    <div id="modal" class="modal" style="display: none;"> <!-- Asegura que esté oculto inicialmente -->
        <div class="modal-content">
            <h2>Editar Película</h2>
            <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="id_pelicula" id="id_pelicula">
                <input type="text" name="titulo" id="titulo" placeholder="Título" required>
                <textarea name="descripcion" id="descripcion" placeholder="Descripción"></textarea>
                <input type="number" name="duracion" id="duracion" placeholder="Duración" required>
                <input type="text" name="clasificacion" id="clasificacion" placeholder="Clasificación" required>
                <input type="text" name="genero" id="genero" placeholder="Género" required>
                <input type="file" name="imagen" accept="image/*" class="file-input">
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

            // Muestra el modal
            document.getElementById('modal').style.display = 'flex';
        }

        function cerrarModal() {
            // Oculta el modal
            document.getElementById('modal').style.display = 'none';
        }
        
        function confirmDelete(id) {
            if (confirm('¿Estás seguro de que deseas eliminar esta película?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.style.display = 'none';

                const inputId = document.createElement('input');
                inputId.type = 'hidden';
                inputId.name = 'id_pelicula';
                inputId.value = id;

                const deleteAction = document.createElement('input');
                deleteAction.type = 'hidden';
                deleteAction.name = 'eliminar';
                deleteAction.value = '1';

                form.appendChild(inputId);
                form.appendChild(deleteAction);
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>


</body>
</html>