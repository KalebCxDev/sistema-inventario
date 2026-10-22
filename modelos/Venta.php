<?php

class Venta extends Model
{
    private $id;
    private $total;
    private $detalle;
    private $cliente; // nueva propiedad

    public function setId($v) { $this->id = (int)$v; }

    public function setTotal($v)
    {
        if ($v < 0) throw new Exception('El total no puede ser negativo');
        $this->total = (float)$v;
    }

    public function setDetalle($v)
    {
        if (trim($v) === '') throw new Exception('El detalle no puede estar vacío');
        $this->detalle = trim($v);
    }

    // si viene vacio, se guarda como varios
    public function setCliente($v)
    {
        $this->cliente = (trim($v) === '') ? 'Varios' : trim($v);
    }

    public function getId() { return $this->id; }
    public function getTotal() { return $this->total; }
    public function getDetalle() { return $this->detalle; }
    public function getCliente() { return $this->cliente; }

    public function guardar()
    {
        $stmt = $this->db->prepare("INSERT INTO ventas (total, detalle, cliente) VALUES (:t, :d, :c)");
        $stmt->execute([':t' => $this->total, ':d' => $this->detalle, ':c' => $this->cliente]);
        $this->id = $this->db->lastInsertId();
        return $this->id;
    }

    public function listarTodas()
    {
        return $this->db->query("SELECT * FROM ventas ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM ventas WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function anular($id)
    {
        $stmt = $this->db->prepare("UPDATE ventas SET estado = 'anulada' WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}