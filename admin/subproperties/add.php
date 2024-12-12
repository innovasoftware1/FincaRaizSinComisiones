<?php
session_start();

if (!(isset($_SESSION['usuarioLogeado']) && isset($_SESSION['usuarioId']) && $_SESSION['usuarioLogeado'] != '')) {
    header("Location: ../login.php");
    exit();
}

$usuarioId = $_SESSION['usuarioId'];
include("../conexion.php");

// Inicializamos la variable $titulo_propiedad
$titulo_propiedad = "";

// Verificamos si se ha recibido el id de la propiedad
if (isset($_GET['id'])) {
    $propiedad_id = $_GET['id'];

    // Realizamos la consulta para obtener los datos de la propiedad principal
    $query = "SELECT * FROM propiedades WHERE id = '$propiedad_id'";
    $result = mysqli_query($conn, $query);

    // Obtener los datos de la propiedad principal

    
    if ($row = mysqli_fetch_assoc($result)) {
        $titulo_propiedad = $row['titulo'];
    } else {
        $titulo_propiedad = "Propiedad no encontrada";
    }
} else {
    $titulo_propiedad = "No se ha especificado una propiedad";
}

// Guardamos la subpropiedad
if (isset($_POST['agregar'])) {
    // Sanitizamos los datos de entrada
    $propiedad_id = $_POST['propiedad_id']; // ID de la propiedad principal
    $fecha_alta = $_POST['fecha_alta'];
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $area_tipo = $_POST['area_tipo'];
    $dimensiones = $_POST['dimensiones'];
    $area = $_POST['area'];
    $precio = $_POST['precio'];
    $moneda = $_POST['moneda'];
    $url_foto_principal = isset($_POST['url_foto_principal']) ? $_POST['url_foto_principal'] : '';
    $recorrido_360_url = $_POST['recorrido_360_url'];
    $video_url = $_POST['video_url'];
    $estado = $_POST['estado'];

    // Armamos el query para insertar en la tabla subpropiedades
    $query = "INSERT INTO subpropiedades (
        propiedad_id, 
        fecha_alta, 
        titulo, 
        descripcion, 
        area_tipo, 
        dimensiones,
        area, 
        precio, 
        moneda, 
        url_foto_principal, 
        video_url, 
        recorrido_360_url, 
        estado
    ) VALUES (
        '$propiedad_id', 
        '$fecha_alta', 
        '$titulo', 
        '$descripcion', 
        '$area_tipo', 
        '$dimensiones',
        '$area', 
        '$precio', 
        '$moneda', 
        '$url_foto_principal', 
        '$video_url', 
        '$recorrido_360_url', 
        '$estado'
    )";


    // Ejecutamos el query
    if (mysqli_query($conn, $query)) {
        $id_subpropiedad = mysqli_insert_id($conn); // Obtén el ID generado
        // Procesar fotos (pasa $id_subpropiedad a los scripts)
        $_POST['id_subpropiedad'] = $id_subpropiedad; // Agregarlo manualmente para los scripts
        include("../scripts_subpropiedades_fotos/procesar-foto-principal.php");
        include("../scripts_subpropiedades_fotos/procesar-fotos-galeria.php");
        
        $mensaje = "La subpropiedad se insertó correctamente";
    } else {
        $mensaje = "Error al insertar en la BD: " . mysqli_error($conn);
    }
    
    
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FRSC - ADMIN.</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../estilo.css">
    <style>


       

.contenedor-foto-galeria {
    position: relative;
    display: inline-block;
    margin: 10px;  /* Espaciado entre las fotos */
}

.foto-galeria {
    max-width: 100%; /* Asegura que la imagen no se desborde */
    height: auto;
    display: block; /* Evita que la imagen tenga márgenes extra */
}

/* Estilo para el botón de eliminar */
.eliminar-foto {
    position: absolute;
    top: 5px;
    right: 5px;
    background-color: rgba(255, 0, 0, 0.7); /* Fondo rojo con algo de transparencia */
    color: white;
    font-weight: bold;
    border: none;
    border-radius: 50%;
    padding: 5px 10px;
    cursor: pointer;
    font-size: 16px;
    z-index: 10; /* Asegura que el botón esté sobre la imagen */
    display: flex;
    align-items: center;
    justify-content: center;
}

.eliminar-foto:hover {
    background-color: rgba(255, 0, 0, 1); /* Fondo rojo sólido al pasar el mouse */
}

.eliminar-foto:focus {
    outline: none; /* Quitar el borde de enfoque cuando se hace clic */
}

        #info-propiedad {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #f1f1f1;
            padding: 20px;
            box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
            font-family: Arial, sans-serif;
        }

        #info-propiedad p {
            margin: 0;
            font-size: 16px;
        }

        #info-propiedad strong {
            color: #333;
        }

        .contenedor-foto-principal img {
            max-width: 200px;
            height: auto;
        }
    </style>
</head>

<body>
    <?php include("../header-menu.php"); ?>

    <div id="contenedor-admin">
        <?php include("../menu_index_options.php"); ?>

        <div class="contenedor-principal">
            <div id="nueva-propiedad">
                <h2>Registro de subpropiedad para la propiedad: <?php echo $titulo_propiedad; ?></h2>

                <h2>deseas registrar una subpropiedad a la propiedad: <?php echo htmlspecialchars($titulo_propiedad); ?>.</h2>

                <br>
                <hr>


                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">

                    <input type="hidden" name="propiedad_id" value="<?php echo $propiedad_id; ?>">
                    <input type="hidden" name="fecha_alta" id="fecha_alta">

                    <input type="hidden" name="id_subpropiedad" value="<?php echo isset($id_subpropiedad) ? $id_subpropiedad : ''; ?>">

                    

                    <script>
                        window.onload = function() {
                            const fechaActual = new Date();
                            const formatoISO = fechaActual.toISOString().slice(0, 19).replace('T', ' '); // Formato: YYYY-MM-DD HH:MM:SS
                            document.getElementById('fecha_alta').value = formatoISO;
                        };
                    </script>
                    <h3><i class="fa-solid fa-circle-info"></i> INFORMACION GENERAL</h3>
                    <br>
                    <hr>
                    <!-- Mostrar Titulo de la propiedad principal -->
                    <div class="fila-una-columna">
                        <label for="titulo">Título de la Propiedad</label>
                        <input type="text" name="titulo" required class="input-entrada-texto" placeholder="Nombre de la sub-propiedad..." maxlength="50">
                    </div>

                    <!-- Mostrar Descripción -->
                    <div class="fila-una-colummna">
                        <label for="descripcion">Descripción de la Propiedad</label>
                        <textarea name="descripcion" id="" cols="30" rows="10" class="input-entrada-texto" placeholder="Descripcion detallada de la sub-propiedad..." style="resize: none;"></textarea>
                    </div>
                    <br>

                    <!-- Estado -->
                    <div class="box">
                        <label for="estado">Estado de la propiedad</label>
                        <select name="estado" id="estado" class="input-entrada-texto">
                            <option value="activo">Activo</option>
                        </select>
                    </div>

                    <!-- Tipo de medidas -->
                    <div class="fila">
                        <div class="box">
                            <label for="area">Dimensiones</label>
                            <input type="text" name="dimensiones" class="input-entrada-texto" placeholder="Dimensiones (ej: Ancho x Largo)" required>
                        </div>

                        <div class="box">
                            <label for="area">Área total</label>
                            <input type="text" name="area" class="input-entrada-texto" placeholder="Área total de la propiedad (ej: 2000)" required>
                        </div>
                        <div class="box">
                            <label for="area_tipo">Tipo de Medida</label>
                            <select name="area_tipo" id="area_tipo" class="input-entrada-texto" required>
                                <option value="">Seleccione un tipo</option>
                                <option value="m²">Metros cuadrados (m²)</option>
                                <option value="hectáreas">Hectáreas</option>
                                <option value="acres">Acres</option>
                                <option value="pies²">Pies cuadrados (ft²)</option>
                            </select>
                        </div>
                    </div>
                    <div class="fila">
                        <div class="box">
                            <label for="precio">Precio</label>
                            <input type="text" name="precio" class="input-entrada-texto" placeholder="Precio de la propiedad (sin puntos)" required>
                        </div>
                        <div class="box">
                            <label for="moneda">Moneda</label>
                            <select name="moneda" class="input-entrada-texto" required>
                                <option value="COP">COP</option>
                                <option value="USD">USD</option>
                            </select>
                        </div>
                        <div class="box">
                        </div>
                    </div>
                    <hr>
                    <h3><i class="fa-solid fa-camera-retro"></i> GALERIA DE FOTOS</h3>
                    <br>
                    <hr>
                    <div>
                        <label for="foto1" class="btn-fotos">Foto Principal</label>
                        <output id="list" class="contenedor-foto-principal">
                            <img src="<?php echo $propiedad['url_foto_principal'] ?>" alt="">
                        </output>
                        <input type="file" id="foto1" accept="image/*" name="foto1" style="display:none">
                        <label for="fotos" class="btn-fotos"> Galería de Fotos </label>
                        <div id="contenedor-fotos-publicacion">
                        </div>
                        <input type="file" id="fotos" accept="image/*" name="fotos[]" value="Foto" multiple="" required style="display:none">
                    </div>
                    <br>
                    <hr>
                    <h3><i class="fa-solid fa-video"></i> VIDEO y RECORRIDO 360º</h3>
                    <br>
                    <hr>
                    <div class="box">
                        <label for="video_url">Video (Youtube.com)</label>
                        <input type="text" name="video_url" class="input-entrada-texto" placeholder="Ingrese enlace iframe de Yotube...">
                    </div>
                    <br>
                    <br>
                    <div class="box">
                        <label for="recorrido_360_url">Recorrido 360° (Webobook.com)</label>
                        <input type="text" name="recorrido_360_url" class="input-entrada-texto" placeholder="Ingrese URL del recorrido 360...">
                    </div>
                    <br>
                    <hr>
                    <br>
                    <input type="submit" value="Agregar Subpropiedad" name="agregar" class="btn-accion">
                </form>

                <?php if (isset($_POST['agregar'])) : ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: '¡Subpropiedad Agregada!',
            text: '<?php echo $mensaje; ?>',
            showConfirmButton: false,
            timer: 3000
        }).then(function() {
            // Obtener el ID de la subpropiedad recién insertada y el propiedad_id desde PHP
            var propiedadId = <?php echo $propiedad_id; ?>;

            // Redirigir a detalles.php con ambos parámetros en la URL
            window.location.href = '../ver-detalle-propiedad.php?id=' + propiedadId;
            
        });
    </script>
<?php endif; ?>         

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $('#link-add-propiedad').addClass('pagina-activa');
    </script>

    <script src="../scripts_subpropiedades_fotos/subirfoto.js"></script>
    <script src="../scripts_subpropiedades_fotos/scriptFotos.js"></script>
    <script src="../subir_v_r.js"></script>
    <script src="../vista_recorrido_video.js"></script>
</body>

</html>