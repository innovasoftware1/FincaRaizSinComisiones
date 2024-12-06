    <?php
    include("conexion.php"); // Asegúrate de tener tu conexión a la base de datos aquí

    // Comprobamos si se ha enviado el dato a través de POST
    if (isset($_POST['ubicacion_url'])) {
        // Sanitize the input to avoid SQL injection
        $ubicacion_url = mysqli_real_escape_string($conn, $_POST['ubicacion_url']);

        // Verificar si la URL está correcta
        echo "URL recibida: " . $ubicacion_url . "<br>";  // Depuración: Verificamos si la URL se está recibiendo

        // Extraer solo el parámetro 'src' de la URL, si existe
        $url_components = parse_url($ubicacion_url);
        
        // Comprobamos si la URL tiene parámetros de consulta (query string)
        if (isset($url_components['query'])) {
            // Extraemos los parámetros de la URL
            parse_str($url_components['query'], $query_params);
            
            // Comprobamos si el parámetro 'src' existe en los parámetros
            if (isset($query_params['src'])) {
                $src = $query_params['src'];
                echo "src extraído: " . $src . "<br>";  // Depuración: Verificamos si el parámetro 'src' se extrajo correctamente

                // Obtener el ID de la última propiedad (última entrada en la tabla)
                $query = "SELECT * FROM propiedades ORDER BY id DESC LIMIT 1";
                $resultado = mysqli_query($conn, $query);

                // Comprobamos si se encontró alguna propiedad
                if (mysqli_num_rows($resultado)) {
                    $propiedad = mysqli_fetch_assoc($resultado);
                    $id_ultima_propiedad = $propiedad['id'];

                    // Mostrar el ID de la última propiedad (verificamos si es correcto)
                    echo "ID de la última propiedad: " . $id_ultima_propiedad . "<br>";

                    // Actualizar la URL de ubicación con el valor de 'src' recibido
                    $update_query = "UPDATE propiedades SET ubicacion_url = '$src' WHERE id = '$id_ultima_propiedad'";
                    echo "Consulta de actualización: " . $update_query . "<br>";  // Depuración: Verificamos la consulta antes de ejecutarla

                    // Ejecutamos la consulta de actualización
                    if (mysqli_query($conn, $update_query)) {
                        echo "URL de ubicación actualizada correctamente.";
                    } else {
                        // Si ocurre un error, mostramos el mensaje de error
                        echo "Error al actualizar la URL de ubicación: " . mysqli_error($conn);
                    }
                } else {
                    // Si no se encuentra ninguna propiedad, mostramos un mensaje de error
                    echo "No se encontró la última propiedad.";
                }
            } else {
                // Si el parámetro 'src' no existe, mostramos un mensaje de error
                echo "No se encontró el parámetro 'src' en la URL.";
            }
        } else {
            // Si la URL no contiene parámetros, mostramos un mensaje de error
            echo "La URL no contiene parámetros.";
        }
    } else {
        // Si no se ha enviado la URL, mostramos un mensaje de error
        echo "No se ha enviado la URL.";
    }
    ?>
