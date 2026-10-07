document.addEventListener('DOMContentLoaded', function () {
    var carrito = [];
    var tabla   = document.getElementById('tabla-pos');
    var tbody   = document.querySelector('#tabla-carrito tbody');
    var totalEl = document.getElementById('total');
    var input   = document.getElementById('carrito-input');
    var btnCobrar = document.getElementById('btn-cobrar');
    var btnVaciar = document.getElementById('btn-vaciar');
    var buscador  = document.getElementById('buscador-pos');

    function render() {
        tbody.innerHTML = '';
        var total = 0;
        carrito.forEach(function (item, i) {
            var sub = item.precio * item.cantidad;
            total += sub;
            var tr = document.createElement('tr');
            tr.innerHTML =
                '<td>' + item.nombre + '</td>' +
                '<td><input type="number" min="1" value="' + item.cantidad + '" data-i="' + i + '" class="cant"></td>' +
                '<td>' + sub.toFixed(2) + '</td>' +
                '<td><button type="button" class="btn eliminar" data-quitar="' + i + '">X</button></td>';
            tbody.appendChild(tr);
        });
        totalEl.textContent = total.toFixed(2);
        input.value = JSON.stringify(carrito);
        btnCobrar.disabled = carrito.length === 0;
    }

    function agregar(id, nombre, precio, stock) {
        var existente = carrito.find(function (x) { return x.id === id; });
        if (existente) {
            if (existente.cantidad + 1 > stock) return alert('No hay más stock');
            existente.cantidad++;
        } else {
            carrito.push({ id: id, nombre: nombre, precio: precio, cantidad: 1, stock: stock });
        }
        render();
    }

    tabla.addEventListener('click', function (e) {
        if (!e.target.classList.contains('btn-agregar')) return;
        var tr = e.target.closest('tr');
        agregar(
            parseInt(tr.dataset.id),
            tr.dataset.nombre,
            parseFloat(tr.dataset.precio),
            parseInt(tr.dataset.stock)
        );
    });

    tbody.addEventListener('click', function (e) {
        if (!e.target.dataset.quitar) return;
        carrito.splice(parseInt(e.target.dataset.quitar), 1);
        render();
    });

    tbody.addEventListener('change', function (e) {
        if (!e.target.classList.contains('cant')) return;
        var i = parseInt(e.target.dataset.i);
        var v = parseInt(e.target.value);
        if (v < 1) v = 1;
        if (v > carrito[i].stock) v = carrito[i].stock;
        carrito[i].cantidad = v;
        render();
    });

    btnVaciar.addEventListener('click', function () {
        carrito = [];
        render();
    });

    buscador.addEventListener('keyup', function () {
        var q = buscador.value.toLowerCase().trim();
        tabla.querySelectorAll('tbody tr').forEach(function (fila) {
            var nombre = fila.dataset.nombre.toLowerCase();
            fila.style.display = nombre.indexOf(q) !== -1 ? '' : 'none';
        });
    });
});