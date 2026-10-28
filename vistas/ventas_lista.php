<?php require __DIR__ . '/header.php'; ?>

<h1>Historial de Ventas</h1>

<?php if (isset($_GET['anulada'])): ?>
    <p class="ok">✔ Venta anulada y stock devuelto correctamente.</p>
<?php endif; ?>

<?php if (!empty($error)): ?>
    <p class="error"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<table>
    <!-- añade la columna Cliente -->
    <tr><th>ID</th><th>Fecha</th><th>Cliente</th><th>Detalle</th><th>Total</th><th>Estado</th><th>Acciones</th></tr>
    <?php foreach ($ventas as $v): ?>
        <tr>
            <td><?= $v['id'] ?></td>
            <td><?= $v['fecha'] ?></td>
            <td><?= htmlspecialchars($v['cliente']) ?></td> <!-- Muestra el nombre o "Varios" -->
            <td><?= htmlspecialchars($v['detalle']) ?></td>
            <td><?= number_format($v['total'], 2) ?></td>
            <td class="<?= $v['estado'] === 'anulada' ? 'salida' : 'entrada' ?>"><?= ucfirst($v['estado']) ?></td>
            <td style="white-space: nowrap;">
                <a href="ver_ticket.php?id=<?= $v['id'] ?>" target="_blank" class="btn azul" style="padding: 3px 8px; font-size: 11px;">Ticket</a>
                <?php if (rolActual() === 'admin' && $v['estado'] !== 'anulada'): ?>
                    <a href="venta_anular.php?id=<?= $v['id'] ?>" class="btn eliminar" onclick="return confirm('¿Seguro que deseas anular la Venta #<?= $v['id'] ?> (S/ <?= number_format($v['total'], 2) ?>)?\nEsta acción devolverá las unidades vendidas al inventario.')">Anular</a>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php require __DIR__ . '/footer.php'; ?>