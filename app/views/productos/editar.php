<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        form { max-width: 400px; }
        label { display: block; margin-top: 10px; }
        input, select { width: 100%; padding: 6px; margin-top: 4px; }
        button { margin-top: 15px; padding: 8px 15px; background: #007bff; color: white; border: none; border-radius: 3px; cursor: pointer; }
        .error { color: red; margin-top: 10px; }
    </style>
</head>
<body>
    <h1>Editar Producto</h1>
    <a href="index.php?accion=index">← Volver al listado</a>

    <?php if (!empty($error)): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST" action="index.php?accion=actualizar">
        <input type="hidden" name="id" value="<?= $producto->getId() ?>">

        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?= htmlspecialchars($producto->getNombre()) ?>" required>

        <label>SKU:</label>
        <input type="text" name="sku" value="<?= htmlspecialchars($producto->getSku()) ?>" required>

        <label>Precio de venta:</label>
        <input type="number" name="precio_venta" step="0.01" min="0" value="<?= $producto->getPrecioVenta() ?>" required>

        <label>Stock actual:</label>
        <input type="number" name="stock_actual" min="0" value="<?= $producto->getStockActual() ?>" required>

        <label>Stock mínimo:</label>
        <input type="number" name="stock_minimo" min="0" value="<?= $producto->getStockMinimo() ?>" required>

        <label>Tipo:</label>
        <select name="tipo">
            <option value="estandar" <?= $producto->getTipo() === 'estandar' ? 'selected' : '' ?>>Estándar</option>
            <option value="fragil" <?= $producto->getTipo() === 'fragil' ? 'selected' : '' ?>>Frágil</option>
            <option value="perecedero" <?= $producto->getTipo() === 'perecedero' ? 'selected' : '' ?>>Perecedero</option>
        </select>

        <button type="submit">Actualizar</button>
    </form>
</body>
</html>