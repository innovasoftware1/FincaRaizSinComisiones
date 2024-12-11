<?php
include("../conexion.php");

if (isset($_GET['idSubpropiedad']) && !empty($_GET['idSubpropiedad'])) {
    $id_subpropiedad = $_GET['idSubpropiedad'];

    // Consulta para obtener las fotos asociadas a la subpropiedad
    $query_fotos = "SELECT * FROM subfotos WHERE id_subpropiedad = '$id_subpropiedad'";
    $result_fotos = mysqli_query($conn, $query_fotos);
    $directorio = 'fotos/'.$id_subpropiedad."/";  // Directorio donde están las fotos de la subpropiedad

    // Eliminar cada foto de la subpropiedad
    while ($foto = mysqli_fetch_assoc($result_fotos)) {
        $archivo = $foto['nombre_foto'];
        if (file_exists($directorio . $archivo)) {
            unlink($directorio . $archivo);  // Eliminar el archivo físico
        }
        
        // Eliminar la entrada de la foto de la base de datos
        $query_delete_foto = "DELETE FROM subfotos WHERE id = '{$foto['id']}'";
        mysqli_query($conn, $query_delete_foto);
    }

    // Eliminar la subpropiedad de la base de datos
    $query_subpropiedad = "DELETE FROM subpropiedades WHERE id = '$id_subpropiedad'";
    if (mysqli_query($conn, $query_subpropiedad)) {
        echo "success";  // Indicar que la eliminación fue exitosa
    } else {
        echo "Error al eliminar subpropiedad.";  // Error al eliminar
    }
} else {
    echo "ID de subpropiedad no proporcionado.";
}
?>
