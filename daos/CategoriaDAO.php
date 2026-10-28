<?php

class CategoriaDAO
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function guardar($categoria)
    {
        $stmt = $this->db->prepare("INSERT INTO categorias (nombre) VALUES (:n)");
        $stmt->execute([':n' => $categoria->getNombre()]);
        $id = (int)$this->db->lastInsertId();
        $categoria->setId($id);
        return $id;
    }

    public function eliminar($id)
    {
        $stmt = $this->db->prepare("DELETE FROM categorias WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function buscarPorId($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM categorias WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$fila) return null;
        return $this->mapear($fila);
    }

    public function listarTodos()
    {
        $stmt = $this->db->query("SELECT * FROM categorias ORDER BY nombre ASC");
        $filas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $lista = [];
        foreach ($filas as $fila) {
            $lista[] = $this->mapear($fila);
        }
        return $lista;
    }

    private function mapear($fila)
    {
        $c = new Categoria();
        $c->setId($fila['id']);
        $c->setNombre($fila['nombre']);
        return $c;
    }
}

