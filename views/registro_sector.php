<?php
// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'gestion_impresoras');

// Procesar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_sector = $_POST['nombre_sector'];
    $lugar_id = $_POST['lugar_id'];
    $sql = "INSERT INTO sectores (nombre_sector, lugar_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $nombre_sector, $lugar_id);
    if ($stmt->execute()) {
        echo "Sector registrado exitosamente.";
    } else {
        echo "Error al registrar el sector: " . $stmt->error;
    }
    $stmt->close();
}

// Obtener lugares para la selección
$lugares = $conn->query("SELECT * FROM lugares");
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Sector</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Registrar Nuevo Sector</h1>
        <form action="" method="POST">
            <label for="lugar_id">Lugar:</label>
            <select id="lugar_id" name="lugar_id" required>
                <option value="">Seleccione un Lugar</option>
                <?php while ($lugar = $lugares->fetch_assoc()): ?>
                    <option value="<?php echo $lugar['id']; ?>"><?php echo $lugar['nombre_lugar']; ?></option>
                <?php endwhile; ?>
            </select>

            <label for="nombre_sector">Nombre del Sector:</label>
            <input type="text" id="nombre_sector" name="nombre_sector" required>
            <button type="submit">Guardar Sector</button>
        </form>
    </div>
</body>
</html>
