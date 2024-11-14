<?php
// Conectar a la base de datos
$conn = new mysqli('localhost', 'root', '', 'gestion_impresoras');

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Procesar el formulario al enviar
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_impresora = $_POST['nombre_impresora'];

    // Insertar el nombre en la tabla nombres
    $sql = "INSERT INTO nombres (nombre_impresora) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nombre_impresora);

    if ($stmt->execute()) {
        echo "Nombre de impresora registrado exitosamente.";
    } else {
        echo "Error al registrar el nombre de impresora: " . $stmt->error;
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
    <title>Registrar Nombre de Impresora</title>
</head>
<body>
    <h1>Registrar Nombre de Impresora</h1>
    <form action="" method="POST">
        <label for="nombre_impresora">Nombre de la Impresora:</label>
        <input type="text" id="nombre_impresora" name="nombre_impresora" required>
        <button type="submit">Registrar Nombre</button>
    </form>
</body>
</html>
