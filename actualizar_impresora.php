<?php
// Conectar a la base de datos
$conn = new mysqli('localhost', 'root', '', 'control_impresoras');

// Comprobar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener ID de la impresora a actualizar
$id = $_GET['id'];

// Obtener los datos actuales de la impresora
$sql = "SELECT * FROM impresoras WHERE id = $id";
$result = $conn->query($sql);
$impresora = $result->fetch_assoc();

// Actualizar datos al enviar el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $contador_negro = $_POST['contador_negro'];
    $contador_color = $_POST['contador_color'];
    $estado = $_POST['estado'];
    $total_impresiones = $contador_negro + $contador_color;

    // Actualizar en la base de datos
    $update_sql = "UPDATE impresoras SET contador_negro = '$contador_negro', contador_color = '$contador_color', total_impresiones = '$total_impresiones', estado = '$estado' WHERE id = $id";

    if ($conn->query($update_sql) === TRUE) {
        echo "Impresora actualizada exitosamente.";
    } else {
        echo "Error: " . $update_sql . "<br>" . $conn->error;
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
        <h1>Actualizar Impresora</h1>
        
        <form action="" method="POST">
            <label for="modelo">Modelo:</label>
            <input type="text" id="modelo" name="modelo" value="<?php echo $impresora['modelo']; ?>" readonly>

            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo $impresora['nombre']; ?>" readonly>

            <label for="contador_negro">Contador de Impresiones en Negro:</label>
            <input type="number" id="contador_negro" name="contador_negro" value="<?php echo $impresora['contador_negro']; ?>" required>

            <label for="contador_color">Contador de Impresiones a Color:</label>
            <input type="number" id="contador_color" name="contador_color" value="<?php echo $impresora['contador_color']; ?>" required>

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
