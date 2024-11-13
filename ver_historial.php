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

    // Obtener el nombre y sector de la impresora
    $info_sql = "SELECT nombre, sector FROM impresoras WHERE id = ?";
    $stmt_info = $conn->prepare($info_sql);
    $stmt_info->bind_param("i", $id);
    $stmt_info->execute();
    $result_info = $stmt_info->get_result();
    
    if ($result_info && $result_info->num_rows > 0) {
        $impresora_info = $result_info->fetch_assoc();
        $nombre = $impresora_info['nombre'];
        $sector = $impresora_info['sector'];
    } else {
        die("Impresora no encontrada.");
    }

    // Consultar el historial de la impresora especificada
    $sql = "SELECT * FROM historial_impresoras WHERE id_impresora = ? ORDER BY fecha_actualizacion DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result === false) {
        die("Error en la consulta SQL: " . $conn->error);
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
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Historial de Cambios - <?php echo htmlspecialchars($nombre); ?> (Sector: <?php echo htmlspecialchars($sector); ?>)</h1>

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
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['contador_negro']; ?></td>
                            <td><?php echo $row['contador_color']; ?></td>
                            <td><?php echo $row['total_impresiones']; ?></td>
                            <td><?php echo $row['estado']; ?></td>
                            <td><?php echo $row['fecha_actualizacion']; ?></td>
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
// Cerrar la conexión
$stmt->close();
$stmt_info->close();
$conn->close();
?>
