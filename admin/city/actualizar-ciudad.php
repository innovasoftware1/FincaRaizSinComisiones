<?php

include("../conexion.php");

$id_ciudad = $_GET['id'];

$query = "SELECT * FROM ciudades WHERE id='$id_ciudad'";
$result = mysqli_query($conn, $query);
$ciudad = mysqli_fetch_assoc($result);

//obtener los departamentos
$query = "SELECT * FROM departamentos";
$resultado_departamentos = mysqli_query($conn, $query);

if (isset($_GET['modificar'])) {
    include("../conexion.php");

    $id = $_GET['id'];
    $id_departamento = $_GET['departamento'];
    $nombre_ciudad = $_GET['nombre_ciudad'];

    $query = "UPDATE ciudades SET id_departamento='$id_departamento', nombre_ciudad='$nombre_ciudad' WHERE id='$id'";

    if (mysqli_query($conn, $query)) { 
        $mensaje = "La ciudad se actualizó correctamente";
    } else {
        $mensaje = "No se pudo actualizar en la BD: " . mysqli_error($conn);
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
            <div id="nueva-ciudad">
                <h2>Actualizar Ciudad</h2>
                <hr>

                <div class="box-nuevo-tipo">
                    <h3>Actualizar Ciudad</h3>
                    <hr>
                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get">
                        <br>
                        <label for="departamento"><b>Seleccione el departamento</b></label>
                        <input type="hidden" name="id" value="<?php echo $ciudad['id'] ?>">

                        <select name="departamento" class="input-entrada-texto">
                            <?php while ($row = mysqli_fetch_assoc($resultado_departamentos)) : ?>
                                <?php if ($row['id'] == $ciudad['id_departamento']) : ?>
                                    <option value="<?php echo $row['id'] ?>" selected>
                                        <?php echo $row['nombre_departamento'] ?>
                                    </option>
                                <?php else : ?>
                                    <option value="<?php echo $row['id'] ?>">
                                        <?php echo $row['nombre_departamento'] ?>
                                    </option>
                                <?php endif ?>
                            <?php endwhile ?>
                        </select>
                        <input type="text" name="nombre_ciudad" value="<?php echo $ciudad['nombre_ciudad'] ?>" placeholder="Nombre de la Ciudad" required>
                        <input type="submit" name="modificar" value="Modificar" class="btn-accion">
                    </form>

                    <?php if (isset($_GET['modificar'])) : ?>
                        <script>
                            Swal.fire({
                                icon: 'success',
                                title: '¡Ciudad actualizada!',
                                text: '<?php echo $mensaje; ?>',
                                showConfirmButton: false,
                                timer: 3000 
                            }).then(() => {
                                window.location.href = 'listado-ciudades.php'; 
                            });
                        </script>
                    <?php endif ?>

                </div>

            </div>
        </div>
    </div>
</body>

</html>
