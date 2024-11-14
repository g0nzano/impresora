<?php
// Conectar a la base de datos
$conn = new mysqli('localhost', 'root', '', 'gestion_impresoras');
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener datos del formulario, con validación condicional para `total_impresiones`
$marca_id = $_POST['marca_id'] ?? null;
$modelo_id = $_POST['modelo_id'] ?? null;
$total_impresiones = $_POST['total_impresiones'] ?? null; // Verificación condicional
$contador_negro = $_POST['contador_negro'] ?? 0;
$contador_color = $_POST['contador_color'] ?? 0;
$fecha_instalacion = $_POST['fecha_instalacion'] ?? null;
$lugar = $_POST['lugar'] ?? '';
$sector = $_POST['sector'] ?? '';
$estado = $_POST['estado'] ?? '';

// Asegurarse de que todos los campos requeridos están definidos
if (!$marca_id || !$modelo_id || !$fecha_instalacion || !$lugar || !$sector || !$estado) {
    die("Error: Todos los campos obligatorios deben completarse.");
}

// Construir la consulta de inserción para impresoras
$sql = "INSERT INTO impresoras (marca_id, modelo_id, contador_negro, contador_color, fecha_instalacion, lugar, sector, estado)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Error en la preparación de la consulta: " . $conn->error);
}

// Vincular los parámetros y ejecutar la consulta
$stmt->bind_param("iiiiisss", $marca_id, $modelo_id, $contador_negro, $contador_color, $fecha_instalacion, $lugar, $sector, $estado);

if ($stmt->execute()) {
    $impresora_id = $stmt->insert_id;

    // Procesar la imagen del reporte si se cargó
    if (isset($_FILES['foto_reporte']) && $_FILES['foto_reporte']['error'] == 0) {
        $foto_reporte = $_FILES['foto_reporte'];
        $ruta_destino = 'uploads/' . basename($foto_reporte['name']);
        
        // Mover la imagen al servidor
        if (move_uploaded_file($foto_reporte['tmp_name'], $ruta_destino)) {
            // Guardar la ruta de la imagen en la tabla imagenes_reportes
            $sql_imagen = "INSERT INTO imagenes_reportes (impresora_id, ruta_imagen) VALUES (?, ?)";
            $stmt_imagen = $conn->prepare($sql_imagen);
            if ($stmt_imagen) {
                $stmt_imagen->bind_param("is", $impresora_id, $ruta_destino);
                $stmt_imagen->execute();
                $stmt_imagen->close();
            } else {
                echo "Error en la consulta para la imagen: " . $conn->error;
            }
        } else {
            echo "Error al mover la imagen al servidor.";
        }
    }

    echo "Impresora registrada exitosamente.";
} else {
    echo "Error al registrar la impresora: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
