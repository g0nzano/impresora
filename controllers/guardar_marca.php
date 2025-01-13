<?php
$conn = new mysqli('localhost', 'root', '', 'gestion_impresoras');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_marca = $_POST['nombre_marca'];
    $sql = "INSERT INTO marcas (nombre_marca) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nombre_marca);
    $stmt->execute();
    echo json_encode(['id' => $stmt->insert_id, 'nombre_marca' => $nombre_marca]);
}
