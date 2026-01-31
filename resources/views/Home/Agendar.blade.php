<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar Cita | H Barber Shop</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
     @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
@vite('resources/css/Home/Agendar.css')
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
                <a href="{{ route('servicios') }}">Servicios</a>
                <a href="{{ route('productos') }}">Productos</a>
                <a href="{{ route('nosotros') }}">Nosotros</a>
                <a href="{{ route('contacto') }}">Contacto</a>
                <a href="{{ route('fidelizacion') }}">Fidelizacion</a>
            </div>
       
            <div class="nav-buttons">
                <button class="btn-primary">Agendar Cita</button>
            <a href="/login" class="nav-login" title="Acceso Staff">
                <i class="fas fa-user-lock"></i>
            </a>
            
            <button class="nav-toggle" id="navToggle">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </nav>


    <!-- Main Content -->
    <main style="padding-top: 100px; min-height: 100vh;">
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
                    <span class="step-label">Confirmar</span>
                </div>
            </div>

            <!-- Step 1: Select Barber -->
            <div class="booking-step active" id="step-1">
                <h2 class="step-title">Elige tu Barbero</h2>
                <p class="step-subtitle">Selecciona al profesional que te atendera</p>

                <div class="selection-grid">
                    <!-- Any Barber Option -->
                    <div class="selection-card any-barber-option" data-barber="any" data-name="Cualquier Barbero">
                        <div class="barber-avatar">?</div>
                        <h3 class="barber-name">Cualquier Barbero</h3>
                        <p class="barber-role">Disponibilidad Inmediata</p>
                        <p class="barber-specialty">Te asignaremos al barbero disponible mas pronto</p>
                    </div>

                    <!-- Barber 1 -->
                    <div class="selection-card" data-barber="1" data-name="Carlos Rodriguez">
                        <div class="barber-avatar">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#d4af37" stroke-width="1.5">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                        </div>
                        <h3 class="barber-name">Carlos Rodriguez</h3>
                        <p class="barber-role">Master Barber</p>
                        <p class="barber-specialty">Especialista en fades y disenos artisticos</p>
                        <div class="barber-rating">
                            <span>&#9733;&#9733;&#9733;&#9733;&#9733;</span>
                            <span style="color: #888; margin-left: 0.5rem;">4.9</span>
                        </div>
                    </div>

                    <!-- Barber 2 -->
                    <div class="selection-card" data-barber="2" data-name="Miguel Torres">
                        <div class="barber-avatar">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#d4af37" stroke-width="1.5">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                        </div>
                        <h3 class="barber-name">Miguel Torres</h3>
                        <p class="barber-role">Senior Barber</p>
                        <p class="barber-specialty">Experto en cortes clasicos y barbas</p>
                        <div class="barber-rating">
                            <span>&#9733;&#9733;&#9733;&#9733;&#9733;</span>
                            <span style="color: #888; margin-left: 0.5rem;">4.8</span>
                        </div>
                    </div>

                    <!-- Barber 3 -->
                    <div class="selection-card" data-barber="3" data-name="Andres Gomez">
                        <div class="barber-avatar">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#d4af37" stroke-width="1.5">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                        </div>
                        <h3 class="barber-name">Andres Gomez</h3>
                        <p class="barber-role">Barber</p>
                        <p class="barber-specialty">Especialista en tratamientos capilares</p>
                        <div class="barber-rating">
                            <span>&#9733;&#9733;&#9733;&#9733;&#9734;</span>
                            <span style="color: #888; margin-left: 0.5rem;">4.7</span>
                        </div>
                    </div>

                    <!-- Barber 4 -->
                    <div class="selection-card" data-barber="4" data-name="David Martinez">
                        <div class="barber-avatar">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#d4af37" stroke-width="1.5">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                        </div>
                        <h3 class="barber-name">David Martinez</h3>
                        <p class="barber-role">Junior Barber</p>
                        <p class="barber-specialty">Cortes modernos y tendencias actuales</p>
                        <div class="barber-rating">
                            <span>&#9733;&#9733;&#9733;&#9733;&#9734;</span>
                            <span style="color: #888; margin-left: 0.5rem;">4.6</span>
                        </div>
                    </div>
                </div>

                <div class="booking-navigation">
                    <div></div>
                    <button class="btn-next" id="btn-next-1" disabled>
                        Continuar
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Step 2: Select Service -->
            <div class="booking-step" id="step-2">
                <h2 class="step-title">Selecciona tu Servicio</h2>
                <p class="step-subtitle">Elige el servicio que deseas</p>

                <div class="category-filter">
                    <button class="category-btn active" data-category="all">Todos</button>
                    <button class="category-btn" data-category="cortes">Cortes</button>
                    <button class="category-btn" data-category="barba">Barba</button>
                    <button class="category-btn" data-category="combos">Combos</button>
                </div>

                <div class="selection-grid" id="services-grid">
                    <!-- Corte Clasico -->
                    <div class="selection-card" data-service="1" data-name="Corte Clasico" data-price="25000" data-duration="30" data-category="cortes">
                        <div class="service-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#d4af37" stroke-width="2">
                                <circle cx="6" cy="6" r="3"/><circle cx="6" cy="18" r="3"/>
                                <line x1="20" y1="4" x2="8.12" y2="15.88"/><line x1="14.47" y1="14.48" x2="20" y2="20"/>
                                <line x1="8.12" y1="8.12" x2="12" y2="12"/>
                            </svg>
                        </div>
                        <h3 class="service-name">Corte Clasico</h3>
                        <p class="service-description">Corte tradicional con tijera y maquina, incluye lavado</p>
                        <div class="service-details">
                            <span class="service-price">$25.000</span>
                            <span class="service-duration">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
                                </svg>
                                30 min
                            </span>
                        </div>
                    </div>

                    <!-- Corte Premium -->
                    <div class="selection-card" data-service="2" data-name="Corte Premium" data-price="35000" data-duration="45" data-category="cortes">
                        <div class="service-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#d4af37" stroke-width="2">
                                <circle cx="6" cy="6" r="3"/><circle cx="6" cy="18" r="3"/>
                                <line x1="20" y1="4" x2="8.12" y2="15.88"/><line x1="14.47" y1="14.48" x2="20" y2="20"/>
                                <line x1="8.12" y1="8.12" x2="12" y2="12"/>
                            </svg>
                        </div>
                        <h3 class="service-name">Corte Premium</h3>
                        <p class="service-description">Corte personalizado con consulta, lavado y styling</p>
                        <div class="service-details">
                            <span class="service-price">$35.000</span>
                            <span class="service-duration">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
                                </svg>
                                45 min
                            </span>
                        </div>
                    </div>

                    <!-- Fade/Degradado -->
                    <div class="selection-card" data-service="3" data-name="Fade / Degradado" data-price="30000" data-duration="40" data-category="cortes">
                        <div class="service-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#d4af37" stroke-width="2">
                                <circle cx="6" cy="6" r="3"/><circle cx="6" cy="18" r="3"/>
                                <line x1="20" y1="4" x2="8.12" y2="15.88"/><line x1="14.47" y1="14.48" x2="20" y2="20"/>
                                <line x1="8.12" y1="8.12" x2="12" y2="12"/>
                            </svg>
                        </div>
                        <h3 class="service-name">Fade / Degradado</h3>
                        <p class="service-description">Low, mid o high fade con acabado perfecto</p>
                        <div class="service-details">
                            <span class="service-price">$30.000</span>
                            <span class="service-duration">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
                                </svg>
                                40 min
                            </span>
                        </div>
                    </div>

                    <!-- Arreglo de Barba -->
                    <div class="selection-card" data-service="4" data-name="Arreglo de Barba" data-price="18000" data-duration="20" data-category="barba">
                        <div class="service-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#d4af37" stroke-width="2">
                                <path d="M6 3v18M18 3v18M6 8h12M6 16h12"/>
                            </svg>
                        </div>
                        <h3 class="service-name">Arreglo de Barba</h3>
                        <p class="service-description">Perfilado, recorte y definicion de lineas</p>
                        <div class="service-details">
                            <span class="service-price">$18.000</span>
                            <span class="service-duration">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
                                </svg>
                                20 min
                            </span>
                        </div>
                    </div>

                    <!-- Afeitado Clasico -->
                    <div class="selection-card" data-service="5" data-name="Afeitado Clasico" data-price="22000" data-duration="25" data-category="barba">
                        <div class="service-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#d4af37" stroke-width="2">
                                <path d="M6 3v18M18 3v18M6 8h12M6 16h12"/>
                            </svg>
                        </div>
                        <h3 class="service-name">Afeitado Clasico</h3>
                        <p class="service-description">Afeitado con navaja, toalla caliente y aftershave</p>
                        <div class="service-details">
                            <span class="service-price">$22.000</span>
                            <span class="service-duration">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
                                </svg>
                                25 min
                            </span>
                        </div>
                    </div>

                    <!-- Barba Premium -->
                    <div class="selection-card" data-service="6" data-name="Barba Premium" data-price="28000" data-duration="35" data-category="barba">
                        <div class="service-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#d4af37" stroke-width="2">
                                <path d="M6 3v18M18 3v18M6 8h12M6 16h12"/>
                            </svg>
                        </div>
                        <h3 class="service-name">Barba Premium</h3>
                        <p class="service-description">Arreglo completo con tratamiento hidratante y aceites</p>
                        <div class="service-details">
                            <span class="service-price">$28.000</span>
                            <span class="service-duration">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
                                </svg>
                                35 min
                            </span>
                        </div>
                    </div>

                    <!-- Combo Basico -->
                    <div class="selection-card" data-service="7" data-name="Combo Basico" data-price="38000" data-duration="50" data-category="combos">
                        <div class="service-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#d4af37" stroke-width="2">
                                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                            </svg>
                        </div>
                        <h3 class="service-name">Combo Basico</h3>
                        <p class="service-description">Corte clasico + Arreglo de barba</p>
                        <div class="service-details">
                            <span class="service-price">$38.000</span>
                            <span class="service-duration">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
                                </svg>
                                50 min
                            </span>
                        </div>
                    </div>

                    <!-- Combo Premium -->
                    <div class="selection-card" data-service="8" data-name="Combo Premium" data-price="55000" data-duration="75" data-category="combos">
                        <div class="service-icon" style="background: linear-gradient(135deg, rgba(212, 175, 55, 0.4), rgba(212, 175, 55, 0.2));">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#d4af37" stroke-width="2">
                                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                            </svg>
                        </div>
                        <h3 class="service-name">Combo Premium</h3>
                        <p class="service-description">Corte premium + Barba premium + Tratamiento capilar</p>
                        <div class="service-details">
                            <span class="service-price">$55.000</span>
                            <span class="service-duration">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
                                </svg>
                                75 min
                            </span>
                        </div>
                    </div>

                    <!-- Corte Infantil -->
                    <div class="selection-card" data-service="9" data-name="Corte Infantil" data-price="20000" data-duration="25" data-category="cortes">
                        <div class="service-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#d4af37" stroke-width="2">
                                <circle cx="6" cy="6" r="3"/><circle cx="6" cy="18" r="3"/>
                                <line x1="20" y1="4" x2="8.12" y2="15.88"/><line x1="14.47" y1="14.48" x2="20" y2="20"/>
                                <line x1="8.12" y1="8.12" x2="12" y2="12"/>
                            </svg>
                        </div>
                        <h3 class="service-name">Corte Infantil</h3>
                        <p class="service-description">Corte para ninos menores de 12 anos</p>
                        <div class="service-details">
                            <span class="service-price">$20.000</span>
                            <span class="service-duration">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
                                </svg>
                                25 min
                            </span>
                        </div>
                    </div>
                </div>

                <div class="booking-navigation">
                    <button class="btn-back" id="btn-back-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M19 12H5M12 19l-7-7 7-7"/>
                        </svg>
                        Atras
                    </button>
                    <button class="btn-next" id="btn-next-2" disabled>
                        Continuar
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Step 3: Select Date & Time -->
            <div class="booking-step" id="step-3">
                <h2 class="step-title">Elige Fecha y Hora</h2>
                <p class="step-subtitle">Selecciona el momento que mejor te convenga</p>

                <div class="datetime-container">
                    <!-- Calendar -->
                    <div class="datetime-section">
                        <h3>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/>
                                <line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                            </svg>
                            Fecha
                        </h3>
                        
                        <div class="calendar-header">
                            <span class="calendar-month">Febrero 2026</span>
                            <div class="calendar-nav">
                                <button>&lt;</button>
                                <button>&gt;</button>
                            </div>
                        </div>

                        <div class="calendar-weekdays">
                            <span class="weekday">Dom</span>
                            <span class="weekday">Lun</span>
                            <span class="weekday">Mar</span>
                            <span class="weekday">Mie</span>
                            <span class="weekday">Jue</span>
                            <span class="weekday">Vie</span>
                            <span class="weekday">Sab</span>
                        </div>

                        <div class="calendar-days">
                            <button class="calendar-day empty"></button>
                            <button class="calendar-day disabled">1</button>
                            <button class="calendar-day today">2</button>
                            <button class="calendar-day">3</button>
                            <button class="calendar-day">4</button>
                            <button class="calendar-day">5</button>
                            <button class="calendar-day">6</button>
                            <button class="calendar-day">7</button>
                            <button class="calendar-day disabled">8</button>
                            <button class="calendar-day">9</button>
                            <button class="calendar-day">10</button>
                            <button class="calendar-day">11</button>
                            <button class="calendar-day">12</button>
                            <button class="calendar-day">13</button>
                            <button class="calendar-day">14</button>
                            <button class="calendar-day disabled">15</button>
                            <button class="calendar-day">16</button>
                            <button class="calendar-day">17</button>
                            <button class="calendar-day">18</button>
                            <button class="calendar-day">19</button>
                            <button class="calendar-day">20</button>
                            <button class="calendar-day">21</button>
                            <button class="calendar-day disabled">22</button>
                            <button class="calendar-day">23</button>
                            <button class="calendar-day">24</button>
                            <button class="calendar-day">25</button>
                            <button class="calendar-day">26</button>
                            <button class="calendar-day">27</button>
                            <button class="calendar-day">28</button>
                        </div>
                    </div>

                    <!-- Time Slots -->
                    <div class="datetime-section">
                        <h3>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
                            </svg>
                            Hora
                        </h3>
                        
                        <div class="time-slots">
                            <button class="time-slot">8:00 AM</button>
                            <button class="time-slot">8:30 AM</button>
                            <button class="time-slot disabled">9:00 AM</button>
                            <button class="time-slot">9:30 AM</button>
                            <button class="time-slot">10:00 AM</button>
                            <button class="time-slot disabled">10:30 AM</button>
                            <button class="time-slot">11:00 AM</button>
                            <button class="time-slot">11:30 AM</button>
                            <button class="time-slot disabled">12:00 PM</button>
                            <button class="time-slot">12:30 PM</button>
                            <button class="time-slot">1:00 PM</button>
                            <button class="time-slot">1:30 PM</button>
                            <button class="time-slot">2:00 PM</button>
                            <button class="time-slot disabled">2:30 PM</button>
                            <button class="time-slot">3:00 PM</button>
                            <button class="time-slot">3:30 PM</button>
                            <button class="time-slot">4:00 PM</button>
                            <button class="time-slot">4:30 PM</button>
                            <button class="time-slot disabled">5:00 PM</button>
                            <button class="time-slot">5:30 PM</button>
                            <button class="time-slot">6:00 PM</button>
                            <button class="time-slot">6:30 PM</button>
                            <button class="time-slot">7:00 PM</button>
                            <button class="time-slot">7:30 PM</button>
                        </div>
                    </div>
                </div>

                <div class="booking-navigation">
                    <button class="btn-back" id="btn-back-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M19 12H5M12 19l-7-7 7-7"/>
                        </svg>
                        Atras
                    </button>
                    <button class="btn-next" id="btn-next-3" disabled>
                        Continuar
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Step 4: Confirm -->
            <div class="booking-step" id="step-4">
                <h2 class="step-title">Confirma tu Cita</h2>
                <p class="step-subtitle">Revisa los detalles y completa tus datos</p>

                <div class="client-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="client-name">Nombre Completo *</label>
                            <input type="text" id="client-name" placeholder="Tu nombre completo" required>
                        </div>
                        <div class="form-group">
                            <label for="client-cedula">Cedula *</label>
                            <input type="text" id="client-cedula" placeholder="Tu numero de cedula" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="client-phone">Celular *</label>
                            <input type="tel" id="client-phone" placeholder="Tu numero de celular" required>
                        </div>
                        <div class="form-group">
                            <label for="client-email">Email (opcional)</label>
                            <input type="email" id="client-email" placeholder="Tu correo electronico">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="client-notes">Notas adicionales (opcional)</label>
                        <textarea id="client-notes" placeholder="Alguna preferencia o indicacion especial..."></textarea>
                    </div>
                </div>

                <!-- Summary -->
                <div class="summary-card">
                    <h3 class="summary-title">Resumen de tu Cita</h3>
                    
                    <div class="summary-item">
                        <span class="summary-label">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                            Barbero
                        </span>
                        <span class="summary-value" id="summary-barber">Carlos Rodriguez</span>
                    </div>

                    <div class="summary-item">
                        <span class="summary-label">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="6" cy="6" r="3"/><circle cx="6" cy="18" r="3"/>
                                <line x1="20" y1="4" x2="8.12" y2="15.88"/>
                            </svg>
                            Servicio
                        </span>
                        <span class="summary-value" id="summary-service">Corte Premium</span>
                    </div>

                    <div class="summary-item">
                        <span class="summary-label">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                            </svg>
                            Fecha
                        </span>
                        <span class="summary-value" id="summary-date">Martes, 3 de Febrero</span>
                    </div>

                    <div class="summary-item">
                        <span class="summary-label">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
                            </svg>
                            Hora
                        </span>
                        <span class="summary-value" id="summary-time">10:00 AM</span>
                    </div>

                    <div class="summary-item">
                        <span class="summary-label">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
                            </svg>
                            Duracion
                        </span>
                        <span class="summary-value" id="summary-duration">45 min</span>
                    </div>

                    <div class="summary-total">
                        <span class="summary-label">Total a Pagar</span>
                        <span class="summary-value" id="summary-total">$35.000</span>
                    </div>
                </div>

                <div class="booking-navigation" style="flex-direction: column; gap: 1rem;">
                    <button class="btn-confirm" id="btn-confirm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: inline; vertical-align: middle; margin-right: 0.5rem;">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                            <polyline points="22 4 12 14.01 9 11.01"/>
                        </svg>
                        Confirmar Cita
                    </button>
                    <button class="btn-back" id="btn-back-4" style="width: 100%; justify-content: center;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M19 12H5M12 19l-7-7 7-7"/>
                        </svg>
                        Modificar Cita
                    </button>
                </div>
            </div>

            <!-- Success Step -->
            <div class="booking-step" id="step-success">
                <div class="success-message">
                    <div class="success-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="#0a0a0a" stroke-width="3">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                    </div>
                    <h2 class="success-title">Cita Confirmada</h2>
                    <p class="success-text">
                        Tu cita ha sido agendada exitosamente. Te hemos enviado un recordatorio por WhatsApp. 
                        Te esperamos puntual para brindarte la mejor experiencia.
                    </p>
                    <div class="confirmation-code">
                        <span>Codigo de Confirmacion</span>
                        <strong>HBS-2026-0203-1045</strong>
                    </div>
                    <a href="index.html" class="btn-next" style="display: inline-flex; text-decoration: none;">
                        Volver al Inicio
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-bottom">
            <p>&copy; 2026 H Barber Shop SAS. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script>
        // Selection functionality for cards
        document.querySelectorAll('#step-1 .selection-card').forEach(card => {
            card.addEventListener('click', () => {
                document.querySelectorAll('#step-1 .selection-card').forEach(c => c.classList.remove('selected'));
                card.classList.add('selected');
                document.getElementById('btn-next-1').disabled = false;
            });
        });

        document.querySelectorAll('#step-2 .selection-card').forEach(card => {
            card.addEventListener('click', () => {
                document.querySelectorAll('#step-2 .selection-card').forEach(c => c.classList.remove('selected'));
                card.classList.add('selected');
                document.getElementById('btn-next-2').disabled = false;
            });
        });

        // Calendar selection
        document.querySelectorAll('.calendar-day:not(.disabled):not(.empty)').forEach(day => {
            day.addEventListener('click', () => {
                document.querySelectorAll('.calendar-day').forEach(d => d.classList.remove('selected'));
                day.classList.add('selected');
                checkStep3();
            });
        });

        // Time slot selection
        document.querySelectorAll('.time-slot:not(.disabled)').forEach(slot => {
            slot.addEventListener('click', () => {
                document.querySelectorAll('.time-slot').forEach(s => s.classList.remove('selected'));
                slot.classList.add('selected');
                checkStep3();
            });
        });

        function checkStep3() {
            const dateSelected = document.querySelector('.calendar-day.selected');
            const timeSelected = document.querySelector('.time-slot.selected');
            document.getElementById('btn-next-3').disabled = !(dateSelected && timeSelected);
        }

        // Category filter
        document.querySelectorAll('.category-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.category-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                const category = btn.dataset.category;
                
                document.querySelectorAll('#services-grid .selection-card').forEach(card => {
                    if (category === 'all' || card.dataset.category === category) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });

        // Navigation
        function goToStep(stepNumber) {
            document.querySelectorAll('.booking-step').forEach(s => s.classList.remove('active'));
            document.querySelectorAll('.progress-steps .step').forEach((s, i) => {
                s.classList.remove('active', 'completed');
                if (i + 1 < stepNumber) s.classList.add('completed');
                if (i + 1 === stepNumber) s.classList.add('active');
            });
            document.querySelectorAll('.step-line').forEach((l, i) => {
                l.classList.toggle('completed', i + 1 < stepNumber);
            });
            document.getElementById(`step-${stepNumber}`).classList.add('active');
        }

        document.getElementById('btn-next-1').addEventListener('click', () => goToStep(2));
        document.getElementById('btn-next-2').addEventListener('click', () => goToStep(3));
        document.getElementById('btn-next-3').addEventListener('click', () => goToStep(4));
        document.getElementById('btn-back-2').addEventListener('click', () => goToStep(1));
        document.getElementById('btn-back-3').addEventListener('click', () => goToStep(2));
        document.getElementById('btn-back-4').addEventListener('click', () => goToStep(3));
        
        document.getElementById('btn-confirm').addEventListener('click', () => {
            document.querySelectorAll('.booking-step').forEach(s => s.classList.remove('active'));
            document.getElementById('step-success').classList.add('active');
        });
    </script>
</body>
</html>
