<?php
require_once __DIR__ . '/../conexion.php';
requiereLogin();

$accion = $_GET['accion'] ?? ($_POST['accion'] ?? 'historial');
$controller = new VentaController();

switch ($accion) {
    case 'cobrar':
        requiereRol(['admin', 'vendedor']);
        $controller->cobrar();
        break;
    case 'anular':
        requiereRol('admin');
        $controller->anular();
        break;
    case 'ticket':
        requiereRol(['admin', 'vendedor']);
        $controller->ticket();
        break;
    default:
        requiereRol(['admin', 'vendedor']);
        $controller->historial();
        break;
}
