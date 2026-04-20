<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="/img/1.png">
    <title>@yield('title', 'Panel Barbero') — H Barber Shop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite(['resources/css/Admin/layout.css'])
</head>
<body>

    {{-- Skip link para lectores de pantalla --}}
    <a href="#main-content" class="skip-link">Saltar al contenido principal</a>

    {{-- Anuncio en vivo para lectores de pantalla --}}
    <div id="sr-live" role="status" aria-live="polite" aria-atomic="true" class="sr-only"></div>

    {{-- Header móvil --}}
    <header class="mobile-header" role="banner">
        <div class="mobile-brand">
            <img src="/img/2.png" alt="H Barber Shop" class="mobile-logo">
            <span class="mobile-title">H Barber Shop</span>
        </div>
        <button
            type="button"
            class="menu-toggle"
            id="menu-toggle"
            aria-expanded="false"
            aria-controls="sidebar"
            aria-label="Abrir menú de navegación"
        >
            <span class="hamburger" aria-hidden="true">
                <span></span>
                <span></span>
                <span></span>
            </span>
            <span class="toggle-label">Menú</span>
        </button>
    </header>

    {{-- Overlay móvil --}}
    <div class="sidebar-overlay" id="sidebar-overlay" aria-hidden="true"></div>

    {{-- Sidebar --}}
    <aside class="sidebar" id="sidebar" aria-label="Navegación del panel de barberos">

        {{-- Botón cerrar (solo móvil) --}}
        <div class="sidebar-close" role="none">
            <button
                type="button"
                class="close-btn"
                id="sidebar-close"
                aria-label="Cerrar menú de navegación"
            >
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true" focusable="false">
                    <path d="M2 2l12 12M14 2L2 14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
                Cerrar
            </button>
        </div>

        {{-- Marca en sidebar --}}
        <div class="sidebar-brand">
            <img src="/img/2.png" alt="H Barber Shop Logo" class="sidebar-logo">
            <div class="sidebar-brand-text">
                <span class="brand-name">H Barber Shop</span>
                <span class="brand-subtitle">Panel de barberos</span>
            </div>
        </div>

        {{-- Navegación --}}
        <nav class="sidebar-nav" aria-label="Módulos del panel de barberos">

            <p class="nav-section-label" aria-hidden="true">General</p>
            <ul class="nav-list" role="list">
                <li>
                    <a href="{{ route('barbero.dashboard') }}"
                       class="nav-link @if(request()->routeIs('barbero.dashboard')) active @endif"
                       @if(request()->routeIs('barbero.dashboard')) aria-current="page" @endif>
                        <span class="nav-icon" aria-hidden="true">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" focusable="false"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
                        </span>
                        <span class="nav-label">Inicio</span>
                    </a>
                </li>
            </ul>

            <p class="nav-section-label" aria-hidden="true">Mi trabajo</p>
            <ul class="nav-list" role="list">
                <li>
                    <a href="{{ route('barbero.turnos') }}"
                       class="nav-link @if(request()->routeIs('barbero.turnos*')) active @endif"
                       @if(request()->routeIs('barbero.turnos*')) aria-current="page" @endif>
                        <span class="nav-icon" aria-hidden="true">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" focusable="false"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        </span>
                        <span class="nav-label">Turnos</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('barbero.horario') }}"
                       class="nav-link @if(request()->routeIs('barbero.horario')) active @endif"
                       @if(request()->routeIs('barbero.horario')) aria-current="page" @endif>
                        <span class="nav-icon" aria-hidden="true">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" focusable="false"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        </span>
                        <span class="nav-label">Horario</span>
                    </a>
                </li>
            </ul>

        </nav>

        {{-- Footer del sidebar --}}
        <div class="sidebar-footer">
            <a href="{{ route('barbero.perfil.show') }}"
               class="footer-link @if(request()->routeIs('barbero.perfil.show')) active @endif"
               @if(request()->routeIs('barbero.perfil.show')) aria-current="page" @endif>
                <span class="nav-icon" aria-hidden="true">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" focusable="false"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                </span>
                <span>Configuración</span>
            </a>
            <form method="POST" action="{{ route('logout') }}" class="logout-form">
                @csrf
                <button type="submit" class="logout-btn">
                    <span class="nav-icon" aria-hidden="true">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" focusable="false"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    </span>
                    <span>Cerrar sesión</span>
                </button>
            </form>
        </div>

    </aside>

    {{-- Contenido principal --}}
    <main class="main-content" id="main-content" tabindex="-1" role="main" aria-label="Contenido principal">
        @yield('content')
    </main>

    <script>
    document.addEventListener('DOMContentLoaded', function () {

        const menuToggle = document.getElementById('menu-toggle');
        const sidebar    = document.getElementById('sidebar');
        const overlay    = document.getElementById('sidebar-overlay');
        const closeBtn   = document.getElementById('sidebar-close');
        const srLive     = document.getElementById('sr-live');
        const navLinks   = Array.from(sidebar.querySelectorAll('.nav-link, .footer-link, .logout-btn'));

        function announce(msg) {
            srLive.textContent = '';
            requestAnimationFrame(() => { srLive.textContent = msg; });
        }

        function openMenu() {
            sidebar.classList.add('open');
            overlay.classList.remove('hidden');
            overlay.removeAttribute('aria-hidden');
            menuToggle.setAttribute('aria-expanded', 'true');
            menuToggle.setAttribute('aria-label', 'Cerrar menú de navegación');
            menuToggle.classList.add('is-open');
            const first = sidebar.querySelector('.nav-link');
            if (first) first.focus();
            announce('Menú de navegación abierto');
        }

        function closeMenu() {
            sidebar.classList.remove('open');
            overlay.classList.add('hidden');
            overlay.setAttribute('aria-hidden', 'true');
            menuToggle.setAttribute('aria-expanded', 'false');
            menuToggle.setAttribute('aria-label', 'Abrir menú de navegación');
            menuToggle.classList.remove('is-open');
            menuToggle.focus();
            announce('Menú de navegación cerrado');
        }

        overlay.classList.add('hidden');

        menuToggle.addEventListener('click', () => sidebar.classList.contains('open') ? closeMenu() : openMenu());
        closeBtn.addEventListener('click', closeMenu);
        overlay.addEventListener('click', closeMenu);

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape' && sidebar.classList.contains('open')) closeMenu();
        });

        navLinks.forEach((link, i) => {
            link.addEventListener('keydown', e => {
                if (e.key === 'ArrowDown') { e.preventDefault(); navLinks[(i + 1) % navLinks.length].focus(); }
                else if (e.key === 'ArrowUp') { e.preventDefault(); navLinks[(i - 1 + navLinks.length) % navLinks.length].focus(); }
                else if (e.key === 'Home') { e.preventDefault(); navLinks[0].focus(); }
                else if (e.key === 'End') { e.preventDefault(); navLinks[navLinks.length - 1].focus(); }
            });
        });

        sidebar.addEventListener('keydown', e => {
            if (e.key === 'Tab' && sidebar.classList.contains('open')) {
                const focusable = sidebar.querySelectorAll('a, button');
                const first = focusable[0];
                const last  = focusable[focusable.length - 1];
                if (e.shiftKey && document.activeElement === first) { e.preventDefault(); last.focus(); }
                else if (!e.shiftKey && document.activeElement === last) { e.preventDefault(); first.focus(); }
            }
        });

        const activeItem = sidebar.querySelector('.nav-link.active, .nav-link[aria-current="page"]');
        if (activeItem) activeItem.scrollIntoView({ block: 'center', behavior: 'auto' });

    });
    </script>

</body>
</html>