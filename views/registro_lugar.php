<?php
// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'gestion_impresoras');

// Procesar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_lugar = $_POST['nombre_lugar'];
    $sql = "INSERT INTO lugares (nombre_lugar) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nombre_lugar);
    if ($stmt->execute()) {
        echo "Lugar registrado exitosamente.";
    } else {
        echo "Error al registrar el lugar: " . $stmt->error;
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
    <title>Registrar Lugar</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Registrar Nuevo Lugar</h1>
        <form action="" method="POST">
            <label for="nombre_lugar">Nombre del Lugar:</label>
            <input type="text" id="nombre_lugar" name="nombre_lugar" required>
            <button type="submit">Guardar Lugar</button>
        </form>
    </div>
</body>
</html>
