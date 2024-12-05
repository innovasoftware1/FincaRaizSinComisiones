<?php
if (isset($_GET['id'])) {
    $idCiudad = $_GET['id'];

    include("../conexion.php");

    $query = "DELETE FROM ciudades WHERE id='$idCiudad'";

    if (mysqli_query($conn, $query)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No se pudo eliminar la ciudad.']);
    }

    mysqli_close($conn);
} else {
    echo json_encode(['status' => 'error', 'message' => 'ID no proporcionado.']);
}
?>
