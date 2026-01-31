@extends('admin.layout')

@section('title', 'Dashboard CRM')

@section('content')
@vite(['resources/css/Admin/dashboard.css'])
@auth

<div style="display:flex;justify-content:flex-end;align-items:center;gap:18px;margin-bottom:18px;">
    <button id="notif-bell" aria-label="Ver notificaciones" style="background:none;border:none;color:#333;font-size:1.5em;cursor:pointer;outline:none;position:relative;">
        🔔
        @php $unread = auth()->user()->unreadNotifications->count(); @endphp
        @if($unread > 0)
            <span style="background:red;color:white;padding:2px 6px;border-radius:50%;font-size:12px;vertical-align:top;position:absolute;top:-8px;right:-12px;">{{ $unread }}</span>
        @endif
    </button>
    <div style="background:white;color:black;min-width:260px;position:absolute;right:10px;display:none;z-index:1000;padding:10px;border-radius:6px;" id="notif-dropdown">
        <strong>Notificaciones</strong>
        <ul style="list-style:none;padding:0;margin:8px 0 0 0;max-height:300px;overflow:auto;">
            @foreach(auth()->user()->unreadNotifications as $n)
                <li style="border-bottom:1px solid #eee;padding:6px 0;">
                    {{ $n->data['message'] ?? 'Notificación' }}
                    <form method="POST" action="{{ url('admin/notifications/'.$n->id.'/leer') }}" style="display:inline-block;margin-left:8px;">
                        @csrf
                        <button class="btn" style="background:#d4af37;border:none;padding:4px 8px;border-radius:4px;">Marcar leída</button>
                    </form>
                </li>
            @endforeach
            @if(auth()->user()->unreadNotifications->isEmpty())
                <li>No hay notificaciones</li>
            @endif
        </ul>
    </div>
   
</div>
@endauth
<div class="dashboard-container">
    <div class="sr-only" aria-live="polite">Bienvenido al panel principal. Aquí puedes consultar los datos clave de tu barbería.</div>
    <h1 class="dashboard-title" tabindex="0">Dashboard CRM</h1>
    <section class="stats-section" aria-label="Resumen de datos">
        <div class="stat-card stat-card--clientes" role="region" aria-label="Clientes totales">
            <span class="stat-label">Clientes Totales</span>
            <span class="stat-value stat-value--clientes" aria-live="polite">{{ $clientesTotales }}</span>
        </div>
        <div class="stat-card stat-card--pendientes" role="region" aria-label="Turnos pendientes">
            <span class="stat-label">Turnos Pendientes</span>
            <span class="stat-value stat-value--pendientes" aria-live="polite">{{ $turnosPendientes }}</span>
        </div>
        <div class="stat-card stat-card--realizados" role="region" aria-label="Turnos realizados">
            <span class="stat-label">Turnos Realizados</span>
            <span class="stat-value stat-value--realizados" aria-live="polite">{{ $turnosRealizados }}</span>
        </div>
        <div class="stat-card stat-card--ingresos" role="region" aria-label="Ingresos del mes">
            <span class="stat-label">Ingresos del mes</span>
            <span class="stat-value stat-value--ingresos" aria-live="polite"><span class="sr-only">Pesos colombianos </span>COP ${{ number_format($ingresosMes, 0) }}</span>
        </div>
    </section>
    <div style="margin-top:40px;">
        <div class="dashboard-section">
            <h3 class="section-title">Servicios más vendidos</h3>
            @if(count($serviciosTop) == 0)
                <p class="section-empty">No hay datos aún.</p>
            @else
                <ul class="sr-only">
                    @foreach($serviciosTop as $s)
                        <li>Servicio más vendido: {{ $s->serv_nombre }}, ventas: {{ $s->total }}</li>
                    @endforeach
                </ul>
                <table class="dashboard-table" aria-label="Servicios más vendidos" aria-hidden="true">
                    <thead>
                        <tr>
                            <th>Servicio</th>
                            <th>Ventas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($serviciosTop as $s)
                        <tr>
                            <td>{{ $s->serv_nombre }}</td>
                            <td>{{ $s->total }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        <div class="dashboard-section">
            <h3 class="section-title">Clientes frecuentes</h3>
            @if(count($clientesFrecuentes) == 0)
                <p class="section-empty">No hay datos aún.</p>
            @else
                <ul class="sr-only">
                    @foreach($clientesFrecuentes as $c)
                        <li>Cliente frecuente: {{ $c->tur_nombre }}, visitas: {{ $c->visitas }}</li>
                    @endforeach
                </ul>
                <table class="dashboard-table" aria-label="Clientes frecuentes" aria-hidden="true">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Visitas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clientesFrecuentes as $c)
                        <tr>
                            <td>{{ $c->tur_nombre }}</td>
                            <td>{{ $c->visitas }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
<script>
    (function(){
        const bell = document.getElementById('notif-bell');
        const dropdown = document.getElementById('notif-dropdown');
        if (bell && dropdown) {
            bell.addEventListener('click', function(e){
                e.preventDefault();
                dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
            });
            document.addEventListener('click', function(e){
                if (!bell.contains(e.target) && !dropdown.contains(e.target)) {
                    dropdown.style.display = 'none';
                }
            });
        }
    })();
</script>
<script>
// Navegación accesible mejorada para dashboard, compatible con lectores de pantalla
document.addEventListener('DOMContentLoaded', function() {
    const modulo = document.querySelector('.dashboard-container');
    if (!modulo) return;
    const focusableSelectors = 'a, button, input, select, textarea, [tabindex]:not([tabindex="-1"])';
    let focusables = Array.from(modulo.querySelectorAll(focusableSelectors)).filter(el => !el.disabled && el.offsetParent !== null);
    if (focusables.length === 0) return;

    // Forzar tabindex=-1 si el primer elemento no es focusable
    if (!focusables[0].hasAttribute('tabindex')) {
        focusables[0].setAttribute('tabindex', '-1');
    }
    // Foco inicial robusto
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
            // Buscar menú accesible
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
