<?php

class AjaxController
{
    public function buscar_cliente()
    {
        $dni = trim($_GET['dni'] ?? '');
        $cliente = (new Cliente())->buscarPorDni($dni);

        header('Content-Type: application/json');
        
        if ($cliente) {
            echo json_encode([
                'existe' => true,
                'id' => $cliente->getId(),
                'nombre' => $cliente->getNombreCompleto(),
                'edad' => $cliente->getEdad() // devolvemos la edad
            ]);
        } else {
            echo json_encode(['existe' => false]);
        }
        exit;
    }

    public function guardar_cliente()
    {
        try {
            $c = new Cliente();
            $c->setDni($_POST['dni'] ?? '');
            $c->setNombres($_POST['nombres'] ?? '');
            $c->setApellidos($_POST['apellidos'] ?? '');
            $c->setFechaNacimiento($_POST['fecha_nacimiento'] ?? ''); // capturamos
            $c->guardar();

            header('Content-Type: application/json');
            echo json_encode([
                'ok' => true,
                'id' => $c->getId(),
                'nombre' => $c->getNombreCompleto(),
                'edad' => $c->getEdad()
            ]);
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        }
        exit;
    }
}