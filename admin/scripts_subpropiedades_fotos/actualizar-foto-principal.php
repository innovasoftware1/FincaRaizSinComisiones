<?php
if (isset($_POST['fotoPrincipalActualizada']) && $_POST['fotoPrincipalActualizada'] === 'si' && isset($_FILES['foto1'])) {
    $id_subpropiedad = intval($_POST['id_subpropiedad']);
    
    $query = "SELECT url_foto_principal FROM subpropiedades WHERE id = '$id_subpropiedad'";
    $resultado = mysqli_query($conn, $query);

    if ($resultado && $subpropiedad = mysqli_fetch_assoc($resultado)) {
        $fotoAnterior = $subpropiedad['url_foto_principal'];

        $directorio = "../subproperties/fotos/" . $id_subpropiedad;
        if (!file_exists($directorio)) {
            mkdir($directorio, 0777, true);
        }

        $file = $_FILES["foto1"];
        $nombre = $file['name'];
        $ruta_provisional = $file["tmp_name"];
        $tipo = $file["type"];

        if ($tipo !== 'image/jpeg' && $tipo !== 'image/jpg' && $tipo !== 'image/png' && $tipo !== 'image/gif') {
            die("Error: El archivo no es una imagen válida.");
        }

        $nuevoNombre = uniqid('foto_', true) . '.' . pathinfo($nombre, PATHINFO_EXTENSION);
        $rutaCompleta = $directorio . '/' . $nuevoNombre;

        if (move_uploaded_file($ruta_provisional, $rutaCompleta)) {
            $query_update = "UPDATE subpropiedades SET url_foto_principal = '$rutaCompleta' WHERE id = '$id_subpropiedad'";
            if (mysqli_query($conn, $query_update)) {
                // Eliminar la foto anterior si existía
                if ($fotoAnterior && file_exists($fotoAnterior)) {
                    unlink($fotoAnterior);
                }
                echo "Foto principal actualizada correctamente.";
            } else {
                echo "Error al actualizar la base de datos: " . mysqli_error($conn);
            }
        } else {
            echo "Error al mover la nueva foto.";
        }
    } else {
        echo "Error: La subpropiedad no existe.";
    }
} else {
    echo "No se detectaron cambios en la foto principal.";
}
?>
