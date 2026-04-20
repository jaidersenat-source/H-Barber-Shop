@extends('admin.layout')

@section('title', 'Redes Sociales y Contacto')

@vite(['resources/css/Admin/config/redes.css'])

@section('content')
<div class="social-container">
    <div class="social-row">
        <div class="social-col">
            <!-- Header -->
            <div class="social-header">
                <div class="social-icon-wrapper">
                    <span class="icon">📱</span>
                </div>
                <div class="social-header-content">
                    <h2>Redes Sociales y Contacto</h2>
                    <p>Configura los enlaces de redes sociales y número de WhatsApp</p>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong><i class="fas fa-check-circle"></i>¡Éxito!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong><i class="fas fa-exclamation-triangle"></i>Error:</strong>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            @endif

            <form action="{{ route('admin.configuraciones.generales.update') }}" method="POST" class="social-form">
                @csrf
                @method('PUT')

                <!-- WhatsApp -->
                <div class="social-card">
                    <div class="social-card-header whatsapp">
                        <h5>
                            <i class="fab fa-whatsapp"></i>
                            Número de WhatsApp
                        </h5>
                    </div>
                    <div class="social-card-body">
                        <div class="form-group">
                            <label for="whatsapp" class="form-label">Número de WhatsApp (sin +)</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="whatsapp" 
                                name="whatsapp" 
                                value="{{ old('whatsapp', $whatsapp) }}" 
                                placeholder="573118104544" 
                                required
                                aria-describedby="whatsapp-help"
                            >
                            <small id="whatsapp-help" class="form-text">
                                <i class="fas fa-info-circle"></i>
                                Formato: código país + número (ejemplo: 573118104544)
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Redes Sociales -->
                <div class="social-card">
                    <div class="social-card-header social-media">
                        <h5>
                            <i class="fab fa-instagram"></i>
                            Redes Sociales
                        </h5>
                    </div>
                    <div class="social-card-body">
                        <div class="form-row">
                            <div class="form-col">
                                <label for="instagram" class="form-label">
                                    <i class="fab fa-instagram icon-instagram"></i>Instagram
                                </label>
                                <input 
                                    type="url" 
                                    class="form-control" 
                                    id="instagram" 
                                    name="instagram" 
                                    value="{{ old('instagram', $redes_sociales['instagram']) }}" 
                                    placeholder="https://www.instagram.com/tu_usuario"
                                >
                            </div>
                            <div class="form-col">
                                <label for="facebook" class="form-label">
                                    <i class="fab fa-facebook icon-facebook"></i>Facebook
                                </label>
                                <input 
                                    type="url" 
                                    class="form-control" 
                                    id="facebook" 
                                    name="facebook" 
                                    value="{{ old('facebook', $redes_sociales['facebook']) }}" 
                                    placeholder="https://www.facebook.com/tu_pagina"
                                >
                            </div>
                            <div class="form-col">
                                <label for="tiktok" class="form-label">
                                    <i class="fab fa-tiktok icon-tiktok"></i>TikTok
                                </label>
                                <input 
                                    type="url" 
                                    class="form-control" 
                                    id="tiktok" 
                                    name="tiktok" 
                                    value="{{ old('tiktok', $redes_sociales['tiktok']) }}" 
                                    placeholder="https://www.tiktok.com/@tu_usuario"
                                >
                            </div>
                            <div class="form-col">
                                <label for="youtube" class="form-label">
                                    <i class="fab fa-youtube icon-youtube"></i>YouTube
                                </label>
                                <input 
                                    type="url" 
                                    class="form-control" 
                                    id="youtube" 
                                    name="youtube" 
                                    value="{{ old('youtube', $redes_sociales['youtube']) }}" 
                                    placeholder="https://www.youtube.com/c/tu_canal"
                                >
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="action-section">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save"></i>Guardar Cambios
                    </button>
                    <a href="{{ route('admin.configuracion') }}" class="btn btn-secondary btn-lg ms-3">
                        <i class="fas fa-arrow-left"></i>Volver
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection