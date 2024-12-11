<?php

function obtenerTodasLasCiudades()
{
    include("admin/conexion.php");
    $query = "SELECT * FROM ciudades";
    $result = mysqli_query($conn, $query);
    return $result;
}

function obtenerPrecioPropiedadPorId($id_propiedad)
{
    include("admin/conexion.php");

    $query = "SELECT precio FROM propiedades WHERE id='$id_propiedad'";
    $resultado = mysqli_query($conn, $query);

    if (!$resultado) {
        die("Error en la consulta: " . mysqli_error($conn));
    }

    $propiedad = mysqli_fetch_assoc($resultado);

    if ($propiedad) {
        return $propiedad['precio'];
    } else {
        return "Propiedad no encontrada";
    }
}



function obtenerTodosLosTipos()
{
    include("admin/conexion.php");
    $query = "SELECT * FROM tipos";
    $result = mysqli_query($conn, $query);
    return $result;
}

function obtenerPropiedadPorId($id_propiedad)
{
    include("admin/conexion.php");

    $query = "SELECT * FROM propiedades WHERE id='$id_propiedad'";

    $resultado_propiedad = mysqli_query($conn, $query);
    $propiedad = mysqli_fetch_assoc($resultado_propiedad);
    return $propiedad;
}

function obtenerSubpropiedadesPorIdPropiedad($id_propiedad)
{
    include("admin/conexion.php");

    $query = "SELECT * FROM subpropiedades WHERE propiedad_id='$id_propiedad'";

    $resultado_subpropiedades = mysqli_query($conn, $query);

    $subpropiedades = [];
    while ($subpropiedad = mysqli_fetch_assoc($resultado_subpropiedades)) {
        $subpropiedades[] = $subpropiedad;
    }

    return $subpropiedades;
}




function obtenerCiudad($id_ciudad)
{
    include("admin/conexion.php");
    $query = "SELECT * FROM ciudades WHERE id='$id_ciudad'";

    $resultado_ciudad = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($resultado_ciudad);

    if ($row) {
        return $row['nombre_ciudad'];
    } else {
        return "Ciudad no encontrada";
    }
}

function obtenerDepartamento($id_Departamento)
{
    include("admin/conexion.php");
    $query = "SELECT * FROM departamentos WHERE id='$id_Departamento'";

    $resultado_Departamento = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($resultado_Departamento);

    if ($row) {
        return $row['nombre_departamento'];
    } else {
        return "País no encontrado";
    }
}


/* fotos principales de propiedades */
function obtenerFotosGaleria($id_propiedad)
{
    include("admin/conexion.php");
    $query = "SELECT * FROM fotos WHERE id_propiedad='$id_propiedad'";

    $resultado_fotos = mysqli_query($conn, $query);
    return $resultado_fotos;
}

/* /* fotos principales de sub-propiedades */
function obtenerFotosSubpropiedad($id_subpropiedad)
{
    include("admin/conexion.php");
    $query = "SELECT * FROM subfotos WHERE id_subpropiedad='$id_subpropiedad'";

    $resultado_fotos_subpropiedad = mysqli_query($conn, $query);
    return $resultado_fotos_subpropiedad;
}
 



function obtenerTipo($id_tipo)
{
    include("admin/conexion.php");

    if (empty($id_tipo)) {
        return "Tipo no proporcionado";
    }

    // Asegúrate de que $id_tipo sea un número entero
    $id_tipo = (int)$id_tipo;

    if ($id_tipo <= 0) {
        return "Tipo no válido";
    }

    $query = "SELECT * FROM tipos WHERE id = ?";

    if ($stmt = mysqli_prepare($conn, $query)) {
        
        mysqli_stmt_bind_param($stmt, "i", $id_tipo); // "i" para integer

        mysqli_stmt_execute($stmt);

        $resultado_tipo = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($resultado_tipo);

        if ($row) {
            return $row['nombre_tipo'];
        } else {
            return "Tipo no encontrado";
        }

        mysqli_stmt_close($stmt);
    } else {
        return "Error en la preparación de la consulta: " . mysqli_error($conn);
    }
}


function pluralToSingular($word)
{
    if (substr($word, -2) == 'es') {
        return substr($word, 0, -2);
    }
    if (substr($word, -1) == 's') {
        return substr($word, 0, -1);
    }
    return $word;
}


function realizarBusqueda($id_ciudad, $id_tipo, $tipoUbicacion, $precio_min = null, $precio_max = null)
{
    include("admin/conexion.php");

    $conditions = [];

    if ($id_ciudad) {
        if (is_array($id_ciudad)) {
            $id_ciudad = implode(',', array_map('intval', $id_ciudad));
            $conditions[] = "ciudad IN ($id_ciudad)";
        } else {
            $conditions[] = "ciudad = '$id_ciudad'";
        }
    }

    if ($id_tipo) {
        if (is_array($id_tipo)) {
            $id_tipo = implode(',', array_map('intval', $id_tipo));
            $conditions[] = "tipo IN ($id_tipo)";
        } else {
            $conditions[] = "tipo = '$id_tipo'";
        }
    }

    if ($tipoUbicacion) {
        if (is_array($tipoUbicacion)) {
            $tipoUbicacion = "'" . implode("','", array_map(function ($item) use ($conn) {
                return mysqli_real_escape_string($conn, $item);
            }, $tipoUbicacion)) . "'";
            $conditions[] = "tipoUbicacion IN ($tipoUbicacion)";
        } else {
            $conditions[] = "tipoUbicacion = '$tipoUbicacion'";
        }
    }

    if ($precio_min !== null && $precio_min !== '') {
        $precio_min = str_replace('.', '', $precio_min);
        $conditions[] = "precio >= " . (int)$precio_min;
    }

    if ($precio_max !== null && $precio_max !== '') {
        $precio_max = str_replace('.', '', $precio_max);
        $conditions[] = "precio <= " . (int)$precio_max;
    }

    $where = implode(' AND ', $conditions);

    $query = "SELECT * FROM propiedades" . (count($conditions) ? " WHERE $where" : "");

    return mysqli_query($conn, $query);
}

function obtenerPropiedades()
{
    include("admin/conexion.php");
    $query = "SELECT * FROM propiedades";
    $result = mysqli_query($conn, $query);
    return $result;
}
