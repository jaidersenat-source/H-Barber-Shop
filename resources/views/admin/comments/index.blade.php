@extends('admin.layout')

@section('content')
@vite(['resources/css/Blog/admin/comentario.css'])
<main class="comments-container" aria-label="Moderación de comentarios">
    <header class="page-header">
        <div class="header-content">
            <h1>Moderación de Comentarios</h1>
            <p>Administra los comentarios del blog</p>
        </div>
        @if($pendingCount > 0)
            <div class="pending-badge" aria-label="Comentarios pendientes">
                <span>{{ $pendingCount }}</span> pendientes
            </div>
        @endif
    </header>

    @if(session('success'))
        <div class="alert alert-success" role="alert"><span aria-hidden="true">✅</span> <span>{{ session('success') }}</span></div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger" role="alert"><span aria-hidden="true">⚠️</span> <span>{{ session('error') }}</span></div>
    @endif

    {{-- Filtros --}}
    <section class="filters-section" aria-label="Filtros de comentarios">
        <form action="{{ route('admin.comments.index') }}" method="GET" class="filters-form" aria-label="Filtrar comentarios">
            <div class="filter-group">
                <label for="status">Estado</label>
                <select name="status" id="status" aria-label="Filtrar por estado">
                    <option value="">Todos</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pendientes</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Aprobados</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rechazados</option>
                </select>
            </div>
            <div class="filter-group">
                <label for="article_id">Artículo</label>
                <select name="article_id" id="article_id" aria-label="Filtrar por artículo">
                    <option value="">Todos los artículos</option>
                    @foreach($articles as $article)
                        <option value="{{ $article->id }}" {{ request('article_id') == $article->id ? 'selected' : '' }}>
                            {{ Str::limit($article->title, 50) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="filter-actions">
                <button type="submit" class="btn-filter" aria-label="Filtrar comentarios"><span aria-hidden="true">🔍</span> <span>Filtrar</span></button>
                <a href="{{ route('admin.comments.index') }}" class="btn-clear" aria-label="Limpiar filtros">Limpiar</a>
            </div>
        </form>
    </section>

    {{-- Acciones masivas --}}
    <div class="bulk-actions" id="bulk-actions" style="display: none;" aria-label="Acciones masivas">
        <span class="selected-count">
            <span id="selected-count">0</span> seleccionados
        </span>
        
        <!-- Formulario para aprobar -->
        <form id="bulk-approve-form" action="{{ route('admin.comments.bulk-approve') }}" method="POST" style="display: inline;">
            @csrf
        </form>
        
        <!-- Formulario para rechazar -->
        <form id="bulk-reject-form" action="{{ route('admin.comments.bulk-reject') }}" method="POST" style="display: inline;">
            @csrf
        </form>
        
        <!-- Formulario para eliminar -->
        <form id="bulk-destroy-form" action="{{ route('admin.comments.bulk-destroy') }}" method="POST" style="display: inline;">
            @csrf
        </form>
        
        <button type="button" onclick="bulkAction('approve')" class="btn-bulk btn-approve" aria-label="Aprobar comentarios seleccionados"><span aria-hidden="true">✅</span> <span>Aprobar</span></button>
        <button type="button" onclick="bulkAction('reject')" class="btn-bulk btn-reject" aria-label="Rechazar comentarios seleccionados"><span aria-hidden="true">❌</span> <span>Rechazar</span></button>
        <button type="button" onclick="bulkAction('delete')" class="btn-bulk btn-delete" aria-label="Eliminar comentarios seleccionados"><span aria-hidden="true">🗑️</span> <span>Eliminar</span></button>
    </div>

        {{-- Lista de comentarios --}}
        <section class="comments-list" aria-label="Lista de comentarios">
            @forelse($comments as $comment)
                <article class="comment-card status-{{ $comment->status }}" data-comment-id="{{ $comment->id }}" aria-label="Comentario de {{ $comment->author_name }}">
                    <div class="comment-checkbox">
                        <input type="checkbox" name="ids[]" value="{{ $comment->id }}" class="comment-select" aria-label="Seleccionar comentario de {{ $comment->author_name }}">
                    </div>
                    <div class="comment-main">
                        <div class="comment-header">
                            <div class="author-info">
                                <div class="author-avatar">
                                    @if($comment->user)
                                        <span class="registered" aria-label="Usuario registrado" aria-hidden="true">👤</span>
                                    @else
                                        <span class="guest" aria-label="Visitante" aria-hidden="true">👥</span>
                                    @endif
                                </div>
                                <div class="author-details">
                                    <span class="author-name">
                                        {{ $comment->author_name }}
                                        @if($comment->isFromRegisteredUser())
                                            <span class="badge badge-user">Usuario registrado</span>
                                        @else
                                            <span class="badge badge-guest">Visitante</span>
                                        @endif
                                    </span>
                                    @if($comment->guest_email)
                                        <span class="author-email">{{ $comment->guest_email }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="comment-meta">
                                <span class="status-badge status-{{ $comment->status }}">
                                    @switch($comment->status)
                                        @case('pending') <span aria-label="Pendiente">⏳ Pendiente</span> @break
                                        @case('approved') <span aria-label="Aprobado">✅ Aprobado</span> @break
                                        @case('rejected') <span aria-label="Rechazado">❌ Rechazado</span> @break
                                    @endswitch
                                </span>
                                <time>{{ $comment->created_at->diffForHumans() }}</time>
                            </div>
                        </div>
                        <div class="comment-article">
                            <span class="label">En:</span>
                            <a href="{{ route('blog.show', $comment->article->slug) }}" target="_blank" aria-label="Ver artículo relacionado: {{ $comment->article->title }}">
                                {{ Str::limit($comment->article->title, 60) }}
                            </a>
                            @if($comment->parent)
                                <span class="reply-to">
                                    ↳ Respuesta a: "{{ Str::limit($comment->parent->content, 30) }}"
                                </span>
                            @endif
                        </div>
                        <div class="comment-content">
                            <p>{{ $comment->content }}</p>
                        </div>
                        <div class="comment-actions">
                            @if($comment->status === 'pending')
                                <form action="{{ route('admin.comments.approve', $comment) }}" method="POST" class="inline-form">
                                    @csrf
                                    <button type="submit" class="btn-action btn-approve" title="Aprobar" aria-label="Aprobar comentario">Aprobar</button>
                                </form>
                                <form action="{{ route('admin.comments.reject', $comment) }}" method="POST" class="inline-form">
                                    @csrf
                                    <button type="submit" class="btn-action btn-reject" title="Rechazar" aria-label="Rechazar comentario">Rechazar</button>
                                </form>
                            @elseif($comment->status === 'approved')
                                <form action="{{ route('admin.comments.reject', $comment) }}" method="POST" class="inline-form">
                                    @csrf
                                    <button type="submit" class="btn-action btn-reject" title="Rechazar" aria-label="Rechazar comentario">Rechazar</button>
                                </form>
                            @elseif($comment->status === 'rejected')
                                <form action="{{ route('admin.comments.approve', $comment) }}" method="POST" class="inline-form">
                                    @csrf
                                    <button type="submit" class="btn-action btn-approve" title="Aprobar" aria-label="Aprobar comentario">Aprobar</button>
                                </form>
                            @endif
                            <form id="delete-form-{{ $comment->id }}" action="{{ route('admin.comments.destroy', $comment) }}" method="POST" class="inline-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn-action btn-delete" title="Eliminar"
                                    aria-label="Eliminar comentario de {{ $comment->author_name }}"
                                    onclick="abrirModalEliminarComentario({{ $comment->id }}, '{{ addslashes(Str::limit($comment->content, 60)) }}')">Eliminar</button>
                            </form>
                        </div>
                    </div>
                </article>
            @empty
                <div class="empty-state">
                    <div class="empty-icon" aria-hidden="true">💬</div>
                    <h3>No hay comentarios</h3>
                    <p>Los comentarios de los artículos aparecerán aquí.</p>
                </div>
            @endforelse
        </section>

    {{-- Paginación --}}
    @if($comments->hasPages())
        <nav class="pagination-wrapper" aria-label="Paginación de comentarios">
            {{ $comments->withQueryString()->links() }}
        </nav>
    @endif
</main>

{{-- Modal confirmación eliminar comentario --}}
<div id="modal-eliminar-comentario" role="alertdialog" aria-modal="true"
     aria-labelledby="modal-eliminar-titulo" aria-describedby="modal-eliminar-desc" tabindex="-1">
    <div class="modal-box">

        <div class="modal-body">
            <div class="modal-icon">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <polyline points="3 6 5 6 21 6"/>
                    <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
                    <path d="M10 11v6M14 11v6"/>
                    <path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/>
                </svg>
            </div>

            <h3 id="modal-eliminar-titulo">Eliminar comentario</h3>
            <p id="modal-eliminar-desc">¿Estás seguro de que deseas eliminar este comentario permanentemente?</p>
            <blockquote id="modal-eliminar-preview"></blockquote>
        </div>

        <div class="modal-divider"></div>

        <div class="modal-actions">
            <button type="button" id="modal-eliminar-cancelar"
                    aria-label="Cancelar eliminación">Cancelar</button>
            <button type="button" id="modal-eliminar-confirmar"
                    aria-label="Confirmar eliminación">Eliminar</button>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Modal eliminar comentario individual
    const modalEliminar = document.getElementById('modal-eliminar-comentario');
    const modalPreview = document.getElementById('modal-eliminar-preview');
    const btnCancelar = document.getElementById('modal-eliminar-cancelar');
    const btnConfirmar = document.getElementById('modal-eliminar-confirmar');
    let formPendiente = null;
    let ultimoFoco = null;

    window.abrirModalEliminarComentario = function(id, preview) {
        formPendiente = document.getElementById('delete-form-' + id);
        modalPreview.textContent = preview ? '"' + preview + '"' : '';
        ultimoFoco = document.activeElement;
        modalEliminar.style.display = 'flex';
        modalEliminar.removeAttribute('aria-hidden');
        setTimeout(() => btnCancelar.focus(), 80);
    };

    function cerrarModal() {
        modalEliminar.style.display = 'none';
        modalEliminar.setAttribute('aria-hidden', 'true');
        formPendiente = null;
        if (ultimoFoco) ultimoFoco.focus();
    }

    btnCancelar.addEventListener('click', cerrarModal);

    btnConfirmar.addEventListener('click', function() {
        if (formPendiente) formPendiente.submit();
        cerrarModal();
    });

    modalEliminar.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') cerrarModal();
        if (e.key === 'Tab') {
            const focusables = [btnCancelar, btnConfirmar];
            const first = focusables[0], last = focusables[focusables.length - 1];
            if (e.shiftKey) { if (document.activeElement === first) { e.preventDefault(); last.focus(); } }
            else { if (document.activeElement === last) { e.preventDefault(); first.focus(); } }
        }
    });

    modalEliminar.addEventListener('click', function(e) {
        if (e.target === modalEliminar) cerrarModal();
    });

    // Filtros automáticos
    document.getElementById('status').addEventListener('change', function() {
        this.closest('form').submit();
    });
    document.getElementById('article_id').addEventListener('change', function() {
        this.closest('form').submit();
    });

    const checkboxes = document.querySelectorAll('.comment-select');
    const bulkActions = document.getElementById('bulk-actions');
    const selectedCount = document.getElementById('selected-count');

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateBulkActions);
    });

    function updateBulkActions() {
        const checked = document.querySelectorAll('.comment-select:checked');
        selectedCount.textContent = checked.length;
        bulkActions.style.display = checked.length > 0 ? 'flex' : 'none';
    }

    window.bulkAction = function(action) {
        const checked = document.querySelectorAll('.comment-select:checked');
        if (checked.length === 0) {
            alert('Por favor selecciona al menos un comentario.');
            return;
        }

        let formId, confirmMsg;
        switch(action) {
            case 'approve':
                formId = 'bulk-approve-form';
                confirmMsg = '¿Aprobar los comentarios seleccionados?';
                break;
            case 'reject':
                formId = 'bulk-reject-form';
                confirmMsg = '¿Rechazar los comentarios seleccionados?';
                break;
            case 'delete':
                formId = 'bulk-destroy-form';
                confirmMsg = '¿Eliminar permanentemente los comentarios seleccionados?';
                break;
            default:
                return;
        }

        if (confirm(confirmMsg)) {
            const form = document.getElementById(formId);
            
            // Limpiar inputs previos
            form.querySelectorAll('input[name="ids[]"]').forEach(input => input.remove());
            
            // Agregar IDs seleccionados al formulario
            checked.forEach(checkbox => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'ids[]';
                input.value = checkbox.value;
                form.appendChild(input);
            });
            
            form.submit();
        }
    };
});
</script>
@endsection
