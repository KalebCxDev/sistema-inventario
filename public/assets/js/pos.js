document.addEventListener('DOMContentLoaded', function () {
    var carrito = [];
    var tabla   = document.getElementById('tabla-pos');
    var tbody   = document.querySelector('#tabla-carrito tbody');
    var totalEl = document.getElementById('total');
    var input   = document.getElementById('carrito-input');
    var btnCobrar = document.getElementById('btn-cobrar');
    var btnVaciar = document.getElementById('btn-vaciar');
    var buscador  = document.getElementById('buscador-pos');
    var errorEscaner = document.getElementById('escaneo-error');
    var formCobrar = document.getElementById('form-cobrar');

    var buscadorDni = document.getElementById('buscador-dni');
    var dniMensaje = document.getElementById('dni-mensaje');
    var clienteIdInput = document.getElementById('cliente_id');
    var clienteNombreInput = document.getElementById('cliente_nombre');
    var modal = document.getElementById('modal-cliente');
    var modalFecha = document.getElementById('modal-fecha-nacimiento');

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
            if (existente.cantidad + 1 > stock) {
                alert('No hay más stock de: ' + nombre);
                return;
            }
            existente.cantidad++;
        } else {
            carrito.push({ id: id, nombre: nombre, precio: precio, cantidad: 1, stock: stock });
        }
        render();
    }

    // 1. Agregar productos con el boton
    tabla.addEventListener('click', function (e) {
        if (!e.target.classList.contains('btn-agregar')) return;
        var tr = e.target.closest('tr');
        agregar(parseInt(tr.dataset.id), tr.dataset.nombre, parseFloat(tr.dataset.precio), parseInt(tr.dataset.stock));
    });

    // 2. Quitar productos del carrito
    tbody.addEventListener('click', function (e) {
        if (!e.target.dataset.quitar) return;
        carrito.splice(parseInt(e.target.dataset.quitar), 1);
        render();
    });

    // 3. Editar cantidad desde el carrito
    tbody.addEventListener('change', function (e) {
        if (!e.target.classList.contains('cant')) return;
        var i = parseInt(e.target.dataset.i);
        var v = parseInt(e.target.value);
        if (v < 1) v = 1;
        if (v > carrito[i].stock) v = carrito[i].stock;
        carrito[i].cantidad = v;
        render();
    });

    // 4. Vaciar carrito
    btnVaciar.addEventListener('click', function () {
        if (confirm('¿Seguro que deseas vaciar el carrito?')) {
            carrito = [];
            render();
        }
    });

    // 5. Escaner o busqueda manual de productos
    buscador.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            e.preventDefault(); 
            var q = buscador.value.trim();
            if (q === '') return;

            errorEscaner.style.display = 'none';
            var filas = tabla.querySelectorAll('tbody tr');
            var encontrado = false;

            for (var i = 0; i < filas.length; i++) {
                var fila = filas[i];
                var skuTabla = fila.dataset.sku.trim(); 

                if (skuTabla.toLowerCase() === q.toLowerCase()) {
                    agregar(parseInt(fila.dataset.id), fila.dataset.nombre, parseFloat(fila.dataset.precio), parseInt(fila.dataset.stock));
                    buscador.value = ''; 
                    encontrado = true;
                    break;
                }
            }

            if (!encontrado) {
                errorEscaner.style.display = 'block';
                buscador.value = '';
            }
        }
    });

    // Filtro visual
    buscador.addEventListener('input', function () {
        var q = buscador.value.toLowerCase().trim();
        var filas = tabla.querySelectorAll('tbody tr');
        for (var i = 0; i < filas.length; i++) {
            var fila = filas[i];
            var nombre = fila.dataset.nombre.toLowerCase();
            var sku    = fila.dataset.sku.trim().toLowerCase();
            var coincide = nombre.indexOf(q) !== -1 || sku.indexOf(q) !== -1;
            fila.style.display = coincide ? '' : 'none';
        }
    });

    // 6. Prevenir cobrar con carrito vacio
    formCobrar.addEventListener('submit', function(e) {
        if (carrito.length === 0) {
            e.preventDefault();
            alert('El carrito esta vacio, agrega productos antes de cobrar.');
        }
    });

    // 7. Buscar DNI
    buscadorDni.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            e.preventDefault();
            var dni = buscadorDni.value.trim();
            
            if (dni === '') {
                clienteIdInput.value = '';
                clienteNombreInput.value = '';
                dniMensaje.style.display = 'none';
                return;
            }

            fetch('ajax_buscar_cliente.php?dni=' + encodeURIComponent(dni))
                .then(response => response.json())
                .then(data => {
                    if (data.existe) {
                        clienteIdInput.value = data.id;
                        clienteNombreInput.value = data.nombre;
                        // muestra nombre y edad
                        dniMensaje.textContent = 'Cliente: ' + data.nombre + ' (' + data.edad + ' años)';
                        dniMensaje.style.display = 'block';
                        buscadorDni.value = '';
                    } else {
                        // cliente no existe, abre modal
                        document.getElementById('modal-dni-texto').textContent = dni;
                        document.getElementById('modal-dni-valor').value = dni;
                        document.getElementById('modal-nombres').value = '';
                        document.getElementById('modal-apellidos').value = '';
                        modalFecha.value = ''; 
                        modal.style.display = 'block';
                    }
                })
                .catch(err => alert('Error de conexion al buscar DNI'));
        }
    });

    // 8. Guardar cliente nuevo desde el modal
    document.getElementById('btn-guardar-cliente').addEventListener('click', function() {
        var dni = document.getElementById('modal-dni-valor').value;
        var nombres = document.getElementById('modal-nombres').value;
        var apellidos = document.getElementById('modal-apellidos').value;
        var fechaNac = modalFecha.value;

        if (nombres.trim() === '' || apellidos.trim() === '' || fechaNac === '') {
            alert('Por favor, completa nombres, apellidos y fecha de nacimiento.');
            return;
        }

        var formData = new FormData();
        formData.append('dni', dni);
        formData.append('nombres', nombres);
        formData.append('apellidos', apellidos);
        formData.append('fecha_nacimiento', fechaNac);

        fetch('ajax_guardar_cliente.php', { method: 'POST', body: formData })
            .then(response => response.json())
            .then(data => {
                if (data.ok) {
                    clienteIdInput.value = data.id;
                    clienteNombreInput.value = data.nombre;
                    // muestra nombre y edad calculada
                    dniMensaje.textContent = 'Cliente: ' + data.nombre + ' (' + data.edad + ' años)';
                    dniMensaje.style.display = 'block';
                    modal.style.display = 'none';
                    buscadorDni.value = '';
                } else {
                    alert('Error: ' + data.error);
                }
            });
    });

    // 9. Cerrar modal
    document.getElementById('btn-cerrar-modal').addEventListener('click', function() {
        modal.style.display = 'none';
        buscadorDni.value = '';
    });
});