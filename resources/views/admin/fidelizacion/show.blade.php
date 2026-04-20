@extends('admin.layout')

@section('content')
@vite(['resources/css/Admin/fidi/show.css'])
<div class="fidelizacion-container" id="modulo-fidelizacion-show" role="region" aria-labelledby="titulo-detalle-fidelizacion" style="max-width:600px;margin:auto;">
    <div class="fidelizacion-header">
        <h2 id="titulo-detalle-fidelizacion" tabindex="0">Detalle de Fidelización</h2>
    </div>

    
    <div style="background:#fff;padding:2rem;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.08);margin-bottom:2rem;">
        <ul aria-label="Datos de fidelización" style="list-style:none; padding-left:0; margin-bottom:2rem;">
            <li tabindex="1"><strong>Cliente:</strong> {{ $item->turno->tur_nombre }}</li>
            <li tabindex="1"><strong>Cédula:</strong> {{ $item->turno->tur_cedula }}</li>
            <li tabindex="2"><strong>Teléfono:</strong> {{ $item->turno->tur_celular }}</li>
            <li tabindex="3"><strong>Visitas acumuladas:</strong> {{ $item->visitas_acumuladas }}</li>
            <li tabindex="4"><strong>Cortes gratis:</strong> {{ $item->cortes_gratis }}</li>
            <li tabindex="5"><strong>Última actualización:</strong>
                <span aria-describedby="fecha-actualizacion-show-{{ $item->fid_id }}">{{ $item->fecha_actualizacion }}</span>
                <span id="fecha-actualizacion-show-{{ $item->fid_id }}" class="sr-only">
                    {{ \Carbon\Carbon::parse($item->fecha_actualizacion)->isoFormat('D [de] MMMM [de] YYYY [a las] H:mm') }}
                </span>
            </li>
        </ul>
        <hr aria-hidden="true" style="margin:2rem 0;">
        <h3 id="info-turno" tabindex="6" style="font-size:1.25rem;color:var(--fid-primary);margin-bottom:1rem;">Información del turno más reciente</h3>
        <ul aria-labelledby="info-turno" style="list-style:none; padding-left:0;">
            <li tabindex="7"><strong>Fecha turno:</strong>
                <span aria-describedby="fecha-turno-show-{{ $item->fid_id }}">{{ $item->turno->tur_fecha }}</span>
                <span id="fecha-turno-show-{{ $item->fid_id }}" class="sr-only">
                    {{ \Carbon\Carbon::parse($item->turno->tur_fecha)->isoFormat('D [de] MMMM [de] YYYY') }}
                </span>
            </li>
            <li tabindex="8"><strong>Hora turno:</strong> {{ $item->turno->tur_hora }}</li>
            <li tabindex="9"><strong>Estado turno:</strong> {{ $item->turno->tur_estado }}</li>
            <li tabindex="10"><strong>Barbero:</strong>
                {{ $item->turno->disponibilidad->persona->per_nombre ?? 'N/A' }}
                {{ $item->turno->disponibilidad->persona->per_apellido ?? '' }}
            </li>
        </ul>
        <div style="margin-top:2rem;">
            <a href="{{ route('fidelizacion.index') }}" class="btn-config" aria-label="Volver al listado de fidelización" tabindex="11">Volver</a>
        </div>
    </div>
</div>
@endsection
