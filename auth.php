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

function requiereRol($rol)
{
    requiereLogin();
}


function puedeVer($seccion)
{
    return true;
}