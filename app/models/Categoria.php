<?php

class Categoria extends Model
{
    private $id;
    private $nombre;

    public function getId() { return $this->id; }
    public function getNombre() { return $this->nombre; }

    public function setId($id) { $this->id = (int)$id; }

    public function setNombre($nombre)
    {
        $nombre = trim($nombre);
        if ($nombre === '') {
            throw new Exception('El nombre de la categoría no puede estar vacío');
        }
        $this->nombre = $nombre;
    }

    public function guardar()
    {
        $stmt = $this->db->prepare("INSERT INTO categorias (nombre) VALUES (:nombre)");
        $stmt->execute([':nombre' => $this->nombre]);
        $this->id = $this->db->lastInsertId();
        return $this->id;
    }

    public function eliminar()
    {
        $stmt = $this->db->prepare("DELETE FROM categorias WHERE id = :id");
        return $stmt->execute([':id' => $this->id]);
    }

    public function listarTodos()
    {
        $stmt = $this->db->query("SELECT * FROM categorias ORDER BY nombre ASC");
        $filas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $categorias = [];
        foreach ($filas as $fila) {
            $c = new Categoria();
            $c->setId($fila['id']);
            $c->setNombre($fila['nombre']);
            $categorias[] = $c;
        }
        return $categorias;
    }

    public function buscarPorId($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM categorias WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$fila) {
            return null;
        }

        $c = new Categoria();
        $c->setId($fila['id']);
        $c->setNombre($fila['nombre']);
        return $c;
    }
}