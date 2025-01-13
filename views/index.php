<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header('Location: ../views/login.php');
    exit;
}

// Código para el panel de administración aquí
?>

<!DOCTYPE html>
<a href="../controllers/logout.php" class="button">Cerrar Sesión</a>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestión de Impresoras</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Sistema de Gestión de Impresoras</h1>
        <div class="menu">
            <a href="registro_impresora.php" class="button">Registrar Nueva Impresora</a>
            <a href="listado_impresoras.php" class="button">Listar Impresoras</a>
            <a href="../controllers/cargar_contadores.php" class="button">Cargar Contadores</a>
        </div>
    </div>
</body>
</html>
