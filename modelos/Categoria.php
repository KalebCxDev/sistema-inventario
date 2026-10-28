<?php

class Categoria
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
        $dao = new CategoriaDAO(conectar());
        return $dao->guardar($this);
    }

    public function eliminar()
    {
        $dao = new CategoriaDAO(conectar());
        return $dao->eliminar($this->id);
    }

    public function buscarPorId($id)
    {
        $dao = new CategoriaDAO(conectar());
        return $dao->buscarPorId($id);
    }

    public function listarTodos()
    {
        $dao = new CategoriaDAO(conectar());
        return $dao->listarTodos();
    }
}
