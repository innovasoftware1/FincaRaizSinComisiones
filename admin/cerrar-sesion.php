<?php
session_start();
session_destroy(); 
header("Location: login.php"); // se rompe y llegamos al Login
exit();
?>
