<?php

include("funciones.php");

$i = 0;

$config = obtenerConfiguracion();

$id_propiedad = $_GET['idPropiedad'];

$propiedad = obtenerPropiedadPorId($id_propiedad);

$restul_fotos_galeria = obtenerFotosGaleria($id_propiedad);


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $propiedad['titulo']; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="estilo.css">
</head>

<body class="page-publicacion">
    <div class="container">
        <?php include("header.php"); ?>

        <div class="contenedor-principal">
            <div class="info-publicacion">
                <section class="info-principal-galeria">
                    <div class="dato1">
                        <span class="estado"><?php echo $propiedad['estado'] ?></span>
                        <span class="precio"><?php echo $propiedad['moneda'] ?> <?php echo number_format($propiedad['precio'], 0, '', '.') ?></span>
                    </div>
                    <h2><?php echo $propiedad['titulo'] ?></h2>
                    <p>
                        <i class="fa-solid fa-location-pin"></i>
                        <?php echo $propiedad['ubicacion'] . ", " . obtenerCiudad($propiedad['ciudad']) . ", " . obtenerDepartamento($propiedad['departamento']) ?>
                    </p>
                    <div class="botones-galeria">
                        <button class="btn-general" onclick="mostrarFotos()">Portada</button>
                        <button class="btn-general" onclick="mostrarRecorrido()">Recorrido 360</button>
                        <button class="btn-general" onclick="mostrarVideo()">Video</button>
                    </div>
                    <div class="contenedor-imagen-principal">
                        <img id="imagen-principal" src="<?php echo "admin/" . $propiedad['url_foto_principal'] ?>" alt="Imagen principal">
                    </div>
                    <div id="video-container" style="display: none;">
                        <?php echo $propiedad['video_url'] ?>
                    </div>
                    <div id="recorrido-container" style="display: none;">
                        <iframe id="recorrido" src="<?php echo $propiedad['recorrido_360_url'] ?>" frameborder="0" allowfullscreen></iframe>
                    </div>
                    <br>
                    <hr>
                    <div class="galeria" id="galeria">
                        <div class="slider-container">
                            <button class="slider-button left" onclick="moveSlide(-1)">&#10094;</button> <!-- Flecha izquierda -->
                            <div class="slider-wrapper">
                                <?php $i = 0; ?>
                                <?php while ($foto = mysqli_fetch_assoc($restul_fotos_galeria)) : ?>
                                    <img src="<?php echo 'admin/fotos/' . $foto['id_propiedad'] . '/' . $foto['nombre_foto'] ?>" onclick="abrirModal(this, <?php echo $i ?>)" alt="Imagen de galería" class="imagen-galeria">
                                    <?php $i++; ?>
                                <?php endwhile ?>
                            </div>
                            <button class="slider-button right" onclick="moveSlide(1)">&#10095;</button> <!-- Flecha derecha -->
                        </div>
                    </div>


                </section>
                <section class="descripcion">
                    <h3>Descripción general</h3>
                    <div class="fila">
                        <div class="dato">
                            <span class="header">
                                <i class="fa-solid fa-home"><span>Tipo propiedad</span></i> <!-- Ícono de tipo (casa) -->
                            </span>
                            <span class="valor"><?php echo obtenerTipo($propiedad['tipo']) ?></span>
                        </div>
                        <div class="dato">
                            <span class="header">
                                <i class="fa-solid fa-clipboard-check"><span>Clasificacion</span></i> <!-- Ícono de estado -->
                            </span>
                            <span class="valor"><?php echo $propiedad['estado'] ?></span>
                        </div>
                        <div class="dato">
                            <span class="header">
                                <i class="fa-solid fa-dollar-sign"><span>Valor propiedad</span></i> <!-- Ícono de precio -->
                            </span>
                            <span class="valor"><?php echo $propiedad['moneda'] ?> <?php echo number_format($propiedad['precio'], 0, '', '.') ?></span>
                        </div>
                        <div class="dato">
                            <span class="header">
                                <i class="fa-solid fa-bed"><span>Habts.</span></i> <!-- Ícono de habitaciones -->
                            </span>
                            <span class="valor"><?php echo $propiedad['habitaciones'] ?></span>
                        </div>
                        <div class="dato">
                            <span class="header">
                                <i class="fa-solid fa-bath"><span>Baños</span></i> <!-- Ícono de baños -->
                            </span>
                            <span class="valor"><?php echo $propiedad['banios'] ?></span>
                        </div>
                    </div>
                    <div class="fila">
                        <div class="dato">
                            <span class="header">
                                <i class="fa-solid fa-car"><span>Garage</span></i> <!-- Ícono de garage -->
                            </span>
                            <span class="valor"><?php echo $propiedad['garage'] ?></span>
                        </div>
                        <div class="dato">
                            <span class="header">
                                <i class="fa-solid fa-ruler-combined"><span>Area</span></i> <!-- Ícono de dimensiones -->
                            </span>
                            <span class="valor"><?php echo $propiedad['dimensiones'] ?> <?php echo $propiedad['dimensiones_tipo'] ?></span>
                        </div>
                        <div class="dato">
                            <span class="header">
                                <i class="fa-solid fa-layer-group"><span>No. Pisos</span></i> <!-- Ícono de pisos -->
                            </span>
                            <span class="valor"><?php echo $propiedad['pisos'] ?></span>
                        </div>
                        <div class="dato">
                            <span class="header">
                                <i class="fa-solid fa-city"><span>Ciudad/Pueblo</span></i> <!-- Ícono de ciudad -->
                            </span>
                            <span class="valor"><?php echo obtenerCiudad($propiedad['ciudad']) ?></span>
                        </div>
                        <div class="dato">
                            <span class="header">
                                <i class="fa-solid fa-flag"><span>Departamento</span></i> <!-- Ícono de país -->
                            </span>
                            <span class="valor"><?php echo obtenerDepartamento($propiedad['departamento']) ?></span>
                        </div>
                    </div>

                    <?php
                    // Descripción del predio
                    $descripcion = str_replace("\n", "<br>", $propiedad['descripcion']);
                    ?>
                    <hr>
                    <br>
                    <h3>Descripción Detallada e Inventario</h3>
                    <br>
                    <div class="descripcion-detallada">
                        <?php echo $descripcion; ?>
                    </div>
                </section>
                <section class="descripcion">
                    <h3>Datos detallados</h3>
                    <div class="fila">
                        <div class="dato">
                            <span class="header">
                                <i class="fa-solid fa-lightbulb"><span>Luz</span></i> <!-- Ícono de Luz -->
                            </span>
                            <span class="valor"><?php echo $propiedad['luz'] ?></span>
                        </div>
                        <div class="dato">
                            <span class="header">
                                <i class="fa-solid fa-tint"><span>Agua</span></i> <!-- Ícono de Agua -->
                            </span>
                            <span class="valor"><?php echo $propiedad['agua'] ?></span>
                        </div>
                        <div class="dato">
                            <span class="header">
                                <i class="fa-solid fa-fire"><span>Gas</span></i> <!-- Ícono de Gas -->
                            </span>
                            <span class="valor"><?php echo $propiedad['gas'] ?></span>
                        </div>
                        <div class="dato">
                            <span class="header">
                                <i class="fa-solid fa-wifi"><span>Internet</span></i> <!-- Ícono de Internet -->
                            </span>
                            <span class="valor"><?php echo $propiedad['internet'] ?></span>
                        </div>
                        <div class="dato">
                            <span class="header">
                                <i class="fa-solid fa-cloud-sun"><span>Clima</span></i> <!-- Ícono de Clima -->
                            </span>
                            <span class="valor"><?php echo $propiedad['clima'] ?></span>
                        </div>
                    </div>
                    <div class="fila">
                        <div class="dato">
                            <span class="header">
                                <i class="fa-solid fa-file-alt"><span>Docs. Transferencia</span></i> <!-- Ícono de Documentos de Transferencia -->
                            </span>
                            <span class="valor"><?php echo $propiedad['documentos_transferencia'] ?></span>
                        </div>
                        <div class="dato">
                            <span class="header">
                                <i class="fa-solid fa-exchange-alt"><span>¿Permuta?</span></i> <!-- Ícono de Permuta -->
                            </span>
                            <span class="valor"><?php echo $propiedad['permuta'] ?></span>
                        </div>
                    </div>
                </section>

                <section class="compartir">
                    <h3>Compartir esta propiedad</h3>
                    <a class="facebook" href="http://facebook.com/sharer.php?u=http://localhost/sapi/publicacion.php?idPublicacion=<?php echo $propiedad['id'] ?>" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>

                    <a class="whatsapp" href="whatsapp://send?text=http://paulopelegrina.com/publicacion.php?idPublicacion=<?php echo $propiedad['id'] ?>" data-action="share/whatsapp/share"> <i class="fa-brands fa-whatsapp"></i> </a>

                    <a class="instagram" href="https://www.instagram.com/create/story/?text=Mira%20esta%20propiedad%20!!!%20http://paulopelegrina.com/publicacion.php?idPublicacion=<?php echo $propiedad['id']; ?>" target="_blank"><i class="fa-brands fa-instagram"></i> </a>

                    <a class="x" href="https://twitter.com/intent/tweet?text=Mira%20esta%20propiedad%20!!!%20http://paulopelegrina.com/publicacion.php?idPublicacion=<?php echo $propiedad['id']; ?>" target="_blank"><i class="fa-brands fa-twitter"></i> </a>

                </section>
            </div>

            <div class="fila">
                <div class="maps2">
                    <h3 class="text-center"><b>Ubicación en Maps</b></h3>
                    <hr id="hr-all">
                    <div class="">
                        <?php echo $propiedad['ubicacion_url']; ?>
                    </div>
                </div>

                <div class="form-contacto-publicacion">
                    <form action="">
                        <h3 class="text-center"><b>Comuníquese con nosotros</b></h3>
                        <hr id="hr-all">
                        <br>
                        <div>
                            <label for="nombre">Nombre</label>
                            <input type="text" placeholder="Ingrese su nombre" name="nombre" required>
                        </div>
                        <div>
                            <label for="email">Dirección de Correo</label>
                            <input type="email" placeholder="Dirección de Correo" name="email" required>
                        </div>
                        <div>
                            <label for="telefono">Teléfono</label>
                            <input type="text" placeholder="Ingrese su teléfono" name="telefono">
                        </div>
                        <div>
                            <label for="mensaje">Consulta</label>
                            <textarea placeholder="Escriba su consulta" name="mensaje" required style="height: 150px; resize: none;"></textarea>

                        </div>
                        <input class="btn-send" type="submit" value="Enviar Mensaje" name="enviar">
                    </form>
                </div>
            </div>

            <!-- The Modal para visualizar la galería de fotos -->
            <div id="myModal" class="modal">
                <!-- Modal content -->
                <div class="modal-content">
                    <img src="" alt="" id="fotoModal">
                    <span class="close"></span>
                    <span onclick="anterior()"><i class="fa-solid fa-angles-left"></i></span>
                    <span onclick="proxima()"><i class="fa-solid fa-angles-right"></i></span>
                </div>
            </div>
        </div>

    </div>

    <footer>
        <?php include("contenido-footer.php") ?>
    </footer>

    <script src="script.js"></script>
    <script src="galeria-slider.js"></script>
    <script src="cambio_multimedia.js"></script>
</body>

</html>