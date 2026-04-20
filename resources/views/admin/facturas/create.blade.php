@extends('admin.layout')

@section('content')
@vite(['resources/css/Admin/factura/create.css'])

<main class="facturas-container" aria-labelledby="titulo-crear-factura">

    <h1 id="titulo-crear-factura">Crear Factura</h1>

    {{-- ============================================================
         SECCIÓN INFORMATIVA: datos del turno (solo lectura)
         JAWS los lee como una lista de definiciones, no como campos
         de formulario, para evitar confusión de "editable/no editable"
         ============================================================ --}}
    <section aria-labelledby="titulo-datos-turno">
        <h2 id="titulo-datos-turno">Datos del turno</h2>
        <p class="info-readonly-aviso" aria-live="polite">
            Los siguientes datos provienen del turno y no pueden modificarse.
        </p>

        <dl class="factura-info-dl">
            <div>
                <dt>Fecha</dt>
                <dd>
                    {{-- Visual: formato corto --}}
                    <span aria-hidden="true">{{ now()->format('d/m/Y H:i') }}</span>
                    {{-- JAWS: formato largo y claro --}}
                    <span class="sr-only">
                        {{ \Carbon\Carbon::now()->locale('es')->isoFormat('D [de] MMMM [de] YYYY [a las] H:mm') }}
                    </span>
                </dd>
            </div>
            <div>
                <dt>Número de turno</dt>
                <dd>{{ $turno->tur_id }}</dd>
            </div>
            <div>
                <dt>Hora del turno</dt>
                <dd>{{ $turno->tur_hora }}</dd>
            </div>
            <div>
                <dt>Nombre del cliente</dt>
                <dd>{{ $turno->tur_nombre }}</dd>
            </div>
            <div>
                <dt>Cédula del cliente</dt>
                <dd>{{ $turno->tur_cedula }}</dd>
            </div>
            <div>
                <dt>Servicio</dt>
                <dd>{{ $turno->servicio->serv_nombre ?? 'Sin servicio asignado' }}</dd>
            </div>
            <div>
                <dt>Abono</dt>
                <dd>
                    {{-- Visual: con símbolo de peso --}}
                    <span aria-hidden="true">${{ number_format($turno->tur_anticipo, 0, ',', '.') }}</span>
                    {{-- JAWS: número en palabras + moneda --}}
                    <span class="sr-only">
                        {{ number_format($turno->tur_anticipo, 0, ',', '.') }} pesos colombianos
                    </span>
                </dd>
            </div>
        </dl>
    </section>

    <hr aria-hidden="true">

    {{-- ============================================================
         FORMULARIO: solo contiene los campos que el admin puede tocar
         ============================================================ --}}
    <section aria-labelledby="titulo-datos-editables">
        <h2 id="titulo-datos-editables">Datos que puede modificar</h2>

        <form
            action="{{ route('factura.store') }}"
            method="POST"
            class="facturas-form"
            aria-describedby="titulo-datos-editables"
            novalidate
        >
            @csrf

            {{-- Campos ocultos: envían los datos del turno al backend --}}
            <input type="hidden" name="tur_id"        value="{{ $turno->tur_id }}">
            <input type="hidden" name="tur_hora"      value="{{ $turno->tur_hora }}">
            <input type="hidden" name="tur_nombre"    value="{{ $turno->tur_nombre }}">
            <input type="hidden" name="tur_cedula"    value="{{ $turno->tur_cedula }}">
            <input type="hidden" name="serv_id"       value="{{ $turno->servicio->serv_id ?? '' }}">
            <input type="hidden" name="tur_anticipo"  value="{{ $turno->tur_anticipo }}">

            {{-- Sede: se resuelve automáticamente desde el barbero del turno --}}
            <div class="form-group">
                <label>Sede</label>
                @if($sedeAuto)
                    <p class="info-readonly-aviso" style="margin:0;">
                        <strong>{{ $sedeAuto->sede_nombre }}</strong>
                        <span style="color:#6b7280;font-size:0.875rem;"> (asignada automáticamente desde el barbero)</span>
                    </p>
                    <input type="hidden" name="sede_id" value="{{ $sedeAuto->sede_id }}">
                @else
                    <p class="info-readonly-aviso" style="color:#b91c1c;">
                        ⚠ No se pudo determinar la sede del barbero. Comuníquese con el administrador.
                    </p>
                @endif
            </div>

            {{-- Errores de validación --}}
            @if($errors->any())
                <div role="alert" aria-live="assertive" class="errores-lista">
                    <p><strong>Por favor corrija los siguientes errores:</strong></p>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Acciones --}}
            <div
                class="form-acciones"
                role="group"
                aria-label="Acciones del formulario"
            >
               
                <span id="btn-rapido-descripcion" class="sr-only">
                    Crea la factura con los datos actuales y regresa al listado, sin agregar servicios extra.
                </span>

                <button type="submit" name="accion_rapida" value="1" class="btn btn-success" aria-label="Crear factura y volver al listado de facturas (sin agregar servicios extra)">
                Crear factura
            </button>
            <button type="submit" name="agregar_servicios" value="1" class="btn btn-primary" aria-label="Crear factura y agregar servicios extra">
                Agregar servicios
            </button>
            </div>

        </form>
    </section>

</main>

@endsection
<div>
           