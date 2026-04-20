@extends('admin.layout')

@section('content')
@vite(['resources/css/Blog/admin/create.css'])
<main class="article-form-container" aria-label="Formulario de nuevo artículo">
    <header class="page-header">
        <div class="header-content">
            <a href="{{ route('admin.blog.index') }}" class="back-link" aria-label="Volver al listado de artículos">← Volver al listado</a>
            <h1>Nuevo Artículo</h1>
        </div>
    </header>

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

    <form action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data" class="article-form" aria-label="Formulario para crear artículo">
        @csrf
        
        <div class="form-layout">
            {{-- Columna principal --}}
            <section class="form-main" aria-label="Datos principales del artículo">
                <fieldset>
                    <legend class="sr-only">Datos principales del artículo</legend>
                    {{-- Título --}}
                    <div class="form-group">
                        <label for="title">Título del artículo <span aria-hidden="true">*</span></label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" required
                               placeholder="Ej: Los 10 mejores cortes de cabello para hombres en 2026"
                               class="input-large" aria-required="true" aria-describedby="titleHelp">
                        <small id="titleHelp">El título aparecerá en Google y redes sociales. Recomendado: 50-60 caracteres.</small>
                    </div>

                    {{-- Extracto --}}
                    <div class="form-group">
                        <label for="excerpt">Extracto / Resumen</label>
                        <textarea id="excerpt" name="excerpt" rows="3" 
                                  placeholder="Breve resumen del artículo para mostrar en listados..." aria-describedby="excerptHelp">{{ old('excerpt') }}</textarea>
                        <small id="excerptHelp">Resumen corto para mostrar en la página del blog. Máximo 500 caracteres.</small>
                    </div>

                    {{-- Contenido --}}
                    <div class="form-group">
                       <label for="content">
                        Contenido del artículo <span aria-hidden="true">*</span>
                       </label>
    <textarea id="content" name="content" rows="15" required
              placeholder="Escribe el contenido del artículo..."
              aria-required="true"
              aria-describedby="contentHelp">{{ old('content') }}</textarea>
    <small id="contentHelp">Puedes usar HTML básico para dar formato.</small>
</div>
                </fieldset>

                <fieldset class="seo-section">
                    <legend>Optimización SEO</legend>
                    <div class="form-group">
                        <label for="meta_title">Meta título (para Google)</label>
                        <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title') }}" 
                               maxlength="70" placeholder="Título optimizado para buscadores..." aria-describedby="metaTitleHelp">
                        <small id="metaTitleHelp">Máximo 70 caracteres. Si lo dejas vacío, se usará el título del artículo.</small>
                    </div>

                    <div class="form-group">
                        <label for="meta_description">Meta descripción</label>
                        <textarea id="meta_description" name="meta_description" rows="2" maxlength="160"
                                  placeholder="Descripción que aparecerá en los resultados de Google..." aria-describedby="metaDescHelp">{{ old('meta_description') }}</textarea>
                        <small id="metaDescHelp">Máximo 160 caracteres. Describe brevemente de qué trata el artículo.</small>
                    </div>

                    <div class="form-group">
                        <label for="meta_keywords">Palabras clave</label>
                        <input type="text" id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords') }}"
                               placeholder="cortes de cabello, barbería, tendencias 2026..." aria-describedby="metaKeywordsHelp">
                        <small id="metaKeywordsHelp">Separadas por comas. Ayudan a categorizar el contenido.</small>
                    </div>
                </fieldset>
            </section>

            {{-- Columna lateral --}}
            <aside class="form-sidebar" aria-label="Opciones adicionales">
                {{-- Publicación --}}
                <div class="sidebar-box">
                    <h4>Publicación</h4>
                    
                    <div class="form-group">
                        <label for="status">Estado</label>
                        <select id="status" name="status" required aria-label="Estado de publicación">
                            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Borrador</option>
                            <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Publicado</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="published_at">Fecha de publicación</label>
                        <input type="datetime-local" id="published_at" name="published_at" value="{{ old('published_at') }}" aria-label="Fecha de publicación">
                        <small id="publishedAtHelp">Deja vacío para publicar ahora.</small>
                    </div>
                </div>

                {{-- Categoría --}}
                <div class="sidebar-box">
                    <h4>Categoría</h4>
                    
                    <div class="form-group">
                        <select id="category" name="category" aria-label="Categoría del artículo">
                            <option value="">Sin categoría</option>
                            @foreach($categories as $key => $name)
                                <option value="{{ $key }}" {{ old('category') == $key ? 'selected' : '' }}>
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
                            <div class="upload-placeholder" id="upload-placeholder" tabindex="0" aria-label="Haz clic para subir imagen">
                                <span class="upload-icon" aria-hidden="true">📷</span>
                                <p>Haz clic para subir imagen</p>
                                <small>JPG, PNG o WebP (máx. 2MB)</small>
                            </div>
                            <img id="image-preview" src="" alt="Vista previa de la imagen seleccionada" style="display:none;">
                        </div>
                    </div>

                    <div class="form-group">
                           <label for="featured_image_alt">Texto alternativo (alt)</label>
                           <input type="text" id="featured_image_alt" name="featured_image_alt" 
                               value="{{ old('featured_image_alt') }}"
                               placeholder="Describe la imagen para SEO..." aria-label="Texto alternativo de la imagen destacada">
                    </div>
                </div>

                {{-- Acciones --}}
                <div class="sidebar-actions">
                    <button type="submit" class="btn-publish" aria-label="Guardar artículo">
                        <span aria-hidden="true">💾</span> <span>Guardar Artículo</span>
                    </button>
                    <a href="{{ route('admin.blog.index') }}" class="btn-cancel" aria-label="Cancelar y volver al listado">Cancelar</a>
                </div>
            </aside>
        </div>
    </form>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
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
                placeholder.style.display = 'none';
            };
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endsection
