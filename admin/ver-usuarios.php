<?php
session_start();

if (!$_SESSION['usuarioLogeado']) {
    header("Location:login.php");
}

function obtenerTodosLosUsuarios()
{
    include("conexion.php");
    $query = "SELECT u.id, u.usuario, u.email, r.nombre_rol, u.fecha_creacion
              FROM usuarios u
              JOIN roles r ON u.rol_id = r.id";
    $result = mysqli_query($conn, $query);
    return $result;
}

$resultado = obtenerTodosLosUsuarios();
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
    <link rel="stylesheet" href="estilo.css">
    <title>FRSC - Admin</title>
</head>

<body>
    <?php include("header.php"); ?>

    <div id="contenedor-admin">
        <?php include("contenedor-menu.php"); ?>

        <div class="contenedor-principal">
            <div id="listado-propiedades">
                <h2>Usuarios Registrados</h2>
                <hr>

                <div class="contenedor-tabla">
                    <table class="contenedor-tabla">
                        <tr>
                            <th>#ID</th>
                            <th>Nombre de Usuario</th>
                            <th>Correo Electrónico</th>
                            <th>Rol</th>
                            <th>Fecha de Creación</th>
                            <th>Acciones</th>
                        </tr>
                        <tbody>
                            <?php while ($usuario = mysqli_fetch_assoc($resultado)) : ?>
                                <tr>
                                    <td><?php echo $usuario['id']; ?></td>
                                    <td><?php echo $usuario['usuario']; ?></td>
                                    <td><?php echo $usuario['email']; ?></td>
                                    <td><?php echo $usuario['nombre_rol']; ?></td>
                                    <td><?php echo $usuario['fecha_creacion']; ?></td>
                                    <td>
                                        <form action="actualizar-usuario.php" method="get" class="form-acciones">
                                            <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
                                            <input type="submit" value="Actualizar" class="btn-actualizar">
                                        </form>
                                        <a href="#" id="eliminar-<?php echo $usuario['id']; ?>" class="btn-eliminar" data-id="<?php echo $usuario['id']; ?>">
                                            Eliminar
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <script>
        $('#link-list-users').addClass('pagina-activa');
    </script>

    <script>
        $(document).ready(function() {
            $('.btn-eliminar').click(function(event) {
                event.preventDefault();
                var idUsuario = $(this).data('id');
                abrirModal(idUsuario);
            });
        });

        function abrirModal(idUsuario) {
            Swal.fire({
                title: '¿Estás seguro de eliminar este usuario?',
                text: '¡Esta acción no se puede deshacer!',
                icon: 'warning',
                showCancelButton: false,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar'
            }).then((result) => {
                if (result.isConfirmed) {
                    eliminarUsuario(idUsuario);
                }
            });
        }

        function eliminarUsuario(idUsuario) {
            $.ajax({
                url: 'eliminar-usuario.php',
                type: 'GET',
                data: { id: idUsuario },
                success: function(response) {
                    Swal.fire({
                        title: 'Usuario eliminado con éxito',
                        icon: 'success',
                        timer: 3000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        title: 'Hubo un error',
                        text: 'El usuario fue eliminado, pero ocurrió un error en la comunicación.',
                        icon: 'error',
                        timer: 3000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                }
            });
        }
    </script>

</body>

</html>
