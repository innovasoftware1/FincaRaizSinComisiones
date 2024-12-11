<?php
session_start();

// Verifica si el usuario está logueado
if (!isset($_SESSION['usuarioLogeado']) || !$_SESSION['usuarioLogeado']) {
    header("Location: login.php");
    exit();
}

include("../conexion.php");

// Obtiene el ID de la propiedad, priorizando 'propiedad_id'
$id_propiedad = isset($_GET['propiedad_id']) ? $_GET['propiedad_id'] : (isset($_GET['id']) ? $_GET['id'] : null);

$query = "SELECT * FROM subpropiedades WHERE id='$id_propiedad'";
$resultado_subpropiedades = mysqli_query($conn, $query);
$fila = mysqli_fetch_assoc($resultado_subpropiedades);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FRSC - ADMIN</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" 
          integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" 
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../estilo.css">
</head>
<body>
    <?php include("../header-menu.php"); ?>
    <div id="contenedor-admin">
        <?php include("../menu_index_options.php"); ?>
        <div class="contenedor-principal">
            <div id="detalle-propiedad">
                <h2>Detalles de Subpropiedad</h2>
                <br>
                <hr>

                <!-- Información básica - inicial -->
                <div class="contenedor-tabla">
                    <h3><i class="fa-solid fa-info-circle"></i> Información Básica</h3>
                    <br>
                    <table class="descripcion">
                        <tr>
                            <td>ID</td>
                            <td><?php echo $fila['id']; ?></td>
                        </tr>
                        <tr>
                            <td>Título</td>
                            <td><?php echo $fila['titulo']; ?></td>
                        </tr>
                        <tr>
                            <td>Descripción</td>
                            <td><?php echo $fila['descripcion']; ?></td>
                        </tr>
                        <tr>
                            <td>Estado</td>
                            <td><?php echo $fila['estado']; ?></td>
                        </tr>
                        <tr>
                            <td>Fecha de Alta</td>
                            <td><?php echo $fila['fecha_alta']; ?></td>
                        </tr>
                    </table>
                </div>
                <!-- Información básica - final -->

                <!-- Medidas - inicial -->
                <div class="contenedor-tabla">
                    <h3><i class="fa-solid fa-ruler"></i> Medidas de la Subpropiedad</h3>
                    <br>
                    <table class="descripcion">
                        <tr>
                            <td>Tipo de Área</td>
                            <td><?php echo $fila['area_tipo']; ?></td>
                        </tr>
                        <tr>
                            <td>Dimensiones</td>
                            <td><?php echo $fila['dimensiones']; ?></td>
                        </tr>
                        <tr>
                            <td>Área</td>
                            <td><?php echo $fila['area']; ?></td>
                        </tr>
                    </table>
                </div>
                <!-- Medidas - final -->

                <!-- Financieros - inicial -->
                <div class="contenedor-tabla">
                    <h3><i class="fa-solid fa-money-check-dollar"></i> Detalles Financieros</h3>
                    <br>
                    <table class="descripcion">
                        <tr>
                            <td>Precio</td>
                            <td><?php echo "(" . $fila['moneda'] . ") " . number_format($fila['precio'], 0, ',', '.'); ?></td>
                        </tr>
                    </table>
                </div>

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
                <!-- Financieros - final -->

                <!-- Multimedia - inicial -->
                <div class="contenedor-tabla">
                    <h3><i class="fa-solid fa-camera"></i> Multimedia</h3>
                    <br>
                    <table class="descripcion">
                        <tr>
                            <td>Foto Principal</td>
                            <td><img src="<?php echo $fila['url_foto_principal']; ?>" alt="Foto" width="200"></td>
                        </tr>
                        <tr>
                            <td>Video</td>
                            <td><a href="<?php echo $fila['video_url']; ?>" target="_blank">Ver Video</a></td>
                        </tr>
                        <tr>
                            <td>Recorrido 360</td>
                            <td><a href="<?php echo $fila['recorrido_360_url']; ?>" target="_blank">Ver Recorrido</a></td>
                        </tr>
                    </table>
                </div>
                <!-- Multimedia - final -->


            </div>
        </div>
    </div>
</body>
</html>
