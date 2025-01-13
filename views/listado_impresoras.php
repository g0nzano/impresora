<?php
// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'gestion_impresoras');

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta SQL
$sql = "
SELECT 
    impresoras.id,
    modelos.nombre_modelo AS modelo,
    nombres.nombre_impresora AS nombre,
    marcas.nombre_marca AS marca,
    series.numero_serie AS numero_serie,
    impresoras.contador_negro,
    impresoras.contador_color,
    impresoras.total_impresiones,
    impresoras.fecha_instalacion,
    impresoras.lugar,
    impresoras.sector,
    impresoras.fecha_actualizacion,
    impresoras.estado,
    impresoras.fecha_registro
FROM impresoras
LEFT JOIN modelos ON impresoras.modelo_id = modelos.id
LEFT JOIN nombres ON impresoras.nombre_id = nombres.id
LEFT JOIN marcas ON impresoras.marca_id = marcas.id
LEFT JOIN series ON series.id_impresora = impresoras.id;
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Impresoras</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
<div class="container">
    <h1>Listado de Impresoras</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Modelo</th>
                <th>Nombre</th>
                <th>Marca</th>
                <th>Número de Serie</th>
                <th>Contador Negro</th>
                <th>Contador Color</th>
                <th>Total Impresiones</th>
                <th>Lugar</th>
                <th>Sector</th>
                <th>Estado</th>
                <th>Fecha de Registro</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['modelo']; ?></td>
                        <td><?php echo $row['nombre']; ?></td>
                        <td><?php echo $row['marca']; ?></td>
                        <td><?php echo $row['numero_serie']; ?></td>
                        <td><?php echo $row['contador_negro']; ?></td>
                        <td><?php echo $row['contador_color']; ?></td>
                        <td><?php echo $row['total_impresiones']; ?></td>
                        <td><?php echo $row['lugar']; ?></td>
                        <td><?php echo $row['sector']; ?></td>
                        <td><?php echo $row['estado']; ?></td>
                        <td><?php echo $row['fecha_registro']; ?></td>
                        <td>
                        <a href="../controllers/actualizar_impresora.php?id=<?php echo $row['id']; ?>">Actualizar</a> |
                        <a href="../views/ver_historial.php?id=<?php echo $row['id']; ?>">Ver Historial</a>
                        </td>

                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="12">No se encontraron impresoras.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>

<?php
$conn->close();
?>
