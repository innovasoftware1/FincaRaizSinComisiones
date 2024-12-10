<?php
session_start();

// Verifica si el usuario está logueado
if (!isset($_SESSION['usuarioLogeado']) || !$_SESSION['usuarioLogeado']) {
    header("Location: login.php");
    exit();
}

include("conexion.php");

// Obtiene el ID de la propiedad, priorizando 'propiedad_id'
$id_propiedad = isset($_GET['propiedad_id']) ? $_GET['propiedad_id'] : (isset($_GET['id']) ? $_GET['id'] : null);

if (!$id_propiedad) {
    // Manejo del caso donde no se recibe ningún ID
    die("No se ha especificado un ID válido.");
}

// Consulta para obtener los datos de la propiedad principal
$query = "SELECT * FROM propiedades WHERE id='$id_propiedad'";
$resultado_propiedad = mysqli_query($conn, $query);
$propiedad = mysqli_fetch_assoc($resultado_propiedad);

if (!$propiedad) {
    die("Propiedad no encontrada.");
}

// Consulta para obtener las subpropiedades relacionadas con la propiedad principal
$query_subpropiedades = "SELECT * FROM subpropiedades WHERE propiedad_id = '$id_propiedad'";
$resultado_subpropiedades = mysqli_query($conn, $query_subpropiedades);
$subpropiedades = mysqli_fetch_all($resultado_subpropiedades, MYSQLI_ASSOC);

// Función para obtener el tipo de propiedad
function obtenerTipo($id_tipo)
{
    include("conexion.php");
    $query = "SELECT * FROM tipos WHERE id='$id_tipo'";
    $resultado_tipo = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($resultado_tipo);
    return $row['nombre_tipo'];
}

// Función para obtener las fotos de la galería de la propiedad
function obtenerFotosGaleria($id_propiedad)
{
    include("conexion.php");
    $query = "SELECT * FROM fotos WHERE id_propiedad='$id_propiedad'";
    $resultado_fotos = mysqli_query($conn, $query);
    return $resultado_fotos;
}

// Función para obtener el nombre del departamento
function obtenerDepartamentos($id_departamento)
{
    include("conexion.php");
    $query = "SELECT * FROM departamentos WHERE id='$id_departamento'";
    $resultado_departamento = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($resultado_departamento);
    return $row['nombre_departamento'];
}

// Función para obtener el nombre de la ciudad
function obtenerCiudad($id_ciudad)
{
    include("conexion.php");
    $query = "SELECT * FROM ciudades WHERE id='$id_ciudad'";
    $resultado_ciudad = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($resultado_ciudad);
    return $row['nombre_ciudad'];
}


?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>FRSC - Admin</title>
</head>


<style>
    .botones-acciones a {
        margin-left: 20px;
    }
</style>



<body>
    <?php include("header.php"); ?>
    <div id="contenedor-admin">
        <?php include("contenedor-menu.php"); ?>

        <div class="contenedor-principal">
            <div id="detalle-propiedad">
                <h2>Detalle de Propiedad</h2>
                <br>
                <hr>
                <!-- informacion general de la propiedad - initial -->
                <div class="contenedor-tabla">
                    <h3><i class="fa-solid fa-circle-info"></i> Información de la propiedad</h3>
                    <br>
                    <table class="descripcion" id="myTable">
                        <tr>
                            <td>id. Propiedad</td>
                            <td>
                                <p>Identificador No. (<?php echo $propiedad['id'] ?>)</p>
                            </td>
                        </tr>

                        <tr>
                            <td>Nombre</td>
                            <td> <?php echo $propiedad['titulo'] ?> </td>
                        </tr>

                        <tr>
                            <td>Descripción detallada</td>
                            <td> <?php echo $propiedad['descripcion'] ?> </td>
                        </tr>

                        <tr>
                            <td>Tipo de propiedad</td>
                            <td> <?php echo obtenerTipo($propiedad['tipo']) ?> </td>
                        </tr>

                        <tr>
                            <td>Tipo de ubicación</td>
                            <td> <?php echo $propiedad['tipoUbicacion'] ?> </td>
                        </tr>

                        <tr>
                            <td>Estado</label></td>
                            <td> <?php echo $propiedad['estado'] ?> </td>
                        </tr>

                    </table>
                    <br>
                    <br>
                    <table class="descripcion">
                        <tr>
                            <td>Nombre del propietario</td>
                            <td><?php echo $propiedad['nombre_propietario'] ?></td>
                        </tr>

                    </table>
                </div>
                <!-- infromacion general de la propiedad - final -->

                <!-- detalles financieros - inicial -->
                <div class="contenedor-tabla">
                    <h3><i class="fa-solid fa-money-check-dollar"></i> Detalles financieros</h3>
                    <br>
                    <table class="descripcion">

                        <tr>
                            <td>Precio</td>
                            <td>
                                <?php
                                echo "(" . $propiedad['moneda'] . ") " . number_format($propiedad['precio'], 0, ',', '.');
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <td>¿Permuta?</td>
                            <td>
                                <p><?php echo $propiedad['permuta'] == 1 ? "Sí" : "No"; ?>, se permuta el predio</p>
                            </td>
                        </tr>

                        <tr>
                            <td>¿Financea?</td>
                            <td>
                                <p><?php echo $propiedad['financiacion'] == 1 ? "Sí" : "No" ?>, se financea el predio</p>
                            </td>
                        </tr>

                    </table>
                </div>
                <!-- detalles financieros - final -->

                <!-- caracteristicas de los predios - inicial -->
                <div class="contenedor-tabla">
                    <h3><i class="fa-solid fa-house-medical"></i> Caracteristicas de la propiedad</h3>
                    <br>
                    <table class="descripcion">

                        <tr>
                            <td>No. Habitaciones</label></td>
                            <td>
                                <p><?php echo $propiedad['habitaciones'] ?> habitaciones</p>
                            </td>
                        </tr>

                        <tr>
                            <td>No. Baños</td>

                            <td>
                                <p><?php echo $propiedad['banios'] ?> baños</p>
                            </td>
                        </tr>

                        <tr>
                            <td>No. Pisos</td>
                            <td>
                                <p><?php echo $propiedad['pisos'] ?> niveles</p>
                            </td>
                        </tr>

                        <tr>
                            <td>Garage</td>
                            <td>
                                <p><?php echo $propiedad['garage'] ?> garaje(s)</p>
                            </td>
                        </tr>

                        <tr>
                            <td>Inventario detallado</td>
                            <td> <?php echo $propiedad['inventario'] ?></td>
                        </tr>


                    </table>
                </div>
                <!-- caracteristicas de los predios - final -->

                <!-- medidas de los predios - inicial -->
                <div class="contenedor-tabla">
                    <h3><i class="fa-solid fa-ruler"></i> Medidas de la propiedad</h3>
                    <br>
                    <table class="descripcion">

                        <tr>
                            <td>Dimensiones (m²)</label></td>
                            <td> <?php echo $propiedad['dimensiones'] ?> mts²</td>
                        </tr>

                        <tr>
                            <td>Area en (m²)</td>

                            <td>
                                <p><?php echo $propiedad['area'] ?> <?php echo $propiedad['dimensiones_tipo'] ?></p>
                            </td>
                        </tr>

                    </table>
                </div>
                <!-- medidas de los predios - final -->

                <!-- ubicacion de los predios - inicial -->
                <div class="contenedor-tabla">
                    <h3><i class="fa-solid fa-map-location-dot"></i> Ubicación geográfica</h3>
                    <br>
                    <table class="descripcion">

                        <tr>
                            <td>Zona geográfica</label></td>
                            <td>
                                <p><?php echo obtenerDepartamentos($propiedad['departamento']) ?>, <?php echo obtenerCiudad($propiedad['ciudad']) ?></p>
                            </td>
                        </tr>

                        <tr>
                            <td>Barrio o Pueblo</td>

                            <td>
                                <p><?php echo $propiedad['ubicacion'] ?></p>
                            </td>
                        </tr>

                        <tr>
                            <td>Dirección</td>

                            <td>
                                <p><?php echo $propiedad['direccion'] ?></p>
                            </td>
                        </tr>

                        <tr>
                            <td>Distancia desde Bogotá (Km.)</td>
                            <td>
                                <p><?php echo $propiedad['distancia_desde_bogota'] ?> Kilómetros</p>
                            </td>
                        </tr>
                        <tr>
                            <td>Distancia del predio al 1er. pueblo (Km.)</td>

                            <td>
                                <p><?php echo $propiedad['distancia_pueblo'] ?> Kilometros</p>
                            </td>
                        </tr>

                        <tr>
                            <td>Salidas de Bogotá</td>

                            <td>
                                <p>Salida por <?php echo $propiedad['salidas_bogota'] ?></p>
                            </td>
                        </tr>

                        <tr>
                            <td>Vías de acceso</td>

                            <td>
                                <p> Cuenta con <?php echo $propiedad['vias_acceso'] ?></p>
                            </td>
                        </tr>

                    </table>
                </div>
                <!-- ubicacion de los predios - final -->

                <!-- servicios de los predios - inicial -->
                <div class="contenedor-tabla">
                    <h3><i class="fa-solid fa-lightbulb"></i> Servicios</h3>
                    <br>
                    <table class="descripcion">

                        <tr>
                            <td>Internet</td>
                            <td> <?php echo $propiedad['internet'] ?> </td>
                        </tr>

                        <tr>
                            <td>Luz</td>
                            <td> <?php echo $propiedad['luz'] ?> </td>
                        </tr>

                        <tr>
                            <td>Agua</td>
                            <td> <?php echo $propiedad['agua_propia'] ?> </td>
                        </tr>

                        <tr>
                            <td>Gas</td>
                            <td> <?php echo $propiedad['gas'] ?> </td>
                        </tr>

                        <tr>
                            <td>Características positivas</td>

                            <td>
                                <p><?php echo $propiedad['caracteristicas_positivas'] ?></p>
                            </td>
                        </tr>

                    </table>
                </div>
                <!-- servicios de los predios - final -->

                <!-- carac. tecnicas de los predios - inicial -->
                <div class="contenedor-tabla">
                    <h3><i class="fa-solid fa-cloud-sun-rain"></i> Características técnicas</h3>
                    <br>
                    <table class="descripcion">

                        <tr>
                            <td>Construcciones aledañas</td>
                            <td> <?php echo $propiedad['construcciones_aledañas'] ?> </td>
                        </tr>

                        <tr>
                            <td>Altitud</td>
                            <td>
                                <p><?php echo number_format($propiedad['altitud'], 0, ',', '.') . " m.s.n.m"; ?> </p>
                            </td>
                        </tr>

                        <tr>
                            <td>Clima</td>
                            <td> <?php echo $propiedad['clima'] ?> </td>
                        </tr>

                    </table>
                </div>
                <!-- carac. tecnicas de los predios - final -->

                <!-- doc. juridicos de los predios - inicial -->
                <div class="contenedor-tabla">
                    <h3><i class="fa-solid fa-file-lines"></i> Documentos juridicos</h3>
                    <br>
                    <table class="descripcion">

                        <tr>
                            <td>Documentos de trasferencia</td>
                            <td> <?php echo $propiedad['documentos_transferencia'] ?> </td>
                        </tr>

                        <tr>
                            <td>Permisos</td>
                            <td> <?php echo $propiedad['permisos'] ?> </td>
                        </tr>

                    </table>
                </div>
                <!-- doc. juridico de los predios - final -->

                <!-- suelos de los predios - inicial -->
                <div class="contenedor-tabla">
                    <h3><i class="fa-solid fa-street-view"></i> Usos de los suelos</h3>
                    <br>
                    <table class="descripcion">

                        <tr>
                            <td>Usos principales</td>
                            <td> <?php echo $propiedad['uso_principal'] ?> </td>
                        </tr>

                        <tr>
                            <td>Usos compatibles</td>
                            <td> <?php echo $propiedad['uso_compatibles'] ?> </td>
                        </tr>

                        <tr>
                            <td>Usos condicionales</td>
                            <td> <?php echo $propiedad['uso_condicionales'] ?> </td>
                        </tr>

                    </table>
                </div>
                <!-- suelos de los predios - final -->

                <!-- espaciales de los predios - inicial -->
                <div class="contenedor-tabla">
                    <h3><i class="fa-solid fa-maximize"></i> Caracteristicas espaciales</h3>
                    <br>
                    <table class="descripcion">

                        <tr>
                            <td>Usos principales</td>
                            <td> <?php echo $propiedad['uso_principal'] ?> </td>
                        </tr>

                        <tr>
                            <td>Usos compatibles</td>
                            <td> <?php echo $propiedad['uso_compatibles'] ?> </td>
                        </tr>

                        <tr>
                            <td>Usos condicionales</td>
                            <td> <?php echo $propiedad['uso_condicionales'] ?> </td>
                        </tr>

                    </table>
                </div>
                <!-- espaciales de los predios - final -->

                <!-- fotoP, galeria, reocrrido, maps y video - inicial -->
                <div class="contenedor-tabla">
                    <h3><i class="fa-solid fa-camera-retro"></i> Galería multimedia</h3>
                    <br>
                    <table class="descripcion">
                        <tr>
                            <td>Foto Principal</td>
                            <td><img src="property/<?php echo $propiedad['url_foto_principal'] ?>" alt=""></td>

                        </tr>

                        <tr>
                            <td>Galería</td>
                            <td>
                                <?php $resultFotos = obtenerFotosGaleria($propiedad['id']); ?>
                                <?php while ($foto = mysqli_fetch_assoc($resultFotos)) : ?>
                                    <img src="property/fotos/<?php echo $propiedad['id'] . "/" . $foto['nombre_foto'] ?>">
                                <?php endwhile ?>
                            </td>
                        </tr>

                        <tr>
                            <td>Video</td>
                            <td>
                                <?php if (!empty($propiedad['video_url'])) : ?>
                                    <?php echo $propiedad['video_url']; ?>
                                <?php else : ?>
                                    No disponible
                                <?php endif; ?>
                            </td>
                        </tr>

                        <tr>
                            <td>Recorrido 360</td>
                            <td>
                                <?php if (!empty($propiedad['recorrido_360_url'])) : ?>
                                    <iframe src="<?php echo $propiedad['recorrido_360_url'] ?>" width="560" height="300" frameborder="0" allowfullscreen></iframe>
                                <?php else : ?>
                                    No disponible
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Url Maps</td>
                            <td>
                                <?php if (!empty($propiedad['ubicacion_url'])) : ?>
                                    <?php echo $propiedad['ubicacion_url']; ?>
                                <?php else : ?>
                                    No disponible
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>
                </div>
                <!-- fotoP, galeria, reocrrido, maps y video - final -->


                <!-- subpropiedades de los predios - inicial -->
                <div class="contenedor-tabla" id="listado-propiedades">
                    <h3><i class="fa-solid fa-house-laptop"></i> Subpropiedades</h3>
                    <br>

                    <table class="descripcion">
                        <thead>
                            <tr>
                                <th>Id. Propiedad</th>
                                <th>Título y Descripción</th>
                                <th>Precio</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($subpropiedades) {
                                foreach ($subpropiedades as $subpropiedad) {
                                    echo "<tr>";
                                    // Propiedad No.
                                    echo "<td>Propiedad No. " . $subpropiedad['id'] . "</td>";
                                    // Título y Descripción
                                    echo "<td><p><b>" . $subpropiedad['titulo'] . "</b><br>" . $subpropiedad['descripcion'] . "</p></td>";
                                    // Precio
                                    echo "<td><p><b>COP</b> " . number_format($subpropiedad['precio']) . "</p></td>"; // Asegúrate de que 'precio' sea el nombre correcto en tu base de datos
                                    // Botones de acción
                                    echo "<td class='botones-acciones'>
                            <a href='ver-detalle-subpropiedad.php?id=" . $subpropiedad['id'] . "' class='btn-detalle'>
                                <i class='fas fa-eye'></i>
                            </a>
                            <a href='subproperties/update.php?id=" . $subpropiedad['id'] . "' class='btn-actualizar'>
                                <i class='fas fa-sync-alt'></i>
                            </a>
                            <a href='javascript:void(0);' onclick='confirmarEliminacion(" . $subpropiedad['id'] . ")' class='btn-eliminar'>
                                <i class='fas fa-trash-alt'></i>
                            </a>
                        </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4'>La propiedad no cuenta con subpropiedades relacionadas.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmarEliminacion(idPropiedad) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "No podrás revertir esta acción",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Llamada a la función que realiza la eliminación
                eliminarPropiedad(idPropiedad);
            }
        });
    }

    function eliminarPropiedad(idPropiedad) {
    Swal.fire({
        icon: 'success',
        title: '¡Eliminado correctamente!',
        text: 'El registro ha sido eliminado con éxito.',
        confirmButtonText: 'Aceptar',
        timer: 5000, // La alerta se cerrará automáticamente después de 5 segundos
        timerProgressBar: true
    });

    // Retrasa la redirección para que dé tiempo de ver la alerta
    setTimeout(() => {
        window.location.href = `subproperties/drop.php?id=${idPropiedad}&id_propiedad=${<?php echo $id_propiedad; ?>}`;
    }, 3000); // Retraso de 5 segundos
}

</script>



</html>
