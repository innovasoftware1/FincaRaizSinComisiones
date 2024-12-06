<?php
if (isset($_FILES["fotos"]))
{
    $reporte = null;
        for($x=0; $x<count($_FILES["fotos"]["name"]); $x++)
    {
        $file = $_FILES["fotos"];
        $nombre = $file["name"][$x];
        $nombre = hash('ripemd160', $nombre);
        $tipo = $file["type"][$x];
        $ruta_provisional = $file["tmp_name"][$x];
        $size = $file["size"][$x];
            
        $directorio = 'fotos/'.$id_ultima_propiedad."/"; 

        if ($tipo != 'image/jpeg' && $tipo != 'image/jpg' && $tipo != 'image/png' && $tipo != 'image/gif')
        {
            $reporte .= "<p style='color: red'>Error $nombre, el archivo no es una imagen.</p>";
        }   
        else
        {
            if($tipo="image/jpeg"){
                $nombre = $nombre . ".jpg";
            } else if($tipo="image/png"){
                $nombre = $nombre . ".png";
            } else if($tipo = "image/gif"){
                $nombre = $nombre . ".gif";
            }
            
            move_uploaded_file($file['tmp_name'][$x], $directorio.$nombre);     

            $query = "INSERT INTO fotos (id, id_propiedad, nombre_foto) VALUES (NULL, '$id_ultima_propiedad', '$nombre')";
            
            if(mysqli_query($conn, $query)){
            }else{
                echo "No se pudo insertar la imagen de la publicacion" . mysqli_error($conn) ;
            }
        }
    }
}

?>