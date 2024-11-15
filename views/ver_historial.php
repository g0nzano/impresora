<?php
// Conectar a la base de datos
$conn = new mysqli('localhost', 'root', '', 'gestion_impresoras');

// Comprobar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verificar si se ha proporcionado el ID de la impresora en la URL y que sea un número
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta para obtener el historial de la impresora especificada
    $sql = "SELECT * FROM historial_impresoras WHERE id_impresora = ? ORDER BY fecha_actualizacion DESC";
    $stmt = $conn->prepare($sql);

    // Verificar si la consulta se preparó correctamente
    if ($stmt === false) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    // Enlazar parámetros y ejecutar la consulta
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result === false) {
        die("Error en la ejecución de la consulta: " . $conn->error);
    }
} else {
    die("ID de impresora no proporcionado o no válido.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Impresora</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Historial de Cambios - Impresora ID <?php echo htmlspecialchars($id); ?></h1>

        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID Historial</th>
                        <th>Contador Negro</th>
                        <th>Contador Color</th>
                        <th>Total Impresiones</th>
                        <th>Estado</th>
                        <th>Fecha de Actualización</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['contador_negro']); ?></td>
                            <td><?php echo htmlspecialchars($row['contador_color']); ?></td>
                            <td><?php echo htmlspecialchars($row['total_impresiones']); ?></td>
                            <td><?php echo htmlspecialchars($row['estado']); ?></td>
                            <td><?php echo htmlspecialchars($row['fecha_actualizacion']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay registros en el historial para esta impresora.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
// Cerrar la consulta y la conexión
$stmt->close();
$conn->close();
?>
