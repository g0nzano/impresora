<?php
// Conectar a la base de datos
$conn = new mysqli('localhost', 'root', '', 'control_impresoras');

// Comprobar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consultar impresoras
$sql = "SELECT * FROM impresoras";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de Impresoras</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Control de Impresoras</h1>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Modelo</th>
                    <th>Nombre</th>
                    <th>Contador Negro</th>
                    <th>Contador Color</th>
                    <th>Total Impresiones</th>
                    <th>Fecha de Instalación</th>
                    <th>Lugar</th>
                    <th>Sector</th>
                    <th>Estado</th>
                    <th>Fecha de Registro</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['modelo'] . "</td>";
                        echo "<td>" . $row['nombre'] . "</td>";
                        echo "<td>" . $row['contador_negro'] . "</td>";
                        echo "<td>" . $row['contador_color'] . "</td>";
                        echo "<td>" . $row['total_impresiones'] . "</td>";
                        echo "<td>" . $row['fecha_instalacion'] . "</td>";
                        echo "<td>" . $row['lugar'] . "</td>";
                        echo "<td>" . $row['sector'] . "</td>";
                        echo "<td>" . $row['estado'] . "</td>";
                        echo "<td>" . $row['fecha_cadastro'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='11'>No hay impresoras registradas</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
// Cerrar la conexión
$conn->close();
?>
