<?php
// Conectar a la base de datos
$conn = new mysqli('localhost', 'root', '', 'gestion_impresoras');

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener datos del formulario y asegurarse de que existen
$modelo_id = isset($_POST['modelo_id']) ? $_POST['modelo_id'] : null;
$nombre_id = isset($_POST['nombre_id']) ? $_POST['nombre_id'] : null;
$contador_negro = isset($_POST['contador_negro']) ? $_POST['contador_negro'] : 0;
$contador_color = isset($_POST['contador_color']) ? $_POST['contador_color'] : 0;
$fecha_instalacion = isset($_POST['fecha_instalacion']) ? $_POST['fecha_instalacion'] : null;
$lugar = isset($_POST['lugar']) ? $_POST['lugar'] : null;
$sector = isset($_POST['sector']) ? $_POST['sector'] : null;
$estado = isset($_POST['estado']) ? $_POST['estado'] : 'operativa';

// Validar que modelo_id y nombre_id tengan valores válidos
if (!$modelo_id || !$nombre_id) {
    die("Error: Debe seleccionar un modelo y un nombre para la impresora.");
}

// Preparar la consulta de inserción
$sql = "INSERT INTO impresoras (modelo_id, nombre_id, contador_negro, contador_color, fecha_instalacion, lugar, sector, estado)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Error en la preparación de la consulta: " . $conn->error);
}

// Enlazar los parámetros y ejecutar la consulta
$stmt->bind_param("iiisssss", $modelo_id, $nombre_id, $contador_negro, $contador_color, $fecha_instalacion, $lugar, $sector, $estado);

if ($stmt->execute()) {
    echo "Impresora registrada exitosamente.";
} else {
    echo "Error al registrar la impresora: " . $stmt->error;
}

// Cerrar la consulta y la conexión
$stmt->close();
$conn->close();
?>
