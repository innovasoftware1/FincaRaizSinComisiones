<?php
session_start();
include("conexion.php");

if (isset($_POST['iniciar'])) {
    $usuario = mysqli_real_escape_string($conn, $_POST['usuario']);
    $password = $_POST['password'];

    // Consulta para obtener la información del usuario
    $sql = "SELECT id, usuario, password, rol_id FROM usuarios WHERE usuario = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $usuario);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Verificar la contraseña encriptada
        if (password_verify($password, $row['password'])) {
            // Inicio de sesión exitoso
            $_SESSION['usuarioLogeado'] = $usuario;
            $_SESSION['rol_id'] = $row['rol_id'];
            $_SESSION['rol_id'] = $row['rol_id'];
            $_SESSION['usuarioId'] = $row['id'];

            header("Location: index.php");
            exit();
        } else {
            // Contraseña incorrecta
            $mensaje = "* El nombre de usuario o la contraseña son incorrectos";
        }
    } else {
        // Usuario no encontrado
        $mensaje = "* El nombre de usuario o la contraseña son incorrectos";
    }

    mysqli_stmt_close($stmt);
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo.css">
    <title>Inicia sesión</title>
</head>

<body>
    <div id="contenedor-login">
        <div class="presentacion">
            <div class="titulo">
                <img class="logo" src="../img/logo-innova.png" alt="">
                <h1>FRSC</h1>
                <p>Sistema de Gestión</p>
                <p>FincaRaizSinComisiones</p>
            </div>
            <div class="contenedor-formulario">
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" class="form-login">
                    <p>Login administrativo <br><h4>Iniciar sesión</h4></p>
                    <input type="text" placeholder="Nombre de Usuario" name="usuario" required class="input-login">
                    <input type="password" placeholder="Contraseña" name="password" required class="input-login">
                    <input type="submit" value="Iniciar Sesión" name="iniciar" class="btn">
                    <br>

                    <?php if (isset($mensaje)) : ?>
                        <span class="msj-error-input"><?php echo $mensaje ?></span>
                    <?php endif ?>
                </form>
            </div>
        </div>
    </div>
</body>

</html>