<?php
include_once '../config.php';
include_once '../functions/gestionar.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_funcion = $_POST['id_funcion'];
    
    // Verificar si se seleccionaron asientos
    if (!isset($_POST['asientos']) || empty($_POST['asientos'])) {
        echo "<script>alert('Por favor, selecciona al menos un asiento.');</script>";
    } else {
        $asientosSeleccionados = $_POST['asientos'];
        $cantidadBoletos = count($asientosSeleccionados);
        $precioTotal = $cantidadBoletos * obtenerPrecioFuncion($id_funcion); // Función que devuelve el precio por boleto

        // Procesar la venta si hay asientos seleccionados
        procesarVenta($id_funcion, $asientosSeleccionados, $precioTotal);
        echo "<script>alert('Compra realizada con éxito');</script>";
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
    <link rel="stylesheet" href="../assets/styleAsientos.css">
</head>
<body>
    <h1>Venta de Boletos</h1>
    <form method="post" onsubmit="return verificarSeleccionAsientos()">
        <label for="funcion">Función:</label>
        <select name="id_funcion" id="funcion" required onchange="cargarAsientos()">
            <option value="">Selecciona una función</option>
            <?php foreach ($funciones as $funcion): ?>
                <option value="<?php echo $funcion['id_funcion']; ?>"><?php echo "{$funcion['pelicula']} - {$funcion['horario']}"; ?></option>
            <?php endforeach; ?>
        </select>
        


        <h2>Selecciona tus asientos</h2>
        <div id="asientosContainer"></div>

        <button type="submit">Comprar Boletos</button>
    </form>

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

                    const checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.name = 'asientos[]';
                    checkbox.value = asientoNum;
                    checkbox.id = `asiento-${asientoNum}`;
                    checkbox.disabled = data.asientosOcupados.includes(asientoNum);

                    const label = document.createElement('label');
                    label.htmlFor = `asiento-${asientoNum}`;
                    label.innerText = asientoNum;
                    label.className = data.asientosOcupados.includes(asientoNum) ? 'ocupado' : 'disponible';

                    rowDiv.appendChild(checkbox);
                    rowDiv.appendChild(label);
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
            const checkboxes = document.querySelectorAll('input[name="asientos[]"]:checked');
            if (checkboxes.length === 0) {
                alert('Por favor, selecciona al menos un asiento.');
                return false; // Previene el envío del formulario
            }
            return true; // Permite el envío del formulario si hay al menos un asiento seleccionado
        }
    </script>
</body>
</html>
