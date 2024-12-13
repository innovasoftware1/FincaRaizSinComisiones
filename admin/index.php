index.php

<?php
session_start();

if (!(isset($_SESSION['usuarioLogeado']) && $_SESSION['usuarioLogeado'] != '')) {
    header("Location: login.php");
    exit();
}

include("funciones.php");

$rol = $_SESSION['rol_id'];

$totalPropiedades = obtenerTotalRegistros('propiedades');
$totalTipos = obtenerTotalRegistros('tipos');
$totalDepartamentos = obtenerTotalRegistros('departamentos');
$totaCiudades = obtenerTotalRegistros('ciudades');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="estilo.css">
    <title>FRSC - Admin</title>
    <style>
        
    </style>
</head>

<body>
    <?php include("header.php"); ?>
    <div id="contenedor-admin">
        <?php include("contenedor-menu.php"); ?>

        <div class="contenedor-principal">
            <div id="dashboard">
                <h2>Dashboard Principal</h2>
                <br>
                <hr>
                <h3>Detalles globales</h3>
                <br>
                <hr>
                <div class="contenedor-cajas-info">
                    <div class="caja-info propiedades">
                        <p>Total Propiedades</p>
                        <hr>
                        <span class="dato"><?php echo $totalPropiedades ?></span>
                        <hr>
                        <a href="property/listado-propiedades.php">Ver Detalles</a>
                    </div>
                    <div class="caja-info tipo">
                        <p>Total Tipo de Propiedades</p>
                        <hr>
                        <span class="dato"><?php echo $totalTipos ?></span>
                        <hr>
                        <a href="type_property/listado-tipo-propiedades.php">Ver Detalles</a>
                    </div>
                    <div class="caja-info departamentos">
                        <p>Total departamentos</p>
                        <hr>
                        <span class="dato"><?php echo $totalDepartamentos ?></span>
                        <hr>
                        <a href="departments/listado-departamento.php">Ver Detalles</a>
                    </div>
                    <div class="caja-info ciudades">
                        <p>Total Ciudades</p>
                        <hr>
                        <span class="dato"><?php echo $totaCiudades ?></span>
                        <hr>
                        <a href="city/listado-ciudades.php">Ver Detalles</a>
                    </div>
                </div>
                <br>
                <h3>Ingreso de usuarios</h3>
                <br>
                <hr>
                <!-- Contenedor para los botones (solo visible para el rol 1 - Administrador) -->
                <?php if ($rol == 1) : ?>
                    <div class="contenedor-cajas-info">
                        <div class="contenedor-botones">
                            <div class="btn-container">
                                <a href="crear-usuario.php" class="btn">Crear Usuario</a>
                            </div>
                            <div class="btn-container">
                                <a href="ver-usuarios.php" class="btn">Ver Usuarios</a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <br>
                <h3>Graficas globales</h3>
                <br>
                <hr>
                <div class="contenedor-cajas-info">
                    <div class="grafico-lineas">
                        <canvas id="graficoLineas"></canvas>
                    </div>
                </div>
                <br>
                <br>
            </div>
        </div>
    </div>
</body>

<script>
    $('#link-dashboard').addClass('pagina-activa');

    var ctx = document.getElementById('graficoLineas').getContext('2d');
    var graficoLineas = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Propiedades', 'Tipos', 'Departamentos', 'Ciudades'],
            datasets: [{
                    label: 'Propiedades',
                    data: [<?php echo $totalPropiedades ?>, 0, 0, 0],
                    fill: false,
                    borderColor: 'rgb(255, 99, 132)',
                    tension: 0.1
                },
                {
                    label: 'Tipos',
                    data: [0, <?php echo $totalTipos ?>, 0, 0],
                    fill: false,
                    borderColor: 'rgb(54, 162, 235)',
                    tension: 0.1
                },
                {
                    label: 'Departamentos',
                    data: [0, 0, <?php echo $totalDepartamentos ?>, 0],
                    fill: false,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                },
                {
                    label: 'Ciudades',
                    data: [0, 0, 0, <?php echo $totaCiudades ?>],
                    fill: false,
                    borderColor: 'rgb(153, 102, 255)',
                    tension: 0.1
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

</html>

