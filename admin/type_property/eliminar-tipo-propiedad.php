<?php
include("../conexion.php");

if (isset($_GET['id'])) {
    $idTipo = $_GET['id'];

    $query = "DELETE FROM tipos WHERE id = '$idTipo'";
    if (mysqli_query($conn, $query)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error']);
    }
}
?>
