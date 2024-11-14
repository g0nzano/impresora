<?php
// Conectar a la base de datos
$conn = new mysqli('localhost', 'root', '', 'gestion_impresoras');

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener marcas de la base de datos
$marcas_result = $conn->query("SELECT id, nombre_marca FROM marcas");
if (!$marcas_result) {
    die("Error en la consulta de marcas: " . $conn->error);
}

// Obtener modelos de la base de datos
$modelos_result = $conn->query("SELECT id, nombre_modelo, marca_id FROM modelos");
if (!$modelos_result) {
    die("Error en la consulta de modelos: " . $conn->error);
}

// Preparar los modelos en un array asociativo por marca
$modelos_por_marca = [];
while ($row = $modelos_result->fetch_assoc()) {
    $modelos_por_marca[$row['marca_id']][] = $row;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Nueva Impresora</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        // JavaScript para actualizar los modelos en función de la marca seleccionada
        document.addEventListener("DOMContentLoaded", function() {
            const modelosPorMarca = <?php echo json_encode($modelos_por_marca); ?>;
            const marcaSelect = document.getElementById("marca_id");
            const modeloSelect = document.getElementById("modelo_id");

            marcaSelect.addEventListener("change", function() {
                const marcaId = this.value;

                // Limpiar el campo de modelos
                modeloSelect.innerHTML = '<option value="">Seleccione un modelo</option>';

                // Agregar modelos correspondientes a la marca seleccionada
                if (modelosPorMarca[marcaId]) {
                    modelosPorMarca[marcaId].forEach(function(modelo) {
                        const option = document.createElement("option");
                        option.value = modelo.id;
                        option.textContent = modelo.nombre_modelo;
                        modeloSelect.appendChild(option);
                    });
                }
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <h1>Registrar Nueva Impresora</h1>
        <form action="guardar_impresora.php" method="POST">
            <!-- Seleccionar Marca -->
            <label for="marca_id">Marca:</label>
            <select id="marca_id" name="marca_id" required>
                <option value="">Seleccione una marca</option>
                <?php while ($row = $marcas_result->fetch_assoc()): ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre_marca']; ?></option>
                <?php endwhile; ?>
            </select>

            <!-- Seleccionar Modelo -->
            <label for="modelo_id">Modelo:</label>
            <select id="modelo_id" name="modelo_id" required>
                <option value="">Seleccione un modelo</option>
                <!-- Los modelos se cargarán dinámicamente según la marca seleccionada -->
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
