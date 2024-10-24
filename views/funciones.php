<?php
include_once "../controllers/FuncionesController.php";
$controller = new FuncionesController();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['agregar'])) {
        $controller->agregarFuncion($_POST['id_pelicula'], $_POST['id_sala'], $_POST['horario'], $_POST['fecha']);
    } elseif (isset($_POST['editar'])) {
        $controller->editarFuncion($_POST['id_funcion'], $_POST['id_pelicula'], $_POST['id_sala'], $_POST['horario'], $_POST['fecha']);
    } elseif (isset($_POST['eliminar'])) {
        $controller->eliminarFuncion($_POST['id_funcion']);
    }
}

$funciones = $controller->obtenerFunciones();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Funciones</title>
</head>
<body>

<h1>Gestión de Funciones</h1>

<form method="POST">
    <label>Pelicula:</label>
    <input type="text" name="id_pelicula" required><br>

    <label>Sala:</label>
    <input type="text" name="id_sala" required><br>

    <label>Horario:</label>
    <input type="time" name="horario" required><br>

    <label>Fecha:</label>
    <input type="date" name="fecha" required><br>

    <button type="submit" name="agregar">Agregar Función</button>
</form>

<h2>Funciones Programadas</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Pelicula</th>
        <th>Sala</th>
        <th>Horario</th>
        <th>Fecha</th>
        <th>Acciones</th>
    </tr>
    <?php foreach ($funciones as $funcion): ?>
    <tr>
        <td><?php echo $funcion['id_funcion']; ?></td>
        <td><?php echo $funcion['titulo']; ?></td>
        <td><?php echo $funcion['nombre']; ?></td>
        <td><?php echo $funcion['horario']; ?></td>
        <td><?php echo $funcion['fecha']; ?></td>
        <td>
            <form method="POST">
                <input type="hidden" name="id_funcion" value="<?php echo $funcion['id_funcion']; ?>">
                <button type="submit" name="editar">Editar</button>
                <button type="submit" name="eliminar">Eliminar</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
