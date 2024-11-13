<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Nueva Impresora</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Registrar Nueva Impresora</h1>
        <form action="guardar_impresora.php" method="POST">
            <label for="modelo">Modelo:</label>
            <input type="text" id="modelo" name="modelo" required>
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>
            <label for="numero_serie">Número de Serie:</label>
            <input type="text" id="numero_serie" name="numero_serie" required>
            <label for="contador_negro">Contador Negro:</label>
            <input type="number" id="contador_negro" name="contador_negro" value="0" required>
            <label for="contador_color">Contador Color:</label>
            <input type="number" id="contador_color" name="contador_color" value="0" required>
            <label for="fecha_instalacion">Fecha de Instalación:</label>
            <input type="date" id="fecha_instalacion" name="fecha_instalacion" required>
            <label for="lugar">Lugar:</label>
            <input type="text" id="lugar" name="lugar" required>
            <label for="sector">Sector:</label>
            <input type="text" id="sector" name="sector" required>
            <label for="estado">Estado:</label>
            <select id="estado" name="estado">
                <option value="operativa">Operativa</option>
                <option value="mantenimiento">Mantenimiento</option>
                <option value="fuera de servicio">Fuera de servicio</option>
            </select>
            <button type="submit">Registrar Impresora</button>
        </form>
    </div>
</body>
</html>
