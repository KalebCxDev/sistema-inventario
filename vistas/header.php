<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Inventario</title>
    <link rel="stylesheet" href="assets/css/estilo.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="menu">
        <a href="index.php">Inicio</a>
        
        <?php if (puedeVer('productos')): ?>
            <a href="productos.php">Productos</a>
        <?php endif; ?>

        <?php if (puedeVer('categorias')): ?>
            <a href="categorias.php">Categorías</a>
        <?php endif; ?>

        <?php if (puedeVer('movimientos')): ?>
            <a href="movimientos.php">Movimientos</a>
        <?php endif; ?>

        <?php if (puedeVer('alertas')): ?>
            <a href="alertas.php">
                Alertas
                <?php
                $_crit = (new Producto())->listarCriticos();
                if (count($_crit) > 0):
                ?>
                <span style="background:#ef4444;color:#fff;border-radius:999px;font-size:11px;font-weight:700;padding:1px 7px;margin-left:4px;vertical-align:middle;"><?= count($_crit) ?></span>
                <?php endif; ?>
            </a>
        <?php endif; ?>

        <?php if (puedeVer('pos')): ?>
            <a href="pos.php">POS</a>
        <?php endif; ?>

        <?php if (puedeVer('ventas')): ?>
            <a href="ventas.php">Ventas</a>
        <?php endif; ?>

        <?php if (puedeVer('usuarios')): ?>
        <a href="usuarios.php">Usuarios</a>
        <?php endif; ?>

        <span class="menu-usuario">
            <?= htmlspecialchars($_SESSION['usuario_nombre'] ?? '') ?> · 
            <a href="logout.php">Salir</a>
        </span>
    </div>