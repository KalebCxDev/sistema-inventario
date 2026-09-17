<?php
$esNuevo = $producto === null;
$accionForm = $esNuevo ? 'guardar' : 'actualizar';
$valor = fn($campo, $default = '') => htmlspecialchars($producto ? $producto->{'get' . $campo}() : $default);
ob_start();
?>
<h1><?= $esNuevo ? 'Nuevo Producto' : 'Editar Producto' ?></h1>
<a href="index.php?accion=index">← Volver al listado</a>

<?php if (!empty($error)): ?>
    <p class="error"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="POST" action="index.php?accion=<?= $accionForm ?>">
    <?php if (!$esNuevo): ?>
        <input type="hidden" name="id" value="<?= $producto->getId() ?>">
    <?php endif; ?>

    <label>Nombre:</label>
    <input type="text" name="nombre" value="<?= $valor('Nombre') ?>" required>

    <label>SKU:</label>
    <input type="text" name="sku" value="<?= $valor('Sku') ?>" required>

    <label>Precio de venta:</label>
    <input type="number" name="precio_venta" step="0.01" min="0" value="<?= $valor('PrecioVenta', 0) ?>" required>

    <label>Stock actual:</label>
    <input type="number" name="stock_actual" min="0" value="<?= $valor('StockActual', 0) ?>" required>

    <label>Stock mínimo:</label>
    <input type="number" name="stock_minimo" min="0" value="<?= $valor('StockMinimo', 0) ?>" required>

    <label>Tipo:</label>
    <select name="tipo">
        <?php foreach (['estandar', 'fragil', 'perecedero'] as $t): ?>
            <option value="<?= $t ?>" <?= ($producto && $producto->getTipo() === $t) ? 'selected' : '' ?>><?= ucfirst($t) ?></option>
        <?php endforeach; ?>
    </select>

    <label>Categoría:</label>
    <select name="categoria_id">
        <option value="">Sin categoría</option>
        <?php foreach ($categorias as $c): ?>
            <option value="<?= $c->getId() ?>" <?= ($producto && $producto->getCategoriaId() == $c->getId()) ? 'selected' : '' ?>>
                <?= htmlspecialchars($c->getNombre()) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit"><?= $esNuevo ? 'Guardar' : 'Actualizar' ?></button>
</form>
<?php $contenido = ob_get_clean(); require __DIR__ . '/../layout.php'; ?>
