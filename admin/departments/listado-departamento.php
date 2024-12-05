<?php
session_start();

if (!$_SESSION['usuarioLogeado']) {
    header("Location:login.php");
    exit;
}
function obtenerTodosLosDepartamentos()
{
    include("../conexion.php");

    $query = "SELECT * FROM departamentos";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Error en la consulta: " . mysqli_error($conn));
    }

    return $result;
}

$result = obtenerTodosLosDepartamentos();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            <div id="listado-departamentos">
                <h2>Listado de Departamentos</h2>
                <hr>
                <div class="contenedor-tabla">
                    <!-- Formulario de búsqueda -->
                    <div class="form-busqueda">
                        <label for="">Filtro de Busqueda</label>
                        <div class="input-container">
                            <input type="text" id="myInput" placeholder="Buscar por nombre departamento..." class="input-buscar">
                        </div>
                    </div>
                    <!-- Tabla de propiedades -->
                    <table class="listados" id="myTable">
                        <tr>
                            <th>#ID</th>
                            <th>Nombre del departamento</th>
                            <th>Acciones</th>
                        </tr>

                        <?php while ($departamento = mysqli_fetch_assoc($result)) : ?>
                            <tr>
                                <td> <?php echo $departamento['id'] ?></td>
                                <td> <?php echo $departamento['nombre_departamento'] ?></td>
                                <td>
                                    <form action="actualizar-departamento.php" method="get" class="form-acciones" style="display:inline;">
                                        <input type="hidden" name="id" value="<?php echo $departamento['id'] ?>">
                                        <input type="submit" value="Actualizar" name="actualizar">
                                    </form>
                                    <button class="btn-eliminar" onclick="eliminarDepartamento(<?php echo $departamento['id']; ?>)">Eliminar</button>
                                </td>
                            </tr>
                        <?php endwhile ?>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function eliminarDepartamento(idDepartamento) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: '¡No podrás revertir esta acción!',
                icon: 'warning',
                showCancelButton: false,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                allowOutsideClick: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'eliminar-departamento.php',
                        type: 'GET',
                        data: {
                            id: idDepartamento
                        },
                        success: function(response) {
                            var data = JSON.parse(response);
                            if (data.status === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: '¡Eliminado!',
                                    text: 'El departamento ha sido eliminado.',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    allowOutsideClick: true
                                }).then(() => {
                                    $('tr').has('button[onclick="eliminarDepartamento(' + idDepartamento + ')"]').remove();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Hubo un problema al eliminar el departamento.',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    allowOutsideClick: true
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Hubo un error al realizar la solicitud.',
                                showConfirmButton: false,
                                timer: 3000,
                                allowOutsideClick: true
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

    <script>
        $('#link-listado-departamentos').addClass('pagina-activa');
    </script>
</body>

</html>