<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $titulo ?? 'Sistema de Inventario' ?></title>
    <link rel="stylesheet" href="assets/css/estilo.css">
</head>
<body>
    <div class="menu">
        <a href="index.php?accion=home">Inicio</a>
        <a href="index.php?accion=index">Productos</a>
        <a href="index.php?accion=categorias">Categorías</a>
        <a href="index.php?accion=movimientos">Movimientos</a>
        <a href="index.php?accion=alertas">Alertas</a>
    </div>

    <?= $contenido ?>
</body>
</html>
