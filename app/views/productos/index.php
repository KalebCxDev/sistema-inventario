<?php ob_start(); ?>
<h1>Listado de Productos</h1>

<?php if ($enAlerta > 0): ?>
    <div class="aviso">⚠ Hay <strong><?= $enAlerta ?></strong> producto(s) con stock crítico.</div>
<?php endif; ?>

<a href="index.php?accion=crear" class="btn nuevo">+ Nuevo Producto</a>

<table>
    <tr><th>ID</th><th>Nombre</th><th>SKU</th><th>Precio</th><th>Stock</th><th>Mínimo</th><th>Tipo</th><th>Descripción</th><th>Detalles</th><th>Acciones</th></tr>
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
                <a href="index.php?accion=editar&id=<?= $p->getId() ?>" class="btn editar">Editar</a>
                <a href="index.php?accion=eliminar&id=<?= $p->getId() ?>" class="btn eliminar"
                   onclick="return confirm('¿Eliminar producto?')">Eliminar</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php $contenido = ob_get_clean(); require __DIR__ . '/../layout.php'; ?>
