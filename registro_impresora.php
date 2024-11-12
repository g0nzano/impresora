<?php
// Configuración de la base de datos
$host = 'localhost';
$dbname = 'control_impresoras';
$username = 'root';  // Cambia esto si tienes un nombre de usuario diferente
$password = '';  // Cambia esto si tienes una contraseña establecida

// Conectar a MySQL
$conn = new mysqli($host, $username, $password, $dbname);

// Comprobar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener datos del formulario
$modelo = $_POST['modelo'];
$nombre = $_POST['nombre'];
$contador_negro = $_POST['contador_negro'];
$contador_color = $_POST['contador_color'];
$fecha_instalacion = $_POST['fecha_instalacion'];
$lugar = $_POST['lugar'];
$sector = $_POST['sector'];
$estado = $_POST['estado'];

// Insertar en la base de datos
$sql = "INSERT INTO impresoras (modelo, nombre, contador_negro, contador_color, fecha_instalacion, lugar, sector, estado)
        VALUES ('$modelo', '$nombre', '$contador_negro', '$contador_color', '$fecha_instalacion', '$lugar', '$sector', '$estado')";

if ($conn->query($sql) === TRUE) {
    echo "Impresora registrada exitosamente.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Cerrar la conexión
$conn->close();
?>
