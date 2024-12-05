<?php
include("funciones.php");

$config = obtenerConfiguracion();
$result_ciudades = obtenerTodasLasCiudades();
$result_tipos = obtenerTodosLosTipos();

$busqueda = isset($_GET['busqueda']) ? trim($_GET['busqueda']) : '';

$estado = isset($_GET['estado']) ? $_GET['estado'] : 'Venta';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fincaraizsincomisiones.com</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="estilo.css">
</head>

<body class="home" id="home">
    <div class="container">
        <?php include("header.php"); ?>

        <h2>Casas, fincas, departamentos <br> Al mejor precio.</h2>

        <div class="box-buscar-propiedades pos-inferior">
            <div class="box-interior">
                <p>¿Dónde quieres comprar?</p>
                <form action="propiedades.php" method="get">
                    <div class="contenedor-botones items-center">
                        <!-- Filtro de Ciudad -->
                        <div class="filtro">
                            <div class="select-btn select-btn-filtro">
                                <span class="btn-text">Ubicación</span>
                                <span class="arrow-dwn"><i class="fa-solid fa-chevron-down"></i></span>
                            </div>
                            <div class="list-items list-items-filtro">
                                <?php while ($row = mysqli_fetch_assoc($result_ciudades)) : ?>
                                    <div class="item item-filtro">
                                        <input type="checkbox" name="ciudad[]" value="<?php echo $row['id']; ?>" class="checkbox">
                                        <span class="item-text"><?php echo $row['nombre_ciudad']; ?></span>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        </div>

                        <!-- Filtro de Tipo de Propiedad -->
                        <div class="filtro">
                            <div class="select-btn select-btn-filtro">
                                <span class="btn-text">Tipo de propiedad</span>
                                <span class="arrow-dwn"><i class="fa-solid fa-chevron-down"></i></span>
                            </div>
                            <div class="list-items list-items-filtro">
                                <?php while ($row = mysqli_fetch_assoc($result_tipos)) : ?>
                                    <div class="item item-filtro">
                                        <input type="checkbox" name="tipo[]" value="<?php echo $row['id']; ?>" class="checkbox">
                                        <span class="item-text"><?php echo $row['nombre_tipo']; ?></span>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        </div>

                        <!-- Filtro de Estado -->
                        <div class="filtro">
                            <div class="select-btn select-btn-filtro">
                                <span class="btn-text">Tipo ubicacion</span>
                                <span class="arrow-dwn"><i class="fa-solid fa-chevron-down"></i></span>
                            </div>
                            <div class="list-items list-items-filtro">
                                <div class="item item-filtro">
                                    <input type="checkbox" name="estado[]" value="campestre" id="campestre" class="checkbox">
                                    <span class="item-text">Campestre</span>
                                </div>
                                <div class="item item-filtro">
                                    <input type="checkbox" name="estado[]" value="urbano" id="urbano" class="checkbox">
                                    <span class="item-text">Urbano</span>
                                </div>
                            </div>
                        </div>

                        <!-- Filtro de Más Filtros -->
                        <!-- <div class="filtro">
                            <div class="select-btn select-btn-filtro">
                                <span class="btn-text">Más filtros</span>
                                <span class="arrow-dwn"><i class="fa-solid fa-chevron-down"></i></span>
                            </div>
                            <div class="list-items list-items-filtro">
                                <div class="filtro-titulo"><b>Habitaciones</b></div>
                                <div class="item item-filtro">
                                    <input type="checkbox" name="habitaciones[]" value="1" class="checkbox">
                                    <span class="item-text">1</span>
                                </div>
                                <div class="item item-filtro">
                                    <input type="checkbox" name="habitaciones[]" value="2" class="checkbox">
                                    <span class="item-text">2</span>
                                </div>
                                <div class="item item-filtro">
                                    <input type="checkbox" name="habitaciones[]" value="3" class="checkbox">
                                    <span class="item-text">3</span>
                                </div>
                                <div class="item item-filtro">
                                    <input type="checkbox" name="habitaciones[]" value="4" class="checkbox">
                                    <span class="item-text">4+</span>
                                </div>

                                <div class="filtro-titulo"><b>Baños</b></div>
                                <div class="item item-filtro">
                                    <input type="checkbox" name="banos[]" value="1" class="checkbox">
                                    <span class="item-text">1</span>
                                </div>
                                <div class="item item-filtro">
                                    <input type="checkbox" name="banos[]" value="2" class="checkbox">
                                    <span class="item-text">2</span>
                                </div>
                                <div class="item item-filtro">
                                    <input type="checkbox" name="banos[]" value="3" class="checkbox">
                                    <span class="item-text">3</span>
                                </div>
                                <div class="item item-filtro">
                                    <input type="checkbox" name="banos[]" value="4" class="checkbox">
                                    <span class="item-text">4+</span>
                                </div>
                            </div>
                        </div> -->
                    </div>

                    <input class="btn-buscar-filtro" type="submit" value="Buscar" name="buscar">
                </form>
            </div>
        </div>

        <footer class="inferior2">
            <?php include("contenido-footer.php"); ?>
        </footer>
    </div>

    <script>
        function convertirAMinusculas(input) {
            input.value = input.value.toLowerCase();
        }
    </script>
</body>

<script src="script.js"></script>
<script src="filtros-dropdown.js"></script>

</html>
