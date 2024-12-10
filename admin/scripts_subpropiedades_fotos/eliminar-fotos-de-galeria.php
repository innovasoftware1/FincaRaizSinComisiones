<?php
// Convertimos los IDs de fotos a un array
$idsFotos = explode(',', $_POST['fotosAEliminar']);

$i = 0;

// Recorremos el array de IDs
while ($i < count($idsFotos)) {
    $id = $idsFotos[$i];

    // Consultamos los datos de la foto
    $query = "SELECT * FROM subfotos WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    if ($foto = mysqli_fetch_assoc($result)) {
        // Directorio de la foto
        $directorio = "fotos/" . $foto['id_subpropiedad'] . "/"; 
        $archivo = $foto['nombre_foto'];

        // Eliminamos el archivo físico
        if (file_exists($directorio . $archivo)) {
            unlink($directorio . $archivo);
        }

        // Eliminamos la foto de la base de datos
        $queryDelete = "DELETE FROM subfotos WHERE id = '$id'";
        mysqli_query($conn, $queryDelete);
    }

    // Incrementamos el contador
    $i++;
}
?>
