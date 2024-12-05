<?php
include("../conexion.php");
$id_tipo_propiedad = $_GET['id'];

$query = "SELECT * FROM tipos WHERE id='$id_tipo_propiedad'";

$result = mysqli_query($conn, $query);
$tipo = mysqli_fetch_assoc($result);

if (isset($_GET['modificar'])) {
    include("../conexion.php");

    $id = $_GET['id'];
    $nombre_tipo = $_GET['nombre_tipo'];

    $query = "UPDATE tipos SET nombre_tipo='$nombre_tipo' WHERE id='$id'";

    if (mysqli_query($conn, $query)) {
        $mensaje = "Tipo de propiedad actualizado correctamente";
        $estado = "success";
    } else {
        $mensaje = "No se pudo actualizar en la BD" . mysqli_error($conn);
        $estado = "error";
    }
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
            <div id="nuevo-tipo-propiedad">
                <h2>Actualizar Tipo de Propiedad</h2>
                <hr>

                <div class="box-nuevo-tipo">
                    <h3>Actualizar Tipo de Propiedad</h3>
                    <hr>
                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get">
                        <input type="hidden" name="id" value="<?php echo $tipo['id'] ?>"> 
                        <input type="text" name="nombre_tipo" value="<?php echo $tipo['nombre_tipo'] ?>" placeholder="Tipo de propiedad" required>
                        <input type="submit" name="modificar" value="Modificar" class="btn-accion">
                    </form>

                    <?php if (isset($estado)) : ?>
                        <script>
                            Swal.fire({
                                icon: '<?php echo $estado; ?>',
                                title: '<?php echo $estado == 'success' ? "¡Éxito!" : "¡Error!"; ?>',
                                text: '<?php echo $mensaje; ?>',
                                showConfirmButton: false,
                                timer: 2500
                            }).then(() => {
                                <?php if ($estado == 'success') : ?>
                                    window.location.href = 'listado-tipo-propiedades.php'; 
                                <?php endif; ?>
                            });
                        </script>
                    <?php endif ?>

                </div>

            </div>
        </div>
    </div>
</body>

</html>
