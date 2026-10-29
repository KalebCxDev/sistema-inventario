<?php require __DIR__ . '/header.php'; ?>

<h1>Punto de Venta</h1>

<?php if (isset($_GET['ok'])): ?>
    <div class="ok" id="mensaje-venta-ok" style="display: flex; align-items: center; justify-content: space-between; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
        <span>✔ Venta registrada correctamente.</span>
        <?php if (!empty($_GET['ticket_id'])): ?>
            <a href="ver_ticket.php?id=<?= (int)$_GET['ticket_id'] ?>" target="_blank" class="btn azul" style="padding: 6px 12px; font-size: 13px; text-decoration: none;">🖨 Ver / Reimprimir Ticket #<?= (int)$_GET['ticket_id'] ?></a>
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
        
        <div class="table-responsive">
            <table id="tabla-pos">
                <thead>
                    <tr><th>Nombre</th><th>SKU</th><th>Precio</th><th>Stock</th><th></th></tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $p): ?>
                        <tr data-id="<?= $p->getId() ?>" data-nombre="<?= htmlspecialchars($p->getNombre()) ?>" data-sku="<?= htmlspecialchars($p->getSku()) ?>" data-precio="<?= $p->getPrecioVenta() ?>" data-stock="<?= $p->getStockActual() ?>">
                            <td style="font-weight: 500;"><?= htmlspecialchars($p->getNombre()) ?></td>
                            <td><code><?= htmlspecialchars($p->getSku()) ?></code></td>
                            <td style="font-weight: 600; color: #0f172a;">S/ <?= number_format($p->getPrecioVenta(), 2) ?></td>
                            <td>
                                <span class="<?= $p->getStockActual() <= $p->getStockMinimo() ? 'salida' : '' ?>">
                                    <?= $p->getStockActual() ?>
                                </span>
                            </td>
                            <td>
                                <button type="button" class="btn editar btn-agregar" <?= $p->getStockActual() <= 0 ? 'disabled' : '' ?>>Agregar</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="pos-carrito">
        <h2>Carrito</h2>
        <div class="table-responsive" style="border: none; box-shadow: none; margin-top: 0;">
            <table id="tabla-carrito" style="min-width: 100%;">
                <thead>
                    <tr><th>Producto</th><th>Cant.</th><th>Subtotal</th><th></th></tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <p class="pos-total">Total: S/ <span id="total">0.00</span></p>

        <form method="POST" action="ventas.php?accion=cobrar" id="form-cobrar" onsubmit="document.getElementById('btn-cobrar').disabled = true; document.getElementById('btn-cobrar').textContent = 'Procesando...';">
            <label for="buscador-dni">DNI del Cliente (Opcional):</label>
            <div style="display: flex; gap: 8px; align-items: center; margin-top: 4px;">
                <input type="text" id="buscador-dni" maxlength="8" placeholder="Escribir o escanear DNI..." autocomplete="off" style="flex: 1;">
                <button type="button" id="btn-quitar-cliente" class="btn eliminar" style="display:none; padding: 8px 12px; font-size: 13px;" title="Quitar cliente seleccionado">✕ Quitar</button>
            </div>
            <p id="dni-mensaje" class="ok" style="display:none; font-size: 13px; margin: 6px 0;"></p>

            <input type="hidden" name="cliente_id" id="cliente_id" value="">
            <input type="hidden" name="cliente_nombre" id="cliente_nombre" value="">
            <input type="hidden" name="carrito" id="carrito-input" value="[]">
            
            <button type="submit" class="azul" id="btn-cobrar">Cobrar</button>
        </form>
        
        <button type="button" id="btn-vaciar" class="btn eliminar">Vaciar carrito</button>

        <div style="margin-top: 22px; padding-top: 16px; border-top: 1px solid #e2e8f0;">
            <label for="input-ticket" style="font-size: 13px; font-weight: 600; color: #334155; display: block; margin-bottom: 6px;">Reimprimir Ticket:</label>
            <div style="display: flex; gap: 8px; align-items: center;">
                <input type="number" id="input-ticket" placeholder="N° de ticket..." min="1" style="flex: 1; padding: 8px 12px; min-height: 38px;">
                <button type="button" id="btn-reimprimir" class="btn azul" style="padding: 8px 14px; white-space: nowrap; height: 38px;">Reimprimir</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Cliente -->
<div class="modal-fondo" id="modal-cliente">
    <div class="modal-caja">
        <h3>Registrar Nuevo Cliente</h3>
        <p style="font-size: 13px; color: #64748b; margin-bottom: 14px;">El DNI <strong id="modal-dni-texto" style="color: #0f172a;"></strong> no existe en el sistema.</p>
        <input type="hidden" id="modal-dni-valor">
        
        <label for="modal-nombres">Nombres:</label>
        <input type="text" id="modal-nombres" autocomplete="off" placeholder="Ej. Juan Carlos">
        
        <label for="modal-apellidos">Apellidos:</label>
        <input type="text" id="modal-apellidos" autocomplete="off" placeholder="Ej. Pérez Gómez">
        
        <label for="modal-fecha-nacimiento">Fecha de Nacimiento:</label>
        <input type="date" id="modal-fecha-nacimiento">
        
        <div style="display: flex; gap: 10px; margin-top: 20px;">
            <button type="button" class="btn azul" id="btn-guardar-cliente" style="flex: 1; padding: 10px;">Guardar y Usar</button>
            <button type="button" class="btn eliminar" id="btn-cerrar-modal" style="padding: 10px 16px;">Cancelar</button>
        </div>
    </div>
</div>

<script src="assets/js/pos.js?v=6"></script>

<?php require __DIR__ . '/footer.php'; ?>
