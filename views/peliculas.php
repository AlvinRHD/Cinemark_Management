<?php
include_once "../controllers/PeliculasController.php";
$controller = new PeliculasController();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['agregar'])) {
        $controller->agregarPelicula($_POST['titulo'], $_POST['duracion'], $_POST['clasificacion'], $_POST['genero'], $_POST['descripcion']);
    } elseif (isset($_POST['editar'])) {
        $controller->editarPelicula($_POST['id_pelicula'], $_POST['titulo'], $_POST['duracion'], $_POST['clasificacion'], $_POST['genero'], $_POST['descripcion']);
    } elseif (isset($_POST['eliminar'])) {
        $controller->eliminarPelicula($_POST['id_pelicula']);
    }
}

$peliculas = $controller->obtenerPeliculas();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Películas</title>
</head>
<body>

<h1>Gestión de Películas</h1>

<!-- Formulario para agregar una nueva película -->
<form method="POST">
    <label>Título:</label>
    <input type="text" name="titulo" required><br>

    <label>Duración (minutos):</label>
    <input type="number" name="duracion" required><br>

    <label>Clasificación:</label>
    <input type="text" name="clasificacion" required><br>

    <label>Género:</label>
    <input type="text" name="genero" required><br>

    <label>Descripción:</label>
    <textarea name="descripcion" required></textarea><br>

    <button type="submit" name="agregar">Agregar Película</button>
</form>

<h2>Películas Disponibles</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Título</th>
        <th>Duración</th>
        <th>Clasificación</th>
        <th>Género</th>
        <th>Descripción</th>
        <th>Acciones</th>
    </tr>
    <?php foreach ($peliculas as $pelicula): ?>
    <tr>
        <td><?php echo $pelicula['id_pelicula']; ?></td>
        <td>
            <input type="text" name="titulo" form="form-<?php echo $pelicula['id_pelicula']; ?>" value="<?php echo $pelicula['titulo']; ?>" required>
        </td>
        <td>
            <input type="number" name="duracion" form="form-<?php echo $pelicula['id_pelicula']; ?>" value="<?php echo $pelicula['duracion']; ?>" required>
        </td>
        <td>
            <input type="text" name="clasificacion" form="form-<?php echo $pelicula['id_pelicula']; ?>" value="<?php echo $pelicula['clasificacion']; ?>" required>
        </td>
        <td>
            <input type="text" name="genero" form="form-<?php echo $pelicula['id_pelicula']; ?>" value="<?php echo $pelicula['genero']; ?>" required>
        </td>
        <td>
            <textarea name="descripcion" form="form-<?php echo $pelicula['id_pelicula']; ?>" required><?php echo $pelicula['descripcion']; ?></textarea>
        </td>
        <td>
            <form method="POST" id="form-<?php echo $pelicula['id_pelicula']; ?>">
                <input type="hidden" name="id_pelicula" value="<?php echo $pelicula['id_pelicula']; ?>">
                <button type="submit" name="editar">Editar</button>
                <button type="submit" name="eliminar">Eliminar</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
