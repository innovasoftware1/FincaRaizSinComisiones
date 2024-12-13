<?php
include("conexion.php");

// Verifica si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Valida si la URL está presente
    if (empty($_POST['recorrido_360_url'])) {
        echo "Por favor ingrese la URL del recorrido 360.";
        exit();
    }

    // Obtiene la URL del recorrido 360 desde el formulario
    $recorrido_360_url = $_POST['recorrido_360_url'];

    // Valida la URL del recorrido 360
    if (filter_var($recorrido_360_url, FILTER_VALIDATE_URL) === false) {
        echo "La URL del recorrido 360 no es válida.";
        exit();
    }

    // Consulta para obtener la última subpropiedad
    $query = "SELECT * FROM subpropiedades ORDER BY id DESC LIMIT 1";
    $resultado = mysqli_query($conn, $query);

    // Verifica si se obtuvo un resultado
    if (mysqli_num_rows($resultado)) {
        $propiedad = mysqli_fetch_assoc($resultado);
        $id_ultima_propiedad = $propiedad['id'];

        // Usa una sentencia preparada para actualizar la URL de manera segura
        $query = "UPDATE subpropiedades SET recorrido_360_url = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);

        // Verifica si la preparación fue exitosa
        if ($stmt) {
            // Enlaza los parámetros y ejecuta la consulta
            mysqli_stmt_bind_param($stmt, "si", $recorrido_360_url, $id_ultima_propiedad);
            if (mysqli_stmt_execute($stmt)) {
                echo "URL del recorrido 360 actualizada correctamente.";
            } else {
                echo "Error al actualizar la URL: " . mysqli_error($conn);
            }

            // Cierra la declaración
            mysqli_stmt_close($stmt);
        } else {
            echo "Error en la preparación de la consulta: " . mysqli_error($conn);
        }
    } else {
        echo "No se pudo obtener la última propiedad.";
    }
}
?>
