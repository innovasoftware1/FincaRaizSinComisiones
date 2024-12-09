<?php

$id_ultima_subpropiedad = null;

// Obtener la última subpropiedad registrada
$query = "SELECT * FROM subpropiedades ORDER BY id DESC LIMIT 1";
$resultado = mysqli_query($conn, $query);

if ($resultado && mysqli_num_rows($resultado)) {
    $subpropiedad = mysqli_fetch_assoc($resultado);
    $id_ultima_subpropiedad = $subpropiedad['id'];

    // Crear directorio para almacenar imágenes si no existe
    $directorio = '../subproperties/fotos/' . $id_ultima_subpropiedad;
    if (!file_exists($directorio)) {
        if (!mkdir($directorio, 0777, true)) {
            die("Error: No se pudo crear el directorio $directorio");
        }
    }

    // Verificar si se ha cargado un archivo llamado 'foto1'
    if (isset($_FILES["foto1"])) {
        $file = $_FILES["foto1"];
        $nombre = $file['name'];
        $tipo = $file['type'];
        $ruta_provisional = $file["tmp_name"];

        // Validar tipo de archivo
        if ($tipo != 'image/jpeg' && $tipo != 'image/jpg' && $tipo != 'image/png' && $tipo != 'image/gif') {
            echo "Error: El archivo no es una imagen válida.";
        } else {
            // Mover el archivo al directorio correspondiente
            if (move_uploaded_file($ruta_provisional, $directorio . '/' . $nombre)) {
                $ruta = $directorio . '/' . $nombre;

                // Actualizar la subpropiedad con la URL de la imagen principal
                $query_update = "UPDATE subpropiedades SET url_foto_principal = '$ruta' WHERE id = '$id_ultima_subpropiedad'";

                if (!mysqli_query($conn, $query_update)) {
                    echo "Error: No se pudo actualizar la URL de la imagen principal. " . mysqli_error($conn);
                }
            } else {
                echo "Error: No se pudo mover el archivo al directorio $directorio.";
            }
        }
    } else {
        echo "No se detectó ninguna imagen para subir.";
    }
} else {
    echo "Error: No se pudo seleccionar la última subpropiedad. " . mysqli_error($conn);
}

?>
