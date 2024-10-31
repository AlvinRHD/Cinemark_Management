<?php


include_once '../config.php';
include_once '../functions/gestionar.php';
include_once '../functions/editar.php';
include_once '../functions/eliminar.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['editar'])) {
        // Editar película
        $id = $_POST['id_pelicula'];
        $titulo = $_POST['titulo'];
        $descripcion = $_POST['descripcion'];
        $duracion = $_POST['duracion'];
        $clasificacion = $_POST['clasificacion'];
        $genero = $_POST['genero'];
        $imagen = $_FILES['imagen'];

        actualizarPelicula($id, $titulo, $descripcion, $duracion, $clasificacion, $genero, $imagen);
    } 
    elseif (isset($_POST['eliminar'])) {
        $id = $_POST['id_pelicula'];
        eliminarPelicula($id);
    }   
    else {
        // Agregar película
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Películas</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    
</head>
<body>
    <h1>Administrar Películas</h1>
    <!-- <form method="post">
        <input type="text" name="titulo" placeholder="Título" required>
        <textarea name="descripcion" placeholder="Descripción"></textarea>
        <input type="number" name="duracion" placeholder="Duración" required>
        <input type="text" name="clasificacion" placeholder="Clasificación" required>
        <input type="text" name="genero" placeholder="Género" required>
        <button type="submit">Agregar Película</button>
    </form> -->
    <form method="post" enctype="multipart/form-data">
    <input type="text" name="titulo" placeholder="Título" required>
    <textarea name="descripcion" placeholder="Descripción"></textarea>
    <input type="number" name="duracion" placeholder="Duración" required>
    <!-- <input type="text" name="clasificacion" placeholder="Clasificación" required>
    <input type="text" name="genero" placeholder="Género" required> -->
    <!-- Campo de Clasificación -->
    <label for="clasificacion">Clasificación:</label>
    <select name="clasificacion" required>
        <option value="G">G - General</option>
        <option value="PG">PG - Supervisión parental</option>
        <option value="PG-13">PG-13 - Mayores de 13</option>
        <option value="R">R - Restringido</option>
        <option value="NC-17">NC-17 - Solo adultos</option>
    </select>

    <!-- Campo de Género -->
    <label for="genero">Género:</label>
    <select name="genero" required>
        <option value="Acción">Acción</option>
        <option value="Aventura">Aventura</option>
        <option value="Comedia">Comedia</option>
        <option value="Drama">Drama</option>
        <option value="Horror">Horror</option>
        <option value="Ciencia ficción">Ciencia ficción</option>
        <option value="Fantasía">Fantasía</option>
        <option value="Romance">Romance</option>
        <option value="Thriller">Thriller</option>
        <option value="Misterio">Misterio</option>
        <option value="Documental">Documental</option>
        
        <!-- Géneros Compuestos -->
        <option value="Acción/Comedia">Acción/Comedia</option>
        <option value="Acción/Aventura">Acción/Aventura</option>
        <option value="Aventura/Fantasía">Aventura/Fantasía</option>
        <option value="Comedia/Drama">Comedia/Drama</option>
        <option value="Comedia/Romance">Comedia/Romance</option>
        <option value="Drama/Romance">Drama/Romance</option>
        <option value="Horror/Comedia">Horror/Comedia</option>
        <option value="Horror/Thriller">Horror/Thriller</option>
        <option value="Ciencia ficción/Aventura">Ciencia ficción/Aventura</option>
        <option value="Ciencia ficción/Thriller">Ciencia ficción/Thriller</option>
        <option value="Animación/Familiar">Animación/Familiar</option>
        <option value="Musical/Drama">Musical/Drama</option>
    </select>
    <input type="file" name="imagen" accept="image/*" required> <!-- Campo para la imagen -->
    <button type="submit">Agregar Película</button>
</form>

    
    <h2>Listado de Películas</h2>
    <ul>
        <?php foreach ($peliculas as $pelicula): ?>
            <li>
                <img src="../uploads/<?php echo $pelicula['imagen']; ?>" alt="<?php echo $pelicula['titulo']; ?>" style="width:100px;">
                <?php echo "{$pelicula['titulo']} -  {$pelicula['descripcion']} - {$pelicula['duracion']} min - Clasificación: {$pelicula['clasificacion']} - Género: {$pelicula['genero']}"; ?>
                <button onclick="abrirModal(<?php echo $pelicula['id_pelicula']; ?>)">Editar</button>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="id_pelicula" value="<?php echo $pelicula['id_pelicula']; ?>">
                    <button type="submit" name="eliminar" onclick="return confirm('Estas seguro que deseas eliminar esta pelicula xdxd?');" >Eliminar</button>
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
                
                <input type="file" name="imagen" accept="image/*"> <!-- Campo para cargar una nueva imagen -->
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

            // Mostrar imagen actual si existe
            const imagenPreview = document.getElementById('imagen_preview');
            if (imagenPreview) {
                imagenPreview.src = '../uploads/' + peliculaSeleccionada.imagen;
                imagenPreview.style.display = 'block';
            }

            document.getElementById('modal').style.display = 'flex';
        }

    </script>
</body>
</html>
