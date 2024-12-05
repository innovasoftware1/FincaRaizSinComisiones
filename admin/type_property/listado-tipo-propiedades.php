<?php
session_start();

if (!$_SESSION['usuarioLogeado']) {
    header("Location:login.php");
}

function obtenerTodosLosTipos()
{
    include("../conexion.php");
    $query = "SELECT * FROM tipos";
    $result = mysqli_query($conn, $query);
    return $result;
}

$result = obtenerTodosLosTipos();
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
            <div id="listado-tipos-propiedades">
                <h2>Tipos de Propiedades</h2>
                <hr>
                <div class="contenedor-tabla">
                    <!-- Formulario de búsqueda -->
                    <div class="form-busqueda">
                        <label for="">Filtro de Busqueda</label>
                        <div class="input-container">
                            <input type="text" id="myInput" placeholder="Buscar por nombre tipo propiedad..." class="input-buscar">
                        </div>
                    </div>

                    <table class="listados" id="myTable">
                        <tr>
                            <th>#ID</th>
                            <th>Tipo</th>
                            <th>Acciones</th>
                        </tr>

                        <?php while ($tipo = mysqli_fetch_assoc($result)) : ?>
                            <tr>
                                <td> <?php echo $tipo['id'] ?></td>
                                <td> <?php echo $tipo['nombre_tipo'] ?></td>
                                <td>
                                    <form action="actualizar-tipo-propiedad.php" method="get" class="form-acciones" class="btn-actualizar" style="display:inline;">
                                        <input type="hidden" name="id" value="<?php echo $tipo['id'] ?>">
                                        <input type="submit" value="Actualizar" name="actualizar">
                                    </form>
                                    <button class="btn-eliminar" onclick="eliminarTipo(<?php echo $tipo['id'] ?>)">Eliminar</button>
                                </td>
                            </tr>
                        <?php endwhile ?>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <script>
        $('#link-listado-tipo-propiedades').addClass('pagina-activa');

        function eliminarTipo(idTipo) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: '¡Este tipo de propiedad será eliminado permanentemente!',
                icon: 'warning',
                showCancelButton: false,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'eliminar-tipo-propiedad.php',
                        type: 'GET',
                        data: {
                            id: idTipo
                        },
                        success: function(response) {
                            var data = JSON.parse(response);
                            if (data.status === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: '¡Eliminado!',
                                    text: 'El tipo de propiedad ha sido eliminado.',
                                    showConfirmButton: false,
                                    timer: 3000
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Hubo un problema al eliminar el tipo de propiedad.',
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Hubo un error al realizar la solicitud.',
                                showConfirmButton: false,
                                timer: 3000
                            });
                        }
                    });
                }
            });
        }
    </script>

    <script>
        $(document).ready(function() {
            $("#myInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#myTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
        });
    </script>
</body>

</html>