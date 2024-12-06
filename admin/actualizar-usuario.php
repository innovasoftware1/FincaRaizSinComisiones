<?php
    include("conexion.php");

    $usuario_actualizado = false;

    if (isset($_GET['id'])) {
        $id_usuario = $_GET['id'];

        $query = "SELECT u.id, u.usuario, u.nombre, u.email, u.password, u.rol_id, r.nombre_rol
                FROM usuarios u
                JOIN roles r ON u.rol_id = r.id
                WHERE u.id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id_usuario);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        if ($resultado && mysqli_num_rows($resultado) > 0) {
            $usuario = mysqli_fetch_assoc($resultado);
        } else {
            $usuario = null;
            header("Location: ver-usuarios.php");
            exit();
        }
    }

    if (isset($_POST['actualizar'])) {
        $id_usuario = $_POST['id'];
        $usuario_nombre = $_POST['usuario'];
        $nombre_completo = $_POST['nombre'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $rol_id = $_POST['rol'];

        // Preparar la consulta de actualización
        if (!empty($password)) {
            // Encriptar la nueva contraseña
            $password_encrypted = password_hash($password, PASSWORD_DEFAULT);
            $query = "UPDATE usuarios SET usuario = ?, nombre = ?, email = ?, password = ?, rol_id = ? WHERE id = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "ssssii", $usuario_nombre, $nombre_completo, $email, $password_encrypted, $rol_id, $id_usuario);
        } else {
            // Actualizar sin modificar la contraseña
            $query = "UPDATE usuarios SET usuario = ?, nombre = ?, email = ?, rol_id = ? WHERE id = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "sssii", $usuario_nombre, $nombre_completo, $email, $rol_id, $id_usuario);
        }

        // Ejecutar la consulta
        if (mysqli_stmt_execute($stmt)) {
            $usuario_actualizado = true;

            // Obtener los datos actualizados del usuario
            $query = "SELECT u.id, u.usuario, u.nombre, r.nombre_rol
                    FROM usuarios u
                    JOIN roles r ON u.rol_id = r.id
                    WHERE u.id = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "i", $id_usuario);
            mysqli_stmt_execute($stmt);
            $resultado = mysqli_stmt_get_result($stmt);
            $usuario = mysqli_fetch_assoc($resultado);
        } else {
            $mensaje = "Error al actualizar el usuario: " . mysqli_error($conn);
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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
        <link rel="stylesheet" href="estilo.css">
        <title>Actualizar Usuario</title>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>

    <body>
        <?php include("header.php"); ?>

        <div id="contenedor-admin">
            <?php include("menu_index.php"); ?>

            <div class="contenedor-principal">
                <div id="configuracion">
                    <h2>Actualizar Usuario</h2>
                    <hr>

                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                        <div class="box-configuracion">

                            <!-- ID (Cédula) -->
                            <label for="id">ID del Usuario</label>
                            <input type="text" name="id" value="<?php echo htmlspecialchars($usuario['id'] ?? ''); ?>" autocomplete="off" class="input-entrada-texto" readonly>

                            <!-- Nombre Completo -->
                            <label for="nombre">Nombre Completo</label>
                            <input type="text" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre'] ?? ''); ?>" autocomplete="off" class="input-entrada-texto">

                            <!-- Nombre de Usuario -->
                            <label for="usuario">Nombre de Usuario</label>
                            <input type="text" name="usuario" value="<?php echo htmlspecialchars($usuario['usuario'] ?? ''); ?>" autocomplete="off" class="input-entrada-texto">

                            <!-- Correo Electrónico -->
                            <label for="email">Correo Electrónico</label>
                            <input type="email" name="email" value="<?php echo htmlspecialchars($usuario['email'] ?? ''); ?>" autocomplete="off" class="input-entrada-texto">
                            <br><br>

                            <!-- Contraseña -->
                            <label for="password">Nueva Contraseña (opcional)</label>
                            <input type="password" name="password" placeholder="Dejar vacío si no deseas cambiarla" autocomplete="off" class="input-entrada-texto">
                            <br><br>

                            <!-- Rol -->
                            <label for="rol">Rol</label>
                            <select name="rol" id="select" required class="input-entrada-texto">
                                <?php
                                $roles_query = "SELECT * FROM roles";
                                $roles_result = mysqli_query($conn, $roles_query);
                                while ($row = mysqli_fetch_assoc($roles_result)) :
                                    $selected = ($row['id'] == ($usuario['rol_id'] ?? '')) ? "selected" : "";
                                ?>
                                    <option value="<?php echo $row['id']; ?>" <?php echo $selected; ?>>
                                        <?php echo htmlspecialchars($row['nombre_rol']); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                            <br><br>

                            <input type="submit" name="actualizar" value="Actualizar Usuario" class="btn-accion">
                        </div>
                    </form>

                    <?php if (isset($mensaje)) : ?>
                        <p><?php echo htmlspecialchars($mensaje); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <script>
            <?php if ($usuario_actualizado) : ?>
                Swal.fire({
                    title: '¡Usuario actualizado con éxito!',
                    icon: 'success',
                    timer: 3000,
                    showConfirmButton: false,
                    willClose: () => {
                        window.location.href = "ver-usuarios.php";
                    }
                });
            <?php endif; ?>
        </script>
    </body>

    </html>