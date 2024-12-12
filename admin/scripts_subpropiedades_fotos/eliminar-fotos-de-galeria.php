<?php
if (isset($_POST['fotosAEliminar']) && !empty($_POST['fotosAEliminar'])) {
    $idsFotos = explode(',', $_POST['fotosAEliminar']);

    foreach ($idsFotos as $id) {
        $id = intval($id); // Convertimos el ID a un entero

        // Consulta para obtener los datos de la foto
        $stmt = $conn->prepare("SELECT * FROM subfotos WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $foto = $result->fetch_assoc()) {
            // Ruta del archivo
            $directorio = "fotos/" . $foto['id_subpropiedad'] . "/";
            $archivo = $foto['nombre_foto'];

            // Eliminamos el archivo físico si existe
            if (file_exists($directorio . $archivo)) {
                unlink($directorio . $archivo);
            }

            // Eliminamos el registro de la base de datos
            $stmtDelete = $conn->prepare("DELETE FROM subfotos WHERE id = ?");
            $stmtDelete->bind_param("i", $id);
            if (!$stmtDelete->execute()) {
                echo "Error al eliminar la foto con ID $id: " . $conn->error;
            }
        }
    }
} else {
    echo "No se recibieron fotos para eliminar.";
}
?>
