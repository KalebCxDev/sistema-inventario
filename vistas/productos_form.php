<?php
require __DIR__ . '/header.php';
$esNuevo = $producto === null;
$accionForm = $esNuevo ? 'producto_guardar.php' : 'producto_actualizar.php';

function valorCampo($producto, $getter, $default = '')
{
    if ($producto === null) return htmlspecialchars($default);
    return htmlspecialchars($producto->$getter());
}
?>

<h1><?= $esNuevo ? 'Nuevo Producto' : 'Editar Producto' ?></h1>
<a href="productos.php">← Volver al listado</a>

<?php if (!empty($error)): ?>
    <p class="error"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="POST" action="<?= $accionForm ?>">
    <?php if (!$esNuevo): ?>
        <input type="hidden" name="id" value="<?= $producto->getId() ?>">
    <?php endif; ?>

    <label>Nombre:</label>
    <input type="text" name="nombre" value="<?= valorCampo($producto, 'getNombre') ?>" required>

    <label>SKU:</label>
    <input type="text" name="sku" value="<?= valorCampo($producto, 'getSku') ?>" required>

    <label>Precio de venta:</label>
    <input type="number" name="precio_venta" step="0.01" min="0"
           value="<?= valorCampo($producto, 'getPrecioVenta', 0) ?>" required>

    <label>Stock actual:</label>
    <input type="number" name="stock_actual" min="0"
           value="<?= valorCampo($producto, 'getStockActual', 0) ?>" required>

    <label>Stock mínimo:</label>
    <input type="number" name="stock_minimo" min="0"
           value="<?= valorCampo($producto, 'getStockMinimo', 0) ?>" required>

    <label>Tipo:</label>
    <select name="tipo">
        <option value="estandar" <?= ($producto && $producto->getTipo() === 'estandar') ? 'selected' : '' ?>>Estándar</option>
        <option value="perecedero" <?= ($producto && $producto->getTipo() === 'perecedero') ? 'selected' : '' ?>>Perecedero</option>
    </select>

    <label>Categoría:</label>
    <select name="categoria_id">
        <option value="">Sin categoría</option>
        <?php foreach ($categorias as $c): ?>
            <option value="<?= $c->getId() ?>"
                <?= ($producto && $producto->getCategoriaId() == $c->getId()) ? 'selected' : '' ?>>
                <?= htmlspecialchars($c->getNombre()) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit"><?= $esNuevo ? 'Guardar' : 'Actualizar' ?></button>
</form>

<?php require __DIR__ . '/footer.php'; ?>