<?php require __DIR__ . '/header.php'; ?>

<h1>Historial de Ventas</h1>

<table>
    <tr><th>ID</th><th>Fecha</th><th>Detalle</th><th>Total</th></tr>
    <?php foreach ($ventas as $v): ?>
        <tr>
            <td><?= $v['id'] ?></td>
            <td><?= $v['fecha'] ?></td>
            <td><?= htmlspecialchars($v['detalle']) ?></td>
            <td><?= number_format($v['total'], 2) ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<?php require __DIR__ . '/footer.php'; ?>