<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'usuario') {
    header('Location: ../views/login.php');
    exit;
}

$conn = new mysqli('localhost', 'root', '', 'gestion_impresoras');

// Validar y guardar foto
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $foto = $_FILES['foto'];

    // Validar archivo
    if ($foto['error'] === UPLOAD_ERR_OK) {
        $ruta = "../uploads/" . basename($foto['name']);
        if (move_uploaded_file($foto['tmp_name'], $ruta)) {
            $sql = "UPDATE impresoras SET foto_contador = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $ruta, $id);
            $stmt->execute();
            header('Location: usuario_contadores.php?success=1');
        } else {
            echo "Error al guardar la foto.";
        }
    } else {
        echo "Error al subir el archivo.";
    }
}
?>
