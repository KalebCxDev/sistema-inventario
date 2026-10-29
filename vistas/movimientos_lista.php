<?php require __DIR__ . '/header.php'; ?>

<h1>Movimientos</h1>

<?php if (!empty($error)): ?>
    <p class="error"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<h2>Registrar movimiento</h2>
<form method="POST" action="movimientos.php?accion=guardar">
    <label>Producto:</label>
    <select name="producto_id" required>
        <option value="">-- Seleccionar producto --</option>
        <?php foreach ($productos as $p): ?>
            <option value="<?= $p->getId() ?>"
                <?= ($productoSeleccionado == $p->getId()) ? 'selected' : '' ?>>
                <?= htmlspecialchars($p->getNombre()) ?> (Stock actual: <?= $p->getStockActual() ?>)
            </option>
        <?php endforeach; ?>
    </select>

    <label>Tipo de movimiento:</label>
    <select name="tipo" required>
        <option value="entrada">Entrada (Ingreso de stock)</option>
        <option value="salida">Salida (Disminución de stock)</option>
    </select>

    <label>Cantidad:</label>
    <input type="number" name="cantidad" min="1" placeholder="Ej. 10" required>

    <button class="azul" type="submit">Registrar movimiento</button>
</form>

<h2>Historial de movimientos</h2>
<div class="table-responsive">
    <table>
        <thead>
            <tr><th>ID</th><th>Producto</th><th>Tipo</th><th>Cantidad</th><th>Fecha</th></tr>
        </thead>
        <tbody>
            <?php foreach ($movimientos as $m): ?>
                <tr>
                    <td><strong>#<?= $m['id'] ?></strong></td>
                    <td style="font-weight: 500;">
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
                    <td>
                        <span class="<?= $m['tipo'] ?>">
                            <?= ucfirst($m['tipo']) ?>
                        </span>
                    </td>
                    <td style="font-weight: 600;"><?= $m['cantidad'] ?></td>
                    <td style="color: #64748b; font-size: 13px;"><?= $m['fecha'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__ . '/footer.php'; ?>
