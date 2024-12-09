<?php
session_start();
include("../conexion.php");

// Verificar conexión a la base de datos
if (!$conn) {
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
}

// Verificar si el usuario está logueado
if (!(isset($_SESSION['usuarioLogeado']) && isset($_SESSION['usuarioId']) && $_SESSION['usuarioLogeado'] != '')) {
    header("Location: ../login.php");
    exit();
}

// Declarar variables globales
$titulo = $descripcion = $area_tipo = $dimensiones = $area = $precio = $moneda = $url_foto_principal = $video_url = $recorrido_360_url = $estado = $propiedad_id = $mensaje = "";

// Obtener el ID de la subpropiedad
if (isset($_GET['id'])) {
    $subpropiedad_id = mysqli_real_escape_string($conn, $_GET['id']);

    // Verificar si existe la subpropiedad
    $query = "SELECT * FROM subpropiedades WHERE id = '$subpropiedad_id'";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        // Asignar valores
        $titulo = $row['titulo'];
        $descripcion = $row['descripcion'];
        $area_tipo = $row['area_tipo'];
        $dimensiones = $row['dimensiones'];
        $area = $row['area'];
        $precio = $row['precio'];
        $moneda = $row['moneda'];
        $url_foto_principal = $row['url_foto_principal'];
        $video_url = $row['video_url'];
        $recorrido_360_url = $row['recorrido_360_url'];
        $estado = $row['estado'];
        $propiedad_id = $row['propiedad_id'];
    } else {
        header("Location: ../error.php?mensaje=Subpropiedad no encontrada");
        exit();
    }
}

// Obtener fotos de galería de la subpropiedad
function obtenerFotosGaleriaDeSubpropiedad($subpropiedad_id)
{
    global $conn;
    $subpropiedad_id = mysqli_real_escape_string($conn, $subpropiedad_id);

    $query = "SELECT * FROM subfotos WHERE id_subpropiedad='$subpropiedad_id'";
    return mysqli_query($conn, $query);
}

// Actualizar subpropiedad
if (isset($_POST['actualizar'])) {
    $titulo = mysqli_real_escape_string($conn, $_POST['titulo'] ?? '');
    $descripcion = mysqli_real_escape_string($conn, $_POST['descripcion'] ?? '');
    $area_tipo = mysqli_real_escape_string($conn, $_POST['area_tipo'] ?? '');
    $dimensiones = mysqli_real_escape_string($conn, $_POST['dimensiones'] ?? '');
    $area = mysqli_real_escape_string($conn, $_POST['area'] ?? '');
    $precio = mysqli_real_escape_string($conn, $_POST['precio'] ?? '');
    $moneda = mysqli_real_escape_string($conn, $_POST['moneda'] ?? '');
    $url_foto_principal = mysqli_real_escape_string($conn, $_POST['url_foto_principal'] ?? '');
    $video_url = mysqli_real_escape_string($conn, $_POST['video_url'] ?? '');
    $recorrido_360_url = mysqli_real_escape_string($conn, $_POST['recorrido_360_url'] ?? '');
    $estado = mysqli_real_escape_string($conn, $_POST['estado'] ?? '');

    $query = "UPDATE subpropiedades SET 
        titulo = '$titulo', 
        descripcion = '$descripcion', 
        area_tipo = '$area_tipo', 
        dimensiones = '$dimensiones', 
        area = '$area', 
        precio = '$precio', 
        moneda = '$moneda', 
        url_foto_principal = '$url_foto_principal', 
        video_url = '$video_url', 
        recorrido_360_url = '$recorrido_360_url', 
        estado = '$estado' 
    WHERE id = '$subpropiedad_id'";

    if (mysqli_query($conn, $query)) {
        // Procesar foto principal
        if (!empty($_POST['fotoPrincipalActualizada']) && $_POST['fotoPrincipalActualizada'] == "si") {
            include("../scripts_subpropiedades_fotos/procesar-foto-principal.php");
        }
        
        // Procesar galería de fotos
        if (!empty($_POST['fotosGaleriaActualizada']) && $_POST['fotosGaleriaActualizada'] == "si") {
            $id_ultima_propiedad = $propiedad_id;
            include("../scripts_subpropiedades_fotos/procesar-fotos-galeria.php");
        }

        // Eliminar fotos indicadas
        if (!empty($_POST['fotosAEliminar'])) {
            $idsFotos = mysqli_real_escape_string($conn, $_POST['fotosAEliminar']);
            include("../scripts_subpropiedades_fotos/eliminar-fotos-de-galeria.php");
        }

        $mensaje = "La subpropiedad se actualizó correctamente";
    } else {
        $mensaje = "Error al actualizar en la BD: " . mysqli_error($conn);
    }
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FRSC - ADMIN.</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link rel="stylesheet" href="../estilo.css">
</head>

<body>
    <?php include("../header-menu.php"); ?>
    <div id="contenedor-admin">
        <?php include("../menu_index_options.php"); ?>

        <div class="contenedor-principal">
            <div id="nueva-propiedad">  
                <h2>Actualizar subpropiedad: <?php echo htmlspecialchars($titulo); ?></h2>
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="propiedad_id" value="<?php echo $propiedad_id; ?>">

                
                    <div class="fila-una-columna">
                        <label for="titulo">Título de la Propiedad</label>
                        <input type="text" name="titulo" value="<?php echo $titulo; ?>" required class="input-entrada-texto" placeholder="Nombre de la propiedad...">
                    </div>

                    <!-- Descripción -->
                    <div class="fila-una-columna">
                        <label for="descripcion">Descripción de la Propiedad</label>
                        <textarea name="descripcion" id="" cols="30" rows="10" class="input-entrada-texto" placeholder="Descripcion detallada de la propiedad..." style="resize: none;"><?php echo $descripcion; ?></textarea>
                    </div>

                    <!-- Estado -->
                    <div class="box">
                        <label for="estado">Estado de la propiedad</label>
                        <select name="estado" id="estado" class="input-entrada-texto">
                            <option value="activo" <?php if ($estado == 'activo') echo 'selected'; ?>>Activo</option>
                            <option value="inactivo" <?php if ($estado == 'inactivo') echo 'selected'; ?>>Inactivo</option>
                        </select>
                    </div>

                <!-- Dimensiones, Área, Tipo de Medida -->
                <div class="fila">
                    <div class="box">
                        <label for="dimensiones">Dimensiones</label>
                        <input type="text" name="dimensiones" value="<?php echo $dimensiones; ?>" class="input-entrada-texto" placeholder="Dimensiones del predio" required>
                    </div>

                    <div class="box">
                        <label for="area">Área en metros cuadrados</label>
                        <input type="text" name="area" value="<?php echo $area; ?>" class="input-entrada-texto" placeholder="Área" required>
                    </div>

                    <div class="box">
                        <label for="area_tipo">Tipo de Medidas</label>
                        <select name="area_tipo" id="area_tipo" class="input-entrada-texto" required>
                            <option value="m²" <?php if ($area_tipo == 'm²') echo 'selected'; ?>>Metros cuadrados (m²)</option>
                            <option value="hectáreas" <?php if ($area_tipo == 'hectáreas') echo 'selected'; ?>>Hectáreas</option>
                            <option value="acres" <?php if ($area_tipo == 'acres') echo 'selected'; ?>>Acres</option>
                            <option value="pies²" <?php if ($area_tipo == 'pies²') echo 'selected'; ?>>Pies cuadrados (ft²)</option>
                        </select>
                    </div>
                </div>

                <!-- Precio -->
                <div class="box">
                    <label for="precio">Precio</label>
                    <input type="text" name="precio" value="<?php echo $precio; ?>" class="input-entrada-texto" placeholder="Precio de la propiedad" required>
                </div>

                <!-- Moneda -->
                <div class="fila">
                    <div class="box">
                        <label for="moneda">Moneda</label>
                        <select name="moneda" class="input-entrada-texto" required>
                            <option value="COP" <?php if ($moneda == 'COP') echo 'selected'; ?>>COP</option>
                            <option value="USD" <?php if ($moneda == 'USD') echo 'selected'; ?>>USD</option>
                        </select>
                    </div>
                </div>

                <h3>GALERÍA DE FOTOS</h3>
                <hr>

                <!-- Foto Principal -->
                <div>
                    <p>Foto principal (<label for="foto1" class="btn-cambiar-foto">Cambiar foto</label>)</p>
                    <output id="list" class="contenedor-foto-principal">
                        <img src="<?php echo $url_foto_principal ?>" alt="">
                    </output>

                    <input type="file" id="foto1" accept="image/*" name="foto1" style="display:none">
                    <input type="hidden" id="fotoPrincipalActualizada" name="fotoPrincipalActualizada">
                </div>

                <!-- Galería de Fotos -->
                <div>
                    <p>Galería ( <label for="fotos" class="btn-cambiar-foto">Agregar más Fotos</label>)</p>
                    <input type="hidden" id="fotosAEliminar" name="fotosAEliminar">
                    <div id="contenedor-fotos-publicacion">
                        <?php
                        $galeria = obtenerFotosGaleriaDeSubpropiedad($subpropiedad_id);
                        $i = 1;
                        ?>
                        <?php while ($foto = mysqli_fetch_assoc($galeria)) : ?>
                            <output class="contenedor-foto-galeria" id="foto-<?php echo $i ?>">
                                <img src="fotos/<?php echo $subpropiedad_id . "/" . $foto['nombre_foto'] ?>" class="foto-galeria">
                                <span class="btn-eliminar-galeria" data-id="<?php echo $foto['id'] ?>" data-index="<?php echo $i ?>" onclick="eliminarFoto(<?php echo $foto['id'] ?>, <?php echo $i ?>)">Eliminar</span>
                            </output>
                        <?php
                            $i++;
                        endwhile
                        ?>
                    </div>

                    <div id="contenedor-fotos-nuevas"></div>

                    <!-- El input de archivo está oculto -->
                    <input type="file" id="fotos" accept="image/*" name="fotos[]" value="Foto" multiple="" style="display:none" onchange="agregarFotosNuevas()">
                    <input type="hidden" id="fotosGaleriaActualizada" name="fotosGaleriaActualizada">
                </div>


                <br>
                <br>

                <!-- Video URL -->
                <div class="box">
                    <label for="video_url">URL del Video</label>
                    <input type="text" name="video_url" value="<?php echo $video_url; ?>" class="input-entrada-texto" placeholder="URL del video">
                </div>

                <!-- Recorrido 360 URL -->
                <div class="box">
                    <label for="recorrido_360_url">URL del Recorrido 360</label>
                    <input type="text" name="recorrido_360_url" value="<?php echo $recorrido_360_url; ?>" class="input-entrada-texto" placeholder="URL del recorrido 360">
                </div>
                <br>

                <input type="submit" value="Actualizar Subpropiedad" name="actualizar" class="btn-accion">
            </form>

            <?php if ($mensaje): ?>
                <p><?php echo htmlspecialchars($mensaje); ?></p>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>
