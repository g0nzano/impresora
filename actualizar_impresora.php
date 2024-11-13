<?php
// Conectar a la base de datos
$conn = new mysqli('localhost', 'root', '', 'gestion_impresoras');

// Comprobar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verificar si se ha proporcionado el ID en la URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Obtener los datos actuales de la impresora
    $sql = "SELECT * FROM impresoras WHERE id = $id";
    $result = $conn->query($sql);

    // Verificar que la impresora exista
    if ($result && $result->num_rows > 0) {
        $impresora = $result->fetch_assoc();
    } else {
        die("Impresora no encontrada.");
    }
} else {
    die("ID de impresora no proporcionado.");
}

// Procesar el formulario al enviar
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $sector = $_POST['sector'];
    $estado = $_POST['estado'];
    $fecha_actualizacion = date('Y-m-d H:i:s');

    // Actualizar la tabla principal con los campos permitidos
    $update_sql = "UPDATE impresoras SET nombre = '$nombre', sector = '$sector', estado = '$estado', fecha_actualizacion = '$fecha_actualizacion' 
                   WHERE id = $id";

    if ($conn->query($update_sql) === TRUE) {
        echo "Impresora actualizada exitosamente.";
    } else {
        echo "Error al actualizar la impresora: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Impresora</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Actualizar Impresora - <?php echo $impresora['nombre']; ?></h1>

        <form action="" method="POST">
            <label for="modelo">Modelo:</label>
            <input type="text" id="modelo" name="modelo" value="<?php echo $impresora['modelo']; ?>" readonly>

            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo $impresora['nombre']; ?>" required>

            <label for="sector">Sector:</label>
            <input type="text" id="sector" name="sector" value="<?php echo $impresora['sector']; ?>" required>

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
// Cerrar la conexión
$conn->close();
?>
