@extends('layouts.blog')

@section('og_type', 'blog')

@section('content')

@vite('resources/css/Blog/show.css')
{{-- Breadcrumbs con Schema.org --}}
<nav class="breadcrumbs" aria-label="Breadcrumb">
    <div class="container">
        <ol itemscope itemtype="https://schema.org/BreadcrumbList">
            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <a itemprop="item" href="{{ route('welcome') }}">
                    <span itemprop="name">Inicio</span>
                </a>
                <meta itemprop="position" content="1" />
            </li>
            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <a itemprop="item" href="{{ route('blog.index') }}">
                    <span itemprop="name">Blog</span>
                </a>
                <meta itemprop="position" content="2" />
            </li>
            @if($article->category)
            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <a itemprop="item" href="{{ route('blog.category', $article->category) }}">
                    <span itemprop="name">{{ $article->category_name }}</span>
                </a>
                <meta itemprop="position" content="3" />
            </li>
            @endif
            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <span itemprop="name">{{ Str::limit($article->title, 50) }}</span>
                <meta itemprop="position" content="{{ $article->category ? 4 : 3 }}" />
            </li>
        </ol>
    </div>
</nav>

<main>
    <article class="article-single" itemscope itemtype="https://schema.org/BlogPosting">
        {{-- Article Header --}}
        <header class="article-header">
            <div class="container">
                @if($article->category)
                    <a href="{{ route('blog.category', $article->category) }}" class="article-category-link">
                        {{ $article->category_name }}
                    </a>
                @endif
                
                <h1 itemprop="headline">{{ $article->title }}</h1>
                
                <div class="article-meta-header">
                    <div class="author-info" itemprop="author" itemscope itemtype="https://schema.org/Person">
                        <div class="author-avatar">
                            <i class="fas fa-user" aria-hidden="true"></i>
                        </div>
                        <div>
                            <span class="author-name" itemprop="name">
                                {{ $article->author?->persona?->per_nombres ?? 'H Barber Shop' }}
                            </span>
                            <time datetime="{{ $article->published_at->toIso8601String() }}" itemprop="datePublished">
                                {{ $article->published_at->format('d \d\e F, Y') }}
                            </time>
                        </div>
                    </div>
                    
                    <div class="article-stats" role="group" aria-label="Estadísticas del artículo">
                        <span><i class="far fa-clock" aria-hidden="true"></i> {{ $article->reading_time }} min lectura</span>
                        <span><i class="far fa-eye" aria-hidden="true"></i> {{ number_format($article->views) }} vistas</span>
                        <span><i class="far fa-comment" aria-hidden="true"></i> {{ $article->approvedComments->count() }} comentarios</span>
                    </div>
                </div>
            </div>
        </header>
        
        {{-- Featured Image --}}
        @if($article->featured_image)
        <div class="article-featured-image">
            <div class="container">
                <img src="{{ $article->featured_image_url }}" 
                     alt="{{ $article->featured_image_alt ?: $article->title }}"
                     itemprop="image">
            </div>
        </div>
        @endif
        
        {{-- Article Content --}}
        <div class="article-body">
            <div class="container">
                <div class="article-content-wrapper">
                    {{-- Main Content --}}
                    <div class="article-content" itemprop="articleBody">
                        @if(isset($isPreview) && $isPreview)
                            <div class="preview-notice" role="alert">
                                <i class="fas fa-eye" aria-hidden="true"></i> Vista previa - Este artículo no está publicado
                            </div>
                        @endif
                        
                        {!! $article->content !!}
                    </div>
                    
                    {{-- Sidebar --}}
                    <aside class="article-sidebar" aria-label="Barra lateral del artículo">
                        {{-- Share Buttons --}}
                        <div class="share-box">
                            <h4>Compartir artículo</h4>
                            <div class="share-buttons" role="group" aria-label="Compartir en redes sociales">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($article->url) }}" 
                                   target="_blank" rel="noopener" class="share-btn facebook" aria-label="Compartir en Facebook">
                                    <i class="fab fa-facebook-f" aria-hidden="true"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode($article->url) }}&text={{ urlencode($article->title) }}" 
                                   target="_blank" rel="noopener" class="share-btn twitter" aria-label="Compartir en Twitter">
                                    <i class="fab fa-twitter" aria-hidden="true"></i>
                                </a>
                                <a href="https://wa.me/?text={{ urlencode($article->title . ' ' . $article->url) }}" 
                                   target="_blank" rel="noopener" class="share-btn whatsapp" aria-label="Compartir en WhatsApp">
                                    <i class="fab fa-whatsapp" aria-hidden="true"></i>
                                </a>
                                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode($article->url) }}&title={{ urlencode($article->title) }}" 
                                   target="_blank" rel="noopener" class="share-btn linkedin" aria-label="Compartir en LinkedIn">
                                    <i class="fab fa-linkedin-in" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                        
                        {{-- CTA Box --}}
                        <div class="cta-box" role="region" aria-label="Llamado a la acción">
                            <h4>¿Te gustó este artículo?</h4>
                            <p>Agenda tu cita y déjate asesorar por nuestros expertos barberos.</p>
                            <a href="{{ route('agendar') }}" class="btn-cta" aria-label="Agendar una cita en la barbería">
                                <i class="fas fa-calendar-check" aria-hidden="true"></i> Agendar Cita
                            </a>
                        </div>
                        
                        {{-- Categories --}}
                        <nav class="categories-box" aria-label="Categorías del blog">
                            <h4>Categorías</h4>
                            <ul>
                                @foreach(\App\Models\Article::CATEGORIES as $key => $name)
                                    <li>
                                        <a href="{{ route('blog.category', $key) }}" 
                                           class="{{ $article->category === $key ? 'active' : '' }}" @if($article->category === $key) aria-current="page" @endif>
                                            {{ $name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </nav>
                    </aside>
                </div>
            </div>
        </div>
        
        {{-- Tags / Keywords --}}
        @if($article->meta_keywords)
        <div class="article-tags" role="list" aria-label="Etiquetas del artículo">
            <div class="container">
                <i class="fas fa-tags" aria-hidden="true"></i>
                @foreach(explode(',', $article->meta_keywords) as $keyword)
                    <span class="tag" role="listitem">{{ trim($keyword) }}</span>
                @endforeach
            </div>
        </div>
        @endif
    </article>
    
    {{-- Related Articles --}}
    @if($relatedArticles->count() > 0)
    <section class="related-articles" role="region" aria-label="Artículos relacionados">
        <div class="container">
            <h2>Artículos Relacionados</h2>
            <div class="related-grid" role="list">
                @foreach($relatedArticles as $related)
                    <article class="related-card" role="listitem">
                        <a href="{{ route('blog.show', $related->slug) }}" class="related-image" aria-label="Leer artículo: {{ $related->title }}">
                            <img src="{{ $related->featured_image_url }}" alt="{{ $related->title }}" loading="lazy">
                        </a>
                        <div class="related-content">
                            <time>{{ $related->published_at->format('d M, Y') }}</time>
                            <h3>
                                <a href="{{ route('blog.show', $related->slug) }}">{{ $related->title }}</a>
                            </h3>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
    @endif
    
    {{-- Comments Section --}}
    <section class="comments-section" id="comentarios" role="region" aria-label="Sección de comentarios">
        <div class="container">
            <h2><i class="far fa-comments" aria-hidden="true"></i> Comentarios ({{ $article->approvedComments->count() }})</h2>
            
            {{-- Comment Form --}}
            @if(!isset($isPreview))
            <div class="comment-form-wrapper">
                <h3>Deja tu comentario</h3>
                
                @if(session('success'))
                    <div class="alert alert-success" role="alert">
                        <i class="fas fa-check-circle" aria-hidden="true"></i> {{ session('success') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-error" role="alert">
                        <i class="fas fa-exclamation-circle" aria-hidden="true"></i> {{ session('error') }}
                    </div>
                @endif
                
                @if($errors->any())
                    <div class="alert alert-error" role="alert">
                        <i class="fas fa-exclamation-triangle" aria-hidden="true"></i>
                        <ul style="margin: 0; padding-left: 20px;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <form action="{{ route('comments.store', $article->id) }}" method="POST" class="comment-form" aria-label="Formulario para dejar un comentario">
                    @csrf
                    
                    @guest('usuario')
                        <div class="form-row">
                            <div class="form-group">
                                <label for="guest_name">Nombre *</label>
                                <input type="text" id="guest_name" name="guest_name" value="{{ old('guest_name') }}" required aria-required="true">
                                @error('guest_name')
                                    <span class="error" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="guest_email">Correo electrónico *</label>
                                <input type="email" id="guest_email" name="guest_email" value="{{ old('guest_email') }}" required aria-required="true">
                                @error('guest_email')
                                    <span class="error" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    @else
                        <p class="logged-as">
                            <i class="fas fa-user-check" aria-hidden="true"></i> Comentando como <strong>{{ Auth::guard('usuario')->user()->usuario }}</strong>
                        </p>
                    @endguest
                    
                    <div class="form-group">
                        <label for="content">Tu comentario *</label>
                        <textarea id="content" name="content" rows="4" required aria-required="true" placeholder="Escribe tu opinión sobre este artículo...">{{ old('content') }}</textarea>
                        @error('content')
                            <span class="error" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn-submit" aria-label="Publicar comentario">
                        <i class="fas fa-paper-plane" aria-hidden="true"></i> Publicar Comentario
                    </button>
                </form>
            </div>
            @endif
            
            {{-- Comments List --}}
            <div class="comments-list" role="list" aria-label="Lista de comentarios">
                @forelse($article->approvedComments as $comment)
                    <div class="comment" id="comment-{{ $comment->id }}" role="listitem">
                        <div class="comment-avatar" aria-hidden="true">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="comment-body">
                            <div class="comment-header">
                                <span class="comment-author">
                                    {{ $comment->author_name }}
                                    @if($comment->isFromRegisteredUser())
                                        <span class="verified-badge" title="Usuario verificado" aria-label="Usuario verificado">
                                            <i class="fas fa-check-circle" aria-hidden="true"></i>
                                        </span>
                                    @endif
                                </span>
                                <time datetime="{{ $comment->created_at->toIso8601String() }}">
                                    {{ $comment->created_at->diffForHumans() }}
                                </time>
                            </div>
                            <div class="comment-content">
                                {{ $comment->content }}
                            </div>
                            
                            {{-- Replies --}}
                            @if($comment->replies->count() > 0)
                                <div class="comment-replies">
                                    @foreach($comment->replies as $reply)
                                        <div class="comment reply" id="comment-{{ $reply->id }}" role="listitem">
                                            <div class="comment-avatar small" aria-hidden="true">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div class="comment-body">
                                                <div class="comment-header">
                                                    <span class="comment-author">
                                                        {{ $reply->author_name }}
                                                        @if($reply->isFromRegisteredUser())
                                                            <span class="verified-badge" aria-label="Usuario verificado">
                                                                <i class="fas fa-check-circle" aria-hidden="true"></i>
                                                            </span>
                                                        @endif
                                                    </span>
                                                    <time>{{ $reply->created_at->diffForHumans() }}</time>
                                                </div>
                                                <div class="comment-content">
                                                    {{ $reply->content }}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="no-comments" role="status">
                        <i class="far fa-comment-dots" aria-hidden="true"></i>
                        Sé el primero en comentar este artículo.
                    </p>
                @endforelse
            </div>
        </div>
    </section>
</main>

{{-- JSON-LD Structured Data --}}
<script type="application/ld+json">
@php
$jsonLd = [
    '@context' => 'https://schema.org',
    '@type' => 'BlogPosting',
    'mainEntityOfPage' => [
        '@type' => 'WebPage',
        '@id' => url()->current()
    ],
    'headline' => $article->title,
    'description' => $article->meta_description ?? Str::limit(strip_tags($article->content), 160),
    'image' => $article->featured_image ? asset($article->featured_image) : asset('img/default-blog.jpg'),
    'author' => [
        '@type' => 'Person',
        'name' => $article->author?->persona?->per_nombres ?? 'H Barber Shop'
    ],
    'publisher' => [
        '@type' => 'Organization',
        'name' => 'H Barber Shop',
        'logo' => [
            '@type' => 'ImageObject',
            'url' => asset('img/1.png')
        ]
    ],
    'datePublished' => $article->published_at ? $article->published_at->toIso8601String() : $article->created_at->toIso8601String(),
    'dateModified' => $article->updated_at->toIso8601String(),
    'wordCount' => str_word_count(strip_tags($article->content)),
    'commentCount' => $article->approvedComments ? $article->approvedComments->count() : 0
];
@endphp
{!! json_encode($jsonLd, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT) !!}
</script>
@endsection

@push('styles')

@endpush
