<?php require __DIR__ . '/header.php'; ?>

<h1>Listado de Productos</h1>

<?php if ($enAlerta > 0): ?>
    <div class="aviso">⚠ Hay <strong><?= $enAlerta ?></strong> producto(s) con stock crítico.</div>
<?php endif; ?>

<a href="producto_crear.php" class="btn nuevo">+ Nuevo Producto</a>
<a href="reporte_productos.php" class="btn editar" target="_blank">Exportar PDF</a>
<a href="reporte_excel.php" class="btn movimiento">Exportar Excel</a>
<div class="buscador">
    <label for="buscador">Buscar:</label>
    <input type="text" id="buscador" placeholder="Nombre, SKU o tipo..." autocomplete="off">
    <span id="contador"><?= count($productos) ?> de <?= count($productos) ?> productos</span>
</div>

<table id="tabla-productos">
    <thead>
        <tr>
            <th>ID</th><th>Nombre</th><th>SKU</th><th>Precio</th><th>Stock</th>
            <th>Mínimo</th><th>Tipo</th><th>Descripción</th><th>Detalles</th><th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($productos as $p): ?>
            <tr class="<?= $p->stockCritico() ? 'critico' : '' ?>">
                <td><?= $p->getId() ?></td>
                <td><?= htmlspecialchars($p->getNombre()) ?></td>
                <td><?= htmlspecialchars($p->getSku()) ?></td>
                <td><?= number_format($p->getPrecioVenta(), 2) ?></td>
                <td><?= $p->getStockActual() ?></td>
                <td><?= $p->getStockMinimo() ?></td>
                <td><?= $p->getTipo() ?></td>
                <td><?= htmlspecialchars($p->descripcion()) ?></td>
                <td><?= htmlspecialchars($p->detallesExtra()) ?></td>
                <td>
                    <a href="producto_editar.php?id=<?= $p->getId() ?>" class="btn editar">Editar</a>
                    <a href="movimientos.php?producto_id=<?= $p->getId() ?>" class="btn movimiento">Movimiento</a>
                    <a href="producto_eliminar.php?id=<?= $p->getId() ?>" class="btn eliminar"
                       onclick="return confirm('¿Eliminar producto?')">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<p id="sin-resultados" class="aviso" style="display:none;">
    No se encontraron productos con ese criterio.
</p>

<script src="assets/js/buscador.js"></script>

<?php require __DIR__ . '/footer.php'; ?>