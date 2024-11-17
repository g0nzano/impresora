<?php
// Conectar a la base de datos
$conn = new mysqli('localhost', 'root', '', 'gestion_impresoras');

// Comprobar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verificar si se ha proporcionado el ID en la URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Obtener los datos actuales de la impresora
    $sql = "SELECT impresoras.*, modelos.nombre_modelo AS modelo, nombres.nombre_impresora AS nombre
            FROM impresoras
            LEFT JOIN modelos ON impresoras.modelo_id = modelos.id
            LEFT JOIN nombres ON impresoras.nombre_id = nombres.id
            WHERE impresoras.id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar que la impresora exista
    if ($result && $result->num_rows > 0) {
        $impresora = $result->fetch_assoc();
    } else {
        die("Impresora no encontrada.");
    }
} else {
    die("ID de impresora no proporcionado o no válido.");
}

// Procesar el formulario al enviar
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sector = $_POST['sector'];
    $lugar = $_POST['lugar'];
    $estado = $_POST['estado'];
    $fecha_actualizacion = date('Y-m-d H:i:s');

    // Actualizar la tabla principal con los campos permitidos
    $update_sql = "UPDATE impresoras SET sector = ?, lugar = ?, estado = ?, fecha_actualizacion = ? WHERE id = ?";
    $stmt_update = $conn->prepare($update_sql);
    $stmt_update->bind_param("ssssi", $sector, $lugar, $estado, $fecha_actualizacion, $id);

    if ($stmt_update->execute()) {
        echo "Impresora actualizada exitosamente.";
    } else {
        echo "Error al actualizar la impresora: " . $stmt_update->error;
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Impresora</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Actualizar Impresora - <?php echo htmlspecialchars($impresora['nombre']); ?></h1>

        <form action="" method="POST">
            <label for="modelo">Modelo:</label>
            <input type="text" id="modelo" name="modelo" value="<?php echo htmlspecialchars($impresora['modelo']); ?>" readonly>

            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($impresora['nombre']); ?>" readonly>

            <label for="contador_negro">Contador Negro:</label>
            <input type="number" id="contador_negro" name="contador_negro" value="<?php echo $impresora['contador_negro']; ?>" readonly>

            <label for="contador_color">Contador Color:</label>
            <input type="number" id="contador_color" name="contador_color" value="<?php echo $impresora['contador_color']; ?>" readonly>

            <label for="sector">Sector:</label>
            <input type="text" id="sector" name="sector" value="<?php echo htmlspecialchars($impresora['sector']); ?>" required>

            <label for="lugar">Lugar:</label>
            <input type="text" id="lugar" name="lugar" value="<?php echo htmlspecialchars($impresora['lugar']); ?>" required>

            <label for="estado">Estado:</label>
            <select id="estado" name="estado">
                <option value="operativa" <?php echo ($impresora['estado'] == 'operativa') ? 'selected' : ''; ?>>Operativa</option>
                <option value="mantenimiento" <?php echo ($impresora['estado'] == 'mantenimiento') ? 'selected' : ''; ?>>Mantenimiento</option>
                <option value="fuera de servicio" <?php echo ($impresora['estado'] == 'fuera de servicio') ? 'selected' : ''; ?>>Fuera de servicio</option>
            </select>

            <button type="submit">Actualizar Impresora</button>
        </form>
    </div>
</body>
</html>

<?php
// Cerrar las conexiones
$stmt->close();
if (isset($stmt_update)) {
    $stmt_update->close();
}
$conn->close();
?>
