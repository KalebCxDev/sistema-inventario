<?php

class VentaDAO
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function guardar($venta)
    {
        $stmt = $this->db->prepare("INSERT INTO ventas (total, detalle, cliente, cliente_id) VALUES (:t, :d, :c, :ci)");
        $stmt->execute([
            ':t' => $venta->getTotal(),
            ':d' => $venta->getDetalle(),
            ':c' => $venta->getCliente(),
            ':ci' => $venta->getClienteId()
        ]);
        $id = (int)$this->db->lastInsertId();
        $venta->setId($id);
        return $id;
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

