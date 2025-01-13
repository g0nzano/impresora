<?php
// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'gestion_impresoras');

// Procesar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_modelo = $_POST['nombre_modelo'];
    $tipo_impresion = $_POST['tipo_impresion'];
    $velocidad_impresion = $_POST['velocidad_impresion'];
    $tipo_dispositivo = $_POST['tipo_dispositivo'];
    $marca_id = $_POST['marca_id'];

    $sql = "INSERT INTO modelos (nombre_modelo, tipo_impresion, velocidad_impresion, tipo_dispositivo, marca_id)
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $nombre_modelo, $tipo_impresion, $velocidad_impresion, $tipo_dispositivo, $marca_id);
    if ($stmt->execute()) {
        echo "Modelo registrado exitosamente.";
    } else {
        echo "Error al registrar el modelo: " . $stmt->error;
    }
    $stmt->close();
}

// Obtener marcas para la selección
$marcas = $conn->query("SELECT * FROM marcas");
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Modelo</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Registrar Nuevo Modelo</h1>
        <form action="" method="POST">
            <label for="marca_id">Marca:</label>
            <select id="marca_id" name="marca_id" required>
                <option value="">Seleccione una Marca</option>
                <?php while ($marca = $marcas->fetch_assoc()): ?>
                    <option value="<?php echo $marca['id']; ?>"><?php echo $marca['nombre_marca']; ?></option>
                <?php endwhile; ?>
            </select>

            <label for="nombre_modelo">Nombre del Modelo:</label>
            <input type="text" id="nombre_modelo" name="nombre_modelo" required>

            <label for="tipo_impresion">Tipo de Impresión:</label>
            <select id="tipo_impresion" name="tipo_impresion" required>
                <option value="Blanco y Negro">Blanco y Negro</option>
                <option value="Blanco con Negro y Color">Blanco con Negro y Color</option>
                <option value="Matricial">Matricial</option>
            </select>

            <label for="velocidad_impresion">Velocidad de Impresión:</label>
            <select id="velocidad_impresion" name="velocidad_impresion" required>
                <option value="Blanco y Negro">Blanco y Negro</option>
                <option value="Blanco con Negro y Color">Blanco con Negro y Color</option>
            </select>

            <label for="tipo_dispositivo">Tipo de Dispositivo:</label>
            <select id="tipo_dispositivo" name="tipo_dispositivo" required>
                <option value="Impresora">Impresora</option>
                <option value="Fotocopiadora">Fotocopiadora</option>
                <option value="Escáner">Escáner</option>
                <option value="Multifuncional">Multifuncional</option>
            </select>

            <button type="submit">Guardar Modelo</button>
        </form>
    </div>
</body>
</html>
