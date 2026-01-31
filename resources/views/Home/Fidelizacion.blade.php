<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Programa de Fidelización | H Barber Shop</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
@vite(['resources/css/Home/fidelizacion.css'])
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
                <a href="{{ route('fidelizacion') }}" class="active">Fidelizacion</a>
            </div>
       
            <div class="nav-buttons">
                <a href="{{ route('agendar') }}">
                <button class="btn-primary">Agendar Cita</button>
                </a>
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

    <!-- Hero Section -->
    <section class="page-hero" style="padding: 140px 0 80px;">
        <div class="container">
            <h1 class="section-title">Programa de <span class="gold-text">Fidelización</span></h1>
            <p class="section-subtitle">Tu lealtad tiene recompensa. Acumula cortes y disfruta de beneficios exclusivos.</p>
        </div>
    </section>

    <!-- Tarjeta 3D y Consulta -->
    <section class="section" style="padding: 60px 0;">
        <div class="container">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center;">
                
                <!-- Tarjeta 3D -->
                <div>
                    <h3 style="font-family: 'Playfair Display', serif; font-size: 1.8rem; color: #fff; margin-bottom: 10px; text-align: center;">Tu Tarjeta de Miembro</h3>
                    <p style="font-family: 'Montserrat', sans-serif; font-size: 0.9rem; color: rgba(255,255,255,0.6); text-align: center; margin-bottom: 30px;">Pasa el cursor sobre la tarjeta para ver el reverso</p>
                    
                    <div class="card-3d-container">
                        <div class="card-3d">
                            <!-- Frente de la tarjeta -->
                            <div class="card-front">
                                <div class="card-pattern"></div>
                                <div class="card-chip"></div>
                                <div class="card-logo">
                                    H
                                    <span>BARBER SHOP</span>
                                </div>
                                <div class="card-number">**** **** **** 4589</div>
                                <div class="card-member-info">
                                    <div class="card-member-label">Miembro</div>
                                    <div class="card-member-name">CLIENTE PREMIUM</div>
                                </div>
                                <div class="card-tier">
                                    <div class="card-tier-label">Nivel</div>
                                    <div class="card-tier-value">GOLD</div>
                                </div>
                            </div>
                            
                            <!-- Reverso de la tarjeta -->
                            <div class="card-back">
                                <div class="card-back-title">Programa de Recompensas</div>
                                <div class="card-back-info">
                                    Cada 10 cortes acumulas 1 corte GRATIS.<br>
                                    Presenta tu cedula o numero de celular<br>
                                    en cada visita para acumular.
                                </div>
                                <div class="card-barcode">
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Formulario de Consulta -->
                <div>
                    <div class="consulta-form">
                        <h3>Consulta tu Progreso</h3>
                        <p>Ingresa tu numero de cedula o celular para ver cuantos cortes llevas acumulados.</p>
                        
                        <div class="form-tabs">
                            <button class="form-tab active" data-tab="cedula">Cedula</button>
                            <button class="form-tab" data-tab="celular">Celular</button>
                        </div>

                        <form id="consultaForm">
                            <div class="input-group" id="cedulaInput">
                                <label for="cedula">Numero de Cedula</label>
                                <input type="text" id="cedula" name="cedula" placeholder="Ej: 1234567890" maxlength="12">
                            </div>

                            <div class="input-group" id="celularInput" style="display: none;">
                                <label for="celular">Numero de Celular</label>
                                <input type="tel" id="celular" name="celular" placeholder="Ej: 3001234567" maxlength="10">
                            </div>

                            <button type="submit" class="btn-consultar">Consultar Mis Cortes</button>
                        </form>
                    </div>

                    <!-- Resultado de la consulta (ejemplo visual) -->
                    <div class="resultado-consulta visible">
                        <div class="resultado-header">
                            <h4>Juan Carlos Rodriguez</h4>
                            <span>Miembro desde Marzo 2024</span>
                        </div>

                        <div class="progreso-container">
                            <div class="progreso-info">
                                <span>Cortes acumulados: <strong>7 de 10</strong></span>
                                <span><strong>3</strong> para corte gratis</span>
                            </div>
                            <div class="progreso-bar">
                                <div class="progreso-fill" style="width: 70%;"></div>
                            </div>
                        </div>

                        <div class="cortes-visual">
                            <div class="corte-icon completado">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                            </div>
                            <div class="corte-icon completado">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                            </div>
                            <div class="corte-icon completado">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                            </div>
                            <div class="corte-icon completado">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                            </div>
                            <div class="corte-icon completado">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                            </div>
                            <div class="corte-icon completado">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                            </div>
                            <div class="corte-icon completado">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                            </div>
                            <div class="corte-icon pendiente">8</div>
                            <div class="corte-icon pendiente">9</div>
                            <div class="corte-icon gratis">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 12V8H6a2 2 0 0 1-2-2c0-1.1.9-2 2-2h12v4"/><path d="M4 6v12c0 1.1.9 2 2 2h14v-4"/><path d="M18 12a2 2 0 0 0-2 2c0 1.1.9 2 2 2h4v-4h-4z"/></svg>
                            </div>
                        </div>

                        <div class="resultado-mensaje">
                            <p>Te faltan solo</p>
                            <span>3 cortes</span>
                            <p>para tu corte GRATIS</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Como funciona -->
    <section class="section como-funciona">
        <div class="container">
            <h2 class="section-title" style="text-align: center;">Como <span class="gold-text">Funciona</span></h2>
            
            <div class="pasos-grid">
                <div class="paso-card">
                    <div class="paso-numero">1</div>
                    <h4>Registrate</h4>
                    <p>En tu primera visita, proporcionanos tu cedula o numero de celular para crear tu cuenta de fidelizacion.</p>
                </div>
                <div class="paso-card">
                    <div class="paso-numero">2</div>
                    <h4>Acumula Cortes</h4>
                    <p>Cada vez que te realices un corte, se registrara automaticamente en tu cuenta. Solo di tu numero.</p>
                </div>
                <div class="paso-card">
                    <div class="paso-numero">3</div>
                    <h4>Consulta tu Progreso</h4>
                    <p>Usa esta pagina para ver cuantos cortes llevas y cuantos te faltan para tu recompensa.</p>
                </div>
                <div class="paso-card">
                    <div class="paso-numero">4</div>
                    <h4>Disfruta tu Premio</h4>
                    <p>Al completar 10 cortes, tu siguiente corte es completamente GRATIS. El contador se reinicia automaticamente.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Beneficios -->
    <section class="section" style="padding: 80px 0;">
        <div class="container">
            <h2 class="section-title" style="text-align: center;">Beneficios <span class="gold-text">Exclusivos</span></h2>
            
            <div class="beneficios-grid">
                <div class="beneficio-card">
                    <div class="beneficio-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#d4af37" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
                    </div>
                    <h4>Corte Gratis</h4>
                    <p>Por cada 10 cortes pagados, el siguiente es completamente gratis. Sin letra pequena.</p>
                </div>
                <div class="beneficio-card">
                    <div class="beneficio-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#d4af37" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    </div>
                    <h4>Descuentos en Productos</h4>
                    <p>Como miembro obtienes 15% de descuento en todos los productos de la tienda.</p>
                </div>
                <div class="beneficio-card">
                    <div class="beneficio-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#d4af37" stroke-width="2"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
                    </div>
                    <h4>Prioridad en Citas</h4>
                    <p>Los miembros tienen prioridad para reservar citas en horarios de alta demanda.</p>
                </div>
                <div class="beneficio-card">
                    <div class="beneficio-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#d4af37" stroke-width="2"><path d="M12 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"/><path d="M12 2v2"/><path d="M12 8v14"/><path d="m8 14 4-2 4 2"/></svg>
                    </div>
                    <h4>Regalos de Cumpleanos</h4>
                    <p>Recibe un servicio especial gratis durante el mes de tu cumpleanos.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="section" style="padding: 80px 0; text-align: center;">
        <div class="container">
            <h2 class="section-title">Aun no eres <span class="gold-text">Miembro?</span></h2>
            <p style="font-family: 'Montserrat', sans-serif; font-size: 1.1rem; color: rgba(255,255,255,0.7); max-width: 600px; margin: 0 auto 30px;">
                Visitanos y registrate automaticamente en tu primer corte. Es gratis y los beneficios comienzan de inmediato.
            </p>
            <a href="{{ route('agendar') }}" class="btn-primary">Agenda tu Cita</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <h3 class="footer-logo">H<span>Barber Shop</span></h3>
                    <p>La experiencia premium en cuidado masculino. Donde el estilo se encuentra con la tradicion.</p>
                </div>
                <div class="footer-col">
                    <h4>Enlaces</h4>
                    <ul>
                        <li><a href="index.html">Inicio</a></li>
                        <li><a href="servicios.html">Servicios</a></li>
                        <li><a href="productos.html">Productos</a></li>
                        <li><a href="fidelizacion.html">Fidelizacion</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Contacto</h4>
                    <ul>
                        <li>Calle 123 #45-67, Bogota</li>
                        <li>+57 300 123 4567</li>
                        <li>info@hbarbershop.com</li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Horarios</h4>
                    <ul>
                        <li>Lun - Vie: 9:00 AM - 8:00 PM</li>
                        <li>Sabado: 9:00 AM - 6:00 PM</li>
                        <li>Domingo: 10:00 AM - 4:00 PM</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 H Barber Shop SAS. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <script>
        // Toggle entre tabs de cedula y celular
        const tabs = document.querySelectorAll('.form-tab');
        const cedulaInput = document.getElementById('cedulaInput');
        const celularInput = document.getElementById('celularInput');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                tabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');

                if (tab.dataset.tab === 'cedula') {
                    cedulaInput.style.display = 'block';
                    celularInput.style.display = 'none';
                } else {
                    cedulaInput.style.display = 'none';
                    celularInput.style.display = 'block';
                }
            });
        });

        // Navbar toggle mobile
        const navToggle = document.querySelector('.nav-toggle');
        const navMenu = document.querySelector('.nav-menu');

        if (navToggle) {
            navToggle.addEventListener('click', () => {
                navMenu.classList.toggle('active');
                navToggle.classList.toggle('active');
            });
        }
    </script>
</body>
</html>
