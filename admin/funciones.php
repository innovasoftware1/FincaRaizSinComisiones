<?php

define('BASE_URL', 'http://localhost/FincaRaizV1/fincaRaizInnova/');


/* function obtenerConfiguracion()
{
    include("conexion.php");

    // Verificar si la tabla configuracion tiene registros
    $query = "SELECT COUNT(*) AS total FROM configuracion";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Error en la consulta COUNT configuracion: " . mysqli_error($conn));
    }

    $row = mysqli_fetch_assoc($result);

    // Si no hay registros, insertar el valor inicial
    if ($row['total'] == '0') {
        $query = "INSERT INTO configuracion (id, propiedad1, propiedad2, propiedad3, propiedad4, propiedad5, propiedad6, propiedad_id)
                  VALUES (NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)";

        if (!mysqli_query($conn, $query)) {
            die("Error al insertar en configuracion: " . mysqli_error($conn));
        }
    }

    // Obtener la configuración del registro con id=1
    $query = "SELECT * FROM configuracion WHERE id = '1'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Error en la consulta SELECT configuracion: " . mysqli_error($conn));
    }

    $config = mysqli_fetch_assoc($result);
    return $config;
} */

function obtenerTotalRegistros($tabla)
{
    include("conexion.php");

    $query = "SELECT COUNT(*) AS total FROM $tabla";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Error en la consulta COUNT $tabla: " . mysqli_error($conn));
    }

    $fila = mysqli_fetch_assoc($result);
    return $fila['total'];
}

function agregarNuevoTipoDePropiedad($tipo)
{
    include("conexion.php");

    $query = "INSERT INTO tipos (id, nombre_tipo) VALUES (NULL, '$tipo')";

    if (!mysqli_query($conn, $query)) {
        die("Error al insertar en tipos: " . mysqli_error($conn));
    }

    return "Tipo de Propiedad agregado correctamente";
}

function agregarNuevoDepartamento($Departamento)
{
    include("conexion.php");

    $query = "INSERT INTO departamentos (id, nombre_departamento) VALUES (NULL, '$Departamento')";

    if (!mysqli_query($conn, $query)) {
        die("Error al insertar en departamentos: " . mysqli_error($conn));
    }

    return "Departamento agregado correctamente";
}
?>
