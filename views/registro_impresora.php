<?php
// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'gestion_impresoras');

// Obtener marcas, lugares, sectores y estados
$marcas = $conn->query("SELECT id, nombre_marca FROM marcas");
$lugares = $conn->query("SELECT id, nombre_lugar FROM lugares");
$sectores = $conn->query("SELECT id, nombre_sector, lugar_id FROM sectores");
$estados = $conn->query("SELECT id, nombre_estado FROM estados");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Impresoras</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <h1>Registro de Impresoras</h1>
        <form action="../controllers/guardar_impresora.php" method="POST" enctype="multipart/form-data">
            <!-- Nombre -->
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo $_POST['nombre'] ?? ''; ?>" required>

            <!-- Marca -->
            <label for="marca">Marca:</label>
            <select id="marca" name="marca" required>
                <option value="">Seleccione una marca</option>
                <?php while ($marca = $marcas->fetch_assoc()): ?>
                    <option value="<?php echo $marca['id']; ?>" <?php echo (isset($_POST['marca']) && $_POST['marca'] == $marca['id']) ? 'selected' : ''; ?>>
                        <?php echo $marca['nombre_marca']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <button type="button" id="agregar-marca">Agregar Marca</button>

            <!-- Modelo -->
            <label for="modelo">Modelo:</label>
            <select id="modelo" name="modelo" required>
                <option value="">Seleccione un modelo</option>
            </select>
            <button type="button" id="agregar-modelo">Agregar Modelo</button>

            <!-- Serie -->
            <label for="numero_serie">Número de Serie:</label>
            <input type="text" id="numero_serie" name="numero_serie" value="<?php echo $_POST['numero_serie'] ?? ''; ?>" required>

            <!-- Foto -->
            <label for="foto">Foto:</label>
            <input type="file" id="foto" name="foto" accept="image/*" required>

            <!-- Lugar -->
            <label for="lugar">Lugar:</label>
            <select id="lugar" name="lugar" required>
                <option value="">Seleccione un lugar</option>
                <?php while ($lugar = $lugares->fetch_assoc()): ?>
                    <option value="<?php echo $lugar['id']; ?>" <?php echo (isset($_POST['lugar']) && $_POST['lugar'] == $lugar['id']) ? 'selected' : ''; ?>>
                        <?php echo $lugar['nombre_lugar']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <button type="button" id="agregar-lugar">Agregar Lugar</button>

            <!-- Sector -->
            <label for="sector">Sector:</label>
            <select id="sector" name="sector" required>
                <option value="">Seleccione un sector</option>
            </select>
            <button type="button" id="agregar-sector">Agregar Sector</button>

            <!-- Estado -->
            <label for="estado">Estado:</label>
            <select id="estado" name="estado" required>
                <option value="">Seleccione un estado</option>
                <?php while ($estado = $estados->fetch_assoc()): ?>
                    <option value="<?php echo $estado['id']; ?>" <?php echo (isset($_POST['estado']) && $_POST['estado'] == $estado['id']) ? 'selected' : ''; ?>>
                        <?php echo $estado['nombre_estado']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <button type="button" id="agregar-estado">Agregar Estado</button>

            <!-- Contador Negro Inicial -->
            <label for="contador_negro">Contador Negro Inicial:</label>
            <input type="number" id="contador_negro" name="contador_negro" value="<?php echo $_POST['contador_negro'] ?? 0; ?>" required>

            <!-- Contador Color Inicial -->
            <label for="contador_color">Contador Color Inicial:</label>
            <input type="number" id="contador_color" name="contador_color" value="<?php echo $_POST['contador_color'] ?? 0; ?>" required>

            <!-- Botón Guardar -->
            <button type="submit">Guardar Impresora</button>
        </form>
    </div>

    <!-- Modal y Scripts para Agregar Nuevas Opciones -->
    <script>
        // Mostrar y ocultar modales
        $('#agregar-marca').click(() => window.location.href = '../views/registro_marca.php');
        $('#agregar-modelo').click(() => window.location.href = '../views/registro_modelo.php');
        $('#agregar-lugar').click(() => window.location.href = '../views/registro_lugar.php');
        $('#agregar-sector').click(() => window.location.href = '../views/registro_sector.php');
        $('#agregar-estado').click(() => window.location.href = '../views/registro_estado.php');

        // Cargar Modelos según Marca Seleccionada
        $('#marca').change(function () {
            const marcaId = $(this).val();
            $.get('../controllers/cargar_modelos.php', { marca_id: marcaId }, function (data) {
                $('#modelo').html(data);
            });
        });

        // Cargar Sectores según Lugar Seleccionado
        $('#lugar').change(function () {
            const lugarId = $(this).val();
            $.get('../controllers/cargar_sectores.php', { lugar_id: lugarId }, function (data) {
                $('#sector').html(data);
            });
        });
    </script>
</body>
</html>
