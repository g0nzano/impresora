<?php
// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'gestion_impresoras');

// Procesar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_marca = $_POST['nombre_marca'];
    $sql = "INSERT INTO marcas (nombre_marca) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nombre_marca);
    if ($stmt->execute()) {
        echo "Marca registrada exitosamente.";
    } else {
        echo "Error al registrar la marca: " . $stmt->error;
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
    <title>Registrar Marca</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Registrar Nueva Marca</h1>
        <form action="" method="POST">
            <label for="nombre_marca">Nombre de la Marca:</label>
            <input type="text" id="nombre_marca" name="nombre_marca" required>
            <button type="submit">Guardar Marca</button>
        </form>
    </div>
</body>
</html>
