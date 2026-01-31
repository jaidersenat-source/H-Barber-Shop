@extends('admin.layout')

@vite(['resources/css/Admin/crm/crm.css'])

@section('content')
<h1 style="font-size:2rem;font-weight:700;margin-bottom:1.5rem;color:#1a365d;">Clientes (CRM)</h1>
<div class="card" id="modulo-crm">
    <form method="GET" action="" style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:20px;align-items:flex-end;">
        <input type="text" name="nombre" value="{{ request('nombre') }}" class="form-control" placeholder="Buscar por nombre">
        <input type="text" name="celular" value="{{ request('celular') }}" class="form-control" placeholder="Buscar por celular">
        <button type="submit" class="btn btn-primary">Filtrar</button>
        <a href="{{ route('crm.clientes') }}" class="btn btn-secondary">Limpiar</a>
        <a href="{{ route('crm.clientes.exportPdf') }}"
   class="btn btn-exportar-pdf"
   target="_blank">
   Exportar PDF
</a>

    </form>
    <!-- Lista vertical accesible para lectores de pantalla -->
    <ul class="sr-only" aria-label="Lista de clientes detallada">
        @forelse($clientes as $c)
        @php
            $inactivo = false;
            $ultimaVisitaNatural = $c->ultima_visita ? \Carbon\Carbon::parse($c->ultima_visita)->translatedFormat('l, d \d\e F \d\e Y') : 'Sin visitas';
            if ($c->ultima_visita) {
                $fechaUltima = \Carbon\Carbon::parse($c->ultima_visita);
                $inactivo = $fechaUltima->diffInMonths(now()) >= 2;
            }
        @endphp
        <li @if($inactivo) style="border:2px solid #f59e42;padding:8px;" @endif>
            <strong>Cliente:</strong> {{ $c->tur_nombre }}<br>
            <strong>Celular:</strong> {{ $c->tur_celular }}<br>
            <strong>Visitas:</strong> {{ $c->visitas }}<br>
            <strong>Última visita:</strong> {{ $ultimaVisitaNatural }}<br>
            <strong>Gasto total:</strong> ${{ number_format($c->gasto_total, 0) }}<br>
            <strong>Servicio favorito:</strong> {{ $c->servicio_favorito ?? 'N/A' }}<br>
            <strong>Acción:</strong> Ver historial
            @if($inactivo)
                <span style="color:#d97706;font-weight:bold;" role="alert" aria-live="polite">
                    El cliente {{ $c->tur_nombre }} con número {{ $c->tur_celular }} no ha vuelto hace más de 2 meses.
                </span>
            @endif
        </li>
        @empty
        <li>No hay clientes registrados</li>
        @endforelse
    </ul>

    <!-- Tabla visual solo para usuarios videntes -->
    @php
    $headers = ['Cliente', 'Celular', 'Visitas', 'Última visita', 'Gasto total', 'Servicio favorito', 'Acción'];
    @endphp
    <table class="table" style="width:100%;border-collapse:collapse;" aria-hidden="true">
        <thead>
            <tr style="background:#e9ecef;color:#2d3a4b;">
                @foreach($headers as $header)
                    <th style="padding:8px;">{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse($clientes as $c)
            @php
                $inactivo = false;
                if ($c->ultima_visita) {
                    $fechaUltima = \Carbon\Carbon::parse($c->ultima_visita);
                    $inactivo = $fechaUltima->diffInMonths(now()) >= 2;
                }
            @endphp
            <tr @if($inactivo) style="border:2px solid #f59e42;" @endif>
                <td data-label="Cliente" style="padding:8px;">{{ $c->tur_nombre }}</td>
                <td data-label="Celular" style="padding:8px;">{{ $c->tur_celular }}</td>
                <td data-label="Visitas" style="padding:8px;">{{ $c->visitas }}</td>
            @php
                $ultimaVisitaNatural = $c->ultima_visita
                    ? \Carbon\Carbon::parse($c->ultima_visita)->locale('es')->isoFormat('dddd D [de] MMMM [de] YYYY')
                    : 'Sin visitas';
            @endphp
                <td data-label="Última visita" style="padding:8px;">
                    {{ $ultimaVisitaNatural }}
                </td>
                <td data-label="Gasto total" style="padding:8px;">${{ number_format($c->gasto_total, 0) }}</td>
                <td data-label="Servicio favorito" style="padding:8px;">{{ $c->servicio_favorito ?? 'N/A' }}</td>
                <td data-label="Acción" style="padding:8px;">
                    @if(isset($c->tur_cedula) && $c->tur_cedula)
                        <a href="{{ route('crm.clientes.detalle', $c->tur_cedula) }}"
                           class="btn btn-primary btn-sm" aria-label="Ver historial de {{ $c->tur_nombre }}">
                            Ver historial
                        </a>
                    @endif
                    @if($inactivo)
                        <div style="color:#d97706;font-weight:bold;">
                            El cliente {{ $c->tur_nombre }} con número {{ $c->tur_celular }} no ha vuelto hace más de 2 meses.
                        </div>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;">No hay clientes registrados</td></tr>
            @endforelse
        </tbody>
    </table>

</div>
<script>
// Navegación accesible mejorada para todo el módulo CRM
document.addEventListener('DOMContentLoaded', function() {
    const modulo = document.getElementById('modulo-crm');
    if (!modulo) return;
    const focusableSelectors = 'a, button, input, select, textarea, [tabindex]:not([tabindex="-1"])';
    let focusables = Array.from(modulo.querySelectorAll(focusableSelectors)).filter(el => !el.disabled && el.offsetParent !== null);
    if (focusables.length === 0) return;
    // Forzar tabindex=-1 si el primer elemento no es focusable
    if (!focusables[0].hasAttribute('tabindex')) {
        focusables[0].setAttribute('tabindex', '-1');
    }
    setTimeout(() => {
        if (typeof focusables[0].focus === 'function') {
            focusables[0].focus();
        }
    }, 150);
    modulo.addEventListener('keydown', function(e) {
        focusables = Array.from(modulo.querySelectorAll(focusableSelectors)).filter(el => !el.disabled && el.offsetParent !== null);
        const idx = focusables.indexOf(document.activeElement);
        if (e.key === 'Tab') {
            // Focus trap
            if (e.shiftKey && document.activeElement === focusables[0]) {
                e.preventDefault();
                focusables[focusables.length - 1].focus();
            } else if (!e.shiftKey && document.activeElement === focusables[focusables.length - 1]) {
                e.preventDefault();
                focusables[0].focus();
            }
        } else if (["ArrowDown", "ArrowRight"].includes(e.key)) {
            e.preventDefault();
            if (idx !== -1) {
                focusables[(idx + 1) % focusables.length].focus();
            }
        } else if (["ArrowUp", "ArrowLeft"].includes(e.key)) {
            e.preventDefault();
            if (idx !== -1) {
                focusables[(idx - 1 + focusables.length) % focusables.length].focus();
            }
        } else if (e.key === 'Escape') {
            let menu = document.querySelector('.sidebar a, nav a, [role="navigation"] a');
            if (menu) {
                menu.setAttribute('tabindex', '-1');
                menu.focus();
            }
        }
    });
});
</script>

@endsection
