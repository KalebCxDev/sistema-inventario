<?php

class Usuario
{
    private $id;
    private $nombre;
    private $usuario;
    private $password;
    private $rol;

    public function getId() { return $this->id; }
    public function getNombre() { return $this->nombre; }
    public function getUsuario() { return $this->usuario; }
    public function getPassword() { return $this->password; }
    public function getRol() { return $this->rol; }

    public function setId($v) { $this->id = (int)$v; }

    public function setNombre($v)
    {
        if (trim($v) === '') throw new Exception('El nombre no puede estar vacío');
        $this->nombre = trim($v);
    }

    public function setUsuario($v)
    {
        if (trim($v) === '') throw new Exception('El usuario no puede estar vacío');
        $this->usuario = trim($v);
    }

    public function setPassword($v)
    {
        if (strlen($v) < 4) throw new Exception('La contraseña debe tener al menos 4 caracteres');
        $this->password = password_hash($v, PASSWORD_DEFAULT);
    }

    public function setPasswordHash($hash)
    {
        $this->password = $hash;
    }

    public function setRol($v)
    {
        if (!in_array($v, ['admin', 'vendedor', 'recepcionista'])) {
            throw new Exception('Rol inválido');
        }
        $this->rol = $v;
    }

    public function guardar()
    {
        $dao = new UsuarioDAO(conectar());
        return $dao->guardar($this);
    }

    public function actualizar()
    {
        $dao = new UsuarioDAO(conectar());
        return $dao->actualizar($this);
    }

    public function eliminar()
    {
        $dao = new UsuarioDAO(conectar());
        return $dao->eliminar($this->id);
    }

    public function listarTodos()
    {
        $dao = new UsuarioDAO(conectar());
        return $dao->listarTodos();
    }

    public function buscarPorId($id)
    {
        $dao = new UsuarioDAO(conectar());
        return $dao->buscarPorId($id);
    }

    public function validar($usuario, $password)
    {
        $dao = new UsuarioDAO(conectar());
        return $dao->validar($usuario, $password);
    }
}
