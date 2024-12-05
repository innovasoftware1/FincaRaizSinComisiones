<?php
session_start();

if (!$_SESSION['usuarioLogeado']) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    include("../conexion.php");

    $idDepartamento = mysqli_real_escape_string($conn, $_GET['id']);

    $query = "DELETE FROM departamentos WHERE id = '$idDepartamento'";

    if (mysqli_query($conn, $query)) {
        echo json_encode(array("status" => "success"));
    } else {
        echo json_encode(array("status" => "error", "message" => mysqli_error($conn)));
    }
} else {
    echo json_encode(array("status" => "error", "message" => "ID no proporcionado."));
}
?>
