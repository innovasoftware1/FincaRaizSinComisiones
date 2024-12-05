<?php
session_start();
if (!$_SESSION['usuarioLogeado']) {
    header("Location:login.php");
}

include("conexion.php");

if (isset($_GET['id'])) {
    $id_usuario = $_GET['id'];

    $query = "DELETE FROM usuarios WHERE id = '$id_usuario'";

    if (mysqli_query($conn, $query)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error']);
    }
}
?>
