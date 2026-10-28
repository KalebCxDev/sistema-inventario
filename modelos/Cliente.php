<?php

class Cliente
{
    private $id;
    private $dni;
    private $nombres;
    private $apellidos;
    private $fecha_nacimiento;

    public function setId($v) { $this->id = (int)$v; }
    public function getId() { return $this->id; }
    public function getDni() { return $this->dni; }
    public function getNombres() { return $this->nombres; }
    public function getApellidos() { return $this->apellidos; }
    public function getFechaNacimiento() { return $this->fecha_nacimiento; }
    public function getNombreCompleto() { return trim($this->nombres . ' ' . $this->apellidos); }

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

    public function setFechaNacimiento($v)
    {
        if (trim($v) === '') throw new Exception('La fecha de nacimiento es obligatoria');
        if (strtotime($v) > time()) throw new Exception('La fecha de nacimiento no puede ser futura');
        $this->fecha_nacimiento = trim($v);
    }

    public function guardar()
    {
        $dao = new ClienteDAO(conectar());
        return $dao->guardar($this);
    }

    public function buscarPorDni($dni)
    {
        $dao = new ClienteDAO(conectar());
        return $dao->buscarPorDni($dni);
    }
}
