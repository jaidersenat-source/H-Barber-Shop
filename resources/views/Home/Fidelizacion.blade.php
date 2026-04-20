@extends('layouts.blog')

@section('og_type', 'blog')

@section('content')
    @vite(['resources/css/Home/fidelizacion.css'])

    <!-- Hero Section -->
<section class="page-hero" role="banner" aria-label="Encabezado del programa de fidelización" style="background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('{{ asset('img/11.jpeg') }}'); background-size: cover; background-position: center; background-attachment: fixed;">
        <div class="container">
            <h1 class="section-title">Programa de <span class="gold-text">Fidelización</span></h1>
            <p class="section-subtitle">Tu lealtad tiene recompensa. Acumula cortes y disfruta de beneficios exclusivos.</p>
        </div>
    </section>

    <!-- Tarjeta 3D y Consulta -->
    <section id="fidelizacion-content" class="section" style="padding: 60px 0;" role="region" aria-label="Tarjeta de miembro y consulta de progreso">
        <div class="container">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center;">
                
                <!-- Tarjeta 3D -->
                <div>
                    <h3 style="font-family: 'Playfair Display', serif; font-size: 1.8rem; color: #fff; margin-bottom: 10px; text-align: center;">Tu Tarjeta de Miembro</h3>
                    <p style="font-family: 'Montserrat', sans-serif; font-size: 0.9rem; color: rgba(255,255,255,0.6); text-align: center; margin-bottom: 30px;">Pasa el cursor sobre la tarjeta para ver el reverso</p>
                    
                    <div class="card-3d-container" role="region" aria-label="Tarjeta de miembro interactiva">
                        <div class="card-3d">
                            <!-- Frente de la tarjeta -->
                            <div class="card-front" aria-label="Frente de la tarjeta de miembro">
                                <div class="card-pattern" aria-hidden="true"></div>
                                <div class="card-chip" aria-hidden="true"></div>
                                <div class="card-logo">
                                    H
                                    <span>BARBER SHOP</span>
                                </div>
                                <div class="card-number">
                                    @if($cliente && $fidelizacion)
                                        **** **** **** {{ substr($fidelizacion->tur_cedula, -4) }}
                                    @else
                                        **** **** **** 4589
                                    @endif
                                </div>
                                <div class="card-member-info">
                                    <div class="card-member-label">Miembro</div>
                                    <div class="card-member-name">
                                        @if($cliente && $fidelizacion)
                                            {{ strtoupper($cliente->per_nombre) }}
                                        @else
                                            CLIENTE PREMIUM
                                        @endif
                                    </div>
                                </div>
                                <div class="card-tier">
                                    <div class="card-tier-label">Nivel</div>
                                    <div class="card-tier-value">
                                        @if($cliente && $fidelizacion)
                                            @php
                                                $cortes = $fidelizacion->visitas_acumuladas;
                                                if ($cortes >= 50) {
                                                    $nivel = 'PLATINUM';
                                                } elseif ($cortes >= 30) {
                                                    $nivel = 'GOLD';
                                                } elseif ($cortes >= 15) {
                                                    $nivel = 'SILVER';
                                                } else {
                                                    $nivel = 'BRONZE';
                                                }
                                            @endphp
                                            {{ $nivel }}
                                        @else
                                            GOLD
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Reverso de la tarjeta -->
                            <div class="card-back" aria-label="Reverso de la tarjeta - Programa de recompensas">
                                <div class="card-back-title">Programa de Recompensas</div>
                                <div class="card-back-info">
                                    @if($cliente && $fidelizacion)
                                        Cortes acumulados: {{ $fidelizacion->visitas_acumuladas }}<br>
                                        Cortes para gratis: {{ max(0, $visitasRequeridas - ($fidelizacion->visitas_acumuladas % $visitasRequeridas)) }}<br>
                                        Cédula: {{ $fidelizacion->tur_cedula }}
                                    @else
                                        Cada {{ $visitasRequeridas }} cortes acumulas 1 corte GRATIS.<br>
                                        Presenta tu cedula o numero de celular<br>
                                        en cada visita para acumular.
                                    @endif
                                </div>
                                <div class="card-barcode" aria-hidden="true">
                                    @if($cliente && $fidelizacion)
                                        @php
                                            // Generar barcode visual basado en los dígitos de la cédula
                                            $cedula_digits = str_split(substr($fidelizacion->tur_cedula, -8));
                                            $barcode_heights = [];
                                            foreach ($cedula_digits as $digit) {
                                                $barcode_heights[] = (($digit + 1) * 5) . 'px';
                                            }
                                        @endphp
                                        @foreach($barcode_heights as $height)
                                            <span style="height: {{ $height }};"></span>
                                        @endforeach
                                        <!-- Llenar con alturas adicionales si es necesario -->
                                        @for($i = count($barcode_heights); $i < 20; $i++)
                                            <span style="height: {{ (($i + 1) * 2) % 35 }}px;"></span>
                                        @endfor
                                    @else
                                        <span style="height: 30px;"></span>
                                        <span style="height: 25px;"></span>
                                        <span style="height: 35px;"></span>
                                        <span style="height: 20px;"></span>
                                        <span style="height: 30px;"></span>
                                        <span style="height: 35px;"></span>
                                        <span style="height: 25px;"></span>
                                        <span style="height: 30px;"></span>
                                        <span style="height: 20px;"></span>
                                        <span style="height: 35px;"></span>
                                        <span style="height: 25px;"></span>
                                        <span style="height: 30px;"></span>
                                        <span style="height: 35px;"></span>
                                        <span style="height: 20px;"></span>
                                        <span style="height: 30px;"></span>
                                        <span style="height: 25px;"></span>
                                        <span style="height: 35px;"></span>
                                        <span style="height: 30px;"></span>
                                        <span style="height: 20px;"></span>
                                        <span style="height: 25px;"></span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Formulario de Consulta -->
                <div>
                    <div class="consulta-form" role="region" aria-label="Formulario de consulta de progreso">
                        <h3 id="consulta-heading">Consulta tu Progreso</h3>
                        <p>Ingresa tu número de cédula o celular para ver cuántos cortes llevas acumulados.</p>
                        
                        <div class="form-tabs" role="tablist" aria-label="Tipo de identificación">
                            <button class="form-tab active" data-tab="cedula" role="tab" aria-selected="true" aria-controls="cedulaInput" id="tab-cedula">Cédula</button>
                            <button class="form-tab" data-tab="celular" role="tab" aria-selected="false" aria-controls="celularInput" id="tab-celular">Celular</button>
                        </div>

                        <form id="consultaForm" method="POST" action="{{ route('fidelizacion.consultar') }}" aria-labelledby="consulta-heading">
                            @csrf
                            <div class="input-group" id="cedulaInput" role="tabpanel" aria-labelledby="tab-cedula">
                                <label for="cedula">Número de Cédula</label>
                                <input type="text" id="cedula" name="identificacion" placeholder="Ej: 1234567890" maxlength="12" aria-required="true" autocomplete="off">
                                <span id="cedula-error" class="field-error" style="display:none;"></span>
                            </div>

                            <div class="input-group" id="celularInput" style="display: none;" role="tabpanel" aria-labelledby="tab-celular">
                                <label for="celular">Número de Celular</label>
                                <input type="tel" id="celular" name="identificacion" placeholder="Ej: 3001234567" maxlength="10" disabled aria-required="true" autocomplete="off">
                                <span id="celular-error" class="field-error" style="display:none;"></span>
                            </div>

                            <button type="submit" class="btn-consultar" id="btnConsultar" aria-label="Consultar mis cortes acumulados">
                                <span id="btnConsultarText">Consultar Mis Cortes</span>
                            </button>
                        </form>
                    </div>

                    <!-- Resultado de la consulta -->
                    @php
                        $cliente = $cliente ?? null;
                        $fidelizacion = $fidelizacion ?? null;
                        $identificacion = $identificacion ?? null;
                        $visitasRequeridas = $visitasRequeridas ?? 7;
                    @endphp

                    @if($cliente && $fidelizacion)
                    <div class="resultado-consulta visible" role="region" aria-live="polite" aria-label="Resultado de la consulta de fidelización">
                        <div class="resultado-header">
                            <h4>{{ $cliente->per_nombre }} {{ $cliente->per_apellido }}</h4>
                            <span>Miembro desde {{ \Carbon\Carbon::parse($fidelizacion->created_at)->format('F Y') }}</span>
                        </div>

                        <div class="progreso-container">
                            <div class="progreso-info">
                                <span>Cortes acumulados: <strong>{{ $fidelizacion->visitas_acumuladas }} de {{ $visitasRequeridas }}</strong></span>
                                <span><strong>{{ max(0, $visitasRequeridas - ($fidelizacion->visitas_acumuladas % $visitasRequeridas)) }}</strong> para corte gratis</span>
                            </div>
                            <div class="progreso-bar" role="progressbar" aria-valuenow="{{ ($fidelizacion->visitas_acumuladas % $visitasRequeridas) }}" aria-valuemin="0" aria-valuemax="{{ $visitasRequeridas }}" aria-label="Progreso de cortes acumulados">
                                <div class="progreso-fill" style="width: {{ (($fidelizacion->visitas_acumuladas % $visitasRequeridas) / $visitasRequeridas) * 100 }}%;"></div>
                            </div>
                        </div>

                        <div class="cortes-visual">
                            @php
                                $cortesCompletados = $fidelizacion->visitas_acumuladas % $visitasRequeridas;
                                $cortesPendientes = $visitasRequeridas - $cortesCompletados;
                            @endphp
                            
                            @for($i = 1; $i <= $cortesCompletados; $i++)
                                <div class="corte-icon completado" aria-label="Corte {{ $i }} completado">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
                                </div>
                            @endfor

                            @for($i = 1; $i <= $cortesPendientes - 1; $i++)
                                <div class="corte-icon pendiente" aria-label="Corte {{ $cortesCompletados + $i }} pendiente">{{ $cortesCompletados + $i }}</div>
                            @endfor

                            <div class="corte-icon gratis" aria-label="Corte gratis al completar">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M20 12V8H6a2 2 0 0 1-2-2c0-1.1.9-2 2-2h12v4"/><path d="M4 6v12c0 1.1.9 2 2 2h14v-4"/><path d="M18 12a2 2 0 0 0-2 2c0 1.1.9 2 2 2h4v-4h-4z"/></svg>
                            </div>
                        </div>

                        <div class="resultado-mensaje">
                            <p>Te faltan solo</p>
                            <span>{{ max(0, $visitasRequeridas - ($fidelizacion->visitas_acumuladas % $visitasRequeridas)) }}</span>
                            <p>para tu corte GRATIS</p>
                        </div>
                    </div>
                    @elseif($cliente)
                    <div class="resultado-consulta visible" style="background: rgba(220, 38, 38, 0.2); border: 2px solid #DC2626; border-radius: 12px; padding: 20px; margin-top: 30px; text-align: center;">
                        <p style="color: #fff; margin-bottom: 15px;"><i class="fas fa-exclamation-circle" style="margin-right: 10px;"></i>No estás registrado en nuestro programa de fidelización</p>
                        <p style="color: rgba(255,255,255,0.8); margin-bottom: 20px;">Visítanos o agenda tu cita para ser miembro y comienza a acumular cortes gratis</p>
                        <a href="{{ route('agendar') }}" style="display: inline-block; padding: 12px 30px; background: linear-gradient(135deg, #DC2626 0%, #991B1B 100%); color: #fff; text-decoration: none; border-radius: 8px; font-weight: 600; transition: all 0.3s;">
                            <i class="fas fa-calendar-check" style="margin-right: 8px;"></i>Agenda tu Cita
                        </a>
                    </div>
                    @elseif($identificacion)
                    <div class="resultado-consulta visible" style="background: rgba(220, 38, 38, 0.2); border: 2px solid #DC2626; border-radius: 12px; padding: 20px; margin-top: 30px; text-align: center;">
                        <p style="color: #fff; margin-bottom: 15px;"><i class="fas fa-exclamation-circle" style="margin-right: 10px;"></i>No estás registrado en nuestro programa de fidelización</p>
                        <p style="color: rgba(255,255,255,0.8); margin-bottom: 20px;">Visítanos o agenda tu cita para ser miembro y comienza a acumular cortes gratis</p>
                        <a href="{{ route('agendar') }}" style="display: inline-block; padding: 12px 30px; background: linear-gradient(135deg, #DC2626 0%, #991B1B 100%); color: #fff; text-decoration: none; border-radius: 8px; font-weight: 600; transition: all 0.3s;">
                            <i class="fas fa-calendar-check" style="margin-right: 8px;"></i>Agenda tu Cita
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Como funciona -->
    <section class="section como-funciona" role="region" aria-label="Cómo funciona el programa">
        <div class="container">
            <h2 class="section-title" style="text-align: center;">Cómo <span class="gold-text">Funciona</span></h2>
            
            <div class="pasos-grid" role="list" aria-label="Pasos del programa de fidelización">
                <div class="paso-card" role="listitem">
                    <div class="paso-numero" aria-hidden="true">1</div>
                    <h4>Regístrate</h4>
                    <p>En tu primera visita, proporciónanos tu cédula o número de celular para crear tu cuenta de fidelización.</p>
                </div>
                <div class="paso-card" role="listitem">
                    <div class="paso-numero" aria-hidden="true">2</div>
                    <h4>Acumula Cortes</h4>
                    <p>Cada vez que te realices un corte, se registrará automáticamente en tu cuenta. Solo di tu número.</p>
                </div>
                <div class="paso-card" role="listitem">
                    <div class="paso-numero" aria-hidden="true">3</div>
                    <h4>Consulta tu Progreso</h4>
                    <p>Usa esta página para ver cuántos cortes llevas y cuántos te faltan para tu recompensa.</p>
                </div>
                <div class="paso-card" role="listitem">
                    <div class="paso-numero" aria-hidden="true">4</div>
                    <h4>Disfruta tu Premio</h4>
                    <p>Al completar 10 cortes, tu siguiente corte es completamente GRATIS. El contador se reinicia automáticamente.</p>
                </div>
            </div>
        </div>
    </section>

   

    <!-- CTA -->
    <section class="section" style="padding: 80px 0; text-align: center;" role="region" aria-label="Llamada a la acción">
        <div class="container">
            <h2 class="section-title">¿Aún no eres <span class="gold-text">Miembro?</span></h2>
            <p style="font-family: 'Montserrat', sans-serif; font-size: 1.1rem; color: rgba(255,255,255,0.7); max-width: 600px; margin: 0 auto 30px;">
                Visítanos y regístrate automáticamente en tu primer corte. Es gratis y los beneficios comienzan de inmediato.
            </p>
           <a href="{{ route('agendar') }}" class="btn-cta-fidelizacion" aria-label="Ir a la página para agendar tu cita">Agenda tu Cita</a>
        </div>
    </section>

    <script>

        // Toggle entre tabs de cedula y celular (con verificación de existencia)
        const tabs = document.querySelectorAll('.form-tab');
        const cedulaInput = document.getElementById('cedulaInput');
        const celularInput = document.getElementById('celularInput');
        const cedulaField = document.getElementById('cedula');
        const celularField = document.getElementById('celular');

        if (tabs.length && cedulaInput && celularInput && cedulaField && celularField) {
            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    tabs.forEach(t => {
                        t.classList.remove('active');
                        t.setAttribute('aria-selected', 'false');
                    });
                    tab.classList.add('active');
                    tab.setAttribute('aria-selected', 'true');

                    if (tab.dataset.tab === 'cedula') {
                        // Transferir valor de celular a cedula si existe
                        if (celularField.value) {
                            cedulaField.value = celularField.value;
                            celularField.value = '';
                        }
                        cedulaInput.style.display = 'block';
                        celularInput.style.display = 'none';
                        cedulaField.disabled = false;
                        celularField.disabled = true;
                    } else {
                        // Transferir valor de cedula a celular si existe
                        if (cedulaField.value) {
                            celularField.value = cedulaField.value;
                            cedulaField.value = '';
                        }
                        cedulaInput.style.display = 'none';
                        celularInput.style.display = 'block';
                        cedulaField.disabled = true;
                        celularField.disabled = false;
                    }
                });
            });
        }

        // Validaciones en tiempo real e inline (solo dígitos) y validación en submit
        const consultaForm = document.getElementById('consultaForm');
        const cedulaError = document.getElementById('cedula-error');
        const celularError = document.getElementById('celular-error');

        function showFieldError(el, msg) {
            if (!el) return;
            el.textContent = msg;
            el.style.display = 'block';
            const input = el.previousElementSibling && (el.previousElementSibling.tagName === 'INPUT' || el.previousElementSibling.tagName === 'TEXTAREA') ? el.previousElementSibling : null;
            if (input) input.classList.add('input-error');
        }

        function clearFieldError(el) {
            if (!el) return;
            el.textContent = '';
            el.style.display = 'none';
            const input = el.previousElementSibling && (el.previousElementSibling.tagName === 'INPUT' || el.previousElementSibling.tagName === 'TEXTAREA') ? el.previousElementSibling : null;
            if (input) input.classList.remove('input-error');
        }

        if (consultaForm && cedulaField && celularField) {
            // Sanitize inputs: allow only digits and show brief inline message when non-digits typed
            cedulaField.addEventListener('input', function() {
                const raw = this.value;
                const digits = raw.replace(/\D+/g, '');
                if (raw !== digits) {
                    this.value = digits;
                    showFieldError(cedulaError, 'Solo se permiten números en la cédula.');
                    setTimeout(()=> clearFieldError(cedulaError), 1600);
                } else {
                    clearFieldError(cedulaError);
                }
            });

            celularField.addEventListener('input', function() {
                const raw = this.value;
                const digits = raw.replace(/\D+/g, '');
                if (raw !== digits) {
                    this.value = digits;
                    showFieldError(celularError, 'Solo se permiten números en el celular.');
                    setTimeout(()=> clearFieldError(celularError), 1600);
                } else {
                    clearFieldError(celularError);
                }
            });

            consultaForm.addEventListener('submit', function(e) {
                const activeTab = document.querySelector('.form-tab.active');
                if (!activeTab) return;
                const tabType = activeTab.dataset.tab;

                if (tabType === 'cedula') {
                    const v = cedulaField.value.trim();
                    if (!/^\d{5,12}$/.test(v)) {
                        e.preventDefault();
                        showFieldError(cedulaError, 'Cédula inválida: ingresa entre 5 y 12 dígitos.');
                        cedulaField.focus();
                        return false;
                    }
                } else {
                    const v = celularField.value.trim();
                    if (!/^3\d{9}$/.test(v)) {
                        e.preventDefault();
                        showFieldError(celularError, 'Celular inválido: debe comenzar con 3 y tener 10 dígitos.');
                        celularField.focus();
                        return false;
                    }
                }
            });
        }

       
    </script>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('consultaForm');
    const btn = document.getElementById('btnConsultar');
    const btnText = document.getElementById('btnConsultarText');

    if (form && btn) {
        form.addEventListener('submit', function() {
            btn.disabled = true;
            btn.style.opacity = '0.7';
            btn.style.cursor = 'not-allowed';
            btnText.textContent = 'Consultando...';
        });
    }
});

const resultado = document.querySelector('.resultado-consulta.visible');
if (resultado) {
    setTimeout(() => {
        resultado.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }, 300);
}
</script>
@endpush