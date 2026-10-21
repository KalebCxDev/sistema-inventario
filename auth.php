<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function login($usuario)
{
    $_SESSION['usuario_id'] = $usuario->getId();
    $_SESSION['usuario_nombre'] = $usuario->getNombre();
    $_SESSION['usuario_rol'] = $usuario->getRol();
}

function logout()
{
    session_unset();
    session_destroy();
}

function estaLogueado()
{
    return isset($_SESSION['usuario_id']);
}

function rolActual()
{
    return $_SESSION['usuario_rol'] ?? null;
}

function requiereLogin()
{
    if (!estaLogueado()) {
        header('Location: login.php');
        exit;
    }
}

function requiereRol($roles)
{
    requiereLogin();
    if (!is_array($roles)) {
        $roles = [$roles];
    }
    if (!in_array(rolActual(), $roles)) {
        header('Location: index.php');
        exit;
    }
}

function puedeVer($seccion)
{
    $rol = rolActual();
    switch ($seccion) {
        case 'movimientos':
            return in_array($rol, ['admin', 'recepcionista']);
        case 'pos':
        case 'ventas':
            return in_array($rol, ['admin', 'vendedor']);
        default:
            return true;
    }
}