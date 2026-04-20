<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Términos de Uso Interno — H Barber Shop CRM</title>
    <link rel="icon" type="image/png" href="/img/1.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            background: #0a0a0a;
            color: #ccc;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 2rem 1rem 4rem;
        }
        .page-logo {
            display: flex;
            align-items: center;
            gap: .75rem;
            margin-bottom: 2rem;
        }
        .page-logo-letter {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 2.5rem;
            font-weight: 900;
            color: #d4af37;
            line-height: 1;
        }
        .page-logo-divider { width: 1px; height: 36px; background: rgba(212,175,55,.4); }
        .page-logo-text { display: flex; flex-direction: column; }
        .page-logo-top    { font-size: .8rem; font-weight: 700; color: #d4af37; letter-spacing: .12em; }
        .page-logo-bottom { font-size: .7rem; color: #888; letter-spacing: .1em; }

        .terms-card {
            background: #141414;
            border: 1px solid #222;
            border-top: 3px solid #d4af37;
            border-radius: 10px;
            width: 100%;
            max-width: 760px;
            padding: 2rem;
            box-shadow: 0 8px 40px rgba(0,0,0,.5);
        }
        .terms-card-header {
            text-align: center;
            margin-bottom: 1.75rem;
            padding-bottom: 1.25rem;
            border-bottom: 1px solid #222;
        }
        .terms-card-header .badge {
            display: inline-block;
            background: rgba(212,175,55,.15);
            color: #d4af37;
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            padding: .25rem .75rem;
            border-radius: 999px;
            margin-bottom: .75rem;
        }
        .terms-card-header h1 {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 1.5rem;
            color: #e8d5a3;
            line-height: 1.3;
            margin-bottom: .4rem;
        }
        .terms-card-header p {
            color: #888;
            font-size: .83rem;
        }

        .terms-body {
            max-height: 52vh;
            overflow-y: auto;
            padding-right: .5rem;
            margin-bottom: 1.5rem;
            font-size: .875rem;
            line-height: 1.7;
            color: #bbb;
            scroll-behavior: smooth;
        }
        .terms-body::-webkit-scrollbar       { width: 5px; }
        .terms-body::-webkit-scrollbar-track { background: #1a1a1a; }
        .terms-body::-webkit-scrollbar-thumb { background: #d4af37; border-radius: 3px; }

        .terms-article { margin-bottom: 1.25rem; }
        .terms-article h2 {
            font-size: .92rem;
            font-weight: 700;
            color: #e0e0e0;
            margin-bottom: .5rem;
            padding: .4rem .6rem;
            background: #1a1a1a;
            border-left: 3px solid #d4af37;
            border-radius: 3px;
        }
        .terms-article ul { padding-left: 1.2rem; margin: .4rem 0; }
        .terms-article ul li { margin-bottom: .3rem; }
        .terms-article p   { margin-bottom: .4rem; }
        .terms-article strong { color: #e0e0e0; }

        .scroll-hint {
            text-align: center;
            font-size: .75rem;
            color: #555;
            margin-bottom: 1rem;
        }
        .scroll-hint svg { vertical-align: middle; }

        .alerta-legal {
            background: rgba(245,158,11,.08);
            border: 1px solid rgba(245,158,11,.25);
            border-radius: 6px;
            padding: .9rem 1.1rem;
            font-size: .82rem;
            color: #fbbf24;
            margin-bottom: 1.25rem;
            line-height: 1.6;
        }

        .accept-form { display: flex; flex-direction: column; gap: 1rem; }
        .accept-label {
            display: flex;
            align-items: flex-start;
            gap: .65rem;
            cursor: pointer;
            background: #1a1a1a;
            border: 1px solid #2a2a2a;
            border-radius: 6px;
            padding: 1rem;
            transition: border-color .2s;
        }
        .accept-label:has(input:checked) { border-color: #d4af37; }
        .accept-label input { margin-top: 3px; flex-shrink: 0; accent-color: #d4af37; width: 16px; height: 16px; }
        .accept-label span { font-size: .85rem; color: #ccc; line-height: 1.55; }
        .accept-label a { color: #d4af37; text-decoration: underline; }

        .btn-accept {
            background: #d4af37;
            color: #0a0a0a;
            font-weight: 700;
            font-size: .95rem;
            padding: .8rem 1.5rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            width: 100%;
            transition: opacity .2s;
            letter-spacing: .03em;
        }
        .btn-accept:disabled { opacity: .35; cursor: not-allowed; }
        .btn-accept:not(:disabled):hover { opacity: .88; }

        .register-note {
            text-align: center;
            font-size: .75rem;
            color: #555;
            margin-top: .5rem;
        }
        @if(session('warning'))
        .flash-warning {
            background: rgba(239,68,68,.1);
            border: 1px solid rgba(239,68,68,.3);
            color: #fca5a5;
            border-radius: 6px;
            padding: .75rem 1rem;
            font-size: .83rem;
            margin-bottom: 1rem;
        }
        @endif
    </style>
</head>
<body>

    <!-- Logo -->
    <div class="page-logo" aria-label="H Barber Shop">
        <span class="page-logo-letter">H</span>
        <div class="page-logo-divider" aria-hidden="true"></div>
        <div class="page-logo-text">
            <span class="page-logo-top">H BARBER</span>
            <span class="page-logo-bottom">SHOP SAS</span>
        </div>
    </div>

    <div class="terms-card" role="main">

        <!-- Encabezado -->
        <div class="terms-card-header">
            <span class="badge">Primer acceso — CRM</span>
            <h1>Términos de Uso Interno del Sistema</h1>
            <p>Debes leer y aceptar estos términos antes de acceder al panel de trabajo.</p>
        </div>

        @if(session('warning'))
        <div class="flash-warning" role="alert">⚠️ {{ session('warning') }}</div>
        @endif

        @if($errors->any())
        <div class="flash-warning" role="alert">
            @foreach($errors->all() as $error) {{ $error }}<br> @endforeach
        </div>
        @endif

        <!-- Hint de scroll -->
        <p class="scroll-hint" aria-live="polite">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M12 5v14M5 12l7 7 7-7"/></svg>
            Desplázate para leer el documento completo
        </p>

        <!-- Cuerpo del documento -->
        <div class="terms-body" id="terms-body" role="document" tabindex="0" aria-label="Términos de Uso Interno del CRM — H Barber Shop SAS">

            <div class="terms-article">
                <h2>5.1. Objeto</h2>
                <p>Los presentes Términos regulan el acceso y uso del sistema CRM por parte de los miembros del equipo de trabajo de H BARBER SHOP S.A.S. Al aceptar estos términos, el colaborador reconoce haber leído, comprendido y se obliga a cumplir todas las disposiciones aquí establecidas.</p>
            </div>

            <div class="terms-article">
                <h2>5.2. Acceso y Credenciales</h2>
                <ul>
                    <li>Las credenciales de acceso (usuario y contraseña) son de uso <strong>personal e intransferible</strong>.</li>
                    <li>Queda prohibido compartir, prestar o ceder las credenciales a terceros, incluso a otros miembros del equipo.</li>
                    <li>El colaborador es responsable de todas las acciones realizadas con su cuenta de acceso.</li>
                    <li>Ante cualquier sospecha de acceso no autorizado, el colaborador debe reportarlo de inmediato a la administración.</li>
                    <li>La contraseña debe mantenerse confidencial y no escribirse en lugares visibles o accesibles.</li>
                </ul>
            </div>

            <div class="terms-article">
                <h2>5.3. Uso Permitido del Sistema</h2>
                <p>El colaborador podrá utilizar el CRM exclusivamente para:</p>
                <ul>
                    <li>Consultar y gestionar la agenda de citas asignadas.</li>
                    <li>Registrar información de los servicios prestados a los clientes.</li>
                    <li>Acceder al historial de servicios de clientes en el marco de su labor.</li>
                    <li>Consultar información operativa del establecimiento autorizada por la administración.</li>
                </ul>
            </div>

            <div class="terms-article">
                <h2>5.4. Usos Prohibidos</h2>
                <p>Queda expresamente <strong>prohibido</strong> al colaborador:</p>
                <ul>
                    <li>Acceder a información de clientes o del sistema fuera del horario o contexto laboral.</li>
                    <li>Copiar, exportar, fotografiar o reproducir por cualquier medio la información de clientes.</li>
                    <li>Compartir información de clientes con terceros, competidores o personas ajenas a la empresa.</li>
                    <li>Utilizar los datos del CRM para fines personales, comerciales o ajenos a las funciones laborales.</li>
                    <li>Intentar acceder a secciones del sistema para las que no tiene autorización.</li>
                    <li>Modificar, eliminar o alterar registros sin autorización expresa de la administración.</li>
                </ul>
            </div>

            <div class="terms-article">
                <h2>5.5. Confidencialidad de la Información</h2>
                <p>El colaborador reconoce que toda la información a la que tenga acceso a través del CRM — incluyendo datos de clientes, historial de servicios, precios, estrategias comerciales e información operativa — constituye <strong>información confidencial y propiedad exclusiva de H BARBER SHOP S.A.S.</strong></p>
                <p>Esta obligación se mantiene vigente durante toda la relación laboral y por un período de <strong>dos (2) años</strong> posteriores a la terminación del vínculo con la empresa, independientemente de la causa.</p>
            </div>

            <div class="terms-article">
                <h2>5.6. Propiedad de la Información</h2>
                <p>Todos los datos registrados en el CRM, incluyendo la base de datos de clientes, historiales de servicios y cualquier otro registro, son propiedad exclusiva de <strong>H BARBER SHOP S.A.S.</strong> El colaborador no adquiere ningún derecho sobre dicha información por el hecho de haberla gestionado.</p>
            </div>

            <div class="terms-article">
                <h2>5.7. Consecuencias del Incumplimiento</h2>
                <p>El incumplimiento de cualquiera de las disposiciones podrá dar lugar a:</p>
                <ul>
                    <li>Suspensión inmediata del acceso al sistema CRM.</li>
                    <li>Inicio de proceso disciplinario interno.</li>
                    <li>Terminación del contrato o vínculo laboral por justa causa.</li>
                    <li>Acciones legales civiles y/o penales conforme a la legislación colombiana, incluyendo la Ley 1581 de 2012 y el Código Penal en lo relativo a la violación de datos personales.</li>
                </ul>
            </div>

            <div class="terms-article">
                <h2>5.8. Aceptación Digital</h2>
                <p>Al hacer clic en el botón "Aceptar y continuar", el colaborador declara libre y voluntariamente que ha leído, comprendido y acepta en su totalidad los presentes Términos de Uso Interno.</p>
                <p>Esta aceptación digital tiene <strong>plena validez legal</strong> y quedará registrada en el sistema con fecha, hora e identificación del usuario, conforme a lo dispuesto en la <strong>Ley 527 de 1999</strong> sobre comercio electrónico y firmas digitales en Colombia.</p>
            </div>

            <div class="terms-article" style="padding:.75rem;background:#1a1a1a;border-radius:6px;border:1px dashed #2a2a2a;margin-top:1rem;">
                <p style="font-size:.78rem;color:#777;text-align:center;">
                    <strong style="color:#aaa;">H BARBER SHOP S.A.S.</strong> &nbsp;|&nbsp; NIT: 901.814.813-3<br>
                    Representante Legal: Angie Katerine Hernández Villamil<br>
                    Documento versión 2.0 — Neiva, Huila, Colombia — Abril 2026
                </p>
            </div>
        </div>

        <!-- Alerta legal -->
        <div class="alerta-legal" role="note" aria-label="Nota legal importante">
            <strong>⚖️ Validez legal:</strong> La aceptación que realices a continuación quedará registrada con tu nombre de usuario, fecha, hora y dirección IP, conforme a la Ley 527 de 1999 (comercio electrónico). Esta constancia puede ser consultada por la administración en cualquier momento.
        </div>

        <!-- Formulario de aceptación -->
        <form method="POST" action="{{ route('barbero.crm.terminos.aceptar') }}" class="accept-form" id="termsForm">
            @csrf
            <label class="accept-label" for="accept_terms">
                <input type="checkbox" id="accept_terms" name="accept_terms"
                       onchange="document.getElementById('btnAceptar').disabled=!this.checked;"
                       aria-required="true">
                <span>
                    He leído íntegramente y acepto los <strong>Términos de Uso Interno y el Acuerdo de Confidencialidad</strong> de H Barber Shop SAS, en su versión 2.0. Entiendo que esta aceptación tiene validez legal conforme a la Ley 527 de 1999 y quedará registrada en el sistema.
                </span>
            </label>

            <button type="submit" id="btnAceptar" class="btn-accept" disabled aria-disabled="true"
                    aria-label="Aceptar los términos de uso interno y continuar al panel">
                ✓ &nbsp; Aceptar y continuar
            </button>

            <p class="register-note">
                Se registrará: <strong>{{ Auth::guard('usuario')->user()->usuario ?? 'tu usuario' }}</strong> — {{ now()->format('d/m/Y H:i') }} — IP: {{ request()->ip() }}
            </p>
        </form>

    </div>

    <script>
    // Asegurar que el botón se mantiene deshabilitado al cargar
    document.getElementById('btnAceptar').disabled = true;
    document.getElementById('accept_terms').checked = false;
    </script>
</body>
</html>
