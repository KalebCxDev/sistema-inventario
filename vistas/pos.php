<?php require __DIR__ . '/header.php'; ?>

<style>
    .modal-fondo { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; }
    .modal-caja { background: #fff; width: 400px; margin: 100px auto; padding: 20px; border-radius: 8px; }
    .modal-caja h3 { margin-top: 0; }
</style>

<h1>Punto de Venta</h1>

<?php if (isset($_GET['ok'])): ?>
    <div class="ok" id="mensaje-venta-ok" style="display: flex; align-items: center; justify-content: space-between; gap: 10px; margin-bottom: 15px;">
        <span>✔ Venta registrada correctamente.</span>
        <?php if (!empty($_GET['ticket_id'])): ?>
            <a href="ver_ticket.php?id=<?= (int)$_GET['ticket_id'] ?>" target="_blank" class="btn azul" style="padding: 4px 10px; font-size: 12px; text-decoration: none;">🖨 Ver / Reimprimir Ticket #<?= (int)$_GET['ticket_id'] ?></a>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php if (!empty($error)): ?>
    <p class="error"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<div class="pos-contenedor">
    <div class="pos-productos">
        <input type="text" id="buscador-pos" placeholder="Buscar o escanear código..." autocomplete="off">
        <p id="escaneo-error" class="error" style="display:none;">Producto no encontrado</p>
        
        <table id="tabla-pos">
            <thead>
                <tr><th>Nombre</th><th>SKU</th><th>Precio</th><th>Stock</th><th></th></tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $p): ?>
                    <tr data-id="<?= $p->getId() ?>" data-nombre="<?= htmlspecialchars($p->getNombre()) ?>" data-sku="<?= htmlspecialchars($p->getSku()) ?>" data-precio="<?= $p->getPrecioVenta() ?>" data-stock="<?= $p->getStockActual() ?>">
                        <td><?= htmlspecialchars($p->getNombre()) ?></td>
                        <td><?= htmlspecialchars($p->getSku()) ?></td>
                        <td><?= number_format($p->getPrecioVenta(), 2) ?></td>
                        <td><?= $p->getStockActual() ?></td>
                        <td>
                            <button type="button" class="btn editar btn-agregar" <?= $p->getStockActual() <= 0 ? 'disabled' : '' ?>>Agregar</button>
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
            
            <label for="buscador-dni">DNI del Cliente (Opcional):</label>
            <!-- Le quite el required y agregue autocomplete="off" -->
            <div style="display: flex; gap: 8px; align-items: center; margin-top: 4px;">
                <input type="text" id="buscador-dni" maxlength="8" placeholder="Escribir o escanear DNI (8 dígitos)..." autocomplete="off" style="flex: 1;">
                <button type="button" id="btn-quitar-cliente" class="btn eliminar" style="display:none; padding: 6px 10px; font-size: 12px;" title="Quitar cliente seleccionado">✕ Quitar</button>
            </div>
            <p id="dni-mensaje" class="ok" style="display:none; font-size: 13px; margin: 5px 0;"></p>

            <input type="hidden" name="cliente_id" id="cliente_id" value="">
            <input type="hidden" name="cliente_nombre" id="cliente_nombre" value="">
            <input type="hidden" name="carrito" id="carrito-input" value="[]">
            
            <button type="submit" class="azul" id="btn-cobrar">Cobrar</button>
        </form>
        
        <button type="button" id="btn-vaciar" class="btn eliminar">Vaciar carrito</button>
    </div>
</div>

<!-- Modal Cliente -->
<div class="modal-fondo" id="modal-cliente">
    <div class="modal-caja">
        <h3>Registrar Nuevo Cliente</h3>
        <p style="font-size: 13px;">El DNI <strong id="modal-dni-texto"></strong> no existe.</p>
        <input type="hidden" id="modal-dni-valor">
        
        <label for="modal-nombres">Nombres:</label>
        <input type="text" id="modal-nombres" autocomplete="off">
        
        <label for="modal-apellidos">Apellidos:</label>
        <input type="text" id="modal-apellidos" autocomplete="off">
        
        <label for="modal-fecha-nacimiento">Fecha de Nacimiento:</label>
        <input type="date" id="modal-fecha-nacimiento">
        
        <div style="display: flex; gap: 10px; margin-top: 15px;">
            <button type="button" class="azul" id="btn-guardar-cliente" style="flex: 1;">Guardar y Usar</button>
            <button type="button" class="btn eliminar" id="btn-cerrar-modal">Cancelar</button>
        </div>
    </div>
</div>

<script src="assets/js/pos.js?v=3"></script>

<?php require __DIR__ . '/footer.php'; ?>