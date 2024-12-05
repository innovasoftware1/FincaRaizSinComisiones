<?php
session_start();

include("../funciones.php");

if (!$_SESSION['usuarioLogeado']) {
    header("Location:login.php");
}

if (isset($_POST['agregar'])) {
    $departamento = $_POST['departamento'];

    $mensaje = agregarNuevoDepartamento($departamento);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../estilo.css">
    <title>FRSC - Admin</title>
</head>

<body>
    <?php include("../header.php"); ?>
    
    <div id="contenedor-admin">
        <?php include("../contenedor-menu.php"); ?>

        <div class="contenedor-principal">
            <div id="nuevo-departamento">
                <h2>Agregar Nuevo Departamento</h2>
                <hr>

                <div class="box-nuevo-tipo">
                    <h3>Agregar Nuevo Departamento</h3>
                    <hr>
                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                        <input type="text" name="departamento" placeholder="Nombre del departamento" required>
                        <input type="submit" name="agregar" value="Agregar" class="btn-accion">
                    </form>

                    <?php if (isset($_POST['agregar'])) : ?>
                        <script>
                            Swal.fire({
                                icon: 'success',
                                title: '¡Departamento Registrado!',
                                text: '<?php echo $mensaje; ?>',
                                showConfirmButton: false,
                                timer: 2500 
                            }).then(function() {
                                window.location.href = 'listado-departamento.php'; 
                            });
                        </script>
                    <?php endif; ?>

                </div>

            </div>
        </div>
    </div>

    <script>
        $('#link-add-departamento').addClass('pagina-activa');
    </script>
</body>

</html>
