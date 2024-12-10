<?php
session_start();
if (!$_SESSION['usuarioLogeado']) {
    header("Location: login.php");
    exit();
}

include("../conexion.php");

if (isset($_GET['id']) && isset($_GET['id_propiedad'])) {
    $id_subpropiedad = $_GET['id'];
    $id_propiedad = $_GET['id_propiedad'];
    
    // Intentamos eliminar la subpropiedad
    $query = "DELETE FROM subpropiedades WHERE id = '$id_subpropiedad'";

    if (mysqli_query($conn, $query)) {
        // Si la eliminación es exitosa, redirige usando PHP
        header("Location: ../ver-detalle-propiedad.php?id=" . $id_propiedad);
        exit();
    } else {
        // Si hay un error, muestra un mensaje de error con redirección usando JavaScript
        echo "<script>
                Swal.fire(
                    'Error!',
                    'Hubo un error al eliminar la subpropiedad.',
                    'error'
                ).then(() => {
                    window.location.href = '../ver-detalle-propiedad.php?id=" . $id_propiedad . "';
                });
              </script>";
    }
} else {
    // Si no se ha proporcionado el ID o ID de propiedad
    echo "<script>
            Swal.fire(
                'Error!',
                'ID no válido.',
                'error'
            ).then(() => {
                window.location.href = '../ver-detalle-propiedad.php';
            });
          </script>";
}
?>
