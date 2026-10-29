<?php
require_once __DIR__ . '/../conexion.php';
requiereLogin();

$accion = $_GET['accion'] ?? ($_POST['accion'] ?? '');
$controller = new AjaxController();

switch ($accion) {
    case 'buscar':
        $controller->buscar_cliente();
        break;
    case 'guardar':
        $controller->guardar_cliente();
        break;
    default:
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Accion no valida']);
        exit;
}

