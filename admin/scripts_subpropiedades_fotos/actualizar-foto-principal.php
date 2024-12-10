<?php    
if(isset($_FILES["foto1"])){
    $reporte = null;
    $file = $_FILES["foto1"];
    $nombre = $file['name'];
    $tipo = $file['type'];
    $ruta_provisional = $file["tmp_name"];

    // Validar tipo de archivo
    if($tipo != 'image/jpeg' && $tipo != 'image/jpg' && $tipo != 'image/png' && $tipo != 'image/gif'){
        $reporte = "El archivo no es una imagen";
    } else {
        // Definir la ruta de almacenamiento en función del ID de la subpropiedad
        $ruta = 'fotos/'.$id_subpropiedad;  // Cambiado para usar subpropiedad_id

        // Asegurarse de que la carpeta exista o crearla si no
        if (!is_dir($ruta)) {
            mkdir($ruta, 0777, true);
        }

        // Mover el archivo a la carpeta correspondiente
        move_uploaded_file($file['tmp_name'], $ruta.'/'.$nombre);

        // Obtener la subpropiedad por su ID
        $subpropiedad = obtenerSubpropiedadPorId($id_subpropiedad);  // Asegúrate de tener esta función
        $foto_a_borrar = $subpropiedad['url_foto_principal'];

        // Actualizar la base de datos con la nueva foto principal
        $query = "UPDATE subpropiedades SET url_foto_principal = '$ruta/$nombre' WHERE id = '$id_subpropiedad'";

        if(mysqli_query($conn, $query)){
            // Borrar la foto anterior si existía
            if ($foto_a_borrar && file_exists($foto_a_borrar)) {
                unlink($foto_a_borrar); // Eliminar foto anterior
            }
            echo "Foto actualizada correctamente.";
        } else {
            echo "No se pudo actualizar la foto de la subpropiedad: " . mysqli_error($conn);
        }
    }
}
?>
