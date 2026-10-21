<?php

class Usuario extends Model
{
    private $id;
    private $nombre;
    private $usuario;
    private $password;
    private $rol;

    public function getId() { return $this->id; }
    public function getNombre() { return $this->nombre; }
    public function getUsuario() { return $this->usuario; }
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

    public function setRol($v)
    {
        if (!in_array($v, ['admin', 'vendedor', 'recepcionista'])) {
            throw new Exception('Rol inválido');
        }
        $this->rol = $v;
    }

    public function guardar()
    {
        $stmt = $this->db->prepare("INSERT INTO usuarios (nombre, usuario, password, rol) VALUES (:n, :u, :p, :r)");
        $stmt->execute([':n' => $this->nombre, ':u' => $this->usuario, ':p' => $this->password, ':r' => $this->rol]);
        return $this->db->lastInsertId();
    }

    public function actualizar()
    {
        if ($this->password !== null) {
            $stmt = $this->db->prepare("UPDATE usuarios SET nombre=:n, usuario=:u, password=:p, rol=:r WHERE id=:id");
            return $stmt->execute([':n' => $this->nombre, ':u' => $this->usuario, ':p' => $this->password, ':r' => $this->rol, ':id' => $this->id]);
        } else {
            $stmt = $this->db->prepare("UPDATE usuarios SET nombre=:n, usuario=:u, rol=:r WHERE id=:id");
            return $stmt->execute([':n' => $this->nombre, ':u' => $this->usuario, ':r' => $this->rol, ':id' => $this->id]);
        }
    }

    public function eliminar()
    {
        return $this->db->prepare("DELETE FROM usuarios WHERE id=:id")->execute([':id' => $this->id]);
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
        $u->password = $fila['password'];
        return $u;
    }
}