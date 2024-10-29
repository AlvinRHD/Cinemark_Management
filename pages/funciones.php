<?php
include_once '../config.php';
include_once '../functions/gestionar.php';
include_once '../functions/editar.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['editar'])) {
        // Editar función
        $id = $_POST['id_funcion'];
        $id_pelicula = $_POST['id_pelicula'];
        $id_sala = $_POST['id_sala'];
        $horario = $_POST['horario'];
        $fecha = $_POST['fecha'];
        actualizarFuncion($id, $id_pelicula, $id_sala, $horario, $fecha);
    } else {
        // Agregar función
        $id_pelicula = $_POST['id_pelicula'];
        $id_sala = $_POST['id_sala'];
        $horario = $_POST['horario'];
        $fecha = $_POST['fecha'];
        agregarFuncion($id_pelicula, $id_sala, $horario, $fecha);
    }
}

$peliculas = obtenerPeliculas();
$salas = obtenerSalas();
$funciones = obtenerFunciones();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Administrar Funciones</title>
    <style>
        /* Estilos del modal */
        .modal {
            display: none;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h1>Administrar Funciones</h1>
    <form method="post">
        <label for="id_pelicula">Película:</label>
        <select name="id_pelicula" required>
            <?php foreach ($peliculas as $pelicula): ?>
                <option value="<?php echo $pelicula['id_pelicula']; ?>"><?php echo $pelicula['titulo']; ?></option>
            <?php endforeach; ?>
        </select>
        
        <label for="id_sala">Sala:</label>
        <select name="id_sala" required>
            <?php foreach ($salas as $sala): ?>
                <option value="<?php echo $sala['id_sala']; ?>"><?php echo $sala['nombre']; ?></option>
            <?php endforeach; ?>
        </select>
        
        <input type="time" name="horario" placeholder="Horario" required>
        <input type="date" name="fecha" required>
        <button type="submit">Agregar Función</button>
    </form>
    
    <h2>Listado de Funciones</h2>
    <ul>
        <?php foreach ($funciones as $funcion): ?>
            <li>
                <?php echo "{$funcion['pelicula']} en {$funcion['sala']} a las {$funcion['horario']} el {$funcion['fecha']}"; ?>
                <button onclick="abrirModal(<?php echo $funcion['id_funcion']; ?>)">Editar</button>
            </li>
        <?php endforeach; ?>
    </ul>

    <!-- Modal de edición -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <h2>Editar Función</h2>
            <form method="post">
                <input type="hidden" name="id_funcion" id="id_funcion">
                <label for="id_pelicula">Película:</label>
                <select name="id_pelicula" id="modal_id_pelicula" required>
                    <?php foreach ($peliculas as $pelicula): ?>
                        <option value="<?php echo $pelicula['id_pelicula']; ?>"><?php echo $pelicula['titulo']; ?></option>
                    <?php endforeach; ?>
                </select>
                
                <label for="id_sala">Sala:</label>
                <select name="id_sala" id="modal_id_sala" required>
                    <?php foreach ($salas as $sala): ?>
                        <option value="<?php echo $sala['id_sala']; ?>"><?php echo $sala['nombre']; ?></option>
                    <?php endforeach; ?>
                </select>
                
                <input type="time" name="horario" id="modal_horario" required>
                <input type="date" name="fecha" id="modal_fecha" required>
                <button type="submit" name="editar">Guardar Cambios</button>
                <button type="button" onclick="cerrarModal()">Cancelar</button>
            </form>
        </div>
    </div>

    <script>
        // Funciones para abrir y cerrar el modal
        function abrirModal(id) {
            const funciones = <?php echo json_encode($funciones); ?>;
            const funcionSeleccionada = funciones.find(f => f.id_funcion == id);

            document.getElementById('id_funcion').value = funcionSeleccionada.id_funcion;
            document.getElementById('modal_id_pelicula').value = funcionSeleccionada.id_pelicula;
            document.getElementById('modal_id_sala').value = funcionSeleccionada.id_sala;
            document.getElementById('modal_horario').value = funcionSeleccionada.horario;
            document.getElementById('modal_fecha').value = funcionSeleccionada.fecha;

            document.getElementById('modal').style.display = 'flex';
        }

        function cerrarModal() {
            document.getElementById('modal').style.display = 'none';
        }
    </script>
</body>
</html>
