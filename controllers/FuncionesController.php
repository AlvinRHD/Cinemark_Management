<?php
include_once "../db.php"; // Conexión a la base de datos

class FuncionesController {

    // Método para agregar una nueva función
    public function agregarFuncion($id_pelicula, $id_sala, $horario, $fecha) {
        global $conexion;

        $sql = "INSERT INTO funciones (id_pelicula, id_sala, horario, fecha)
                VALUES (?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("iiss", $id_pelicula, $id_sala, $horario, $fecha);

        if ($stmt->execute()) {
            echo "Función agregada correctamente";
        } else {
            echo "Error al agregar función: " . $conexion->error;
        }
    }

    // Método para editar una función existente
    public function editarFuncion($id_funcion, $id_pelicula, $id_sala, $horario, $fecha) {
        global $conexion;

        $sql = "UPDATE funciones 
                SET id_pelicula = ?, id_sala = ?, horario = ?, fecha = ?
                WHERE id_funcion = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("iissi", $id_pelicula, $id_sala, $horario, $fecha, $id_funcion);

        if ($stmt->execute()) {
            echo "Función actualizada correctamente";
        } else {
            echo "Error al actualizar función: " . $conexion->error;
        }
    }

    // Método para eliminar una función
    public function eliminarFuncion($id_funcion) {
        global $conexion;

        $sql = "DELETE FROM funciones WHERE id_funcion = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $id_funcion);

        if ($stmt->execute()) {
            echo "Función eliminada correctamente";
        } else {
            echo "Error al eliminar función: " . $conexion->error;
        }
    }

    // Método para obtener todas las funciones
    public function obtenerFunciones() {
        global $conexion;

        $sql = "SELECT f.id_funcion, p.titulo, s.nombre, f.horario, f.fecha 
                FROM funciones f
                JOIN peliculas p ON f.id_pelicula = p.id_pelicula
                JOIN salas s ON f.id_sala = s.id_sala";
        $result = $conexion->query($sql);

        $funciones = [];
        while ($row = $result->fetch_assoc()) {
            $funciones[] = $row;
        }
        return $funciones;
    }
}
?>
