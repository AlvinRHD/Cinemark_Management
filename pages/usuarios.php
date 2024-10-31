<?php
include_once '../config.php';
include_once '../functions/gestionar.php';
include_once '../functions/editar.php';
include_once '../functions/eliminar.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['editar'])) {
        // Editar usuario
        $id = $_POST['id_usuario'];
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $contrasena = $_POST['contrasena'];
        $rol = $_POST['rol'];
        actualizarUsuario($id, $nombre, $email, $contrasena, $rol);
    } 
    elseif (isset($_POST['eliminar'])) {
        // Eliminar usuario
        $id = $_POST['id_usuario'];
        eliminarUsuario($id);
    } 
    else {
        // Agregar usuario
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $contrasena = $_POST['contrasena'];
        $rol = $_POST['rol'];
        agregarUsuario($nombre, $email, $contrasena, $rol);
    }
}

$usuarios = obtenerUsuarios();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Usuarios</title>
    <link rel="stylesheet" href="../assets/css/usuarios.css">
</head>
<body>
    <h1>Administrar Usuarios</h1>
    <form method="post">
        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="email" name="email" placeholder="Correo electrónico" required>
        <input type="password" name="contrasena" placeholder="Contraseña" required>
        <select name="rol" required>
        <?php 
            if ($_SESSION['rol'] == 'gerente') {
                echo '<option value="empleado">Empleado</option>';
            }
            else {
                echo '<option value="administrador">Administrador</option>';
                echo '<option value="gerente">Gerente</option>';
                echo '<option value="empleado">Empleado</option>';
            }
            ?>
        </select>
        <button type="submit">Agregar Usuario</button>
    </form>

    <br>
    <br>
    <br>
    <br>
    <h2>Listado de Usuarios</h2>
    <br>
    <div class="user-list">
        <?php foreach ($usuarios as $usuario): ?>
            <div class="user-card">
                <div class="user-info">
                    <p class="user-name"><?php echo $usuario['nombre']; ?></p>
                    <p class="user-email"><?php echo $usuario['email']; ?></p>
                    <p class="user-role">Rol: <?php echo $usuario['rol']; ?></p>
                </div>
                <div class="user-actions">
                    <button class="edit-button" onclick="abrirModal(<?php echo $usuario['id_usuario']; ?>)">✏️ Editar</button>
                    <button class="delete-button" onclick="confirmDelete(<?php echo $usuario['id_usuario']; ?>)">🗑️ Eliminar</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Modal de edición -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <h2>Editar Usuario</h2>
            <form method="post">
                <input type="hidden" name="id_usuario" id="id_usuario">
                <input type="text" name="nombre" id="nombre" placeholder="Nombre" required>
                <input type="email" name="email" id="email" placeholder="Correo electrónico" required>
                <input type="password" name="contrasena" placeholder="Contraseña" required>
                <select name="rol" id="rol" required>
                    <option value="administrador">Administrador</option>
                    <option value="empleado">Empleado</option>
                    <option value="gerente">Gerente</option>
                </select>
                <button type="submit" name="editar">Guardar Cambios</button>
                <button type="button" onclick="cerrarModal()">Cancelar</button>
            </form>
        </div>
    </div>

    <script>
        // Funciones para abrir y cerrar el modal
        function abrirModal(id) {
            const usuario = <?php echo json_encode($usuarios); ?>;
            const usuarioSeleccionado = usuario.find(u => u.id_usuario == id);

            document.getElementById('id_usuario').value = usuarioSeleccionado.id_usuario;
            document.getElementById('nombre').value = usuarioSeleccionado.nombre;
            document.getElementById('email').value = usuarioSeleccionado.email;
            document.getElementById('rol').value = usuarioSeleccionado.rol;

            document.getElementById('modal').style.display = 'flex';
        }

        function cerrarModal() {
            document.getElementById('modal').style.display = 'none';
        }

        // Confirmar y enviar eliminación
        function confirmDelete(id) {
            if (confirm('¿Estás seguro de que deseas eliminar este usuario?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.style.display = 'none';

                const inputId = document.createElement('input');
                inputId.type = 'hidden';
                inputId.name = 'id_usuario';
                inputId.value = id;

                const deleteAction = document.createElement('input');
                deleteAction.type = 'hidden';
                deleteAction.name = 'eliminar';
                deleteAction.value = '1';

                form.appendChild(inputId);
                form.appendChild(deleteAction);
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</body>
</html>