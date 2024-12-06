<?php
session_start();

if (!$_SESSION['usuarioLogeado']) {
    header("Location:login.php");
}

function obtenerPropiedadPorId($id_propiedad)
{
    include("../conexion.php");

    $query = "SELECT * FROM propiedades WHERE id='$id_propiedad'";

    $resultado_propiedad = mysqli_query($conn, $query);
    $propiedad = mysqli_fetch_assoc($resultado_propiedad);
    return $propiedad;
}
$id_propiedad = $_GET['id'];
$propiedad = obtenerPropiedadPorId($id_propiedad);

/************************************************************* */

function obtenerFotosGaleriaDePropiedad($id_propiedad)
{
    include("../conexion.php");

    $query = "SELECT * FROM fotos WHERE id_propiedad='$id_propiedad'";

    $galeria = mysqli_query($conn, $query);
    return $galeria;
}

include("../conexion.php");

$query = "SELECT * FROM tipos";

$resultado_tipos = mysqli_query($conn, $query);

include("../conexion.php");

$query = "SELECT * FROM departamentos";

$resultado_departamentos = mysqli_query($conn, $query);

include("../conexion.php");

$query = "SELECT * FROM ciudades WHERE id_departamento='$propiedad[departamento]'";

$resultado_ciudades = mysqli_query($conn, $query);

if (isset($_POST['actualizar'])) {

    include("../conexion.php");

    $id_propiedad = $_POST['id'];
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $tipo = $_POST['tipo'];
    $estado = $_POST['estado'];
    $ubicacion = $_POST['ubicacion'];
    $habitaciones = $_POST['habitaciones'];
    $banios = $_POST['banios'];
    $pisos = $_POST['pisos'];
    $garage = $_POST['garage'];
    $dimensiones = $_POST['dimensiones'];
    $precio = $_POST['precio'];
    $moneda = $_POST['moneda'];
    $url_galeria = "url";
    $departamento = $_POST['departamento'];
    $ciudad = $_POST['ciudad'];
    $agua = $_POST['agua'];
    $luz = $_POST['luz'];
    $gas = $_POST['gas'];
    $internet = $_POST['internet'];
    $clima = $_POST['clima'];
    $documentos_transferencia = $_POST['documentos_transferencia'];
    $permuta = $_POST['permuta'];
    $video_url = $_POST['video_url'];
    $recorrido_360_url = $_POST['recorrido_360_url'];
    $ubicacion_url = $_POST['ubicacion_url'];
    $dimension_tipo = $_POST['dimensiones_tipo'];


    $query = "UPDATE propiedades SET
     id='$id', 
     titulo='$titulo', 
     descripcion='$descripcion', 
     tipo='$tipo', 
     estado='$estado', 
     ubicacion='$ubicacion', 
     habitaciones='$habitaciones', 
     banios='$banios', 
     pisos='$pisos', 
     garage='$garage', 
     dimensiones='$dimensiones', 
     precio='$precio',
     moneda='$moneda', 
     departamento='$departamento',
     ciudad='$ciudad',
     agua='$agua',
     luz='$luz',
     gas='$gas',
     internet='$internet',
     clima='$clima',
     documentos_transferencia='$documentos_transferencia',
     permuta='$permuta',
     video_url='$video_url',
     recorrido_360_url='$recorrido_360_url',
     ubicacion_url='$ubicacion_url',
     dimensiones_tipo='$dimensiones_tipo'

     WHERE id='$id_propiedad'";

    if (mysqli_query($conn, $query)) {

        if ($_POST['fotoPrincipalActualizada'] == "si") {
            include("actualizar-foto-principal.php");
        }

        if ($_POST['fotosGaleriaActualizada'] == "si") {
            $id_ultima_propiedad = $id_propiedad;
            include("procesar-fotos-galeria.php");
        }

        $idsFotos =  $_POST['fotosAEliminar'];
        if ($idsFotos != "") {
            include("eliminar-fotos-de-galeria.php");
        }

        $mensaje = "La propiedad se actualizó correctamente";
    } else {
        $mensaje = "No se pudo insertar en la BD" . mysqli_error($conn);
    }
}


/******************************************************* */


?>


<!DOCTYPE html>

<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FRSC- ADMIN</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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

            <div id="actualizar-propiedad">
                <h2>Actualizar propiedad</h2>
                <hr>
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data" method="post">
                    <input type="hidden" name="id" value="<?php echo $propiedad['id'] ?>">
                    <div class="fila-una-columna">
                        <label for="titulo">Título de la Propiedad</label>
                        <input type="text" name="titulo" value="<?php echo $propiedad['titulo'] ?>" required class="input-entrada-texto">
                    </div>

                    <div class="fila-una-columna">
                        <label for="descripcion">Descripción de la Propiedad</label>
                        <textarea name="descripcion" id="" cols="30" rows="10" class="input-entrada-texto" style="resize: none;"><?php echo $propiedad['descripcion'] ?></textarea>
                    </div>

                    <br>
                    <br>
                    <h2>Datos basicos de la propiedad</h2>
                    <hr>

                    <div class="fila">

                        <div class="box">
                            <label for="tipo">Seleccione tipo de propiedad</label>
                            <select name="tipo" id="" class="input-entrada-texto">
                                <?php while ($row = mysqli_fetch_assoc($resultado_tipos)) : ?>
                                    <?php if ($row['id'] == $propiedad['tipo']) : ?>
                                        <option value="<?php echo $row['id'] ?>" selected>
                                            <?php echo $row['nombre_tipo'] ?>
                                        </option>
                                    <?php else : ?>
                                        <option value="<?php echo $row['id'] ?>">
                                            <?php echo $row['nombre_tipo'] ?>
                                        </option>
                                    <?php endif ?>
                                <?php endwhile ?>
                            </select>
                        </div>


                        <div class="box">
                            <label for="estado">Elija estado de la propiedad</label>
                            <select name="estado" id="" class="input-entrada-texto">
                                <option value="venta" <?php if ($propiedad['estado'] == "Venta") {
                                                            echo "selected";
                                                        } ?>>Venta</option>
                                <option value="Alquiler" <?php if ($propiedad['estado'] == "Alquiler") {
                                                                echo "selected";
                                                            } ?>>Proyecto</option>
                            </select>
                        </div>

                        <div class="box">
                            <label for="ubicacion">Direcciòn</label>
                            <input type="text" name="ubicacion" value="<?php echo $propiedad['ubicacion'] ?>" class="input-entrada-texto">
                        </div>
                    </div>


                    <div class="fila">
                        <div class="box">
                            <label for="habitaciones">Habitaciones</label>
                            <input type="text" name="habitaciones" value="<?php echo $propiedad['habitaciones'] ?>" class="input-entrada-texto">
                        </div>

                        <div class="box">
                            <label for="baños">Baños</label>
                            <input type="text" name="banios" value="<?php echo $propiedad['banios'] ?>" class="input-entrada-texto">
                        </div>

                        <div class="box">
                            <label for="pisos">Pisos</label>
                            <input type="text" name="pisos" value="<?php echo $propiedad['pisos'] ?>" class="input-entrada-texto">
                        </div>

                    </div>


                    <div class="fila">
                        <div class="box">
                            <label for="garage">Garage</label>
                            <select name="garage" id="" class="input-entrada-texto">
                                <option value="No" <?php if ($propiedad['garage'] == "No") {
                                                        echo "selected";
                                                    } ?>>No</option>
                                <option value="Si" <?php if ($propiedad['garage'] == "Si") {
                                                        echo "selected";
                                                    } ?>>Si</option>
                            </select>
                        </div>

                        <div class="box">
                            <label for="dimensiones">Area</label>
                            <input type="text" name="dimensiones" value="<?php echo $propiedad['dimensiones'] ?>" class="input-entrada-texto">
                        </div>

                        <div class="box">
                            <label for="dimensiones_tipo">Medida del area</label>
                            <select name="dimensiones_tipo" id="" class="input-entrada-texto">
                                <option value="Mts²" <?php if ($propiedad['dimensiones_tipo'] == "Mts²") {
                                                        echo "selected";
                                                    } ?>>Mts²</option>
                                <option value="Fanegadas" <?php if ($propiedad['dimensiones_tipo'] == "Fanegadas") {
                                                        echo "selected";
                                                    } ?>>Fanegadas</option>
                                <option value="Hectareas" <?php if ($propiedad['dimensiones_tipo'] == "Hectareas") {
                                                        echo "selected";
                                                    } ?>>Hectareas</option>
                            </select>
                        </div>
                    </div>

                    <div class="fila">
                        <div class="box">
                            <label for="precio">Precio (Alquiler o Venta)</label>
                            <input type="text" name="precio" value="<?php echo $propiedad['precio'] ?>" class="input-entrada-texto">
                        </div>

                        <div class="box">
                            <label for="moneda">Moneda</label>
                            <input type="text" name="moneda" class="input-entrada-texto" required value="<?php echo $propiedad['moneda'] ?>">
                        </div>
                        <div class="box">
                            <label for="ubicacion_url">Url ubicación</label>
                            <input type="text" name="ubicacion_url" class="input-entrada-texto" required
                                value="<?php echo htmlspecialchars(isset($_POST['ubicacion_url']) ? $_POST['ubicacion_url'] : $propiedad['ubicacion_url']); ?>">
                        </div>
                    </div>

                    <br>
                    <br>
                    <h2>Servicios del predio</h2>
                    <hr>

                    <div class="fila">
                        <div class="box">
                            <label for="internet">Internet</label>
                            <select name="internet" id="" class="input-entrada-texto">
                                <option value="No" <?php if ($propiedad['internet'] == "No") {
                                                        echo "selected";
                                                    } ?>>No</option>
                                <option value="Si" <?php if ($propiedad['internet'] == "Si") {
                                                        echo "selected";
                                                    } ?>>Si</option>
                            </select>
                        </div>

                        <div class="box">
                            <label for="agua">Agua</label>
                            <select name="agua" id="" class="input-entrada-texto">
                                <option value="No" <?php if ($propiedad['agua'] == "No") {
                                                        echo "selected";
                                                    } ?>>No</option>
                                <option value="Si" <?php if ($propiedad['agua'] == "Si") {
                                                        echo "selected";
                                                    } ?>>Si</option>
                            </select>
                        </div>

                        <div class="box">
                            <label for="gas">Gas</label>
                            <select name="gas" id="" class="input-entrada-texto">
                                <option value="No" <?php if ($propiedad['gas'] == "No") {
                                                        echo "selected";
                                                    } ?>>No</option>
                                <option value="Si" <?php if ($propiedad['gas'] == "Si") {
                                                        echo "selected";
                                                    } ?>>Si</option>
                            </select>
                        </div>
                    </div>
                    <div class="fila">

                        <div class="box">
                            <label for="luz">Luz</label>
                            <select name="luz" id="" class="input-entrada-texto">
                                <option value="No" <?php if ($propiedad['luz'] == "No") {
                                                        echo "selected";
                                                    } ?>>No</option>
                                <option value="Si" <?php if ($propiedad['luz'] == "Si") {
                                                        echo "selected";
                                                    } ?>>Si</option>
                            </select>
                        </div>

                        <div class="box">
                            <label for="clima">Clima</label>
                            <select name="clima" id="clima" class="input-entrada-texto">
                                <option value="Cálido (24 °C a 30 °C)" <?php if ($propiedad['clima'] == "Cálido") {
                                                                            echo "selected";
                                                                        } ?>>Cálido (24 °C a 30 °C)</option>
                                <option value="Templado (16 °C a 24 °C)" <?php if ($propiedad['clima'] == "Templado") {
                                                                                echo "selected";
                                                                            } ?>>Templado (16 °C a 24 °C)</option>
                                <option value="Frío (0 °C a 16 °C)" <?php if ($propiedad['clima'] == "Frío") {
                                                                        echo "selected";
                                                                    } ?>>Frío (0 °C a 16 °C)</option>
                                <option value="Páramo (0 °C a 10 °C)" <?php if ($propiedad['clima'] == "Páramo") {
                                                                            echo "selected";
                                                                        } ?>>Páramo (0 °C a 10 °C)</option>
                                <option value="Tropical (25 °C a 35 °C)" <?php if ($propiedad['clima'] == "Tropical") {
                                                                                echo "selected";
                                                                            } ?>>Tropical (25 °C a 35 °C)</option>
                            </select>
                        </div>


                        <div class="box">
                            <label for="documentos_transferencia">Documentos de transferencia</label>
                            <select name="documentos_transferencia" id="documentos_transferencia" class="input-entrada-texto">
                                <option value="Escritura pública" <?php if ($propiedad['documentos_transferencia'] == "Escritura pública") {
                                                                        echo "selected";
                                                                    } ?>>Escritura pública</option>
                                <option value="Promesa de compraventa" <?php if ($propiedad['documentos_transferencia'] == "Promesa de compraventa") {
                                                                            echo "selected";
                                                                        } ?>>Promesa de compraventa</option>
                                <option value="Certificado de libertad y tradición" <?php if ($propiedad['documentos_transferencia'] == "Certificado de libertad y tradición") {
                                                                                        echo "selected";
                                                                                    } ?>>Certificado de libertad y tradición</option>
                                <option value="Recibo de pago de impuestos" <?php if ($propiedad['documentos_transferencia'] == "Recibo de pago de impuestos") {
                                                                                echo "selected";
                                                                            } ?>>Recibo de pago de impuestos</option>
                                <option value="Documento de identidad" <?php if ($propiedad['documentos_transferencia'] == "Documento de identidad") {
                                                                            echo "selected";
                                                                        } ?>>Documento de identidad</option>
                                <option value="Autorizaciones" <?php if ($propiedad['documentos_transferencia'] == "Autorizaciones") {
                                                                    echo "selected";
                                                                } ?>>Autorizaciones</option>
                                <option value="Declaración de impuestos de ganancia ocasional" <?php if ($propiedad['documentos_transferencia'] == "Declaración de impuestos de ganancia ocasional") {
                                                                                                    echo "selected";
                                                                                                } ?>>Declaración de impuestos de ganancia ocasional</option>
                            </select>
                        </div>

                    </div>



                    <br>
                    <br>
                    <h2>Galería de fotos</h2>
                    <hr>

                    <div class="">

                        <p>Foto principal (<label for="foto1" class="btn-cambiar-foto">Cambiar foto</label>)</p>
                        <output id="list" class="contenedor-foto-principal">
                            <img src="<?php echo $propiedad['url_foto_principal'] ?>" alt="">
                        </output>

                        <input type="file" id="foto1" accept="image/*" name="foto1" style="display:none">
                        <input type="hidden" id="fotoPrincipalActualizada" name="fotoPrincipalActualizada">
                    </div>

                    <div>
                        <p>Galería ( <label for="fotos" class="btn-cambiar-foto">Agregar mas Fotos</label>)</p>
                        <input type="hidden" id="fotosAEliminar" name="fotosAEliminar">
                        <div id="contenedor-fotos-publicacion">
                            <?php
                            $galeria = obtenerFotosGaleriaDePropiedad($propiedad['id']);
                            $i = 1; ?>
                            <?php while ($foto = mysqli_fetch_assoc($galeria)) : ?>
                                <output class="contenedor-foto-galeria" id="<?php echo $i ?>">
                                <img src="fotos/<?php echo $propiedad['id'] . "/" . $foto['nombre_foto'] ?>" class="foto-galeria">

                                    <span id="btn-eliminar-galeria" id="<?php echo $foto['id'] ?>" onclick="eliminarFoto(<?php echo $foto['id'] ?>, <?php echo $i ?>)"> Eliminar</i></span>
                                </output>
                            <?php
                                $i++;
                            endwhile
                            ?>
                        </div>

                        <div id="contenedor-fotos-nuevas">

                        </div>

                        <input type="file" id="fotos" accept="image/*" name="fotos[]" value="Foto" multiple="" style="display:none">
                        <input type="hidden" id="fotosGaleriaActualizada" name="fotosGaleriaActualizada">

                    </div>

                    <br>
                    <br>
                    <h2>Video y Recorrido 360º</h2>
                    <hr>
                    <div class="form-group">
                        <label for="video_url">Video del predio</label>
                        <input
                            class="input-entrada-texto"
                            type="text"
                            name="video_url"
                            id="video_url"
                            value="<?php echo htmlspecialchars($propiedad['video_url']); ?>"
                            placeholder="Ingrese URL del video de YouTube"
                            required>
                        <div id="videoPreview"></div>
                    </div>

                    <br>
                    <br>
                    <div class="form-group">
                        <label for="recorrido_360_url">Recorrido 360º</label>
                        <input
                            class="input-entrada-texto"
                            type="text"
                            name="recorrido_360_url"
                            id="recorrido_360_url"
                            value="<?php echo htmlspecialchars($propiedad['recorrido_360_url']); ?>"
                            placeholder="Ingrese URL del recorrido 360º"
                            required>
                        <div id="videoPreview"></div>
                    </div>


                    <br>
                    <br>
                    <h2>Ubicación y datos del Propietario</h2>
                    <hr>
                    <div class="fila">
                        <div class="box">
                            <label for="departamento"> Seleccione país de la Propiedad</label>
                            <select name="departamento" id="" onchange="muestraselect(this.value)" class="input-entrada-texto">
                                <?php while ($row = mysqli_fetch_assoc($resultado_departamentos)) : ?>
                                    <?php if ($row['id'] == $propiedad['departamento']) : ?>
                                        <option value="<?php echo $row['id'] ?>" selected>
                                            <?php echo $row['nombre_departamento'] ?>
                                        </option>
                                    <?php else : ?>
                                        <option value="<?php echo $row['id'] ?>">
                                            <?php echo $row['nombre_departamento'] ?>
                                        </option>
                                    <?php endif ?>
                                <?php endwhile ?>
                            </select>
                        </div>

                        <div class="box">
                            <label for="ciudad">Seleccione ciudad</label>
                            <select name="ciudad" id="ciudad" class="input-entrada-texto">
                                <?php while ($row = mysqli_fetch_assoc($resultado_ciudades)) : ?>
                                    <?php if ($row['id'] == $propiedad['ciudad']) : ?>
                                        <option value="<?php echo $row['id'] ?>" selected>
                                            <?php echo $row['nombre_ciudad'] ?>
                                        </option>
                                    <?php else : ?>
                                        <option value="<?php echo $row['id'] ?>">
                                            <?php echo $row['nombre_ciudad'] ?>
                                        </option>
                                    <?php endif ?>
                                <?php endwhile ?>
                            </select>
                        </div>

                    </div>
                    <div class="fila">
                        
                        <div class="box">
                            <label for="permuta">¿Permuta?</label>
                            <select name="permuta" id="" class="input-entrada-texto">
                                <option value="No" <?php if ($propiedad['permuta'] == "No") {
                                                        echo "selected";
                                                    } ?>>No</option>
                                <option value="Si" <?php if ($propiedad['permuta'] == "Si") {
                                                        echo "selected";
                                                    } ?>>Si</option>
                            </select>
                        </div>
                    </div>


                    <input type="submit" value="Actualizar Datos" name="actualizar" class="btn-accion">

                </form>

                <?php if (isset($estado)) : ?>
                    <script>
                        Swal.fire({
                            icon: '<?php echo $estado; ?>',
                            title: '<?php echo $estado == 'success' ? "¡Éxito!" : "¡Error!"; ?>',
                            text: '<?php echo $mensaje; ?>',
                            showConfirmButton: false,
                            timer: 2500
                        }).then(() => {
                            <?php if ($estado == 'success') : ?>
                                window.location.href = 'listado-propiedades.php';
                            <?php endif; ?>
                        });
                    </script>
                <?php endif ?>

            </div>
        </div>

    </div>


    <?php if (isset($_POST['actualizar'])) : ?>

        <script>
            alert("<?php echo $mensaje ?>");
            window.location.href = 'listado-propiedades.php';
        </script>

    <?php endif ?>

    <script src="../script.js"></script>
    <script src="../subirFoto.js"></script>
    <script src="../vista_recorrido_video.js"></script>
</body>

</html>