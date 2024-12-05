<?php
$idsFotos = explode(',', $idsFotos);

$i=0;

while ($i < count($idsFotos)){
    $id = $idsFotos[$i];
    $query = "SELECT * FROM fotos WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    $foto = mysqli_fetch_assoc($result); 
    
    $directorio = "fotos/".$foto['id_propiedad']."/"; 
    $archivo = $foto['nombre_foto'];
    unlink($directorio.$archivo);
    
    $query = "DELETE FROM fotos WHERE id = '$id'";

    $result = mysqli_query($conn, $query);
    
    $i++;
}
?>
