<?php
include("../conexion.php");

// Obtener los IDs y nombres de las fotos a eliminar
$idsFotos = isset($_POST['fotosAEliminar']) ? $_POST['fotosAEliminar'] : ''; // Aseguramos que se recibe la variable

if (!empty($idsFotos)) {
    $idsFotos = explode(',', $idsFotos); // Convertir los IDs y nombres a un array

    $i = 0;

    while ($i < count($idsFotos)) {
        $id = $idsFotos[$i];

        // Si el valor es numérico, es una foto existente en la base de datos
        if (is_numeric($id)) {
            // Eliminar foto existente de la base de datos
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
                    unlink($filePath); // Eliminar el archivo
                } else {
                    echo "El archivo no existe: $filePath";
                }
                
                // Eliminar el registro de la foto en la base de datos
                $query = "DELETE FROM fotos WHERE id = '$id'";
                if (!mysqli_query($conn, $query)) {
                    echo "Error al eliminar foto con ID $id: " . mysqli_error($conn);
                }
            } else {
                echo "No se encontró la foto con ID $id.";
            }
        } else {
            // Si el valor no es numérico, es el nombre de una foto nueva
            // No necesitamos hacer nada con los nombres, solo eliminamos la foto de la vista (ya que no está registrada en la BD)
            echo "Foto nueva eliminada: $id<br>";
        }
        
        $i++; // Incrementar el índice para el siguiente ciclo
    }
    
    echo "Las fotos seleccionadas han sido eliminadas correctamente.";
} else {
    echo "No se han proporcionado fotos para eliminar.";
}
?>
