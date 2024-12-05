<?php
session_start();
// Iniciar sesión si no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el usuario está autenticado y tiene un rol asignado
if (!isset($_SESSION['usuarioLogeado']) || !isset($_SESSION['rol_id'])) {
    header("Location: ../login.php");
    exit();
}

// Obtener el rol del usuario
$rol = $_SESSION['rol_id'];

// Definir una constante para la URL base del proyecto
define('BASE_URL', 'http://localhost/FincaRaizV1/fincaRaizInnova/');
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>estilo.css">
    <title>SAWPI - Dashboard</title>
</head>

<body>
    <div class="contenedor-menu">
        <h2>MENÚ</h2>
        <nav>
            <ul>
                <hr>

                <?php if ($rol == 1 || $rol == 2) : ?>
                    <li id="link-dashboard">
                        <a href="<?php echo BASE_URL; ?>admin/index.php">
                            <i class="fa-solid fa-user"></i>
                            Dashboard
                        </a>
                    </li>
                    <hr>

                    <!-- Propiedades -->
                    <li id="link-add-propiedad">
                        <a href="<?php echo BASE_URL; ?>admin/property/add-propiedad.php">
                            <i class="fa-solid fa-building"></i>
                            Nueva Propiedad
                        </a>
                    </li>
                    <li id="link-listado-propiedades">
                        <a href="<?php echo BASE_URL; ?>admin/property/listado-propiedades.php">
                            <i class="fa-solid fa-list"></i>
                            Listado de Propiedades
                        </a>
                    </li>
                    <hr>

                    <!-- Tipos de Propiedades -->   
                    <li id="link-add-tipo-propiedad">
                        <a href="<?php echo BASE_URL; ?>admin/type_property/add-tipo-propiedad.php">
                            <i class="fa-solid fa-folder-plus"></i>
                            Nuevo Tipo de Propiedad
                        </a>
                    </li>
                    <li id="link-listado-tipo-propiedades">
                        <a href="<?php echo BASE_URL; ?>admin/type_property/listado-tipo-propiedades.php">
                            <i class="fa-solid fa-list"></i>
                            Listado de Tipo
                        </a>
                    </li>
                    <hr>

                    <!-- Departamentos -->
                    <li id="link-add-departamento">
                        <a href="<?php echo BASE_URL; ?>admin/departments/add-departamento.php">
                            <i class="fa-solid fa-earth-americas"></i>
                            Nuevo Departamento
                        </a>
                    </li>
                    <li id="link-listado-departamentos">
                        <a href="<?php echo BASE_URL; ?>admin/departments/listado-departamento.php">
                            <i class="fa-solid fa-list"></i>
                            Listado de Departamento
                        </a>
                    </li>
                    <hr>

                    <!-- Ciudades -->
                    <li id="link-add-ciudad">
                        <a href="<?php echo BASE_URL; ?>admin/city/add-ciudad.php">
                            <i class="fa-solid fa-location-dot"></i>
                            Nueva Ciudad
                        </a>
                    </li>
                    <li id="link-listado-ciudades">
                        <a href="<?php echo BASE_URL; ?>admin/city/listado-ciudades.php">
                            <i class="fa-solid fa-list"></i>
                            Listado de Ciudades
                        </a>
                    </li>
                <?php endif; ?>

                <hr>
                <li id="link-ver-sitio">
                    <a href="<?php echo BASE_URL; ?>index.php" target="_blank">
                        <i class="fa-solid fa-earth-africa"></i>
                        Ver Sitio Web
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</body>

</html>
