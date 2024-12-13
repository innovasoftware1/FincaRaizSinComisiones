<?php
include("funciones.php");

/* $config = obtenerConfiguracion(); */
$result_ciudades = obtenerTodasLasCiudades();
$result_tipos = obtenerTodosLosTipos();

$busqueda = isset($_GET['busqueda']) ? trim($_GET['busqueda']) : '';

$tipoUbicacion = isset($_GET['tipoUbicacion']) ? $_GET['tipoUbicacion'] : 'Venta';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fincaraizsincomisiones.com</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="estilo.css">
</head>
<style>
    .select-btn {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #f0f0f0;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        cursor: pointer;
        overflow: hidden;
    }

    .select-btn .btn-text {
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
        max-width: 200px;
    }
</style>

<body class="home" id="home">

    <!-- icono de whatsapp inicio -->
    <a href="https://api.whatsapp.com/send?phone=573102499843&text=Quiero%20más%20información..."
        target="_blank" class="float">
        <i class="fab fa-whatsapp my-float"></i>
    </a>
    <div id="tooltip" class="tooltip"><b>¡Contáctanos por WhatsApp!</b></div>
    <!-- icono de whatsapp final -->

    <div class="container">
        <?php include("header.php"); ?>

        <h2>"Donde tus sueños encuentran su lugar<br> ideal, al mejor precio."</h2>

        <div class="box-buscar-propiedades pos-inferior">
            <div class="box-interior">
                <p>¿Dónde quieres comprar?</p>
                <form action="propiedades.php" method="get">
                    <div class="contenedor-botones">
                        <!-- Filtro de Ciudad -->
                        <div class="filtro">
                            <div class="select-btn select-btn-filtro">
                                <span class="btn-text" id="ubicacion-text">Ubicación</span>
                                <span class="arrow-dwn"><i class="fa-solid fa-chevron-down"></i></span>
                            </div>
                            <div class="list-items list-items-filtro">
                                <?php while ($row = mysqli_fetch_assoc($result_ciudades)) : ?>
                                    <div class="item item-filtro">
                                        <input type="checkbox" name="ciudad[]" value="<?php echo $row['id']; ?>" class="checkbox" onchange="updateFilterText('ubicacion', 'ciudad[]')">
                                        <span class="item-text"><?php echo $row['nombre_ciudad']; ?></span>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        </div>

                        <!-- Filtro de Tipo de Propiedad -->
                        <div class="filtro">
                            <div class="select-btn select-btn-filtro">
                                <span class="btn-text" id="tipo-text">Tipo de propiedad</span>
                                <span class="arrow-dwn"><i class="fa-solid fa-chevron-down"></i></span>
                            </div>
                            <div class="list-items list-items-filtro">
                                <?php while ($row = mysqli_fetch_assoc($result_tipos)) : ?>
                                    <div class="item item-filtro">
                                        <input type="checkbox" name="tipo[]" value="<?php echo $row['id']; ?>" class="checkbox" onchange="updateFilterText('tipo', 'tipo[]')">
                                        <span class="item-text"><?php echo $row['nombre_tipo']; ?></span>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        </div>

                        <!-- Filtro Tipo ubicación -->
                        <div class="filtro">
                            <div class="select-btn select-btn-filtro">
                                <span class="btn-text" id="tipo-ubicacion-text">Tipo ubicación</span>
                                <span class="arrow-dwn"><i class="fa-solid fa-chevron-down"></i></span>
                            </div>
                            <div class="list-items list-items-filtro">
                                <div class="item item-filtro">
                                    <input type="checkbox" name="tipoUbicacion[]" value="campestre" id="campestre" class="checkbox" onchange="updateFilterText('tipo-ubicacion', 'tipoUbicacion[]')">
                                    <span class="item-text">Campestre</span>
                                </div>
                                <div class="item item-filtro">
                                    <input type="checkbox" name="tipoUbicacion[]" value="urbano" id="urbano" class="checkbox" onchange="updateFilterText('tipo-ubicacion', 'tipoUbicacion[]')">
                                    <span class="item-text">Urbano</span>
                                </div>
                            </div>
                        </div>

                        <!-- Filtro Rango de Precio -->
                        <div class="filtro">
                            <div class="select-btn">
                                <span class="btn-text" id="precio-text">Precio</span>
                                <span class="arrow-dwn"><i class="fa-solid fa-chevron-down"></i></span>
                            </div>
                            <div class="list-items">
                                <div class="item">
                                    <input type="number" name="precio_min" id="precio_min" placeholder="Precio mínimo"
                                        value="<?php echo isset($_GET['precio_min']) ? htmlspecialchars($_GET['precio_min']) : ''; ?>"
                                        min="0" step="0.01" onchange="updatePriceText()">
                                </div>
                                <div class="item">
                                    <input type="number" name="precio_max" id="precio_max" placeholder="Precio máximo"
                                        value="<?php echo isset($_GET['precio_max']) ? htmlspecialchars($_GET['precio_max']) : ''; ?>"
                                        min="0" step="0.01" onchange="updatePriceText()">
                                </div>
                                <div id="error-message" class="error-message"></div>
                                <button type="submit" onclick="return validarPrecio()">Aplicar filtro</button>
                            </div>
                        </div>

                        <script>
                            function updateFilterText(filterId, filterName) {
                                const selectedItems = [];
                                const checkboxes = document.querySelectorAll(`input[name="${filterName}"]:checked`);

                                checkboxes.forEach(checkbox => {
                                    selectedItems.push(checkbox.nextElementSibling.textContent); // Obtiene el texto del filtro
                                });

                                const filterText = selectedItems.length > 0 ? selectedItems.join(', ') : filterId.replace('-', ' ').toUpperCase();
                                document.getElementById(`${filterId}-text`).textContent = selectedItems.length > 2 ? selectedItems.slice(0, 2).join(', ') + '...' : filterText;
                            }

                            function updatePriceText() {
                                const minPrice = document.getElementById('precio_min').value;
                                const maxPrice = document.getElementById('precio_max').value;
                                let priceText = "Precio";

                                if (minPrice && maxPrice) {
                                    priceText = `De $${minPrice} a $${maxPrice}`;
                                } else if (minPrice) {
                                    priceText = `Desde $${minPrice}`;
                                } else if (maxPrice) {
                                    priceText = `Hasta $${maxPrice}`;
                                }

                                document.getElementById('precio-text').textContent = priceText;
                            }
                        </script>


                    </div>

                    <input class="btn-buscar-filtro" type="submit" value="Buscar" name="buscar">
                </form>
            </div>
        </div>
        <footer class="inferior2">
            <?php include("contenido-footer.php"); ?>
        </footer>
    </div>

</body>

<script src="script.js"></script>
<script src="filtros-dropdown.js"></script>
<script src="tooltip-whatsapp.js"></script>

</html>