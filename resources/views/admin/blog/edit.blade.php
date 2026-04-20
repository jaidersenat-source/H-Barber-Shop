@extends('admin.layout')

@section('content')
@vite(['resources/css/Blog/admin/edit.css'])
<main class="article-form-container" aria-label="Formulario de edición de artículo">
    <header class="page-header">
        <div class="header-content">
            <a href="{{ route('admin.blog.index') }}" class="back-link" aria-label="Volver al listado de artículos">← Volver al listado</a>
            <h1>Editar Artículo</h1>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.blog.preview', $article) }}" target="_blank" class="btn-secondary" aria-label="Vista previa del artículo">Vista previa</a>
            @if($article->status === 'published')
                <a href="{{ route('blog.show', $article->slug) }}" target="_blank" class="btn-secondary" aria-label="Ver artículo publicado en el blog">Ver en el blog</a>
            @endif
        </div>
    </header>

    @if(session('success'))
        <div class="alert alert-success" role="alert">
            <span aria-hidden="true">✅</span> <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger" role="alert">
            <strong>Por favor corrige los siguientes errores:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.blog.update', $article) }}" method="POST" enctype="multipart/form-data" class="article-form" aria-label="Formulario para editar artículo">
        @csrf
        @method('PUT')
        
        <div class="form-layout">
            {{-- Columna principal --}}
            <section class="form-main" aria-label="Datos principales del artículo">
                <fieldset>
                    <legend class="sr-only">Datos principales del artículo</legend>
                    {{-- Título --}}
                    <div class="form-group">
                        <label for="title">Título del artículo <span aria-hidden="true">*</span></label>
                        <input type="text" id="title" name="title" value="{{ old('title', $article->title) }}" required
                               placeholder="Ej: Los 10 mejores cortes de cabello para hombres en 2026"
                               class="input-large" aria-required="true">
                    </div>

                    {{-- Slug --}}
                    <div class="form-group">
                        <label for="slug">URL amigable (slug)</label>
                        <div class="slug-input-wrapper">
                            <span class="slug-prefix">/blog/</span>
                            <input type="text" id="slug" name="slug" value="{{ old('slug', $article->slug) }}"
                                   placeholder="url-del-articulo">
                        </div>
                        <small>Deja vacío para generar automáticamente desde el título.</small>
                    </div>

                    {{-- Extracto --}}
                    <div class="form-group">
                        <label for="excerpt">Extracto / Resumen</label>
                        <textarea id="excerpt" name="excerpt" rows="3" 
                                  placeholder="Breve resumen del artículo...">{{ old('excerpt', $article->excerpt) }}</textarea>
                    </div>

                    {{-- Contenido --}}
                    <div class="form-group" role="group" aria-labelledby="contentLabel">
                        <label for="content" id="contentLabel">Contenido del artículo <span aria-hidden="true">*</span></label>
                        <textarea id="content" name="content" rows="20" required aria-required="true" aria-labelledby="contentLabel" aria-describedby="contentHelp">{{ old('content', $article->content) }}</textarea>
                        <small id="contentHelp">Puedes usar HTML básico para dar formato.</small>
                    </div>
                </fieldset>

                <fieldset class="seo-section">
                    <legend>Optimización SEO</legend>
                    <div class="form-group">
                        <label for="meta_title" id="metaTitleLabel">Meta título</label>
                        <input type="text" id="meta_title" name="meta_title" 
                               value="{{ old('meta_title', $article->meta_title) }}" maxlength="70" aria-labelledby="metaTitleLabel metaTitleCount">
                        <div class="char-counter" id="metaTitleCount">
                            <span id="meta_title_count">{{ strlen($article->meta_title ?? '') }}</span>/70 caracteres
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="meta_description" id="metaDescLabel">Meta descripción</label>
                        <textarea id="meta_description" name="meta_description" rows="2" maxlength="160" aria-labelledby="metaDescLabel metaDescCount">{{ old('meta_description', $article->meta_description) }}</textarea>
                        <div class="char-counter" id="metaDescCount">
                            <span id="meta_desc_count">{{ strlen($article->meta_description ?? '') }}</span>/160 caracteres
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="meta_keywords" id="metaKeywordsLabel">Palabras clave</label>
                        <input type="text" id="meta_keywords" name="meta_keywords" 
                               value="{{ old('meta_keywords', $article->meta_keywords) }}" aria-labelledby="metaKeywordsLabel">
                    </div>
                </fieldset>
            </section>

            {{-- Columna lateral --}}
            <aside class="form-sidebar" aria-label="Opciones adicionales">
                {{-- Info del artículo --}}
                <div class="sidebar-box info-box" aria-label="Información del artículo">
                    <div class="info-item">
                        <span class="info-label">Creado:</span>
                        <span>{{ $article->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Modificado:</span>
                        <span>{{ $article->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Vistas:</span>
                        <span>{{ number_format($article->views) }}</span>
                    </div>
                </div>

                {{-- Publicación --}}
                <div class="sidebar-box">
                    <h4>Publicación</h4>
                    
                    <div class="form-group">
                        <label for="status">Estado</label>
                        <select id="status" name="status" required aria-label="Estado de publicación">
                            <option value="draft" {{ old('status', $article->status) == 'draft' ? 'selected' : '' }}>Borrador</option>
                            <option value="published" {{ old('status', $article->status) == 'published' ? 'selected' : '' }}>Publicado</option>
                            <option value="archived" {{ old('status', $article->status) == 'archived' ? 'selected' : '' }}>Archivado</option>
                        </select>
                    </div>

                    <div class="form-group">
                           <label for="published_at">Fecha de publicación</label>
                           <input type="datetime-local" id="published_at" name="published_at" 
                               value="{{ old('published_at', $article->published_at?->format('Y-m-d\TH:i')) }}" aria-label="Fecha de publicación">
                    </div>
                </div>

                {{-- Categoría --}}
                <div class="sidebar-box">
                    <h4>Categoría</h4>
                    
                    <div class="form-group">
                        <select id="category" name="category" aria-label="Categoría del artículo">
                            <option value="">Sin categoría</option>
                            @foreach($categories as $key => $name)
                                <option value="{{ $key }}" {{ old('category', $article->category) == $key ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Imagen destacada --}}
                <div class="sidebar-box">
                    <h4>Imagen destacada</h4>
                    
                    <div class="form-group">
                        <div class="image-upload-area" id="image-upload-area">
                            <input type="file" id="featured_image" name="featured_image" accept="image/*" hidden aria-label="Subir imagen destacada">
                            @if($article->featured_image)
                                <img id="image-preview" src="{{ $article->featured_image_url }}" alt="Vista previa de la imagen seleccionada">
                                <div class="image-change-overlay" tabindex="0" aria-label="Cambiar imagen destacada">
                                    <span aria-hidden="true">📷</span> <span>Cambiar imagen</span>
                                </div>
                            @else
                                <div class="upload-placeholder" id="upload-placeholder" tabindex="0" aria-label="Haz clic para subir imagen">
                                    <span class="upload-icon" aria-hidden="true">📷</span>
                                    <p>Haz clic para subir imagen</p>
                                </div>
                                <img id="image-preview" src="" alt="Vista previa de la imagen seleccionada" style="display:none;">
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                           <label for="featured_image_alt">Texto alternativo (alt)</label>
                           <input type="text" id="featured_image_alt" name="featured_image_alt" 
                               value="{{ old('featured_image_alt', $article->featured_image_alt) }}" aria-label="Texto alternativo de la imagen destacada">
                    </div>
                </div>

                {{-- Acciones --}}
                <div class="sidebar-actions">
                    <button type="submit" class="btn-publish" aria-label="Guardar cambios del artículo">
                        <span aria-hidden="true">💾</span> <span>Guardar Cambios</span>
                    </button>
                    <a href="{{ route('admin.blog.index') }}" class="btn-cancel" aria-label="Cancelar y volver al listado">Cancelar</a>
                </div>

                {{-- Eliminar --}}
                <div class="sidebar-box danger-zone" aria-label="Zona de peligro">
                    <h4>Zona de peligro</h4>
                    <form action="{{ route('admin.blog.destroy', $article) }}" method="POST" 
                          onsubmit="return confirm('¿Estás seguro de eliminar este artículo? Esta acción no se puede deshacer.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-danger" aria-label="Eliminar artículo">Eliminar artículo</button>
                    </form>
                </div>
            </div>
        </div>
    </form>
    </aside>
</div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Image upload
    const uploadArea = document.getElementById('image-upload-area');
    const fileInput = document.getElementById('featured_image');
    const preview = document.getElementById('image-preview');
    const placeholder = document.getElementById('upload-placeholder');

    uploadArea.addEventListener('click', () => fileInput.click());

    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                if (placeholder) placeholder.style.display = 'none';
            };
            reader.readAsDataURL(file);
        }
    });

    // Character counters
    const metaTitle = document.getElementById('meta_title');
    const metaTitleCount = document.getElementById('meta_title_count');
    const metaDesc = document.getElementById('meta_description');
    const metaDescCount = document.getElementById('meta_desc_count');

    if (metaTitle && metaTitleCount) {
        metaTitle.addEventListener('input', function() {
            metaTitleCount.textContent = this.value.length;
        });
    }

    if (metaDesc && metaDescCount) {
        metaDesc.addEventListener('input', function() {
            metaDescCount.textContent = this.value.length;
        });
    }
});
</script>
@endsection
