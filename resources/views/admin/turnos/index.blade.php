@extends('admin.layout')

@section('content')
@vite(['resources/css/Admin/turnos/turnos.css'])

<main id="modulo-turnos">
    <div class="card">

        <div class="card-header">
            <h1 id="turnos-titulo">Turnos Registrados</h1>
            <a href="{{ route('turnos.create') }}" class="btn crear-btn" aria-label="Crear nuevo turno">
                <span aria-hidden="true">&#43;</span> Crear turno
            </a>
        </div>

        {{-- Mensajes de sesión --}}
        @if(session('ok'))
            <p class="mensaje-ok" role="alert" aria-live="assertive">{{ session('ok') }}</p>
        @endif
        @if(session('error'))
            <p class="mensaje-error" role="alert" aria-live="assertive">{{ session('error') }}</p>
        @endif

        {{-- Filtros --}}
        {{-- Filtros dinámicos --}}
<form method="GET" class="form-filtros" id="form-filtros" aria-labelledby="filtros-titulo" novalidate>
    <p id="filtros-titulo" class="sr-only">Filtrar turnos</p>
    <div class="filtros-row" style="display: flex; width: 100%; gap: 1.25rem; align-items: flex-end;">
        <div class="filtro-grupo">
            <label for="estado">Estado</label>
            <select name="estado" id="estado" class="filtro-auto">
                <option value=""          @selected(request('estado') == '')          >Todos</option>
                <option value="Pendiente" @selected(request('estado') == 'Pendiente') >Pendiente</option>
                <option value="Cancelado" @selected(request('estado') == 'Cancelado') >Cancelado</option>
                <option value="Realizado" @selected(request('estado') == 'Realizado') >Realizado</option>
            </select>
        </div>
        <div class="filtro-grupo">
            <label for="estado_pago">Estado Pago</label>
            <select name="estado_pago" id="estado_pago" class="filtro-auto">
                <option value=""               @selected(request('estado_pago') == '')               >Todos</option>
                <option value="sin_anticipo"   @selected(request('estado_pago') == 'sin_anticipo')   >Sin Anticipo</option>
                <option value="pendiente_pago" @selected(request('estado_pago') == 'pendiente_pago') >Pendiente Pago</option>
                <option value="confirmado"     @selected(request('estado_pago') == 'confirmado')     >Pago Confirmado</option>
            </select>
        </div>
        <div class="filtro-grupo">
            <label for="fecha">Fecha</label>
            <input type="date" name="fecha" id="fecha" value="{{ request('fecha') }}" class="filtro-auto">
        </div>
        <div class="filtro-grupo">
            <label for="buscar">Buscar (cédula o nombre)</label>
            <input type="text" name="buscar" id="buscar" value="{{ request('buscar') }}" placeholder="Cédula o nombre del cliente" class="filtro-auto">
        </div>
        {{-- Botón de búsqueda, usar la variante del módulo para mantener estilo consistente --}}
        <button type="submit" class="btn-filtrar">Buscar</button>
    </div>
</form>

        <div id="turnos-contenido">

            {{-- =====================================================
                 LISTA ACCESIBLE para lector de pantalla (JAWS)
                 ===================================================== --}}
            <ul class="sr-only" aria-label="Lista de turnos">
                @forelse($turnos as $t)
                @php
                   // Preparar datos de WhatsApp una sola vez por turno
                  $waMensaje = urlencode("Hola {$t->tur_nombre}, tu cita ha sido confirmada para las {$t->tur_hora} en H Barber Shop. ¡Te esperamos!");
                  $waNumero  = preg_replace('/[^0-9]/', '', $t->tur_celular);
                  $waNumero  = (strlen($waNumero) === 10) ? '57' . $waNumero : $waNumero;
                @endphp
                <li>
                    <p><strong>Cliente:</strong> {{ $t->tur_nombre }}, teléfono {{ $t->tur_celular }}</p>
                    <p><strong>Barbero:</strong> {{ $t->disponibilidad->persona->per_nombre }} {{ $t->disponibilidad->persona->per_apellido }}</p>
                    <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($t->tur_fecha)->locale('es')->translatedFormat('l, d \d\e F \d\e Y') }}</p>
                    <p><strong>Hora:</strong> {{ $t->tur_hora }}</p>
                    <p><strong>Estado:</strong> {{ $t->tur_estado }}</p>

                    @if(isset($t->tur_estado_pago))
                        <p><strong>Estado de pago:</strong>
                            @if($t->tur_estado_pago === 'pendiente_pago')
                                Pendiente de verificación.
                                Anticipo: {{ number_format($t->tur_anticipo, 0, ',', '.') }} pesos.
                                Referencia: {{ $t->tur_referencia_pago }}.
                            @elseif($t->tur_estado_pago === 'confirmado')
                                Pago confirmado.
                            @else
                                Sin anticipo.
                            @endif
                        </p>
                    @endif

                    <div role="group" aria-label="Acciones para el turno de {{ $t->tur_nombre }}">

                        @if(isset($t->tur_estado_pago) && $t->tur_estado_pago === 'pendiente_pago')

                            <form action="{{ route('turnos.confirm-payment', $t->tur_id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                        aria-label="Confirmar pago del turno de {{ $t->tur_nombre }} del {{ \Carbon\Carbon::parse($t->tur_fecha)->locale('es')->translatedFormat('d \d\e F') }} a las {{ $t->tur_hora }}">
                                    Confirmar pago
                                </button>
                            </form>

                            <form action="{{ route('turnos.reject-payment', $t->tur_id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                        aria-label="Rechazar pago del turno de {{ $t->tur_nombre }} del {{ \Carbon\Carbon::parse($t->tur_fecha)->locale('es')->translatedFormat('d \d\e F') }} a las {{ $t->tur_hora }}">
                                    Rechazar pago
                                </button>
                            </form>

                            {{-- ✅ BOTÓN WHATSAPP — estado pendiente_pago --}}
                            <a href="https://wa.me/{{ $waNumero }}?text={{ $waMensaje }}"
                               target="_blank" rel="noopener noreferrer"
                               aria-label="Confirmar cita vía WhatsApp a {{ $t->tur_nombre }}">
                                Confirmar por WhatsApp
                            </a>

                        @elseif($t->tur_estado === 'Pendiente')

                            <form action="{{ route('turnos.complete', $t->tur_id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                        aria-label="Marcar como realizado el turno de {{ $t->tur_nombre }} del {{ \Carbon\Carbon::parse($t->tur_fecha)->locale('es')->translatedFormat('d \d\e F') }} a las {{ $t->tur_hora }}">
                                    Marcar como realizado
                                </button>
                            </form>

                            <form action="{{ route('turnos.cancel', $t->tur_id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                        aria-label="Cancelar el turno de {{ $t->tur_nombre }} del {{ \Carbon\Carbon::parse($t->tur_fecha)->locale('es')->translatedFormat('d \d\e F') }} a las {{ $t->tur_hora }}">
                                    Cancelar turno
                                </button>
                            </form>

                            <button type="button"
                                    class="btn-reprogramar-turno"
                                    data-tur-id="{{ $t->tur_id }}"
                                    data-tur-fecha="{{ $t->tur_fecha }}"
                                    data-tur-hora="{{ $t->tur_hora }}"
                                    aria-label="Reprogramar el turno de {{ $t->tur_nombre }} del {{ \Carbon\Carbon::parse($t->tur_fecha)->locale('es')->translatedFormat('d \d\e F') }} a las {{ $t->tur_hora }}">
                                Reprogramar turno
                            </button>

                            {{-- ✅ BOTÓN WHATSAPP — estado Pendiente --}}
                            <a href="https://wa.me/{{ $waNumero }}?text={{ $waMensaje }}"
                               target="_blank" rel="noopener noreferrer"
                               aria-label="Confirmar cita vía WhatsApp a {{ $t->tur_nombre }}">
                                Confirmar por WhatsApp
                            </a>

                        @elseif($t->tur_estado === 'Realizado')

                            <p>Estado: Realizado.</p>
                            <a href="{{ route('facturas.createFromTurno', ['tur_id' => $t->tur_id]) }}"
                               aria-label="Facturar el turno de {{ $t->tur_nombre }} del {{ \Carbon\Carbon::parse($t->tur_fecha)->locale('es')->translatedFormat('d \d\e F') }} a las {{ $t->tur_hora }}">
                                Facturar turno
                            </a>

                        @elseif($t->tur_estado === 'Cancelado')
                            <p>Estado: Cancelado. Sin acciones disponibles.</p>
                        @endif

                    </div>
                </li>
                @empty
                <li>No hay turnos registrados.</li>
                @endforelse
            </ul>

            {{-- =====================================================
                 TABLA VISUAL — solo para usuarios videntes
                 ===================================================== --}}
            <table class="table" aria-hidden="true">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Barbero</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Estado</th>
                        <th>Estado Pago</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($turnos as $t)
                    @php
                        // Preparar datos de WhatsApp una sola vez por turno
                        $waMensaje = urlencode("Hola {$t->tur_nombre}, tu cita ha sido confirmada para las {$t->tur_hora} en H Barber Shop. ¡Te esperamos!");
                        $waNumero  = preg_replace('/[^0-9]/', '', $t->tur_celular);
                        $waNumero  = (strlen($waNumero) === 10) ? '57' . $waNumero : $waNumero;
                    @endphp
                    <tr>
                        <td data-label="Cliente">{{ $t->tur_nombre }} ({{ $t->tur_celular }})</td>
                        <td data-label="Barbero">{{ $t->disponibilidad->persona->per_nombre }} {{ $t->disponibilidad->persona->per_apellido }}</td>
                        <td data-label="Fecha">{{ \Carbon\Carbon::parse($t->tur_fecha)->locale('es')->isoFormat('dddd D [de] MMMM [de] YYYY') }}</td>
                        <td data-label="Hora">{{ $t->tur_hora }}</td>
                        <td data-label="Estado">{{ $t->tur_estado }}</td>
                        <td data-label="Estado Pago">
                            @if(isset($t->tur_estado_pago) && $t->tur_estado_pago === 'pendiente_pago')
                                <span class="badge badge-pendiente">⏳ Pendiente Verificación</span>
                                <span class="pago-detalle">Anticipo: ${{ number_format($t->tur_anticipo, 0, ',', '.') }}</span>
                                <span class="pago-detalle">Ref: {{ $t->tur_referencia_pago }}</span>
                            @elseif(isset($t->tur_estado_pago) && $t->tur_estado_pago === 'confirmado')
                                <span class="badge badge-confirmado">✅ Confirmado</span>
                            @else
                                <span class="badge badge-sin">Sin Anticipo</span>
                            @endif
                        </td>
                        <td data-label="Acciones">
                            <div class="acciones-turno">
                                @if(isset($t->tur_estado_pago) && $t->tur_estado_pago === 'pendiente_pago')
                                    <form action="{{ route('turnos.confirm-payment', $t->tur_id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-confirmar" aria-label="Confirmar pago del turno de {{ $t->tur_nombre }}">Confirmar pago</button>
                                    </form>
                                    <form action="{{ route('turnos.reject-payment', $t->tur_id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-rechazar" aria-label="Rechazar pago del turno de {{ $t->tur_nombre }}">Rechazar pago</button>
                                    </form>
                                    {{-- ✅ BOTÓN WHATSAPP — estado pendiente_pago --}}
                                    <a href="https://wa.me/{{ $waNumero }}?text={{ $waMensaje }}"
                                       target="_blank" rel="noopener noreferrer"
                                       class="btn btn-whatsapp"
                                       aria-label="Confirmar cita vía WhatsApp a {{ $t->tur_nombre }}">
                                        <i class="fab fa-whatsapp" aria-hidden="true"></i> WhatsApp
                                    </a>

                                @elseif($t->tur_estado === 'Pendiente')
                                    <form action="{{ route('turnos.complete', $t->tur_id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-realizado" aria-label="Marcar como realizado el turno de {{ $t->tur_nombre }}">Realizado</button>
                                    </form>
                                    <form action="{{ route('turnos.cancel', $t->tur_id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-cancelar" aria-label="Cancelar el turno de {{ $t->tur_nombre }}">Cancelar</button>
                                    </form>
                                    <button type="button" class="btn btn-reprogramar-visual btn-reprogramar-turno"
                                            data-tur-id="{{ $t->tur_id }}"
                                            data-tur-fecha="{{ $t->tur_fecha }}"
                                            data-tur-hora="{{ $t->tur_hora }}"
                                            aria-label="Reprogramar el turno de {{ $t->tur_nombre }}">
                                        Reprogramar
                                    </button>
                                    {{-- ✅ BOTÓN WHATSAPP — estado Pendiente --}}
                                    <a href="https://wa.me/{{ $waNumero }}?text={{ $waMensaje }}"
                                       target="_blank" rel="noopener noreferrer"
                                       class="btn btn-whatsapp"
                                       aria-label="Confirmar cita vía WhatsApp a {{ $t->tur_nombre }}">
                                        <i class="fab fa-whatsapp" aria-hidden="true"></i> WhatsApp
                                    </a>

                                @elseif($t->tur_estado === 'Realizado')
                                    <span class="estado-label estado-realizado">Realizado</span>
                                    <a href="{{ route('facturas.createFromTurno', ['tur_id' => $t->tur_id]) }}" class="btn btn-facturar" aria-label="Facturar el turno de {{ $t->tur_nombre }}">Facturar turno</a>

                                @elseif($t->tur_estado === 'Cancelado')
                                    <span class="estado-label estado-cancelado">Cancelado</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="tabla-vacia">No hay turnos registrados</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

        </div>

        {{-- Paginación --}}
        @if($turnos->hasPages() || $turnos->total() > 0)
        <div class="paginacion-wrapper" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem; margin-top:1.5rem; padding-top:1rem; border-top:1px solid #e5e7eb;">
            <p style="margin:0; color:#6b7280; font-size:0.875rem;">
                Mostrando
                <strong>{{ $turnos->firstItem() ?? 0 }}</strong>
                a
                <strong>{{ $turnos->lastItem() ?? 0 }}</strong>
                de
                <strong>{{ $turnos->total() }}</strong>
                resultado{{ $turnos->total() !== 1 ? 's' : '' }}
            </p>
            {{ $turnos->links() }}
        </div>
        @endif

    </div>
</main>

<div id="modal-reprogramar-turno"
     class="modal"
     style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; justify-content:center; align-items:center;"
     role="dialog"
     aria-modal="true"
     aria-labelledby="modalReprogramarTitulo">

    <div class="modal-dialog" style="background:white; padding:2rem; border-radius:12px; max-width:500px; width:90%; box-shadow:0 10px 40px rgba(0,0,0,0.3); position:relative;">
        <h2 id="modalReprogramarTitulo" style="margin:0 0 1.5rem 0; color:#1f2937; font-size:1.5rem; border-bottom:3px solid #DC2626; padding-bottom:0.75rem;">
            Reprogramar turno
        </h2>

        <form id="form-reprogramar-turno" method="POST" action="" autocomplete="off">
            @csrf
            @method('PUT')
            <input type="hidden" name="tur_id" id="repro-tur-id">

            <div class="form-group" style="margin-bottom:1.25rem;">
                <label for="repro-tur-fecha" style="display:block; font-weight:600; margin-bottom:0.5rem; color:#374151;">
                    Nueva fecha
                </label>
                <input type="date" 
                       name="tur_fecha" 
                       id="repro-tur-fecha" 
                       required 
                       aria-required="true"
                       style="width:100%; padding:0.75rem; border:2px solid #d1d5db; border-radius:6px; font-size:1rem; transition:border-color 0.2s;"
                       onfocus="this.style.borderColor='#10b981'"
                       onblur="this.style.borderColor='#d1d5db'">
            </div>

            <div class="form-group" style="margin-bottom:1.5rem;">
                <label for="repro-tur-hora" style="display:block; font-weight:600; margin-bottom:0.5rem; color:#374151;">
                    Nueva hora
                </label>
                <input type="time" 
                       name="tur_hora" 
                       id="repro-tur-hora" 
                       required 
                       aria-required="true"
                       style="width:100%; padding:0.75rem; border:2px solid #d1d5db; border-radius:6px; font-size:1rem; transition:border-color 0.2s;"
                       onfocus="this.style.borderColor='#10b981'"
                       onblur="this.style.borderColor='#d1d5db'">
            </div>

            <div class="modal-botones" style="display:flex; gap:1rem; justify-content:flex-end;">
                <button type="button" 
                        id="btn-cerrar-modal-repro" 
                        class="btn btn-cancelar-modal"
                        style="padding:0.75rem 1.5rem; background:#6b7280; color:white; border:none; border-radius:6px; cursor:pointer; font-size:1rem; transition:background 0.2s;"
                        onmouseover="this.style.background='#4b5563'"
                        onmouseout="this.style.background='#6b7280'"
                        aria-label="Cancelar reprogramación y cerrar ventana">
                    Cancelar
                </button>
                <button type="submit" 
                        class="btn btn-guardar-modal"
                        style="padding:0.75rem 1.5rem; background:#DC2626; color:white; border:none; border-radius:6px; cursor:pointer; font-size:1rem; font-weight:600; transition:background 0.2s;"
                        onmouseover="this.style.background='#b91c1c'"
                        onmouseout="this.style.background='#DC2626'"
                        aria-label="Guardar nueva fecha y hora del turno">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('modal-reprogramar-turno');
    const form = document.getElementById('form-reprogramar-turno');
    const btnCerrar = document.getElementById('btn-cerrar-modal-repro');
    let lastTrigger = null;

    function getFocusables() {
        return Array.from(
            modal.querySelectorAll('input, button, select, textarea, a[href]')
        ).filter(el => !el.disabled && el.offsetParent !== null);
    }

    function abrirModal(turId, turFecha, turHora) {
        document.getElementById('repro-tur-id').value = turId;
        document.getElementById('repro-tur-fecha').value = turFecha;
        document.getElementById('repro-tur-hora').value = turHora;
        form.action = `/admin/turnos/${turId}/reprogramar`;
        modal.style.display = 'flex';
        setTimeout(() => {
            const focusables = getFocusables();
            if (focusables.length) focusables[0].focus();
        }, 100);
    }

    function cerrarModal() {
        modal.style.display = 'none';
        if (lastTrigger) lastTrigger.focus();
    }

    document.querySelectorAll('.btn-reprogramar-turno').forEach(btn => {
        btn.addEventListener('click', function () {
            lastTrigger = btn;
            abrirModal(
                btn.getAttribute('data-tur-id'),
                btn.getAttribute('data-tur-fecha'),
                btn.getAttribute('data-tur-hora')
            );
        });
    });

    btnCerrar.addEventListener('click', cerrarModal);

    modal.addEventListener('click', function (e) {
        if (e.target === modal) cerrarModal();
    });

    modal.addEventListener('keydown', function (e) {
        const focusables = getFocusables();

        if (e.key === 'Escape') {
            cerrarModal();
            return;
        }

        if (e.key === 'Tab' && focusables.length > 0) {
            if (e.shiftKey && document.activeElement === focusables[0]) {
                e.preventDefault();
                focusables[focusables.length - 1].focus();
            } else if (!e.shiftKey && document.activeElement === focusables[focusables.length - 1]) {
                e.preventDefault();
                focusables[0].focus();
            }
        }
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('form-filtros');
    const filtros = document.querySelectorAll('.filtro-auto');
    
    filtros.forEach(filtro => {
        filtro.addEventListener('change', function() {
            // Enviar el formulario automáticamente
            form.submit();
        });
    });
});
</script>


@endsection