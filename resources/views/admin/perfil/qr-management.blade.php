@extends('admin.layout')

@section('title', 'Gestión de QR para Pagos')

@vite(['resources/css/Admin/config/qr.css'])

@section('content')
<div class="qr-page">

    {{-- Header de página --}}
    <div class="qr-page-header">
        <div class="qr-page-header-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                <rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="3" height="3"/>
                <rect x="18" y="14" width="3" height="3"/><rect x="14" y="18" width="3" height="3"/>
                <rect x="18" y="18" width="3" height="3"/>
            </svg>
        </div>
        <div>
            <h1>Gestión de Códigos QR</h1>
            <p>Administra los códigos QR para recibir anticipos de pago</p>
        </div>
    </div>

    {{-- Alerta de éxito --}}
    @if(session('success'))
        <div class="qr-alert qr-alert-success" role="alert">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Grid de tarjetas QR --}}
    <div class="qr-grid">

        {{-- ── NEQUI ── --}}
        <div class="qr-card" data-brand="nequi">
            <div class="qr-card-header">
                <div class="qr-brand-badge nequi">
                    <span class="qr-brand-dot"></span>
                    Nequi
                </div>
                <span class="qr-status-pill {{ file_exists(public_path('img/qr/nequi-qr.png')) ? 'active' : 'inactive' }}">
                    {{ file_exists(public_path('img/qr/nequi-qr.png')) ? 'Activo' : 'Sin configurar' }}
                </span>
            </div>

            <div class="qr-card-body">
                {{-- Previsualización actual --}}
                <div class="qr-preview-area nequi">
                    @if(file_exists(public_path('img/qr/nequi-qr.png')))
                        <img src="{{ asset('img/qr/nequi-qr.png') }}?v={{ time() }}" alt="QR Nequi Actual" class="qr-preview-img">
                        <p class="qr-updated-at">Actualizado el {{ date('d/m/Y \a \l\a\s H:i', filemtime(public_path('img/qr/nequi-qr.png'))) }}</p>
                    @else
                        <div class="qr-empty-state nequi">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                                <rect x="3" y="14" width="7" height="7"/><path d="M14 14h3v3h-3zM17 17h3v3h-3z"/>
                            </svg>
                            <span>Sin QR cargado</span>
                        </div>
                    @endif
                </div>

                {{-- Formulario de subida --}}
                <form action="{{ route('admin.qr.upload') }}" method="POST" enctype="multipart/form-data" class="qr-upload-form">
                    @csrf
                    <input type="hidden" name="tipo" value="nequi">
                    <div class="qr-form-group">
                        <label for="nequi-qr" class="qr-form-label">Subir nuevo QR</label>
                        <input type="file" class="qr-file-input" id="nequi-qr" name="qr_image"
                               accept="image/*" required aria-describedby="nequi-help">
                        <div class="qr-file-preview" id="preview-nequi"></div>
                        <small id="nequi-help" class="qr-form-hint">PNG, JPG, JPEG · Máximo 2MB</small>
                    </div>
                    <button type="submit" class="qr-btn nequi">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                        Subir QR Nequi
                    </button>
                </form>

                {{-- Instrucciones --}}
                <details class="qr-instructions">
                    <summary>¿Cómo generar el QR de Nequi?</summary>
                    <ol>
                        <li>Abre tu app <strong>Nequi</strong></li>
                        <li>Ve a <strong>"Mi Negocio"</strong></li>
                        <li>Toca <strong>"Cobrar con QR"</strong></li>
                        <li>Configura <strong>$10,000 COP</strong></li>
                        <li>Mensaje: <strong>"Anticipo H Barber Shop"</strong></li>
                        <li>Guarda la imagen y súbela aquí</li>
                    </ol>
                </details>
            </div>
        </div>

        {{-- ── DAVIPLATA ── --}}
        <div class="qr-card" data-brand="daviplata">
            <div class="qr-card-header">
                <div class="qr-brand-badge daviplata">
                    <span class="qr-brand-dot"></span>
                    DaviPlata
                </div>
                <span class="qr-status-pill {{ file_exists(public_path('img/qr/daviplata-qr.png')) ? 'active' : 'inactive' }}">
                    {{ file_exists(public_path('img/qr/daviplata-qr.png')) ? 'Activo' : 'Sin configurar' }}
                </span>
            </div>

            <div class="qr-card-body">
                <div class="qr-preview-area daviplata">
                    @if(file_exists(public_path('img/qr/daviplata-qr.png')))
                        <img src="{{ asset('img/qr/daviplata-qr.png') }}?v={{ time() }}" alt="QR DaviPlata Actual" class="qr-preview-img">
                        <p class="qr-updated-at">Actualizado el {{ date('d/m/Y \a \l\a\s H:i', filemtime(public_path('img/qr/daviplata-qr.png'))) }}</p>
                    @else
                        <div class="qr-empty-state daviplata">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                                <rect x="3" y="14" width="7" height="7"/><path d="M14 14h3v3h-3zM17 17h3v3h-3z"/>
                            </svg>
                            <span>Sin QR cargado</span>
                        </div>
                    @endif
                </div>

                <form action="{{ route('admin.qr.upload') }}" method="POST" enctype="multipart/form-data" class="qr-upload-form">
                    @csrf
                    <input type="hidden" name="tipo" value="daviplata">
                    <div class="qr-form-group">
                        <label for="daviplata-qr" class="qr-form-label">Subir nuevo QR</label>
                        <input type="file" class="qr-file-input" id="daviplata-qr" name="qr_image"
                               accept="image/*" required aria-describedby="daviplata-help">
                        <div class="qr-file-preview" id="preview-daviplata"></div>
                        <small id="daviplata-help" class="qr-form-hint">PNG, JPG, JPEG · Máximo 2MB</small>
                    </div>
                    <button type="submit" class="qr-btn daviplata">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                        Subir QR DaviPlata
                    </button>
                </form>

                <details class="qr-instructions">
                    <summary>¿Cómo generar el QR de DaviPlata?</summary>
                    <ol>
                        <li>Abre tu app <strong>DaviPlata</strong></li>
                        <li>Ve a <strong>"Cobrar"</strong></li>
                        <li>Genera QR para <strong>$10,000 COP</strong></li>
                        <li>Mensaje: <strong>"Anticipo H Barber Shop"</strong></li>
                        <li>Guarda la imagen y súbela aquí</li>
                    </ol>
                </details>
            </div>
        </div>

        {{-- ── BANCOLOMBIA ── --}}
        <div class="qr-card" data-brand="bancolombia">
            <div class="qr-card-header">
                <div class="qr-brand-badge bancolombia">
                    <span class="qr-brand-dot"></span>
                    Bancolombia
                </div>
                <span class="qr-status-pill {{ file_exists(public_path('img/qr/bancolombia-qr.png')) ? 'active' : 'inactive' }}">
                    {{ file_exists(public_path('img/qr/bancolombia-qr.png')) ? 'Activo' : 'Sin configurar' }}
                </span>
            </div>

            <div class="qr-card-body">
                <div class="qr-preview-area bancolombia">
                    @if(file_exists(public_path('img/qr/bancolombia-qr.png')))
                        <img src="{{ asset('img/qr/bancolombia-qr.png') }}?v={{ time() }}" alt="QR Bancolombia Actual" class="qr-preview-img">
                        <p class="qr-updated-at">Actualizado el {{ date('d/m/Y \a \l\a\s H:i', filemtime(public_path('img/qr/bancolombia-qr.png'))) }}</p>
                    @else
                        <div class="qr-empty-state bancolombia">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                                <rect x="3" y="14" width="7" height="7"/><path d="M14 14h3v3h-3zM17 17h3v3h-3z"/>
                            </svg>
                            <span>Sin QR cargado</span>
                        </div>
                    @endif
                </div>

                <form action="{{ route('admin.qr.upload') }}" method="POST" enctype="multipart/form-data" class="qr-upload-form">
                    @csrf
                    <input type="hidden" name="tipo" value="bancolombia">
                    <div class="qr-form-group">
                        <label for="bancolombia-qr" class="qr-form-label">Subir nuevo QR</label>
                        <input type="file" class="qr-file-input" id="bancolombia-qr" name="qr_image"
                               accept="image/*" required aria-describedby="bancolombia-help">
                        <div class="qr-file-preview" id="preview-bancolombia"></div>
                        <small id="bancolombia-help" class="qr-form-hint">PNG, JPG, JPEG · Máximo 2MB</small>
                    </div>
                    <button type="submit" class="qr-btn bancolombia">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                        Subir QR Bancolombia
                    </button>
                </form>

                <details class="qr-instructions">
                    <summary>¿Cómo generar el QR de Bancolombia?</summary>
                    <ol>
                        <li>Abre tu app <strong>Bancolombia</strong></li>
                        <li>Ve a <strong>"Cobrar"</strong> → <strong>"Código QR"</strong></li>
                        <li>Selecciona <strong>"Monto fijo"</strong> → <strong>$10,000 COP</strong></li>
                        <li>Descripción: <strong>"Anticipo H Barber Shop"</strong></li>
                        <li>Toca <strong>"Generar QR"</strong>, guarda y sube aquí</li>
                    </ol>
                </details>
            </div>
        </div>

    </div>{{-- /qr-grid --}}

    {{-- Nota informativa --}}
    <div class="qr-info-box">
        <div class="qr-info-box-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        </div>
        <div class="qr-info-box-content">
            <strong>Consejos importantes</strong>
            <ul>
                <li>Configura siempre <strong>$10,000 COP</strong> como monto fijo del anticipo.</li>
                <li>Puedes actualizar los QRs cuando quieras sin perder el historial.</li>
                <li>Si no hay QR cargado, los clientes verán las instrucciones manuales de pago.</li>
            </ul>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    // Preview de imagen antes de subir
    document.querySelectorAll('.qr-file-input').forEach(input => {
        input.addEventListener('change', function (e) {
            const file = e.target.files[0];
            const card  = input.closest('.qr-card');
            const brand = card ? card.dataset.brand : '';
            const previewEl = document.getElementById('preview-' + brand);
            if (!previewEl) return;

            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewEl.innerHTML = `
                        <img src="${e.target.result}" alt="Vista previa">
                        <span>✓ ${file.name}</span>
                    `;
                };
                reader.readAsDataURL(file);
            } else {
                previewEl.innerHTML = '';
            }
        });
    });

    // Estado de carga al enviar
    document.querySelectorAll('.qr-upload-form').forEach(form => {
        form.addEventListener('submit', function (e) {
            const fileInput = form.querySelector('.qr-file-input');
            const submitBtn = form.querySelector('.qr-btn');
            if (!fileInput.files.length) {
                e.preventDefault();
                alert('Por favor selecciona una imagen antes de enviar.');
                return;
            }
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
        });
    });
</script>
@endpush