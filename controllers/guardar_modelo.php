<?php
$conn = new mysqli('localhost', 'root', '', 'gestion_impresoras');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_modelo = $_POST['nombre_modelo'];
    $marca_id = $_POST['marca_id'];
    $sql = "INSERT INTO modelos (nombre_modelo, marca_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $nombre_modelo, $marca_id);
    $stmt->execute();
    echo json_encode(['id' => $stmt->insert_id, 'nombre_modelo' => $nombre_modelo]);
}
