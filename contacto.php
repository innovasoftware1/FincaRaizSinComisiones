<?php
include("funciones.php");


/* $config = obtenerConfiguracion(); */

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

<!-- icono de whatsapp inicio -->
<a href="https://api.whatsapp.com/send?phone=573102499843&text=Estoy%20interesado%20en%20vender..."
    target="_blank" class="float">
    <i class="fab fa-whatsapp my-float"></i>
</a>
<div id="tooltip" class="tooltip"><b>¡Contáctanos por WhatsApp!</b></div>
<!-- icono de whatsapp final -->

<body class="page-contacto">
    <div class="container">
        <?php include("header.php"); ?>
        <h2 class="titulo-seccion">Contacto</h2>


        <!-- vender con nosotros inicio -->
        <div class="contenedor-contacto contacto-ventas">
            <div class="col-size info formulario">
                <br>
                <h3>¿Buscas vender tu propiedad?</h3>
                <br>
                <hr>
                <br>
                <!-- Contenedor para las columnas -->
                <div id="contenedor">
                    <!-- Columna 1 -->
                    <div>
                        <div class="contacto-item">
                            <h3> <i class="fa-solid fa-hand-holding-dollar"></i> ¡Conoce nuestro nuevo método de venta!</h3>
                            <p>Nos encargamos de todo el proceso para que tú solo te concentres en cerrar la venta. Con nuestro nuevo método de venta sin intermediarios, tú tendrás acceso directo al futuro comprador, simplificando cada paso y asegurando que el proceso sea más rápido y eficiente.</p>
                        </div>

                        <div class="contacto-item">
                            <h3><i class="fa-solid fa-thumbs-up"></i> Nuestra oferta incluye:</h3>
                            <ul>
                                <li>Publicación en página web</li>
                                <li>Recorrido virtual 360 ° con un gemelo digital de su predio elaborado con dron</li>
                                <li>Fotografía profesional</li>
                                <li>Asesoría personalizada</li>
                                <li>Publicidad eficiente (vallas, pendones, volantes y marketing electrónico)</li>
                            </ul>
                        </div>

                        <div class="contacto-item">
                            <h3><i class="fa-solid fa-users"></i> ¿Por qué somos tu aliado perfecto para vender?</h3>
                            <p>"Porque somos un modelo de venta innovador en el sector de finca raíz, que te ayuda a vender tus propiedades de manera más eficiente, rápida, segura y económica."</p>
                        </div>
                    </div>

                    <!-- Columna 2 -->
                    <div>
                        <div class="contacto-item">
                            <h3><i class="fa-solid fa-lightbulb"></i> Eficiencia</h3>
                            <p>Creamos un gemelo digital que permite a los compradores explorar su propiedad en un portal web intuitivo, facilitando la búsqueda exacta.</p>
                        </div>

                        <div class="contacto-item">
                            <h3><i class="fa-solid fa-user-secret"></i> Seguridad</h3>
                            <p>Los propietarios evitarán contacto directo con los compradores, reduciendo el riesgo de interactuar con desconocidos.</p>
                        </div>

                        <div class="contacto-item">
                            <h3><i class="fa-regular fa-money-bill-1"></i> Economia</h3>
                            <p>Solo se cobrará un 2.8% del valor de su propiedad al momento de la venta, sin pagos mensuales ni inversiones iniciales.</p>
                        </div>

                        <div class="contacto-item">
                            <h3><i class="fa-solid fa-gauge-high"></i> Rapidez</h3>
                            <ul>
                                <li><b>Publicidad efectiva Impresa:</b> Volanteo, Vallas, Pendones.</li>
                                <li><b>Digital:</b> Manejo de redes sociales.</li>
                                <li><b>Página web:</b> Para así llegar rápidamente a miles de posibles compradores</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- vender con nosotros final  -->
        <div class="contenedor-contacto">

            <div class="col info">
                <div class="formulario">
                    <h3>Información de contacto</h3>
                    <hr>
                </div>
                <div>
                    <h3> <i class="fa-solid fa-location-dot"></i> Nuestra Oficina Central</h3>
                    <br>
                    <p>Carrera 25A # 10-60, Bogotà</p>
                </div>

                <div>
                    <h3><i class="fa-solid fa-phone"></i> Nuestros teléfonos</h3>
                    <br>
                    <p>(+57) 3102499843</p>
                </div>


                <div>
                    <h3><i class="fa-solid fa-envelope"></i> Correo Electrónico</h3>
                    <br>
                    <p>supata@fincaraizsincomisiones.com</p>
                </div>

                <div>
                    <h3><i class="fa-solid fa-clock"></i> Horarios de atención en Oficina</h3>
                    <br>
                    <p>Domingo a Domingo de 7:00am a 7:00pm</p>
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
        <script src="tooltip-whatsapp.js"></script>
</body>

</html>