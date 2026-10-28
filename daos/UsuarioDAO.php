<?php

class UsuarioDAO
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function guardar($usuario)
    {
        $stmt = $this->db->prepare("INSERT INTO usuarios (nombre, usuario, password, rol) VALUES (:n, :u, :p, :r)");
        $stmt->execute([
            ':n' => $usuario->getNombre(),
            ':u' => $usuario->getUsuario(),
            ':p' => $usuario->getPassword(),
            ':r' => $usuario->getRol()
        ]);
        $id = (int)$this->db->lastInsertId();
        $usuario->setId($id);
        return $id;
    }

    public function actualizar($usuario)
    {
        if ($usuario->getPassword() !== null) {
            $stmt = $this->db->prepare("UPDATE usuarios SET nombre=:n, usuario=:u, password=:p, rol=:r WHERE id=:id");
            return $stmt->execute([
                ':n' => $usuario->getNombre(),
                ':u' => $usuario->getUsuario(),
                ':p' => $usuario->getPassword(),
                ':r' => $usuario->getRol(),
                ':id' => $usuario->getId()
            ]);
        } else {
            $stmt = $this->db->prepare("UPDATE usuarios SET nombre=:n, usuario=:u, rol=:r WHERE id=:id");
            return $stmt->execute([
                ':n' => $usuario->getNombre(),
                ':u' => $usuario->getUsuario(),
                ':r' => $usuario->getRol(),
                ':id' => $usuario->getId()
            ]);
        }
    }

    public function eliminar($id)
    {
        return $this->db->prepare("DELETE FROM usuarios WHERE id=:id")->execute([':id' => $id]);
    }

    public function listarTodos()
    {
        return $this->db->query("SELECT * FROM usuarios ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        return $fila ? $fila : null;
    }

    public function validar($usuario, $password)
    {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE usuario = :u");
        $stmt->execute([':u' => $usuario]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$fila) return null;
        if (!password_verify($password, $fila['password'])) return null;

        $u = new Usuario();
        $u->setId($fila['id']);
        $u->setNombre($fila['nombre']);
        $u->setUsuario($fila['usuario']);
        $u->setRol($fila['rol']);
        $u->setPasswordHash($fila['password']);
        return $u;
    }
}

