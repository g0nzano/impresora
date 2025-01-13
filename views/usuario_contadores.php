<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'usuario') {
    header('Location: ../views/login.php'); // Redirige al login si no es usuario normal
    exit;
}

// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'gestion_impresoras');

// Búsqueda
$filtro = $_POST['filtro'] ?? '';
$valor = $_POST['valor'] ?? '';

$result = null;
if (!empty($filtro) && !empty($valor)) {
    if ($filtro === 'serie') {
        $sql = "SELECT * FROM impresoras WHERE numero_serie = ?";
    } elseif ($filtro === 'modelo') {
        $sql = "SELECT * FROM impresoras WHERE modelo_id IN (SELECT id FROM modelos WHERE nombre_modelo LIKE ?)";
        $valor = "%$valor%";
    } elseif ($filtro === 'sector') {
        $sql = "SELECT * FROM impresoras WHERE sector LIKE ?";
        $valor = "%$valor%";
    }
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $valor);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Búsqueda de Impresoras</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
<div class="container">
    <h1>Búsqueda de Impresoras</h1>
    <form method="POST">
        <label for="filtro">Buscar por:</label>
        <select name="filtro" id="filtro" required>
            <option value="">Seleccione...</option>
            <option value="serie">Número de Serie</option>
            <option value="modelo">Modelo</option>
            <option value="sector">Sector</option>
        </select>
        <input type="text" name="valor" placeholder="Ingrese el valor de búsqueda" required>
        <button type="submit">Buscar</button>
    </form>

    <?php if ($result && $result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Modelo</th>
                    <th>Nombre</th>
                    <th>Sector</th>
                    <th>Número de Serie</th>
                    <th>Contador Negro</th>
                    <th>Contador Color</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['modelo_id']; ?></td>
                        <td><?php echo $row['nombre_id']; ?></td>
                        <td><?php echo $row['sector']; ?></td>
                        <td><?php echo $row['numero_serie']; ?></td>
                        <td><?php echo $row['contador_negro']; ?></td>
                        <td><?php echo $row['contador_color']; ?></td>
                        <td>
                            <form action="cargar_foto.php" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <input type="file" name="foto" accept="image/*" required>
                                <button type="submit">Cargar Foto</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <p>No se encontraron resultados para su búsqueda.</p>
    <?php endif; ?>
</div>
</body>
</html>
