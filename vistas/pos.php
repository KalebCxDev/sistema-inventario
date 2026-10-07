<?php require __DIR__ . '/header.php'; ?>

<h1>Punto de Venta</h1>

<?php if (isset($_GET['ok'])): ?>
    <p class="ok">✔ Venta registrada correctamente.</p>
<?php endif; ?>

<?php if (!empty($error)): ?>
    <p class="error"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<div class="pos-contenedor">
    <div class="pos-productos">
        <input type="text" id="buscador-pos" placeholder="Buscar producto..." autocomplete="off">
        <table id="tabla-pos">
            <thead>
                <tr><th>Nombre</th><th>Precio</th><th>Stock</th><th></th></tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $p): ?>
                    <tr data-id="<?= $p->getId() ?>"
                        data-nombre="<?= htmlspecialchars($p->getNombre()) ?>"
                        data-precio="<?= $p->getPrecioVenta() ?>"
                        data-stock="<?= $p->getStockActual() ?>">
                        <td><?= htmlspecialchars($p->getNombre()) ?></td>
                        <td><?= number_format($p->getPrecioVenta(), 2) ?></td>
                        <td><?= $p->getStockActual() ?></td>
                        <td>
                            <button type="button" class="btn editar btn-agregar"
                                <?= $p->getStockActual() <= 0 ? 'disabled' : '' ?>>
                                Agregar
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="pos-carrito">
        <h2>Carrito</h2>
        <table id="tabla-carrito">
            <thead>
                <tr><th>Producto</th><th>Cant.</th><th>Subtotal</th><th></th></tr>
            </thead>
            <tbody></tbody>
        </table>
        <p class="pos-total">Total: S/ <span id="total">0.00</span></p>

        <form method="POST" action="venta_cobrar.php" id="form-cobrar">
            <input type="hidden" name="carrito" id="carrito-input" value="[]">
            <button type="submit" class="azul" id="btn-cobrar" disabled>Cobrar</button>
        </form>
        <button type="button" id="btn-vaciar" class="btn eliminar">Vaciar carrito</button>
    </div>
</div>

<script src="assets/js/pos.js"></script>

<?php require __DIR__ . '/footer.php'; ?>