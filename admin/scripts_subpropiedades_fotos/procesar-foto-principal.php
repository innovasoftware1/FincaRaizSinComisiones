<?php
include("../conexion.php");

// Verifica si se recibieron los datos necesarios
if (isset($_FILES["foto1"]) && isset($_POST['id_subpropiedad'])) {
    $id_subpropiedad = intval($_POST['id_subpropiedad']);

    // Crear directorio para las fotos si no existe
    $directorio = "../subproperties/fotos/" . $id_subpropiedad;
    if (!file_exists($directorio)) {
        mkdir($directorio, 0777, true);
    }

    $file = $_FILES["foto1"];
    $nombre = $file['name'];
    $tipo = $file['type'];
    $ruta_provisional = $file['tmp_name'];

    // Validar tipo de archivo
    $extensionesValidas = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
    if (!in_array($tipo, $extensionesValidas)) {
        die("Error: El archivo no es una imagen válida.");
    }

    // Generar un nombre único para la imagen
    $nuevoNombre = uniqid('foto_', true) . '.' . pathinfo($nombre, PATHINFO_EXTENSION);
    $rutaCompleta = $directorio . '/' . $nuevoNombre;

    // Mover el archivo al directorio
    if (move_uploaded_file($ruta_provisional, $rutaCompleta)) {
        // Actualizar la URL de la foto principal en la base de datos
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
    die("Error: No se recibió el ID de la subpropiedad o no se detectó foto principal.");
}
?>
