<?php require __DIR__ . '/header.php'; ?>

<h1>Sistema de Inventario</h1>
<div class="cards">
    <a href="productos.php" class="card">
        <div class="num"><?= $totalProductos ?></div>
        <div class="lbl">Productos</div>
    </a>
    <a href="categorias.php" class="card">
        <div class="num"><?= $totalCategorias ?></div>
        <div class="lbl">Categorías</div>
    </a>
    <a href="movimientos.php" class="card">
        <div class="num"><?= $totalMovimientos ?></div>
        <div class="lbl">Movimientos</div>
    </a>
    <a href="alertas.php" class="card <?= $totalAlertas > 0 ? 'alerta' : '' ?>">
        <div class="num"><?= $totalAlertas ?></div>
        <div class="lbl">En alerta</div>
    </a>
</div>

<?php require __DIR__ . '/footer.php'; ?>