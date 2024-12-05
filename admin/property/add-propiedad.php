<?php
include("../conexion.php");


$query = "SELECT * FROM tipos";
$resultado_tipos = mysqli_query($conn, $query);

$query = "SELECT * FROM departamentos";

$resultado_departamentos = mysqli_query($conn, $query);



// Guardamos propiedad
if (isset($_POST['agregar'])) {
    include("../conexion.php");


    $id = isset($_POST['id']) ? $_POST['id'] : '';  // Valor por defecto vacío si no está definido
    $fecha_publicacion = $_POST['fecha_alta']; 
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $tipo = $_POST['tipo'];
    $ubicacion = $_POST['ubicacion'];
    $habitaciones = $_POST['habitaciones'];
    $banios = $_POST['banios'];
    $pisos = $_POST['pisos'];
    $garage = $_POST['garage'];
    $dimensiones = $_POST['dimensiones'];
    $dimensiones_tipo = $_POST['dimensiones_tipo']; /*  */
    $area = $_POST['area'];
    $altitud = $_POST['altitud'];
    $distancia_pueblo = $_POST['distancia_pueblo'];
    $vias_acceso = $_POST['vias_acceso'];
    $clima = $_POST['clima'];
    $precio = $_POST['precio'];
    $moneda = $_POST['moneda'];
    $url_foto_principal = "url";/*  */
    $recorrido_360_url = $_POST['recorrido_360_url'];
    $ubicacion_url = $_POST['ubicacion_url'];
    $documentos_transferencia = $_POST['documentos_transferencia'];
    $permisos = $_POST['permisos'];
    $uso_principal = $_POST['uso_principal'];
    $uso_compatibles = $_POST['uso_compatibles'];
    $uso_condicionales = $_POST['uso_condicionales'];
    $departamento = $_POST['departamento'];
    $ciudad = $_POST['ciudad'];
    $agua = isset($_POST['agua']) ? $_POST['agua'] : 0;
    $internet = isset($_POST['internet']) ? $_POST['internet'] : 0;
    $permuta = isset($_POST['permuta']) ? $_POST['permuta'] : 0;
    $gas = isset($_POST['gas']) ? $_POST['gas'] : 0;
    $luz = isset($_POST['luz']) ? $_POST['luz'] : 0; 
    $video_url = $_POST['video_url'];
   
    $estado = $_POST['estado'];
    


  

    // Armamos el query para insertar en la tabla propiedades
$query = "INSERT INTO propiedades (id, fecha_alta, titulo, descripcion, tipo, estado, ubicacion, habitaciones, banios, pisos, garage, dimensiones, dimensiones_tipo, area, altitud, distancia_pueblo, vias_acceso, clima, precio, moneda, url_foto_principal, video_url, recorrido_360_url, ubicacion_url, documentos_transferencia, permisos, uso_principal, uso_compatibles, uso_condicionales, departamento, ciudad, agua, luz, gas, internet, permuta)
VALUES ('$id', CURRENT_TIMESTAMP, '$titulo', '$descripcion', '$tipo', '$estado', '$ubicacion', '$habitaciones', '$banios', '$pisos', '$garage', '$dimensiones', '$dimensiones_tipo', '$area', '$altitud', '$distancia_pueblo', '$vias_acceso', '$clima', '$precio', '$moneda', '', '$video_url', '$recorrido_360_url', '$ubicacion_url', '$documentos_transferencia', '$permisos', '$uso_principal', '$uso_compatibles', '$uso_condicionales', '$departamento', '$ciudad', '$agua', '$luz', '$gas', '$internet', '$permuta')";


    
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
    <?php include("../header.php"); ?>

    <div id="contenedor-admin">
        <?php include("../contenedor-menu.php"); ?>

        <div class="contenedor-principal">
            <div id="nueva-propiedad">
                <h2>Nueva propiedad</h2>
                <br>
                <hr>
                <br>
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">

                <input type="hidden" name="fecha_alta" id="fecha_alta">
                    <script>
                        window.onload = function() {
                            const fechaActual = new Date();
                            const formatoISO = fechaActual.toISOString().slice(0, 19).replace('T', ' '); // Formato: YYYY-MM-DD HH:MM:SS
                            document.getElementById('fecha_alta').value = formatoISO;
                        };
                        console.log(fecha_alta)
                    </script>   


                    <div class="fila-una-columna">
                        <label for="titulo">Título de la Propiedad</label>
                        <input type="text" name="titulo" required class="input-entrada-texto" placeholder="Nombre de la propiedad...">
                    </div>

                    <div class="fila-una-colummna">
                        <label for="descripcion">Descripción de la Propiedad</label>
                        <textarea name="descripcion" id="" cols="30" rows="10" class="input-entrada-texto" placeholder="Descripcion detallada de la propiedad..." style="resize: none;"></textarea>
                    </div>

                    <div class="fila">
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
                    </div>

                    <div class="fila-una-columna">
                        <label for="estado">Estado de la propiedad</label>
                        <input type="text" name="estado" class="input-entrada-texto" placeholder="Estado" required>
                        
                    </div>

                    <div class="fila-una-columna">
                        <label for="ubicacion">Dirección</label>
                        <input type="text" name="ubicacion" class="input-entrada-texto" placeholder="Ubicación de la propiedad" required>
                    </div>

                    <!-- Información de la propiedad -->
                    <div class="fila">
                        <div class="box">
                            <label for="habitaciones">Habitaciones</label>
                            <input type="number" name="habitaciones" class="input-entrada-texto" placeholder="Número de habitaciones" required>
                        </div>

                        <div class="box">
                            <label for="banios">Baños</label>
                            <input type="number" name="banios" class="input-entrada-texto" placeholder="Número de baños" required>
                        </div>

                        <div class="box">
                            <label for="pisos">Pisos</label>
                            <input type="number" name="pisos" class="input-entrada-texto" placeholder="Número de pisos" required>
                        </div>
                    </div>

                    <div class="fila">
                        <div class="box">
                            <label for="garage">Garaje</label>
                            <input type="number" name="garage" class="input-entrada-texto" placeholder="Número de garages" required>
                        </div>

                        <div class="box">
                            <label for="dimensiones">Dimensiones (m²)</label>
                            <input type="text" name="dimensiones" class="input-entrada-texto" placeholder="Dimensiones" required>
                        </div>

                        <br>
                        <br>
                        <br>

                        <div class="fila">
                            <div class="box">
                                <label for="dimensiones_tipo">Tipo de Medidas</label>
                                <select name="dimensiones_tipo" id="dimensiones_tipo" class="input-entrada-texto" required>
                                    <option value="">Seleccione un tipo</option>
                                    <option value="m²">Metros cuadrados (m²)</option>
                                    <option value="hectáreas">Hectáreas</option>
                                    <option value="acres">Acres</option>
                                    <option value="pies²">Pies cuadrados (ft²)</option>
                                </select>
                            </div>
                        </div>

                        <div class="box">
                            <label for="area">Área en metros cuadrados</label>
                            <input type="text" name="area" class="input-entrada-texto" placeholder="Área" required>
                        </div>


                        <div class="box">
                            <label for="precio">Precio</label>
                            <input type="text" name="precio" class="input-entrada-texto" placeholder="Precio de la propiedad" required>
                        </div>
                    </div>

                    <div class="fila">
                        <div class="box">
                            <label for="moneda">Moneda</label>
                            <select name="moneda" class="input-entrada-texto" required>
                                <option value="COP">COP</option>
                                <option value="USD">USD</option>
                            </select>
                        </div>

                        <div class="fila">
                                            <div class="box">
                                                <label for="departamento">Seleccione Depart. de la Propiedad</label>
                                                <select name="departamento" id="" onchange="muestraselect(this.value)" class="input-entrada-texto">
                                                    <option value="">Seleccione departamento</option>
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
                                        </div>

                    </div>

                    <!-- Servicios -->
                    <div class="fila">
                        <div class="box">
                            <label for="agua">Agua</label>
                            <input type="checkbox" name="agua" value="1">
                        </div>

                        <div class="box">
                            <label for="luz">Luz</label>
                            <input type="checkbox" name="luz" value="1">
                        </div>

                        <div class="box">
                            <label for="gas">Gas</label>
                            <input type="checkbox" name="gas" value="1">
                        </div>

                        <div class="box">
                            <label for="internet">Internet</label>
                            <input type="checkbox" name="internet" value="1">
                        </div>
                    </div>

                    <!-- Nuevos campos -->
                    <div class="fila">

                        <div class="box">
                            <label for="altitud">Altitud</label>
                            <input type="text" name="altitud" class="input-entrada-texto" placeholder="Altitud" required>
                        </div>

                        <div class="box">
                            <label for="distancia_pueblo">Distancia al Pueblo</label>
                            <input type="text" name="distancia_pueblo" class="input-entrada-texto" placeholder="Distancia en km" required>
                        </div>
                    </div>

                    <div class="fila">
                        <div class="box">
                            <label for="vias_acceso">Vías de acceso</label>
                            <input type="text" name="vias_acceso" class="input-entrada-texto" placeholder="Vías de acceso" required>
                        </div>

                        <div class="box">
                            <label for="clima">Clima</label>
                            <input type="text" name="clima" class="input-entrada-texto" placeholder="clima" required>
                        </div>

                        <div class="box">
                            <label for="documentos_transferencia">Documentos de trasferencia</label>
                            <input type="text" name="documentos_transferencia" class="input-entrada-texto" placeholder="documentos_transferencia" required>
                        </div>

                        <div class="box">
                            <label for="permisos">Permisos</label>
                            <input type="text" name="permisos" class="input-entrada-texto" placeholder="Permisos de construcción" required>
                        </div>

                        <div class="box">
                            <label for="uso_principal">Uso principal</label>
                            <input type="text" name="uso_principal" class="input-entrada-texto" placeholder="Uso principal" required>
                        </div>
                    </div>

                    <div class="fila">
                        <div class="box">
                            <label for="uso_compatibles">Usos compatibles</label>
                            <input type="text" name="uso_compatibles" class="input-entrada-texto" placeholder="Usos compatibles" required>
                        </div>

                        <div class="box">
                            <label for="uso_condicionales">Usos condicionales</label>
                            <input type="text" name="uso_condicionales" class="input-entrada-texto" placeholder="Usos condicionales" required>
                        </div>
                    </div>

                    <label for="foto1" class="btn-fotos">Foto Principal</label>
                        <output id="list" class="contenedor-foto-principal">
                            <img src="<?php echo $propiedad['url_foto_principal'] ?>" alt="">
                        </output>
                        <input type="file" id="foto1" accept="image/*" name="foto1" style="display:none">
                    </div>

                    
                    <
                        <label for="fotos" class="btn-fotos"> Galería de Fotos </label>

                        <div id="contenedor-fotos-publicacion">

                        </div>


                        <input type="file" id="fotos" accept="image/*" name="fotos[]" value="Foto" multiple="" required style="display:none">
                    <

                    <div class="fila">
                        <div class="box">
                            <label for="video_url">URL del Video</label>
                            <input type="text" name="video_url" class="input-entrada-texto" placeholder="URL del video" required>
                        </div>

                                                        
                        <div class="ubicacion_url">
                            <label for="ubicacion_url">URL del Video</label>
                            <input type="text" name="ubicacion_url" class="input-entrada-texto" placeholder="URL de la ubicacaion" required>
                        </div>


                        <div class="box">
                            <label for="recorrido_360_url">URL del Recorrido 360</label>
                            <input type="text" name="recorrido_360_url" class="input-entrada-texto" placeholder="URL del recorrido 360" required>
                        </div>
                    </div>


                    <br><br>

                    <input type="submit" value="Agregar Propiedad" name="agregar" class="btn-accion">                
            </form>

                <?php if (isset($_POST['agregar'])) : ?>
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: '¡Propiedad Agregada!',
                            text: '<?php echo $mensaje; ?>',
                            showConfirmButton: false,
                            timer: 3000
                        }).then(function() {
                            /* window.location.href = 'listado-propiedades.php'; */
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
