<?php
include_once "../controllers/SalasController.php";
$controller = new SalasController();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['agregar'])) {
        $controller->agregarSala($_POST['nombre'], $_POST['capacidad']);
    } elseif (isset($_POST['editar'])) {
        $controller->editarSala($_POST['id_sala'], $_POST['nombre'], $_POST['capacidad'], $_POST['estado']);
    } elseif (isset($_POST['eliminar'])) {
        $controller->eliminarSala($_POST['id_sala']);
    }
}

$salas = $controller->obtenerSalas();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Salas</title>
</head>
<body>

<h1>Gestión de Salas</h1>

<form method="POST">
    <label>Nombre de la Sala:</label>
    <input type="text" name="nombre" required><br>

    <label>Capacidad:</label>
    <input type="number" name="capacidad" required><br>

    <button type="submit" name="agregar">Agregar Sala</button>
</form>

<h2>Salas Disponibles</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Capacidad</th>
        <th>Estado</th> 
        <th>Acciones</th>
    </tr>
    <?php foreach ($salas as $sala): ?>
    <tr>
        <td><?php echo $sala['id_sala']; ?></td>
        <td><?php echo $sala['nombre']; ?></td>
        <td><?php echo $sala['capacidad']; ?></td>
        <td><?php echo $sala['estado']; ?></td> 
        <td>
            <form method="POST">
                <input type="hidden" name="id_sala" value="<?php echo $sala['id_sala']; ?>">
                <input type="text" name="nombre" value="<?php echo $sala['nombre']; ?>" required>
                <input type="number" name="capacidad" value="<?php echo $sala['capacidad']; ?>" required>
                <select name="estado" required> 
                    <option value="disponible" <?php if ($sala['estado'] == 'disponible') echo 'selected'; ?>>Disponible</option>
                    <option value="ocupada" <?php if ($sala['estado'] == 'ocupada') echo 'selected'; ?>>Ocupada</option>
                </select>
                <button type="submit" name="editar">Editar</button>
                <button type="submit" name="eliminar">Eliminar</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
