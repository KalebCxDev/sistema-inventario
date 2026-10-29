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

    public function listarTodas($limite = 20, $offset = 0)
    {
        $stmt = $this->db->prepare("SELECT * FROM ventas ORDER BY id DESC LIMIT :lim OFFSET :off");
        $stmt->bindValue(':lim', (int)$limite, PDO::PARAM_INT);
        $stmt->bindValue(':off', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function contarTodas()
    {
        return (int)$this->db->query("SELECT COUNT(*) FROM ventas")->fetchColumn();
    }

    public function buscarPorCliente($clienteId)
    {
        $stmt = $this->db->prepare("SELECT * FROM ventas WHERE cliente_id = :id ORDER BY id DESC");
        $stmt->execute([':id' => $clienteId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    public function obtenerVentasUltimos7Dias()
    {
        try {
            $sql = "SELECT DATE(fecha) AS fecha, SUM(total) AS total
                    FROM ventas
                    WHERE fecha >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
                      AND (estado IS NULL OR estado != 'anulada')
                    GROUP BY DATE(fecha)
                    ORDER BY fecha ASC";
            $filas = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $sql = "SELECT DATE(fecha) AS fecha, SUM(total) AS total
                    FROM ventas
                    WHERE fecha >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
                    GROUP BY DATE(fecha)
                    ORDER BY fecha ASC";
            $filas = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        }

        // Indexar ventas por fecha Y-m-d
        $ventasPorFecha = [];
        if (!empty($filas)) {
            foreach ($filas as $fila) {
                $ventasPorFecha[$fila['fecha']] = (float)$fila['total'];
            }
        }

        // Construir siempre los últimos 7 días correlativos para que el gráfico nunca quede vacío
        $resultado = [];
        for ($i = 6; $i >= 0; $i--) {
            $fecha = date('Y-m-d', strtotime("-$i days"));
            $resultado[] = [
                'fecha' => $fecha,
                'total' => $ventasPorFecha[$fecha] ?? 0
            ];
        }

        return $resultado;
    }
}

