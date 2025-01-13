<?php
$conn = new mysqli('localhost', 'root', '', 'gestion_impresoras');
if (isset($_GET['marca_id'])) {
    $marca_id = $_GET['marca_id'];
    $result = $conn->query("SELECT id, nombre_modelo FROM modelos WHERE marca_id = $marca_id");
    echo '<option value="">Seleccione un modelo</option>';
    while ($row = $result->fetch_assoc()) {
        echo '<option value="' . $row['id'] . '">' . $row['nombre_modelo'] . '</option>';
    }
}
?>
