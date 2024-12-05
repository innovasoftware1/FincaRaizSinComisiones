<?php
include("../conexion.php");

// Verifica si se recibe el parámetro "c"
if (isset($_GET['c']) && !empty($_GET['c'])) {
    $id_departamento = intval($_GET['c']); // Convertir a entero por seguridad

    // Construye la consulta
    $query = "SELECT * FROM ciudades WHERE id_departamento = $id_departamento";
    $resultado_ciudades = mysqli_query($conn, $query);

    // Verifica si la consulta se ejecutó correctamente
    if (!$resultado_ciudades) {
        die("Error en la consulta: " . mysqli_error($conn) . " Consulta: " . $query);
    }

    // Verifica si hay resultados
    if (mysqli_num_rows($resultado_ciudades) > 0) {
        while ($row = mysqli_fetch_assoc($resultado_ciudades)) {
            echo '<option value="' . $row['id'] . '">' . $row['nombre_ciudad'] . '</option>';
        }
    } else {
        echo '<option value="">No hay ciudades disponibles</option>';
    }
} else {
    echo "Error: No se recibió un ID de departamento válido.";
}
?>
