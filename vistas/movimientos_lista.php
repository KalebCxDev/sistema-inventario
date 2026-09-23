<?php require __DIR__ . '/header.php'; ?>

<h1>Movimientos</h1>

<?php if (!empty($error)): ?>
    <p class="error"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<h2>Registrar movimiento</h2>
<form method="POST" action="movimiento_guardar.php">
    <label>Producto:</label>
    <select name="producto_id" required>
        <option value="">-- Seleccionar --</option>
        <?php foreach ($productos as $p): ?>
            <option value="<?= $p->getId() ?>">
                <?= htmlspecialchars($p->getNombre()) ?> (stock: <?= $p->getStockActual() ?>)
            </option>
        <?php endforeach; ?>
    </select>

    <label>Tipo:</label>
    <select name="tipo" required>
        <option value="entrada">Entrada</option>
        <option value="salida">Salida</option>
    </select>

    <label>Cantidad:</label>
    <input type="number" name="cantidad" min="1" required>

    <button class="azul" type="submit">Registrar</button>
</form>

<h2>Historial</h2>
<table>
    <tr><th>ID</th><th>Producto</th><th>Tipo</th><th>Cantidad</th><th>Fecha</th></tr>
    <?php foreach ($movimientos as $m): ?>
        <tr>
            <td><?= $m['id'] ?></td>
            <td>
                <?php
                $nombre = '-';
                foreach ($productos as $p) {
                    if ($p->getId() == $m['producto_id']) {
                        $nombre = $p->getNombre();
                        break;
                    }
                }
                echo htmlspecialchars($nombre);
                ?>
            </td>
            <td class="<?= $m['tipo'] ?>"><?= $m['tipo'] ?></td>
            <td><?= $m['cantidad'] ?></td>
            <td><?= $m['fecha'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<?php require __DIR__ . '/footer.php'; ?>