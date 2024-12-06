<?php
include("funciones.php");

$limInferior = 0;
$id_ciudad = $_GET['ciudad'] ?? null;
$id_tipo = $_GET['tipo'] ?? null;
$tipoUbicacion = isset($_GET['tipoUbicacion']) ? (array)$_GET['tipoUbicacion'] : [];


$precio_min = isset($_GET['precio_min']) ? $_GET['precio_min'] : null;
$precio_max = isset($_GET['precio_max']) ? $_GET['precio_max'] : null;


$result_propiedades = realizarBusqueda($id_ciudad, $id_tipo, $tipoUbicacion, $precio_min, $precio_max);

/* $config = obtenerConfiguracion(); */
$result_ciudades = obtenerTodasLasCiudades();
$result_tipos = obtenerTodosLosTipos();
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

<!-- icono de whatsapp inicio -->
<a href="https://api.whatsapp.com/send?phone=573102499843&text=Quiero%20más%20información%20acerca%20de..."
    target="_blank" class="float">
    <i class="fab fa-whatsapp my-float"></i>
</a>
<div id="tooltip" class="tooltip"><b>¡Contáctanos por WhatsApp!</b></div>
<!-- icono de whatsapp final -->

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
                                    <input type="checkbox" name="tipoUbicacion[]" value="campestre" id="campestre" <?php echo (in_array('campestre', $tipoUbicacion)) ? 'checked' : ''; ?>>
                                    <span class="item-text">Campestre</span>
                                </div>
                                <div class="item">
                                    <input type="checkbox" name="tipoUbicacion[]" value="urbano" id="urbano" <?php echo (in_array('urbano', $tipoUbicacion)) ? 'checked' : ''; ?>>
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

                        <!-- Filtro Rango de Precio -->
                        <div class="filtro">
                            <div class="select-btn">
                                <span class="btn-text">Precio</span>
                                <span class="arrow-dwn"><i class="fa-solid fa-chevron-down"></i></span>
                            </div>
                            <div class="list-items">
                                <div class="item">
                                    <input type="number" name="precio_min" id="precio_min" placeholder="Precio mínimo"
                                        value="<?php echo isset($_GET['precio_min']) ? htmlspecialchars($_GET['precio_min']) : ''; ?>"
                                        min="0" step="0.01">
                                </div>
                                <div class="item">
                                    <input type="number" name="precio_max" id="precio_max" placeholder="Precio máximo"
                                        value="<?php echo isset($_GET['precio_max']) ? htmlspecialchars($_GET['precio_max']) : ''; ?>"
                                        min="0" step="0.01">
                                </div>
                                <div id="error-message" class="error-message"></div>
                                <button type="submit" onclick="return validarPrecio()">Aplicar filtro</button>
                            </div>
                        </div>
                    </div>

                    <input class="btn-buscar-filtro" type="submit" value="Buscar" name="buscar">
                </form>
            </div>
        </div>

        <!--  -->
        <h2 class="titulo-seccion"><b>Propiedades Destacadas</b></h2>

        <div class="contenedor-propiedades" id="contenedor-propiedades">
            <?php if (mysqli_num_rows($result_propiedades) > 0): ?>
                <?php while ($propiedad = mysqli_fetch_assoc($result_propiedades)) : ?>
                    <form action="publicacion.php" method="get" id="<?php echo $propiedad['id']; ?>">
                        <input type="hidden" value="<?php echo $propiedad['id']; ?>" name="idPropiedad">
                        <div class="contenedor-propiedad" onclick="document.getElementById('<?php echo $propiedad['id']; ?>').submit();">
                            <div class="contenedor-img">
                                <img src="<?php echo 'admin/property/' . $propiedad['url_foto_principal']; ?>" alt="">
                                <div class="tipoUbicacion"><?php echo $propiedad['tipoUbicacion']; ?></div>
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
            <?php else: ?>
                <div class="sin-resultados" style="text-align: center;">
                    <img src="img/none.svg" alt="Sin resultados" width="100" height="100">
                    <p style="color: #c7c7c7; font-weight: bold;">No se encontraron propiedades con los filtros seleccionados.</p>
                </div>

            <?php endif; ?>
        </div>

        <button value="0" onclick="cargarMasPropiedades(this.value)" id="botonCargarMas">Ver Más</button>
    </div>

    <footer class="inferior">
        <?php include("contenido-footer.php"); ?>
    </footer>

    <script src="script.js"></script>
    <script src="filtros-dropdown.js"></script>
    <script>
        function validarPrecio() {
            const precioMin = document.getElementById('precio_min');
            const precioMax = document.getElementById('precio_max');
            const errorMessage = document.getElementById('error-message');

            errorMessage.textContent = '';
            errorMessage.style.color = 'red';
            errorMessage.style.fontSize = '12px';

            let valid = true;

            if (isNaN(precioMin.value) || isNaN(precioMax.value)) {
                valid = false;
                errorMessage.textContent = 'Por favor, ingrese valores numéricos válidos.';
            } else if (precioMin.value < 0 || precioMax.value < 0) {
                valid = false;
                errorMessage.textContent = 'Los precios no pueden ser negativos.';
            } else if (parseFloat(precioMin.value) > parseFloat(precioMax.value)) {
                valid = false;
                errorMessage.textContent = 'El precio máximo no puede ser menor al precio mínimo.';
            }

            return valid;
        }
    </script>
</body>

</html>