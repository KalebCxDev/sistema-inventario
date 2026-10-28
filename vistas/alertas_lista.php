<?php require __DIR__ . '/header.php'; ?>

<h1>Alertas de Stock Crítico</h1>

<div class="aviso">
    <strong>Total de productos:</strong> <?= $total ?><br>
    <strong>Productos en alerta crítica:</strong> <?= $enAlerta ?>
</div>

<?php if ($enAlerta === 0): ?>
    <p class="ok">✔ Todo en orden. No hay productos con stock crítico en este momento.</p>
<?php else: ?>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>ID</th><th>Nombre</th><th>SKU</th><th>Stock actual</th>
                    <th>Stock mínimo</th><th>Tipo</th><th>Detalles</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($criticos as $p): ?>
                    <tr class="critico">
                        <td><strong>#<?= $p->getId() ?></strong></td>
                        <td style="font-weight: 500;"><?= htmlspecialchars($p->getNombre()) ?></td>
                        <td><code><?= htmlspecialchars($p->getSku()) ?></code></td>
                        <td>
                            <span class="salida" style="font-weight: 700;">
                                <?= $p->getStockActual() ?>
                            </span>
                        </td>
                        <td><?= $p->getStockMinimo() ?></td>
                        <td><span style="text-transform: capitalize;"><?= $p->getTipo() ?></span></td>
                        <td><?= htmlspecialchars($p->detallesExtra()) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?php require __DIR__ . '/footer.php'; ?>
