<?php
include("funciones.php");


$config = obtenerConfiguracion();

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¿Quieres vender?</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="estilo.css">
</head>

<body class="page-contacto">
    <div class="container">
        <?php include("header.php"); ?>
        <h2 class="titulo-seccion">Contacto</h2>
        <div class="contenedor-contacto">
            <div class="col info">
                <div class="formulario">
                    <h3>Información de contacto</h3>
                    <hr>
                </div>
                <div>
                    <h3> <i class="fa-solid fa-location-dot"></i> Nuestra Oficina Central</h3>
                    <p><?php echo $config['oficina_central'] ?></p>
                </div>

                <div>
                    <h3><i class="fa-solid fa-phone"></i> Nuestros teléfonos</h3>
                    <p>(+57) <?php echo $config['telefono1'] ?></p>
                    <p>(+57) <?php echo $config['telefono2'] ?></p>
                </div>


                <div>
                    <h3><i class="fa-solid fa-envelope"></i> Correo Electrónico</h3>
                    <p><?php echo $config['email_contacto'] ?></p>
                </div>

                <div>
                    <h3><i class="fa-solid fa-clock"></i> Horarios de atención en Oficina</h3>
                    <p><?php echo $config['horarios'] ?></p>
                </div>

            </div>
            <div class="col formulario">
                <form action="">
                    <h3>Comuníquese con nosotros</h3>
                    <hr>
                    <div>
                        <label for="nombre"><b>Nombre</b></label>
                        <input type="text" placeholder="Ingrese su nombre" name="nombre" required>
                    </div>
                    <div>
                        <label for="email"><b>Dirección de Correo</b></label>
                        <input type="email" placeholder="Dirección de Correo" name="email" required>
                    </div>
                    <div>
                        <label for="telefono"><b>Teléfono</b></label>
                        <input type="text" placeholder="Ingrese su teléfono" name="telefono">
                    </div>
                    <div>
                        <label for="mensaje"><b>Consulta</b></label>
                        <textarea type="text" placeholder="Escriba su consulta" name="mensaje" required></textarea>
                    </div>
                    <input class="btn-contact" type="submit" value="Enviar Mensaje" name="enviar">
                </form>
            </div>
            <div class="col formulario">
                <h3>Ubicacion</h3>
                <hr>
                <iframe class="maps" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d497.11541201109173!2d-74.0906027!3d4.607753!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e3f996d30f98dbf%3A0x2398e734d7687cbe!2sInnova%20Publicidad%20Visual%20S.A.S.!5e0!3m2!1ses!2sco!4v1730476915861!5m2!1ses!2sco" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>

        </div>

        <footer class="inferior">
            <?php include("contenido-footer.php") ?>
        </footer>

        <script src="script.js"></script>
</body>

</html>