<?php

class Venta extends Model
{
    private $id;
    private $total;
    private $detalle;

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

    public function getId() { return $this->id; }
    public function getTotal() { return $this->total; }
    public function getDetalle() { return $this->detalle; }

    public function guardar()
    {
        $stmt = $this->db->prepare("INSERT INTO ventas (total, detalle) VALUES (:t, :d)");
        $stmt->execute([':t' => $this->total, ':d' => $this->detalle]);
        $this->id = $this->db->lastInsertId();
        return $this->id;
    }

    public function listarTodas()
    {
        return $this->db->query("SELECT * FROM ventas ORDER BY id DESC")
                        ->fetchAll(PDO::FETCH_ASSOC);
    }
}