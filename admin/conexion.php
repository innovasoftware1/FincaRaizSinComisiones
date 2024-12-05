<?php
/* Conexión a la base de datos */
$server = "localhost:3306"; // Servidor y puerto
$username = "root";         // Usuario
$password = "";             // Contraseña
$bd = "finca_raiz_v1";      // Base de datos

$conn = mysqli_connect($server, $username, $password, $bd);

if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}
?>
