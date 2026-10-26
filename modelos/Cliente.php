<?php

class Cliente extends Model
{
    private $id;
    private $dni;
    private $nombres;
    private $apellidos;
    private $fecha_nacimiento; // nueva propiedad

    public function setId($v) { $this->id = (int)$v; }
    public function getId() { return $this->id; }
    public function getDni() { return $this->dni; }
    public function getNombres() { return $this->nombres; }
    public function getApellidos() { return $this->apellidos; }
    public function getFechaNacimiento() { return $this->fecha_nacimiento; }
    public function getNombreCompleto() { return trim($this->nombres . ' ' . $this->apellidos); }

    // calcula la edad a partir de la fecha
    public function getEdad()
    {
        if (!$this->fecha_nacimiento) return 0;
        $hoy = new DateTime();
        $nacimiento = new DateTime($this->fecha_nacimiento);
        return $hoy->diff($nacimiento)->y;
    }

    public function setDni($v)
    {
        if (trim($v) === '') throw new Exception('El DNI no puede estar vacio');
        $this->dni = trim($v);
    }

    public function setNombres($v)
    {
        if (trim($v) === '') throw new Exception('Los nombres no pueden estar vacios');
        $this->nombres = trim($v);
    }

    public function setApellidos($v)
    {
        if (trim($v) === '') throw new Exception('Los apellidos no pueden estar vacios');
        $this->apellidos = trim($v);
    }

    // valida que la fecha no sea futura
    public function setFechaNacimiento($v)
    {
        if (trim($v) === '') throw new Exception('La fecha de nacimiento es obligatoria');
        if (strtotime($v) > time()) throw new Exception('La fecha de nacimiento no puede ser futura');
        $this->fecha_nacimiento = trim($v);
    }

    public function guardar()
    {
        $stmt = $this->db->prepare("INSERT INTO clientes (dni, nombres, apellidos, fecha_nacimiento) VALUES (:d, :n, :a, :f)");
        $stmt->execute([':d' => $this->dni, ':n' => $this->nombres, ':a' => $this->apellidos, ':f' => $this->fecha_nacimiento]);
        $this->id = $this->db->lastInsertId();
        return $this->id;
    }

    public function buscarPorDni($dni)
    {
        $stmt = $this->db->prepare("SELECT * FROM clientes WHERE dni = :d");
        $stmt->execute([':d' => $dni]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$fila) return null;

        $c = new Cliente();
        $c->setId($fila['id']);
        $c->setDni($fila['dni']);
        $c->setNombres($fila['nombres']);
        $c->setApellidos($fila['apellidos']);
        $c->setFechaNacimiento($fila['fecha_nacimiento']); // añadido
        return $c;
    }
}