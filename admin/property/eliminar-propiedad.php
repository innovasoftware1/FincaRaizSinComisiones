<?php
include("../conexion.php");

if (isset($_GET['idPropiedad']) && !empty($_GET['idPropiedad'])) {
    $id_propiedad = $_GET['idPropiedad'];

    $query_fotos = "SELECT * FROM fotos WHERE id_propiedad = '$id_propiedad'";
    $result_fotos = mysqli_query($conn, $query_fotos);
    $directorio = 'fotos/'.$id_propiedad."/"; 

    while ($foto = mysqli_fetch_assoc($result_fotos)) {
        $archivo = $foto['nombre_foto'];
        if (file_exists($directorio . $archivo)) {
            unlink($directorio . $archivo);
        }
        $query_delete_foto = "DELETE FROM fotos WHERE id = '{$foto['id']}'";
        mysqli_query($conn, $query_delete_foto);
    }

    $query_propiedad = "DELETE FROM propiedades WHERE id = '$id_propiedad'";
    if (mysqli_query($conn, $query_propiedad)) {
        echo "success";
    } else {
        echo "Error al eliminar propiedad.";
    }
} 
?>

