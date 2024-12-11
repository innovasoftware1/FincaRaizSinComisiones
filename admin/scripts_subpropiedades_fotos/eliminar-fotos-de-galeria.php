<?php
// Validamos si se recibió la lista de fotos a eliminar
if (isset($_POST['fotosAEliminar']) && !empty($_POST['fotosAEliminar'])) {
    // Convertimos los IDs de fotos a un array
    $idsFotos = explode(',', $_POST['fotosAEliminar']);

    // Recorremos el array de IDs
    foreach ($idsFotos as $id) {
        $id = intval($id); // Aseguramos que sea un número entero

        // Consultamos los datos de la foto en la base de datos
        $query = "SELECT * FROM subfotos WHERE id = '$id'";
        $result = mysqli_query($conn, $query);

        if ($result && $foto = mysqli_fetch_assoc($result)) {
            // Construimos la ruta del archivo
            $directorio = "fotos/" . $foto['id_subpropiedad'] . "/";
            $archivo = $foto['nombre_foto'];

            // Eliminamos el archivo físico si existe
            if (file_exists($directorio . $archivo)) {
                unlink($directorio . $archivo);
            }

            // Eliminamos el registro de la base de datos
            $queryDelete = "DELETE FROM subfotos WHERE id = '$id'";
            if (!mysqli_query($conn, $queryDelete)) {
                echo "Error al eliminar la foto con ID $id: " . mysqli_error($conn);
            }
        }
    }
} else {
    echo "No se recibieron fotos para eliminar.";
}
?>
