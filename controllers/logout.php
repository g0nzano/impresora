<?php
session_start(); // Inicia la sesión
session_destroy(); // Destruye la sesión actual
header('Location: ../views/login.php'); // Redirige al usuario al login
exit; // Termina el script
?>
