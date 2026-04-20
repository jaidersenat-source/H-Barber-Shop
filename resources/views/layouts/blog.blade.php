<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-M7WB9VRJ');</script>
    <!-- End Google Tag Manager -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    {{-- SEO Meta Tags --}}
    @php
        $defaultTitles = [
            'welcome' => 'Inicio | H Barber Shop',
            'servicios' => 'Servicios | H Barber Shop',
            'public.membresias' => 'Membresías | H Barber Shop',
            'productos' => 'Productos | H Barber Shop',
            'nosotros' => 'Nosotros | H Barber Shop',
            'contacto' => 'Contacto | H Barber Shop',
            'fidelizacion' => 'Programa de Fidelización | H Barber Shop',
            'agendar' => 'Agendar Cita | H Barber Shop',
            'blog.index' => 'Blog | H Barber Shop',
        ];
        $currentRoute = Route::currentRouteName();
        $defaultTitle = $defaultTitles[$currentRoute] ?? 'H Barber Shop';
    @endphp
    <title>{{ $seo['title'] ?? $defaultTitle }}</title>
    <meta name="description" content="{{ $seo['description'] ?? 'H Barber Shop - Barbería Premium en Neiva' }}">
    @if(!empty($seo['keywords']))
    <meta name="keywords" content="{{ $seo['keywords'] }}">
    @endif
    <link rel="canonical" href="{{ $seo['canonical'] ?? url()->current() }}">
    
    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="{{ $seo['canonical'] ?? url()->current() }}">
    <meta property="og:title" content="{{ $seo['title'] ?? $defaultTitle }}">
    <meta property="og:description" content="{{ $seo['description'] ?? 'H Barber Shop - Barbería Premium en Neiva' }}">
    @if(!empty($seo['image']))
    <meta property="og:image" content="{{ $seo['image'] }}">
    @endif
    <meta property="og:site_name" content="H Barber Shop">
    <meta property="og:locale" content="es_CO">
    
    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seo['title'] ?? $defaultTitle }}">
    <meta name="twitter:description" content="{{ $seo['description'] ?? 'H Barber Shop - Barbería Premium en Neiva' }}">
    @if(!empty($seo['image']))
    <meta name="twitter:image" content="{{ $seo['image'] }}">
    @endif
    
    {{-- Article specific meta (for blog posts) --}}
    @if(!empty($seo['published_time']))
    <meta property="article:published_time" content="{{ $seo['published_time'] }}">
    @endif
    @if(!empty($seo['modified_time']))
    <meta property="article:modified_time" content="{{ $seo['modified_time'] }}">
    @endif
    @if(!empty($seo['author']))
    <meta property="article:author" content="{{ $seo['author'] }}">
    @endif
    
    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="/img/1.png">
    
    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">
    
    {{-- Vite Assets --}}
   @vite(['resources/css/app.css', 'resources/js/app.js'])
   @vite(['resources/css/nav.css'])
    
    {{-- Accesibilidad para JAWS y lectores de pantalla --}}
    @vite(['resources/css/accessibility.css', 'resources/js/accessibility.js'])

    {{-- Footer --}}
    @vite(['resources/css/footer.css'])

    {{-- Cookie Banner --}}
    @vite(['resources/css/cookie-banner.css'])
    
    @stack('styles')
</head>
@push('styles')
    @vite(['resources/css/Blog/blog.css'])
@endpush
<body lang="es">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M7WB9VRJ" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <!-- Skip Link para accesibilidad -->
    <a href="#main-content" class="skip-link" tabindex="0" aria-label="Saltar al contenido principal">Saltar al contenido principal</a>

   <!-- Navbar -->
    <nav class="navbar" role="navigation" aria-label="Navegación principal">
        <div class="container">
    <div class="nav-logo">
        <a href="{{ route('welcome') }}" style="display: flex; align-items: center; gap: 12px; text-decoration: none;" aria-label="H Barber Shop - Ir al inicio">
    <img src="{{ asset('img/nav2.png') }}" alt="Logo H Barber Shop" width="40" height="40" style="object-fit: contain;">
    
    <!-- ← AGREGA ESTO -->
    <div class="nav-logo-divider"></div>
    <div class="nav-logo-text">
        <span class="nav-logo-top">H BARBER</span>
        <span class="nav-logo-bottom">SHOP</span>
    </div>
</a>
    </div>
            <div class="nav-links" id="navLinks" role="menubar" aria-label="Menú de navegación">
                <a href="{{ route('welcome') }}" class="nav-link {{ Route::currentRouteName() === 'welcome' ? 'active' : '' }}" role="menuitem" @if(Route::currentRouteName() === 'welcome') aria-current="page" @endif>Inicio</a>
                <a href="{{ route('servicios') }}" class="nav-link {{ Route::currentRouteName() === 'servicios' ? 'active' : '' }}" role="menuitem" @if(Route::currentRouteName() === 'servicios') aria-current="page" @endif>Servicios</a>
                <a href="{{ route('public.membresias') }}" class="nav-link {{ Route::currentRouteName() === 'public.membresias' ? 'active' : '' }}" role="menuitem" @if(Route::currentRouteName() === 'public.membresias') aria-current="page" @endif>Membresías</a>
                <a href="{{ route('productos') }}" class="nav-link {{ Route::currentRouteName() === 'productos' ? 'active' : '' }}" role="menuitem" @if(Route::currentRouteName() === 'productos') aria-current="page" @endif>Productos</a>
                <a href="{{ route('blog.index') }}" class="nav-link {{ Route::currentRouteName() === 'blog.index' ? 'active' : '' }}" role="menuitem" @if(Route::currentRouteName() === 'blog.index') aria-current="page" @endif>Blog</a>
                <a href="{{ route('nosotros') }}" class="nav-link {{ Route::currentRouteName() === 'nosotros' ? 'active' : '' }}" role="menuitem" @if(Route::currentRouteName() === 'nosotros') aria-current="page" @endif>Nosotros</a>
                <a href="{{ route('contacto') }}" class="nav-link {{ Route::currentRouteName() === 'contacto' ? 'active' : '' }}" role="menuitem" @if(Route::currentRouteName() === 'contacto') aria-current="page" @endif>Contacto</a>
                <a href="{{ route('fidelizacion') }}" class="nav-link {{ Route::currentRouteName() === 'fidelizacion' ? 'active' : '' }}" role="menuitem" @if(Route::currentRouteName() === 'fidelizacion') aria-current="page" @endif>Fidelización</a>
            </div>
       
            <div class="nav-buttons">
                <a href="{{ route('agendar') }}" class="btn-primary" role="button" aria-label="Agendar una cita en H Barber Shop">Agendar Cita</a>
            <a href="/login" class="nav-login" aria-label="Acceso al panel de administración para personal">
                <i class="fas fa-user-lock" aria-hidden="true"></i>
                <span class="sr-only">Acceso Staff</span>
            </a>
            
            <button class="nav-toggle" id="navToggle" aria-expanded="false" aria-controls="navLinks" aria-label="Abrir menú de navegación">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </button>
        </div>
    </nav>

    <!-- Overlay para cerrar el menú al tocar fuera -->
    <div class="nav-overlay" id="navOverlay" aria-hidden="true"></div>

    
    
    {{-- Page Content --}}
    <main id="main-content" role="main" aria-label="Contenido principal">
    @yield('content')
    </main>
    
    <!-- Footer -->
    <footer class="footer" id="contacto" role="contentinfo" aria-label="Pie de página — H Barber Shop SAS">
        <div class="container">

            <div class="footer-grid">

                {{-- ── Columna 1: Marca + Redes ── --}}
                <div class="footer-col footer-col--brand">
                    <div class="footer-logo">
                        <svg width="44" height="44" viewBox="0 0 50 50" aria-hidden="true" role="presentation">
                            <text x="25" y="38" font-family="Playfair Display" font-size="44" font-weight="700" fill="#D4AF37" text-anchor="middle">H</text>
                        </svg>
                        <span>{{ config('site.empresa.nombre', 'H BARBER SHOP SAS') }}</span>
                    </div>
                    <p>{{ config('site.empresa.eslogan', 'Estilo, precisión y experiencia premium desde 2020') }}</p>

                    {{-- Redes sociales --}}
                    <div class="footer-social" role="group" aria-label="Redes sociales">
                        @if(config('site.redes_sociales.instagram'))
                        <a href="{{ config('site.redes_sociales.instagram') }}" aria-label="Instagram" target="_blank" rel="noopener">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                        </a>
                        @endif
                        @if(config('site.redes_sociales.facebook'))
                        <a href="{{ config('site.redes_sociales.facebook') }}" aria-label="Facebook" target="_blank" rel="noopener">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                        </a>
                        @endif
                        @if(config('site.contacto.whatsapp'))
                        <a href="https://wa.me/{{ config('site.contacto.whatsapp') }}" aria-label="WhatsApp" target="_blank" rel="noopener">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        </a>
                        @endif
                        @if(config('site.redes_sociales.tiktok'))
                        <a href="{{ config('site.redes_sociales.tiktok') }}" aria-label="TikTok" target="_blank" rel="noopener">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>
                        </a>
                        @endif
                        @if(config('site.redes_sociales.youtube'))
                        <a href="{{ config('site.redes_sociales.youtube') }}" aria-label="YouTube" target="_blank" rel="noopener">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        </a>
                        @endif
                    </div>
                </div>

                {{-- ── Columna 2: Enlaces rápidos ── --}}
                <div class="footer-col">
                    <h4 id="footer-nav">Navegación</h4>
                    <ul aria-labelledby="footer-nav">
                        <li><a href="{{ route('servicios') }}">Servicios</a></li>
                        <li><a href="{{ route('public.membresias') }}">Membresías</a></li>
                        <li><a href="{{ route('productos') }}">Productos</a></li>
                        <li><a href="{{ route('blog.index') }}">Blog</a></li>
                        <li><a href="{{ route('nosotros') }}">Nosotros</a></li>
                        <li><a href="{{ route('agendar') }}">Agendar cita</a></li>
                    </ul>
                </div>

                {{-- ── Columna 3: Contacto ── --}}
                <div class="footer-col">
                    <h4 id="footer-contacto-title">Contacto</h4>
                    <ul aria-labelledby="footer-contacto-title">
                        <li>{{ config('site.contacto.direccion', 'Calle 50 #21A-05') }}</li>
                        <li>{{ config('site.contacto.ciudad', 'Neiva, Huila, Colombia') }}</li>
                        <li><a href="tel:{{ config('site.contacto.whatsapp', '573118104544') }}">{{ config('site.contacto.telefono', '+57 311 810 4544') }}</a></li>
                        <li><a href="mailto:{{ config('site.contacto.email', 'hbarbershopsas@gmail.com') }}">{{ config('site.contacto.email', 'hbarbershopsas@gmail.com') }}</a></li>
                    </ul>
                </div>

                {{-- ── Columna 4: Horarios ── --}}
                <div class="footer-col">
                    <h4 id="footer-horarios">Horarios</h4>
                    <ul aria-labelledby="footer-horarios">
                        <li>Lun – Vie: {{ config('site.horarios.lunes_viernes', '9:00 – 20:30') }}</li>
                        <li>Sábados: {{ config('site.horarios.sabados', '9:00 – 20:30') }}</li>
                        <li>Domingos: {{ config('site.horarios.domingos', 'Cerrado') }}</li>
                    </ul>
                </div>

                {{-- ── Columna 5: SENA ── --}}
                <div class="footer-col footer-col--sena">
                    <h4>Financiado por</h4>
                    <div class="footer-sena">
                        <div class="sena-badge" aria-label="Proyecto financiado por el SENA">
                            <!-- Reemplazar con la imagen oficial del SENA en public/img/sena-logo.png -->
                            <img src="{{ asset('img/sena-logo.png') }}" alt="Logo SENA" class="sena-logo-img">
                            <div class="sena-badge-info">
                                <strong>Proyecto SENA</strong>
                                <span>Servicio Nacional de Aprendizaje</span>
                            </div>
                        </div>
                        <p>Este proyecto fue financiado y apoyado por el SENA como parte del programa de formación tecnológica en desarrollo de software.</p>
                    </div>
                </div>

            </div>{{-- /.footer-grid --}}

            <div class="footer-divider" aria-hidden="true"></div>

            {{-- Barra inferior --}}
            <div class="footer-bottom">
                <div class="footer-bottom-left">
                    <p class="footer-copyright">&copy; {{ date('Y') }} H Barber Shop SAS. Todos los derechos reservados.</p>
                    <div class="footer-legal-links" aria-label="Políticas y términos legales">
                        <a href="{{ route('politicas') }}" aria-label="Políticas Legales y Privacidad">Políticas Legales &amp; Privacidad</a>
                        <span class="sep" aria-hidden="true">|</span>
                        <a href="{{ route('politicas') }}#datos-personales">Tratamiento de Datos</a>
                        <span class="sep" aria-hidden="true">|</span>
                        <a href="{{ route('politicas') }}#privacidad-cookies">Cookies</a>
                        <span class="sep" aria-hidden="true">|</span>
                        <a href="{{ route('politicas') }}#terminos-condiciones">Términos de Uso</a>
                    </div>
                </div>

                <div class="footer-dev" aria-label="Crédito del desarrollador">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                    Desarrollado por
                    <a href="https://my-portfolio-sooty-nine-14.vercel.app/" target="_blank" rel="noopener" aria-label="Portafolio de JAIDERCODE">JAIDERCODE</a>
                </div>
            </div>

        </div>
    </footer>
    
    @stack('scripts')

    <!-- ═══════════════════════════════════════════
         COOKIE BANNER — H BARBER SHOP S.A.S.
         CSS en: resources/css/cookie-banner.css
    ════════════════════════════════════════════ -->

    <!-- Banner -->
    <div id="cookie-banner" role="dialog" aria-modal="false" aria-label="Aviso de consentimiento de cookies">
        <div id="cookie-banner-inner">
            <div id="cookie-banner-icon" aria-hidden="true">🍪</div>
            <div id="cookie-banner-text">
                <p>
                    <strong>Este sitio usa cookies.</strong>
                    Utilizamos cookies propias y de terceros (<em>Google Analytics</em> y <em>Píxel de Meta</em>) para mejorar tu experiencia y analizar el tráfico.
                    <a href="{{ route('politicas') }}#privacidad-cookies" target="_blank" rel="noopener" aria-label="Ver política de cookies">Más información</a>.
                </p>
            </div>
            <div id="cookie-banner-btns">
                <button id="cookie-config-btn" class="cookie-btn cookie-btn--ghost"
                        aria-label="Configurar preferencias de cookies">
                    Configurar
                </button>
                <button id="cookie-accept-btn" class="cookie-btn cookie-btn--primary"
                        aria-label="Aceptar todas las cookies">
                    Aceptar todas
                </button>
            </div>
        </div>
    </div>

    <!-- Modal configuración -->
    <div id="cookie-config-modal" role="dialog" aria-modal="true" aria-labelledby="cookie-modal-title">
        <div id="cookie-modal-box">

            <div class="cookie-modal-header">
                <div class="cookie-modal-logo" aria-hidden="true">H</div>
                <div>
                    <h2 id="cookie-modal-title">Preferencias de cookies</h2>
                    <p>H Barber Shop SAS &mdash; Ley 1581 de 2012</p>
                </div>
            </div>

            <div class="cookie-divider" aria-hidden="true"></div>

            <!-- Esenciales -->
            <div class="cookie-row" aria-label="Cookies esenciales, siempre activas">
                <div class="cookie-row-info">
                    <div class="cookie-row-title">
                        🔒 Esenciales
                    </div>
                    <div class="cookie-row-desc">Necesarias para el funcionamiento básico del sitio y el formulario de agendamiento.</div>
                </div>
                <span class="cookie-badge-always" aria-label="Siempre activas">Siempre activas</span>
            </div>

            <!-- Analíticas -->
            <div class="cookie-row" aria-label="Cookies analíticas de Google Analytics">
                <div class="cookie-row-info">
                    <div class="cookie-row-title">📊 Google Analytics</div>
                    <div class="cookie-row-desc">Análisis anónimo del tráfico para mejorar el sitio.</div>
                </div>
                <label class="cookie-toggle" aria-label="Activar cookies analíticas">
                    <input type="checkbox" id="cookie-analytics">
                    <span class="cookie-toggle-track"></span>
                    <span class="cookie-toggle-thumb"></span>
                </label>
            </div>

            <!-- Marketing -->
            <div class="cookie-row" aria-label="Cookies de marketing del Píxel de Meta">
                <div class="cookie-row-info">
                    <div class="cookie-row-title">📢 Píxel de Meta</div>
                    <div class="cookie-row-desc">Personalización de publicidad en Facebook e Instagram.</div>
                </div>
                <label class="cookie-toggle" aria-label="Activar cookies de marketing">
                    <input type="checkbox" id="cookie-marketing">
                    <span class="cookie-toggle-track"></span>
                    <span class="cookie-toggle-thumb"></span>
                </label>
            </div>

            <button id="cookie-save-btn" class="cookie-btn--save"
                    aria-label="Guardar mis preferencias de cookies">
                Guardar preferencias
            </button>

            <p class="cookie-legal-note">
                Puedes cambiar tus preferencias en cualquier momento.<br>
                <a href="{{ route('politicas') }}#privacidad-cookies" target="_blank" rel="noopener">Ver política de cookies completa</a>
            </p>
        </div>
    </div>

    <script>
    (function () {
        var COOKIE_KEY = 'hbs_cookie_consent';
        var banner = document.getElementById('cookie-banner');
        var modal  = document.getElementById('cookie-config-modal');
        var saved  = null;

        try { saved = JSON.parse(localStorage.getItem(COOKIE_KEY)); } catch(e) {}

        if (saved) {
            applyConsent(saved);
        } else {
            banner.style.display = 'block';
        }

        document.getElementById('cookie-accept-btn').addEventListener('click', function () {
            save({ analytics: true, marketing: true, ts: Date.now() });
        });

        document.getElementById('cookie-config-btn').addEventListener('click', function () {
            if (saved) {
                setToggle('analytics', saved.analytics);
                setToggle('marketing', saved.marketing);
            }
            modal.style.display = 'flex';
            document.getElementById('cookie-modal-box').focus();
        });

        document.getElementById('cookie-save-btn').addEventListener('click', function () {
            var consent = {
                analytics: document.getElementById('cookie-analytics').checked,
                marketing: document.getElementById('cookie-marketing').checked,
                ts: Date.now()
            };
            save(consent);
            modal.style.display = 'none';
        });

        modal.addEventListener('click', function (e) {
            if (e.target === modal) modal.style.display = 'none';
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modal.style.display === 'flex') modal.style.display = 'none';
        });

        // Sincronizar thumb al cambiar checkbox
        ['analytics','marketing'].forEach(function(type) {
            var cb = document.getElementById('cookie-' + type);
            if (!cb) return;
            cb.addEventListener('change', function () {
                syncThumb(cb);
            });
        });

        function setToggle(type, val) {
            var cb = document.getElementById('cookie-' + type);
            if (!cb) return;
            cb.checked = !!val;
            syncThumb(cb);
        }

        function syncThumb(cb) {
            var label = cb.closest('.cookie-toggle');
            if (!label) return;
            var thumb = label.querySelector('.cookie-toggle-thumb');
            if (thumb) thumb.style.transform = cb.checked ? 'translateX(20px)' : '';
        }

        function save(consent) {
            try { localStorage.setItem(COOKIE_KEY, JSON.stringify(consent)); } catch(e) {}
            banner.style.display = 'none';
            applyConsent(consent);
        }

        function applyConsent(consent) {
            if (consent.analytics && typeof window.gtag === 'function') {
                window.gtag('consent', 'update', { analytics_storage: 'granted' });
            }
            if (consent.marketing && typeof window.fbq === 'function') {
                window.fbq('consent', 'grant');
            }
        }
    })();
    </script>

    <!-- ═══════════════════════════════════════════
         GOOGLE ANALYTICS GA4
         Crear en analytics.google.com con hbarbershopsas@gmail.com
         Reemplazar G-XXXXXXXXXX por el ID real y descomentar.
    ════════════════════════════════════════════ -->
    {{-- INSTRUCCION: Descomentar y reemplazar G-XXXXXXXXXX cuando GA4 esté configurado
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXXXXXX"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('consent', 'default', { analytics_storage: 'denied', ad_storage: 'denied' });
        gtag('config', 'G-XXXXXXXXXX');
    </script>
    --}}

    <!-- ═══════════════════════════════════════════
         META PIXEL (Facebook / Instagram)
         Crear en business.facebook.com — Administrador de Eventos
         Reemplazar XXXXXXXXXXXXXXXXXX por el ID real y descomentar.
    ════════════════════════════════════════════ -->
    {{-- INSTRUCCION: Descomentar y reemplazar XXXXXXXXXXXXXXXXXX cuando el Píxel esté creado
    <script>
        !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
        n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
        document,'script','https://connect.facebook.net/en_US/fbevents.js');
        fbq('consent', 'revoke');
        fbq('init', 'XXXXXXXXXXXXXXXXXX');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
        src="https://www.facebook.com/tr?id=XXXXXXXXXXXXXXXXXX&ev=PageView&noscript=1"/></noscript>
    --}}

    <!-- JavaScript para toggle del menú móvil -->
    <script>
    (function() {
        var navToggle = document.getElementById('navToggle');
        var navLinks  = document.querySelector('.nav-links');
        var overlay   = document.getElementById('navOverlay');

        if (!navToggle || !navLinks) return;

        function openMenu() {
            navLinks.classList.add('active');
            navToggle.classList.add('active');
            if (overlay) overlay.classList.add('active');
            document.body.classList.add('nav-open');
            navToggle.setAttribute('aria-expanded', 'true');
            navToggle.setAttribute('aria-label', 'Cerrar menú de navegación');
        }

        function closeMenu() {
            navLinks.classList.remove('active');
            navToggle.classList.remove('active');
            if (overlay) overlay.classList.remove('active');
            document.body.classList.remove('nav-open');
            navToggle.setAttribute('aria-expanded', 'false');
            navToggle.setAttribute('aria-label', 'Abrir menú de navegación');
        }

        // Abrir / cerrar con la hamburguesa
        navToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            navLinks.classList.contains('active') ? closeMenu() : openMenu();
        });

        // Cerrar al tocar el overlay (click y touch)
        if (overlay) {
            overlay.addEventListener('click', closeMenu);
            overlay.addEventListener('touchstart', closeMenu, { passive: true });
        }

        // Cerrar al tocar FUERA del panel (fallback para cualquier browser)
        document.addEventListener('click', function(e) {
            if (navLinks.classList.contains('active') &&
                !navLinks.contains(e.target) &&
                !navToggle.contains(e.target)) {
                closeMenu();
            }
        });

        // Igual para touch
        document.addEventListener('touchstart', function(e) {
            if (navLinks.classList.contains('active') &&
                !navLinks.contains(e.target) &&
                !navToggle.contains(e.target)) {
                closeMenu();
            }
        }, { passive: true });

        // Cerrar al hacer clic en un enlace del menú
        navLinks.querySelectorAll('a').forEach(function(link) {
            link.addEventListener('click', closeMenu);
        });
    })();
    </script>
</body>
</html>
