<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios - H Barber Shop SAS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/Home/Servicio.css'])
   
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="container">
            <div class="nav-logo">
                <a href="index.html" style="display: flex; align-items: center; gap: 12px; text-decoration: none;">
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none">
                        <text x="20" y="28" font-family="Playfair Display" font-size="32" font-weight="700" fill="#D4AF37" text-anchor="middle">H</text>
                    </svg>
                    <span class="logo-text">H BARBER SHOP</span>
                </a>
            </div>
            <div class="nav-links">
                <a href="{{ route('welcome') }}">Inicio</a>
                <a href="{{ route('servicios') }}" class="active">Servicios</a>
                <a href="{{ route('productos') }}">Productos</a>
                <a href="{{ route('nosotros') }}">Nosotros</a>
                <a href="{{ route('contacto') }}">Contacto</a>
                <a href="{{ route('fidelizacion') }}">Fidelizacion</a>
            </div>
            <div class="nav-buttons">
                <a href="{{ route('agendar') }}">
                <button class="btn-primary">Agendar Cita</button>
                </a>
                 <a href="/login" class="nav-login" title="Acceso Usuarios">
                <i class="fas fa-user-lock"></i>
            </a>
            </div>
            <button class="mobile-menu-btn">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </nav>

    <!-- Hero de Servicios -->
    <section class="services-hero">
        <div class="container">
            <h1>Nuestros Servicios</h1>
            <p>Descubre la experiencia premium en cuidado masculino. Cada servicio está diseñado para brindarte resultados excepcionales.</p>
        </div>
    </section>

    <!-- Categorías -->
    <section class="services-categories">
        <div class="container">
            <div class="categories-wrapper">
                <button class="category-btn active" data-category="all">Todos</button>
                <button class="category-btn" data-category="cortes">Cortes</button>
                <button class="category-btn" data-category="barba">Barba</button>
                <button class="category-btn" data-category="tratamientos">Tratamientos</button>
                <button class="category-btn" data-category="combos">Combos</button>
            </div>
        </div>
    </section>

    <!-- Servicios de Corte -->
    <section class="services-full">
        <div class="container">
            <!-- Cortes de Cabello -->
            <div class="services-section" data-category="cortes">
                <h2 class="services-section-title">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#D4AF37" stroke-width="2">
                        <circle cx="6" cy="6" r="3"/>
                        <circle cx="6" cy="18" r="3"/>
                        <line x1="20" y1="4" x2="8.12" y2="15.88"/>
                        <line x1="14.47" y1="14.48" x2="20" y2="20"/>
                        <line x1="8.12" y1="8.12" x2="12" y2="12"/>
                    </svg>
                    Cortes de Cabello
                </h2>
                <div class="services-list">
                    <div class="service-item">
                        <div class="service-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
                                <circle cx="6" cy="6" r="3"/>
                                <circle cx="6" cy="18" r="3"/>
                                <line x1="20" y1="4" x2="8.12" y2="15.88"/>
                            </svg>
                        </div>
                        <div class="service-details">
                            <h3>Corte Clásico</h3>
                            <p class="description">Corte tradicional con tijera y máquina, incluye lavado y estilizado. Perfecto para un look elegante y profesional.</p>
                            <div class="service-meta">
                                <span class="service-price">$35.000</span>
                                <span class="service-duration">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"/>
                                        <polyline points="12 6 12 12 16 14"/>
                                    </svg>
                                    30 min
                                </span>
                                <button class="btn-reservar">Reservar</button>
                            </div>
                        </div>
                    </div>

                    <div class="service-item">
                        <div class="service-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
                                <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                                <path d="M2 17l10 5 10-5"/>
                                <path d="M2 12l10 5 10-5"/>
                            </svg>
                        </div>
                        <div class="service-details">
                            <h3>Corte Premium</h3>
                            <p class="description">Corte personalizado con técnicas avanzadas, incluye consultoría de estilo, lavado con masaje capilar y estilizado con productos premium.</p>
                            <div class="service-meta">
                                <span class="service-price">$45.000</span>
                                <span class="service-duration">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"/>
                                        <polyline points="12 6 12 12 16 14"/>
                                    </svg>
                                    45 min
                                </span>
                                <button class="btn-reservar">Reservar</button>
                            </div>
                        </div>
                    </div>

                    <div class="service-item">
                        <div class="service-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                            </svg>
                        </div>
                        <div class="service-details">
                            <h3>Corte Fade / Degradado</h3>
                            <p class="description">Especialidad de la casa. Degradado perfecto con transiciones suaves, desde low fade hasta high fade según tu preferencia.</p>
                            <div class="service-meta">
                                <span class="service-price">$40.000</span>
                                <span class="service-duration">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"/>
                                        <polyline points="12 6 12 12 16 14"/>
                                    </svg>
                                    40 min
                                </span>
                                <button class="btn-reservar">Reservar</button>
                            </div>
                        </div>
                    </div>

                    <div class="service-item">
                        <div class="service-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
                                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                            </svg>
                        </div>
                        <div class="service-details">
                            <h3>Corte Infantil</h3>
                            <p class="description">Corte especializado para niños menores de 12 años. Ambiente amigable y paciencia garantizada.</p>
                            <div class="service-meta">
                                <span class="service-price">$25.000</span>
                                <span class="service-duration">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"/>
                                        <polyline points="12 6 12 12 16 14"/>
                                    </svg>
                                    25 min
                                </span>
                                <button class="btn-reservar">Reservar</button>
                            </div>
                        </div>
                    </div>

                    <div class="service-item">
                        <div class="service-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
                                <path d="M12 20h9"/>
                                <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
                            </svg>
                        </div>
                        <div class="service-details">
                            <h3>Diseño / Arte en Cabello</h3>
                            <p class="description">Diseños personalizados, líneas, figuras geométricas o logotipos. Expresa tu estilo único con arte en tu cabello.</p>
                            <div class="service-meta">
                                <span class="service-price">Desde $15.000</span>
                                <span class="service-duration">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"/>
                                        <polyline points="12 6 12 12 16 14"/>
                                    </svg>
                                    15-30 min
                                </span>
                                <button class="btn-reservar">Reservar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Servicios de Barba -->
            <div class="services-section" data-category="barba">
                <h2 class="services-section-title">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#D4AF37" stroke-width="2">
                        <path d="M6 2v6a6 6 0 0 0 12 0V2"/>
                        <path d="M12 14v8"/>
                        <path d="M8 22h8"/>
                    </svg>
                    Servicios de Barba
                </h2>
                <div class="services-list">
                    <div class="service-item">
                        <div class="service-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
                                <path d="M6 2v6a6 6 0 0 0 12 0V2"/>
                            </svg>
                        </div>
                        <div class="service-details">
                            <h3>Arreglo de Barba</h3>
                            <p class="description">Perfilado y arreglo completo de barba con máquina y tijera. Incluye definición de líneas y contornos.</p>
                            <div class="service-meta">
                                <span class="service-price">$25.000</span>
                                <span class="service-duration">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"/>
                                        <polyline points="12 6 12 12 16 14"/>
                                    </svg>
                                    20 min
                                </span>
                                <button class="btn-reservar">Reservar</button>
                            </div>
                        </div>
                    </div>

                    <div class="service-item">
                        <div class="service-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                <line x1="16" y1="2" x2="16" y2="6"/>
                                <line x1="8" y1="2" x2="8" y2="6"/>
                            </svg>
                        </div>
                        <div class="service-details">
                            <h3>Afeitado Clásico con Navaja</h3>
                            <p class="description">Experiencia tradicional de afeitado con navaja caliente, toallas calientes y productos premium. El ritual completo del caballero.</p>
                            <div class="service-meta">
                                <span class="service-price">$35.000</span>
                                <span class="service-duration">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"/>
                                        <polyline points="12 6 12 12 16 14"/>
                                    </svg>
                                    30 min
                                </span>
                                <button class="btn-reservar">Reservar</button>
                            </div>
                        </div>
                    </div>

                    <div class="service-item">
                        <div class="service-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                            </svg>
                        </div>
                        <div class="service-details">
                            <h3>Barba Premium</h3>
                            <p class="description">Servicio completo: arreglo con navaja, aplicación de aceites nutritivos, masaje facial y toalla caliente.</p>
                            <div class="service-meta">
                                <span class="service-price">$45.000</span>
                                <span class="service-duration">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"/>
                                        <polyline points="12 6 12 12 16 14"/>
                                    </svg>
                                    40 min
                                </span>
                                <button class="btn-reservar">Reservar</button>
                            </div>
                        </div>
                    </div>

                    <div class="service-item">
                        <div class="service-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/>
                                <path d="M8 14s1.5 2 4 2 4-2 4-2"/>
                                <line x1="9" y1="9" x2="9.01" y2="9"/>
                                <line x1="15" y1="9" x2="15.01" y2="9"/>
                            </svg>
                        </div>
                        <div class="service-details">
                            <h3>Cejas y Contornos</h3>
                            <p class="description">Perfilado de cejas y definición de contornos faciales para un look más limpio y definido.</p>
                            <div class="service-meta">
                                <span class="service-price">$15.000</span>
                                <span class="service-duration">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"/>
                                        <polyline points="12 6 12 12 16 14"/>
                                    </svg>
                                    15 min
                                </span>
                                <button class="btn-reservar">Reservar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tratamientos -->
            <div class="services-section" data-category="tratamientos">
                <h2 class="services-section-title">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#D4AF37" stroke-width="2">
                        <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/>
                    </svg>
                    Tratamientos Especiales
                </h2>
                <div class="services-list">
                    <div class="service-item">
                        <div class="service-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
                                <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/>
                            </svg>
                        </div>
                        <div class="service-details">
                            <h3>Tratamiento Capilar Hidratante</h3>
                            <p class="description">Hidratación profunda para cabello seco o maltratado. Incluye masaje capilar y aplicación de mascarilla nutritiva.</p>
                            <div class="service-meta">
                                <span class="service-price">$50.000</span>
                                <span class="service-duration">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"/>
                                        <polyline points="12 6 12 12 16 14"/>
                                    </svg>
                                    45 min
                                </span>
                                <button class="btn-reservar">Reservar</button>
                            </div>
                        </div>
                    </div>

                    <div class="service-item">
                        <div class="service-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
                                <circle cx="12" cy="12" r="5"/>
                                <line x1="12" y1="1" x2="12" y2="3"/>
                                <line x1="12" y1="21" x2="12" y2="23"/>
                                <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/>
                                <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
                                <line x1="1" y1="12" x2="3" y2="12"/>
                                <line x1="21" y1="12" x2="23" y2="12"/>
                                <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/>
                                <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
                            </svg>
                        </div>
                        <div class="service-details">
                            <h3>Tratamiento Facial</h3>
                            <p class="description">Limpieza facial profunda, exfoliación, mascarilla purificante y masaje relajante. Tu piel como nueva.</p>
                            <div class="service-meta">
                                <span class="service-price">$55.000</span>
                                <span class="service-duration">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"/>
                                        <polyline points="12 6 12 12 16 14"/>
                                    </svg>
                                    50 min
                                </span>
                                <button class="btn-reservar">Reservar</button>
                            </div>
                        </div>
                    </div>

                    <div class="service-item">
                        <div class="service-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
                                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                            </svg>
                        </div>
                        <div class="service-details">
                            <h3>Tratamiento Anticaída</h3>
                            <p class="description">Tratamiento especializado para fortalecer el cabello y prevenir la caída. Incluye diagnóstico capilar.</p>
                            <div class="service-meta">
                                <span class="service-price">$70.000</span>
                                <span class="service-duration">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"/>
                                        <polyline points="12 6 12 12 16 14"/>
                                    </svg>
                                    60 min
                                </span>
                                <button class="btn-reservar">Reservar</button>
                            </div>
                        </div>
                    </div>

                    <div class="service-item">
                        <div class="service-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
                                <path d="M5 3v4M3 5h4M6 17v4M4 19h4M13 3l2 2-2 2M19 13l2 2-2 2M21 3l-9.5 9.5"/>
                                <circle cx="7.5" cy="16.5" r="2.5"/>
                            </svg>
                        </div>
                        <div class="service-details">
                            <h3>Coloración / Tinte</h3>
                            <p class="description">Coloración profesional para cabello o barba. Cubre canas o cambia tu look con colores naturales o atrevidos.</p>
                            <div class="service-meta">
                                <span class="service-price">Desde $60.000</span>
                                <span class="service-duration">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"/>
                                        <polyline points="12 6 12 12 16 14"/>
                                    </svg>
                                    60-90 min
                                </span>
                                <button class="btn-reservar">Reservar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Combos Especiales -->
    <section class="combos-section" data-category="combos">
        <div class="container">
            <h2 class="section-title">Combos Especiales</h2>
            <div class="combo-cards">
                <div class="combo-card">
                    <div class="combo-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
                            <circle cx="6" cy="6" r="3"/>
                            <circle cx="6" cy="18" r="3"/>
                            <line x1="20" y1="4" x2="8.12" y2="15.88"/>
                        </svg>
                    </div>
                    <h3>Combo Básico</h3>
                    <p class="combo-description">El clásico combo para mantenerte siempre impecable.</p>
                    <div class="combo-includes">
                        <h4>Incluye:</h4>
                        <ul>
                            <li>
                                <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                                Corte Clásico
                            </li>
                            <li>
                                <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                                Arreglo de Barba
                            </li>
                            <li>
                                <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                                Lavado y Estilizado
                            </li>
                        </ul>
                    </div>
                    <div class="combo-price">
                        <span class="old-price">$60.000</span>
                        <span class="current-price">$52.000</span>
                    </div>
                    <button class="btn-reservar">Reservar Combo</button>
                </div>

                <div class="combo-card featured">
                    <span class="combo-badge">Popular</span>
                    <div class="combo-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                        </svg>
                    </div>
                    <h3>Combo Premium</h3>
                    <p class="combo-description">La experiencia completa para el caballero exigente.</p>
                    <div class="combo-includes">
                        <h4>Incluye:</h4>
                        <ul>
                            <li>
                                <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                                Corte Premium
                            </li>
                            <li>
                                <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                                Barba Premium con Navaja
                            </li>
                            <li>
                                <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                                Tratamiento Facial Express
                            </li>
                            <li>
                                <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                                Masaje Relajante
                            </li>
                        </ul>
                    </div>
                    <div class="combo-price">
                        <span class="old-price">$120.000</span>
                        <span class="current-price">$95.000</span>
                    </div>
                    <button class="btn-reservar">Reservar Combo</button>
                </div>

                <div class="combo-card">
                    <div class="combo-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                        </svg>
                    </div>
                    <h3>Combo Novio</h3>
                    <p class="combo-description">El día más importante merece la mejor preparación.</p>
                    <div class="combo-includes">
                        <h4>Incluye:</h4>
                        <ul>
                            <li>
                                <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                                Corte Premium Personalizado
                            </li>
                            <li>
                                <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                                Afeitado Clásico con Navaja
                            </li>
                            <li>
                                <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                                Tratamiento Facial Completo
                            </li>
                            <li>
                                <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                                Copa de Champagne
                            </li>
                        </ul>
                    </div>
                    <div class="combo-price">
                        <span class="old-price">$180.000</span>
                        <span class="current-price">$150.000</span>
                    </div>
                    <button class="btn-reservar">Reservar Combo</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Información Adicional -->
    <section class="services-info">
        <div class="container">
            <div class="info-grid">
                <div class="info-card">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    <h3>Reserva Online</h3>
                    <p>Agenda tu cita en segundos desde cualquier dispositivo. Recibe confirmación inmediata.</p>
                </div>
                <div class="info-card">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                    <h3>Puntualidad</h3>
                    <p>Respetamos tu tiempo. Llegamos a la hora acordada, sin esperas innecesarias.</p>
                </div>
                <div class="info-card">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    </svg>
                    <h3>Higiene Garantizada</h3>
                    <p>Herramientas esterilizadas y productos de primera calidad. Tu salud es nuestra prioridad.</p>
                </div>
                <div class="info-card">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                        <polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                    <h3>Satisfacción 100%</h3>
                    <p>Si no quedas satisfecho, lo arreglamos sin costo adicional. Ese es nuestro compromiso.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="cta-final">
        <div class="cta-background"></div>
        <div class="container">
            <h2 class="cta-title">Transforma tu imagen hoy</h2>
            <p class="cta-subtitle">Reserva tu cita y descubre por qué somos la barbería preferida de la ciudad</p>
            <a href="{{ route('agendar') }}">
            <button class="btn-cta-3d">Agendar Mi Cita</button>
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <div class="footer-logo">
                        <svg width="50" height="50" viewBox="0 0 50 50">
                            <text x="25" y="35" font-family="Playfair Display" font-size="40" font-weight="700" fill="#D4AF37" text-anchor="middle">H</text>
                        </svg>
                        <span>H BARBER SHOP SAS</span>
                    </div>
                    <p>Estilo, precisión y experiencia premium desde 2008</p>
                </div>
                <div class="footer-col">
                    <h4>Servicios</h4>
                    <ul>
                        <li><a href="#cortes">Cortes de Cabello</a></li>
                        <li><a href="#barba">Servicios de Barba</a></li>
                        <li><a href="#tratamientos">Tratamientos</a></li>
                        <li><a href="#combos">Combos Especiales</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Contacto</h4>
                    <ul>
                        <li>Calle 123 #45-67</li>
                        <li>Bogotá, Colombia</li>
                        <li>Tel: +57 310 123 4567</li>
                        <li>info@hbarbershop.com</li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Horarios</h4>
                    <ul>
                        <li>Lun - Vie: 9:00 - 20:00</li>
                        <li>Sábados: 9:00 - 18:00</li>
                        <li>Domingos: 10:00 - 16:00</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2026 H Barber Shop SAS. Todos los derechos reservados.</p>
                <div class="social-links">
                    <a href="#" aria-label="Instagram">IG</a>
                    <a href="#" aria-label="Facebook">FB</a>
                    <a href="#" aria-label="WhatsApp">WA</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Filtro de categorías
        document.querySelectorAll('.category-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.category-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                const category = this.dataset.category;
                
                document.querySelectorAll('.services-section, .combos-section').forEach(section => {
                    if (category === 'all' || section.dataset.category === category) {
                        section.style.display = 'block';
                    } else {
                        section.style.display = 'none';
                    }
                });
            });
        });
    </script>

    


</body>
</html>
