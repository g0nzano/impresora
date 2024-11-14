<?php
// Conectar a la base de datos
$conn = new mysqli('localhost', 'root', '', 'gestion_impresoras');

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Procesar formulario de registro de marca
if (isset($_POST['nueva_marca'])) {
    $nombre_marca = $_POST['nombre_marca'];
    
    // Insertar la nueva marca
    $sql = "INSERT INTO marcas (nombre_marca) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nombre_marca);
    
    if ($stmt->execute()) {
        echo "Marca registrada exitosamente.";
    } else {
        echo "Error al registrar la marca: " . $stmt->error;
    }
    $stmt->close();
}

// Procesar eliminación de marca
if (isset($_POST['eliminar_marca'])) {
    $marca_id = $_POST['marca_id'];
    $sql = "DELETE FROM marcas WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $marca_id);
    
    if ($stmt->execute()) {
        echo "Marca eliminada exitosamente.";
    } else {
        echo "Error al eliminar la marca: " . $stmt->error;
    }
    $stmt->close();
}

// Obtener marcas existentes para el formulario de modelos y listado de marcas
$marcas_result = $conn->query("SELECT id, nombre_marca FROM marcas");

// Procesar formulario de registro de modelo
if (isset($_POST['nuevo_modelo'])) {
    $nombre_modelo = $_POST['nombre_modelo'];
    $marca_id = $_POST['marca_id'];
    $tipo_impresion = $_POST['tipo_impresion'];
    
    // Insertar el nuevo modelo asociado a la marca seleccionada
    $sql = "INSERT INTO modelos (nombre_modelo, marca_id, tipo_impresion) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sis", $nombre_modelo, $marca_id, $tipo_impresion);
    
    if ($stmt->execute()) {
        echo "Modelo registrado exitosamente.";
    } else {
        echo "Error al registrar el modelo: " . $stmt->error;
    }
    $stmt->close();
}

// Procesar eliminación de modelo
if (isset($_POST['eliminar_modelo'])) {
    $modelo_id = $_POST['modelo_id'];
    $sql = "DELETE FROM modelos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $modelo_id);
    
    if ($stmt->execute()) {
        echo "Modelo eliminado exitosamente.";
    } else {
        echo "Error al eliminar el modelo: " . $stmt->error;
    }
    $stmt->close();
}

// Obtener modelos existentes para listado
$modelos_result = $conn->query("SELECT modelos.id, modelos.nombre_modelo, modelos.tipo_impresion, marcas.nombre_marca 
                                FROM modelos 
                                JOIN marcas ON modelos.marca_id = marcas.id");

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar y Administrar Marcas y Modelos</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Registrar Nueva Marca</h1>
        <form action="" method="POST">
            <label for="nombre_marca">Nombre de la Marca:</label>
            <input type="text" id="nombre_marca" name="nombre_marca" required>
            <button type="submit" name="nueva_marca">Registrar Marca</button>
        </form>

        <h2>Listado de Marcas</h2>
        <ul>
            <?php while ($marca = $marcas_result->fetch_assoc()): ?>
                <li>
                    <?php echo htmlspecialchars($marca['nombre_marca']); ?>
                    <form action="" method="POST" style="display:inline;">
                        <input type="hidden" name="marca_id" value="<?php echo $marca['id']; ?>">
                        <button type="submit" name="eliminar_marca">Eliminar</button>
                    </form>
                </li>
            <?php endwhile; ?>
        </ul>

        <h1>Registrar Nuevo Modelo</h1>
        <form action="" method="POST">
            <label for="marca_id">Marca:</label>
            <select id="marca_id" name="marca_id" required>
                <option value="">Seleccione una marca</option>
                <?php 
                // Reiniciar el puntero del resultado de marcas para reutilizarlo
                $marcas_result->data_seek(0);
                while ($row = $marcas_result->fetch_assoc()): ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['nombre_marca']); ?></option>
                <?php endwhile; ?>
            </select>

            <label for="nombre_modelo">Nombre del Modelo:</label>
            <input type="text" id="nombre_modelo" name="nombre_modelo" required>

            <label for="tipo_impresion">Tipo de Impresión:</label>
            <select id="tipo_impresion" name="tipo_impresion" required>
                <option value="Blanco y Negro">BLANCO & NEGRO</option>
                <option value="Blanco y Negro y Colorido">BN & COLOR</option>
            </select>

            <button type="submit" name="nuevo_modelo">Registrar Modelo</button>
        </form>

        <h2>Listado de Modelos</h2>
        <ul>
            <?php while ($modelo = $modelos_result->fetch_assoc()): ?>
                <li>
                    <?php echo htmlspecialchars($modelo['nombre_marca'] . " - " . $modelo['nombre_modelo'] . " (" . $modelo['tipo_impresion'] . ")"); ?>
                    <form action="" method="POST" style="display:inline;">
                        <input type="hidden" name="modelo_id" value="<?php echo $modelo['id']; ?>">
                        <button type="submit" name="eliminar_modelo">Eliminar</button>
                    </form>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>
</body>
</html>
