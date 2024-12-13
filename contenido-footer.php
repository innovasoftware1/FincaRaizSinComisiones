<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FRSC.com</title>
    <link rel="stylesheet" href="estilo.css">
</head>

<body>

    <footer class="footer-inicio">
        <div class="siguenos">
            <p>Síguenos: </p>
        </div>
        <div class="compartir">
            <a class="facebook" href="http://facebook.com/sharer.php?u=http://localhost/sapi/publicacion.php?idPublicacion=<?php echo $propiedad['id'] ?>" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
            <a class="whatsapp" href="whatsapp://send?text=http://paulopelegrina.com/publicacion.php?idPublicacion=<?php echo $propiedad['id'] ?>" data-action="share/whatsapp/share"><i class="fa-brands fa-whatsapp"></i></a>
            <a class="instagram" href="https://www.instagram.com/create/story/?text=Mira%20esta%20propiedad%20!!!%20http://paulopelegrina.com/publicacion.php?idPublicacion=<?php echo $propiedad['id']; ?>" target="_blank"><i class="fa-brands fa-instagram"></i></a>
            <a class="x" href="https://twitter.com/intent/tweet?text=Mira%20esta%20propiedad%20!!!%20http://paulopelegrina.com/publicacion.php?idPublicacion=<?php echo $propiedad['id']; ?>" target="_blank"><i class="fa-brands fa-x-twitter">𝕏</i></a>
        </div>
        <div class="footer-left">
            Fincaraizsincomisiones.com <br>
            <p>(+57)3102499843 - fincaraizsincomisiones@gmail.com</p>
            <p> <a href="admin/login.php">Ingreso de Funcionarios</a></p>
        </div>

    </footer>


</body>

</html>