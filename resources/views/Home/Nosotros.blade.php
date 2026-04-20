@extends('layouts.blog')

@section('og_type', 'blog')

@section('content')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Conoce la historia de H Barber Shop SAS. Barbería premium con más de 10 años de experiencia en cortes y servicios de calidad.">
    <title>Nosotros - H Barber Shop SAS</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
     @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
@vite(['resources/css/Home/Nosotros.css'])
<body lang="es">
    <a href="#main-content" class="skip-link">Ir al contenido principal</a>

   <!-- Hero Section -->
    <section class="page-hero" role="banner" aria-label="Encabezado de la página Nosotros" 
    style="background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('{{ asset('img/4.jpeg') }}');">
    <div class="hero-overlay" aria-hidden="true"></div>
    <div class="hero-content">
        <h1 class="hero-title">Nuestra Historia</h1>
        <p class="hero-subtitle">Mas que una barberia, una experiencia de estilo y tradicion</p>
    </div>
</section>

    <!-- Nuestra Historia -->
    <main id="main-content">
    <section class="about-section" role="region" aria-labelledby="about-title">
        <div class="container">
            <div class="about-grid">
                <article class="about-content">
                    <span class="section-badge" aria-hidden="true">Desde 2015</span>
                    <h2 class="section-title" id="about-title">Quienes Somos</h2>
                    <p class="about-text">
                        En <strong>H BARBER SHOP</strong> concebimos el cuidado masculino como una expresión de elegancia, precisión y buen gusto. Cada detalle de nuestro espacio y servicio está pensado
                         para ofrecer una experiencia distinguida, donde la calidad y la autenticidad son prioridad.
                    </p>
                    <p class="about-text">
                       Nuestra barbería nace de un proyecto emprendedor liderado por una mujer no vidente que, con visión y determinación, hizo realidad este negocio gracias al apoyo de un fondo de emprendimiento del SENA.
                        Desde la administración, dirige el funcionamiento del establecimiento con profesionalismo y compromiso.
                    </p>
                    <p class="about-text">
                       Junto a su hermano, barbero especializado y responsable del área técnica, han construido un equipo que combina gestión, talento y dedicación
                        para brindar un servicio impecable, enfocado en la confianza, el estilo y la excelencia.
                    </p>
                </article>
                <div class="about-image">
                    <div class="image-frame">
                        <img src="{{ asset('img/image.png') }}" alt="Logo de H Barber Shop SAS" class="about-photo">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mision, Vision, Valores -->
    <section class="values-section" role="region" aria-labelledby="values-title">
        <div class="container">
            <h2 class="visually-hidden" id="values-title">Valores de la empresa</h2>
            <div class="values-grid" role="list">
                <!-- Mision -->
                <article class="value-card" role="listitem">
                    <div class="value-icon" aria-hidden="true">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h3 class="value-title" id="mission-heading">Mision</h3>
                    <p class="value-text" aria-describedby="mission-heading">
                        Brindar servicios de barberia de la mas alta calidad, combinando tecnicas tradicionales 
                        con tendencias modernas, en un ambiente acogedor y profesional que supere las expectativas 
                        de nuestros clientes.
                    </p>
                </article>

                <!-- Vision -->
                <article class="value-card" role="listitem">
                    <div class="value-icon" aria-hidden="true">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h3 class="value-title" id="vision-heading">Vision</h3>
                    <p class="value-text" aria-describedby="vision-heading">
                        Ser reconocidos como la barberia lider en innovacion y calidad, expandiendo nuestra 
                        presencia y manteniendo los mas altos estandares de servicio, formando barberos 
                        de excelencia.
                    </p>
                </article>

                <!-- Valores -->
                <article class="value-card" role="listitem">
                    <div class="value-icon" aria-hidden="true">
                        <i class="fas fa-gem"></i>
                    </div>
                    <h3 class="value-title" id="values-heading">Valores</h3>
                    <p class="value-text" aria-describedby="values-heading">
                        Excelencia en cada detalle, respeto por nuestros clientes y equipo, innovacion constante, 
                        compromiso con la calidad, honestidad y pasion por nuestro oficio.
                    </p>
                </article>
            </div>
        </div>
    </section>

    <!-- Nuestro Equipo -->
    <section class="team-section" role="region" aria-labelledby="team-title">
        <div class="container">
            <div class="section-header">
                <span class="section-badge" aria-hidden="true">Profesionales</span>
                <h2 class="section-title" id="team-title">Nuestro Equipo</h2>
                <p class="section-subtitle">Conoce a los expertos detras de cada corte perfecto</p>
            </div>

            <div class="team-grid" role="list">
                @if(isset($admin) && $admin && $admin->persona)
                    <article class="team-card" role="listitem" aria-label="Admin {{ $admin->persona->per_nombre }} {{ $admin->persona->per_apellido }}">
                        <div class="team-image">
                            @if($admin->foto_perfil)
                                <img src="{{ asset('storage/' . $admin->foto_perfil) }}" alt="Foto de perfil de {{ $admin->persona->per_nombre }}" class="foto-perfil-equipo">
                            @else
                                <div class="image-placeholder" aria-hidden="true">
                                    <i class="fas fa-user-shield"></i>
                                </div>
                            @endif
                            <div class="team-social">
                                @if(isset($admin->persona->per_correo))
                                    <a href="mailto:{{ $admin->persona->per_correo }}" class="social-link" aria-label="Enviar email a {{ $admin->persona->per_nombre }}"><i class="fas fa-envelope" aria-hidden="true"></i></a>
                                @endif
                            </div>
                        </div>
                        <div class="team-info">
                            <h3 class="team-name">{{ $admin->persona->per_nombre ?? 'Admin' }} {{ $admin->persona->per_apellido ?? '' }}</h3>
                            <span class="team-role" aria-label="Profesión">Administradora</span>
                            <p class="team-bio">
                                @if(isset($admin->persona->per_telefono))
                                    Tel: {{ $admin->persona->per_telefono }}
                                @endif
                            </p>
                        </div>
                    </article>
                @endif
                @forelse($barberos as $barbero)
                    <article class="team-card" role="listitem" aria-label="Barbero {{ $barbero->persona->per_nombre }} {{ $barbero->persona->per_apellido }}">
                        <div class="team-image">
                            @if($barbero->persona && $barbero->persona->usuario && $barbero->persona->usuario->foto_perfil)
                             <img src="{{ asset('storage/' . $barbero->persona->usuario->foto_perfil) }}" alt="Foto de perfil de {{ $barbero->persona->per_nombre }}" class="foto-perfil-equipo">
                            @else
                                <div class="image-placeholder" aria-hidden="true">
                                    <i class="fas fa-user"></i>
                                </div>
                            @endif
                            <div class="team-social">
                                @if(isset($barbero->persona->per_correo))
                                    <a href="mailto:{{ $barbero->persona->per_correo }}" class="social-link" aria-label="Enviar email a {{ $barbero->persona->per_nombre }}"><i class="fas fa-envelope" aria-hidden="true"></i></a>
                                @endif
                            </div>
                        </div>
                        <div class="team-info">
                            <h3 class="team-name" id="team-{{ $loop->index }}">{{ $barbero->persona->per_nombre ?? 'Barbero' }} {{ $barbero->persona->per_apellido ?? '' }}</h3>
                            <span class="team-role" aria-label="Profesión">Barbero</span>
                            <p class="team-bio" aria-describedby="team-{{ $loop->index }}">
                                @if(isset($barbero->persona->per_telefono))
                                    Tel: {{ $barbero->persona->per_telefono }}
                                @endif
                            </p>
                            <div class="team-specialties">
                                <!-- Si tienes especialidades, agrégalas aquí -->
                            </div>
                        </div>
                    </article>
                @empty
                    <p role="status" aria-live="polite">No hay barberos registrados actualmente.</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Estadisticas -->
    <section class="stats-section" role="region" aria-labelledby="stats-title">
        <div class="container">
            <h2 class="visually-hidden" id="stats-title">Estadísticas de la empresa</h2>
            <div class="stats-grid" role="list">
                <article class="stat-item" role="listitem" aria-label="Anos de experiencia">
                    <div class="stat-number" data-count="10" role="status" aria-live="polite">10+</div>
                    <div class="stat-label">Anos de Experiencia</div>
                </article>
                <article class="stat-item" role="listitem" aria-label="Clientes satisfechos">
                    <div class="stat-number" data-count="15000" role="status" aria-live="polite">15,000+</div>
                    <div class="stat-label">Clientes Satisfechos</div>
                </article>
                <article class="stat-item" role="listitem" aria-label="Barberos expertos">
                    <div class="stat-number" data-count="4" role="status" aria-live="polite">4</div>
                    <div class="stat-label">Barberos Expertos</div>
                </article>
                <article class="stat-item" role="listitem" aria-label="Cortes realizados">
                    <div class="stat-number" data-count="50000" role="status" aria-live="polite">50,000+</div>
                    <div class="stat-label">Cortes Realizados</div>
                </article>
            </div>
        </div>
    </section>

    <!-- Por que Elegirnos -->
    <section class="why-section" role="region" aria-labelledby="why-title">
        <div class="container">
            <div class="section-header">
                <span class="section-badge" aria-hidden="true">Diferencia</span>
                <h2 class="section-title" id="why-title">Por Que Elegirnos</h2>
                <p class="section-subtitle">Lo que nos hace unicos en cada visita</p>
            </div>

            <div class="why-grid" role="list">
                <article class="why-card" role="listitem">
                    <div class="why-icon" aria-hidden="true">
                        <i class="fas fa-award"></i>
                    </div>
                    <h3 class="why-title" id="why-1">Calidad Garantizada</h3>
                    <p class="why-text" aria-describedby="why-1">
                        Utilizamos productos premium y tecnicas profesionales para asegurar 
                        resultados excepcionales en cada servicio.
                    </p>
                </article>

                <article class="why-card" role="listitem">
                    <div class="why-icon" aria-hidden="true">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3 class="why-title" id="why-2">Puntualidad</h3>
                    <p class="why-text" aria-describedby="why-2">
                        Respetamos tu tiempo. Sistema de citas organizado para minimizar 
                        la espera y maximizar tu experiencia.
                    </p>
                </article>

                <article class="why-card" role="listitem">
                    <div class="why-icon" aria-hidden="true">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="why-title" id="why-3">Higiene Impecable</h3>
                    <p class="why-text" aria-describedby="why-3">
                        Protocolos estrictos de limpieza y desinfeccion. Tu salud y 
                        seguridad son nuestra prioridad.
                    </p>
                </article>

                <article class="why-card" role="listitem">
                    <div class="why-icon" aria-hidden="true">
                        <i class="fas fa-couch"></i>
                    </div>
                    <h3 class="why-title" id="why-4">Ambiente Premium</h3>
                    <p class="why-text" aria-describedby="why-4">
                        Espacio disenado para tu comodidad con ambiente masculino, 
                        moderno y relajante.
                    </p>
                </article>

                <article class="why-card" role="listitem">
                    <div class="why-icon" aria-hidden="true">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h3 class="why-title" id="why-5">Formacion Continua</h3>
                    <p class="why-text" aria-describedby="why-5">
                        Nuestro equipo se capacita constantemente en las ultimas 
                        tendencias y tecnicas de barberia mundial.
                    </p>
                </article>

                <article class="why-card" role="listitem">
                    <div class="why-icon" aria-hidden="true">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h3 class="why-title" id="why-6">Atencion Personalizada</h3>
                    <p class="why-text" aria-describedby="why-6">
                        Cada cliente es unico. Escuchamos tus preferencias y 
                        asesoramos para lograr tu mejor version.
                    </p>
                </article>
            </div>
        </div>
    </section>

    <!-- Testimonios -->
    <section class="testimonials-section" role="region" aria-labelledby="testimonials-title">
        <div class="container">
            <div class="section-header">
                <span class="section-badge" aria-hidden="true">Opiniones</span>
                <h2 class="section-title" id="testimonials-title">Lo Que Dicen Nuestros Clientes</h2>
            </div>

            <div class="testimonials-grid" role="list">
                <article class="testimonial-card" role="listitem">
                    <div class="testimonial-stars" aria-label="Puntuación: 5 de 5 estrellas">
                        <i class="fas fa-star" aria-hidden="true"></i>
                        <i class="fas fa-star" aria-hidden="true"></i>
                        <i class="fas fa-star" aria-hidden="true"></i>
                        <i class="fas fa-star" aria-hidden="true"></i>
                        <i class="fas fa-star" aria-hidden="true"></i>
                    </div>
                    <p class="testimonial-text">
                        "La mejor barberia de la ciudad sin duda. El ambiente es increible y 
                        los barberos son verdaderos profesionales. Siempre salgo satisfecho."
                    </p>
                    <div class="testimonial-author">
                        <div class="author-avatar" aria-hidden="true">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="author-info">
                            <span class="author-name">Juan Perez</span>
                            <span class="author-time">Cliente hace 3 anos</span>
                        </div>
                    </div>
                </article>

                <article class="testimonial-card" role="listitem">
                    <div class="testimonial-stars" aria-label="Puntuación: 5 de 5 estrellas">
                        <i class="fas fa-star" aria-hidden="true"></i>
                        <i class="fas fa-star" aria-hidden="true"></i>
                        <i class="fas fa-star" aria-hidden="true"></i>
                        <i class="fas fa-star" aria-hidden="true"></i>
                        <i class="fas fa-star" aria-hidden="true"></i>
                    </div>
                    <p class="testimonial-text">
                        "Encontre mi barberia de por vida. La atencion es de primera, 
                        los productos que usan son excelentes y el resultado siempre supera mis expectativas."
                    </p>
                    <div class="testimonial-author">
                        <div class="author-avatar" aria-hidden="true">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="author-info">
                            <span class="author-name">Roberto Garcia</span>
                            <span class="author-time">Cliente hace 2 anos</span>
                        </div>
                    </div>
                </article>

                <article class="testimonial-card" role="listitem">
                    <div class="testimonial-stars" aria-label="Puntuación: 5 de 5 estrellas">
                        <i class="fas fa-star" aria-hidden="true"></i>
                        <i class="fas fa-star" aria-hidden="true"></i>
                        <i class="fas fa-star" aria-hidden="true"></i>
                        <i class="fas fa-star" aria-hidden="true"></i>
                        <i class="fas fa-star" aria-hidden="true"></i>
                    </div>
                    <p class="testimonial-text">
                        "El afeitado con navaja es una experiencia unica. Andres es un maestro 
                        en lo que hace. El programa de fidelidad es un gran plus."
                    </p>
                    <div class="testimonial-author">
                        <div class="author-avatar" aria-hidden="true">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="author-info">
                            <span class="author-name">David Martinez</span>
                            <span class="author-time">Cliente hace 1 ano</span>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section" role="region" aria-labelledby="cta-title">
        <div class="container">
            <div class="cta-content">
                <h2 class="cta-title" id="cta-title">Forma Parte de la Experiencia H Barber Shop</h2>
                <p class="cta-text">
                    Reserva tu cita hoy y descubre por que miles de clientes confian en nosotros 
                    para lucir su mejor version.
                </p>
                <div class="cta-buttons">
                    <a href="{{ route('servicios') }}" class="btn btn-primary" aria-label="Ver servicios disponibles">
                        <i class="fas fa-cut" aria-hidden="true"></i>
                        Ver Servicios
                    </a>
                    <a href="{{ route('agendar') }}" class="btn btn-secondary" aria-label="Reservar una cita en línea">
                        <i class="fas fa-calendar-alt" aria-hidden="true"></i>
                        Reservar Cita
                    </a>
                </div>
            </div>
        </div>
    </section>

    </main>
</body>
@endsection

@push('scripts')
    
@endpush

@push('styles')

@endpush 