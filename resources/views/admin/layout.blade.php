<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="/img/1.png">
    <title>H Barber Shop — Administración</title>
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
<body class="admin-root">

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
    <aside class="sidebar" id="sidebar" aria-label="Navegación principal">

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
                <span class="brand-subtitle">Panel de administración</span>
            </div>
        </div>

        {{-- Navegación --}}
        <nav class="sidebar-nav" aria-label="Módulos del sistema">

            <p class="nav-section-label" aria-hidden="true">General</p>
            <ul class="nav-list" role="list">
                <li>
                    <a href="{{ route('admin.dashboard') }}"
                       class="nav-link @if(request()->routeIs('admin.dashboard')) active @endif"
                       @if(request()->routeIs('admin.dashboard')) aria-current="page" @endif>
                        <span class="nav-icon" aria-hidden="true">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" focusable="false"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
                        </span>
                        <span class="nav-label">Inicio</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.reportes.general') }}"
                       class="nav-link @if(request()->routeIs('admin.reportes.general')) active @endif"
                       @if(request()->routeIs('admin.reportes.general')) aria-current="page" @endif>
                        <span class="nav-icon" aria-hidden="true">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" focusable="false"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                        </span>
                        <span class="nav-label">Reporte general</span>
                    </a>
                </li>
            </ul>

            <p class="nav-section-label" aria-hidden="true">Operaciones</p>
            <ul class="nav-list" role="list">
                <li>
                    <a href="{{ route('personal.index') }}"
                       class="nav-link @if(request()->routeIs('personal.*')) active @endif"
                       @if(request()->routeIs('personal.*')) aria-current="page" @endif>
                        <span class="nav-icon" aria-hidden="true">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" focusable="false"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </span>
                        <span class="nav-label">Personal</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('sedes.index') }}"
                       class="nav-link @if(request()->routeIs('sedes.*')) active @endif"
                       @if(request()->routeIs('sedes.*')) aria-current="page" @endif>
                        <span class="nav-icon" aria-hidden="true">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" focusable="false"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                        </span>
                        <span class="nav-label">Sedes</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('turnos.index') }}"
                       class="nav-link @if(request()->routeIs('turnos.*')) active @endif"
                       @if(request()->routeIs('turnos.*')) aria-current="page" @endif>
                        <span class="nav-icon" aria-hidden="true">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" focusable="false"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        </span>
                        <span class="nav-label">Turnos</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('disponibilidad.index') }}"
                       class="nav-link @if(request()->routeIs('disponibilidad.*')) active @endif"
                       @if(request()->routeIs('disponibilidad.*')) aria-current="page" @endif>
                        <span class="nav-icon" aria-hidden="true">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" focusable="false"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        </span>
                        <span class="nav-label">Disponibilidad</span>
                    </a>
                </li>
            </ul>

            <p class="nav-section-label" aria-hidden="true">Catálogo</p>
            <ul class="nav-list" role="list">
                <li>
                    <a href="{{ route('servicios.index') }}"
                       class="nav-link @if(request()->routeIs('servicios.*')) active @endif"
                       @if(request()->routeIs('servicios.*')) aria-current="page" @endif>
                        <span class="nav-icon" aria-hidden="true">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" focusable="false"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                        </span>
                        <span class="nav-label">Servicios</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('productos.index') }}"
                       class="nav-link @if(request()->routeIs('productos.*')) active @endif"
                       @if(request()->routeIs('productos.*')) aria-current="page" @endif>
                        <span class="nav-icon" aria-hidden="true">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" focusable="false"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
                        </span>
                        <span class="nav-label">Productos</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('membresias.index') }}"
                       class="nav-link @if(request()->routeIs('membresias.*')) active @endif"
                       @if(request()->routeIs('membresias.*')) aria-current="page" @endif>
                        <span class="nav-icon" aria-hidden="true">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" focusable="false"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        </span>
                        <span class="nav-label">Membresías</span>
                    </a>
                </li>
            </ul>

            <p class="nav-section-label" aria-hidden="true">Clientes</p>
            <ul class="nav-list" role="list">
                <li>
                    <a href="{{ route('crm.clientes') }}"
                       class="nav-link @if(request()->routeIs('crm.*')) active @endif"
                       @if(request()->routeIs('crm.*')) aria-current="page" @endif>
                        <span class="nav-icon" aria-hidden="true">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" focusable="false"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        </span>
                        <span class="nav-label">CRM</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('fidelizacion.index') }}"
                       class="nav-link @if(request()->routeIs('fidelizacion.*')) active @endif"
                       @if(request()->routeIs('fidelizacion.*')) aria-current="page" @endif>
                        <span class="nav-icon" aria-hidden="true">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" focusable="false"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                        </span>
                        <span class="nav-label">Fidelización</span>
                    </a>
                </li>
            </ul>

            <p class="nav-section-label" aria-hidden="true">Finanzas</p>
            <ul class="nav-list" role="list">
                <li>
                    <a href="{{ route('factura.index') }}"
                       class="nav-link @if(request()->routeIs('factura.*')) active @endif"
                       @if(request()->routeIs('factura.*')) aria-current="page" @endif>
                        <span class="nav-icon" aria-hidden="true">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" focusable="false"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                        </span>
                        <span class="nav-label">Facturación</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.gastos.index') }}"
                       class="nav-link @if(request()->routeIs('admin.gastos.*') || request()->routeIs('admin.categorias-gastos.*')) active @endif"
                       @if(request()->routeIs('admin.gastos.*') || request()->routeIs('admin.categorias-gastos.*')) aria-current="page" @endif>
                        <span class="nav-icon" aria-hidden="true">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" focusable="false"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                        </span>
                        <span class="nav-label">Gastos</span>
                    </a>
                </li>
            </ul>

            <p class="nav-section-label" aria-hidden="true">Contenido</p>
            <ul class="nav-list" role="list">
                <li>
                    <a href="{{ route('admin.blog.index') }}"
                       class="nav-link @if(request()->routeIs('admin.blog.*')) active @endif"
                       @if(request()->routeIs('admin.blog.*')) aria-current="page" @endif>
                        <span class="nav-icon" aria-hidden="true">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" focusable="false"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        </span>
                        <span class="nav-label">Blog</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.comments.index') }}"
                       class="nav-link @if(request()->routeIs('admin.comments.*')) active @endif"
                       @if(request()->routeIs('admin.comments.*')) aria-current="page" @endif>
                        <span class="nav-icon" aria-hidden="true">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" focusable="false"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        </span>
                        <span class="nav-label">Comentarios</span>
                        @if($pendingComments > 0)
                            <span class="nav-badge" aria-label="{{ $pendingComments }} comentarios pendientes">{{ $pendingComments }}</span>
                        @endif
                    </a>
                </li>
            </ul>

        </nav>

        {{-- Footer del sidebar --}}
        <div class="sidebar-footer">
              <a href="{{ route('perfil.show') }}"
                  class="footer-link admin-footer-link @if(request()->routeIs('perfil.show')) active @endif"
                  @if(request()->routeIs('perfil.show')) aria-current="page" @endif>
                <span class="nav-icon" aria-hidden="true">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" focusable="false"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                </span>
                <span>Configuración</span>
            </a>
            <button type="button" class="logout-btn admin-logout-btn" data-logout-url="{{ route('logout') }}" onclick="performLogout(this)">
                <span class="nav-icon" aria-hidden="true">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" focusable="false"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                </span>
                <span>Cerrar sesión</span>
            </button>
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

    <script>
    function performLogout(button) {
        const url = button.dataset.logoutUrl;
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': token,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'text/html'
            },
            credentials: 'same-origin'
        }).then(response => {
            // If server redirects, follow; otherwise reload or go to home
            if (response.redirected) window.location.href = response.url;
            else window.location.reload();
        }).catch(() => { window.location.href = '/'; });
    }
    </script>

<!-- Small inline overrides loaded last to protect logout form from per-view CSS (no new files) -->
<style>
/* Target only the logout form in the admin sidebar to avoid breaking other buttons */
.admin-root #sidebar .sidebar-footer .logout-form,
.admin-root #sidebar .sidebar-footer .logout-form > .admin-logout-btn {
    display: inline-flex !important;
    align-items: center !important;
    gap: 11px !important;
    width: auto !important;
    min-height: 40px !important;
    padding: 9px 10px !important;
    background: transparent !important;
    color: var(--text-on-dark) !important;
    border-radius: 7px !important;
    border: 1px solid transparent !important;
    font-size: 0.85rem !important;
    font-weight: 400 !important;
    line-height: 1 !important;
    text-transform: none !important;
    box-shadow: none !important;
    text-align: left !important;
}

/* Match hover/active/focus states of .footer-link */
.admin-root #sidebar .sidebar-footer .logout-form > .admin-logout-btn:hover,
.admin-root #sidebar .sidebar-footer .logout-form > .admin-logout-btn:focus {
    background: var(--coal-3) !important;
    color: #fff !important;
}

/* Ensure icon opacity matches nav links */
.admin-root #sidebar .sidebar-footer .logout-form .nav-icon,
.admin-root #sidebar .sidebar-footer .footer-link .nav-icon {
    opacity: 0.7;
}
.admin-root #sidebar .sidebar-footer .logout-form > .admin-logout-btn:hover .nav-icon,
.admin-root #sidebar .sidebar-footer .footer-link:hover .nav-icon {
    opacity: 1;
}
</style>

</body>
</html>