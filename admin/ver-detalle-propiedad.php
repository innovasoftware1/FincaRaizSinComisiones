<?php
session_start();

if (!$_SESSION['usuarioLogeado']) {
    header("Location:login.php");
}

include("conexion.php");
$id_propiedad = $_GET['id'];

$query = "SELECT * FROM propiedades WHERE id='$id_propiedad'";

$resultado_propiedad = mysqli_query($conn, $query);
$propiedad = mysqli_fetch_assoc($resultado_propiedad);


function obtenerTipo($id_tipo)
{
    include("conexion.php");
    $query = "SELECT * FROM tipos WHERE id='$id_tipo'";

    $resultado_tipo = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($resultado_tipo);
    return $row['nombre_tipo'];
}

function obtenerFotosGaleria($id_propiedad)
{
    include("conexion.php");
    $query = "SELECT * FROM fotos WHERE id_propiedad='$id_propiedad'";

    $resultado_fotos = mysqli_query($conn, $query);
    return $resultado_fotos;
}

function obtenerDepartamentos($id_departamento)
{
    include("conexion.php");
    $query = "SELECT * FROM departamentos WHERE id='$id_departamento'";

    $resultado_departamento = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($resultado_departamento);
    return $row['nombre_departamento'];
}

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
    <link rel="stylesheet" href="estilo.css">
    <title>FRSC - Admin</title>
</head>

<body>
    <?php include("header.php"); ?>
    <div id="contenedor-admin">
        <?php include("contenedor-menu.php"); ?>

        <div class="contenedor-principal">
            <div id="detalle-propiedad">
                <h2>Detalle de Propiedad</h2>
                <br>
                <hr>
                <div class="contenedor-tabla">
                    <h3>Descripción de la propiedad</h3>
                    <table class="descripcion">
                        <tr>
                            <td>Cedula del propietario</td>
                            <td><?php echo $propiedad['id'] ?></td>
                        </tr>
                        <tr>
                            <td>Nombre de la Propiedad:</td>
                            <td> <?php echo $propiedad['titulo'] ?> </td>
                        </tr>

                        <tr>
                            <td>Descripción de la Propiedad</td>
                            <td> <?php echo $propiedad['descripcion'] ?> </td>
                        </tr>

                        <tr>
                            <td>Tipo de propiedad</td>
                            <td> <?php echo obtenerTipo($propiedad['tipo']) ?> </td>
                        </tr>

                        <tr>
                            <td>Clasificacion</label></td>
                            <td> <?php echo $propiedad['estado'] ?> </td>
                        </tr>

                        <tr>
                            <td>Ubicación</label></td>
                            <td> <?php echo $propiedad['ubicacion'] ?> </td>
                        </tr>

                        <tr>
                            <td>No. Habitaciones</label></td>
                            <td> <?php echo $propiedad['habitaciones'] ?> </td>
                        </tr>

                        <tr>
                            <td>No. Baños</td>

                            <td> <?php echo $propiedad['banios'] ?> </td>
                        </tr>

                        <tr>
                            <td>No. Pisos</td>
                            <td> <?php echo $propiedad['pisos'] ?> </td>
                        </tr>

                        <tr>
                            <td>Garage</td>
                            <td> <?php echo $propiedad['garage'] ?> </td>
                        </tr>

                        <tr>
                            <td>Area</td>
                            <td> <?php echo $propiedad['dimensiones'] ?> <?php echo $propiedad['dimensiones_tipo'] ?></td>
                        </tr>

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
                            <td> <?php echo $propiedad['agua'] ?> </td>
                        </tr>

                        <tr>
                            <td>Gas</td>
                            <td> <?php echo $propiedad['gas'] ?> </td>
                        </tr>

                        <tr>
                            <td>Clima y Temperatura</td>
                            <td> <?php echo $propiedad['clima'] ?> </td>
                        </tr>

                        <tr>
                            <td>Documentos necesarios para proceso</td>
                            <td> <?php echo $propiedad['documentos_transferencia'] ?> </td>
                        </tr>

                        <tr>
                            <td>Precio (Venta)</td>
                            <td> <?php echo $propiedad['moneda'] . " " . $propiedad['precio'] ?> </td>
                        </tr>
                    </table>
                </div>

                <div class="contenedor-tabla">
                    <h3>Galería de Fotos</h3>
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



                <div class="contenedor-tabla">
                    <h3>Ubicación y Datos del propietario</h3>

                    <table class="descripcion">
                        <tr class="fila">
                            <td><label for="departamento">Departamento</td>
                            <td> <?php echo obtenerDepartamentos($propiedad['departamento']) ?> </td>
                        </tr>
                        <tr class="fila">
                            <td>Ciudad</td>
                            <td> <?php echo obtenerCiudad($propiedad['ciudad']) ?> </td>
                        </tr>

                        <tr>
                            <td>¿Permuta?</td>
                            <td><?php echo $propiedad['permuta'] ?> </td>
                        </tr>
                    </table>
                </div>

            </div>
        </div>
    </div>
</body>

</html>