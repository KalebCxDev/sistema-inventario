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
    var btnQuitarCliente = document.getElementById('btn-quitar-cliente');
    var dniMensaje = document.getElementById('dni-mensaje');
    var clienteIdInput = document.getElementById('cliente_id');
    var clienteNombreInput = document.getElementById('cliente_nombre');
    var modal = document.getElementById('modal-cliente');
    var modalNombres = document.getElementById('modal-nombres');
    var modalApellidos = document.getElementById('modal-apellidos');
    var modalFecha = document.getElementById('modal-fecha-nacimiento');
    var btnGuardarCliente = document.getElementById('btn-guardar-cliente');
    var btnCerrarModal = document.getElementById('btn-cerrar-modal');

    // 0. Auto-focus al cargar la pÃ¡gina en el buscador de productos
    if (buscador) {
        buscador.focus();
    }

    // Abrir automÃ¡ticamente el ticket en nueva pestaÃ±a si acaba de cobrarse una venta
    var urlParams = new URLSearchParams(window.location.search);
    var ticketId = urlParams.get('ticket_id');
    if (ticketId) {
        window.open('ver_ticket.php?id=' + encodeURIComponent(ticketId), '_blank');
    }

    // Limpiar alertas de Ã©xito despuÃ©s de 6 segundos para permitir leer o dar clic al botÃ³n de ticket
    var alertaOk = document.getElementById('mensaje-venta-ok') || document.querySelector('.ok');
    if (alertaOk && alertaOk.id !== 'dni-mensaje') {
        setTimeout(function () {
            alertaOk.style.transition = 'opacity 0.6s ease';
            alertaOk.style.opacity = '0';
            setTimeout(function () {
                if (alertaOk.parentNode) alertaOk.parentNode.removeChild(alertaOk);
            }, 600);
        }, 6000);
    }

    function render(highlightId) {
        tbody.innerHTML = '';
        var total = 0;
        carrito.forEach(function (item, i) {
            var sub = item.precio * item.cantidad;
            total += sub;
            var tr = document.createElement('tr');
            if (highlightId !== undefined && item.id === highlightId) {
                tr.style.backgroundColor = '#e0f2fe';
                setTimeout(function () {
                    tr.style.transition = 'background-color 0.8s ease';
                    tr.style.backgroundColor = '';
                }, 300);
            }
            tr.innerHTML =
                '<td>' + item.nombre + '</td>' +
                '<td><input type="number" min="1" max="' + item.stock + '" value="' + item.cantidad + '" data-i="' + i + '" class="cant"></td>' +
                '<td>' + sub.toFixed(2) + '</td>' +
                '<td><button type="button" class="btn eliminar" data-quitar="' + i + '" title="Quitar">X</button></td>';
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
                alert('No hay mas stock disponible de: ' + nombre + ' (Stock: ' + stock + ')');
                return;
            }
            existente.cantidad++;
        } else {
            carrito.push({ id: id, nombre: nombre, precio: precio, cantidad: 1, stock: stock });
        }
        render(id);
    }

    function limpiarCliente() {
        clienteIdInput.value = '';
        clienteNombreInput.value = '';
        buscadorDni.value = '';
        dniMensaje.textContent = '';
        dniMensaje.style.display = 'none';
        if (btnQuitarCliente) btnQuitarCliente.style.display = 'none';
        buscadorDni.focus();
    }

    function cerrarModalCliente() {
        modal.style.display = 'none';
        buscadorDni.value = '';
        buscadorDni.focus();
    }

    function abrirModalCliente(dni) {
        document.getElementById('modal-dni-texto').textContent = dni;
        document.getElementById('modal-dni-valor').value = dni;
        modalNombres.value = '';
        modalApellidos.value = '';
        modalFecha.value = '';
        modal.style.display = 'block';
        // Enfoque automÃ¡tico al primer input del modal
        setTimeout(function () {
            modalNombres.focus();
        }, 50);
    }

    // 1. Agregar productos con el botÃ³n
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

    // 3. Editar cantidad desde el carrito con validaciÃ³n inmediata de stock
    tbody.addEventListener('change', function (e) {
        if (!e.target.classList.contains('cant')) return;
        var i = parseInt(e.target.dataset.i);
        var v = parseInt(e.target.value);
        if (isNaN(v) || v < 1) {
            v = 1;
        }
        if (v > carrito[i].stock) {
            alert('La cantidad ingresada supera el stock disponible (' + carrito[i].stock + ') para ' + carrito[i].nombre);
            v = carrito[i].stock;
        }
        carrito[i].cantidad = v;
        render();
    });

    // 4. Vaciar carrito
    btnVaciar.addEventListener('click', function () {
        if (carrito.length === 0) return;
        if (confirm('¿Seguro que deseas vaciar el carrito?')) {
            carrito = [];
            render();
            buscador.focus();
        }
    });

    // 5. EscÃ¡ner o bÃºsqueda de productos
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
                    var stockActual = parseInt(fila.dataset.stock);
                    if (stockActual <= 0) {
                        alert('El producto "' + fila.dataset.nombre + '" no tiene stock disponible.');
                    } else {
                        agregar(parseInt(fila.dataset.id), fila.dataset.nombre, parseFloat(fila.dataset.precio), stockActual);
                    }
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

    // Filtro visual en tabla de productos
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

    // 6. ValidaciÃ³n y Confirmaciones antes de Cobrar
    formCobrar.addEventListener('submit', function (e) {
        if (carrito.length === 0) {
            e.preventDefault();
            alert('El carrito esta¡ vaci­o. Agrega productos antes de cobrar.');
            return;
        }

        var totalVenta = totalEl.textContent;
        var clienteNombre = clienteNombreInput.value.trim();
        var confirmacion = false;

        if (clienteNombre === '') {
            // Caso sin cliente definido
            confirmacion = confirm(
                'No hay ningun cliente asignado a la venta.\n\n' +
                'Total a cobrar: S/ ' + totalVenta + '\n' +
                '¿Desea continuar con la venta a Publico General?'
            );
        } else {
            // Caso con cliente definido
            confirmacion = confirm(
                '¿Confirmar venta por S/ ' + totalVenta + ' a nombre de:\n' +
                clienteNombre + '?'
            );
        }

        if (!confirmacion) {
            e.preventDefault();
            btnCobrar.disabled = false;
            btnCobrar.textContent = 'Cobrar';
            return;
        }

        // Evitar doble clic/doble cobro
        btnCobrar.disabled = true;
        btnCobrar.textContent = 'Procesando...';
    });

    // Solo permitir nÃºmeros en el buscador de DNI
    buscadorDni.addEventListener('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    // 7. Buscar DNI con validaciÃ³n
    buscadorDni.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            e.preventDefault();
            var dni = buscadorDni.value.trim();

            if (dni === '') {
                limpiarCliente();
                return;
            }

            if (dni.length !== 8) {
                alert('El DNI debe contener exactamente 8 digitos.');
                return;
            }

            fetch('ajax_buscar_cliente.php?dni=' + encodeURIComponent(dni))
                .then(function (response) { return response.json(); })
                .then(function (data) {
                    if (data.existe) {
                        clienteIdInput.value = data.id;
                        clienteNombreInput.value = data.nombre;
                        dniMensaje.textContent = 'Cliente: ' + data.nombre + (data.edad ? ' (' + data.edad + ' aÃ±os)' : '');
                        dniMensaje.style.display = 'block';
                        if (btnQuitarCliente) btnQuitarCliente.style.display = 'inline-block';
                        buscadorDni.value = '';
                    } else {
                        // Cliente no existe, abre modal y enfoca primer campo
                        abrirModalCliente(dni);
                    }
                })
                .catch(function () {
                    alert('Error de conexion al buscar DNI.');
                });
        }
    });

    if (btnQuitarCliente) {
        btnQuitarCliente.addEventListener('click', function () {
            limpiarCliente();
        });
    }

    // 8. Guardar cliente nuevo desde el modal
    function guardarClienteDesdeModal() {
        var dni = document.getElementById('modal-dni-valor').value;
        var nombres = modalNombres.value.trim();
        var apellidos = modalApellidos.value.trim();
        var fechaNac = modalFecha.value;

        if (nombres === '' || apellidos === '' || fechaNac === '') {
            alert('Por favor, completa nombres, apellidos y fecha de nacimiento.');
            if (nombres === '') modalNombres.focus();
            else if (apellidos === '') modalApellidos.focus();
            else modalFecha.focus();
            return;
        }

        btnGuardarCliente.disabled = true;
        btnGuardarCliente.textContent = 'Guardando...';

        var formData = new FormData();
        formData.append('dni', dni);
        formData.append('nombres', nombres);
        formData.append('apellidos', apellidos);
        formData.append('fecha_nacimiento', fechaNac);

        fetch('ajax_guardar_cliente.php', { method: 'POST', body: formData })
            .then(function (response) { return response.json(); })
            .then(function (data) {
                btnGuardarCliente.disabled = false;
                btnGuardarCliente.textContent = 'Guardar y Usar';

                if (data.ok) {
                    clienteIdInput.value = data.id;
                    clienteNombreInput.value = data.nombre;
                    dniMensaje.textContent = 'Cliente: ' + data.nombre + (data.edad ? ' (' + data.edad + ' Años)' : '');
                    dniMensaje.style.display = 'block';
                    if (btnQuitarCliente) btnQuitarCliente.style.display = 'inline-block';
                    modal.style.display = 'none';
                    buscadorDni.value = '';
                } else {
                    alert('Error: ' + data.error);
                }
            })
            .catch(function () {
                btnGuardarCliente.disabled = false;
                btnGuardarCliente.textContent = 'Guardar y Usar';
                alert('Error al comunicarse con el servidor.');
            });
    }

    btnGuardarCliente.addEventListener('click', guardarClienteDesdeModal);

    // Enter en los inputs del modal para enviar
    [modalNombres, modalApellidos, modalFecha].forEach(function (el) {
        el.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.keyCode === 13) {
                e.preventDefault();
                guardarClienteDesdeModal();
            }
        });
    });

    // 9. Cerrar modal con botÃ³n y tecla Escape
    btnCerrarModal.addEventListener('click', cerrarModalCliente);

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' || e.keyCode === 27) {
            if (modal.style.display === 'block') {
                cerrarModalCliente();
            }
        }
    });

    // 10. Reimpresion rapida de tickets
    var inputTicket = document.getElementById('input-ticket');
    var btnReimprimir = document.getElementById('btn-reimprimir');

    function reimprimirTicket() {
        if (!inputTicket) return;
        var num = inputTicket.value.trim();
        if (!num || parseInt(num, 10) <= 0) {
            alert('Por favor ingrese un número de ticket válido.');
            inputTicket.focus();
            return;
        }
        window.open('ver_ticket.php?id=' + encodeURIComponent(num), '_blank');
        inputTicket.value = '';
    }

    if (btnReimprimir) {
        btnReimprimir.addEventListener('click', reimprimirTicket);
    }

    if (inputTicket) {
        inputTicket.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.keyCode === 13) {
                e.preventDefault();
                reimprimirTicket();
            }
        });
    }
});