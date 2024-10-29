<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login/login.php");
    exit();
}

include_once '../config.php';
include_once '../functions/gestionar.php';
include_once '../functions/editar.php';
include_once '../functions/eliminar.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['editar'])) {
        // Editar sala
        $id = $_POST['id_sala'];
        $nombre = $_POST['nombre'];
        $capacidad = $_POST['capacidad'];
        $estado = $_POST['estado'];
        actualizarSala($id, $nombre, $capacidad, $estado);
    }
    elseif (isset($_POST['eliminar'])) {
        $id = $_POST['id_sala'];
        eliminarSala($id);
        } 
    
    else {
        // Agregar sala
        $nombre = $_POST['nombre'];
        $capacidad = $_POST['capacidad'];
        agregarSala($nombre, $capacidad);
    }
}

$salas = obtenerSalas();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Salas</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <h1>Administrar Salas</h1>
    <form method="post">
        <input type="text" name="nombre" placeholder="Nombre de la Sala" required>
        <input type="number" name="capacidad" placeholder="Capacidad" required>
        <button type="submit">Agregar Sala</button>
    </form>
    
    <h2>Listado de Salas</h2>
    <ul>
        <?php foreach ($salas as $sala): ?>
            <li>
                <?php echo "{$sala['nombre']} - Capacidad: {$sala['capacidad']} - Estado: {$sala['estado']}"; ?>
                <button onclick="abrirModal(<?php echo $sala['id_sala']; ?>)">Editar</button>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="id_sala" value="<?php echo $sala['id_sala']; ?>">
                    <button type="submit" name="eliminar" onclick="return confirm('Estas seguro que deseas eliminar esta sala xdxd?');" >Eliminar</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>

    <!-- Modal de edición -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <h2>Editar Sala</h2>
            <form method="post">
                <input type="hidden" name="id_sala" id="id_sala">
                <input type="text" name="nombre" id="nombre" placeholder="Nombre de la Sala" required>
                <input type="number" name="capacidad" id="capacidad" placeholder="Capacidad" required>
                <label for="estado">Estado:</label>
                <select name="estado" id="estado" required>
                    <option value="disponible">Disponible</option>
                    <option value="ocupada">Ocupada</option>
                </select>
                <button type="submit" name="editar">Guardar Cambios</button>
                <button type="button" onclick="cerrarModal()">Cancelar</button>
            </form>
        </div>
    </div>

    <script>
        // Funciones para abrir y cerrar el modal
        function abrirModal(id) {
            const salas = <?php echo json_encode($salas); ?>;
            const salaSeleccionada = salas.find(s => s.id_sala == id);

            document.getElementById('id_sala').value = salaSeleccionada.id_sala;
            document.getElementById('nombre').value = salaSeleccionada.nombre;
            document.getElementById('capacidad').value = salaSeleccionada.capacidad;
            document.getElementById('estado').value = salaSeleccionada.estado;

            document.getElementById('modal').style.display = 'flex';
        }

        function cerrarModal() {
            document.getElementById('modal').style.display = 'none';
        }
    </script>
</body>
</html>
