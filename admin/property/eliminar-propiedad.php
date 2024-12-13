<?php
include("../conexion.php");

if (isset($_GET['idPropiedad']) && !empty($_GET['idPropiedad'])) {
    $idPropiedad = $_GET['idPropiedad'];

    // Consulta para obtener las fotos asociadas a la subpropiedad
    $query_fotos = "SELECT * FROM fotos WHERE id_propiedad = '$idPropiedad'";
    $result_fotos = mysqli_query($conn, $query_fotos);

    if (!$result_fotos) {
        // Si la consulta no es exitosa, muestra un mensaje de error
        die("Error al ejecutar la consulta: " . mysqli_error($conn));
    }

    $directorio = 'fotos/'.$idPropiedad."/";  // Directorio donde están las fotos de la subpropiedad

    // Eliminar cada foto de la subpropiedad
    while ($foto = mysqli_fetch_assoc($result_fotos)) {
        $archivo = $foto['nombre_foto'];
        if (file_exists($directorio . $archivo)) {
            unlink($directorio . $archivo);  // Eliminar el archivo físico
        }
        
        // Eliminar la entrada de la foto de la base de datos
        $query_delete_foto = "DELETE FROM fotos WHERE id = '{$foto['id']}'";
        mysqli_query($conn, $query_delete_foto);
    }

    // Eliminar la subpropiedad de la base de datos
    $query_subpropiedad = "DELETE FROM propiedades WHERE id = '$idPropiedad'";
    if (mysqli_query($conn, $query_subpropiedad)) {
        echo "success";  // Indicar que la eliminación fue exitosa
    } else {
        echo "Error al eliminar subpropiedad.";  // Error al eliminar
    }
} else {
    echo "ID de subpropiedad no proporcionado.";
}
?>
