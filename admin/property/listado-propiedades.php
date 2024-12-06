<?php
session_start();

if (!$_SESSION['usuarioLogeado']) {
    header("Location:login.php");
}

function obtenerTodasLasPropiedades()
{
    include("../conexion.php");
    $query = "SELECT * FROM propiedades ORDER BY fecha_alta DESC";
    $result = mysqli_query($conn, $query);
    return $result;
}

function obtenerTipo($id_tipo)
{
    include("../conexion.php");
    $query = "SELECT * FROM tipos WHERE id='$id_tipo'";
    $resultado_tipo = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($resultado_tipo);
    return $row['nombre_tipo'];
}

$result = obtenerTodasLasPropiedades();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../estilo.css">
    <title>FRSC - Admin</title>
</head>

<body>
    <?php include("../header.php"); ?>
    <div id="contenedor-admin">
        <?php include("../contenedor-menu.php"); ?>
        <div class="contenedor-principal">
            <div id="listado-propiedades">
                <h2>Listado de Propiedades</h2>
                <hr>
                <br>
                <div class="contenedor-tabla">
                    <!-- Formulario de búsqueda -->
                    <div class="form-busqueda">
                        <label for="">Filtro de Busqueda</label>
                        <div class="input-container">
                            <input type="text" id="myInput" placeholder="Buscar por cedula, nombre, propietario o tipo..." class="input-buscar">
                        </div>
                    </div>
                    <!-- Tabla de propiedades -->
                    <table id="myTable">
                        <tr>
                            <th>Cedula</th>
                            <th>Título</th>
                            <th>Tipo</th>
                            <th>Estado</th>
                            <th>Ubicación</th>
                            <th>Fecha de Publicación</th>
                            <th>Acciones</th>
                        </tr>
                        <?php while ($propiedad = mysqli_fetch_assoc($result)) : ?>
                            <tr>
                                <td> <?php echo $propiedad['id'] ?></td>
                                <td> <?php echo $propiedad['titulo'] ?></td>
                                <td> <?php echo obtenerTipo($propiedad['tipo']) ?></td>
                                <td> <?php echo $propiedad['estado'] ?></td>
                                <td> <?php echo $propiedad['ubicacion'] ?></td>
                                <td> <?php echo $propiedad['fecha_alta'] ?></td>
                                <td>
                                    <form action="../ver-detalle-propiedad.php" method="get" class="form-acciones">
                                        <input type="hidden" name="id" value="<?php echo $propiedad['id'] ?>">
                                        <input type="submit" value="Ver Detalle" name="detalle" class="btn-detalle">
                                    </form>

                                    <form action="actualizar-propiedad.php" method="get" class="form-acciones">
                                        <input type="hidden" name="id" value="<?php echo $propiedad['id'] ?>">
                                        <input type="submit" value="Actualizar" name="actualizar" class="btn-actualizar">
                                    </form>
                                    <form action="../subproperties/add.php" method="get" class="form-acciones">
                                        <input type="hidden" name="id" value="<?php echo $propiedad['id'] ?>">
                                        <input type="submit" value="registrar subpropiedad" name="actualizar" class="btn-actualizar">
                                    </form>

                                    <a href="javascript:void(0);" onclick="confirmarEliminacion(<?php echo $propiedad['id'] ?>)" class="btn-eliminar">Eliminar</a>

                                </td>
                            </tr>
                        <?php endwhile ?>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <script>
        $('#link-listado-propiedades').addClass('pagina-activa');

        function confirmarEliminacion(idPropiedad) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "No podrás revertir esta acción",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar'
            }).then((result) => {
                if (result.isConfirmed) {
                    eliminarPropiedad(idPropiedad);
                }
            });
        }

        function eliminarPropiedad(idPropiedad) {
            $.ajax({
                url: 'eliminar-propiedad.php',
                type: 'GET',
                data: {
                    idPropiedad: idPropiedad
                },
                success: function(response) {
                    console.log("Respuesta del servidor:", response);
                    if (response.trim() === "success") {
                        Swal.fire({
                            title: 'Eliminado!',
                            text: 'La propiedad ha sido eliminada.',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = "listado-propiedades.php";
                        });
                    } else {
                        Swal.fire(
                            'Error!',
                            'No se pudo eliminar la propiedad.',
                            'error'
                        );
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error en la solicitud:", error);
                    Swal.fire(
                        'Error!',
                        'Hubo un problema al procesar la solicitud.',
                        'error'
                    );
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