<?php
include_once "../db.php"; // Conexión a la base de datos

class SalasController {

    // Método para agregar una nueva sala
    public function agregarSala($nombre, $capacidad) {
        global $conexion;

        $sql = "INSERT INTO salas (nombre, capacidad)
                VALUES (?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("si", $nombre, $capacidad);

        if ($stmt->execute()) {
            echo "Sala agregada correctamente";
        } else {
            echo "Error al agregar sala: " . $conexion->error;
        }
    }

    // Método para editar una sala existente
    public function editarSala($id_sala, $nombre, $capacidad) {
        global $conexion;

        $sql = "UPDATE salas 
                SET nombre = ?, capacidad = ?
                WHERE id_sala = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sii", $nombre, $capacidad, $id_sala);

        if ($stmt->execute()) {
            echo "Sala actualizada correctamente";
        } else {
            echo "Error al actualizar sala: " . $conexion->error;
        }
    }

    // Método para eliminar una sala
    public function eliminarSala($id_sala) {
        global $conexion;

        $sql = "DELETE FROM salas WHERE id_sala = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $id_sala);

        if ($stmt->execute()) {
            echo "Sala eliminada correctamente";
        } else {
            echo "Error al eliminar sala: " . $conexion->error;
        }
    }

    // Método para obtener todas las salas
    public function obtenerSalas() {
        global $conexion;

        $sql = "SELECT * FROM salas";
        $result = $conexion->query($sql);

        $salas = [];
        while ($row = $result->fetch_assoc()) {
            $salas[] = $row;
        }
        return $salas;
    }
}
?>
