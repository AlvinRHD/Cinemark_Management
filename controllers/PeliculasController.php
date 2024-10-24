<?php
include_once "../db.php"; // Conexión a la base de datos

class PeliculasController {

    // Método para agregar una nueva película
    public function agregarPelicula($titulo, $duracion, $clasificacion, $genero, $descripcion) {
        global $conexion;

        $sql = "INSERT INTO peliculas (titulo, duracion, clasificacion, genero, descripcion)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("siiss", $titulo, $duracion, $clasificacion, $genero, $descripcion);

        if ($stmt->execute()) {
            echo "Película agregada correctamente";
        } else {
            echo "Error al agregar película: " . $conexion->error;
        }
    }

    // Método para editar una película existente
    public function editarPelicula($id_pelicula, $titulo, $duracion, $clasificacion, $genero, $descripcion) {
        global $conexion;

        $sql = "UPDATE peliculas 
                SET titulo = ?, duracion = ?, clasificacion = ?, genero = ?, descripcion = ?
                WHERE id_pelicula = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("siissi", $titulo, $duracion, $clasificacion, $genero, $descripcion, $id_pelicula);

        if ($stmt->execute()) {
            echo "Película actualizada correctamente";
        } else {
            echo "Error al actualizar película: " . $conexion->error;
        }
    }

    // Método para eliminar una película
    public function eliminarPelicula($id_pelicula) {
        global $conexion;

        $sql = "DELETE FROM peliculas WHERE id_pelicula = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $id_pelicula);

        if ($stmt->execute()) {
            echo "Película eliminada correctamente";
        } else {
            echo "Error al eliminar película: " . $conexion->error;
        }
    }

    // Método para obtener todas las películas
    public function obtenerPeliculas() {
        global $conexion;

        $sql = "SELECT * FROM peliculas";
        $result = $conexion->query($sql);

        $peliculas = [];
        while ($row = $result->fetch_assoc()) {
            $peliculas[] = $row;
        }
        return $peliculas;
    }
}
?>
