

<?php

$server = "localhost:3307"; // Servidor y puerto
$username = "root";         // Usuario
$password = "clave.innova";             // Contraseña
$bd = "finca_raiz_v1";      // Base de datos

$conn = mysqli_connect($server, $username, $password, $bd);

if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}
?>
