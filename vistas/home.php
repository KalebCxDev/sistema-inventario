<?php require __DIR__ . '/header.php'; ?>

<h1>Sistema de Inventario</h1>
<div class="cards">
    <a href="productos.php" class="card">
        <div class="num"><?= $totalProductos ?></div>
        <div class="lbl">Productos</div>
    </a>

    <a href="categorias.php" class="card">
        <div class="num"><?= $totalCategorias ?></div>
        <div class="lbl">Categorías</div>
    </a>

    <?php if (puedeVer('movimientos')): ?>
        <a href="movimientos.php" class="card">
            <div class="num"><?= $totalMovimientos ?></div>
            <div class="lbl">Movimientos</div>
        </a>
    <?php endif; ?>

    <a href="alertas.php" class="card <?= $totalAlertas > 0 ? 'alerta' : '' ?>">
        <div class="num"><?= $totalAlertas ?></div>
        <div class="lbl">En alerta</div>
    </a>

    <?php if (puedeVer('pos')): ?>
        <a href="pos.php" class="card">
            <div class="num">POS</div>
            <div class="lbl">Punto de Venta</div>
        </a>
    <?php endif; ?>
</div>

<?php 
    $totalSemana = !empty($ventasSemana) ? array_sum(array_column($ventasSemana, 'total')) : 0;
?>

<div style="margin-top: 36px; background: #ffffff; border-radius: 10px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); border: 1px solid #e5e7eb; max-width: 900px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
        <div>
            <h2 style="margin: 0; color: #1f2937; font-size: 18px;">Ventas de los últimos 7 días</h2>
            <small style="color: #6b7280; font-size: 13px;">Resumen diario de ingresos</small>
        </div>
        <div style="background: #eff6ff; padding: 6px 14px; border-radius: 20px; border: 1px solid #bfdbfe;">
            <span style="font-size: 13px; color: #1e40af;">Total 7 días: <strong>S/ <?= number_format($totalSemana, 2) ?></strong></span>
        </div>
    </div>

    <div id="contenedorGrafico" style="position: relative; height: 320px; width: 100%;">
        <canvas id="graficoVentas"></canvas>
    </div>
</div>

<script>
    function renderizarGrafico() {
        const canvas = document.getElementById('graficoVentas');
        if (!canvas) return;

        if (typeof Chart === 'undefined') {
            document.getElementById('contenedorGrafico').innerHTML = 
                '<div style="text-align:center; padding: 60px 20px; color: #6b7280;">' +
                '<p style="font-size: 16px; font-weight: 600; color: #374151; margin-bottom: 8px;">No se pudo cargar la librería Chart.js</p>' +
                '<p style="font-size: 13px;">Verifica tu conexión a internet para descargar la librería de gráficos.</p>' +
                '</div>';
            return;
        }

        const datosVentas = <?= json_encode($ventasSemana ?? []) ?>;

        const etiquetas = datosVentas.map(item => {
            const partes = item.fecha.split('-');
            if (partes.length === 3) {
                return partes[2] + '/' + partes[1]; // Formato DD/MM
            }
            return item.fecha;
        });

        const montos = datosVentas.map(item => parseFloat(item.total) || 0);

        const ctx = canvas.getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: etiquetas,
                datasets: [{
                    label: 'Ventas del día (S/)',
                    data: montos,
                    backgroundColor: 'rgba(37, 99, 235, 0.75)',
                    borderColor: '#2563eb',
                    borderWidth: 1.5,
                    borderRadius: 6,
                    hoverBackgroundColor: 'rgba(29, 78, 216, 0.9)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'S/ ' + Number(value).toFixed(2);
                            },
                            color: '#6b7280',
                            font: { size: 12 }
                        },
                        grid: {
                            color: '#f3f4f6'
                        }
                    },
                    x: {
                        ticks: {
                            color: '#4b5563',
                            font: { size: 12, weight: '500' }
                        },
                        grid: {
                            display: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            color: '#374151',
                            font: { size: 13, weight: '500' }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return ' Total: S/ ' + Number(context.parsed.y).toFixed(2);
                            }
                        }
                    }
                }
            }
        });
    }

    // Aseguramos que se ejecute después de cargar todos los scripts
    if (document.readyState === 'complete') {
        renderizarGrafico();
    } else {
        window.addEventListener('load', renderizarGrafico);
    }
</script>

<?php require __DIR__ . '/footer.php'; ?>
