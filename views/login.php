<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'gestion_impresoras');

// Verificar si hubo un error en la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_usuario = $_POST['nombre_usuario'];
    $contrasena = md5($_POST['contrasena']); // En un entorno real, usa password_hash y password_verify.

    // Verificar usuario
    $sql = "SELECT * FROM usuarios WHERE nombre_usuario = ? AND contrasena = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $nombre_usuario, $contrasena);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $_SESSION['usuario'] = $user['nombre_usuario'];
        $_SESSION['rol'] = $user['rol'];

        // Redirigir según el rol del usuario
        if ($user['rol'] === 'admin') {
          header('Location: ../views/index.php'); // Página principal para administradores
      } else {
          header('Location: ../views/usuario_contadores.php'); // Cambia "controllers" a "views" si el archivo está en la carpeta "views"
      }
      
        exit;
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
<div class="login-container">
    <h1>Iniciar Sesión</h1>
    <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
    <form method="POST" action="">
        <label for="nombre_usuario">Usuario:</label>
        <input type="text" id="nombre_usuario" name="nombre_usuario" placeholder="Ingrese su usuario" required>
        
        <label for="contrasena">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" placeholder="Ingrese su contraseña" required>
        
        <button type="submit">Iniciar Sesión</button>
    </form>
    <p>¿Olvidaste tu contraseña? <a href="#">Recuperar</a></p>
</div>
</body>
</html>
