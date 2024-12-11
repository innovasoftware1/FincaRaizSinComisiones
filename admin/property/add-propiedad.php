<?php

session_start();


if (!(isset($_SESSION['usuarioLogeado']) && isset($_SESSION['usuarioId']) && $_SESSION['usuarioLogeado'] != '')) {
    header("Location: ../login.php");
    exit();
}
$usuarioId = $_SESSION['usuarioId'];

include("../conexion.php");



$query = "SELECT * FROM tipos";
$resultado_tipos = mysqli_query($conn, $query);

$query = "SELECT * FROM departamentos";

$resultado_departamentos = mysqli_query($conn, $query);



// Guardamos propiedad
if (isset($_POST['agregar'])) {
    include("../conexion.php");

    $fecha_alta = $_POST['fecha_alta'];
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $tipo = $_POST['tipo'];
    $estado = $_POST['estado'];
    $ubicacion = $_POST['ubicacion'];
    $tipoUbicacion = $_POST['tipoUbicacion'];
    $direccion = $_POST['direccion'];
    $habitaciones = $_POST['habitaciones'];
    $banios = $_POST['banios'];
    $pisos = $_POST['pisos'];
    $garage = $_POST['garage'];
    $dimensiones = $_POST['dimensiones'];
    $dimensiones_tipo = $_POST['dimensiones_tipo'];
    $area = $_POST['area'];
    $altitud = $_POST['altitud'];
    $distancia_pueblo = $_POST['distancia_pueblo'];
    $vias_acceso = $_POST['vias_acceso'];
    $clima = $_POST['clima'];
    $precio = $_POST['precio'];
    $moneda = $_POST['moneda'];
    $url_foto_principal = isset($_POST['url_foto_principal']) ? $_POST['url_foto_principal'] : '';
    $video_url = $_POST['video_url'];
    $recorrido_360_url = $_POST['recorrido_360_url'];
    $ubicacion_url = isset($_POST['ubicacion_url']) ? $_POST['ubicacion_url'] : '';
    $documentos_transferencia = $_POST['documentos_transferencia'];
    $permisos = $_POST['permisos'];
    $uso_principal = $_POST['uso_principal'];
    $uso_compatibles = $_POST['uso_compatibles'];
    $uso_condicionales = $_POST['uso_condicionales'];
    $departamento = $_POST['departamento'];
    $ciudad = $_POST['ciudad'];
    $luz = isset($_POST['luz']) ? $_POST['luz'] : 0;
    $gas = isset($_POST['gas']) ? $_POST['gas'] : 0;
    $internet = isset($_POST['internet']) ? $_POST['internet'] : 0;
    $permuta = isset($_POST['permuta']) ? $_POST['permuta'] : 0;
    $caracteristicas_positivas = $_POST['caracteristicas_positivas'];
    $distancia_desde_bogota = $_POST['distancia_desde_bogota'];
    $financiacion = $_POST['financiacion'];
    $salidas_bogota = $_POST['salidas_bogota'];
    $agua_propia = $_POST['agua_propia'];
    $construcciones_aledañas = $_POST['construcciones_aledañas'];
    $inventario = $_POST['inventario'];
    $nombre_propietario = $_POST['nombre_propietario'];
    $usuarioId = $_SESSION['usuarioId'];

    $query = "INSERT INTO propiedades (
        fecha_alta, titulo, descripcion, tipo, tipoUbicacion, estado, ubicacion, direccion, habitaciones, banios, pisos, 
        garage, dimensiones, dimensiones_tipo, area, altitud, distancia_pueblo, vias_acceso, clima, 
        precio, moneda, url_foto_principal, video_url, recorrido_360_url, ubicacion_url, 
        documentos_transferencia, permisos, uso_principal, uso_compatibles, uso_condicionales, 
        departamento, ciudad, luz, gas, internet, permuta, caracteristicas_positivas, 
        distancia_desde_bogota, financiacion, salidas_bogota, agua_propia, construcciones_aledañas, 
        inventario, fecha_de_venta, nombre_propietario , usuario_id
    ) VALUES (
        CURRENT_TIMESTAMP, '$titulo', '$descripcion', '$tipo', '$tipoUbicacion', 'activo', '$ubicacion', '$direccion', 
        '$habitaciones', '$banios', '$pisos', '$garage', '$dimensiones', '$dimensiones_tipo', '$area', '$altitud', 
        '$distancia_pueblo', '$vias_acceso', '$clima', '$precio', '$moneda', '$url_foto_principal', '$video_url', 
        '$recorrido_360_url', '$ubicacion_url', '$documentos_transferencia', '$permisos', '$uso_principal', 
        '$uso_compatibles', '$uso_condicionales', '$departamento', '$ciudad', '$luz', '$gas', '$internet', '$permuta', 
        '$caracteristicas_positivas', '$distancia_desde_bogota', '$financiacion', '$salidas_bogota', '$agua_propia', 
        '$construcciones_aledañas', '$inventario', NULL,'$nombre_propietario','$usuarioId'
    )";


    if (mysqli_query($conn, $query)) {
        include("../procesar-foto-principal.php");
        include("../procesar-fotos-galeria.php");
        $mensaje = "La propiedad se insertó correctamente";
    } else {
        $mensaje = "No se pudo insertar en la BD" . mysqli_error($conn);
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
    <script>
        function muestraselect(str) {
            var conexion;

            if (str == "") {
                document.getElementById("ciudad").innerHTML = "";
                return;
            }
            if (window.XMLHttpRequest) {
                conexion = new XMLHttpRequest();
            }


            conexion.onreadystatechange = function() {
                if (conexion.readyState == 4 && conexion.status == 200) {
                    document.getElementById("ciudad").innerHTML = conexion.responseText;
                }
            }

            conexion.open("GET", "ciudad.php?c=" + str, true);
            conexion.send();
        }
    </script>
</head>

<body>
    <?php include("../header-menu.php"); ?>

    <div id="contenedor-admin">
        <?php include("../menu_index_options.php"); ?>

        <div class="contenedor-principal">
            <div id="nueva-propiedad">
                <h2>Nueva propiedad</h2>
                <br>
                <hr>
                <br>

                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">

                    <input type="hidden" name="fecha_alta" id="fecha_alta">
                    <script>
                        window.onload = function() {
                            const fechaActual = new Date();
                            const formatoISO = fechaActual.toISOString().slice(0, 19).replace('T', ' '); // Formato: YYYY-MM-DD HH:MM:SS
                            document.getElementById('fecha_alta').value = formatoISO;
                        };
                        console.log(fecha_alta)
                    </script>


                    <!-- INFORMACION GENERAL-->
                    <h3><i class="fa-solid fa-circle-info"></i> INFORMACION GENERAL</h3>
                    <br>
                    <hr>
                    <div class="fila">
                        <div class="box">
                            <label for="titulo">Nombre de la propiedad</label>
                            <input type="text" name="titulo" required class="input-entrada-texto" placeholder="Nombre de la propiedad..." maxlength="50">
                        </div>

                        <div class="box">
                            <label for="tipo">Seleccione tipo de propiedad</label>
                            <select name="tipo" id="" class="input-entrada-texto">
                                <?php while ($row = mysqli_fetch_assoc($resultado_tipos)) : ?>
                                    <option value="<?php echo $row['id'] ?>">
                                        <?php echo $row['nombre_tipo'] ?>
                                    </option>
                                <?php endwhile ?>
                            </select>
                        </div>

                        <div class="box">
                            <label for="tipoUbicacion">Tipo De ubicacion</label>
                            <select name="tipoUbicacion" id="tipoUbicacion" class="input-entrada-texto">
                                <option value="Campestre">Campestre</option>
                                <option value="Urbano">Urbano</option>
                            </select>
                        </div>
                    </div>

                    <div class="fila">
                        <div class="box">
                            <label for="descripcion">Descripción de la Propiedad</label>
                            <textarea name="descripcion" id="" cols="30" rows="10" class="input-entrada-texto" placeholder="Descripcion detallada de la propiedad..." style="width: 660px; height: 150px; resize: none;"></textarea>
                        </div>

                        <div class="box">
                            <label for="estado">Estado de la propiedad</label>
                            <select name="estado" id="estado" class="input-entrada-texto">
                                <option value="Activo">Activo</option>
                            </select>
                        </div>
                    </div>
                    <hr>


                    <!-- CARACTERISTICAS DE LOS PREDIOS-->
                    <h3><i class="fa-solid fa-house-medical"></i> CARACTERISTICAS DETALLADAS</h3>
                    <br>
                    <hr>
                    <div class="fila">
                        <div class="box">
                            <label for="habitaciones">Habitaciones</label>
                            <input type="text" name="habitaciones" class="input-entrada-texto" placeholder="Número de habitaciones (ej. 2, 5, etc...)" maxlength="2" required />
                        </div>
                        <div class="box">
                            <label for="banios">Baños</label>
                            <input type="text" name="banios" class="input-entrada-texto" placeholder="Número de baños (ej. 2, 5, etc...)" maxlength="2" required>
                        </div>

                        <div class="box">
                            <label for="pisos">Pisos</label>
                            <input type="text" name="pisos" class="input-entrada-texto" placeholder="Número de pisos (ej. 2, 5, etc...)" maxlength="2" required>
                        </div>
                    </div>

                    <div class="fila">
                        <div class="box">
                            <label for="inventario">Inventario</label>
                            <textarea name="inventario" id="" cols="30" rows="10" class="input-entrada-texto" placeholder="Inventario detallado de la propiedad..." style="width: 660px; height: 150px; resize: none;"></textarea>
                        </div>
                        <div class="box">
                            <label for="garage">Garaje</label>
                            <input type="text" name="garage" class="input-entrada-texto" placeholder="Número de garages (ej. 2, 5, etc...)" maxlength="2" required>
                        </div>

                    </div>

                    <hr>
                    <h3><i class="fa-solid fa-ruler"></i> MEDIDAS Y DIMENSIONES</h3>
                    <br>
                    <hr>
                    <div class="fila">
                        <div class="box">
                            <label for="dimensiones">Dimensiones</label>
                            <input type="text" name="dimensiones" class="input-entrada-texto" placeholder="Dimensiones (ej: Ancho x Largo)" maxlength="20" required>
                        </div>
                        <div class="box">
                            <label for="area">Área total</label>
                            <input type="text" name="area" class="input-entrada-texto" placeholder="Área total de la propiedad (ej: 2000)" maxlength="20" required>
                        </div>
                        <div class="box">
                            <label for="dimensiones_tipo">Tipo de Medida</label>
                            <select name="dimensiones_tipo" id="dimensiones_tipo" class="input-entrada-texto" required>
                                <option value="m²">Metros cuadrados (m²)</option>
                                <option value="hectáreas">Hectáreas (ha)</option>
                                <option value="acres">Acres (ac)</option>
                                <option value="pies²">Pies cuadrados (ft²)</option>
                            </select>
                        </div>

                    </div>
                    <hr>

                    <h3><i class="fa-solid fa-map-location-dot"></i> UBICACION GEOGRAFICA</h3>
                    <br>
                    <hr>
                    <div class="fila">
                        <div class="box">
                            <label for="departamento">Seleccione Depart. de la Propiedad</label>
                            <select name="departamento" id="" onchange="muestraselect(this.value)" class="input-entrada-texto">
                                <option value="">Seleccione el departamento</option>
                                <?php while ($row = mysqli_fetch_assoc($resultado_departamentos)) : ?>
                                    <option value="<?php echo $row['id'] ?>">
                                        <?php echo $row['nombre_departamento'] ?>
                                    </option>
                                <?php endwhile ?>
                            </select>
                        </div>
                        <div class="box">
                            <label for="ciudad">Seleccione una ciudad</label>
                            <select name="ciudad" id="ciudad" class="input-entrada-texto" required>
                            </select>
                        </div>

                        <div class="box">
                            <label for="ubicacion">Barrio o Pueblo</label>
                            <input type="text" name="ubicacion" class="input-entrada-texto" placeholder="Ubicación de la propiedad" required>
                        </div>
                    </div>
                    <div class="fila-una-columna">
                        <label for="direccion">Dirección</label>
                        <input type="text" name="direccion" class="input-entrada-texto" placeholder="Ubicación de la propiedad" required>
                    </div>


                    <div class="input-container">
                        <br>
                        <label for="ubicacion_url">Ingrese la URL de la ubicación:</label>
                        <textarea class="input-entrada-texto" id="ubicacion_url" name="ubicacion_url" placeholder="Pegue aquí el iframe" style="resize: none;"></textarea><br>
                        <div id="previewContainer"></div> <!-- Contenedor para mostrar el iframe -->
                        <div id="errorContainer" class="error-message"></div> <!-- Contenedor para mostrar errores -->
                    </div>
                    <hr>



                    <h3><i class="fa-solid fa-lightbulb"></i> SERVICIOS Y CARACTERISTICAS</h3>
                    <br>
                    <hr>
                    <div class="fila">
                        <div class="box">
                            <label for="agua_propia">Agua</label>
                            <select name="agua_propia" id="agua_propia" class="input-entrada-texto">
                                <option value="nacimiento propio">Nacimiento propio</option>
                                <option value="algibe">Algibe</option>
                                <option value="reserva_acuifera_subterranea">Reserva acuífera subterránea</option>
                                <option value="no_aplica">No, pero de fácil acceso.</option>
                            </select>
                        </div>
                        <div class="box">
                            <label for="luz">Luz</label>
                            <select name="luz" id="luz" class="input-entrada-texto">
                                <option value="si">Sí</option>
                                <option value="no">No, pero de fácil acceso.</option>
                            </select>
                        </div>

                        <div class="box">
                            <label for="gas">Gas</label>
                            <select name="gas" id="gas" class="input-entrada-texto">
                                <option value="si">Sí</option>
                                <option value="no">No, pero de fácil acceso.</option>
                            </select>
                        </div>
                    </div>

                    <div class="fila">
                        <div class="box">
                            <label for="caracteristicas_positivas">Características Positivas</label>
                            <textarea name="caracteristicas_positivas" id="caracteristicas_positivas" cols="30" rows="5" class="input-entrada-texto" placeholder="Características positivas de la propiedad..." style="width: 660px; height: 150px; resize: none;"></textarea>
                        </div>

                        <div class="box">
                            <label for="internet">Internet</label>
                            <select name="internet" id="internet" class="input-entrada-texto">
                                <option value="si">Sí</option>
                                <option value="no">No, pero de fácil acceso.</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <h3><i class="fa-solid fa-cloud-sun-rain"></i> PROPIEDADES TÉCNICAS</h3>
                    <br>
                    <hr>
                    <div class="fila">
                        <div class="box">
                            <label for="construcciones_aledañas">Construcciones Aledañas</label>
                            <textarea name="construcciones_aledañas" id="" cols="30" rows="10" class="input-entrada-texto" placeholder="Construcciones aledañas a la propiedad..." style="width: 660px; height: 130px; resize: none;"></textarea>
                        </div>
                        <div class="box">
                        </div>
                        <div class="box">
                            <label for="altitud">Altitud</label>
                            <input type="text" name="altitud" class="input-entrada-texto" placeholder="Cantidad de M.S.N.M (ej: 2000)" required>
                            <br>
                            <br>
                            <label for="clima">Clima</label>
                            <select name="clima" id="" class="input-entrada-texto">
                                <option value="Cálido (24 °C a 30 °C)">Cálido (24 °C a 30 °C)</option>
                                <option value="Templado (16 °C a 24 °C)">Templado (16 °C a 24 °C)</option>
                                <option value="Frío (0 °C a 16 °C)">Frío (0 °C a 16 °C)</option>
                                <option value="Páramo (0 °C a 10 °C)">Páramo (0 °C a 10 °C)</option>
                                <option value="Tropical (25 °C a 35 °C)">Tropical (25 °C a 35 °C)</option>
                                <option value="Subpáramo (10 °C a 15 °C)">Subpáramo (10 °C a 15 °C)</option>
                                <option value="Tierra caliente (30 °C a 38 °C)">Tierra caliente (30 °C a 38 °C)</option>
                                <option value="Tierra fría (15 °C a 20 °C)">Tierra fría (15 °C a 20 °C)</option>
                                <option value="Clima seco">Clima seco</option>
                                <option value="Clima húmedo tropical">Clima húmedo tropical</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <h3><i class="fa-solid fa-file-lines"></i> DOCUMENTOS JURIDICO</h3>
                    <br>
                    <hr>
                    <div class="fila">
                        <div class="box">
                            <label for="documentos_transferencia">Documentos de trasferencia</label>
                            <input type="text" name="documentos_transferencia" class="input-entrada-texto" placeholder="Documentos solicitados..." required>
                        </div>
                        <div class="box">
                            <label for="permisos">Permisos</label>
                            <input type="text" name="permisos" class="input-entrada-texto" placeholder="Permisos de la propiedad..." required>
                        </div>
                        <div class="box">
                        </div>
                    </div>
                    <hr>
                    <h3><i class="fa-solid fa-street-view"></i> USOS DETALLADOS DE SUELOS</h3>
                    <br>
                    <hr>
                    <div class="fila">
                        <div class="box">
                            <label for="uso_principal">Uso principal</label>
                            <textarea type="text" name="uso_principal" class="input-entrada-texto" placeholder="Usos principales..." style="height: 100px; max-width: 100%; resize: none;" required></textarea>
                        </div>
                        <div class="box">
                            <label for="uso_compatibles">Usos compatibles</label>
                            <textarea type="text" name="uso_compatibles" class="input-entrada-texto" placeholder="Usos compatibles..." style="height: 100px; max-width: 100%; resize: none;" required></textarea>
                        </div>
                        <div class="box">
                            <label for="uso_condicionales">Usos condicionales</label>
                            <textarea type="text" name="uso_condicionales" class="input-entrada-texto" placeholder="Usos condicionales..." style="height: 100px; max-width: 100%; resize: none;" required></textarea>
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
        <!-- Las imágenes seleccionadas se mostrarán aquí con un botón de eliminación -->
    </div>

    <input type="file" id="fotos" accept="image/*" name="fotos[]" value="Foto" multiple="" required style="display:none">
</div>

                    <br>
                    <hr>
                    <h3><i class="fa-solid fa-video"></i> VIDEO y RECORRIDO 360º</h3>
                    <br>
                    <hr>
                    <div>
                        <label for="video_url">Video (Youtube.com)</label>
                        <input class="input-entrada-texto" type="text" name="video_url" id="video_url" placeholder="Ingrese enlace iframe de Yotube..." required>
                        <div id="videoPreview"></div> <!-- Contenedor para la vista previa -->
                    </div>
                    <br>
                    <br>
                    <div>
                        <label for="recorrido_360_url">Recorrido 360° (Webobook.com)</label>
                        <input class="input-entrada-texto" type="text" name="recorrido_360_url" id="recorrido_360_url" placeholder="Ingrese URL del recorrido 360..." required>
                        <div id="recorridoPreview"></div> <!-- Mantenemos la vista previa -->
                    </div>
                    <br>
                    <hr>
                    <br>


                    <h3><i class="fa-solid fa-money-check-dollar"></i> INFORMACIÓN FINANCIERA</h3>
                    <br>
                    <hr>
                    <div class="fila">
                        <div class="box">
                            <label for="precio">Precio</label>
                            <input type="text" name="precio" class="input-entrada-texto" placeholder="Precio de la propiedad (sin puntos)" required>
                        </div>
                        <div class="box">
                            <label for="permuta">¿Permuta disponible?</label>
                            <select name="permuta" id="permuta" class="input-entrada-texto" required>
                                <option value="1">Sí</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="box">
                            <label for="financiacion">¿Financiación disponible?</label>
                            <select name="financiacion" id="financiacion" class="input-entrada-texto" required>
                                <option value="1">Sí</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    </div>

                    <div class="fila">
                        <div class="box">
                            <label for="moneda">Moneda</label>
                            <select name="moneda" class="input-entrada-texto" required>
                                <option value="COP">COP</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <br>

                    <h3><i class="fa-solid fa-maximize"></i> PROPIEDADES ESPACIALES</h3>
                    <br>
                    <hr>
                    <div class="fila">
                        <div class="box">
                            <label for="salidas_bogota">Salidas de Bogotá</label>
                            <select name="salidas_bogota" id="salidas_bogota" class="input-entrada-texto" required>

                                <option value="Autopista Sur">Autopista Sur</option>
                                <option value="Autopista Calle 80">Autopista Calle 80</option>
                                <option value="Autopista Calle 13">Autopista Calle 13</option>
                                <option value="Autopista Via La Calera">Autopista Vía La Calera</option>
                                <option value="Autopista Norte">Autopista Norte</option>
                                <option value="Autopista Norte Calle 192">Autopista Norte (Calle 192)</option>
                                <option value="Autopista Sur Calle 13">Autopista Sur (Calle 13)</option>

                            </select>
                        </div>
                        <div class="box">
                            <label for="distancia_pueblo">Distancia al Pueblo</label>
                            <input type="number" name="distancia_pueblo" class="input-entrada-texto" placeholder="Distancia en Km. (sin puntos)" required>
                        </div>
                        <div class="box">
                            <label for="distancia_desde_bogota">Distancia desde Bogotá (km)</label>
                            <input type="number" name="distancia_desde_bogota" id="distancia_desde_bogota" class="input-entrada-texto" placeholder="Distancia en Km. (sin puntos)" required>
                        </div>
                    </div>

                    <div class="fila">
                        <div class="box">
                            <label for="vias_acceso">Vías de acceso</label>
                            <textarea name="vias_acceso" id="" cols="30" rows="10" class="input-entrada-texto" placeholder="Descripción de las vias de acceso relacionadas a la propiedad..." style="width: 660px; height: 150px; resize: none;"></textarea>
                        </div>
                        <div class="box">
                            <label for="nombre_propietario">Nombre Propietario</label>
                            <input type="text" name="nombre_propietario" class="input-entrada-texto" placeholder="nombre propietario" required>
                        </div>
                    </div>

                    <hr>
                    <br>

                    <input type="submit" value="Agregar Propiedad" name="agregar" class="btn-accion">

                </form>

                <style>

.foto-container {
    position: relative;
    display: inline-block;
    margin: 10px;
}

.foto-container img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 5px;
}

.btn-eliminar {
    position: absolute;
    top: 0;
    right: 0;
    background: red;
    color: white;
    border: none;
    padding: 5px;
    border-radius: 50%;
    cursor: pointer;
}

.btn-eliminar:hover {
    background: darkred;
}


                    .input-container {
                        margin-bottom: 20px;
                    }

                    textarea {
                        width: 100%;
                        height: 50px;
                        margin-bottom: 10px;
                    }
                </style>

                <script>
                    // Obtener referencias a los elementos
                    const iframeInput = document.getElementById('ubicacion_url');
                    const previewContainer = document.getElementById('previewContainer');
                    const errorContainer = document.getElementById('errorContainer');

                    // Evento para generar la vista previa automáticamente
                    iframeInput.addEventListener('input', () => {
                        const iframeCode = iframeInput.value.trim();

                        // Limpiar cualquier error previo
                        errorContainer.textContent = '';

                        // Imprimir el valor ingresado en la consola
                        console.log('Valor de ubicacion_url:', iframeCode);

                        // Validar que el código ingresado sea un iframe con un atributo 'src'
                        const srcMatch = iframeCode.match(/<iframe[^>]*src=["']([^"']+)["'][^>]*>/);

                        if (srcMatch && srcMatch[1]) {
                            const iframeSrc = srcMatch[1]; // Aquí está el valor de src

                            // Inyectar un nuevo iframe con el src extraído
                            previewContainer.innerHTML = `<iframe src="${iframeSrc}" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>`;
                        } else {
                            previewContainer.innerHTML = ''; // Limpiar la vista previa
                            errorContainer.textContent = 'El código ingresado no contiene un iframe válido o no tiene el atributo "src".';
                        }
                    });

// Variable para almacenar las fotos seleccionadas
let fotosSeleccionadas = [];

document.getElementById('fotos').addEventListener('change', function(e) {
    // Obtener los archivos seleccionados
    const archivos = e.target.files;

    // Mostrar las imágenes en el contenedor
    const contenedorFotos = document.getElementById('contenedor-fotos-publicacion');
    
    // Limpiar contenedor de fotos previas
    contenedorFotos.innerHTML = '';

    // Iterar sobre las fotos seleccionadas y mostrarlas en el DOM
    for (let i = 0; i < archivos.length; i++) {
        const archivo = archivos[i];
        
        // Crear un contenedor para cada foto con un botón de eliminación
        const divFoto = document.createElement('div');
        divFoto.classList.add('foto-container');

        const img = document.createElement('img');
        img.src = URL.createObjectURL(archivo); // Mostrar la imagen

        const btnEliminar = document.createElement('button');
        btnEliminar.innerHTML = 'X';
        btnEliminar.classList.add('btn-eliminar');
        btnEliminar.addEventListener('click', function() {
            // Eliminar la foto seleccionada
            divFoto.remove();
            fotosSeleccionadas = fotosSeleccionadas.filter(f => f !== archivo);
        });

        divFoto.appendChild(img);
        divFoto.appendChild(btnEliminar);
        contenedorFotos.appendChild(divFoto);

        // Almacenar las fotos seleccionadas en el array para enviar al servidor
        fotosSeleccionadas.push(archivo);
    }
});


                </script>




                <?php if (isset($_POST['agregar'])) : ?>
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: '¡Propiedad Agregada!',
                            text: '<?php echo $mensaje; ?>',
                            showConfirmButton: false,
                            timer: 3000
                        }).then(function() {
                            window.location.href = 'listado-propiedades.php';
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
    <!-- scripts para procesar galerias (video,imagens, recorrido360) prpiedad -->
    <script src="../subirfoto.js"></script>
    <script src="../scriptFotos.js"></script>
    <script src="../subir_v_r.js"></script>
    <script src="../vista_recorrido_video.js"></script>
    <!-- **NOTA:** pendiente script de alerta SW2 (eliminar - agregar) -->
</body>

</html>