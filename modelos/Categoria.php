<?php

class Categoria extends Model
{
    private $id;
    private $nombre;

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
        $stmt = $this->db->prepare("INSERT INTO categorias (nombre) VALUES (:n)");
        $stmt->execute([':n' => $this->nombre]);
        $this->id = $this->db->lastInsertId();
        return $this->id;
    }

    public function eliminar()
    {
        return $this->db->prepare("DELETE FROM categorias WHERE id=:id")
                        ->execute([':id' => $this->id]);
    }

    public function buscarPorId($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM categorias WHERE id=:id");
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