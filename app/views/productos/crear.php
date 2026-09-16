<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo Producto</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        form { max-width: 400px; }
        label { display: block; margin-top: 10px; }
        input, select { width: 100%; padding: 6px; margin-top: 4px; }
        button { margin-top: 15px; padding: 8px 15px; background: #28a745; color: white; border: none; border-radius: 3px; cursor: pointer; }
        .error { color: red; margin-top: 10px; }
    </style>
</head>
<body>
    <h1>Nuevo Producto</h1>
    <a href="index.php?accion=index">← Volver al listado</a>

    <?php if (!empty($error)): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST" action="index.php?accion=guardar">
        <label>Nombre:</label>
        <input type="text" name="nombre" required>

        <label>SKU:</label>
        <input type="text" name="sku" required>

        <label>Precio de venta:</label>
        <input type="number" name="precio_venta" step="0.01" min="0" required>

        <label>Stock actual:</label>
        <input type="number" name="stock_actual" min="0" value="0" required>

        <label>Stock mínimo:</label>
        <input type="number" name="stock_minimo" min="0" value="0" required>

        <label>Tipo:</label>
        <select name="tipo">
            <option value="estandar">Estándar</option>
            <option value="fragil">Frágil</option>
            <option value="perecedero">Perecedero</option>
        </select>

        <button type="submit">Guardar</button>
    </form>
</body>
</html>