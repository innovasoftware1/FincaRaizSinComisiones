<?php
if (isset($_FILES["fotos"])) {
    if (isset($_POST['id_subpropiedad']) && !empty($_POST['id_subpropiedad'])) {
        $id_subpropiedad = intval($_POST['id_subpropiedad']);
    } else {
        die("Error: No se recibió el ID de la subpropiedad.");
    }

    $reporte = null;

    for ($x = 0; $x < count($_FILES["fotos"]["name"]); $x++) {
        $file = $_FILES["fotos"];
        $nombre = $file["name"][$x];
        $nombre = hash('ripemd160', $nombre);
        $tipo = $file["type"][$x];
        $ruta_provisional = $file["tmp_name"][$x];
        $size = $file["size"][$x];

        $directorio = 'fotos/' . $id_subpropiedad . "/";

        // Verificar tipo de archivo
        if ($tipo != 'image/jpeg' && $tipo != 'image/jpg' && $tipo != 'image/png' && $tipo != 'image/gif') {
            $reporte .= "<p style='color: red'>Error $nombre, el archivo no es una imagen.</p>";
        } else {
            // Agregar extensión según el tipo
            if ($tipo == "image/jpeg") {
                $nombre = $nombre . ".jpg";
            } elseif ($tipo == "image/png") {
                $nombre = $nombre . ".png";
            } elseif ($tipo == "image/gif") {
                $nombre = $nombre . ".gif";
            }

            // Crear directorio si no existe
            if (!file_exists($directorio)) {
                mkdir($directorio, 0777, true);
            }

            // Mover archivo al directorio
            if (move_uploaded_file($file['tmp_name'][$x], $directorio . $nombre)) {
                $query = "INSERT INTO subfotos (id, id_subpropiedad, nombre_foto) VALUES (NULL, '$id_subpropiedad', '$nombre')";

                if (!mysqli_query($conn, $query)) {
                    echo "Error al insertar la imagen: " . mysqli_error($conn);
                }
            } else {
                echo "Error al mover la imagen al directorio.";
            }
        }
    }
}
?>
