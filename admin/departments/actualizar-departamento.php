<?php
include("../conexion.php");
$id_departamento = $_GET['id'];

$query = "SELECT * FROM departamentos WHERE id='$id_departamento'";

$result = mysqli_query($conn, $query);
$departamento = mysqli_fetch_assoc($result);

if (isset($_GET['modificar'])) {
    include("../conexion.php");

    $id = $_GET['id'];
    $nombre_departamento = $_GET['nombre_departamento'];

    $query = "UPDATE departamentos SET nombre_departamento='$nombre_departamento' WHERE id='$id'";

    if (mysqli_query($conn, $query)) {
        $mensaje = "El país se actualizó correctamente";
        $estado = 'success';
    } else {
        $mensaje = "No se pudo actualizar en la BD: " . mysqli_error($conn);
        $estado = 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../estilo.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>FRSC - Admin</title>
</head>

<body>
    <?php include("../header.php"); ?>
    <div id="contenedor-admin">
        <?php include("../contenedor-menu.php"); ?>

        <div class="contenedor-principal">
            <div id="nuevo-departamento">
                <h2>Actualizar Departamento</h2>
                <hr>

                <div class="box-nuevo-tipo">
                    <h3>Actualizar Departamento</h3>
                    <hr>
                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get">
                        <input type="hidden" name="id" value="<?php echo $departamento['id'] ?>"> 
                        <input type="text" name="nombre_departamento" value="<?php echo $departamento['nombre_departamento'] ?>" placeholder="Nombre del departamento" required>
                        <input type="submit" name="modificar" value="Modificar" class="btn-accion">
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script>
    <?php if (isset($estado)) : ?>
        Swal.fire({
            icon: '<?php echo $estado; ?>',
            title: '<?php echo $estado == 'success' ? "¡Éxito!" : "¡Error!"; ?>',
            text: '<?php echo $mensaje; ?>',
            showConfirmButton: false,  
            timer: 2000,  
            allowOutsideClick: false 
        }).then(() => {
            <?php if ($estado == 'success') : ?>
                window.location.href = 'listado-departamento.php'; 
            <?php endif; ?> 
        });
    <?php endif; ?>
</script>

</body>

</html>
