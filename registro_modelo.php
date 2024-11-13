<?php
// Conectar a la base de datos
$conn = new mysqli('localhost', 'root', '', 'gestion_impresoras');

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Procesar el formulario al enviar
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_modelo = $_POST['nombre_modelo'];

    // Insertar el modelo en la tabla modelos
    $sql = "INSERT INTO modelos (nombre_modelo) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nombre_modelo);

    if ($stmt->execute()) {
        echo "Modelo registrado exitosamente.";
    } else {
        echo "Error al registrar el modelo: " . $stmt->error;
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
    <title>Registrar Modelo de Impresora</title>
</head>
<body>
    <h1>Registrar Modelo de Impresora</h1>
    <form action="" method="POST">
        <label for="nombre_modelo">Nombre del Modelo:</label>
        <input type="text" id="nombre_modelo" name="nombre_modelo" required>
        <button type="submit">Registrar Modelo</button>
    </form>
</body>
</html>
