<?php
// Conectar a la base de datos
$conn = new mysqli('localhost', 'root', '', 'gestion_impresoras');

session_start();

// Verificar si el usuario ha iniciado sesión y tiene el rol adecuado
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header('Location: ../views/login.php'); // Redirige al login si no es admin
    exit;
}

// Comprobar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta para obtener impresoras con sus modelos y nombres correspondientes
$sql = "SELECT impresoras.id, modelos.nombre_modelo AS modelo, nombres.nombre_impresora AS nombre,
               impresoras.contador_negro, impresoras.contador_color, impresoras.total_impresiones,
               impresoras.fecha_instalacion, impresoras.lugar, impresoras.sector, impresoras.estado,
               impresoras.fecha_registro, impresoras.fecha_actualizacion
        FROM impresoras
        LEFT JOIN modelos ON impresoras.modelo_id = modelos.id
        LEFT JOIN nombres ON impresoras.nombre_id = nombres.id";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cargar Contadores</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Cargar Contadores de Impresoras</h1>

        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Modelo</th>
                        <th>Nombre</th>
                        <th>Contador Negro</th>
                        <th>Contador Color</th>
                        <th>Total Impresiones</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <form action="actualizar_contadores.php" method="POST">
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['modelo']; ?></td>
                                <td><?php echo $row['nombre']; ?></td>
                                <td><input type="number" name="contador_negro" value="<?php echo $row['contador_negro']; ?>" required></td>
                                <td><input type="number" name="contador_color" value="<?php echo $row['contador_color']; ?>" required></td>
                                <td><?php echo $row['total_impresiones']; ?></td>
                                <td>
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button type="submit">Actualizar</button>
                                </td>
                            </form>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay impresoras registradas.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>
