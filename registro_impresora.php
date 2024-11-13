<?php
// Conectar a la base de datos
$conn = new mysqli('localhost', 'root', '', 'gestion_impresoras');

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener modelos de la base de datos
$modelos_result = $conn->query("SELECT id, nombre_modelo FROM modelos");
if (!$modelos_result) {
    die("Error en la consulta de modelos: " . $conn->error);
}

// Obtener nombres de la base de datos
$nombres_result = $conn->query("SELECT id, nombre_impresora FROM nombres");
if (!$nombres_result) {
    die("Error en la consulta de nombres: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Nueva Impresora</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Registrar Nueva Impresora</h1>
        <form action="guardar_impresora.php" method="POST">
            <!-- Seleccionar Modelo -->
            <label for="modelo_id">Modelo:</label>
            <select id="modelo_id" name="modelo_id" required>
                <option value="">Seleccione un modelo</option>
                <?php while ($row = $modelos_result->fetch_assoc()): ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre_modelo']; ?></option>
                <?php endwhile; ?>
            </select>

            <!-- Seleccionar Nombre -->
            <label for="nombre_id">Nombre:</label>
            <select id="nombre_id" name="nombre_id" required>
                <option value="">Seleccione un nombre</option>
                <?php while ($row = $nombres_result->fetch_assoc()): ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre_impresora']; ?></option>
                <?php endwhile; ?>
            </select>

            <!-- Ingresar Número de Serie -->
            <label for="numero_serie">Número de Serie:</label>
            <input type="text" id="numero_serie" name="numero_serie" required>

            <!-- Otros Campos -->
            <label for="contador_negro">Contador Negro:</label>
            <input type="number" id="contador_negro" name="contador_negro" value="0" required>

            <label for="contador_color">Contador Color:</label>
            <input type="number" id="contador_color" name="contador_color" value="0" required>

            <label for="fecha_instalacion">Fecha de Instalación:</label>
            <input type="date" id="fecha_instalacion" name="fecha_instalacion" required>

            <label for="lugar">Lugar:</label>
            <input type="text" id="lugar" name="lugar" required>

            <label for="sector">Sector:</label>
            <input type="text" id="sector" name="sector" required>

            <label for="estado">Estado:</label>
            <select id="estado" name="estado">
                <option value="operativa">Operativa</option>
                <option value="mantenimiento">Mantenimiento</option>
                <option value="fuera de servicio">Fuera de servicio</option>
            </select>

            <button type="submit">Registrar Impresora</button>
        </form>
    </div>
</body>
</html>

<?php
// Cerrar la conexión
$conn->close();
?>
