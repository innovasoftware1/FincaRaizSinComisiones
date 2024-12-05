<?php
include("funciones.php");
include("admin/conexion.php");

$limiteInferior = isset($_GET['c']) ? $_GET['c'] : 0;
$limiteInferior = $limiteInferior + 6;
$result_propiedades = cargarPropiedades($limiteInferior);
?>

<?php while ($propiedad = mysqli_fetch_assoc($result_propiedades)) : ?>

    <div class="fila">
        <form action="publicacion.php" method="get" id="<?php echo $propiedad['id'] ?>">
            <input type="hidden" value="<?php echo $propiedad['id'] ?>" name="idPropiedad"> 
            <div class="contenedor-propiedad" onclick="document.getElementById('<?php echo $propiedad['id'] ?>').submit();">
                <div class="contenedor-img">
                    <img src="<?php echo 'admin/' . $propiedad['url_foto_principal'] ?>" alt="">
                    <div class="estado">
                        <?php echo $propiedad['estado'] ?>
                    </div>
                </div>
                <div class="info">
                    <h2><?php echo $propiedad['titulo'] ?></h2>
                    <p> <i class="fa-solid fa-location-pin"></i><?php echo $propiedad['ubicacion'] ?></p>
                    <span class="precio"><?php echo $propiedad['moneda']?> <?php echo number_format($propiedad['precio'],0,'','.') ?></span>
                    <hr>
                    <table>
                        <tr>
                            <th>Ambientes</th>
                            <th>Baños</th>
                            <th>Dimensiones</th>
                        </tr>
                        <tr>
                            <td><?php echo $propiedad['habitaciones'] ?></td>
                            <td><?php echo $propiedad['banios'] ?></td>
                            <td><?php echo $propiedad['dimensiones'] ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </form>
    </div>

<?php endwhile ?>
