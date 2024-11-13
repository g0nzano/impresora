<?php
$conn = new mysqli('localhost', 'root', '', 'gestion_impresoras');

$sql = "SELECT * FROM impresoras";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Impresoras</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h1>Listado de Impresoras</h1>
    <div class="table-container">
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
                    <th>Fecha de Actualización</th>
                    <th>Acciones</th>
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
                        echo "<td>" . $row['fecha_registro'] . "</td>";
                        echo "<td>" . $row['fecha_actualizacion'] . "</td>";
                        echo "<td><a href='actualizar_impresora.php?id=" . $row['id'] . "'>Actualizar</a></td>";
                       
                        echo "<td><a href='ver_historial.php?id=" . $row['id'] . "'>Ver Historial</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='13'>No hay impresoras registradas</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php
$conn->close();
?>
