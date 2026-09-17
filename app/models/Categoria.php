<?php

class Categoria extends Model
{
    private $id, $nombre;

    public function getId() { return $this->id; }
    public function getNombre() { return $this->nombre; }
    public function setId($v) { $this->id = (int)$v; }

    public function setNombre($v)
    {
        if (trim($v) === '') throw new Exception('El nombre de la categoría no puede estar vacío');
        $this->nombre = trim($v);
    }

    public function guardar()
    {
        $this->db->prepare("INSERT INTO categorias (nombre) VALUES (:n)")->execute([':n' => $this->nombre]);
        $this->id = $this->db->lastInsertId();
        return $this->id;
    }

    public function eliminar()
    {
        return $this->db->prepare("DELETE FROM categorias WHERE id=:id")->execute([':id' => $this->id]);
    }

    public function buscarPorId($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM categorias WHERE id=:id");
        $stmt->execute([':id' => $id]);
        return ($f = $stmt->fetch(PDO::FETCH_ASSOC)) ? $this->mapear($f) : null;
    }

    public function listarTodos()
    {
        $stmt = $this->db->query("SELECT * FROM categorias ORDER BY nombre ASC");
        return array_map([$this, 'mapear'], $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    private function mapear($f)
    {
        $c = new Categoria();
        $c->setId($f['id']);
        $c->setNombre($f['nombre']);
        return $c;
    }
}