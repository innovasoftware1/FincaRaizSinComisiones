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
        // Definir la ruta del directorio
        $directorio = 'property/fotos/'.$id_propiedad;
        
        // Verificar si el directorio existe, si no, crearlo
        if (!is_dir($directorio)) {
            mkdir($directorio, 0777, true); // Crear el directorio con permisos 777
        }

        // Mover el archivo al directorio
        $ruta = $directorio.'/'.$nombre;
        if (move_uploaded_file($file['tmp_name'], $ruta)) {
            // Obtener la propiedad para obtener la URL de la foto principal
            $propiedad = obtenerPropiedadPorId($id_propiedad);
            $foto_a_borrar = $propiedad['url_foto_principal'];

            // Actualizar la URL de la foto principal en la base de datos
            $query = "UPDATE propiedades SET url_foto_principal = '$ruta' WHERE id='$id_propiedad'";

            if(mysqli_query($conn, $query)){
                echo "foto:".$foto_a_borrar;

                // Verificar si el archivo a eliminar existe antes de intentar eliminarlo
                if ($foto_a_borrar && file_exists($foto_a_borrar)) {
                    unlink($foto_a_borrar);
                } else {
                    echo "El archivo a eliminar no existe o no es válido: $foto_a_borrar";
                }
            }else{
                echo "No se pudo insertar la imagen de la publicación".mysqli_error($conn);
            }
        } else {
            echo "Error al mover el archivo. Verifique los permisos del directorio.";
        }
    }
}
?>
