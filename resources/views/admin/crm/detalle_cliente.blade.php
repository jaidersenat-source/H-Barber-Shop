@extends('admin.layout')

@vite(['resources/css/Admin/crm/detalle.css'])

@section('content')
<div class="card" id="modulo-crm-detalle" role="main" aria-label="Detalles del cliente {{ $cliente->nombre ?? '' }}">

    <div class="header-flex-responsive">
        <h2>Historial del cliente</h2>
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


    {{-- Resumen de gastos --}}
    @php
            $totalGastoTexto    = $totalGasto;
            $promedioGastoTexto = $promedioGasto;
    @endphp

   <div class="resumen-gastos">
    <div class="resumen-card">
        <span class="resumen-label" id="total-gastado-label">Total gastado</span>
        <div class="resumen-cifra" aria-hidden="true">${{ $totalGastoTexto }}</div>
        <span class="sr-only">Total gastado por {{ $cliente->nombre ?? 'el cliente' }}: {{ $totalGastoTexto }} pesos colombianos</span>
    </div>
    <div class="resumen-card">
        <span class="resumen-label" id="promedio-gasto-label">Promedio por visita</span>
        <div class="resumen-cifra" aria-hidden="true">${{ $promedioGastoTexto }}</div>
        <span class="sr-only">Promedio por visita de {{ $cliente->nombre ?? 'el cliente' }}: {{ $promedioGastoTexto }} pesos colombianos</span>
    </div>
</div>

    {{-- ══════════════════════════
         TABLA DE TURNOS
    ══════════════════════════ --}}
    <h3 style="margin-top:32px;" tabindex="0">Turnos</h3>

    <!-- Lista accesible para lector de pantalla -->
    <ul class="sr-only" aria-label="Lista de turnos del cliente">
        @forelse($turnos as $t)
        @php
            \Carbon\Carbon::setLocale('es');
            $fechaTurnoVisual = \Carbon\Carbon::parse($t->tur_fecha)
                ->translatedFormat('l, d \d\e F \d\e Y');
            $horaParts  = explode(':', $t->tur_hora);
            $horaNum    = (int) $horaParts[0];
            $minNum     = (int) ($horaParts[1] ?? 0);
            $horaAria   = $minNum === 0
                ? "las {$horaNum} en punto"
                : "las {$horaNum} y {$minNum} minutos";
            $barberoNombre  = $t->disponibilidad->persona->per_nombre   ?? '';
            $barberoApellido = $t->disponibilidad->persona->per_apellido ?? '';
        @endphp
        <li>
            <strong>Fecha:</strong> {{ $fechaTurnoVisual }}<br>
            <strong>Hora:</strong> {{ $t->tur_hora }}<br>
            <strong>Barbero:</strong> {{ $barberoNombre }} {{ $barberoApellido }}<br>
            <strong>Estado:</strong> {{ $t->tur_estado }}<br>
        </li>
        @empty
        <li>No hay turnos registrados.</li>
        @endforelse
    </ul>

    <table class="table" aria-label="Turnos del cliente {{ $cliente->nombre ?? '' }}">
        <thead>
            <tr>
                <th scope="col">Fecha</th>
                <th scope="col">Hora</th>
                <th scope="col">Barbero</th>
                <th scope="col">Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse($turnos as $t)
            @php
                \Carbon\Carbon::setLocale('es');
                $fechaTurnoVisual = \Carbon\Carbon::parse($t->tur_fecha)
                    ->translatedFormat('l d \d\e F \d\e Y');
                $fechaTurnoAria = $fechaTurnoVisual;
                $horaParts  = explode(':', $t->tur_hora);
                $horaNum    = (int) $horaParts[0];
                $minNum     = (int) ($horaParts[1] ?? 0);
                $horaAria   = $minNum === 0
                    ? "las {$horaNum} en punto"
                    : "las {$horaNum} y {$minNum} minutos";
                $barberoNombre  = $t->disponibilidad->persona->per_nombre   ?? '';
                $barberoApellido = $t->disponibilidad->persona->per_apellido ?? '';
            @endphp
            <tr aria-label="Fecha {{ $fechaTurnoAria }}, hora {{ $horaAria }}, barbero {{ $barberoNombre }} {{ $barberoApellido }}, estado {{ $t->tur_estado }}.">
                <td data-label="Fecha">{{ $fechaTurnoVisual }}</td>
                <td data-label="Hora">{{ $t->tur_hora }}</td>
                <td data-label="Barbero">{{ $barberoNombre }} {{ $barberoApellido }}</td>
                <td data-label="Estado">{{ $t->tur_estado }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align:center;">No hay turnos registrados</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- ══════════════════════════
         TABLA DE FACTURAS
    ══════════════════════════ --}}
    <h3 style="margin-top:32px;" tabindex="0">Facturas</h3>

    <!-- Lista accesible para lector de pantalla -->
    <ul class="sr-only" aria-label="Lista de facturas del cliente">
        @forelse($facturas as $f)
        @php
            \Carbon\Carbon::setLocale('es');
            $fechaFacturaVisual = \Carbon\Carbon::parse($f->fac_fecha)
                ->translatedFormat('l, d \d\e F \d\e Y');
            $totalTexto = $f->fac_total;
            $abonoTexto = $f->fac_abono;
        @endphp
        <li>
            <strong>ID:</strong> {{ $f->fac_id }}<br>
            <strong>Total:</strong> {{ $totalTexto }} pesos colombianos<br>
            <strong>Abono:</strong> {{ $abonoTexto }} pesos colombianos<br>
            <strong>Fecha:</strong> {{ $fechaFacturaVisual }}<br>
        </li>
        @empty
        <li>No hay facturas registradas.</li>
        @endforelse
    </ul>

    <table class="table" aria-label="Facturas del cliente {{ $cliente->nombre ?? '' }}">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Total</th>
                <th scope="col">Abono</th>
                <th scope="col">Fecha</th>
            </tr>
        </thead>
        <tbody>
            @forelse($facturas as $f)
            @php
                \Carbon\Carbon::setLocale('es');
                $fechaFacturaVisual = \Carbon\Carbon::parse($f->fac_fecha)
                    ->translatedFormat('l d \d\e F \d\e Y');
                $fechaFacturaAria = $fechaFacturaVisual;
                $totalTexto = $f->fac_total;
                $abonoTexto = $f->fac_abono;
            @endphp
            <tr aria-label="Factura número {{ $f->fac_id }}, total {{ $totalTexto }} pesos colombianos, abono {{ $abonoTexto }} pesos colombianos, fecha {{ $fechaFacturaAria }}.">
                <td data-label="ID">{{ $f->fac_id }}</td>
                <td data-label="Total">{{ $totalTexto }} pesos colombianos</td>
                <td data-label="Abono">{{ $abonoTexto }} pesos colombianos</td>
                <td data-label="Fecha">{{ $fechaFacturaVisual }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align:center;">No hay facturas registradas</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>
@endsection