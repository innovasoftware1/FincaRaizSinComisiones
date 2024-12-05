<?php
include("conexion.php");

$id_ultima_propiedad = null;

$query = "SELECT * FROM propiedades ORDER BY id DESC LIMIT 1";
$resultado = mysqli_query($conn, $query);

if (mysqli_num_rows($resultado)) {
    $propiedad = mysqli_fetch_assoc($resultado);
    $id_ultima_propiedad = $propiedad['id'];
    $video_url = $_POST['video_url'];

    if (filter_var($video_url, FILTER_VALIDATE_URL) === false) {
        echo "La URL del video no es válida.";
    } else {
        $query = "UPDATE propiedades SET video_url = '$video_url' WHERE id='$id_ultima_propiedad'";

        if (!mysqli_query($conn, $query)) {
            echo "No se pudo insertar la URL del video: " . mysqli_error($conn);
        } else {
            echo "URL del video actualizada correctamente.";
        }
    }
} else {
    echo "No se pudo seleccionar la última propiedad: " . mysqli_error($conn);
}
?>
