<?php

class ClienteDAO
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function guardar($cliente)
    {
        $stmt = $this->db->prepare("INSERT INTO clientes (dni, nombres, apellidos, fecha_nacimiento) VALUES (:d, :n, :a, :f)");
        $stmt->execute([
            ':d' => $cliente->getDni(),
            ':n' => $cliente->getNombres(),
            ':a' => $cliente->getApellidos(),
            ':f' => $cliente->getFechaNacimiento()
        ]);
        $id = (int)$this->db->lastInsertId();
        $cliente->setId($id);
        return $id;
    }

    public function buscarPorDni($dni)
    {
        $stmt = $this->db->prepare("SELECT * FROM clientes WHERE dni = :d");
        $stmt->execute([':d' => $dni]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$fila) return null;
        return $this->mapear($fila);
    }

    private function mapear($fila)
    {
        $c = new Cliente();
        $c->setId($fila['id']);
        $c->setDni($fila['dni']);
        $c->setNombres($fila['nombres']);
        $c->setApellidos($fila['apellidos']);
        $c->setFechaNacimiento($fila['fecha_nacimiento']);
        return $c;
    }
}

