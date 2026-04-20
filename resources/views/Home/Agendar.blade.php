@extends('layouts.blog')

@section('og_type', 'blog')

@section('content')
    @vite('resources/css/Home/Agendar.css')

    <!-- Main Content -->
    <main class="main-booking">
        <div class="booking-container">

            <!-- Progress Steps -->
            <div class="progress-steps">
                <div class="step active" data-step="1">
                    <div class="step-number">1</div>
                    <span class="step-label">Barbero</span>
                </div>
                <div class="step-line"></div>
                <div class="step" data-step="2">
                    <div class="step-number">2</div>
                    <span class="step-label">Servicio</span>
                </div>
                <div class="step-line"></div>
                <div class="step" data-step="3">
                    <div class="step-number">3</div>
                    <span class="step-label">Fecha</span>
                </div>
                <div class="step-line"></div>
                <div class="step" data-step="4">
                    <div class="step-number">4</div>
                    <span class="step-label">Pago</span>
                </div>
                <div class="step-line"></div>
                <div class="step" data-step="5">
                    <div class="step-number">5</div>
                    <span class="step-label">Confirmar</span>
                </div>
            </div>

            <!-- ══════════════════════════════════════
                 STEP 1: SELECCIONAR BARBERO
            ══════════════════════════════════════ -->
            <section class="booking-step active" id="step-1" role="region" aria-label="Paso 1: Seleccionar barbero">
                <h2 class="step-title">Elige tu Barbero</h2>
                <p class="step-subtitle">Selecciona al profesional que te atenderá</p>

                <div class="selection-grid" role="radiogroup" aria-label="Barberos disponibles">

                    <!-- Cualquier barbero -->
                    <div class="selection-card any-barber-option"
                         data-barber="any"
                         data-name="Cualquier Barbero"
                         role="radio" aria-checked="false" tabindex="0"
                         aria-label="Cualquier Barbero - Disponibilidad Inmediata">
                        <div class="barber-avatar" aria-hidden="true">?</div>
                        <h3 class="barber-name">Cualquier Barbero</h3>
                        <p class="barber-role">Disponibilidad Inmediata</p>
                        <p class="barber-specialty">Te asignaremos al barbero disponible más pronto</p>
                    </div>

                    @forelse($barberos as $barbero)
                        <div class="selection-card {{ !$barbero->has_availability ? 'barber-no-availability' : '' }}"
                             data-barber="{{ $barbero->persede_id }}"
                             data-name="{{ $barbero->persona->per_nombre }} {{ $barbero->persona->per_apellido }}"
                             data-has-availability="{{ $barbero->has_availability ? 'true' : 'false' }}"
                             role="radio" aria-checked="false" tabindex="0"
                             aria-label="{{ $barbero->persona->per_nombre }} {{ $barbero->persona->per_apellido }} - {{ $barbero->cargo ?? 'Barbero Profesional' }}{{ !$barbero->has_availability ? ' - Sin disponibilidad' : '' }}">
                            <div class="barber-avatar" aria-hidden="true">
                                @if($barbero->persona && $barbero->persona->usuario && $barbero->persona->usuario->foto_perfil)
                                    <img src="{{ asset('storage/' . $barbero->persona->usuario->foto_perfil) }}"
                                         alt="{{ $barbero->persona->per_nombre }}">
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24"
                                         fill="none" stroke="#d4af37" stroke-width="1.5" aria-hidden="true">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                        <circle cx="12" cy="7" r="4"/>
                                    </svg>
                                @endif
                            </div>
                            <h3 class="barber-name">{{ $barbero->persona->per_nombre }} {{ $barbero->persona->per_apellido }}</h3>
                            <p class="barber-role">{{ $barbero->cargo ?? 'Barbero Profesional' }}</p>
                            <p class="barber-specialty">{{ $barbero->especialidad ?? 'Experto en cortes y estilismo' }}</p>
                            @if(!$barbero->has_availability)
                                <span class="badge-sin-disponibilidad" aria-hidden="true">Sin disponibilidad</span>
                            @endif
                            <div class="barber-rating" aria-label="Calificación {{ $barbero->rating ?? '4.8' }} de 5 estrellas">
                                <span aria-hidden="true">&#9733;&#9733;&#9733;&#9733;&#9733;</span>
                                <span class="rating-value">{{ $barbero->rating ?? '4.8' }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="no-barbers-message">
                            <p>No hay barberos disponibles en este momento.</p>
                            <p>Por favor, intenta más tarde.</p>
                        </div>
                    @endforelse

                </div>

                <div id="barber-availability-message" role="alert" aria-live="polite" class="barber-availability-message"></div>
                <div id="booking-feedback" role="alert" aria-live="assertive" class="booking-feedback" style="display:none;margin-top:1rem;"></div>
                <div class="booking-navigation" role="group" aria-label="Navegación del paso 1">
                    <div></div>
                    <button class="btn-next" id="btn-next-1" disabled aria-disabled="true"
                            aria-label="Continuar al paso 2: Seleccionar servicio">
                        Continuar
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
            </section>

            <!-- ══════════════════════════════════════
                 STEP 2: SELECCIONAR SERVICIO
            ══════════════════════════════════════ -->
            <section class="booking-step" id="step-2" role="region" aria-label="Paso 2: Seleccionar servicio">
                <h2 class="step-title">Selecciona tu Servicio</h2>
                <p class="step-subtitle">Elige el servicio que deseas</p>

                <div class="category-filter" role="group" aria-label="Filtros de categoría">
                    <button class="category-btn active" data-category="all">Todos</button>
                    @php
                        $categorias = $servicios->pluck('serv_categoria')->filter()->unique();
                    @endphp
                    @foreach($categorias as $categoria)
                        <button class="category-btn" data-category="{{ strtolower($categoria) }}">
                            {{ ucfirst($categoria) }}
                        </button>
                    @endforeach
                </div>

                <div class="selection-grid" id="services-grid" role="radiogroup" aria-label="Servicios disponibles">
                    @forelse($servicios as $servicio)
                        <div class="selection-card"
                             data-service="{{ $servicio->serv_id }}"
                             data-name="{{ $servicio->serv_nombre }}"
                             data-price="{{ $servicio->serv_precio }}"
                             data-duration="{{ $servicio->serv_duracion }}"
                             data-category="{{ strtolower($servicio->serv_categoria ?? 'general') }}"
                             data-type="{{ $servicio->serv_categoria === 'combos' ? 'combo' : 'servicio' }}"
                             role="radio" aria-checked="false" tabindex="0"
                             aria-label="{{ $servicio->serv_nombre }} - ${{ number_format($servicio->serv_precio, 0, ',', '.') }} - {{ $servicio->serv_duracion }} minutos">

                            <div class="service-icon">
                                @if($servicio->serv_categoria === 'combos')
                                    <div class="combo-badge">COMBO</div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="#d4af37" stroke-width="2" aria-hidden="true">
                                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                                        <circle cx="12" cy="8" r="2"/>
                                        <path d="M12 14v4"/>
                                    </svg>
                                @elseif($servicio->serv_icono)
                                    <img src="{{ asset($servicio->serv_icono) }}" alt="{{ $servicio->serv_nombre }}">
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="#d4af37" stroke-width="2" aria-hidden="true">
                                        <circle cx="6" cy="6" r="3"/><circle cx="6" cy="18" r="3"/>
                                        <line x1="20" y1="4" x2="8.12" y2="15.88"/>
                                        <line x1="14.47" y1="14.48" x2="20" y2="20"/>
                                        <line x1="8.12" y1="8.12" x2="12" y2="12"/>
                                    </svg>
                                @endif
                            </div>

                            <h3 class="service-name">{{ $servicio->serv_nombre }}</h3>
                            <p class="service-description">{{ $servicio->serv_descripcion ?? 'Servicio profesional de calidad' }}</p>

                            @if($servicio->serv_categoria === 'combos' && !empty($servicio->serv_servicios_incluidos))
                                <div class="combo-services">
                                    <small>Incluye: {{ $servicio->serviciosIncluidos()->pluck('serv_nombre')->join(', ') }}</small>
                                </div>
                            @endif

                            <div class="service-details">
                                <span class="service-price {{ $servicio->serv_categoria === 'combos' ? 'combo-price' : '' }}">
                                    ${{ number_format($servicio->serv_precio, 0, ',', '.') }}
                                </span>
                                <span class="service-duration">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
                                    </svg>
                                    {{ $servicio->serv_duracion }} min
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="no-services-message">
                            <p>No hay servicios disponibles en este momento.</p>
                            <p>Por favor, contacta directamente a la barbería.</p>
                        </div>
                    @endforelse
                </div>

                <div class="booking-navigation" role="group" aria-label="Navegación del paso 2">
                    <button class="btn-back" id="btn-back-2" aria-label="Volver al paso 1: Seleccionar barbero">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="M19 12H5M12 19l-7-7 7-7"/>
                        </svg>
                        Atrás
                    </button>
                    <button class="btn-next" id="btn-next-2" disabled aria-disabled="true"
                            aria-label="Continuar al paso 3: Seleccionar fecha">
                        Continuar
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
            </section>

            <!-- ══════════════════════════════════════
                 STEP 3: FECHA Y HORA
            ══════════════════════════════════════ -->
            <section class="booking-step" id="step-3" role="region" aria-label="Paso 3: Seleccionar fecha y hora">
                <h2 class="step-title">Elige Fecha y Hora</h2>
                <p class="step-subtitle">Selecciona el momento que mejor te convenga</p>

                <div class="datetime-container">

                    <!-- Calendario -->
                    <div class="datetime-section">
                        <h3>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                <line x1="16" y1="2" x2="16" y2="6"/>
                                <line x1="8" y1="2" x2="8" y2="6"/>
                                <line x1="3" y1="10" x2="21" y2="10"/>
                            </svg>
                            Fecha
                        </h3>

                        <div class="calendar-header">
                            <span class="calendar-month" id="calendar-month"
                                  aria-live="polite" role="status">{{ now()->translatedFormat('F Y') }}</span>
                            <div class="calendar-nav" role="group" aria-label="Navegación del calendario">
                                <button id="prev-month" aria-label="Mes anterior">&lt;</button>
                                <button id="next-month" aria-label="Mes siguiente">&gt;</button>
                            </div>
                        </div>

                        <div class="calendar-weekdays" role="row" aria-label="Días de la semana">
                            <span class="weekday" role="columnheader" abbr="Domingo">Dom</span>
                            <span class="weekday" role="columnheader" abbr="Lunes">Lun</span>
                            <span class="weekday" role="columnheader" abbr="Martes">Mar</span>
                            <span class="weekday" role="columnheader" abbr="Miércoles">Mie</span>
                            <span class="weekday" role="columnheader" abbr="Jueves">Jue</span>
                            <span class="weekday" role="columnheader" abbr="Viernes">Vie</span>
                            <span class="weekday" role="columnheader" abbr="Sábado">Sab</span>
                        </div>

                        <div class="calendar-days" id="calendar-days" role="grid" aria-label="Días disponibles">
                            {{-- generado dinámicamente por JS --}}
                        </div>
                    </div>

                    <!-- Horarios -->
                    <div class="datetime-section">
                        <h3>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
                            </svg>
                            Hora
                        </h3>

                        <div class="time-slots" id="time-slots" role="radiogroup" aria-label="Horarios disponibles">
                            <div class="no-barber-selected">
                                <p>Primero selecciona un barbero para ver horarios disponibles</p>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="booking-navigation" role="group" aria-label="Navegación del paso 3">
                    <button class="btn-back" id="btn-back-3" aria-label="Volver al paso 2: Seleccionar servicio">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="M19 12H5M12 19l-7-7 7-7"/>
                        </svg>
                        Atrás
                    </button>
                    <button class="btn-next" id="btn-next-3" disabled aria-disabled="true"
                            aria-label="Continuar al paso 4: Pago">
                        Continuar
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
            </section>

            <!-- ══════════════════════════════════════
                 STEP 4: PAGO (OPCIONAL)
            ══════════════════════════════════════ -->
            <section class="booking-step" id="step-4" role="region" aria-label="Paso 4: Anticipo opcional">
                <h2 class="step-title">Anticipo (Opcional)</h2>
                <p class="step-subtitle">Asegura tu cita con un anticipo de $10.000</p>

                <div class="payment-options" role="group" aria-label="Opciones de pago">

                    <div class="payment-choice" role="radiogroup" aria-label="Seleccionar opción de pago">
                        <label class="payment-option">
                            <input type="radio" name="payment-option" value="no-payment" checked>
                            <div class="option-card">
                                <h3>Continuar sin anticipo</h3>
                                <p>Agenda tu cita normalmente</p>
                            </div>
                        </label>
                        <label class="payment-option">
                            <input type="radio" name="payment-option" value="with-payment">
                            <div class="option-card">
                                <h3>Pagar anticipo $10.000</h3>
                                <p>Asegura tu cita con un anticipo</p>
                            </div>
                        </label>
                    </div>

                    <!-- ── Sección QR ── -->
                    <div class="qr-payment-section" id="qr-payment">
                        <h3>Opciones de Pago</h3>

                        {{-- Botones selector de método --}}
                        <div class="qr-method-btns" role="group" aria-label="Selecciona método de pago">
                            <button type="button" class="qr-method-btn qr-method-btn--nequi" data-method="nequi"
                                    aria-pressed="false" aria-label="Pagar con Nequi">
                                📜 Nequi
                            </button>
                            <button type="button" class="qr-method-btn qr-method-btn--daviplata" data-method="daviplata"
                                    aria-pressed="false" aria-label="Pagar con DaviPlata">
                                🏦 DaviPlata
                            </button>
                            <button type="button" class="qr-method-btn qr-method-btn--bancolombia" data-method="bancolombia"
                                    aria-pressed="false" aria-label="Pagar con Bancolombia">
                                🏦 Bancolombia
                            </button>
                        </div>

                        {{-- Panel Nequi --}}
                        <div class="qr-panel" id="panel-nequi" style="display:none;">
                            <div class="qr-option qr-option--nequi">
                                <h4 class="nequi-title">Nequi</h4>
                                <div class="qr-placeholder">
                                    <div class="qr-code nequi-payment-box">
                                        @if(file_exists(public_path('img/qr/nequi-qr.png')))
                                            <div class="real-qr-section">
                                                <img id="nequi-qr"
                                                     src="{{ asset('img/qr/nequi-qr.png') }}?{{ time() }}"
                                                     alt="QR Nequi Real"
                                                     class="qr-image qr-image--nequi">
                                                <p class="qr-official-label qr-official-label--nequi">✅ QR Oficial Nequi</p>
                                                <p class="qr-amount qr-amount--nequi"><strong>$10,000 COP</strong></p>
                                                <small class="qr-instruction">🎯 Escanea este QR con tu app Nequi</small>
                                            </div>
                                        @endif
                                        <div class="payment-steps nequi-steps">
                                            <p class="steps-title nequi-steps-title">
                                                @if(file_exists(public_path('img/qr/nequi-qr.png')))
                                                    📲 ¿No puedes escanear? Paga manualmente:
                                                @else
                                                    📱 Pasos para pagar con Nequi:
                                                @endif
                                            </p>
                                            <ol class="steps-list">
                                                <li>Abre tu app <strong class="nequi-highlight">Nequi</strong></li>
                                                <li>Toca <strong>"Enviar plata"</strong> o <strong>"Transferir"</strong></li>
                                                <li>Ingresa este número:</li>
                                            </ol>
                                            <div data-copy-phone="true" class="phone-copy-box nequi-phone">
                                                <span class="phone-number">311 810 4544</span>
                                                <br><small>📋 Toca para copiar</small>
                                            </div>
                                            <ol class="steps-list" start="4">
                                                <li>Monto: <strong class="nequi-highlight">$10,000</strong></li>
                                                <li>En mensaje escribe: <strong class="nequi-highlight">Anticipo + tu nombre</strong></li>
                                                <li>Confirma el envío ✓</li>
                                            </ol>
                                        </div>
                                        <div class="payment-confirm-note">
                                            <small>✅ Una vez enviado, ingresa el número de comprobante abajo</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Panel DaviPlata --}}
                        <div class="qr-panel" id="panel-daviplata" style="display:none;">
                            <div class="qr-option qr-option--daviplata">
                                <h4 class="daviplata-title">DaviPlata</h4>
                                <div class="qr-placeholder">
                                    <div class="qr-code daviplata-payment-box">
                                        @if(file_exists(public_path('img/qr/daviplata-qr.png')))
                                            <div class="real-qr-section">
                                                <img id="daviplata-qr"
                                                     src="{{ asset('img/qr/daviplata-qr.png') }}?{{ time() }}"
                                                     alt="QR DaviPlata Real"
                                                     class="qr-image qr-image--daviplata">
                                                <p class="qr-official-label qr-official-label--daviplata">✅ QR Oficial DaviPlata</p>
                                                <p class="qr-amount qr-amount--daviplata"><strong>$10,000 COP</strong></p>
                                                <small class="qr-instruction">🎯 Escanea este QR con tu app DaviPlata</small>
                                            </div>
                                        @endif
                                        <div class="payment-steps daviplata-steps">
                                            <p class="steps-title daviplata-steps-title">
                                                @if(file_exists(public_path('img/qr/daviplata-qr.png')))
                                                    📲 ¿No puedes escanear? Paga manualmente:
                                                @else
                                                    📱 Pasos para pagar con DaviPlata:
                                                @endif
                                            </p>
                                            <ol class="steps-list">
                                                <li>Abre tu app <strong class="daviplata-highlight">DaviPlata</strong></li>
                                                <li>Toca <strong>"Enviar plata"</strong></li>
                                                <li>Ingresa este número:</li>
                                            </ol>
                                            <div data-copy-phone="true" class="phone-copy-box daviplata-phone">
                                                <span class="phone-number">311 810 4544</span>
                                                <br><small>📋 Toca para copiar</small>
                                            </div>
                                            <ol class="steps-list" start="4">
                                                <li>Monto: <strong class="daviplata-highlight">$10,000</strong></li>
                                                <li>En mensaje escribe: <strong class="daviplata-highlight">Anticipo + tu nombre</strong></li>
                                                <li>Confirma el envío ✓</li>
                                            </ol>
                                        </div>
                                        <div class="payment-confirm-note">
                                            <small>✅ Una vez enviado, ingresa el número de comprobante abajo</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Panel Bancolombia --}}
                        <div class="qr-panel" id="panel-bancolombia" style="display:none;">
                            <div class="qr-option qr-option--bancolombia">
                                <h4 class="bancolombia-title">Bancolombia</h4>
                                <div class="qr-placeholder">
                                    <div class="qr-code bancolombia-payment-box">
                                        @if(file_exists(public_path('img/qr/bancolombia-qr.png')))
                                            <div class="real-qr-section">
                                                <img id="bancolombia-qr"
                                                     src="{{ asset('img/qr/bancolombia-qr.png') }}?{{ time() }}"
                                                     alt="QR Bancolombia Real"
                                                     class="qr-image qr-image--bancolombia">
                                                <p class="qr-official-label qr-official-label--bancolombia">✅ QR Oficial Bancolombia</p>
                                                <p class="qr-amount qr-amount--bancolombia"><strong>$10,000 COP</strong></p>
                                                <small class="qr-instruction">🎯 Escanea este QR con tu app Bancolombia</small>
                                            </div>
                                        @endif
                                        <div class="payment-steps bancolombia-steps">
                                            <p class="steps-title bancolombia-steps-title">
                                                @if(file_exists(public_path('img/qr/bancolombia-qr.png')))
                                                    📲 ¿No puedes escanear? Paga manualmente:
                                                @else
                                                    📱 Pasos para pagar con Bancolombia:
                                                @endif
                                            </p>
                                            <ol class="steps-list">
                                                <li>Abre tu app <strong class="bancolombia-highlight">Bancolombia</strong></li>
                                                <li>Ve a <strong>"Transferencias"</strong> → <strong>"A otros bancos"</strong></li>
                                                <li>Ingresa este número:</li>
                                            </ol>
                                            <div data-copy-phone="true" class="phone-copy-box bancolombia-phone">
                                                <span class="phone-number">311 810 4544</span>
                                                <br><small>📋 Toca para copiar</small>
                                            </div>
                                            <ol class="steps-list" start="4">
                                                <li>Monto: <strong class="bancolombia-highlight">$10,000</strong></li>
                                                <li>Descripción: <strong class="bancolombia-highlight">Anticipo + tu nombre</strong></li>
                                                <li>Confirma el envío ✓</li>
                                            </ol>
                                        </div>
                                        <div class="payment-confirm-note payment-confirm-note--bancolombia">
                                            <small>✅ Una vez enviado, ingresa el número de comprobante abajo</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Número de transacción -->
                        <div class="payment-confirmation" role="group" aria-label="Confirmación de pago">
                            <label for="transaction-reference">Número de transacción/comprobante:</label>
                            <input type="text" id="transaction-reference"
                                   placeholder="Ej: 123456789 o código de confirmación"
                                   aria-required="true" aria-describedby="transaction-help">
                            <small id="transaction-help">
                                Una vez realizado el pago, ingresa el número de transacción para confirmar tu anticipo
                            </small>
                        </div>

                    </div>{{-- /qr-payment-section --}}

                </div>{{-- /payment-options --}}

                <div class="booking-navigation" role="group" aria-label="Navegación del paso 4">
                    <button class="btn-back" id="btn-back-4" aria-label="Volver al paso 3: Seleccionar fecha">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="M19 12H5M12 19l-7-7 7-7"/>
                        </svg>
                        Atrás
                    </button>
                    <button class="btn-next" id="btn-next-4" aria-label="Continuar al paso 5: Confirmar cita">
                        Continuar
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
            </section>

            <!-- ══════════════════════════════════════
                 STEP 5: CONFIRMAR
            ══════════════════════════════════════ -->
            <section class="booking-step" id="step-5" role="region" aria-label="Paso 5: Confirmar cita">
                <h2 class="step-title">Confirma tu Cita</h2>
                <p class="step-subtitle">Revisa los detalles y completa tus datos</p>

                <fieldset class="client-form" aria-label="Datos personales del cliente">
                    <legend class="sr-only">Información personal</legend>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="client-name">Nombre Completo <span aria-hidden="true">*</span></label>
                            <input type="text" id="client-name" placeholder="Tu nombre completo"
                                   required aria-required="true">
                            <span id="client-name-error" class="field-error" role="alert" aria-live="polite" style="display:none;"></span>
                        </div>
                        <div class="form-group">
                            <label for="client-cedula">Cédula <span aria-hidden="true">*</span></label>
                            <input type="text" id="client-cedula" placeholder="Tu número de cédula"
                                required aria-required="true" maxlength="10" inputmode="numeric" pattern="[0-9]{5,10}">
                            <span id="client-cedula-error" class="field-error" role="alert" aria-live="polite" style="display:none;"></span>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="client-phone">Celular <span aria-hidden="true">*</span></label>
                            <input type="tel" id="client-phone" placeholder="Tu número de celular"
                                required aria-required="true" maxlength="10" minlength="10" pattern="3[0-9]{9}" inputmode="tel">
                            <span id="client-phone-error" class="field-error" role="alert" aria-live="polite" style="display:none;"></span>
                        </div>
                        <div class="form-group">
                            <label for="client-email">Email <span aria-hidden="true">*</span></label>
                            <input type="email" id="client-email" placeholder="Tu correo electrónico"
                                   required aria-required="true">
                            <span id="client-email-error" class="field-error" role="alert" aria-live="polite" style="display:none;"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="client-birthdate">Fecha de Nacimiento (opcional)</label>
                        <input type="date" id="client-birthdate" aria-required="false">
                    </div>
                </fieldset>

                <!-- Consentimiento de tratamiento de datos -->
                <div class="consent-section" style="margin:1rem 0;">
                    <label for="accept-terms" style="display:flex;align-items:flex-start;gap:.6rem;cursor:pointer;color:#fff;">
                        <input type="checkbox" id="accept-terms" name="accept-terms" aria-required="true" style="margin-top:3px;flex-shrink:0;accent-color:#DC2626;">
                        <span style="color:#eee;line-height:1.35;">
                            He leído y acepto la
                            <a href="#" id="open-terms-modal" style="color:#D4AF37;text-decoration:underline;">Política de Tratamiento de Datos Personales</a>
                            de H Barber Shop SAS.
                            <a href="{{ route('politicas') }}" target="_blank" rel="noopener" style="color:#D4AF37;font-size:.85em;">(ver página completa)</a>
                        </span>
                    </label>
                    <small style="color:#bbb;display:block;margin-top:.3rem;">Requisito legal — Ley 1581 de 2012. Debes aceptar el tratamiento de datos para confirmar la cita.</small>
                </div>

              <!-- Modal Términos -->
<div id="terms-modal" class="terms-modal" role="dialog" aria-modal="true" aria-labelledby="terms-modal-title" style="display:none;">
    <div class="terms-modal-overlay" id="terms-modal-overlay"></div>
    <div class="terms-modal-box" role="document">

        {{-- Header --}}
        <header class="terms-modal-header">
            <div class="terms-modal-header-left">
                <div class="terms-modal-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#D4AF37" stroke-width="1.5">
                        <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.586a1 1 0 0 1 .707.293l5.414 5.414a1 1 0 0 1 .293.707V19a2 2 0 0 1-2 2z"/>
                    </svg>
                </div>
                <div class="terms-modal-titles">
                    <h2 id="terms-modal-title">Términos y Condiciones</h2>
                    <p>H Barber Shop SAS — Tratamiento de datos personales</p>
                </div>
            </div>
            <button type="button" id="terms-close-x" class="terms-modal-close" aria-label="Cerrar modal">&#x2715;</button>
        </header>

        {{-- Badges --}}
        <div class="terms-modal-badges" aria-label="Marco legal aplicable">
            <span class="terms-badge terms-badge--gold">Ley 1581 de 2012</span>
            <span class="terms-badge terms-badge--blue">Política de privacidad</span>
            <span class="terms-badge terms-badge--green">Colombia</span>
        </div>

        {{-- Body --}}
        <div class="terms-modal-body" id="terms-modal-body" tabindex="0"></div>

        {{-- Footer --}}
        <footer class="terms-modal-footer">
            <p class="terms-modal-note" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                    <circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/>
                </svg>
                Debes aceptar para continuar con la reserva
            </p>
            <div class="terms-modal-actions">
                <button type="button" id="terms-close" class="terms-btn terms-btn--ghost">Cerrar</button>
                <button type="button" id="terms-download" class="terms-btn terms-btn--download"
                        data-download-url="{{ url('/terminos/descargar') }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                        <polyline points="7 10 12 15 17 10"/>
                        <line x1="12" y1="15" x2="12" y2="3"/>
                    </svg>
                    Descargar
                </button>
                <button type="button" id="terms-accept" class="terms-btn terms-btn--accept">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    Aceptar
                </button>
            </div>
        </footer>
    </div>
</div>

<script type="text/template" id="terms-template">
<div class="terms-section">
    <div class="terms-section-title">Responsable del Tratamiento</div>
    <p><strong>Razón social:</strong> H BARBER SHOP S.A.S. &nbsp;|&nbsp; <strong>NIT:</strong> 901.814.813-3<br>
    <strong>Representante Legal:</strong> Angie Katerine Hernández Villamil<br>
    <strong>Dirección:</strong> Calle 50 #21A-05, Álamos Norte, Neiva, Huila<br>
    <strong>Teléfono/WhatsApp:</strong> 311 810 4544 &nbsp;|&nbsp; <strong>Correo:</strong> hbarbershopsas@gmail.com<br>
    <strong>Sitio web:</strong> www.hbarbershop.co</p>
</div>
<div class="terms-section">
    <div class="terms-section-title">Datos que se recopilan</div>
    <ul>
        <li>Nombre completo y datos de identificación.</li>
        <li>Número de teléfono celular y/o fijo.</li>
        <li>Dirección de correo electrónico.</li>
        <li>Fecha y hora de citas agendadas.</li>
        <li>Historial de servicios solicitados.</li>
        <li>Preferencias y observaciones manifestadas por el cliente.</li>
        <li>Datos de navegación en el sitio web (cookies y herramientas de análisis).</li>
    </ul>
</div>
<div class="terms-section">
    <div class="terms-section-title">Finalidades del Tratamiento</div>
    <ul>
        <li>Gestionar el agendamiento, confirmación y seguimiento de citas.</li>
        <li>Brindar atención al cliente y dar respuesta a solicitudes, quejas o inquietudes.</li>
        <li>Enviar comunicaciones sobre novedades, promociones y servicios, previa autorización.</li>
        <li>Mejorar la experiencia del usuario en el sitio web y el establecimiento.</li>
        <li>Cumplir con obligaciones legales, tributarias y contables.</li>
        <li>Analizar el comportamiento de navegación para optimizar los servicios digitales.</li>
    </ul>
</div>
<div class="terms-section">
    <div class="terms-section-title">Derechos del Titular (Art. 8, Ley 1581 de 2012)</div>
    <ul>
        <li>Conocer, actualizar y rectificar sus datos personales en cualquier momento.</li>
        <li>Solicitar prueba de la autorización otorgada para el tratamiento de sus datos.</li>
        <li>Ser informado sobre el uso que se ha dado a sus datos personales.</li>
        <li>Presentar quejas ante la Superintendencia de Industria y Comercio (SIC).</li>
        <li>Revocar la autorización y/o solicitar la supresión de sus datos, siempre que no exista obligación legal que lo impida.</li>
        <li>Acceder de forma gratuita a sus datos personales objeto de tratamiento.</li>
    </ul>
</div>
<div class="terms-section">
    <div class="terms-section-title">Política de Cancelación de Citas</div>
    <p>El cliente debe notificar cancelaciones o cambios con al menos <strong>dos (2) horas de anticipación</strong>. La inasistencia reiterada sin aviso previo podrá dar lugar a restricciones en el agendamiento futuro.</p>
</div>
<div class="terms-section">
    <div class="terms-section-title">Seguridad y Confidencialidad</div>
    <p>H BARBER SHOP S.A.S. implementa las medidas técnicas, humanas y administrativas necesarias para garantizar la seguridad de los datos personales y evitar su adulteración, pérdida, consulta, uso o acceso no autorizado o fraudulento.</p>
    <p>Los datos personales proporcionados no serán vendidos, cedidos ni compartidos con terceros sin autorización previa, salvo obligación legal.</p>
</div>
<div class="terms-section">
    <div class="terms-section-title">Legislación aplicable</div>
    <p>La presente política se rige por la Ley Estatutaria <strong>1581 de 2012</strong>, el Decreto Reglamentario <strong>1377 de 2013</strong> y demás normas concordantes de la República de Colombia.</p>
</div>
<div class="terms-section">
    <div class="terms-section-title">Canal para ejercer derechos</div>
    <div class="terms-meta-grid">
        <div class="terms-meta-item">
            <span>Correo electrónico</span>
            <strong>hbarbershopsas@gmail.com</strong>
        </div>
        <div class="terms-meta-item">
            <span>Teléfono / WhatsApp</span>
            <strong>311 810 4544</strong>
        </div>
        <div class="terms-meta-item">
            <span>Dirección física</span>
            <strong>Calle 50 #21A-05, Álamos Norte, Neiva, Huila</strong>
        </div>
        <div class="terms-meta-item">
            <span>Representante Legal</span>
            <strong>Angie Katerine Hernández Villamil</strong>
        </div>
        <div class="terms-meta-item">
            <span>Versión del documento</span>
            <strong>2.0 — Abril 2026</strong>
        </div>
        <div class="terms-meta-item">
            <span>Tiempo de respuesta</span>
            <strong>Máximo 15 días hábiles</strong>
        </div>
    </div>
</div>
</script>
                <!-- Resumen -->
                <div class="summary-card" role="region" aria-label="Resumen de la cita" aria-live="polite">
                    <h3 class="summary-title">Resumen de tu Cita</h3>

                    <div class="summary-item">
                        <span class="summary-label">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                            Barbero
                        </span>
                        <span class="summary-value" id="summary-barber">—</span>
                    </div>

                    <div class="summary-item">
                        <span class="summary-label">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <circle cx="6" cy="6" r="3"/><circle cx="6" cy="18" r="3"/>
                                <line x1="20" y1="4" x2="8.12" y2="15.88"/>
                            </svg>
                            Servicio
                        </span>
                        <span class="summary-value" id="summary-service">—</span>
                    </div>

                    <div class="summary-item">
                        <span class="summary-label">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                <line x1="16" y1="2" x2="16" y2="6"/>
                                <line x1="8" y1="2" x2="8" y2="6"/>
                            </svg>
                            Fecha
                        </span>
                        <span class="summary-value" id="summary-date">—</span>
                    </div>

                    <div class="summary-item">
                        <span class="summary-label">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
                            </svg>
                            Hora
                        </span>
                        <span class="summary-value" id="summary-time">—</span>
                    </div>

                    <div class="summary-item">
                        <span class="summary-label">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
                            </svg>
                            Duración
                        </span>
                        <span class="summary-value" id="summary-duration">—</span>
                    </div>

                    <div class="summary-item summary-payment-info" id="summary-payment-info">
                        <span class="summary-label">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <rect x="1" y="3" width="15" height="13"/>
                                <path d="M16 8h4l3 3v5a2 2 0 0 1-2 2h-2"/>
                                <circle cx="5.5" cy="18.5" r="2.5"/>
                                <circle cx="18.5" cy="18.5" r="2.5"/>
                            </svg>
                            Anticipo
                        </span>
                        <span class="summary-value" id="summary-payment">$10.000 - Pendiente</span>
                    </div>

                    <div class="summary-total">
                        <span class="summary-label">Total a Pagar</span>
                        <span class="summary-value" id="summary-total">—</span>
                    </div>
                </div>

                <div class="booking-navigation booking-navigation-vertical" role="group" aria-label="Acciones finales">
                    <button class="btn-confirm" id="btn-confirm" disabled aria-disabled="true" aria-label="Confirmar y agendar la cita">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                            <polyline points="22 4 12 14.01 9 11.01"/>
                        </svg>
                        Confirmar Cita
                    </button>
                    <button class="btn-back btn-back-full" id="btn-back-5"
                            aria-label="Volver a modificar los datos de la cita">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="M19 12H5M12 19l-7-7 7-7"/>
                        </svg>
                        Modificar Cita
                    </button>
                </div>
            </section>

            <!-- ══════════════════════════════════════
                 STEP SUCCESS
            ══════════════════════════════════════ -->
            <section class="booking-step" id="step-success" role="region" aria-label="Confirmación exitosa de la cita">
                <div class="success-message" role="alert" aria-live="assertive">

                    <div class="success-icon" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24"
                             fill="none" stroke="#0a0a0a" stroke-width="3" aria-hidden="true">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                    </div>

                    <h2 class="success-title" id="success-title">¡Cita Confirmada!</h2>

                    <p class="success-text" id="success-text">
                        Tu cita ha sido agendada exitosamente. Te hemos enviado un recordatorio por WhatsApp.
                        Te esperamos puntual para brindarte la mejor experiencia.
                    </p>

                    <div class="confirmation-code">
                        <span>Código de Confirmación</span>
                        <strong>HBS-2026-0203-1045</strong>
                    </div>

                    <a href="{{ route('welcome') }}" class="btn-next btn-home"
                       aria-label="Volver a la página de inicio">
                        Volver al Inicio
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>

                </div>
            </section>

        </div>
    </main>

    <script>
        window.turnosAvailableRoute = "{{ route('turnos.available') }}";
        window.turnosStoreRoute     = "{{ route('turnos.store') }}";
    </script>
@endsection

@push('scripts')
    @vite(['resources/js/Home/agendar.js'])
@endpush