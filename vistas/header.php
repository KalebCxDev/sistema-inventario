<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Inventario</title>
    <link rel="stylesheet" href="assets/css/estilo.css">
</head>
<body>
    <div class="menu">
        <a href="index.php">Inicio</a>
        <?php if (puedeVer('productos')): ?><a href="productos.php">Productos</a><?php endif; ?>
        <?php if (puedeVer('categorias')): ?><a href="categorias.php">Categorías</a><?php endif; ?>
        <?php if (puedeVer('movimientos')): ?><a href="movimientos.php">Movimientos</a><?php endif; ?>
        <?php if (puedeVer('alertas')): ?><a href="alertas.php">Alertas</a><?php endif; ?>
        <?php if (puedeVer('pos')): ?><a href="pos.php">POS</a><?php endif; ?>
        <?php if (puedeVer('ventas')): ?><a href="ventas.php">Ventas</a><?php endif; ?>

        <span class="menu-usuario">
            <?= htmlspecialchars($_SESSION['usuario_nombre'] ?? '') ?> ·
            <a href="logout.php">Salir</a>
        </span>
    </div>