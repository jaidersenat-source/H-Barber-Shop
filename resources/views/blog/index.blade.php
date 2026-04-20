@extends('layouts.blog')

@section('og_type', 'blog')

@section('content')
<header class="blog-header" role="banner" aria-label="Encabezado del blog" style="background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('{{ asset('img/7.jpg') }}'); background-size: cover; background-position: center; background-attachment: fixed;">
    <div class="container">
        <h1>{{ $categoryName ?? 'Blog de Barbería' }}</h1>
        <p>Consejos de estilo, tendencias en cortes de cabello, cuidado de barba y las últimas novedades de nuestra barbería.</p>
    </div>
</header>
@vite(['resources/css/Blog/index.css'])
<main role="main" aria-label="Contenido del blog">
    <div class="container">
        {{-- Filtros y búsqueda --}}
        <div class="blog-filters" role="search" aria-label="Buscar y filtrar artículos">
            <form action="{{ route('blog.index') }}" method="GET" class="search-form" role="search" aria-label="Buscar artículos en el blog">
                <div class="search-input-wrapper">
                    <i class="fas fa-search" aria-hidden="true"></i>
                    <input type="text" name="buscar" placeholder="Buscar artículos..." value="{{ request('buscar') }}" aria-label="Término de búsqueda">
                </div>
                <button type="submit" class="btn-search" aria-label="Ejecutar búsqueda">Buscar</button>
            </form>
            
            <nav class="category-filters" role="navigation" aria-label="Filtros por categoría">
                <a href="{{ route('blog.index') }}" class="{{ !request('categoria') && !isset($categoryName) ? 'active' : '' }}" @if(!request('categoria') && !isset($categoryName)) aria-current="page" @endif>
                    Todos
                </a>
                @foreach($categories as $key => $name)
                    <a href="{{ route('blog.category', $key) }}" 
                       class="{{ (isset($categoryName) && $categoryName === $name) || request('categoria') === $key ? 'active' : '' }}"
                       @if((isset($categoryName) && $categoryName === $name) || request('categoria') === $key) aria-current="page" @endif>
                        {{ $name }}
                    </a>
                @endforeach
            </nav>
        </div>
        
        {{-- Grid de artículos --}}
        @if($articles->count() > 0)
            <div class="articles-grid" role="list" aria-label="Lista de artículos del blog">
                @foreach($articles as $article)
                    <article class="article-card" itemscope itemtype="https://schema.org/BlogPosting" role="listitem">
                        <a href="{{ route('blog.show', $article->slug) }}" class="article-image">
                            <img src="{{ $article->featured_image_url }}" 
                                 alt="{{ $article->featured_image_alt ?: $article->title }}"
                                 loading="lazy"
                                 itemprop="image">
                            @if($article->category)
                                <span class="article-category">{{ $article->category_name }}</span>
                            @endif
                        </a>
                        
                        <div class="article-content">
                            <div class="article-meta">
                                <time datetime="{{ $article->published_at->toIso8601String() }}" itemprop="datePublished">
                                    <i class="far fa-calendar" aria-hidden="true"></i>
                                    {{ $article->published_at->format('d M, Y') }}
                                </time>
                                <span><i class="far fa-clock" aria-hidden="true"></i> {{ $article->reading_time }} min lectura</span>
                            </div>
                            
                            <h2 itemprop="headline">
                                <a href="{{ route('blog.show', $article->slug) }}">
                                    {{ $article->title }}
                                </a>
                            </h2>
                            
                            <p itemprop="description">
                                {{ $article->excerpt ?: Str::limit(strip_tags($article->content), 150) }}
                            </p>
                            
                            <div class="article-footer">
                                <span class="article-author" itemprop="author">
                                    <i class="far fa-user" aria-hidden="true"></i>
                                    {{ $article->author?->persona?->per_nombres ?? 'H Barber Shop' }}
                                </span>
                                <a href="{{ route('blog.show', $article->slug) }}" class="read-more" aria-label="Leer artículo completo: {{ $article->title }}">
                                    Leer más <i class="fas fa-arrow-right" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
            {{-- Paginación --}}
            <div class="pagination-wrapper" role="navigation" aria-label="Paginación de artículos">
                {{ $articles->withQueryString()->links() }}
            </div>
        @else
            <div class="no-articles" role="status" aria-live="polite">
                <i class="fas fa-newspaper" aria-hidden="true"></i>
                <h3>No hay artículos disponibles</h3>
                <p>Pronto publicaremos contenido interesante. ¡Vuelve pronto!</p>
                @if(request()->hasAny(['buscar', 'categoria']))
                    <a href="{{ route('blog.index') }}" class="btn-primary">Ver todos los artículos</a>
                @endif
            </div>
        @endif
    </div>
</main>

{{-- JSON-LD Structured Data --}}
<script type="application/ld+json">
@php
    $blogJsonLd = [
        '@context' => 'https://schema.org',
        '@type' => 'Blog',
        'name' => 'Blog de H Barber Shop',
        'description' => $seo['description'],
        'url' => route('blog.index'),
        'publisher' => [
            '@type' => 'Organization',
            'name' => 'H Barber Shop',
            'logo' => [
                '@type' => 'ImageObject',
                'url' => asset('img/1.png'),
            ],
        ],
    ];
@endphp
{!! json_encode($blogJsonLd, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT) !!}
</script>


@endsection

@push('styles')

@endpush
