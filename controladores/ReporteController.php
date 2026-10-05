<?php

require_once __DIR__ . '/../librerias/dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

class ReporteController
{
    public function productos()
    {
        $productos = (new Producto())->listarTodos();

        ob_start();
        require __DIR__ . '/../vistas/reportes/productos_pdf.php';
        $html = ob_get_clean();

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'DejaVu Sans');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('productos.pdf', ['Attachment' => false]); 
    }
}