@extends('layouts.blog')

@section('og_type', 'blog')

@section('content')
@vite(['resources/css/Home/membresias.css'])

{{-- HERO (mismo estilo que el blog) --}}
<section class="membresias-hero" role="banner" aria-label="Encabezado de membresías"
    style="background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('{{ asset('img/13.png') }}');
           background-size: cover; background-position: center; background-attachment: fixed;">
    <div class="container">
        <h1 class="membresias-hero__titulo">Nuestras <span class="gold-text">Membresías</span></h1>
        <p class="membresias-hero__subtitulo">Accede a beneficios exclusivos y ahorra en cada visita con uno de nuestros planes.</p>
    </div>
</section>



{{-- GRID DE MEMBRESÍAS --}}
<main class="membresias-main" role="main" aria-label="Planes de membresía">
    <div class="container">

        

        @if($membresias->isEmpty())
            <div class="no-membresias" role="status" aria-live="polite">
                <i class="fas fa-id-card" aria-hidden="true"></i>
                <h3>Próximamente</h3>
                <p>Pronto tendremos planes disponibles. ¡Vuelve pronto!</p>
            </div>
        @else
            <div class="membresias-grid" role="list" aria-label="Planes de membresía disponibles">
                @foreach($membresias as $m)
                @php
                    $esPopular = $m->es_popular ?? false;
                @endphp
                <article class="membresia-card {{ $esPopular ? 'membresia-card--popular' : '' }}"
                         role="listitem"
                         aria-label="Plan {{ $m->nombre }}">

                    {{-- Imagen --}}
                    @if($m->imagen)
                        <div class="membresia-card__imagen">
                            <img src="{{ asset('storage/' . $m->imagen) }}"
                                 alt="Imagen del plan {{ $m->nombre }}"
                                 loading="lazy">
                            <span class="membresia-card__badge">
                                {{ $esPopular ? 'Popular' : 'Plan' }}
                            </span>
                        </div>
                    @else
                        <div class="membresia-card__imagen membresia-card__imagen--placeholder" aria-hidden="true">
                            <span>✂</span>
                            <span class="membresia-card__badge">
                                {{ $esPopular ? 'Popular' : 'Plan' }}
                            </span>
                        </div>
                    @endif

                    {{-- Contenido --}}
                    <div class="membresia-card__body">

                        {{-- Meta: duración + tipo --}}
                        <div class="membresia-card__meta">
                            <span>
                                <i class="far fa-clock" aria-hidden="true"></i>
                                {{ $m->etiquetaDuracion() }}
                            </span>
                            @if($m->tipo ?? false)
                            <span>
                                <i class="fas fa-tag" aria-hidden="true"></i>
                                {{ ucfirst($m->tipo) }}
                            </span>
                            @endif
                        </div>

                        {{-- Nombre --}}
                        <h2 class="membresia-card__nombre">{{ $m->nombre }}</h2>

                        {{-- Descripción --}}
                        @if($m->descripcion)
                            <p class="membresia-card__descripcion">{{ $m->descripcion }}</p>
                        @endif

                        {{-- Precio --}}
                        <div class="membresia-card__precio"
                             aria-label="Precio: {{ number_format($m->precio, 2) }} pesos colombianos">
                            <span class="membresia-card__precio-valor">
                                ${{ number_format($m->precio, 0, ',', '.') }}
                            </span>
                            <span class="membresia-card__precio-periodo">
                                / {{ $m->etiquetaDuracion() }}
                            </span>
                        </div>

                        {{-- Servicios incluidos como tags --}}
                        @if(!empty($m->servicios_incluidos))
                            <div class="membresia-card__servicios" aria-label="Servicios incluidos">
                                @foreach($m->servicios_incluidos as $servicio)
                                    <span class="membresia-card__servicio-tag">{{ $servicio }}</span>
                                @endforeach
                            </div>
                        @endif

                        {{-- Beneficios --}}
                        @if(!empty($m->beneficiosLista()))
                            <ul class="membresia-card__beneficios"
                                aria-label="Beneficios del plan {{ $m->nombre }}">
                                @foreach($m->beneficiosLista() as $b)
                                    <li>
                                        <span class="membresia-card__check" aria-hidden="true">
                                            <i class="fas fa-check"></i>
                                        </span>
                                        {{ $b }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    

                    {{-- Footer (mismo layout que article-footer) --}}
                    <div class="membresia-card__footer">
                        @php
                            $whatsappMsg = urlencode("Hola, estoy interesado en la membresía *{$m->nombre}* (". $m->etiquetaDuracion() ."). ¿Me pueden dar más información?");
                            $whatsappNum = config('app.whatsapp_number', '573118104544');
                        @endphp
                        <span class="membresia-card__author">
                            <i class="fas fa-shield-alt" aria-hidden="true"></i>
                            H Barber Shop
                        </span>
                        <a href="https://wa.me/{{ $whatsappNum }}?text={{ $whatsappMsg }}"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="btn-adquirir {{ $esPopular ? 'btn-adquirir--destacado' : '' }}"
                           aria-label="Adquirir membresía {{ $m->nombre }} vía WhatsApp">
                            Adquirir <i class="fas fa-arrow-right" aria-hidden="true"></i>
                        </a>
                    </div>

                </article>
                @endforeach
            </div>
        @endif

    </div>
</main>

{{-- SECCIÓN INTRO: 3 ventajas rápidas --}}
<section class="membresias-intro" aria-label="Ventajas de ser miembro">
    <div class="container">
        <div class="membresias-intro__grid">
            <div class="membresias-intro__item">
                <div class="membresias-intro__icon">
                    <i class="fas fa-percentage" aria-hidden="true"></i>
                </div>
                <h3>Descuentos Exclusivos</h3>
                <p>Ahorra en cada visita con precios especiales solo para miembros.</p>
            </div>
            <div class="membresias-intro__item">
                <div class="membresias-intro__icon">
                    <i class="fas fa-calendar-check" aria-hidden="true"></i>
                </div>
                <h3>Reserva Prioritaria</h3>
                <p>Agenda tu cita antes que nadie y elige el horario que prefieras.</p>
            </div>
            <div class="membresias-intro__item">
                <div class="membresias-intro__icon">
                    <i class="fas fa-gift" aria-hidden="true"></i>
                </div>
                <h3>Beneficios Adicionales</h3>
                <p>Productos gratis, descuentos en tienda y sorpresas cada mes.</p>
            </div>
        </div>
    </div>
</section>


@endsection

@push('scripts')
@endpush

@push('styles')
@endpush
