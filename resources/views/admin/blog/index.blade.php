@extends('admin.layout')

@section('content')
@vite(['resources/css/Blog/admin/index.css'])
<main class="admin-blog-container" aria-label="Gestión del Blog">
    <header class="page-header">
        <div class="header-content">
            <h1>Gestión del Blog</h1>
            <p>Administra los artículos del blog de la barbería</p>
        </div>
        <a href="{{ route('admin.blog.create') }}" class="btn-primary" aria-label="Crear nuevo artículo">
            <span aria-hidden="true">➕</span> <span>Nuevo Artículo</span>
        </a>
    </header>

    @if(session('success'))
        <div class="alert alert-success" role="alert">
            <span aria-hidden="true">✅</span> <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- Filtros --}}
    <section class="filters-section" aria-label="Filtros de artículos">
        <form action="{{ route('admin.blog.index') }}" method="GET" class="filters-form">
            <div class="filter-group">
                <label for="search">Buscar</label>
                <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Título o contenido..." aria-label="Buscar por título o contenido">
            </div>
            <div class="filter-group">
                <label for="status">Estado</label>
                <select name="status" id="status" aria-label="Filtrar por estado">
                    <option value="">Todos</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Borrador</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Publicado</option>
                    <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Archivado</option>
                </select>
            </div>
            <div class="filter-group">
                <label for="category">Categoría</label>
                <select name="category" id="category" aria-label="Filtrar por categoría">
                    <option value="">Todas</option>
                    @foreach($categories as $key => $name)
                        <option value="{{ $key }}" {{ request('category') == $key ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter-actions">
                <button type="submit" class="btn-filter" aria-label="Filtrar artículos"><span aria-hidden="true">🔍</span> <span>Filtrar</span></button>
                <a href="{{ route('admin.blog.index') }}" class="btn-clear" aria-label="Limpiar filtros">Limpiar</a>
            </div>
        </form>
    </section>

    {{-- Tabla de artículos --}}
    <section class="table-container" aria-label="Tabla de artículos">
        <!-- Lista vertical accesible solo para lectores de pantalla -->
        <ul class="sr-only" aria-label="Lista de artículos del blog detallada">
            @forelse($articles as $article)
                <li>
                    <strong>Título:</strong> {{ $article->title }}<br>
                    <strong>Categoría:</strong> {{ $article->category_name ?? 'Sin categoría' }}<br>
                    <strong>Estado:</strong>
                        @switch($article->status)
                            @case('draft') Borrador @break
                            @case('published') Publicado @break
                            @case('archived') Archivado @break
                            @default {{ ucfirst($article->status) }}
                        @endswitch<br>
                    <strong>Autor:</strong> {{ $article->author?->persona?->per_nombres ?? 'N/A' }}<br>
                    <strong>Vistas:</strong> {{ number_format($article->views) }}<br>
                    <strong>Fecha:</strong>
                        @if($article->published_at)
                            {{ \Carbon\Carbon::parse($article->published_at)->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }}
                        @else
                            —
                        @endif

                    <strong>Acciones:</strong>
                    <a href="{{ route('admin.blog.edit', $article) }}" class="btn-action    btn-edit" aria-label="Editar artículo {{ $article->title }}">Editar</a>
                    <button type="button" class="btn-action btn-delete" data-article-id="{{ $article->id }}" data-article-title="{{ $article->title }}" aria-label="Eliminar artículo {{ $article->title }}">Eliminar</button>
                </li>
            @empty
                <li>No hay artículos</li>
            @endforelse
        </ul>

        <table class="articles-table" aria-describedby="captionBlogArticulos">
            <caption id="captionBlogArticulos">Lista de artículos del blog</caption>
            <thead>
                <tr>
                    <th scope="col">Imagen</th>
                    <th scope="col">Título</th>
                    <th scope="col">Categoría</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Autor</th>
                    <th scope="col">Vistas</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($articles as $article)
                    <tr>
                        <td class="image-cell">
                            <img src="{{ $article->featured_image_url }}" alt="Imagen destacada de {{ $article->title }}" width="80" height="60">
                        </td>
                        <td class="title-cell">
                            <strong>{{ Str::limit($article->title, 50) }}</strong>
                            <span class="slug">/blog/{{ $article->slug }}</span>
                        </td>
                        <td>
                            @if($article->category)
                                <span class="category-badge">{{ $article->category_name }}</span>
                            @else
                                <span class="text-muted">Sin categoría</span>
                            @endif
                        </td>
                        <td>
                            <span class="status-badge status-{{ $article->status }}">
                                @switch($article->status)
                                    @case('draft') <span aria-label="Borrador">📝 Borrador</span> @break
                                    @case('published') <span aria-label="Publicado">✅ Publicado</span> @break
                                    @case('archived') <span aria-label="Archivado">📦 Archivado</span> @break
                                @endswitch
                            </span>
                        </td>
                        <td>{{ $article->author?->persona?->per_nombres ?? 'N/A' }}</td>
                        <td>{{ number_format($article->views) }}</td>
                        <td>
                            @if($article->published_at)
                                {{ $article->published_at->format('d/m/Y') }}
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td class="actions-cell">
                            <a href="{{ route('admin.blog.edit', $article) }}" class="btn-action btn-edit">✏️ Editar</a>
                            <button type="button" class="btn-action btn-delete" data-article-id="{{ $article->id }}" data-article-title="{{ $article->title }}">🗑️ Eliminar</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="empty-state">
                            <div class="empty-icon" aria-hidden="true">📝</div>
                            <p>No hay artículos</p>
                            <a href="{{ route('admin.blog.create') }}" class="btn-primary" aria-label="Crear primer artículo">Crear primer artículo</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>

    {{-- Paginación --}}
    @if($articles->hasPages())
        <nav class="pagination-wrapper" aria-label="Paginación de artículos">
            {{ $articles->withQueryString()->links() }}
        </nav>
    @endif
</main>

<!-- Modal de confirmación de eliminación -->
<div id="deleteModal" class="modal-overlay" style="display: none;" role="dialog" aria-modal="true" aria-labelledby="deleteModalTitle" aria-describedby="deleteModalDesc">
    <div class="modal-content">
        <div class="modal-header">
            <h2 id="deleteModalTitle">Confirmar eliminación</h2>
            <button class="modal-close" data-close-modal aria-label="Cerrar ventana de confirmación">&times;</button>
        </div>
        <div class="modal-body">
            <p id="deleteModalDesc">¿Estás seguro de que deseas eliminar el artículo <strong id="articleTitle"></strong>?</p>
            <p class="modal-warning">Esta acción no se puede deshacer.</p>
        </div>
        <div class="modal-footer">
            <button class="btn-modal btn-cancel" data-close-modal>Cancelar</button>
            <form id="deleteForm" action="" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-modal btn-confirm-delete">Eliminar permanentemente</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteModal = document.getElementById('deleteModal');
        const deleteForm = document.getElementById('deleteForm');
        const articleTitle = document.getElementById('articleTitle');
        const deleteButtons = document.querySelectorAll('.btn-delete');
        const closeModalButtons = document.querySelectorAll('[data-close-modal]');
        let lastFocusedElement = null;

        // Abrir modal de eliminación (click, Enter, Space)
        deleteButtons.forEach(btn => {
            const openModal = function() {
                lastFocusedElement = document.activeElement;
                const articleId = this.getAttribute('data-article-id');
                const title = this.getAttribute('data-article-title');
                articleTitle.textContent = title;
                deleteForm.action = '/admin/blog/' + articleId;
                deleteModal.style.display = 'flex';
                // Mover foco al botón cancelar para accesibilidad
                setTimeout(() => {
                    const cancelBtn = deleteModal.querySelector('.btn-cancel');
                    if (cancelBtn) cancelBtn.focus();
                }, 100);
                // Ocultar fondo a lectores de pantalla
                document.body.setAttribute('aria-hidden', 'true');
                deleteModal.setAttribute('aria-hidden', 'false');
            };
            btn.addEventListener('click', openModal);
            btn.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    openModal.call(this);
                }
            });
        });

        // Cerrar modal
        function closeModal() {
            deleteModal.style.display = 'none';
            // Restaurar foco
            if (lastFocusedElement) lastFocusedElement.focus();
            // Restaurar accesibilidad
            document.body.removeAttribute('aria-hidden');
            deleteModal.setAttribute('aria-hidden', 'true');
        }
        closeModalButtons.forEach(btn => {
            btn.addEventListener('click', closeModal);
        });

        // Cerrar modal al hacer clic fuera
        deleteModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Cerrar modal con Escape y mantener foco dentro del modal
        document.addEventListener('keydown', function(e) {
            if (deleteModal.style.display === 'flex') {
                if (e.key === 'Escape') {
                    closeModal();
                }
                // Trampa de foco dentro del modal
                if (e.key === 'Tab') {
                    const focusable = deleteModal.querySelectorAll('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
                    const focusableArr = Array.prototype.slice.call(focusable);
                    const first = focusableArr[0];
                    const last = focusableArr[focusableArr.length - 1];
                    if (e.shiftKey) {
                        if (document.activeElement === first) {
                            e.preventDefault();
                            last.focus();
                        }
                    } else {
                        if (document.activeElement === last) {
                            e.preventDefault();
                            first.focus();
                        }
                    }
                }
            }
        });
    });
</script>

@endsection
