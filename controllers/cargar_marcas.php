<?php
$marcas = $conn->query("SELECT id, nombre_marca FROM marcas");
?>
<label for="marca">Marca:</label>
<select id="marca" name="marca" required>
    <option value="">Seleccione una marca</option>
    <?php while ($marca = $marcas->fetch_assoc()): ?>
        <option value="<?php echo $marca['id']; ?>"><?php echo $marca['nombre_marca']; ?></option>
    <?php endwhile; ?>
</select>
