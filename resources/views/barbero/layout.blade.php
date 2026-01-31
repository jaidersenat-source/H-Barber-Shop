<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="/img/1.png">
    <title>@yield('title', 'Panel Barbero') - H Barber Shop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
@vite(['resources/css/Admin/layout.css'])
    <!-- Skip Link -->
    <a href="#main-content" class="skip-link">Saltar al contenido principal</a>

    <!-- Header Móvil -->
    <header class="mobile-header" role="banner">
        <h1>H Barber Shop</h1>
        <button 
            type="button" 
            class="menu-toggle" 
            id="menu-toggle"
            aria-expanded="false"
            aria-controls="sidebar"
            aria-label="Abrir menú de navegación"
        >
            <span aria-hidden="true">☰</span> Menú
        </button>
    </header>

    <!-- Overlay para móvil -->
    <div class="sidebar-overlay" id="sidebar-overlay" aria-hidden="true"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar" role="navigation" aria-label="Menú principal de administración">
        <!-- Botón cerrar en móvil -->
        <div class="sidebar-close">
            <button 
                type="button" 
                class="close-btn" 
                id="sidebar-close"
                aria-label="Cerrar menú"
            >
                ✕ Cerrar
            </button>
        </div>

        <!-- Header del Sidebar -->
        <div class="sidebar-header" style="text-align:center;">
            <img src="/img/1.png" alt="H Barber Shop Logo" class="sidebar-logo" style="max-width:80px; height:auto; display:block; margin:0 auto 8px auto;">
            <p style="margin:0;">Panel de Barberos</p>
        </div>

        <!-- Navegación Principal -->
        <nav class="sidebar-nav">
            <ul class="nav-list" role="menubar" aria-label="Módulos del sistema">
                <li role="none">
                    <a role="menuitem" href="{{ route('barbero.dashboard') }}" class="nav-link @if(request()->routeIs('barbero.dashboard')) active @endif" @if(request()->routeIs('barbero.dashboard')) aria-current="page" @endif>
                        <span class="nav-icon" aria-hidden="true">🏠</span>
                        Inicio
                    </a>
                </li>
               
               
                <li role="none">
                    <a role="menuitem" href="{{ route('barbero.turnos') }}" class="nav-link @if(request()->routeIs('barbero.turnos.*')) active @endif" @if(request()->routeIs('barbero.turnos.*')) aria-current="page" @endif>
                        <span class="nav-icon" aria-hidden="true">📅</span>
                        Turnos
                    </a>
                </li>
               
                <li role="none">
                    <a role="menuitem" href="{{ route('barbero.horario') }}" class="nav-link @if(request()->routeIs('barbero.horario')) active @endif" @if(request()->routeIs('barbero.horario')) aria-current="page" @endif>
                        <span class="nav-icon" aria-hidden="true">🕒</span>
                        Horario
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Footer del Sidebar: Configuración y Cerrar Sesión -->
        <div class="sidebar-footer">
            <a href="{{ route('barbero.perfil.show') }}" class="config-link @if(request()->routeIs('barbero.perfil.show')) active @endif" @if(request()->routeIs('barbero.perfil.show')) aria-current="page" @endif>
                <span class="nav-icon" aria-hidden="true">⚙️</span>
                Configuración
            </a>
            <form method="POST" action="{{ route('logout') }}" class="logout-form">
                @csrf
                <button type="submit" class="logout-btn" style="background:#a13c3c;color:#ffffff;">
                    <span aria-hidden="true">🚪</span>
                    Cerrar sesión
                </button>
            </form>
        </div>
    </aside>

    <!-- Contenido Principal -->
    <main class="main-content" id="main-content" tabindex="-1" role="main" aria-label="Contenido principal">
        @yield('content')
    </main>

    <!-- JavaScript Accesible -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const menuToggle = document.getElementById('menu-toggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const closeBtn = document.getElementById('sidebar-close');
        const navLinks = Array.from(sidebar.querySelectorAll('.nav-link, .config-link'));

        // Función para abrir menú
        function openMenu() {
            sidebar.classList.add('open');
            overlay.classList.add('active');
            menuToggle.setAttribute('aria-expanded', 'true');
            menuToggle.setAttribute('aria-label', 'Cerrar menú de navegación');
            // Mover foco al primer enlace
            const firstLink = sidebar.querySelector('.nav-link');
            if (firstLink) firstLink.focus();
            // Anunciar para lectores de pantalla
            announceToScreenReader('Menú de navegación abierto');
        }

        // Función para cerrar menú
        function closeMenu() {
            sidebar.classList.remove('open');
            overlay.classList.remove('active');
            menuToggle.setAttribute('aria-expanded', 'false');
            menuToggle.setAttribute('aria-label', 'Abrir menú de navegación');
            menuToggle.focus();
            announceToScreenReader('Menú de navegación cerrado');
        }

        // Anunciar cambios a lectores de pantalla
        function announceToScreenReader(message) {
            let announcement = document.getElementById('sr-announcement');
            if (!announcement) {
                announcement = document.createElement('div');
                announcement.id = 'sr-announcement';
                announcement.setAttribute('role', 'status');
                announcement.setAttribute('aria-live', 'polite');
                announcement.className = 'sr-only';
                document.body.appendChild(announcement);
            }
            announcement.textContent = '';
            setTimeout(function() {
                announcement.textContent = message;
            }, 100);
        }

        // Event listeners
        if (menuToggle) {
            menuToggle.addEventListener('click', function() {
                if (sidebar.classList.contains('open')) {
                    closeMenu();
                } else {
                    openMenu();
                }
            });
        }

        if (closeBtn) {
            closeBtn.addEventListener('click', closeMenu);
        }

        if (overlay) {
            overlay.addEventListener('click', closeMenu);
        }

        // Cerrar con Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && sidebar.classList.contains('open')) {
                closeMenu();
            }
        });

        // Navegación con flechas en el menú
        navLinks.forEach(function(link, index) {
            link.addEventListener('keydown', function(e) {
                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    navLinks[(index + 1) % navLinks.length].focus();
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    navLinks[(index - 1 + navLinks.length) % navLinks.length].focus();
                } else if (e.key === 'Home') {
                    e.preventDefault();
                    navLinks[0].focus();
                } else if (e.key === 'End') {
                    e.preventDefault();
                    navLinks[navLinks.length - 1].focus();
                }
            });
        });

        // Trap focus dentro del sidebar cuando está abierto en móvil
        sidebar.addEventListener('keydown', function(e) {
            if (e.key === 'Tab' && sidebar.classList.contains('open')) {
                const focusableElements = sidebar.querySelectorAll('a, button');
                const firstElement = focusableElements[0];
                const lastElement = focusableElements[focusableElements.length - 1];

                if (e.shiftKey && document.activeElement === firstElement) {
                    e.preventDefault();
                    lastElement.focus();
                } else if (!e.shiftKey && document.activeElement === lastElement) {
                    e.preventDefault();
                    firstElement.focus();
                }
            }
        });
    });
    </script>
    
</body>
</html>
