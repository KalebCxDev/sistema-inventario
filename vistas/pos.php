<?php require __DIR__ . '/header.php'; ?>

<style>
    .modal-fondo { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; }
    .modal-caja { background: #fff; width: 400px; margin: 100px auto; padding: 20px; border-radius: 8px; }
    .modal-caja h3 { margin-top: 0; }
</style>

<h1>Punto de Venta</h1>

<?php if (isset($_GET['ok'])): ?>
    <p class="ok">✔ Venta registrada correctamente.</p>
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
            <input type="text" id="buscador-dni" placeholder="Escribir o escanear DNI..." autocomplete="off">
            <p id="dni-mensaje" class="ok" style="display:none; font-size: 13px; margin: 5px 0;"></p>

            <input type="hidden" name="cliente_id" id="cliente_id" value="">
            <input type="hidden" name="cliente_nombre" id="cliente_nombre" value="">
            <input type="hidden" name="carrito" id="carrito-input" value="[]">
            
            <!-- El boton debe ser type="submit" y NO tener disabled (el JS lo controla) -->
            <button type="button" class="azul" id="btn-cobrar" onclick="document.getElementById('form-cobrar').submit()">Cobrar</button>
        </form>
        
        <button type="button" id="btn-vaciar" class="btn eliminar">Vaciar carrito</button>
    </div>
</div>

<!-- El modal debe estar FUERA del formulario -->
<div class="modal-fondo" id="modal-cliente">
    <div class="modal-caja">
        <h3>Registrar Nuevo Cliente</h3>
        <p style="font-size: 13px;">El DNI <strong id="modal-dni-texto"></strong> no existe.</p>
        <input type="hidden" id="modal-dni-valor">
        
        <label>Nombres:</label>
        <input type="text" id="modal-nombres">
        
        <!-- ... (dentro del modal, abajo de apellidos) ... -->
        <label>Apellidos:</label>
        <input type="text" id="modal-apellidos">
        
        <!-- NUEVO CAMPO -->
        <label>Fecha de Nacimiento:</label>
        <input type="date" id="modal-fecha-nacimiento">
        
        <button type="button" class="azul" id="btn-guardar-cliente" style="margin-top: 15px;">Guardar y Usar</button>
        <button type="button" class="btn eliminar" id="btn-cerrar-modal" style="margin-top: 15px;">Cancelar</button>
</div>

<script src="assets/js/pos.js?v=2"></script>

<?php require __DIR__ . '/footer.php'; ?>