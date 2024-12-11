<?php
include("admin/conexion.php");
include("funciones.php");

$i = 0;

/* $config = obtenerConfiguracion(); */

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
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="estilo.css">
</head>

<!-- icono de whatsapp inicio -->
<a id="whatsapp-link" href="#" target="_blank" class="float">
    <i class="fab fa-whatsapp my-float"></i>
</a>
<div id="tooltip" class="tooltip"><b>¡Contáctanos por WhatsApp!</b></div>


<script>
    let enlaceWhatsApp = document.getElementById('whatsapp-link');
    let urlPropiedad = window.location.href;
    let textoWhatsApp = `Quiero%20más%20información%20acerca%20de%20esta%20propiedad:%20${encodeURIComponent(urlPropiedad)}`;
    enlaceWhatsApp.href = `https://api.whatsapp.com/send?phone=573102499843&text=${textoWhatsApp}`;
</script>

<!-- icono de whatsapp final -->

<body class="page-publicacion">
    <div class="container">
        <?php include("header.php"); ?>

        <div class="contenedor-principal">
            <div class="info-publicacion">
                <section class="info-principal-galeria">
                    <div class="dato1 datoresponsive">
                        <span class="tipoUbicacion"><?php echo obtenerTipo($propiedad['tipo']) ?> - <?php echo $propiedad['tipoUbicacion'] ?></span>
                        <span class="precio"><?php echo $propiedad['moneda'] ?> <?php echo number_format($propiedad['precio'], 0, '', '.') ?></span>
                    </div>
                    <h2><?php echo $propiedad['titulo'] ?></h2>
                    <p>
                        <i class="fa-solid fa-location-pin"></i>
                        <?php echo $propiedad['ubicacion'] . ", " . obtenerCiudad($propiedad['ciudad']) . ", " . obtenerDepartamento($propiedad['departamento']) ?>
                    </p>
                    <br>
                    <div class="dato1">
                        <span class="tipoUbicacion">Permuta: <?php echo $propiedad['permuta'] == 1 ? 'Sí' : 'No'; ?></span>
                        <span class="tipoUbicacion">
                            <p>Financiaciòn: <?php echo $propiedad['financiacion'] == 1 ? 'Sí' : 'No'; ?>
                        </span>
                    </div>
                    <div class="botones-galeria">
                        <button class="btn-general" onclick="mostrarFotos()">Fotografia</button>
                        <button class="btn-general" onclick="mostrarRecorrido()">Recorrido 360</button>
                        <button class="btn-general" onclick="mostrarVideo()">Video</button>
                    </div>
                    <div class="contenedor-imagen-principal">
                        <img id="imagen-principal" src="<?php echo "admin/property/" . $propiedad['url_foto_principal'] ?>" alt="Imagen principal">
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
                                    <img src="<?php echo 'admin/property/fotos/' . $foto['id_propiedad'] . '/' . $foto['nombre_foto'] ?>" onclick="abrirModal(this, <?php echo $i ?>)" alt="Imagen de galería" class="imagen-galeria">
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
                                <i class="fa-solid fa-chart-area"><span>Area</span></i> <!-- Ícono de dimensiones -->
                            </span>
                            <span class="valor"><?php echo $propiedad['dimensiones'] ?></span>
                        </div>
                        <div class="dato">
                            <span class="header">
                                <i class="fa-solid fa-ruler-combined"><span>Dimensiones</span></i> <!-- Ícono de dimensiones -->
                            </span>
                            <span class="valor"><?php echo $propiedad['area'] ?> <?php echo $propiedad['dimensiones_tipo'] ?></span>
                        </div>
                        <div class="dato">
                            <span class="header">
                                <i class="fa-solid fa-house"></class><span>Tipo propiedad</span></i> <!-- Ícono de tipo (casa) -->
                            </span>
                            <span class="valor"><?php echo obtenerTipo($propiedad['tipo']) ?></span>
                        </div>
                        <div class="dato">
                            <span class="header">
                                <i class="fa-solid fa-clipboard-check"><span>Clasificacion</span></i> <!-- Ícono de estado -->
                            </span>
                            <span class="valor"><?php echo $propiedad['tipoUbicacion'] ?></span>
                        </div>
                    </div>
                    <div class="fila">
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
                            <span class="valor"><?php echo $propiedad['habitaciones'] ?> habitacion(es)</span>
                        </div>
                        <div class="dato">
                            <span class="header">
                                <i class="fa-solid fa-bath"><span>Baños</span></i> <!-- Ícono de baños -->
                            </span>
                            <span class="valor"><?php echo $propiedad['banios'] ?> baño(s)</span>
                        </div>
                        <div class="dato">
                            <span class="header">
                                <i class="fa-solid fa-car"><span>Garage</span></i> <!-- Ícono de garage -->
                            </span>
                            <span class="valor">
                                <P><?php echo $propiedad['garage'] ?> garaje(s)</P>
                            </span>
                        </div>
                    </div>
                    <div class="fila">
                        <div class="dato">
                            <span class="header">
                                <i class="fa-solid fa-layer-group"><span>No. Pisos</span></i> <!-- Ícono de pisos -->
                            </span>
                            <span class="valor"><?php echo $propiedad['pisos'] ?> plantas</span>
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
                        <div class="dato">
                            <span class="header">
                                <i class="fa-solid fa-exchange-alt"><span> ¿Permuta?</span></i> <!-- Ícono de Permuta -->
                            </span>
                            <span>
                                <p><?php echo $propiedad['permuta'] == 1 ? 'Sí' : 'No'; ?>, permuta.</p>
                            </span>
                        </div>
                    </div>

                    <?php
                    // Descripción del predio
                    $descripcion = str_replace("\n", "<br>", $propiedad['descripcion']);
                    ?>
                    <hr>
                    <br>
                    <h3><i class="fa-solid fa-audio-description"></i> Descripción Detallada</h3>
                    <br>
                    <div class="descripcion-detallada">
                        <?php echo $descripcion; ?>
                    </div>

                    <?php
                    // Inventario del predio
                    $inventario = str_replace("\n", "<br>", $propiedad['inventario']);
                    ?>
                    <br>
                    <hr>
                    <br>
                    <h3><i class="fa-solid fa-check-to-slot"></i> Inventario detallado</h3>
                    <br>
                    <div class="descripcion-detallada">
                        <?php echo $inventario; ?>
                    </div>
                </section>

                <!-- contenedor sub-propiedades en caso de haber -->
                <div class="info-publicacion">
                    <?php
                    $id_propiedad = $_GET['idPropiedad'];

                    $propiedad = obtenerPropiedadPorId($id_propiedad);

                    $subpropiedades = obtenerSubpropiedadesPorIdPropiedad($id_propiedad);

                    if (!empty($subpropiedades)) {
                        echo '<section class="info-principal-galeria subpro">';

                        foreach ($subpropiedades as $subpropiedad) {
                            $id_subpropiedad = $subpropiedad['id'];
                            $titulo_subpro = htmlspecialchars($subpropiedad['titulo']);
                            $descripcion_subpro = htmlspecialchars($subpropiedad['descripcion']);
                            $area_subpro = htmlspecialchars($subpropiedad['area']);
                            $area_tipo_subpro = htmlspecialchars($subpropiedad['area_tipo']);
                            $dimensiones_subpro = htmlspecialchars($subpropiedad['dimensiones']);
                            $precio_subpro = htmlspecialchars($subpropiedad['moneda']) . " " . number_format($subpropiedad['precio'], 0, '', '.');
                            $imagen_subpro = "admin/subproperties/" . htmlspecialchars($subpropiedad['url_foto_principal']);
                            $video_url_subpro = htmlspecialchars($subpropiedad['video_url']);
                            $recorrido_360_url_subpro = htmlspecialchars($subpropiedad['recorrido_360_url']);

                            $galeria_fotos_subpro = obtenerFotosSubpropiedad($id_subpropiedad);

                            $galeria_fotos_urls_subpro = [];

                            while ($foto = mysqli_fetch_assoc($galeria_fotos_subpro)) {
                                $foto_url_subpro = "admin/subproperties/fotos/" . $id_subpropiedad . "/" . htmlspecialchars($foto['nombre_foto']);
                                $galeria_fotos_urls_subpro[] = $foto_url_subpro;
                            }

                            $galeria_fotos_json_subpro = json_encode($galeria_fotos_urls_subpro);
                    ?>

                            <!-- Card de la subpropiedad -->
                            <div class="card-subpropiedad" style="background-image: url('<?php echo $imagen_subpro; ?>'); background-size: cover; background-position: center; opacity: 0.8; position: relative; border-radius: 10px;">
                                <div class="contenido">
                                    <h2 class="titulo-subpro"><?php echo $titulo_subpro; ?></h2>
                                    <p class="precio-subpro"><?php echo $precio_subpro; ?></p>

                                    <!-- Botones de iconos -->
                                    <button class="btn-icon" onclick="abrirModalDetalles( '<?php echo $titulo_subpro; ?>', '<?php echo $descripcion_subpro; ?>', '<?php echo $area_subpro; ?>', '<?php echo $area_tipo_subpro; ?>', '<?php echo $dimensiones_subpro; ?>', '<?php echo $precio_subpro; ?>')">
                                        <i class="fa fa-file"></i> <!-- Detalles -->
                                    </button>


                                    <!-- Botón de la galería -->
                                    <button class="btn-icon" onclick='abrirModalGaleriaSubpro(<?php echo $id_subpropiedad; ?>, <?php echo $galeria_fotos_json_subpro; ?>)'>
                                        <i class="fa fa-image"></i>
                                    </button>

                                    <!-- Botón de recorrido 360 -->
                                    <button class="btn-icon" onclick="abrirModalRecorrido360('<?php echo $recorrido_360_url_subpro; ?>')">
                                        <i class="fa-solid fa-person"></i> <!-- Recorrido 360 -->
                                        <div class="circle-below"></div> <!-- Círculo debajo -->
                                    </button>

                                    <!-- Botón del video -->
                                    <button class="btn-icon" onclick="abrirModalVideo('<?php echo $video_url_subpro; ?>')">
                                        <i class="fa fa-video-camera"></i> <!-- Video -->
                                    </button>
                                </div>
                            </div>

                    <?php
                        }
                        echo '</section>';
                    }
                    ?>
                </div>

                <section class="descripcion" style="margin-top: 2.5%;">
                    <h3>Usos de suelos</h3>

                    <?php
                    // usos principales
                    $uso_principal = str_replace("\n", "<br>", $propiedad['uso_principal']);
                    ?>
                    <br>
                    <h3 class="sub-titulo"><i class="fa-solid fa-file-powerpoint"></i> Usos Principales</h3>
                    <div class="descripcion-detallada">
                        <?php echo $uso_principal; ?>
                    </div>

                    <?php
                    // usos compatibles
                    $uso_compatibles = str_replace("\n", "<br>", $propiedad['uso_compatibles']);
                    ?>
                    <br>
                    <hr>
                    <br>
                    <h3 class="sub-titulo"><i class="fa-solid fa-file-code"></i> Usos Compatibles</h3>
                    <div class="descripcion-detallada">
                        <?php echo $uso_compatibles; ?>
                    </div>

                    <?php
                    // usos condicionales
                    $uso_condicionales = str_replace("\n", "<br>", $propiedad['uso_condicionales']);
                    ?>
                    <br>
                    <hr>
                    <br>
                    <h3 class="sub-titulo"><i class="fa-solid fa-file-excel"></i> </i> Usos Condicionales</h3>
                    <div class="descripcion-detallada">
                        <?php echo $uso_condicionales; ?>
                    </div>
                </section>
                <!-- valor agregado de la propiedad -inicial -->
                <section class="descripcion">
                    <h3>Valor agregado del predio</h3>

                    <?php
                    // usos principales
                    $construcciones_aledañas = str_replace("\n", "<br>", $propiedad['construcciones_aledañas']);
                    ?>
                    <br>
                    <h3 class="sub-titulo"><i class="ri-community-fill"></i> Construcciones aledañas</h3>
                    <div class="descripcion-detallada">
                        <?php echo $construcciones_aledañas; ?>
                    </div>

                    <?php
                    // usos compatibles
                    $caracteristicas_positivas = str_replace("\n", "<br>", $propiedad['caracteristicas_positivas']);
                    ?>
                    <br>
                    <hr>
                    <br>
                    <h3 class="sub-titulo"><i class="fa-solid fa-square-plus"></i> Caracteristicas positivas</h3>
                    <div class="descripcion-detallada">
                        <?php echo $caracteristicas_positivas; ?>
                    </div>
                </section>
                <!-- valor agregado de la propiedad -final -->

                <section class="compartir">
                    <h3>Compartir esta propiedad</h3>
                    <a class="facebook" href="http://facebook.com/sharer.php?u=http://localhost/sapi/publicacion.php?idPublicacion=<?php echo $propiedad['id'] ?>" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>

                    <a class="whatsapp" href="whatsapp://send?text=http://paulopelegrina.com/publicacion.php?idPublicacion=<?php echo $propiedad['id'] ?>" data-action="share/whatsapp/share"> <i class="fa-brands fa-whatsapp"></i> </a>

                    <a class="instagram" href="https://www.instagram.com/create/story/?text=Mira%20esta%20propiedad%20!!!%20http://paulopelegrina.com/publicacion.php?idPublicacion=<?php echo $propiedad['id']; ?>" target="_blank"><i class="fa-brands fa-instagram"></i> </a>

                    <a class="x" href="https://twitter.com/intent/tweet?text=Mira%20esta%20propiedad%20!!!%20http://paulopelegrina.com/publicacion.php?idPublicacion=<?php echo $propiedad['id']; ?>" target="_blank"><i class="fa-brands fa-x-twitter">𝕏</i> </a>

                </section>
            </div>

            <div class="fila content-mp">

                <!-- ubicacion de googleMaps - inicial -->
                <div class="maps2">
                    <h3 class="text-center"><b>Ubicación en Maps</b></h3>
                    <hr id="hr-all">
                    <div class="">
                        <?php echo $propiedad['ubicacion_url']; ?>
                    </div>
                </div>
                <!-- ubicacion de googleMaps - final -->

                <!-- datos tecnicos - inicial -->
                <div class="form-contacto-publicacion">
                    <h3>Datos técnicos</h3>
                    <hr>
                    <br>
                    <br>
                    <div class="fila">
                        <div class="dato">
                            <span class="header">
                                <i class="fa-solid fa-lightbulb color"><span> Luz</span></i> <!-- Ícono de Luz -->
                            </span>
                            <span><?php echo $propiedad['luz'] ?></span>
                        </div>
                        <div class="dato">
                            <span class="header">
                                <i class="fa-solid fa-tint"><span> Agua</span></i> <!-- Ícono de Agua -->
                            </span>
                            <span><?php echo $propiedad['agua_propia'] ?></span>
                        </div>
                        <div class="dato">
                            <span class="header">
                                <i class="fa-solid fa-fire"><span> Gas</span></i> <!-- Ícono de Gas -->
                            </span>
                            <span><?php echo $propiedad['gas'] ?></span>
                        </div>
                        <div class="dato">
                            <span class="header">
                                <i class="fa-solid fa-wifi"><span> Internet</span></i> <!-- Ícono de Internet -->
                            </span>
                            <span><?php echo $propiedad['internet'] ?></span>
                        </div>
                        <div class="dato">
                            <span class="header">
                                <i class="fa-solid fa-cloud-sun"><span> Clima</span></i> <!-- Ícono de Clima -->
                            </span>
                            <br>
                            <span><?php echo $propiedad['clima'] ?></span>
                        </div>
                    </div>
                    <div class="fila">
                        <div class="dato">
                            <span class="header">
                                <i class="fa-solid fa-water"><span> Altitud</span></i> <!-- Ícono de Documentos de altitud -->
                            </span>
                            <span><?php echo $propiedad['altitud'] ?> m.s.n.m.</span>
                        </div>
                        <div class="dato">
                            <span class="header">
                                <i class="fa-solid fa-file-alt"><span> Docs. Transferencia</span></i> <!-- Ícono de Documentos de Transferencia -->
                            </span>
                            <br>
                            <span><?php echo $propiedad['documentos_transferencia'] ?></span>
                        </div>
                    </div>
                </div>
                <!-- datos tecnicos - final -->


                <!-- condiciones adicionales del predio - -inicial -->
                <div class="form-contacto-publicacion">
                    <h3>Caracteristicas</h3>
                    <hr>
                    <br>

                    <?php
                    // usos principales
                    $distancia_pueblo = str_replace("\n", "<br>", $propiedad['distancia_pueblo']);
                    ?>
                    <br>
                    <h3 class="sub-titulo"><i class="fa-solid fa-tape"></i> Distancia al pueblo</h3>
                    <div class="descripcion-detallada">
                        <p>a <b><?php echo $distancia_pueblo; ?></b> Kilometros del pueblo</p>
                    </div>

                    <?php
                    // usos compatibles
                    $vias_acceso = str_replace("\n", "<br>", $propiedad['vias_acceso']);
                    ?>
                    <br>
                    <h3 class="sub-titulo"><i class="fa-solid fa-road"></i> Vías de acceso al predio</h3>
                    <div class="descripcion-detallada">
                        <?php echo $vias_acceso; ?>
                    </div>

                    <?php
                    // usos condicionales
                    $permisos = str_replace("\n", "<br>", $propiedad['permisos']);
                    ?>
                    <br>
                    <h3 class="sub-titulo"><i class="fa-solid fa-folder"></i> Permisos del predio</h3>
                    <div class="descripcion-detallada">
                        <p><b>Cuenta con perisos de:</b> <?php echo $permisos; ?></p>
                    </div>

                    <?php
                    // usos condicionales
                    $distancia_desde_bogota = str_replace("\n", "<br>", $propiedad['distancia_desde_bogota']);
                    ?>
                    <br>
                    <h3 class="sub-titulo"><i class="ri-pin-distance-fill"></i> Distancia desde Bogotá</h3>
                    <div class="descripcion-detallada">
                        <p>a <b><?php echo $distancia_desde_bogota; ?></b> kilometros de Bogotá</p>
                    </div>
                </div>
                <!-- condiciones adicionales del predio - final -->

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


            <!-- Modal para visualizar la galería de fotos -->
            <div id="myModal" class="modal">
                <div class="modal-content">
                    <img src="" alt="" id="fotoModal">
                    <span class="close"></span>
                    <span onclick="anterior()"><i class="fa-solid fa-angles-left"></i></span>
                    <span onclick="proxima()"><i class="fa-solid fa-angles-right"></i></span>
                </div>
            </div>

            <!-- Modal para visualizar la galería de fotos de la subpropiedad -->
            <div id="myModalGaleriaSubpro" class="modal" style="display: none;">
                <div class="modal-content">
                    <img id="fotoModalGaleriaSubpro" class="modal-content" src="">
                    <div id="galeriaGaleriaSubpro"></div>
                    <span onclick="anteriorSubpro()"><i class="fa-solid fa-angles-left"></i></span>
                    <span onclick="proximaSubpro()"><i class="fa-solid fa-angles-right"></i></span>
                </div>
            </div>

            <!-- Modal para ver los detalles de la subpropiedad -->
            <div id="myModalDetalles" class="modal" style="display: none;">
                <div class="modal-content" style="max-width: 400px; max-height: 300px; padding: 50px;">
                    <p style="font-size: 16px; color: #555; line-height: 1.6;"><strong>Titulo:</strong> <span id="titulo"></span></p>
                    <p style="font-size: 16px; color: #555; line-height: 1.6;"><strong>Descripcion:</strong> <span id="descripcion"></span></p>
                    <p style="font-size: 16px; color: #555; line-height: 1.6;"><strong>Area:</strong> <span id="area"></span> <span id="area_tipo"></span></p>
                    <p style="font-size: 16px; color: #555; line-height: 1.6;"><strong>Dimensiones:</strong> <span id="dimensiones"></span></p>
                    <p style="font-size: 16px; color: #555; line-height: 1.6;"><strong>Precio:</strong> <span id="precio"></span></p>
                </div>
            </div>






            <!-- Modal para el video -->
            <div id="myModalVideo" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="cerrarModalVideo()">&times;</span>
                    <iframe style="border-radius: 5px;" id="videoModal" width="100%" height="100%" border-radius="10px" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>

            <!-- Modal para el recorrido 360 -->
            <div id="myModalRecorrido360" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="cerrarModalRecorrido360()">&times;</span>
                    <iframe style="border-radius: 5px;" id="recorrido360Modal" width="100%" height="100%" frameborder="0" allowfullscreen></iframe>
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
    <script src="tooltip-whatsapp.js"></script>
    <script src="modal-galeria.js"></script>

    <script>

    </script>
</body>

</html>