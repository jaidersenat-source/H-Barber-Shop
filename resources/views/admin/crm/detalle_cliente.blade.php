@extends('admin.layout')

@vite(['resources/css/Admin/crm/detalle.css'])

@section('content')
<div class="card" id="modulo-crm-detalle" role="main" aria-label="Detalles del cliente {{ $cliente->nombre ?? '' }}">
    <div class="header-flex-responsive">
        <h2 style="margin:0;font-size:2rem;font-weight:700;color:#1a365d;">Historial del cliente</h2>
        <a href="{{ route('crm.clientes') }}" class="btn btn-outline-primary volver-btn" accesskey="b" aria-label="Volver al listado de clientes">
            <span aria-hidden="true">&larr;</span> Volver
        </a>
    </div>
    <style>
    .header-flex-responsive {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.5rem;
        gap: 1.5rem;
        flex-wrap: wrap;
    }
    @media (max-width: 600px) {
        .header-flex-responsive {
            flex-direction: column;
            align-items: stretch;
            gap: 0.75rem;
        }
        .header-flex-responsive .volver-btn {
            width: 100%;
            max-width: 100%;
            min-width: 0;
            box-sizing: border-box;
        }
    }
    </style>
    <form method="GET" action="" style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:24px;" aria-label="Filtrar historial del cliente">
        <input type="date" name="desde" value="{{ request('desde') }}" class="form-control" placeholder="Desde" aria-label="Filtrar desde fecha">
        <input type="date" name="hasta" value="{{ request('hasta') }}" class="form-control" placeholder="Hasta" aria-label="Filtrar hasta fecha">
        <input type="text" name="servicio" value="{{ request('servicio') }}" class="form-control" placeholder="Servicio (opcional)" aria-label="Filtrar por servicio">
        <button type="submit" class="btn btn-primary" aria-label="Filtrar historial">Filtrar historial</button>
        <a href="" class="btn btn-secondary" aria-label="Limpiar filtros">Limpiar</a>
    </form>
    <div style="display:flex;gap:32px;flex-wrap:wrap;margin-bottom:24px;">
        <div style="flex:1;min-width:220px;background:#f8f9fa;padding:16px;border-radius:8px;" aria-label="Total gastado por {{ $cliente->nombre ?? 'el cliente' }}">
            <span style="font-size:1.1em;color:#6c757d;">Total gastado</span>
            <div style="font-size:1.7em;font-weight:bold;color:#2d3a4b;">${{ number_format($totalGasto, 0) }}</div>
        </div>
        <div style="flex:1;min-width:220px;background:#f8f9fa;padding:16px;border-radius:8px;" aria-label="Promedio por visita de {{ $cliente->nombre ?? 'el cliente' }}">
            <span style="font-size:1.1em;color:#6c757d;">Promedio por visita</span>
            <div style="font-size:1.7em;font-weight:bold;color:#2d3a4b;">${{ number_format($promedioGasto, 0) }}</div>
        </div>
    </div>
    <h3 style="margin-top:32px;" tabindex="0">Turnos</h3>
    <table class="table" aria-label="Turnos del cliente {{ $cliente->nombre ?? '' }}">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Barbero</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse($turnos as $t)
            <tr aria-label="Turno de {{ $t->tur_nombre }} el {{ $t->tur_fecha }} a las {{ $t->tur_hora }} con {{ $t->disponibilidad->persona->per_nombre }} {{ $t->disponibilidad->persona->per_apellido }} estado {{ $t->tur_estado }}">
                @php $fechaNatural = \Carbon\Carbon::parse($t->tur_fecha)->translatedFormat('l, d \d\e F \d\e Y'); @endphp
                <tr aria-label="Turno de {{ $t->tur_nombre }} el {{ $fechaNatural }} a las {{ $t->tur_hora }} con {{ $t->disponibilidad->persona->per_nombre }} {{ $t->disponibilidad->persona->per_apellido }} estado {{ $t->tur_estado }}">
                <td>{{ $fechaNatural }}</td>
                <td>{{ $t->tur_hora }}</td>
                <td>{{ $t->disponibilidad->persona->per_nombre }} {{ $t->disponibilidad->persona->per_apellido }}</td>
                <td>{{ $t->tur_estado }}</td>
            </tr>
            @empty
            <tr><td colspan="4" style="text-align:center;">No hay turnos registrados</td></tr>
            @endforelse
        </tbody>
    </table>
    <h3 style="margin-top:32px;" tabindex="0">Facturas</h3>
    <table class="table" aria-label="Facturas del cliente {{ $cliente->nombre ?? '' }}">
        <thead>
            <tr>
                <th>ID</th>
                <th>Total</th>
                <th>Abono</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @forelse($facturas as $f)
            <tr aria-label="Factura {{ $f->fac_id }} total ${{ number_format($f->fac_total, 0) }} abono ${{ number_format($f->fac_abono, 0) }} fecha {{ $f->fac_fecha }}">
                @php $fechaFacturaNatural = \Carbon\Carbon::parse($f->fac_fecha)->translatedFormat('l, d \d\e F \d\e Y'); @endphp
                <tr aria-label="Factura {{ $f->fac_id }} total ${{ number_format($f->fac_total, 0) }} abono ${{ number_format($f->fac_abono, 0) }} fecha {{ $fechaFacturaNatural }}">
                <td>{{ $f->fac_id }}</td>
                <td>${{ number_format($f->fac_total, 0) }}</td>
                <td>${{ number_format($f->fac_abono, 0) }}</td>
                <td>{{ $fechaFacturaNatural }}</td>
            </tr>
            @empty
            <tr><td colspan="4" style="text-align:center;">No hay facturas registradas</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<script>
// Navegación accesible con flechas y Tab para todo el módulo Detalle Cliente
// y volver al menú con Esc
document.addEventListener('DOMContentLoaded', function() {
    const modulo = document.getElementById('modulo-crm-detalle');
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
@endsection
