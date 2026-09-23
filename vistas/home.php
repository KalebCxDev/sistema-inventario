<?php require __DIR__ . '/header.php'; ?>

<h1>Sistema de Inventario</h1>
<div class="cards">
    <div class="card"><div class="num"><?= $totalProductos ?></div><div class="lbl">Productos</div></div>
    <div class="card"><div class="num"><?= $totalCategorias ?></div><div class="lbl">Categorías</div></div>
    <div class="card"><div class="num"><?= $totalMovimientos ?></div><div class="lbl">Movimientos</div></div>
    <div class="card <?= $totalAlertas > 0 ? 'alerta' : '' ?>">
        <div class="num"><?= $totalAlertas ?></div><div class="lbl">En alerta</div>
    </div>
</div>

<?php require __DIR__ . '/footer.php'; ?>