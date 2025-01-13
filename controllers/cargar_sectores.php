<?php
$conn = new mysqli('localhost', 'root', '', 'gestion_impresoras');

if (isset($_GET['lugar_id'])) {
    $lugar_id = $_GET['lugar_id'];
    $result = $conn->query("SELECT id, nombre_sector FROM sectores WHERE lugar_id = $lugar_id");
    echo '<option value="">Seleccione un sector</option>';
    while ($row = $result->fetch_assoc()) {
        echo '<option value="' . $row['id'] . '">' . $row['nombre_sector'] . '</option>';
    }
}
?>
