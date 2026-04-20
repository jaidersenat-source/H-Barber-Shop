@extends('admin.layout')
@section('content')
@vite(['resources/css/Admin/fidi/fidelizacion.css'])

{{-- Región principal con landmark y título descriptivo --}}
<main
    id="modulo-fidelizacion-config"
    aria-labelledby="titulo-pagina"
    class="fidelizacion-container"
    style="max-width:500px;margin:auto;"
>
    {{-- Encabezado de página --}}
    <div class="fidelizacion-header">
        <h1 id="titulo-pagina">Configuración de Fidelización</h1>
    </div>

    {{-- Mensaje de éxito: rol alert para que JAWS lo anuncie automáticamente --}}
    {{-- Mensaje de éxito: anuncio prioritario para lectores de pantalla --}}
@if(session('ok'))
    <div
        id="mensaje-exito"
        role="alert"
        aria-live="assertive"
        aria-atomic="true"
        tabindex="-1"
        style="color: #065f46; background: #d1fae5; border-left: 4px solid #10b981; padding: 1rem 1.25rem; border-radius: 6px; font-weight: 600; margin-bottom: 1.5rem; outline: none;"
    >
        ✅ {{ session('ok') }}
    </div>

    {{-- Script para enfocar automáticamente el mensaje y que JAWS lo lea --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mensaje = document.getElementById('mensaje-exito');
            if (mensaje) {
                // Enfocar el mensaje para que JAWS lo lea inmediatamente
                setTimeout(() => {
                    mensaje.focus();
                    
                    // Anunciar también con Web Speech API como respaldo
                    if ('speechSynthesis' in window) {
                        const utterance = new SpeechSynthesisUtterance('{{ session('ok') }}');
                        utterance.lang = 'es-ES';
                        utterance.rate = 1.1;
                        window.speechSynthesis.speak(utterance);
                    }
                }, 300);
            }
        });
    </script>
@endif

    {{-- Errores de validación: region landmark para que JAWS pueda navegarlos --}}
    @if($errors->any())
        <section
            aria-labelledby="errores-titulo"
            role="alert"
            aria-live="assertive"
            style="background:#fff1f2;border:1.5px solid #fca5a5;border-radius:6px;padding:1rem;margin-bottom:1rem;"
        >
            <h2 id="errores-titulo" style="font-size:1rem;margin:0 0 0.5rem;">
                Se encontraron {{ $errors->count() }} error(es) en el formulario:
            </h2>
            <ul aria-label="Lista de errores">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </section>
    @endif

    {{--
        aria-describedby apunta al párrafo de descripción del formulario
        para que JAWS lo lea al hacer foco en el form.
    --}}
    <form
        action="{{ route('fidelizacion.config.update') }}"
        method="POST"
        aria-labelledby="titulo-pagina"
        aria-describedby="form-descripcion"
        novalidate
        style="background:#fff;padding:2rem;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.08);"
    >
        @csrf

        {{-- Descripción breve del formulario, leída por JAWS al entrar al form --}}
        <p id="form-descripcion" style="margin:0 0 1.5rem;color:#555;font-size:0.95rem;">
            Ajuste los parámetros del programa de fidelización de clientes.
            Todos los campos son obligatorios.
        </p>

        {{-- Campo: visitas requeridas --}}
        <div class="form-grupo" style="margin-bottom:1.5rem;">
            <label
                for="visitas_requeridas"
                style="font-weight:600;display:block;margin-bottom:0.5rem;"
            >
                Visitas requeridas para obtener un corte gratis
            </label>

            {{-- aria-describedby enlaza la pista adicional con el input --}}
            <input
                type="number"
                min="1"
                max="99"
                name="visitas_requeridas"
                id="visitas_requeridas"
                value="{{ old('visitas_requeridas', $visitas) }}"
                required
                aria-required="true"
                aria-describedby="visitas-hint @error('visitas_requeridas') visitas-error @enderror"
                @error('visitas_requeridas') aria-invalid="true" @enderror
                style="width:100%;max-width:300px;padding:0.75rem;font-size:1rem;border:1.5px solid #e2e8f0;border-radius:6px;"
            >

            {{-- Pista de ayuda siempre visible --}}
            <span id="visitas-hint" style="display:block;font-size:0.85rem;color:#666;margin-top:0.35rem;">
                Ingrese un número entre 1 y 99.
            </span>

            @error('visitas_requeridas')
                <span
                    id="visitas-error"
                    role="alert"
                    style="display:block;color:#dc2626;font-size:0.85rem;margin-top:0.25rem;"
                >
                    {{ $message }}
                </span>
            @enderror
        </div>

        {{-- Campo: estado de fidelización --}}
        <div class="form-grupo" style="margin-bottom:2rem;">
            <label
                for="habilitado"
                style="font-weight:600;display:block;margin-bottom:0.5rem;"
            >
                Estado del programa de fidelización
            </label>

            <select
                name="habilitado"
                id="habilitado"
                aria-required="true"
                aria-describedby="habilitado-hint @error('habilitado') habilitado-error @enderror"
                @error('habilitado') aria-invalid="true" @enderror
                style="width:100%;max-width:300px;padding:0.75rem;font-size:1rem;border:1.5px solid #e2e8f0;border-radius:6px;"
            >
                {{-- Las opciones usan texto completo y descriptivo, no solo "Sí/No" --}}
                <option value="1" @selected($habilitado)>Habilitado — el programa está activo</option>
                <option value="0" @selected(!$habilitado)>Deshabilitado — el programa está inactivo</option>
            </select>

            <span id="habilitado-hint" style="display:block;font-size:0.85rem;color:#666;margin-top:0.35rem;">
                Cuando está deshabilitado, los clientes no acumulan visitas.
            </span>

            @error('habilitado')
                <span
                    id="habilitado-error"
                    role="alert"
                    style="display:block;color:#dc2626;font-size:0.85rem;margin-top:0.25rem;"
                >
                    {{ $message }}
                </span>
            @enderror
        </div>

        {{-- Acciones del formulario --}}
        <div
            role="group"
            aria-label="Acciones del formulario"
            style="display:flex;gap:1rem;flex-wrap:wrap;margin-top:2rem;"
        >
            <button
                type="submit"
                class="btn-ver"
                aria-describedby="titulo-pagina"
            >
                Guardar configuración
            </button>

            {{-- El enlace de volver comunica su destino claramente --}}
            <a
                href="{{ route('fidelizacion.index') }}"
                class="btn-config"
                aria-label="Volver al listado de fidelización sin guardar cambios"
            >
                Volver
            </a>
        </div>
    </form>
</main>

@endsection