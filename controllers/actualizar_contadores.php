<?php
// Conectar a la base de datos
$conn = new mysqli('localhost', 'root', '', 'gestion_impresoras');

// Comprobar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener datos del formulario
$id = $_POST['id'];
$nuevo_contador_negro = $_POST['contador_negro'];
$nuevo_contador_color = $_POST['contador_color'];

// Obtener los contadores actuales para verificar
$sql = "SELECT contador_negro, contador_color FROM impresoras WHERE id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$contador_actual_negro = $row['contador_negro'];
$contador_actual_color = $row['contador_color'];

// Verificar que los nuevos contadores no sean menores que los actuales
if ($nuevo_contador_negro >= $contador_actual_negro && $nuevo_contador_color >= $contador_actual_color) {
    // Calcular el nuevo total de impresiones
    $total_impresiones = $nuevo_contador_negro + $nuevo_contador_color;
    $fecha_actualizacion = date('Y-m-d H:i:s');

    // Actualizar la tabla principal
    $update_sql = "UPDATE impresoras SET contador_negro = '$nuevo_contador_negro', contador_color = '$nuevo_contador_color', 
                   total_impresiones = '$total_impresiones', fecha_actualizacion = '$fecha_actualizacion' WHERE id = $id";

    if ($conn->query($update_sql) === TRUE) {
        // Guardar en el historial
        $historial_sql = "INSERT INTO historial_impresoras (id_impresora, contador_negro, contador_color, total_impresiones, 
                           estado, fecha_actualizacion) VALUES ('$id', '$nuevo_contador_negro', '$nuevo_contador_color', 
                           '$total_impresiones', (SELECT estado FROM impresoras WHERE id = $id), '$fecha_actualizacion')";

        if ($conn->query($historial_sql) === TRUE) {
            echo "Contadores actualizados y registro guardado en el historial.";
        } else {
            echo "Error al guardar en el historial: " . $conn->error;
        }
    } else {
        echo "Error al actualizar los contadores: " . $conn->error;
    }
} else {
    echo "Error: Los nuevos contadores no pueden ser menores que los contadores actuales.";
}

$conn->close();
?>
