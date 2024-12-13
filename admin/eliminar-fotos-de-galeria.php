<?php
$idsFotos = explode(',', $idsFotos);

$i = 0;

while ($i < count($idsFotos)) {
    $id = $idsFotos[$i];
    $query = "SELECT * FROM fotos WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    
    // Verificar si se encontró la foto
    $foto = mysqli_fetch_assoc($result);
    
    if ($foto) {
        // Crear la ruta del directorio y archivo
        $directorio = "property/fotos/".$foto['id_propiedad']."/"; 
        $archivo = $foto['nombre_foto'];
        $filePath = $directorio . $archivo;
        
        // Verificar si el archivo existe antes de intentar eliminarlo
        if (file_exists($filePath)) {
            unlink($filePath);
        } else {
            echo "El archivo no existe: $filePath";
        }
        
        // Eliminar el registro de la foto de la base de datos
        $query = "DEL
>
?>
