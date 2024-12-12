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

    if (!$id_propiedad) {
        echo "ID de subpropiedad no especificado.";
        exit();
    }



    $query = "SELECT * FROM subpropiedades WHERE id='$id_propiedad'";
    $resultado_subpropiedades = mysqli_query($conn, $query);
    $fila = mysqli_fetch_assoc($resultado_subpropiedades);





    // Define la función para obtener las fotos de la galería
    function obtenerFotosGaleria($idPropiedad) {
        global $conn;
        $query = "SELECT * FROM subfotos WHERE id_subpropiedad = '$idPropiedad'";
        $resultado = mysqli_query($conn, $query);
        if (!$resultado) {
            echo "Error en la consulta de fotos: " . mysqli_error($conn);
            return [];
        }
        return $resultado;
    }
    ?>

    <style>
        /* Estilo para centrar y agrandar el botón */
        .boton-volver {
            text-align: center; /* Centra el contenido dentro de la celda */
        }

        .btn-volver {
            font-size: 20px; /* Aumenta el tamaño de la fuente */
            background-color: #007bff; /* Color de fondo del botón */
            color: white; /* Color del texto */
            border: none; /* Elimina el borde */
            border-radius: 5px; /* Bordes redondeados */
            cursor: pointer; /* Cambia el cursor a mano cuando se pasa por encima */
            transition: background-color 0.3s ease; /* Efecto de transición al pasar el ratón */
        }

        .btn-volver:hover {
            background-color: #0056b3; /* Color de fondo al pasar el ratón */
        }

    </style>

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

                    <!-- Información básica -->
                    <div class="contenedor-tabla">
                        <h3><i class="fa-solid fa-info-circle"></i> Información Básica</h3>
                        <br>
                        <table class="descripcion">
                            <tr><td>ID</td><td><?php echo $fila['id']; ?></td></tr>
                            <tr><td>Título</td><td><?php echo $fila['titulo']; ?></td></tr>
                            <tr><td>Descripción</td><td><?php echo $fila['descripcion']; ?></td></tr>
                            <tr><td>Estado</td><td><?php echo $fila['estado']; ?></td></tr>
                            <tr><td>Fecha de Alta</td><td><?php echo $fila['fecha_alta']; ?></td></tr>
                        </table>
                    </div>

                    <!-- Medidas -->
                    <div class="contenedor-tabla">
                        <h3><i class="fa-solid fa-ruler"></i> Medidas de la Subpropiedad</h3>
                        <br>
                        <table class="descripcion">
                            <tr><td>Tipo de Área</td><td><?php echo $fila['area_tipo']; ?></td></tr>
                            <tr><td>Dimensiones</td><td><?php echo $fila['dimensiones']; ?></td></tr>
                            <tr><td>Área</td><td><?php echo $fila['area']; ?></td></tr>
                        </table>
                    </div>

                    <!-- Detalles Financieros -->
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

                    <!-- Multimedia -->
                    <div class="contenedor-tabla">
                        <h3><i class="fa-solid fa-camera-retro"></i> Multimedia</h3>
                        <br>
                        <table class="descripcion">
                        <tr>
                            <td>Foto Principal</td>
                            <td>
                                <img src="<?php echo htmlspecialchars($fila['url_foto_principal']); ?>" alt="Foto" width="200">
                            </td>
                        </tr>

                        <br>
                        <tr>
                            <td>Galeria</td>
                            <td colspan="2">
                                <div class="galeria">
                                    <?php 
                                    $resultFotos = obtenerFotosGaleria($fila['id']); 
                                    if ($resultFotos && mysqli_num_rows($resultFotos) > 0) {
                                        while ($foto = mysqli_fetch_assoc($resultFotos)) : ?>
                                            <img src="fotos/<?php echo $fila['id'] . "/" . htmlspecialchars($foto['nombre_foto']); ?>" alt="Foto">
                                        <?php endwhile; 
                                    } else {
                                        echo "<p>No hay fotos disponibles.</p>";
                                    }
                                    ?>
                                </div>
                            </td>
                        </tr>


                        <tr>
                            <td>Video</td>
                            <td>
                                <?php 
                                if (!empty($fila['video_url'])) :
                                    // Verifica que la URL contenga <iframe> como una medida de seguridad
                                    if (strpos($fila['video_url'], '<iframe') !== false) {
                                        echo $fila['video_url']; // Imprime el iframe directamente
                                    } else {
                                        echo "El contenido del video no es válido.";
                                    }
                                else :
                                    echo "No disponible";
                                endif;
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <td>Recorrido 360</td>
                            <td>
                                <?php if (!empty($fila['recorrido_360_url'])) : ?>
                                    <iframe src="<?php echo $fila['recorrido_360_url']; ?>" width="560" height="300" frameborder="0" allowfullscreen></iframe>
                                <?php else : ?>
                                    No disponible
                                <?php endif; ?>
                                <br><br>
                            </td>
                            
                        </tr>
                     
                        <tr>
                            <td colspan="2" class="boton-volver">
                                <button onclick="window.location.href='../ver-detalle-propiedad.php?propiedad_id=<?php echo $fila['propiedad_id']; ?>';" class="btn-accion" type="button">Volver</button>
                            </td>
                        </tr>

                       
                    </table>

                    
                    </div>  
                </div>
            </div>
        </div>
    </body>
    </html>
    
