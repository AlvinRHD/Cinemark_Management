<?php
include_once '../config.php';
include_once '../functions/gestionar.php';
include_once '../functions/editar.php';
include_once '../functions/eliminar.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['editar'])) {
        // Editar función
        $id = $_POST['id_funcion'];
        $id_pelicula = $_POST['id_pelicula'];
        $id_sala = $_POST['id_sala'];
        $horario = $_POST['horario'];
        $fecha = $_POST['fecha'];
        $precio = $_POST['precio']; // Captura el precio
        actualizarFuncion($id, $id_pelicula, $id_sala, $horario, $fecha, $precio);
    } 
    elseif (isset($_POST['eliminar'])) {
        $id = $_POST['id_funcion'];
        eliminarFuncion($id);
    }
    else {
        // Agregar función
        $id_pelicula = $_POST['id_pelicula'];
        $id_sala = $_POST['id_sala'];
        $horario = $_POST['horario'];
        $fecha = $_POST['fecha'];
        $precio = $_POST['precio']; // Captura el precio
    
        // Comprobar si la sala está ocupada
        $salaSeleccionada = obtenerSalaPorId($id_sala); 
        if ($salaSeleccionada['estado'] === 'ocupada') {
            echo "<script>alert('La sala seleccionada está ocupada. Por favor, elige otra sala.');</script>";
        } else {
            agregarFuncion($id_pelicula, $id_sala, $horario, $fecha, $precio); // Pasa el precio
        }
    }
    
}

$peliculas = obtenerPeliculas();
$salas = obtenerSalas();
$funciones = obtenerFunciones();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Funciones</title>
    <link rel="stylesheet" href="../assets/css/funciones.css">
    <link rel="stylesheet" href="../assets/css/grid.css">
    <link rel="stylesheet" href="../assets/css/app.css">

   
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
        <br>
        <br>
        <br>
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
    <br>

    <input type="time" name="horario" placeholder="Horario" required>
    <br>
    <input type="date" name="fecha" required>
    <br>
    <input type="number" name="precio" placeholder="Precio" step="0.01" required> <!-- Nuevo campo para el precio -->
    <br>
    <button type="submit">Agregar Función</button>
</form>

    
    <h2>Listado de Funciones</h2>
    <ul>
    <?php foreach ($funciones as $funcion): ?>
    <li>
        <img src="../uploads/<?php echo $funcion['imagen_pelicula']; ?>" alt="<?php echo $funcion['pelicula']; ?>" style="width:100px;">
        <?php 
            echo "{$funcion['pelicula']} en {$funcion['sala']} a las {$funcion['horario']} el {$funcion['fecha']} - Precio: $"; 
            echo isset($funcion['precio']) ? $funcion['precio'] : "No disponible"; 
        ?>
        <button onclick="abrirModal(<?php echo $funcion['id_funcion']; ?>)">Editar</button>
        <form method="post" style="display:inline;">
            <input type="hidden" name="id_funcion" value="<?php echo $funcion['id_funcion']; ?>">
            <button type="submit" name="eliminar" onclick="return confirm('¿Estás seguro de que deseas eliminar esta función?');">Eliminar</button>
        </form>
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
                <input type="number" name="precio" id="modal_precio" placeholder="Precio" step="0.01" required>
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