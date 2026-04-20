@extends('layouts.blog')

@section('og_type', 'blog')

@section('content')
    <!-- Detección de capacidad del dispositivo (antes de cargar JS pesado) -->
    <script>
    (function(){
        try {
            var prefersReduced = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            var connection = navigator.connection || navigator.mozConnection || navigator.webkitConnection || {};
            var saveData = connection.saveData === true;
            var deviceMemory = navigator.deviceMemory || null;
            var cores = navigator.hardwareConcurrency || null;
            var isSmallScreen = window.matchMedia && window.matchMedia('(max-width: 767px)').matches;
            var isCoarse = window.matchMedia && window.matchMedia('(pointer: coarse)').matches;

            var lowMemory = deviceMemory !== null ? deviceMemory <= 1.5 : false;
            var fewCores  = cores !== null ? cores <= 2 : false;

            // Gama baja: memoria o núcleos escasos, pantalla pequeña y táctil
            var lowSpec = prefersReduced || saveData || ((lowMemory || fewCores) && isSmallScreen && isCoarse);

            if (lowSpec) {
                document.documentElement.classList.add('no-3d');
                window.__DISABLE_3D = true;
            } else {
                window.__DISABLE_3D = false;
            }
        } catch(e) {
            window.__DISABLE_3D = false;
        }
    })();
    </script>

    @vite(['resources/css/Home/inicio.css'])

    <style>
    /* === MODO LIGERO (gama baja) =============================================== */
    /* Eliminar efectos 3D/transformaciones pesadas */
    .no-3d .btn-3d,
    .no-3d .btn-primary-3d,
    .no-3d .btn-secondary-3d,
    .no-3d .btn-cta-3d,
    .no-3d .service-3d,
    .no-3d .product-3d,
    .no-3d .card-shine,
    .no-3d .scroll-indicator,
    .no-3d .progress-fill,
    .no-3d .hero-title,
    .no-3d .hero-subtitle {
        transform: none !important;
        animation: none !important;
        transition: color 0.2s ease, background-color 0.2s ease !important;
        will-change: auto !important;
    }

    /* Ocultar elementos pesados: video de fondo, canvas de partículas */
    .no-3d #particles-canvas,
    .no-3d #hero-video,
    .no-3d .brand-video {
        display: none !important;
    }

    /* Fondo de respaldo para el hero cuando no hay video */
    .no-3d .hero {
        background: linear-gradient(160deg, #1c0a00 0%, #2e1500 45%, #111 100%) !important;
        min-height: 100svh;
    }

    /* Asegurar visibilidad inmediata de contenido hero */
    .no-3d .hero-title,
    .no-3d .hero-subtitle,
    .no-3d .hero-buttons,
    .no-3d .hero-content {
        opacity: 1 !important;
        visibility: visible !important;
    }

    /* Botones siguen siendo clicables y visibles */
    .no-3d .btn-primary-3d,
    .no-3d .btn-secondary-3d,
    .no-3d .btn-cta-3d {
        opacity: 1 !important;
        visibility: visible !important;
        display: inline-block !important;
    }

    /* Cards: mostrar inmediatamente sin animación de entrada */
    .no-3d .experience-card,
    .no-3d .service-card,
    .no-3d .loyalty-card,
    .no-3d .product-card,
    .no-3d .brand-image,
    .no-3d .section-title,
    .no-3d .cta-title,
    .no-3d .cta-subtitle {
        opacity: 1 !important;
        visibility: visible !important;
        transform: none !important;
    }

    @media (prefers-reduced-motion: reduce) {
        .btn-3d, .service-3d, .product-3d, .card-shine,
        #particles-canvas, .scroll-indicator {
            transform: none !important;
            animation: none !important;
            transition: none !important;
        }
    }
    </style>

    <!-- Hero Section -->
    <section class="hero" role="banner" aria-label="Sección principal de H Barber Shop">
        <!-- Video de fondo con descripción accesible -->
        <video id="hero-video" autoplay muted loop playsinline aria-hidden="true" role="presentation">
            <source src="{{ asset('video/4.mp4') }}" type="video/mp4">
            <p>Su navegador no soporta video HTML5.</p>
        </video>
    
        <div class="hero-overlay" aria-hidden="true"></div>
        <div class="video-overlay" aria-hidden="true"></div>
        <canvas id="particles-canvas" aria-hidden="true" role="presentation"></canvas>
        
        <div class="hero-content">
            <h1 class="hero-title">Estilo, Precisión y Experiencia Premium</h1>
            <p class="hero-subtitle">El arte de la barbería llevado a su máxima expresión</p>
            <div class="hero-buttons" role="group" aria-label="Acciones principales">
                <a href="{{ route('agendar') }}" aria-label="Agendar una cita en H Barber Shop">
                    <button class="btn-3d btn-primary-3d">Agendar Cita</button>
                </a>

                <a href="{{ route('servicios') }}" aria-label="Ver la lista completa de servicios">
                    <button class="btn-3d btn-secondary-3d">Ver Servicios</button>
                </a>
            </div>
        </div>
        <div class="scroll-indicator" aria-hidden="true" role="presentation">
            <span>Desliza</span>
            <div class="scroll-line"></div>
        </div>
    </section>

    <!-- Experiencia Section -->
    <section class="experience" aria-label="Razones para elegir H Barber Shop">
        <div class="container">
            <h2 class="visually-hidden">Ventajas de H Barber Shop</h2>
            <div class="experience-grid" role="list">
                <div class="experience-card" role="listitem" data-aos="fade-up" data-delay="0" aria-describedby="exp-1">
                    <div class="card-icon" aria-hidden="true" role="presentation">
                        <svg width="60" height="60" viewBox="0 0 60 60" fill="none">
                            <circle cx="30" cy="30" r="28" stroke="#D4AF37" stroke-width="2" opacity="0.3"/>
                            <path d="M30 15 L30 45 M15 30 L45 30" stroke="#D4AF37" stroke-width="2"/>
                        </svg>
                    </div>
                    <h3 id="exp-1">Atención Personalizada</h3>
                    <p>Cada cliente es único. Diseñamos tu estilo perfecto.</p>
                </div>
                <div class="experience-card" role="listitem" data-aos="fade-up" data-delay="100" aria-describedby="exp-2">
                    <div class="card-icon" aria-hidden="true" role="presentation">
                        <svg width="60" height="60" viewBox="0 0 60 60" fill="none">
                            <rect x="15" y="15" width="30" height="30" stroke="#D4AF37" stroke-width="2" opacity="0.3"/>
                            <circle cx="30" cy="30" r="8" fill="#D4AF37"/>
                        </svg>
                    </div>
                    <h3 id="exp-2">Barberos Profesionales</h3>
                    <p>Expertos certificados con años de experiencia.</p>
                </div>
                <div class="experience-card" role="listitem" data-aos="fade-up" data-delay="200" aria-describedby="exp-3">
                    <div class="card-icon" aria-hidden="true" role="presentation">
                        <svg width="60" height="60" viewBox="0 0 60 60" fill="none">
                            <polygon points="30,10 50,50 10,50" stroke="#D4AF37" stroke-width="2" opacity="0.3"/>
                            <circle cx="30" cy="35" r="5" fill="#D4AF37"/>
                        </svg>
                    </div>
                    <h3 id="exp-3">Ambiente Premium</h3>
                    <p>Instalaciones exclusivas y confortables.</p>
                </div>
                <div class="experience-card" role="listitem" data-aos="fade-up" data-delay="300" aria-describedby="exp-4">
                    <div class="card-icon" aria-hidden="true" role="presentation">
                        <svg width="60" height="60" viewBox="0 0 60 60" fill="none">
                            <path d="M20 25 L40 25 L40 40 L20 40 Z" stroke="#D4AF37" stroke-width="2" opacity="0.3"/>
                            <circle cx="30" cy="20" r="4" fill="#D4AF37"/>
                        </svg>
                    </div>
                    <h3 id="exp-4">Tecnología y Comodidad</h3>
                    <p>Equipamiento de última generación.</p>
                </div>
            </div>
        </div>
    </section>

<style>
@media (max-width: 768px) {
  .hero {
    background-image: url('{{ asset('img/12.jpg') }}');
  }
}
</style>




    <!-- Servicios Section -->
    <section class="services" id="servicios" aria-label="Servicios disponibles">
        <div class="container">
            <h2 class="section-title">Servicios Destacados</h2>
            <div class="services-grid" role="list">
                @foreach($serviciosDestacados as $servicio)
                    <article class="service-card" role="listitem" data-aos="zoom-in" aria-label="{{ $servicio->serv_nombre }}">
                        <div class="service-3d">
                            <div class="service-image">
                                @php
                                    $categoria = strtolower($servicio->serv_categoria ?? '');
                                    $imagenCategoria = 'default.jpg'; // Imagen por defecto
                                    
                                    if(str_contains($categoria, 'barba')) {
                                        $imagenCategoria = 'barba.jpg';
                                    } elseif(str_contains($categoria, 'corte')) {
                                        $imagenCategoria = 'corte.jpg';
                                    } elseif(str_contains($categoria, 'tratamientos')) {
                                        $imagenCategoria = 'tratamiento.jpg';
                                    } elseif(str_contains($categoria, 'combo')) {
                                        $imagenCategoria = 'combo.jpg';
                                    }
                                @endphp
                                <img src="{{ asset('img/servicios/' . $imagenCategoria) }}" alt="Imagen del servicio: {{ $servicio->serv_nombre }}">
                            </div>
                        </div>
                        <div class="service-info">
                            <h3>{{ $servicio->serv_nombre }}</h3>
                            <p class="service-price" aria-label="Precio desde">Desde ${{ number_format($servicio->serv_precio, 0, ',', '.') }}</p>
                            <p aria-label="Descripción del servicio">{{ $servicio->serv_descripcion }}</p>
                            <a href="{{ route('agendar') }}" aria-label="Reservar el servicio {{ $servicio->serv_nombre }}">
                                <button class="btn-service" aria-label="Reservar">Reservar</button>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="loyalty" aria-label="Programa de fidelización">
        <div class="container">
            <h2 class="section-title">Programa de Fidelización</h2>
            
            <div class="loyalty-content-wrapper">
                <!-- Texto Explicativo -->
                <div class="loyalty-info" data-aos="fade-right">
                    <div class="info-badge">
                        <svg width="30" height="30" viewBox="0 0 30 30" fill="none" aria-hidden="true" role="presentation">
                            <path d="M15 2L18.5 12H29L20.5 18.5L24 28.5L15 22L6 28.5L9.5 18.5L1 12H11.5L15 2Z" fill="#D4AF37" opacity="0.3"/>
                            <path d="M15 2L18.5 12H29L20.5 18.5L24 28.5L15 22L6 28.5L9.5 18.5L1 12H11.5L15 2Z" stroke="#D4AF37" stroke-width="1.5"/>
                        </svg>
                        <span>Exclusivo para Clientes</span>
                    </div>
                    
                    <h3 class="info-title">Membresía Premium</h3>
                    <p class="info-description">
                        Nuestro programa de fidelización fue creado para recompensar tu lealtad. 
                        Cada visita te acerca más a beneficios exclusivos y experiencias únicas.
                    </p>
                    
                    <div class="info-benefits" role="list" aria-label="Beneficios del programa de fidelización">
                        <div class="benefit-item" role="listitem">
                            <div class="benefit-icon" aria-hidden="true" role="presentation">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <circle cx="12" cy="12" r="10" stroke="#D4AF37" stroke-width="2"/>
                                    <path d="M8 12L11 15L16 9" stroke="#D4AF37" stroke-width="2"/>
                                </svg>
                            </div>
                            <div class="benefit-text">
                                <h4>Acumula Puntos</h4>
                                <p>Por cada servicio realizado</p>
                            </div>
                        </div>
                        
                        <div class="benefit-item" role="listitem">
                            <div class="benefit-icon" aria-hidden="true" role="presentation">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M12 2L15 8.5L22 9.5L17 14.5L18 21.5L12 18.5L6 21.5L7 14.5L2 9.5L9 8.5L12 2Z" stroke="#D4AF37" stroke-width="2"/>
                                </svg>
                            </div>
                            <div class="benefit-text">
                                <h4>Corte Gratis</h4>
                                <p>Al completar 8 visitas</p>
                            </div>
                        </div>
                        
                        <div class="benefit-item" role="listitem">
                            <div class="benefit-icon" aria-hidden="true" role="presentation">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect x="3" y="6" width="18" height="14" rx="2" stroke="#D4AF37" stroke-width="2"/>
                                    <path d="M3 10H21" stroke="#D4AF37" stroke-width="2"/>
                                </svg>
                            </div>
                            <div class="benefit-text">
                                <h4>Descuentos Exclusivos</h4>
                                <p>En productos y servicios</p>
                            </div>
                        </div>
                        
                        <div class="benefit-item" role="listitem">
                            <div class="benefit-icon" aria-hidden="true" role="presentation">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <circle cx="12" cy="8" r="4" stroke="#D4AF37" stroke-width="2"/>
                                    <path d="M6 21C6 17 9 14 12 14C15 14 18 17 18 21" stroke="#D4AF37" stroke-width="2"/>
                                </svg>
                            </div>
                            <div class="benefit-text">
                                <h4>Atención Prioritaria</h4>
                                <p>Reservas y agendamiento</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="info-cta">
                        <p class="cta-text">¿Por qué lo creamos?</p>
                        <p class="cta-description">
                            Porque valoramos tu confianza y queremos que cada visita a H Barber Shop 
                            sea más que un servicio: una experiencia premium que reconoce tu lealtad 
                            y te hace parte de nuestra exclusiva comunidad.
                        </p>
                    </div>
                </div>
                
                <!-- Tarjeta de Fidelización -->
                <div class="loyalty-card-wrapper" data-aos="fade-left">
                    <div class="loyalty-card" role="region" aria-label="Tarjeta de cliente premium">
                        <div class="card-shine" aria-hidden="true"></div>
                        <div class="card-header">
                            <div class="card-logo" aria-hidden="true" role="presentation">
                                <svg width="50" height="50" viewBox="0 0 50 50">
                                    <text x="25" y="35" font-family="Playfair Display" font-size="40" font-weight="700" fill="#D4AF37" text-anchor="middle">H</text>
                                </svg>
                            </div>
                            <div class="card-chip" aria-hidden="true" role="presentation">
                                <div class="chip-line"></div>
                                <div class="chip-line"></div>
                                <div class="chip-line"></div>
                                <div class="chip-line"></div>
                            </div>
                        </div>
                        <div class="card-name" aria-label="Tipo de membresía">Cliente Premium</div>
                        <div class="progress-section" aria-label="Progreso de acumulación de puntos">
                            <p class="progress-text">Acumula cortes y gana uno gratis</p>
                            <div class="progress-bar" role="progressbar" aria-valuenow="62.5" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-fill" style="width: 62.5%"></div>
                            </div>
                            <div class="progress-dots" aria-hidden="true" role="presentation">
                                <span class="dot completed"></span>
                                <span class="dot completed"></span>
                                <span class="dot completed"></span>
                                <span class="dot completed"></span>
                                <span class="dot completed"></span>
                                <span class="dot"></span>
                                <span class="dot"></span>
                                <span class="dot"></span>
                            </div>
                            <p class="progress-count" aria-label="Cortes completados">5 de 8 cortes</p>
                        </div>
                        <div class="card-number" aria-label="Número de tarjeta">•••• •••• •••• 4829</div>
                    </div>
                    
                    <div class="card-stats">
                        <div class="hero-buttons" role="group">
                            <a href="{{ route('fidelizacion') }}" aria-label="Ver detalles del programa de fidelización">
                                <button class="btn-3d btn-primary-3d">Consultar</button>
                            </a>
                        </div>
                        <div class="stat-divider" aria-hidden="true"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Productos Section -->
    <section class="products" id="productos" aria-label="Productos premium disponibles">
        <div class="container">
            <h2 class="section-title">Productos Premium</h2>
            <div class="products-carousel" role="region" aria-label="Carrusel de productos">
                <button class="carousel-btn prev" aria-label="Producto anterior">&lt;</button>
                <div class="products-track" role="list">
                    @foreach($productosDestacados as $producto)
                        <div class="product-card" role="listitem" aria-label="{{ $producto->pro_nombre }}">
                            <div class="product-3d">
                                @if($producto->pro_imagen)
                                    <img src="{{ asset('storage/' . $producto->pro_imagen) }}" alt="Producto: {{ $producto->pro_nombre }}">
                                @else
                                    <img src="{{ asset('img/placeholder.jpg') }}" alt="Imagen no disponible del producto {{ $producto->pro_nombre }}">
                                @endif
                            </div>
                            <h4>{{ $producto->pro_nombre }}</h4>
                            <p class="product-price" aria-label="Precio del producto">${{ number_format($producto->pro_precio, 0, ',', '.') }}</p>
                            <a href="{{ route('productos') }}" aria-label="Ver más detalles del producto {{ $producto->pro_nombre }}">
                                <button class="btn-product">Ver Producto</button>
                            </a>
                        </div>
                    @endforeach
                </div>
                <button class="carousel-btn next" aria-label="Siguiente producto">&gt;</button>
            </div>
        </div>
    </section>

    <!-- Marca Section -->
    <section class="brand" id="nosotros" aria-label="Experiencia H Barber Shop">
        <div class="container">
            <h2 class="section-title">La Experiencia H Barber Shop</h2>
            <div class="brand-grid">
                <div class="brand-image large" data-aos="fade-right">
                    <img src="{{ asset('img/4.jpeg') }}" alt="Interior de la barbería H Barber Shop con instalaciones premium">
                    <div class="image-overlay">
                        <h3>Exclusividad</h3>
                        <p>Un espacio diseñado para ti</p>
                    </div>
                </div>
                <div class="brand-content" data-aos="fade-left">
                    <h3>Profesionalismo</h3>
                    <p>Más de 4 años de experiencia en el arte de la barbería. Nuestro equipo está certificado y en constante capacitación para brindarte el mejor servicio.</p>
                </div>
                <div class="brand-content" data-aos="fade-right">
                    <h3>Estilo de Vida</h3>
                    <p>No es solo un corte, es una experiencia. Ambiente masculino, sofisticado y relajante donde cada detalle está pensado para tu comodidad.</p>
                </div>
                
                <div class="brand-image brand-video-container" data-aos="fade-left">
                    <video 
                        class="brand-video" 
                        controls 
                        preload="metadata" 
                        playsinline 
                        webkit-playsinline
                        aria-label="Vídeo de un barbero profesional trabajando">
                        <source src="{{ asset('video/barbero.mp4') }}" type="video/mp4">
                        <p>Su navegador no soporta el elemento video HTML5.</p>
                    </video>
                    <div class="image-overlay">
                        <h3>Maestros del Estilo</h3>
                        <p>Expertos en su arte</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Final -->
    <section class="cta-final" aria-label="Llamada a la acción final">
        <div class="cta-background" aria-hidden="true"></div>
        <div class="container">
            <h2 class="cta-title">Reserva tu cita y vive la experiencia H Barber Shop</h2>
            <p class="cta-subtitle">Donde el estilo se encuentra con la perfección</p>
            <a href="{{ route('agendar') }}" aria-label="Ir a la página de agendamiento de citas">
                <button class="btn-cta-3d">Agendar Ahora</button>
            </a>
        </div>
    </section>

    <script>
    window.turnosAvailableRoute = "{{ route('turnos.available') }}";
    window.turnosStoreRoute = "{{ route('turnos.store') }}";
    </script>
    @vite(['resources/js/Home/inicio.js'])
@endsection

@push('scripts')
<script>
// Solo cargar librerías pesadas (GSAP, Three.js) en dispositivos de gama media/alta
if (!window.__DISABLE_3D) {
    (function loadHeavyLibs() {
        var scripts = [
            'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js',
            'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js'
        ];
        scripts.forEach(function(src) {
            var s = document.createElement('script');
            s.src = src;
            s.async = false; // mantener orden
            document.head.appendChild(s);
        });
    })();
}
</script>
@endpush