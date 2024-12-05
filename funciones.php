<?php
    
function obtenerConfiguracion()
{
    include("admin/conexion.php");
    $query = "SELECT COUNT(*) AS total FROM configuracion";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row['total'] == '0') {
        echo "Valor" . $row['total'];
        $query = "INSERT INTO configuracion (id, user, password)
                  VALUES (NULL, 'admin', 'admin')";

        if (mysqli_query($conn, $query)) { 
        } else {
            echo "No se pudo insertar en la BD" . mysqli_error($conn);
        }
    }

    $query = "SELECT * FROM configuracion WHERE id='1'";
    $result = mysqli_query($conn, $query);
    $config = mysqli_fetch_assoc($result);

    if (!$config) {
        echo "No se pudo obtener la configuración.";
        return null;
    }

    return $config;
}

function obtenerTodasLasCiudades()
{
    include("admin/conexion.php");
    $query = "SELECT * FROM ciudades";
    $result = mysqli_query($conn, $query);
    return $result;
}

function obtenerTodosLosTipos()
{
    include("admin/conexion.php");
    $query = "SELECT * FROM tipos";
    $result = mysqli_query($conn, $query);
    return $result;
}

function cargarPropiedades($limInferior)
{
    include("admin/conexion.php");
    $config = obtenerConfiguracion();

    if (!$config) {
        echo "No se pudo obtener la configuración.";
        return null;
    }

    if ($config['tipo_visualizacion_propiedades'] == "f") { // Visualizamos por fecha de carga
        $query = "SELECT * FROM propiedades ORDER BY fecha_alta DESC LIMIT $limInferior, 6";
        $result = mysqli_query($conn, $query);
        return $result;
    } else { 
        $query = "SELECT * FROM propiedades WHERE id IN ('$config[propiedad1]', '$config[propiedad2]', '$config[propiedad3]', '$config[propiedad4]', '$config[propiedad5]', '$config[propiedad6]')
                  UNION
                  SELECT * FROM propiedades WHERE id NOT IN ('$config[propiedad1]', '$config[propiedad2]', '$config[propiedad3]', '$config[propiedad4]', '$config[propiedad5]', '$config[propiedad6]') 
                  LIMIT $limInferior, 6";
        $result = mysqli_query($conn, $query);
        return $result;
    }
}

function obtenerPropiedadPorId($id_propiedad)
{
    include("admin/conexion.php");

    $query = "SELECT * FROM propiedades WHERE id='$id_propiedad'";

    $resultado_propiedad = mysqli_query($conn, $query);
    $propiedad = mysqli_fetch_assoc($resultado_propiedad);
    return $propiedad;
}

function obtenerCiudad($id_ciudad)
{
    include("admin/conexion.php");
    $query = "SELECT * FROM ciudades WHERE id='$id_ciudad'";

    // Ejecutamos la consulta
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

function obtenerFotosGaleria($id_propiedad)
{
    include("admin/conexion.php");
    $query = "SELECT * FROM fotos WHERE id_propiedad='$id_propiedad'";

    $resultado_fotos = mysqli_query($conn, $query);
    return $resultado_fotos;
}

function obtenerTipo($id_tipo)
{
    include("admin/conexion.php");

    if (empty($id_tipo)) {
        return "Tipo no proporcionado";
    }

    $id_tipo = trim($id_tipo);
    $query = "SELECT * FROM tipos WHERE id = ?";

    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "s", $id_tipo); 

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

function pluralToSingular($word) {
    if (substr($word, -2) == 'es') {
        return substr($word, 0, -2);
    }
    if (substr($word, -1) == 's') {
        return substr($word, 0, -1);
    }
    return $word;
}

function realizarBusqueda($id_ciudad, $id_tipo, $estado, $precio_min = null, $precio_max = null)
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

    if ($estado) {
        if (is_array($estado)) {
            $estado = "'" . implode("','", array_map(function($item) use ($conn) {
                return mysqli_real_escape_string($conn, $item);
            }, $estado)) . "'";
            $conditions[] = "estado IN ($estado)";
        } else {
            $conditions[] = "estado = '$estado'";
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
?>
