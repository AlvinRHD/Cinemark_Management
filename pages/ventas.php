<?php
include_once '../config.php';
include_once '../functions/gestionar.php';

session_start();


// Verifica si la sesión existe y si el usuario está autenticado
if (!isset($_SESSION['id_usuario'])) {
    // Si no está autenticado, redirige al formulario de inicio de sesión
    header("Location: ../auth/login.php"); // Cambia 'login.php' por la ruta de tu formulario de inicio de sesión
    exit();}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_funcion = $_POST['id_funcion'];
    
    // Verificar si se seleccionaron asientos
    if (!isset($_POST['asientos']) || empty($_POST['asientos'])) {
        echo "<script>alert('Por favor, selecciona al menos un asiento.');</script>";
    } else {
        $asientosSeleccionados = $_POST['asientos'];
        $cantidadBoletos = count($asientosSeleccionados);
        $precioTotal = $cantidadBoletos * obtenerPrecioFuncion($id_funcion); // Función que devuelve el precio por boleto

        // Procesar la venta solo si no hay asientos ocupados
        if (procesarVenta($id_funcion, $asientosSeleccionados, $precioTotal)) {
            echo "<script>alert('Compra realizada con éxito');</script>";
        }
    }
}


$funciones = obtenerFunciones();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas de Boletos</title>
    <link rel="stylesheet" href="../assets/css/styleAsientos.css">
    <link rel="stylesheet" href="../assets/css/app.css">
    <link rel="stylesheet" href="../assets/css/grid.css">
    <link rel="stylesheet" href="../assets/css/index.css">
</head>
<body>
    <div class="container">
        <header class="nav-wrapper">
            <div class="nav">
                <a href="../index.php" class="logo">Copilot</a>
                <ul class="nav-menu">
                    <li><a href="../index.php">Inicio</a></li>
                </ul>
            </div>
        </header>
        <main class="section">
            <h1 class="pricing-header">Venta de Boletos</h1>
            <form method="post" onsubmit="return verificarSeleccionAsientos()">
                <div class="row">
                    <div class="col-6">
                        <label for="funcion">Función:</label>
                        <select name="id_funcion" id="funcion" class="form-control" required onchange="cargarAsientos()">
                            <option value="">Selecciona una función</option>
                            <?php foreach ($funciones as $funcion): ?>
                                <option value="<?php echo $funcion['id_funcion']; ?>"><?php echo "{$funcion['pelicula']} - {$funcion['horario']}"; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <h2>Selecciona tus asientos</h2>
                <div id="asientosContainer" class="row"></div>
                <button type="submit" class="btn btn-hover">Comprar Boletos</button>
            </form>
        </main>
    </div>

    <script>

function cargarAsientos() {
    
    const funcionId = document.getElementById('funcion').value;
    if (!funcionId) return;

    fetch(`../functions/cargar_asientos.php?id_funcion=${funcionId}`)
        .then(response => response.json())
        .then(data => {
            

            const asientosContainer = document.getElementById('asientosContainer');
            asientosContainer.innerHTML = '';

            const rows = Math.ceil(data.capacidad / 10);
            for (let i = 0; i < rows; i++) {
                const rowDiv = document.createElement('div');
                rowDiv.className = 'fila';

                for (let j = 0; j < 10; j++) {
                    const asientoNum = i * 10 + j + 1;
                    if (asientoNum > data.capacidad) break;

                    // Crear el botón para el asiento
                    const button = document.createElement('button');
                    button.type = 'button';
                    button.innerText = asientoNum;
                    button.className = 'asiento';

                    // Si el asiento está ocupado, agregar clase 'ocupado', si está disponible, agregar clase 'disponible'
                    if (data.asientosOcupados.includes(asientoNum.toString())) {
                        button.classList.add('ocupado');
                        button.disabled = true; // Deshabilitar asiento ocupado
                    } else {
                        button.classList.add('disponible');
                        // Permitir selección de asientos disponibles
                        button.onclick = () => {
                            button.classList.toggle('seleccionado');
                        };
                    }

                    rowDiv.appendChild(button);
                }
                asientosContainer.appendChild(rowDiv);
            }
        });
        

}



        function mostrarAsientos(capacidad, asientosOcupados) {
    const asientosContainer = document.getElementById("asientosContainer");
    asientosContainer.innerHTML = "";
    
    for (let i = 1; i <= capacidad; i++) {
        const asiento = document.createElement("button");
        asiento.innerText = i;
        asiento.classList.add("asiento");

        // Marcar los asientos ocupados
        if (asientosOcupados.includes(i)) {
            asiento.classList.add("ocupado");
            asiento.disabled = true;
        }

        asientosContainer.appendChild(asiento);
    }
}


       

        function verificarSeleccionAsientos() {
    const selectedSeats = document.querySelectorAll('.asiento.seleccionado');
    if (selectedSeats.length === 0) {
        alert('Por favor, selecciona al menos un asiento.');
        return false;
    }

    // Agregar los asientos seleccionados al formulario
    selectedSeats.forEach(seat => {
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'asientos[]';
        hiddenInput.value = seat.innerText; // Número del asiento
        document.querySelector('form').appendChild(hiddenInput);
    });

    return true;
}

    </script>
</body>
</html>
