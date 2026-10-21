<?php

class UsuarioController
{
    public function index()
    {
        $usuarios = (new Usuario())->listarTodos();
        $error = null;
        require __DIR__ . '/../vistas/usuarios_lista.php';
    }

    public function crear()
    {
        $usuario = null;
        $error = null;
        require __DIR__ . '/../vistas/usuarios_form.php';
    }

    public function editar()
    {
        $id = $_GET['id'] ?? 0;
        $usuario = (new Usuario())->buscarPorId($id);
        if (!$usuario) {
            header('Location: usuarios.php');
            exit;
        }
        $error = null;
        require __DIR__ . '/../vistas/usuarios_form.php';
    }

    public function guardar()
    {
        try {
            $u = new Usuario();
            $u->setNombre($_POST['nombre'] ?? '');
            $u->setUsuario($_POST['usuario'] ?? '');
            $u->setRol($_POST['rol'] ?? '');
            $u->setPassword($_POST['password'] ?? '');
            $u->guardar();
            header('Location: usuarios.php');
            exit;
        } catch (Exception $e) {
            $usuario = null;
            $error = $e->getMessage();
            require __DIR__ . '/../vistas/usuarios_form.php';
        }
    }

    public function actualizar()
    {
        try {
            $u = new Usuario();
            $u->setId($_POST['id'] ?? 0);
            $u->setNombre($_POST['nombre'] ?? '');
            $u->setUsuario($_POST['usuario'] ?? '');
            $u->setRol($_POST['rol'] ?? '');
            
            if (!empty($_POST['password'])) {
                $u->setPassword($_POST['password']);
            }
            
            $u->actualizar();
            header('Location: usuarios.php');
            exit;
        } catch (Exception $e) {
            $usuario = (new Usuario())->buscarPorId($_POST['id'] ?? 0);
            $error = $e->getMessage();
            require __DIR__ . '/../vistas/usuarios_form.php';
        }
    }

    public function eliminar()
    {
        $id = $_GET['id'] ?? 0;
        
        if ($id == $_SESSION['usuario_id']) {
            header('Location: usuarios.php?error=self');
            exit;
        }

        $u = (new Usuario())->buscarPorId($id);
        if ($u) {
            $userObj = new Usuario();
            $userObj->setId($id);
            $userObj->eliminar();
        }
        header('Location: usuarios.php');
        exit;
    }
}