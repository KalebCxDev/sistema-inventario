<?php

require_once __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelController
{
    public function productos()
    {
        $productos = (new Producto())->listarTodos();

        $documento = new Spreadsheet();
        $hoja = $documento->getActiveSheet();
        $hoja->setTitle('Productos');

        $encabezado = ['ID', 'Nombre', 'SKU', 'Precio', 'Stock', 'Mínimo', 'Tipo', 'Descripción'];
        $hoja->fromArray($encabezado, null, 'A1');

        $fila = 2;
        foreach ($productos as $p) {
            $hoja->setCellValue("A{$fila}", $p->getId());
            $hoja->setCellValue("B{$fila}", $p->getNombre());
            $hoja->setCellValue("C{$fila}", $p->getSku());
            $hoja->setCellValue("D{$fila}", $p->getPrecioVenta());
            $hoja->setCellValue("E{$fila}", $p->getStockActual());
            $hoja->setCellValue("F{$fila}", $p->getStockMinimo());
            $hoja->setCellValue("G{$fila}", $p->getTipo());
            $hoja->setCellValue("H{$fila}", $p->descripcion());
            $fila++;
        }

        foreach (range('A', 'H') as $col) {
            $hoja->getColumnDimension($col)->setAutoSize(true);
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="productos.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($documento);
        $writer->save('php://output');
        exit;
    }
}