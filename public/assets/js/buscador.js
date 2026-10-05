document.addEventListener('DOMContentLoaded', function () {
    var input      = document.getElementById('buscador');
    var tabla      = document.getElementById('tabla-productos');
    if (!input || !tabla) return;

    var filas      = tabla.querySelectorAll('tbody tr');
    var contador   = document.getElementById('contador');
    var sinRes     = document.getElementById('sin-resultados');
    var totalFilas = filas.length;

    input.addEventListener('keyup', function () {
        var q = input.value.toLowerCase().trim();
        var visibles = 0;

        for (var i = 0; i < filas.length; i++) {
            var fila   = filas[i];
            var nombre = fila.cells[1].textContent.toLowerCase();
            var sku    = fila.cells[2].textContent.toLowerCase();
            var tipo   = fila.cells[6].textContent.toLowerCase();

            var coincide = q === ''
                || nombre.indexOf(q) !== -1
                || sku.indexOf(q) !== -1
                || tipo.indexOf(q) !== -1;

            fila.style.display = coincide ? '' : 'none';
            if (coincide) visibles++;
        }

        contador.textContent = visibles + ' de ' + totalFilas + ' productos';
        sinRes.style.display = (visibles === 0) ? 'block' : 'none';
    });
});