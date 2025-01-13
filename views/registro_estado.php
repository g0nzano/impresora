<?php
// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'gestion_impresoras');

// Procesar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_estado = $_POST['nombre_estado'];
    $sql = "INSERT INTO estados (nombre_estado) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nombre_estado);
    if ($stmt->execute()) {
        echo "Estado registrado exitosamente.";
    } else {
        echo "Error al registrar el estado: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Estado</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Registrar Nuevo Estado</h1>
        <form action="" method="POST">
            <label for="nombre_estado">Nombre del Estado:</label>
            <input type="text" id="nombre_estado" name="nombre_estado" required>
            <button type="submit">Guardar Estado</button>
        </form>
    </div>
</body>
</html>
