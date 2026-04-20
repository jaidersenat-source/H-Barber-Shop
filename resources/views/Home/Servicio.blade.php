@extends('layouts.blog')

@section('og_type', 'blog')

@section('content')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Servicios de barbería premium en H Barber Shop SAS. Cortes, barba, tratamientos y combos especiales. Reserva tu cita hoy.">
    <meta name="theme-color" content="#D4AF37">
    <title>Servicios - H Barber Shop SAS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/Home/Servicio.css'])
   
</head>
<body lang="es">
    <!-- Skip Link -->
    <a href="#main-services-content" class="skip-link">Saltar al contenido principal</a>
    <!-- Hero de Servicios -->
    <section class="services-hero" role="banner" aria-label="Sección principal de servicios" style="background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('{{ asset('img/8.jpg') }}'); background-size: cover; background-position: center; background-attachment: fixed;">
        <div class="container">
            <h1>Nuestros Servicios</h1>
            <p>Descubre la experiencia premium en cuidado masculino. Cada servicio está diseñado para brindarte resultados excepcionales.</p>
        </div>
    </section>

    <!-- Categorías -->
    <section class="services-categories" aria-label="Filtro de categorías de servicios">
        <div class="container">
            <h2 class="visually-hidden">Categorías de servicios</h2>
            <div class="categories-wrapper" role="tablist">
                <button class="category-btn active" data-category="all" role="tab" aria-selected="true" aria-controls="all-services">Todos</button>
                <button class="category-btn" data-category="cortes" role="tab" aria-selected="false" aria-controls="cortes-services">Cortes</button>
                <button class="category-btn" data-category="barba" role="tab" aria-selected="false" aria-controls="barba-services">Barba</button>
                <button class="category-btn" data-category="tratamientos" role="tab" aria-selected="false" aria-controls="tratamientos-services">Tratamientos</button>
                <button class="category-btn" data-category="combos" role="tab" aria-selected="false" aria-controls="combos-services">Combos</button>
            </div>
        </div>
    </section>

    <main id="main-services-content">
    <section class="services-full">
        <div class="container">
            <!-- Cortes de Cabello -->
            <div class="services-section" id="cortes-services" data-category="cortes" role="tabpanel" aria-labelledby="cortes-tab">
                <h2 class="services-section-title">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#D4AF37" stroke-width="2" aria-hidden="true" role="presentation">
                        <circle cx="6" cy="6" r="3"/>
                        <circle cx="6" cy="18" r="3"/>
                        <line x1="20" y1="4" x2="8.12" y2="15.88"/>
                        <line x1="14.47" y1="14.48" x2="20" y2="20"/>
                        <line x1="8.12" y1="8.12" x2="12" y2="12"/>
                    </svg>
                    Cortes de Cabello
                </h2>
                <div class="services-list" role="list">
                    @php $hayCortes = false; @endphp
                    @foreach($servicios as $servicio)
                        @if($servicio->serv_categoria === 'cortes')
                            @php $hayCortes = true; @endphp
                            <article class="service-item" role="listitem" aria-label="{{ $servicio->serv_nombre }}">
                                <div class="service-icon" aria-hidden="true" role="presentation">
                                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
                                        <circle cx="6" cy="6" r="3"/>
                                        <circle cx="6" cy="18" r="3"/>
                                        <line x1="20" y1="4" x2="8.12" y2="15.88"/>
                                    </svg>
                                </div>
                                <div class="service-details">
                                    <h3>{{ $servicio->serv_nombre }}</h3>
                                    <p class="description" aria-label="Descripción del servicio">{{ $servicio->serv_descripcion }}</p>
                                    <div class="service-meta">
                                        <span class="service-price" aria-label="Precio">Desde ${{ number_format($servicio->serv_precio, 0, ',', '.') }}</span>
                                        <span class="service-duration" aria-label="Duración del servicio">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                <circle cx="12" cy="12" r="10"/>
                                                <polyline points="12 6 12 12 16 14"/>
                                            </svg>
                                            {{ $servicio->serv_duracion }} min
                                        </span>
                                        <a href="{{ route('agendar') }}" aria-label="Reservar el servicio {{ $servicio->serv_nombre }}">
                                            <button class="btn-reservar">Reservar</button>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        @endif
                    @endforeach
                    @if(!$hayCortes)
                        <p role="status" aria-live="polite">No hay servicios de cortes disponibles en este momento.</p>
                    @endif
                </div>
            </div>

            <!-- Servicios de Barba -->
            <div class="services-section" id="barba-services" data-category="barba" role="tabpanel" aria-labelledby="barba-tab">
                <h2 class="services-section-title">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#D4AF37" stroke-width="2" aria-hidden="true" role="presentation">
                        <path d="M6 2v6a6 6 0 0 0 12 0V2"/>
                        <path d="M12 14v8"/>
                        <path d="M8 22h8"/>
                    </svg>
                    Servicios de Barba
                </h2>
                <div class="services-list" role="list">
                    @php $hayBarba = false; @endphp
                    @foreach($servicios as $servicio)
                        @if($servicio->serv_categoria === 'barba')
                            @php $hayBarba = true; @endphp
                            <article class="service-item" role="listitem" aria-label="{{ $servicio->serv_nombre }}">
                                <div class="service-icon" aria-hidden="true" role="presentation">
                                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
                                        <path d="M6 2v6a6 6 0 0 0 12 0V2"/>
                                    </svg>
                                </div>
                                <div class="service-details">
                                    <h3>{{ $servicio->serv_nombre }}</h3>
                                    <p class="description" aria-label="Descripción del servicio">{{ $servicio->serv_descripcion }}</p>
                                    <div class="service-meta">
                                        <span class="service-price" aria-label="Precio">Desde ${{ number_format($servicio->serv_precio, 0, ',', '.') }}</span>
                                        <span class="service-duration" aria-label="Duración del servicio">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                <circle cx="12" cy="12" r="10"/>
                                                <polyline points="12 6 12 12 16 14"/>
                                            </svg>
                                            {{ $servicio->serv_duracion }} min
                                        </span>
                                        <a href="{{ route('agendar') }}" aria-label="Reservar el servicio {{ $servicio->serv_nombre }}">
                                            <button class="btn-reservar">Reservar</button>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        @endif
                    @endforeach
                    @if(!$hayBarba)
                        <p role="status" aria-live="polite">No hay servicios de barba disponibles en este momento.</p>
                    @endif
                </div>
            </div>

            <!-- Tratamientos -->
            <div class="services-section" id="tratamientos-services" data-category="tratamientos" role="tabpanel" aria-labelledby="tratamientos-tab">
                <h2 class="services-section-title">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#D4AF37" stroke-width="2" aria-hidden="true" role="presentation">
                        <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/>
                    </svg>
                    Tratamientos Especiales
                </h2>
                <div class="services-list" role="list">
                    @php $hayTratamientos = false; @endphp
                    @foreach($servicios as $servicio)
                        @if($servicio->serv_categoria === 'tratamientos')
                            @php $hayTratamientos = true; @endphp
                            <article class="service-item" role="listitem" aria-label="{{ $servicio->serv_nombre }}">
                                <div class="service-icon" aria-hidden="true" role="presentation">
                                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
                                        <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/>
                                    </svg>
                                </div>
                                <div class="service-details">
                                    <h3>{{ $servicio->serv_nombre }}</h3>
                                    <p class="description" aria-label="Descripción del servicio">{{ $servicio->serv_descripcion }}</p>
                                    <div class="service-meta">
                                        <span class="service-price" aria-label="Precio">Desde ${{ number_format($servicio->serv_precio, 0, ',', '.') }}</span>
                                        <span class="service-duration" aria-label="Duración del servicio">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                <circle cx="12" cy="12" r="10"/>
                                                <polyline points="12 6 12 12 16 14"/>
                                            </svg>
                                            {{ $servicio->serv_duracion }} min
                                        </span>
                                        <a href="{{ route('agendar') }}" aria-label="Reservar el servicio {{ $servicio->serv_nombre }}">
                                            <button class="btn-reservar">Reservar</button>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        @endif
                    @endforeach
                    @if(!$hayTratamientos)
                        <p role="status" aria-live="polite">No hay tratamientos especiales disponibles en este momento.</p>
                    @endif
                </div>
            </div>
        </div>
    </section>

            <!-- Combos Especiales -->
            <section class="combos-section" id="combos-services" data-category="combos" role="tabpanel" aria-labelledby="combos-tab">
        <div class="container">
            <h2 class="section-title">Combos Especiales</h2>
            <div class="combo-cards" role="list">
                @php
                    $combosServicios = $servicios->where('serv_categoria', 'combos');
                    $hayCombos = $combosServicios->count() > 0;
                @endphp
                @foreach($combosServicios as $combo)
                    <article class="combo-card" role="listitem" aria-label="{{ $combo->serv_nombre }}">
                        <div class="combo-icon" aria-hidden="true" role="presentation">
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
                                <circle cx="6" cy="6" r="3"/>
                                <circle cx="6" cy="18" r="3"/>
                                <line x1="20" y1="4" x2="8.12" y2="15.88"/>
                            </svg>
                        </div>
                        <h3>{{ $combo->serv_nombre }}</h3>
                        <p class="combo-description" aria-label="Descripción del combo">{{ $combo->serv_descripcion }}</p>
                        @if(!empty($combo->serv_servicios_incluidos))
                        <div class="combo-includes" aria-label="Servicios incluidos">
                            <h4>Incluye:</h4>
                            <ul role="list">
                                @foreach($combo->serviciosIncluidos() as $servicioIncluido)
                                    <li role="listitem">{{ $servicioIncluido->serv_nombre }}</li>
                                @endforeach
                                <li role="listitem" class="combo-total-duracion"><strong>Duración total:</strong> {{ $combo->serv_duracion }} min</li>
                            </ul>
                        </div>
                        @endif
                        <div class="combo-price" aria-label="Precio del combo">
                            <span class="current-price">${{ number_format($combo->serv_precio, 0, ',', '.') }}</span>
                        </div>
                        <a href="{{ route('agendar') }}" aria-label="Reservar el combo {{ $combo->serv_nombre }}">
                            <button class="btn-reservar">Reservar Combo</button>
                        </a>
                    </article>
                @endforeach
                @if(!$hayCombos)
                    <p role="status" aria-live="polite">No hay combos especiales disponibles en este momento.</p>
                @endif
            </div>
        </div>
    </section>

    <!-- Información Adicional -->
    <section class="services-info" aria-label="Información sobre los servicios">
        <div class="container">
            <h2 class="visually-hidden">Por qué elegir nuestros servicios</h2>
            <div class="info-grid" role="list">
                <article class="info-card" role="listitem">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" aria-hidden="true" role="presentation">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    <h3>Reserva Online</h3>
                    <p>Agenda tu cita en segundos desde cualquier dispositivo. Recibe confirmación inmediata.</p>
                </article>
                <article class="info-card" role="listitem">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" aria-hidden="true" role="presentation">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                    <h3>Puntualidad</h3>
                    <p>Respetamos tu tiempo. Llegamos a la hora acordada, sin esperas innecesarias.</p>
                </article>
                <article class="info-card" role="listitem">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" aria-hidden="true" role="presentation">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    </svg>
                    <h3>Higiene Garantizada</h3>
                    <p>Herramientas esterilizadas y productos de primera calidad. Tu salud es nuestra prioridad.</p>
                </article>
                <article class="info-card" role="listitem">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" aria-hidden="true" role="presentation">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                        <polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                    <h3>Satisfacción 100%</h3>
                    <p>Si no quedas satisfecho, lo arreglamos sin costo adicional. Ese es nuestro compromiso.</p>
                </article>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="cta-final" aria-label="Llamada a la acción final">
        <div class="cta-background" aria-hidden="true"></div>
        <div class="container">
            <h2 class="cta-title">Transforma tu imagen hoy</h2>
            <p class="cta-subtitle">Reserva tu cita y descubre por qué somos la barbería preferida de la ciudad</p>
            <a href="{{ route('agendar') }}" aria-label="Ir a la página de agendamiento">
                <button class="btn-cta-3d">Agendar Mi Cita</button>
            </a>
        </div>
    </section>

    </main>

    <script>
        // Filtro de categorías accesible
        document.querySelectorAll('.category-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.category-btn').forEach(b => {
                    b.classList.remove('active');
                    b.setAttribute('aria-selected', 'false');
                });
                this.classList.add('active');
                this.setAttribute('aria-selected', 'true');

                const category = this.getAttribute('data-category');

                document.querySelectorAll('.services-section, .combos-section').forEach(section => {
                    if (category === 'all' || section.getAttribute('data-category') === category) {
                        section.style.display = '';
                    } else {
                        section.style.display = 'none';
                    }
                });

                // Anunciar cambio
                const categoryName = this.textContent.trim();
                const statusRegion = document.querySelector('[role="status"]');
                if (statusRegion) {
                    statusRegion.textContent = `Mostrando servicios de ${categoryName}`;
                }
            });

            // Navegación con teclado
            btn.addEventListener('keydown', function(e) {
                if (e.key === 'ArrowRight') {
                    const nextBtn = this.nextElementSibling;
                    if (nextBtn && nextBtn.classList.contains('category-btn')) {
                        nextBtn.click();
                        nextBtn.focus();
                    }
                } else if (e.key === 'ArrowLeft') {
                    const prevBtn = this.previousElementSibling;
                    if (prevBtn && prevBtn.classList.contains('category-btn')) {
                        prevBtn.click();
                        prevBtn.focus();
                    }
                }
            });
        });

        // Crear región viva para anuncios
        if (!document.querySelector('[role="status"]')) {
            const statusRegion = document.createElement('div');
            statusRegion.setAttribute('role', 'status');
            statusRegion.setAttribute('aria-live', 'polite');
            statusRegion.setAttribute('aria-atomic', 'true');
            statusRegion.style.position = 'absolute';
            statusRegion.style.left = '-10000px';
            statusRegion.id = 'services-status';
            document.body.insertBefore(statusRegion, document.body.firstChild);
        }
    </script>
   

</body>
@endsection

@push('styles')

@endpush 