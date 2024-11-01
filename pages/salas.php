<?php

include_once '../config.php';
include_once '../functions/gestionar.php';
include_once '../functions/editar.php';
include_once '../functions/eliminar.php';

session_start();



if (!isset($_SESSION['id_usuario'])) {

    header("Location: ../auth/login.php"); 
    exit();}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['editar'])) {
     
        $id = $_POST['id_sala'];
        $nombre = $_POST['nombre'];
        $capacidad = $_POST['capacidad'];
        $estado = $_POST['estado'];
        actualizarSala($id, $nombre, $capacidad, $estado);
    } elseif (isset($_POST['eliminar'])) {
        $id = $_POST['id_sala'];
        eliminarSala($id);
    } else {
   
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
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/salas.css">
    <link rel="stylesheet" href="../assets/css/app.css">
    <link rel="stylesheet" href="../assets/css/grid.css">
</head>
<body>
<header class="nav-wrapper">
            <div class="nav">
                <a href="../index.php" class="logo">Copilot</a>
                <ul class="nav-menu">
                    <li><a href="../index.php">Inicio</a></li>
                </ul>
            </div>
        </header>
    <h1>Administrar Salas</h1>
    
 
    <form method="post">
        <input type="text" name="nombre" placeholder="Nombre de la Sala" required>
        <input type="number" name="capacidad" placeholder="Capacidad" required>
        <button type="submit">Agregar Sala</button>
    </form>
    
    <h2>Listado de Salas</h2>
    
   
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Capacidad</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($salas as $sala): ?>
                <tr>
                    <td><?php echo $sala['nombre']; ?></td>
                    <td><?php echo $sala['capacidad']; ?></td>
                    <td><?php echo $sala['estado']; ?></td>
                    <td>
                        <div class="action-buttons">
                            <button class="edit-button" onclick="abrirModal(<?php echo $sala['id_sala']; ?>)">🖋️Editar</button>
                            <form method="post" style="display:inline;">
                            <input type="hidden" name="id_sala" value="<?php echo $sala['id_sala']; ?>">
                            <button type="submit" name="eliminar" class="delete-button" onclick="return confirm('¿Estás seguro de que deseas eliminar esta sala?');">Eliminar</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

   
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
