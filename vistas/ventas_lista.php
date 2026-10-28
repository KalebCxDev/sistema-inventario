<?php require __DIR__ . '/header.php'; ?>

<h1>Historial de Ventas</h1>

<?php if (isset($_GET['anulada'])): ?>
    <p class="ok">✔ Venta anulada y stock devuelto correctamente.</p>
<?php endif; ?>

<?php if (!empty($error)): ?>
    <p class="error"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<div class="table-responsive">
    <table>
        <thead>
            <tr><th>ID</th><th>Fecha</th><th>Cliente</th><th>Detalle</th><th>Total</th><th>Estado</th><th>Acciones</th></tr>
        </thead>
        <tbody>
            <?php foreach ($ventas as $v): ?>
                <tr>
                    <td><strong>#<?= $v['id'] ?></strong></td>
                    <td style="color: #64748b; font-size: 13px;"><?= $v['fecha'] ?></td>
                    <td style="font-weight: 500;"><?= htmlspecialchars($v['cliente']) ?></td>
                    <td><?= htmlspecialchars($v['detalle']) ?></td>
                    <td style="font-weight: 600; color: #0f172a;">S/ <?= number_format($v['total'], 2) ?></td>
                    <td>
                        <span class="<?= $v['estado'] === 'anulada' ? 'salida' : 'entrada' ?>">
                            <?= ucfirst($v['estado']) ?>
                        </span>
                    </td>
                    <td style="white-space: nowrap;">
                        <a href="ver_ticket.php?id=<?= $v['id'] ?>" target="_blank" class="btn ticket">🖨 Ticket</a>
                        <?php if (rolActual() === 'admin' && $v['estado'] !== 'anulada'): ?>
                            <a href="venta_anular.php?id=<?= $v['id'] ?>" class="btn eliminar" onclick="return confirm('¿Seguro que deseas anular la Venta #<?= $v['id'] ?> (S/ <?= number_format($v['total'], 2) ?>)?\nEsta acción devolverá las unidades vendidas al inventario.')">Anular</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__ . '/footer.php'; ?>
