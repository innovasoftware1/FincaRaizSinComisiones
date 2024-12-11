<?php
if (isset($_FILES["foto1"])) {
    $id_subpropiedad = intval($_POST['id_subpropiedad']);

    // Verificar si existe la subpropiedad
    $query = "SELECT * FROM subpropiedades WHERE id = '$id_subpropiedad'";
    $resultado = mysqli_query($conn, $query);

    if ($resultado && mysqli_num_rows($resultado)) {
        $directorio = "../subproperties/fotos/" . $id_subpropiedad;

        // Crear el directorio si no existe
        if (!file_exists($directorio)) {
            mkdir($directorio, 0777, true);
        }

        $file = $_FILES["foto1"];
        $nombre = $file['name'];
        $tipo = $file['type'];
        $ruta_provisional = $file['tmp_name'];

        // Validar tipo de archivo
        if ($tipo != 'image/jpeg' && $tipo != 'image/jpg' && $tipo != 'image/png' && $tipo != 'image/gif') {
            die("Error: El archivo no es una imagen válida.");
        }

        $nuevoNombre = uniqid('foto_', true) . '.' . pathinfo($nombre, PATHINFO_EXTENSION);
        $rutaCompleta = $directorio . '/' . $nuevoNombre;

        // Mover el archivo al directorio
        if (move_uploaded_file($ruta_provisional, $rutaCompleta)) {
            // Actualizar la URL en la base de datos
            $query_update = "UPDATE subpropiedades SET url_foto_principal = '$rutaCompleta' WHERE id = '$id_subpropiedad'";
            if (mysqli_query($conn, $query_update)) {
                echo "Foto principal procesada correctamente.";
            } else {
                echo "Error al actualizar la base de datos: " . mysqli_error($conn);
            }
        } else {
            echo "Error al mover la foto al directorio.";
        }
    } else {
        echo "Error: La subpropiedad no existe.";
    }
} else {
    echo "No se detectó ninguna foto principal para subir.";
}
?>
