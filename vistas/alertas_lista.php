<?php require __DIR__ . '/header.php'; ?>

<h1>Alertas de Stock Crítico</h1>

<div class="aviso">
    <strong>Total de productos:</strong> <?= $total ?><br>
    <strong>Productos en alerta:</strong> <?= $enAlerta ?>
</div>

<?php if ($enAlerta === 0): ?>
    <p class="ok">✔ Todo en orden. No hay productos con stock crítico.</p>
<?php else: ?>
    <table>
        <tr>
            <th>ID</th><th>Nombre</th><th>SKU</th><th>Stock actual</th>
            <th>Stock mínimo</th><th>Tipo</th><th>Detalles</th>
        </tr>
        <?php foreach ($criticos as $p): ?>
            <tr class="critico">
                <td><?= $p->getId() ?></td>
                <td><?= htmlspecialchars($p->getNombre()) ?></td>
                <td><?= htmlspecialchars($p->getSku()) ?></td>
                <td><?= $p->getStockActual() ?></td>
                <td><?= $p->getStockMinimo() ?></td>
                <td><?= $p->getTipo() ?></td>
                <td><?= htmlspecialchars($p->detallesExtra()) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<?php require __DIR__ . '/footer.php'; ?>