<?php    
if(isset($_FILES["foto1"])){
    $reporte = null;
    $file = $_FILES["foto1"];
    $nombre = $file['name'];
    $tipo = $file['type'];
    $ruta_provisional = $file["tmp_name"];

    if($tipo != 'image/jpeg' && $tipo != 'image/jpg' && $tipo != 'image/png' && $tipo != 'image/gif'){
        $reporte = "El archivo no es una imagen";
    }else{
        $ruta = 'fotos/'.$id_propiedad;

        move_uploaded_file($file['tmp_name'], $ruta.'/'.$nombre);

        $propiedad = obtenerPropiedadPorId($id_propiedad);
        $foto_a_borrar = $propiedad['url_foto_principal'];

        $query = "UPDATE propiedades SET url_foto_principal = '$ruta/$nombre' WHERE id='$id_propiedad'";

        if(mysqli_query($conn, $query)){
            echo "foto:".$foto_a_borrar;
            unlink($foto_a_borrar);
        }else{
            echo "No se pudo insertar las imagen de la publicación".mysqli_error($conn);
        }
    }
}
?>