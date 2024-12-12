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
    $ubicacion_url = $_POST['ubicacion_url'];
    $documentos_transferencia = $_POST['documentos_transferencia'];
    $permisos = isset($_POST['permisos']) ? $_POST['permisos'] : null;
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
    $agua_propia = isset($_POST['agua_propia']) ? $_POST['agua_propia'] : null;
    $construcciones_aledañas = $_POST['construcciones_aledañas'];
    $inventario = $_POST['inventario'];
    $nombre_propietario = $_POST['nombre_propietario'];

    $query = "UPDATE propiedades SET 
        titulo = '$titulo',
        descripcion = '$descripcion',
        tipo = '$tipo',
        estado = '$estado',
        ubicacion = '$ubicacion',
        habitaciones = '$habitaciones',
        banios = '$banios',
        pisos = '$pisos',
        garage = '$garage',
        dimensiones = '$dimensiones',
        dimensiones_tipo = '$dimensiones_tipo',
        area = '$area',
        altitud = '$altitud',
        distancia_pueblo = '$distancia_pueblo',
        vias_acceso = '$vias_acceso',
        clima = '$clima',
        precio = '$precio',
        moneda = '$moneda',
        url_foto_principal = '$url_foto_principal',
        video_url = '$video_url',
        recorrido_360_url = '$recorrido_360_url',
        ubicacion_url = '$ubicacion_url',
        documentos_transferencia = '$documentos_transferencia',
        permisos = '$permisos',
        uso_principal = '$uso_principal',
        uso_compatibles = '$uso_compatibles',
        uso_condicionales = '$uso_condicionales',
        departamento = '$departamento',
        ciudad = '$ciudad',
        luz = '$luz',
        gas = '$gas',
        internet = '$internet',
        permuta = '$permuta',
        caracteristicas_positivas = '$caracteristicas_positivas',
        distancia_desde_bogota = '$distancia_desde_bogota',
        financiacion = '$financiacion',
        salidas_bogota = '$salidas_bogota',
        agua_propia = '$agua_propia',
        construcciones_aledañas = '$construcciones_aledañas',
        inventario = '$inventario',
        nombre_propietario = '$nombre_propietario'
        WHERE id = '$id_propiedad'";

    
    if (mysqli_query($conn, $query)) {

        if ($_POST['fotoPrincipalActualizada'] == "si") {
            include("../actualizar-foto-principal.php");
        }

        if ($_POST['fotosGaleriaActualizada'] == "si") {
            $id_ultima_propiedad = $id_propiedad;
            include("../procesar-fotos-galeria.php");
        }

        $idsFotos =  $_POST['fotosAEliminar'];
        if ($idsFotos != "") {
            include("../eliminar-fotos-de-galeria.php");
        }

        $mensaje = "La propiedad se actualizó correctamente";
    } else {
        $mensaje = "No se pudo insertar en la BD" . mysqli_error($conn);
    }
}


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
        if (isset($_FILES['foto1']) && $_FILES['foto1']['error'] == 0) {
            // Aquí se actualiza la foto principal
            $foto1 = $_FILES['foto1'];
            // Procesar la foto, moverla al directorio adecuado, etc.
        } else {
            // Si no se seleccionó una nueva foto, mantener la URL de la foto principal actual
            $foto1 = $fotoPrincipalActualizada; // Se mantiene la foto principal actual
        }

    </script>
</head>

<body>

    <?php include("../header-menu.php"); ?>

    <div id="contenedor-admin">
        <?php include("../menu_index_options.php"); ?>

        <div class="contenedor-principal">

            <div id="actualizar-propiedad">
            <h2>Actualizar propiedad</h2>
<hr>


<form action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" method="POST">
<input type="hidden" name="id" value="<?php echo htmlspecialchars($propiedad['id']); ?>">




                    
                    <h2>Información General</h2>
                    
                    <div class="fila-una-columna">
                        <label for="titulo">Nombre del Predio</label>
                        <input type="text" name="titulo" value="<?php echo htmlspecialchars($propiedad['titulo']) ?>" required class="input-entrada-texto">
                    </div>

                    <div class="fila-una-columna">
                        <label for="descripcion">Descripción de la Propiedad</label>
                        <textarea name="descripcion" cols="30" rows="10" class="input-entrada-texto" style="resize: none;"><?php echo htmlspecialchars($propiedad['descripcion']) ?></textarea>
                    </div>  
                    
                    <div class="fila-una-columna">
                        <label for="estado">Estado de la propiedad</label>
                        <select name="estado" id="estado" required class="input-entrada-texto">
                            <option value="nuevo" <?php echo ($propiedad['estado'] === 'Activo') ? 'selected' : ''; ?>>Activo</option>
                            <option value="usado" <?php echo ($propiedad['estado'] === 'Vendido') ? 'selected' : ''; ?>>Vendido</option>
                            <option value="nuevo" <?php echo ($propiedad['estado'] === 'Bloqueado') ? 'selected' : ''; ?>>Bloquedo</option>
                        </select>
                    </div>

                    <div class="fila-una-columna">
                    <label for="tipo">Seleccione tipo de propiedad</label>
                    <select name="tipo" id="tipo" required class="input-entrada-texto">
                        <?php while ($row = mysqli_fetch_assoc($resultado_tipos)) : ?>
                            <option value="<?php echo $row['id']; ?>" 
                                <?php echo ($propiedad['tipo'] == $row['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($row['nombre_tipo']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                    <div class="fila-una-columna">
                        <label for="ubicacion">Tipo de ubicación</label>
                        <select name="ubicacion" id="ubicacion" required class="input-entrada-texto">
                            <option value="urbana" <?php echo ($propiedad['ubicacion'] === 'urbana') ? 'selected' : ''; ?>>Urbana</option>
                            <option value="rural" <?php echo ($propiedad['ubicacion'] === 'campestre') ? 'selected' : ''; ?>>Campestre</option>
                        </select>
                    </div>

                    <br>
                <br>
                <h2>Características De Los Predios</h2>
                <hr>

                <div class="fila">
                    <div class="box">
                        <label for="habitaciones">Habitaciones</label>
                        <input type="text" name="habitaciones" value="<?php echo $propiedad['habitaciones']; ?>" class="input-entrada-texto">
                    </div>

                    <div class="box">
                        <label for="banios">Baños</label>
                        <input type="text" name="banios" value="<?php echo $propiedad['banios']; ?>" class="input-entrada-texto">
                    </div>

                    <div class="box">
                        <label for="pisos">Pisos</label>
                        <input type="text" name="pisos" value="<?php echo $propiedad['pisos']; ?>" class="input-entrada-texto">
                    </div>

                    <div class="box">
                        <label for="garage">Garaje</label>
                        <select name="garage" class="input-entrada-texto">
                            <option value="No" <?php echo ($propiedad['garage'] == "No") ? 'selected' : ''; ?>>No</option>
                            <option value="Si" <?php echo ($propiedad['garage'] == "Si") ? 'selected' : ''; ?>>Si</option>
                        </select>
                    </div>

                    <div class="box">
                        <label for="inventario">Inventario</label>
                        <textarea name="inventario" class="input-entrada-texto" rows="3" style="resize: none;"><?php echo $propiedad['inventario']; ?></textarea>
                    </div>
                </div>

                <br>
                <br>
                <h2>Medidas</h2>
                <hr>

                <div class="fila">
                    <!-- Campo: Dimensiones -->
                    <div class="box">
                        <label for="dimensiones">Dimensiones (m²)</label>
                        <input 
                            type="text" 
                            name="dimensiones" 
                            id="dimensiones" 
                            class="input-entrada-texto" 
                            value="<?php echo htmlspecialchars($propiedad['dimensiones']); ?>" 
                            placeholder="Ejemplo: 50x100" 
                            required>
                    </div>

                    <!-- Campo: Tipo de Dimensiones -->
                    <div class="box">
                        <label for="dimensiones_tipo">Tipo de Dimensiones</label>
                        <input 
                            type="text" 
                            name="dimensiones_tipo" 
                            id="dimensiones_tipo" 
                            class="input-entrada-texto" 
                            value="<?php echo htmlspecialchars($propiedad['dimensiones_tipo']); ?>" 
                            placeholder="Ejemplo: metros cuadrados" 
                            required>
                    </div>

                    <!-- Campo: Área -->
                    <div class="box">
                        <label for="area">Área</label>
                        <input 
                            type="text" 
                            name="area" 
                            id="area" 
                            class="input-entrada-texto" 
                            value="<?php echo htmlspecialchars($propiedad['area']); ?>" 
                            placeholder="Ingrese el área total" 
                            required>
                    </div>
                </div>

                <br>
                <br>
                <h2>Ubicación Geográfica</h2>
                <hr>
                <div class="fila">
                    <!-- Campo: Departamento -->
                    <div class="box">
                        <label for="departamento">Seleccione Departamento</label>
                        <select name="departamento" id="departamento" onchange="muestraselect(this.value)" class="input-entrada-texto">
                            <option value="">Seleccione departamento</option>
                            <?php while ($row = mysqli_fetch_assoc($resultado_departamentos)) : ?>
                                <option value="<?php echo $row['id']; ?>" 
                                    <?php echo ($row['id'] == $propiedad['departamento']) ? 'selected' : ''; ?>>
                                    <?php echo $row['nombre_departamento']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <!-- Campo: Ciudad -->
                    <div class="box">
                        <label for="ciudad">Seleccione Ciudad</label>
                        <select name="ciudad" id="ciudad" class="input-entrada-texto" required>
                            <option value="">Seleccione ciudad</option>
                            <?php while ($row = mysqli_fetch_assoc($resultado_ciudades)) : ?>
                                <option value="<?php echo $row['id']; ?>" 
                                    <?php echo ($row['id'] == $propiedad['ciudad']) ? 'selected' : ''; ?>>
                                    <?php echo $row['nombre_ciudad']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <!-- Campo: Barrio o Pueblo -->
                    <div class="box">
                        <label for="ubicacion">Barrio o Pueblo</label>
                        <input type="text" name="ubicacion" class="input-entrada-texto" 
                            placeholder="Ubicación de la propiedad" 
                            value="<?php echo htmlspecialchars($propiedad['ubicacion']); ?>" 
                            required>
                    </div>
                </div>

                <div class="fila-una-columna">
                    <!-- Campo: Dirección -->
                    <label for="direccion">Dirección</label>
                    <input type="text" name="direccion" class="input-entrada-texto" 
                        placeholder="Dirección de la propiedad" 
                        value="<?php echo htmlspecialchars($propiedad['direccion']); ?>" 
                        required>
                </div>

                <div class="input-container">
                    <br>
                    <label for="ubicacion_url">Ingrese la URL de la ubicación:</label>
                    <textarea class="input-entrada-texto" id="ubicacion_url" name="ubicacion_url" 
                        placeholder="Pegue aquí el iframe" oninput="verVistaPrevia()"> 
                        <?php echo htmlspecialchars($propiedad['ubicacion_url']); ?>
                    </textarea>
                    <br>
                    <div id="previewContainer"></div> <!-- Contenedor para mostrar el iframe -->
                    <div id="errorContainer" class="error-message"></div> <!-- Contenedor para mostrar errores -->
                </div>




                <br>
                <br>
                <h2>Servicios De La Propiedad</h2>
                <hr>

                <div class="fila">
                    <div class="box">
                        <label for="internet">Internet</label>
                        <select name="internet" id="internet" class="input-entrada-texto">
                            <option value="No" <?php if ($propiedad['internet'] == "No") { echo "selected"; } ?>>No</option>
                            <option value="Si" <?php if ($propiedad['internet'] == "Si") { echo "selected"; } ?>>Si</option>
                        </select>
                    </div>

                    <div class="box">
                    <label for="agua">Agua</label>
                    <select name="agua" id="agua" class="input-entrada-texto">
                        <option value="nacimiento propio" <?php if ($propiedad['agua_propia'] == "nacimiento propio") { echo "selected"; } ?>>Nacimiento propio</option>
                        <option value="algibe" <?php if ($propiedad['agua_propia'] == "algibe") { echo "selected"; } ?>>Algibe</option>
                        <option value="reserva_acuifera_subterranea" <?php if ($propiedad['agua_propia'] == "reserva_acuifera_subterranea") { echo "selected"; } ?>>Reserva acuífera subterránea</option>
                        <option value="no_aplica" <?php if ($propiedad['agua_propia'] == "no_aplica") { echo "selected"; } ?>>No aplica / No cuenta con agua</option>
                    </select>
                </div>

                    <div class="box">
                        <label for="gas">Gas</label>
                        <select name="gas" id="gas" class="input-entrada-texto">
                            <option value="No" <?php if ($propiedad['gas'] == "No") { echo "selected"; } ?>>No</option>
                            <option value="Si" <?php if ($propiedad['gas'] == "Si") { echo "selected"; } ?>>Si</option>
                        </select>
                    </div>
                </div>

                <div class="fila">
                    <div class="box">
                        <label for="luz">Luz</label>
                        <select name="luz" id="luz" class="input-entrada-texto">
                            <option value="No" <?php if ($propiedad['luz'] == "No") { echo "selected"; } ?>>No</option>
                            <option value="Si" <?php if ($propiedad['luz'] == "Si") { echo "selected"; } ?>>Si</option>
                        </select>
                    </div>
                </div>

                <!-- Características Positivas -->
                <div class="fila-una-columna">
                    <label for="caracteristicas_positivas">Características Positivas</label>
                    <textarea name="caracteristicas_positivas" id="caracteristicas_positivas" cols="30" rows="5" class="input-entrada-texto" placeholder="Características positivas de la propiedad..."><?php echo htmlspecialchars($propiedad['caracteristicas_positivas']); ?></textarea>
                </div>
                <hr>


                <br>
                <br>
                <h2>Técnicas</h2>
                <hr>

                <!-- Campo: Altitud -->
                <div class="form-group">
                    <label for="altitud">Altitud</label>
                    <input 
                        class="input-entrada-texto"
                        type="text"
                        name="altitud"
                        id="altitud"
                        value="<?php echo htmlspecialchars($propiedad['altitud']); ?>"
                        placeholder="Ingrese altitud en metros">
                </div>

                <!-- Campo: Clima -->
                <div class="box">
                    <label for="clima">Clima</label>
                    <select name="clima" id="clima" class="input-entrada-texto">
                        <option value="Cálido (24 °C a 30 °C)" <?php if ($propiedad['clima'] == "Cálido (24 °C a 30 °C)") { echo "selected"; } ?>>Cálido (24 °C a 30 °C)</option>
                        <option value="Templado (16 °C a 24 °C)" <?php if ($propiedad['clima'] == "Templado (16 °C a 24 °C)") { echo "selected"; } ?>>Templado (16 °C a 24 °C)</option>
                        <option value="Frío (0 °C a 16 °C)" <?php if ($propiedad['clima'] == "Frío (0 °C a 16 °C)") { echo "selected"; } ?>>Frío (0 °C a 16 °C)</option>
                        <option value="Páramo (0 °C a 10 °C)" <?php if ($propiedad['clima'] == "Páramo (0 °C a 10 °C)") { echo "selected"; } ?>>Páramo (0 °C a 10 °C)</option>
                        <option value="Tropical (25 °C a 35 °C)" <?php if ($propiedad['clima'] == "Tropical (25 °C a 35 °C)") { echo "selected"; } ?>>Tropical (25 °C a 35 °C)</option>
                    </select>
                </div>

                <!-- Campo: Construcciones Aledañas -->
                <div class="box">
                    <label for="construcciones_aledañas">Construcciones Aledañas</label>
                    <input 
                        type="text" 
                        name="construcciones_aledañas" 
                        class="input-entrada-texto" 
                        placeholder="Describe las construcciones cercanas a la propiedad..."
                        value="<?php echo htmlspecialchars($propiedad['construcciones_aledañas']); ?>"
                    >
                </div>


                <br>
                                    <br>
                                    <h2>Jurídico</h2>
                                    <hr>

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

                                        <br>
                <br>
                <h2>Usos Del Suelo</h2>
                <hr>

                <!-- Campo: Uso principal -->
                <div class="form-group">
                    <label for="uso_principal">Uso principal</label>
                    <input 
                        class="input-entrada-texto"
                        type="text"
                        name="uso_principal"
                        id="uso_principal"
                        value="<?php echo htmlspecialchars($propiedad['uso_principal']); ?>"
                        placeholder="Ingrese el uso principal de la propiedad">
                </div>

                <!-- Campo: Usos compatibles -->
                <div class="box">
                    <label for="uso_compatibles">Usos compatibles</label>
                    <input 
                        type="text" 
                        name="uso_compatibles" 
                        class="input-entrada-texto" 
                        placeholder="Usos compatibles"
                        value="<?php echo htmlspecialchars($propiedad['uso_compatibles']); ?>" 
                        required>
                </div>

                <!-- Campo: Usos condicionales -->
                <div class="box">
                    <label for="uso_condicionales">Usos condicionales</label>
                    <input 
                        type="text" 
                        name="uso_condicionales" 
                        class="input-entrada-texto" 
                        placeholder="Usos condicionales" 
                        value="<?php echo htmlspecialchars($propiedad['uso_condicionales']); ?>" 
                        required>
                </div>

                    <br>
                    <br>
                    <h2>Galería de fotos</h2>
                    <hr>

                    <div class="">
                        <p><b>Foto principal</b> (<label for="foto1" class="btn-cambiar-foto">Cambiar foto</label>)</p>
                        <output id="list" class="contenedor-foto-principal">
                            <img src="<?php echo $propiedad['url_foto_principal'] ?>" alt="">
                        </output>

                        <input type="file" id="foto1" accept="image/*" name="foto1" style="display:none">
                        <input type="hidden" id="fotoPrincipalActualizada" name="fotoPrincipalActualizada" value="<?php echo $propiedad['url_foto_principal']; ?>">
                    </div>
                    <br><br>
                    <div>
                        <p><b>Galería</b> ( <label for="fotos" class="btn-cambiar-foto">Agregar mas Fotos</label>)</p>
                        <input type="hidden" id="fotosAEliminar" name="fotosAEliminar">
                        <div id="contenedor-fotos-publicacion">
                            <?php
                            $galeria = obtenerFotosGaleriaDePropiedad($propiedad['id']);
                            $i = 1;
                            while ($foto = mysqli_fetch_assoc($galeria)) : ?>
                                <output class="contenedor-foto-galeria" id="<?php echo $i ?>">
                                    <img src="fotos/<?php echo $propiedad['id'] . "/" . $foto['nombre_foto'] ?>" class="foto-galeria">
                                    <span id="btn-eliminar-galeria" id="<?php echo $foto['id'] ?>" onclick="eliminarFoto(<?php echo $foto['id'] ?>, <?php echo $i ?>)"> Eliminar</span>
                                </output>
                            <?php
                                $i++;
                            endwhile
                            ?>
                        </div>

                        <br>
                        <br>

                        <div id="contenedor-fotos-nuevas">
                            <p><b>(Opcional) Fotos nuevas de galeria</b></p>       
                        </div>

                        <input type="file" id="fotos" accept="image/*" name="fotos[]" multiple="" style="display:none">
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
                <h2>Detalles Financieros De La Propiedad</h2>
                <hr>

                <!-- Campo: Precio -->
                <div class="box">
                    <label for="precio">Precio (Alquiler o Venta)</label>
                    <input 
                        type="text" 
                        name="precio" 
                        value="<?php echo $propiedad['precio']; ?>" 
                        class="input-entrada-texto">
                </div>

                <!-- Campo: Moneda -->
                <div class="box">
                    <label for="moneda">Moneda</label>
                    <input 
                        type="text" 
                        name="moneda" 
                        value="<?php echo $propiedad['moneda']; ?>" 
                        class="input-entrada-texto" 
                        required>
                </div>

                <!-- Campo: Permuta -->
                <div class="fila">
                    <div class="box">
                        <label for="permuta">¿Permuta?</label>
                        <select name="permuta" id="" class="input-entrada-texto">
                            <option value="0" <?php if ($propiedad['permuta'] == "No") { echo "selected"; } ?>>No</option>
                            <option value="1" <?php if ($propiedad['permuta'] == "Si") { echo "selected"; } ?>>Sí</option>
                        </select>
                    </div>
                </div>  

                <!-- Campo: Financiación disponible -->
                <div class="box">
                    <label for="financiacion">¿Financiación disponible?</label>
                    <select name="financiacion" id="financiacion" class="input-entrada-texto" required>
                        <option value="1" <?php if ($propiedad['financiacion'] == "1") { echo "selected"; } ?>>Sí</option>
                        <option value="0" <?php if ($propiedad['financiacion'] == "0") { echo "selected"; } ?>>No</option>
                    </select>
                </div>

                <br>
                <h2>Espaciales</h2>
                <hr>

                <div class="fila">
                    <!-- Salidas de Bogotá -->
                    <div class="box">
                        <label for="salidas_bogota">Salidas de Bogotá</label>
                        <select name="salidas_bogota" id="salidas_bogota" class="input-entrada-texto" required>
                            <option value="autopista_sur" <?php if ($propiedad['salidas_bogota'] == "autopista_sur") { echo "selected"; } ?>>Autopista Sur</option>
                            <option value="autopista_calle_80" <?php if ($propiedad['salidas_bogota'] == "autopista_calle_80") { echo "selected"; } ?>>Autopista Calle 80</option>
                            <option value="autopista_calle_13" <?php if ($propiedad['salidas_bogota'] == "autopista_calle_13") { echo "selected"; } ?>>Autopista Calle 13</option>
                            <option value="autopista_via_la_calera" <?php if ($propiedad['salidas_bogota'] == "autopista_via_la_calera") { echo "selected"; } ?>>Autopista Via La Calera</option>
                        </select>
                    </div>

                    <!-- Distancia al Pueblo -->
                    <div class="box">
                        <label for="distancia_pueblo">Distancia al Pueblo</label>
                        <input 
                            type="text" 
                            name="distancia_pueblo" 
                            class="input-entrada-texto" 
                            value="<?php echo htmlspecialchars($propiedad['distancia_pueblo']); ?>" 
                            placeholder="Distancia en km">
                    </div>
                </div>

                <div class="fila">
                    <!-- Distancia desde Bogotá -->
                    <div class="box">
                        <label for="distancia_desde_bogota">Distancia desde Bogotá (km)</label>
                        <input 
                            type="number" 
                            name="distancia_desde_bogota" 
                            id="distancia_desde_bogota" 
                            class="input-entrada-texto" 
                            value="<?php echo htmlspecialchars($propiedad['distancia_desde_bogota']); ?>" 
                            placeholder="Distancia en km" 
                            required>
                    </div>

                    <!-- Vías de acceso -->
                    <div class="box">
                        <label for="vias_acceso">Vías de acceso</label>
                        <input 
                            type="text" 
                            name="vias_acceso" 
                            class="input-entrada-texto" 
                            value="<?php echo htmlspecialchars($propiedad['vias_acceso']); ?>" 
                            placeholder="Vías de acceso" 
                            required>
                    </div>

                    <!-- Nombre del propietario -->
                    <div class="box">
                        <label for="nombre_propietario">Nombre Propietario</label>
                        <input 
                            type="text" 
                            name="nombre_propietario" 
                            class="input-entrada-texto" 
                            value="<?php echo htmlspecialchars($propiedad['nombre_propietario']); ?>" 
                            placeholder="Nombre propietario" 
                            required>
                    </div>
                </div>


                <input type="submit" value="Actualizar Datos" name="actualizar" class="btn-accion">
            </form>

            <?php if (isset($estado)) : ?>
                <script>
                    Swal.fire({
                        icon: '<?php echo $estado; ?>',
                        title: '<?php echo $estado == 'success' ? "¡Éxito!" : "¡Se Actualizo correctamente!"; ?>',
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

    <script src="../script.js"></script>
    <script src="../subirFoto.js"></script>
    <script src="../vista_recorrido_video.js"></script>
</body>

</html>