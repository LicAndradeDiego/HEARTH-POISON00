document.addEventListener('DOMContentLoaded', () => {
    // Validación HTML/JS para todos los formularios con data-validar.
    document.querySelectorAll('form[data-validar]').forEach(form => {
        form.addEventListener('submit', e => {
            let valido = true;
            form.querySelectorAll('[required]').forEach(input => {
                input.classList.remove('campo-error');
                if (!String(input.value).trim()) {
                    valido = false;
                    input.classList.add('campo-error');
                }
            });

            const tel = form.querySelector('input[name="Telefono"], input[name="Numero"], input[name="Celular"]');
            if (tel && tel.value.trim() && !/^\d{7,15}$/.test(tel.value.trim())) {
                valido = false;
                tel.classList.add('campo-error');
            }

            const ci = form.querySelector('input[name="CI"]');
            if (ci && ci.value.trim() && !/^\d{4,15}$/.test(ci.value.trim())) {
                valido = false;
                ci.classList.add('campo-error');
            }

            const precio = form.querySelector('input[name="precio"]');
            const costo = form.querySelector('input[name="costo"], input[name="costoTotal"]');
            const stock = form.querySelector('input[name="stock"]');

            if (precio && (Number(precio.value) <= 0 || Number.isNaN(Number(precio.value)))) {
                valido = false; precio.classList.add('campo-error');
            }
            if (costo && (Number(costo.value) < 0 || Number.isNaN(Number(costo.value)))) {
                valido = false; costo.classList.add('campo-error');
            }
            if (stock && (Number(stock.value) < 0 || Number.isNaN(Number(stock.value)))) {
                valido = false; stock.classList.add('campo-error');
            }

            if (!valido) {
                e.preventDefault();
                if (window.Swal) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Revisa el formulario',
                        text: 'Completa los campos correctamente antes de continuar.',
                        confirmButtonText: 'Entendido',
                        confirmButtonColor: '#7a2735'
                    });
                }
            }
        });
    });

    // Confirmación elegante para eliminaciones.
    document.querySelectorAll('.js-delete').forEach(link => {
        link.addEventListener('click', e => {
            if (!window.Swal) return;
            e.preventDefault();
            const destino = link.href;
            Swal.fire({
                icon: 'warning',
                title: '¿Eliminar registro?',
                text: 'Esta acción no se puede deshacer.',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#b30000',
                cancelButtonColor: '#444',
                background: '#111',
                color: '#fff'
            }).then(r => { if (r.isConfirmed) window.location.href = destino; });
        });
    });
});
