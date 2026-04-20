@extends('admin.layout')

@vite(['resources/css/Admin/crm/crm.css'])

@section('content')
<h1>Clientes (CRM)</h1>
<div class="card" id="modulo-crm">
    <form method="GET" id="form-busqueda-clientes" style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap; margin-bottom: 1.5rem;">
    <input type="text" 
           name="nombre" 
           id="buscar-nombre"
           value="{{ request('nombre') }}" 
           class="form-control busqueda-auto" 
           placeholder="Buscar por nombre"
           style="flex: 1; min-width: 200px;">
    
    <input type="text" 
           name="celular" 
           id="buscar-celular"
           value="{{ request('celular') }}" 
           class="form-control busqueda-auto" 
           placeholder="Buscar por celular"
           style="flex: 1; min-width: 200px;">
    
    {{-- Botón oculto para accesibilidad --}}
    <button type="submit" class="sr-only">Buscar</button>
    
    <a href="{{ route('crm.clientes.exportPdf') }}"
       class="btn btn-exportar btn-pdf"
       target="_blank"
       style="padding: 0.75rem 1.5rem; background: #374151; color: white; border: none; border-radius: 6px; text-decoration: none; font-weight: 600; transition: background 0.2s; display: inline-flex; align-items: center; gap: 0.5rem;"
       onmouseover="this.style.background='#1f2937'"
       onmouseout="this.style.background='#374151'">
        📄 Exportar PDF
    </a>
    
    <a href="{{ route('crm.clientes.exportExcel') }}"
       class="btn btn-exportar btn-excel"
       target="_blank"
       style="padding: 0.75rem 1.5rem; background: #10b981; color: white; border: none; border-radius: 6px; text-decoration: none; font-weight: 600; transition: background 0.2s; display: inline-flex; align-items: center; gap: 0.5rem;"
       onmouseover="this.style.background='#059669'"
       onmouseout="this.style.background='#10b981'">
        📊 Exportar Excel
    </a>
</form>

    {{-- =====================================================
         LISTA ACCESIBLE para lector de pantalla (JAWS)
         ===================================================== --}}
    <ul class="sr-only" aria-label="Lista de clientes detallada">
        @forelse($clientes as $c)
        @php
            $inactivo = false;
            $ultimaVisitaNatural = $c->ultima_visita
                ? \Carbon\Carbon::parse($c->ultima_visita)->locale('es')->translatedFormat('l, d \d\e F \d\e Y')
                : 'Sin visitas';

            if ($c->ultima_visita) {
                $inactivo = \Carbon\Carbon::parse($c->ultima_visita)->diffInMonths(now()) >= 2;
            }

            // Preparar datos WhatsApp 
            $waNumero  = preg_replace('/[^0-9]/', '', $c->tur_celular);
            $waNumero  = (strlen($waNumero) === 10) ? '57' . $waNumero : $waNumero;
            $waMensaje = urlencode("Hola {$c->tur_nombre}, hace tiempo no te vemos por H Barber Shop. ¡Te esperamos para tu próximo corte! Agenda tu cita cuando quieras. 💈");
        @endphp
        <li>
            <strong>Cliente:</strong> {{ $c->tur_nombre }}<br>
            <strong>Celular:</strong> {{ $c->tur_celular }}<br>
            <strong>Visitas:</strong> {{ $c->visitas }}<br>
            <strong>Última visita:</strong> {{ $ultimaVisitaNatural }}<br>
            <strong>Gasto total:</strong> {{ $c->gasto_total }} pesos colombianos<br>
            <strong>Servicio favorito:</strong> {{ $c->servicio_favorito ?? 'N/A' }}<br>
            <strong>Acción:</strong>

            @if(isset($c->tur_cedula) && $c->tur_cedula)
                <a href="{{ route('crm.clientes.detalle', $c->tur_cedula) }}"
                   aria-label="Ver historial de {{ $c->tur_nombre }}">
                    Ver historial
                </a>
            @else
                <span aria-disabled="true">Ver historial</span>
            @endif

            @if($inactivo)
                {{-- ✅ BOTÓN WHATSAPP — cliente inactivo +2 meses --}}
                <a href="https://wa.me/{{ $waNumero }}?text={{ $waMensaje }}"
                   target="_blank" rel="noopener noreferrer"
                   aria-label="Invitar a {{ $c->tur_nombre }} a volver a la barbería vía WhatsApp">
                    Invitar por WhatsApp
                </a>
                <span role="alert" aria-live="polite">
                    El cliente {{ $c->tur_nombre }} con número {{ $c->tur_celular }} no ha vuelto hace más de 2 meses.
                </span>
            @endif
        </li>
        @empty
        <li>No hay clientes registrados</li>
        @endforelse
    </ul>

    {{-- =====================================================
         TABLA VISUAL — solo para usuarios videntes
         ===================================================== --}}
    @php
        $headers = ['Cliente', 'Celular', 'Visitas', 'Última visita', 'Gasto total', 'Servicio favorito', 'Acción'];
    @endphp
    <table class="table" style="width:100%;border-collapse:collapse;" aria-hidden="true">
        <thead>
            <tr>
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
                    $inactivo = \Carbon\Carbon::parse($c->ultima_visita)->diffInMonths(now()) >= 2;
                }
                $ultimaVisitaNatural = $c->ultima_visita
                    ? \Carbon\Carbon::parse($c->ultima_visita)->locale('es')->isoFormat('dddd D [de] MMMM [de] YYYY')
                    : 'Sin visitas';

                // Preparar datos WhatsApp
                $waNumero  = preg_replace('/[^0-9]/', '', $c->tur_celular);
                $waNumero  = (strlen($waNumero) === 10) ? '57' . $waNumero : $waNumero;
                $waMensaje = urlencode("Hola {$c->tur_nombre}, hace tiempo no te vemos por H Barber Shop. ¡Te esperamos para tu próximo corte! Agenda tu cita cuando quieras. 💈");
            @endphp
            <tr>
                <td data-label="Cliente" style="padding:8px;">{{ $c->tur_nombre }}</td>
                <td data-label="Celular" style="padding:8px;">{{ $c->tur_celular }}</td>
                <td data-label="Visitas" style="padding:8px;">{{ $c->visitas }}</td>
                <td data-label="Última visita" style="padding:8px;">{{ $ultimaVisitaNatural }}</td>
                <td data-label="Gasto total" style="padding:8px;">{{ number_format($c->gasto_total, 0) }}</td>
                <td data-label="Servicio favorito" style="padding:8px;">{{ $c->servicio_favorito ?? 'N/A' }}</td>
                <td data-label="Acción" style="padding:8px;">

                    @if(isset($c->tur_cedula) && $c->tur_cedula)
                        <a href="{{ route('crm.clientes.detalle', $c->tur_cedula) }}"
                           class="btn btn-primary btn-sm"
                           aria-label="Ver historial de {{ $c->tur_nombre }}">
                            Ver historial
                        </a>
                    @endif

                    @if($inactivo)
                        {{-- ✅ BOTÓN WHATSAPP — cliente inactivo +2 meses --}}
                        <a href="https://wa.me/{{ $waNumero }}?text={{ $waMensaje }}"
                           target="_blank" rel="noopener noreferrer"
                           class="btn btn-whatsapp btn-sm"
                           aria-label="Invitar a {{ $c->tur_nombre }} a volver a la barbería vía WhatsApp">
                            <i class="fab fa-whatsapp" aria-hidden="true"></i> Invitar
                        </a>
                        <div class="badge-inactivo" title="Sin visita hace más de 2 meses">
                            ⚠️ Inactivo
                        </div>
                    @endif

                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center;">No hay clientes registrados</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Paginación --}}
    @if($clientes->hasPages() || $clientes->total() > 0)
    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem; margin-top:1.5rem; padding-top:1rem; border-top:1px solid #e5e7eb;">
        <p style="margin:0; color:#6b7280; font-size:0.875rem;">
            Mostrando
            <strong>{{ $clientes->firstItem() ?? 0 }}</strong>
            a
            <strong>{{ $clientes->lastItem() ?? 0 }}</strong>
            de
            <strong>{{ $clientes->total() }}</strong>
            cliente{{ $clientes->total() !== 1 ? 's' : '' }}
        </p>
        {{ $clientes->links() }}
    </div>
    @endif

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('form-busqueda-clientes');
    const inputNombre = document.getElementById('buscar-nombre');
    const inputCelular = document.getElementById('buscar-celular');
    let timeoutId = null;

    // Función para enviar el formulario con un pequeño retraso (debounce)
    function buscarConDelay() {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => {
            form.submit();
        }, 500); // Espera 500ms después de que el usuario deje de escribir
    }

    // Escuchar cambios en ambos inputs
    inputNombre.addEventListener('input', buscarConDelay);
    inputCelular.addEventListener('input', buscarConDelay);
});
</script>
@endsection