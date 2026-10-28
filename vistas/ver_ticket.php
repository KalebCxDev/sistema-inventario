<?php
// Vista para renderizar e imprimir boletas / tickets térmicos (80mm)
$idVenta = (int)($venta['id'] ?? 0);
$fechaVenta = !empty($venta['fecha']) ? date('d/m/Y H:i:s', strtotime($venta['fecha'])) : date('d/m/Y H:i:s');
$nombreCliente = !empty($venta['cliente']) ? $venta['cliente'] : 'Varios (Público General)';
$dniCliente = !empty($cliente['dni']) ? $cliente['dni'] : '';
$totalVenta = (float)($venta['total'] ?? 0);
$estadoVenta = $venta['estado'] ?? 'completada';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket de Venta #<?= $idVenta ?></title>
    <style>
        /* Estilos en pantalla */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #e5e7eb;
            font-family: 'Courier New', Courier, monospace;
            font-size: 13px;
            color: #000;
            padding: 20px;
        }

        /* Contenedor simulando papel térmico de 80mm */
        .ticket-wrapper {
            max-width: 80mm;
            margin: 0 auto;
            background: #fff;
            padding: 15px 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            border-radius: 4px;
        }

        .ticket-header {
            text-align: center;
            margin-bottom: 12px;
        }

        .ticket-header h1 {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 4px;
            text-transform: uppercase;
        }

        .ticket-header p {
            font-size: 11px;
            line-height: 1.4;
        }

        .divisor {
            border: none;
            border-top: 1px dashed #000;
            margin: 8px 0;
        }

        .ticket-datos {
            font-size: 12px;
            margin-bottom: 8px;
            line-height: 1.5;
        }

        .ticket-datos p {
            word-break: break-word;
        }

        /* Tabla de productos */
        table.ticket-items {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            margin: 8px 0;
        }

        table.ticket-items th {
            text-align: left;
            border-bottom: 1px dashed #000;
            padding: 4px 0;
            font-size: 11px;
        }

        table.ticket-items th.col-cant { width: 15%; text-align: center; }
        table.ticket-items th.col-desc { width: 55%; text-align: left; }
        table.ticket-items th.col-sub  { width: 30%; text-align: right; }

        table.ticket-items td {
            padding: 4px 0;
            vertical-align: top;
        }

        table.ticket-items td.col-cant { text-align: center; }
        table.ticket-items td.col-desc { text-align: left; word-break: break-word; }
        table.ticket-items td.col-sub  { text-align: right; white-space: nowrap; }

        .ticket-totales {
            margin-top: 6px;
            text-align: right;
            font-size: 13px;
        }

        .ticket-totales .total-grande {
            font-size: 16px;
            font-weight: bold;
            margin: 6px 0;
        }

        .ticket-footer {
            text-align: center;
            margin-top: 15px;
            font-size: 11px;
            line-height: 1.4;
        }

        .estado-anulada {
            border: 2px solid #dc2626;
            color: #dc2626;
            text-align: center;
            padding: 6px;
            font-weight: bold;
            font-size: 14px;
            margin: 10px 0;
            text-transform: uppercase;
        }

        /* Botones de acción en pantalla */
        .acciones-pantalla {
            max-width: 80mm;
            margin: 15px auto 0;
            display: flex;
            gap: 10px;
        }

        .btn-accion {
            flex: 1;
            padding: 10px;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            font-size: 13px;
            font-weight: 600;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            transition: opacity 0.2s;
        }

        .btn-imprimir {
            background-color: #2563eb;
            color: #fff;
        }

        .btn-volver {
            background-color: #4b5563;
            color: #fff;
        }

        .btn-accion:hover {
            opacity: 0.9;
        }

        /* Reglas estrictas para impresión */
        @media print {
            body {
                background: #fff !important;
                padding: 0 !important;
                margin: 0 !important;
            }

            .ticket-wrapper {
                max-width: 100% !important;
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                box-shadow: none !important;
                border-radius: 0 !important;
            }

            .no-imprimir {
                display: none !important;
            }

            @page {
                size: 80mm auto;
                margin: 3mm;
            }
        }
    </style>
</head>
<body>

    <div class="acciones-pantalla no-imprimir">
        <button type="button" class="btn-accion btn-imprimir" onclick="window.print()">🖨 Imprimir Ticket</button>
        <a href="pos.php" class="btn-accion btn-volver">← Volver al POS</a>
    </div>

    <div class="ticket-wrapper">
        <div class="ticket-header">
            <h1>MI TIENDA / BODEGA</h1>
            <p>SISTEMA DE CONTROL DE INVENTARIO</p>
            <p>R.U.C. 20123456789</p>
            <p>Oxapampa, Pasco - Perú</p>
            <p>Telf: (063) 123-456</p>
        </div>

        <hr class="divisor">

        <div class="ticket-datos">
            <p><strong>TICKET N°:</strong> #<?= str_pad($idVenta, 6, '0', STR_PAD_LEFT) ?></p>
            <p><strong>FECHA:</strong> <?= $fechaVenta ?></p>
            <p><strong>CLIENTE:</strong> <?= htmlspecialchars($nombreCliente) ?></p>
            <?php if (!empty($dniCliente)): ?>
                <p><strong>DNI:</strong> <?= htmlspecialchars($dniCliente) ?></p>
            <?php endif; ?>
        </div>

        <?php if ($estadoVenta === 'anulada'): ?>
            <div class="estado-anulada">** VENTA ANULADA **</div>
        <?php endif; ?>

        <hr class="divisor">

        <table class="ticket-items">
            <thead>
                <tr>
                    <th class="col-cant">CANT</th>
                    <th class="col-desc">DESCRIPCIÓN</th>
                    <th class="col-sub">TOTAL</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($items)): ?>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td class="col-cant"><?= (int)$item['cantidad'] ?></td>
                            <td class="col-desc">
                                <?= htmlspecialchars($item['nombre']) ?>
                                <?php if (!empty($item['precio'])): ?>
                                    <div style="font-size: 10px; color: #555;">(P.U. S/ <?= number_format($item['precio'], 2) ?>)</div>
                                <?php endif; ?>
                            </td>
                            <td class="col-sub">
                                S/ <?= number_format(!empty($item['subtotal']) ? $item['subtotal'] : 0, 2) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" style="text-align: center; padding: 8px 0;">
                            <?= htmlspecialchars($venta['detalle'] ?? '') ?>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <hr class="divisor">

        <div class="ticket-totales">
            <p class="total-grande">TOTAL: S/ <?= number_format($totalVenta, 2) ?></p>
            <p style="font-size: 11px;">OP. GRAVADA: S/ <?= number_format($totalVenta / 1.18, 2) ?></p>
            <p style="font-size: 11px;">I.G.V. (18%): S/ <?= number_format($totalVenta - ($totalVenta / 1.18), 2) ?></p>
        </div>

        <hr class="divisor">

        <div class="ticket-footer">
            <p>¡GRACIAS POR SU COMPRA!</p>
            <p>Conserve este ticket como comprobante.</p>
            <p style="margin-top: 5px; font-size: 10px;">Emitido por Sistema POS</p>
        </div>
    </div>

    <!-- Script de impresión automática -->
    <script>
        window.addEventListener('load', function () {
            // Se invoca el cuadro de impresión para probar guardando como PDF o en ticketera
            setTimeout(function () {
                window.print();
            }, 300);
        });
    </script>
</body>
</html>
