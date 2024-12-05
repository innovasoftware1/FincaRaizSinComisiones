<?php

$id_ultima_propiedad = null;

$query = "SELECT * FROM propiedades ORDER BY id DESC limit 1";

$resultado = mysqli_query($conn, $query);

if(mysqli_num_rows($resultado)){
    $propiedad = mysqli_fetch_assoc($resultado);
    $id_ultima_propiedad = $propiedad['id'];
    $directorio = 'fotos/'.$id_ultima_propiedad;

    if(!file_exists($directorio)){
        mkdir($directorio,0777, true);
        
    }

    if(isset($_FILES["foto1"])){
        $reporte = null;
        $file = $_FILES["foto1"];
        $nombre = $file['name'];
        $tipo = $file['type'];
        $ruta_provisional = $file["tmp_name"];

        if($tipo != 'image/jpeg' && $tipo != 'image/jpg' && $tipo != 'image/png' && $tipo != 'image/gif'){
            $reporte = "El archivo no es una imagen";
        }else{
            move_uploaded_file($file['tmp_name'], $directorio.'/'.$nombre);

            $ruta = 'fotos/'.$id_ultima_propiedad;
            $query = "UPDATE propiedades SET url_foto_principal = '$ruta/$nombre' WHERE id='$id_ultima_propiedad'";

            if(mysqli_query($conn, $query)){
            }else{
                echo "No se pudo insertar las imagen de la publicación".mysqli_error($conn);
            }
        }

    }


}else{
    $mensaje = "No se pudo seleccionar el última propiedad".mysqli_error($conn);
}


?>