@extends('admin.layout')

@section('content')
@vite(['resources/css/Admin/factura/facturas.css'])
<div class="facturas-container" id="modulo-facturas">
    <h2>Listado de Facturas</h2>
    <form method="GET" action="" class="facturas-filtros" aria-label="Filtrar facturas">
        <div class="filtro-grupo">
            <label for="fecha">Fecha</label>
            <input type="date" name="fecha" id="fecha" value="{{ request('fecha') }}" class="form-control" placeholder="Filtrar por fecha">
        </div>
        <div class="filtro-grupo">
            <label for="buscar">Buscar</label>
            <input type="text" name="buscar" id="buscar" value="{{ request('buscar') }}" class="form-control" placeholder="Buscar por cliente, sede o ID">
        </div>
        <button type="submit" class="btn btn-primary" aria-label="Filtrar facturas">Filtrar</button>
        <a href="{{ route('factura.index') }}" class="btn btn-secondary" aria-label="Limpiar filtros">Limpiar</a>
    </form>
    <div class="facturas-table-wrapper">
        <!-- Lista vertical accesible para lectores de pantalla -->
        <ul class="sr-only" aria-label="Listado de facturas detallado">
            @foreach($facturas as $factura)
            @php
                $subtotal = 0;
                $totalDescuento = 0;
                $porcentajeTotal = 0;
                $serviciosConDescuento = 0;
                foreach($factura->detalles as $detalle) {
                    $precioOriginal = $detalle->servicios->serv_precio ?? $detalle->serv_precio;
                    // Usar el descuento aplicado en el momento de la factura
                    $descuento = $detalle->serv_descuento ?? ($detalle->servicios->serv_descuento ?? 0);
                    $subtotal += $precioOriginal;
                    $totalDescuento += ($precioOriginal - $detalle->serv_precio);
                    if($descuento > 0) {
                        $porcentajeTotal += $descuento;
                        $serviciosConDescuento++;
                    }
                }
                $porcentajePromedio = $serviciosConDescuento > 0 ? $porcentajeTotal / $serviciosConDescuento : 0;
                $totalFinal = $subtotal - $totalDescuento;
            @endphp
            <li>
                <strong>ID:</strong> {{ $factura->fac_id }}<br>
                <strong>Fecha:</strong>
                    <span aria-describedby="fecha-factura-lista-{{ $factura->fac_id }}">{{ $factura->fac_fecha }}</span>
                    <span id="fecha-factura-lista-{{ $factura->fac_id }}" class="sr-only">
                        {{ \Carbon\Carbon::parse($factura->fac_fecha)->isoFormat('D [de] MMMM [de] YYYY') }}
                    </span><br>
                <strong>Sede:</strong> {{ $factura->sede->sede_nombre ?? '' }}<br>
                <strong>Turno:</strong> {{ $factura->turno->tur_id ?? '' }}<br>
                <strong>Total:</strong> ${{ number_format($factura->fac_total,2) }}<br>
                <strong>Abono:</strong> ${{ number_format($factura->fac_abono,2) }}<br>
                <strong>Descuento promedio:</strong> {{ number_format($porcentajePromedio,2) }}%<br>
                <strong>Total con descuento:</strong> ${{ number_format($totalFinal,2) }}<br>
                <strong>Acciones:</strong> Ver factura / Descargar PDF / Eliminar factura
            </li>
            @endforeach
        </ul>
        <!-- Tabla visual solo para usuarios videntes -->
        <table class="facturas-table" role="table" aria-label="Listado de facturas">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Sede</th>
                    <th scope="col">Turno</th>
                    <th scope="col">Total</th>
                    <th scope="col">Abono</th>
                    <th scope="col">Descuento (%)</th>
                    <th scope="col">Total con descuento</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($facturas as $factura)
                @php
                    $subtotal = 0;
                    $totalDescuento = 0;
                    $porcentajeTotal = 0;
                    $serviciosConDescuento = 0;
                    foreach($factura->detalles as $detalle) {
                        $precioOriginal = $detalle->servicios->serv_precio ?? $detalle->serv_precio;
                        $descuento = $detalle->servicios->serv_descuento ?? 0;
                        $subtotal += $precioOriginal;
                        $totalDescuento += ($precioOriginal - $detalle->serv_precio);
                        if($descuento > 0) {
                            $porcentajeTotal += $descuento;
                            $serviciosConDescuento++;
                        }
                    }
                    $porcentajePromedio = $serviciosConDescuento > 0 ? $porcentajeTotal / $serviciosConDescuento : 0;
                    $totalFinal = $subtotal - $totalDescuento;
                @endphp
                <tr>
                    <td data-label="ID">{{ $factura->fac_id }}</td>
                    <td data-label="Fecha">
                        <span aria-describedby="fecha-factura-tabla-{{ $factura->fac_id }}">{{ $factura->fac_fecha }}</span>
                        <span id="fecha-factura-tabla-{{ $factura->fac_id }}" class="sr-only">
                            {{ \Carbon\Carbon::parse($factura->fac_fecha)->isoFormat('D [de] MMMM [de] YYYY') }}
                        </span>
                    </td>
                    <td data-label="Sede">{{ $factura->sede->sede_nombre ?? '' }}</td>
                    <td data-label="Turno">{{ $factura->turno->tur_id ?? '' }}</td>
                    <td data-label="Total">${{ number_format($factura->fac_total,2) }}</td>
                    <td data-label="Abono">${{ number_format($factura->fac_abono,2) }}</td>
                    <td data-label="Descuento (%)">{{ number_format($porcentajePromedio,2) }}%</td>
                    <td data-label="Total con descuento">${{ number_format($totalFinal,2) }}</td>
                    <td class="acciones" data-label="Acciones">
                        <a href="{{ route('facturas.show', $factura->fac_id) }}" class="btn btn-info btn-sm" aria-label="Ver factura {{ $factura->fac_id }}">Ver</a>
                        <a href="{{ route('facturas.pdf', $factura->fac_id) }}" class="btn btn-secondary btn-sm" target="_blank" aria-label="Descargar PDF de la factura {{ $factura->fac_id }}">Descargar PDF</a>
                        <button type="button" class="btn btn-danger btn-sm" aria-label="Eliminar factura {{ $factura->fac_id }}" onclick="confirmarEliminacionFactura({{ $factura->fac_id }})">Eliminar</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Modal para contraseña de administrador -->
    <div id="modal-admin-pass" class="modal-admin" style="display:none;">
        <div class="modal-admin-content">
            <button type="button" class="modal-admin-close" aria-label="Cerrar" tabindex="0">&times;</button>
            <h3>Eliminar factura</h3>
            <p id="modal-admin-msg">Para eliminar la factura, introduce tu contraseña de administrador:</p>
            <input type="password" id="modal-admin-input" class="modal-admin-input" placeholder="Contraseña" autocomplete="current-password" tabindex="0">
            <div class="modal-admin-actions">
                <button type="button" class="modal-admin-accept">Aceptar</button>
                <button type="button" class="modal-admin-cancel">Cancelar</button>
            </div>
        </div>
    </div>
<script>
// Navegación accesible con flechas y Tab para todo el módulo Facturas
// y volver al menú con Esc
document.addEventListener('DOMContentLoaded', function() {
    const modulo = document.getElementById('modulo-facturas');
    if (!modulo) return;
    const focusableSelectors = 'a, button, input, select, textarea, [tabindex]:not([tabindex="-1"])';
    const focusables = Array.from(modulo.querySelectorAll(focusableSelectors)).filter(el => !el.disabled && el.offsetParent !== null);
    if (focusables.length === 0) return;
    let current = 0;
    focusables[0].focus();
    modulo.addEventListener('keydown', function(e) {
        if (e.key === 'Tab') {
            // Focus trap
            const first = focusables[0];
            const last = focusables[focusables.length - 1];
            if (e.shiftKey) {
                if (document.activeElement === first) {
                    e.preventDefault();
                    last.focus();
                }
            } else {
                if (document.activeElement === last) {
                    e.preventDefault();
                    first.focus();
                }
            }
        } else if (["ArrowDown", "ArrowRight"].includes(e.key)) {
            e.preventDefault();
            current = focusables.indexOf(document.activeElement);
            if (current !== -1) {
                let next = (current + 1) % focusables.length;
                focusables[next].focus();
            }
        } else if (["ArrowUp", "ArrowLeft"].includes(e.key)) {
            e.preventDefault();
            current = focusables.indexOf(document.activeElement);
            if (current !== -1) {
                let prev = (current - 1 + focusables.length) % focusables.length;
                focusables[prev].focus();
            }
        } else if (e.key === 'Escape') {
            const menu = document.querySelector('.sidebar a');
            if (menu) menu.focus();
        }
    });
});
</script>
<script>
// Lógica para mostrar y manejar el modal de contraseña
function showAdminPasswordModal(msg, callback) {
    const modal = document.getElementById('modal-admin-pass');
    const input = document.getElementById('modal-admin-input');
    const closeBtn = modal.querySelector('.modal-admin-close');
    const acceptBtn = modal.querySelector('.modal-admin-accept');
    const cancelBtn = modal.querySelector('.modal-admin-cancel');
    document.getElementById('modal-admin-msg').textContent = msg;
    modal.style.display = 'flex';
    input.value = '';
    setTimeout(() => input.focus(), 100);
    function closeModal() {
        modal.style.display = 'none';
        acceptBtn.onclick = cancelBtn.onclick = closeBtn.onclick = null;
        input.onkeydown = null;
    }
    acceptBtn.onclick = function() {
        closeModal();
        callback(input.value);
    };
    cancelBtn.onclick = closeBtn.onclick = function() {
        closeModal();
        callback(null);
    };
    input.onkeydown = function(e) {
        if (e.key === 'Enter') acceptBtn.click();
        if (e.key === 'Escape') cancelBtn.click();
    };
}
// Ejemplo de uso:
// showAdminPasswordModal('Para eliminar la factura #4 introduce tu contraseña de administrador:', function(pass) { if(pass){...} });
function confirmarEliminacionFactura(id) {
    showAdminPasswordModal('Para eliminar la factura #' + id + ' introduce tu contraseña de administrador:', function(pass) {
        if(pass){
            // Crear formulario y enviar petición de eliminación
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = '/admin/facturas/' + id;
            form.style.display = 'none';
            var csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';
            var methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            var passwordInput = document.createElement('input');
            passwordInput.type = 'hidden';
            passwordInput.name = 'password';
            passwordInput.value = pass;
            form.appendChild(csrfInput);
            form.appendChild(methodInput);
            form.appendChild(passwordInput);
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>
</div>
@endsection
