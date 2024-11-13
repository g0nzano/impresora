<?php
// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'gestion_impresoras');

// Obtener datos del formulario
$modelo = $_POST['modelo'];
$nombre = $_POST['nombre'];
$contador_negro = $_POST['contador_negro'];
$contador_color = $_POST['contador_color'];
$fecha_instalacion = $_POST['fecha_instalacion'];
$lugar = $_POST['lugar'];
$sector = $_POST['sector'];
$estado = $_POST['estado'];
$numero_serie = $_POST['numero_serie'];

// Insertar la impresora en la tabla impresoras
$sql = "INSERT INTO impresoras (modelo, nombre, contador_negro, contador_color, fecha_instalacion, lugar, sector, estado)
        VALUES ('$modelo', '$nombre', '$contador_negro', '$contador_color', '$fecha_instalacion', '$lugar', '$sector', '$estado')";

if ($conn->query($sql) === TRUE) {
    $id_impresora = $conn->insert_id;

    // Insertar el número de serie en la tabla series
    $sql_serie = "INSERT INTO series (numero_serie, id_impresora) VALUES ('$numero_serie', '$id_impresora')";
    if ($conn->query($sql_serie) === TRUE) {
        echo "Impresora registrada exitosamente con número de serie.";
    } else {
        echo "Error al registrar el número de serie: " . $conn->error;
    }
} else {
    echo "Error al registrar la impresora: " . $conn->error;
}

$conn->close();
?>
