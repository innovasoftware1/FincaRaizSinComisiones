<?php
include("funciones.php");

$limInferior = 0;
$id_ciudad = $_GET['ciudad'] ?? null;
$id_tipo = $_GET['tipo'] ?? null;
$estado = isset($_GET['estado']) ? (array)$_GET['estado'] : [];

$config = obtenerConfiguracion();
$result_ciudades = obtenerTodasLasCiudades();
$result_tipos = obtenerTodosLosTipos();

$result_propiedades = realizarBusqueda($id_ciudad, $id_tipo, $estado);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Venta de propiedades</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="estilo.css">

    <script>
        function cargarMasPropiedades(str) {
            var conexion;
            if (str == "") {
                document.getElementById("contenedor-propiedades").innerHTML = "";
                return;
            }
            if (window.XMLHttpRequest) {
                conexion = new XMLHttpRequest();
            }

            conexion.onreadystatechange = function() {
                if (conexion.readyState == 4 && conexion.status == 200) {
                    document.getElementById("contenedor-propiedades").innerHTML += conexion.responseText;
                    document.getElementById("botonCargarMas").value = parseInt(document.getElementById("botonCargarMas").value) + 6;
                }
            }

            conexion.open("GET", "maspropiedades.php?c=" + str, true);
            conexion.send();
        }

        const selectBtn = document.querySelector(".select-btn");
        const listItems = document.querySelector(".list-items");

        selectBtn.addEventListener("click", () => {
            selectBtn.classList.toggle("open");
        });

        const items = document.querySelectorAll(".item");
        items.forEach(item => {
            item.addEventListener("click", () => {
                item.classList.toggle("checked");

                const checked = document.querySelectorAll(".item.checked");
                const btnText = document.querySelector(".btn-text");

                if (checked.length > 0) {
                    btnText.innerText = `${checked.length} Seleccionados`;
                } else {
                    btnText.innerText = "Seleccionar Filtros";
                }
            });
        });
    </script>

</head>

<body class="page-propiedades">
    <div class="container">
        <?php include("header.php"); ?>

        <!-- Formulario de Búsqueda -->
        <div class="box-buscar-propiedades pos-centrada">
            <div class="box-interior">
                <p>Encuentra la propiedad que buscas</p>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
                    <div class="contenedor-botones">
                        <!-- Filtro Ciudad -->
                        <div class="filtro">
                            <div class="select-btn">
                                <span class="btn-text">Ubicación</span>
                                <span class="arrow-dwn"><i class="fa-solid fa-chevron-down"></i></span>
                            </div>
                            <div class="list-items">
                                <?php while ($row = mysqli_fetch_assoc($result_ciudades)) : ?>
                                    <div class="item">
                                        <input type="checkbox" name="ciudad[]" value="<?php echo $row['id']; ?>" <?php echo (in_array($row['id'], (array)$id_ciudad)) ? 'checked' : ''; ?>>
                                        <span class="item-text"><?php echo $row['nombre_ciudad']; ?></span>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        </div>

                        <!-- Filtro tipo ubicacion -->
                        <div class="filtro">
                            <div class="select-btn">
                                <span class="btn-text">Clasificacion</span>
                                <span class="arrow-dwn"><i class="fa-solid fa-chevron-down"></i></span>
                            </div>
                            <div class="list-items">
                                <div class="item">
                                    <input type="checkbox" name="estado[]" value="campestre" id="campestre" <?php echo (in_array('campestre', $estado)) ? 'checked' : ''; ?>>
                                    <span class="item-text">Campestre</span>
                                </div>
                                <div class="item">
                                    <input type="checkbox" name="estado[]" value="urbano" id="urbano" <?php echo (in_array('urbano', $estado)) ? 'checked' : ''; ?>>
                                    <span class="item-text">Urbano</span>
                                </div>
                            </div>
                        </div>

                        <!-- Filtro Tipo -->
                        <div class="filtro">
                            <div class="select-btn">
                                <span class="btn-text">Tipo de propiedad</span>
                                <span class="arrow-dwn"><i class="fa-solid fa-chevron-down"></i></span>
                            </div>
                            <div class="list-items">
                                <?php while ($row = mysqli_fetch_assoc($result_tipos)) : ?>
                                    <div class="item">
                                        <input type="checkbox" name="tipo[]" value="<?php echo $row['id']; ?>" <?php echo (in_array($row['id'], (array)$id_tipo)) ? 'checked' : ''; ?>>
                                        <span class="item-text"><?php echo $row['nombre_tipo']; ?></span>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        </div>

                        <!-- Filtro Más Filtros -->
                        <div class="filtro">
                            <div class="select-btn">
                                <span class="btn-text">Rango de precio</span>
                                <span class="arrow-dwn"><i class="fa-solid fa-chevron-down"></i></span>
                            </div>
                            <div class="list-items list-items-wide">

                                <!-- Rango de precios (min-max) -->
                                <div style="margin-bottom: 5px; height: 60px;">
                                    <input style="height: 30px;" type="text" id="precio_min" name="precio_min" placeholder="Valor minimo" value="<?php echo isset($_GET['precio_min']) ? $_GET['precio_min'] : ''; ?>" oninput="formatearNumero(this)" min="0" maxlength="16">
                                    <input style="margin-top: 5px; height: 30px;" type="text" id="precio_max" name="precio_max" placeholder="Valor maximo" value="<?php echo isset($_GET['precio_max']) ? $_GET['precio_max'] : ''; ?>" oninput="formatearNumero(this)" min="0" maxlength="16">
                                </div>
                                <!-- Filtro Habitaciones
                                <div class="filtro-titulo"><b>Habitaciones</b><hr></div>
                                <div class="item">
                                    <input type="checkbox" name="habitaciones[]" value="1" class="checkbox">
                                    <span class="item-text">1</span>
                                </div>
                                <div class="item">
                                    <input type="checkbox" name="habitaciones[]" value="2" class="checkbox">
                                    <span class="item-text">2</span>
                                </div>
                                <div class="item">
                                    <input type="checkbox" name="habitaciones[]" value="3" class="checkbox">
                                    <span class="item-text">3</span>
                                </div>
                                <div class="item">
                                    <input type="checkbox" name="habitaciones[]" value="4" class="checkbox">
                                    <span class="item-text">4+</span>
                                </div>

                                Filtro Baños
                                 <br>
                                <div class="filtro-titulo"><b>Baños</b><hr></div>
                                <div class="item">
                                    <input type="checkbox" name="banos[]" value="1" class="checkbox">
                                    <span class="item-text">1</span>
                                </div>
                                <div class="item">
                                    <input type="checkbox" name="banos[]" value="2" class="checkbox">
                                    <span class="item-text">2</span>
                                </div>
                                <div class="item">
                                    <input type="checkbox" name="banos[]" value="3" class="checkbox">
                                    <span class="item-text">3</span>
                                </div>
                                <div class="item">
                                    <input type="checkbox" name="banos[]" value="4" class="checkbox">
                                    <span class="item-text">4+</span>
                                </div> -->
                            </div>
                        </div>
                    </div>

                    <input class="btn-buscar-filtro" type="submit" value="Buscar" name="buscar">
                </form>
            </div>
        </div>

        <h3>Resultados de la Búsqueda: <span><?php echo obtenerCiudad($id_ciudad) . " | " . obtenerTipo($id_tipo) . " | " . implode(", ", $estado); ?></span></h3>
        <h2 class="titulo-seccion"><b>Propiedades Destacadas</b></h2>

        <div class="contenedor-propiedades" id="contenedor-propiedades">
            <?php while ($propiedad = mysqli_fetch_assoc($result_propiedades)) : ?>
                <form action="publicacion.php" method="get" id="<?php echo $propiedad['id']; ?>">
                    <input type="hidden" value="<?php echo $propiedad['id']; ?>" name="idPropiedad">
                    <div class="contenedor-propiedad" onclick="document.getElementById('<?php echo $propiedad['id']; ?>').submit();">
                        <div class="contenedor-img">
                            <img src="<?php echo 'admin/' . $propiedad['url_foto_principal']; ?>" alt="">
                            <div class="estado"><?php echo $propiedad['estado']; ?></div>
                        </div>
                        <div class="info">
                            <h2><?php echo $propiedad['titulo']; ?></h2>
                            <p><i class="fa-solid fa-location-pin"></i><?php echo $propiedad['ubicacion']; ?></p>
                            <span class="precio"><?php echo $propiedad['moneda']; ?> <?php echo number_format($propiedad['precio'], 0, '', '.'); ?></span>
                            <hr>
                            <table>
                                <tr>
                                    <th>Habts.</th>
                                    <th>Baños</th>
                                    <th>Área</th>
                                </tr>
                                <tr>
                                    <td><?php echo $propiedad['habitaciones']; ?></td>
                                    <td><?php echo $propiedad['banios']; ?></td>
                                    <td><?php echo $propiedad['dimensiones']; ?> <?php echo $propiedad['dimensiones_tipo'] ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </form>
            <?php endwhile; ?>
        </div>

        <button value="0" onclick="cargarMasPropiedades(this.value)" id="botonCargarMas">Ver Más</button>
    </div>

    <footer class="inferior">
        <?php include("contenido-footer.php"); ?>
    </footer>

    <script src="script.js"></script>
    <script src="filtros-dropdown.js"></script>
    <script>
        function formatearNumero(input) {
            // Eliminar todos los caracteres no numéricos
            const valorSinFormato = input.value.replace(/\D/g, '');

            // Formatear el número agregando puntos
            const valorFormateado = valorSinFormato.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

            // Asignar el valor formateado al input
            input.value = valorFormateado;
        }
    </script>

</body>

</html>