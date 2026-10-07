<?php

class AuthController
{
    public function login()
    {
        $error = null;
        require __DIR__ . '/../vistas/login.php';
    }

    public function autenticar()
    {
        $usuario = $_POST['usuario'] ?? '';
        $password = $_POST['password'] ?? '';

        $u = (new Usuario())->validar($usuario, $password);

        if (!$u) {
            $error = 'Usuario o contraseña incorrectos';
            require __DIR__ . '/../vistas/login.php';
            return;
        }

        login($u);
        header('Location: index.php');
        exit;
    }

    public function logout()
    {
        logout();
        header('Location: login.php');
        exit;
    }
}