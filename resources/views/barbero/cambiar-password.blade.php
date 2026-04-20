@extends('barbero.layout')

@section('content')
<div style="display:flex;justify-content:center;align-items:center;min-height:70vh;padding:2rem;">
    <div style="background:#1F2937;border:2px solid #DC2626;border-radius:16px;padding:2.5rem;width:100%;max-width:480px;box-shadow:0 20px 60px rgba(0,0,0,0.5);">

        <h1 style="font-family:'Playfair Display',serif;color:#D4AF37;margin-bottom:.5rem;font-size:1.8rem;">Cambiar Contraseña</h1>
        <p style="color:rgba(255,255,255,.7);font-size:.95rem;margin-bottom:1.8rem;">
            Por seguridad debes establecer una contraseña personal antes de continuar.
            No podrás usar el sistema hasta completar este paso.
        </p>

        @if(session('warning'))
            <div style="background:rgba(220,38,38,.2);border:1px solid #DC2626;border-radius:8px;padding:12px 16px;margin-bottom:1.2rem;color:#fecaca;font-size:.9rem;">
                {{ session('warning') }}
            </div>
        @endif

        @if($errors->any())
            <div style="background:rgba(220,38,38,.2);border:1px solid #DC2626;border-radius:8px;padding:12px 16px;margin-bottom:1.2rem;">
                <ul style="margin:0;padding-left:1rem;color:#fecaca;font-size:.9rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('barbero.cambiar-password.update') }}" novalidate>
            @csrf

            <div style="margin-bottom:1.2rem;">
                <label for="password" style="display:block;color:#fff;font-weight:600;margin-bottom:.4rem;font-size:.95rem;">
                    Nueva contraseña <span style="color:#DC2626;">*</span>
                </label>
                <input type="password"
                       id="password"
                       name="password"
                       required
                       autocomplete="new-password"
                       placeholder="Mín. 8 caracteres"
                       style="width:100%;padding:12px 16px;background:rgba(0,0,0,.3);border:2px solid rgba(220,38,38,.3);border-radius:8px;color:#fff;font-size:1rem;box-sizing:border-box;transition:border-color .3s;"
                       onfocus="this.style.borderColor='#DC2626'" onblur="this.style.borderColor='rgba(220,38,38,.3)'">
                <small style="color:rgba(255,255,255,.55);font-size:.78rem;margin-top:.4rem;display:block;">
                    Debe tener al menos 8 caracteres, una mayúscula, un número y un carácter especial (!$#%&?@_").
                </small>
            </div>

            <div style="margin-bottom:1.8rem;">
                <label for="password_confirmation" style="display:block;color:#fff;font-weight:600;margin-bottom:.4rem;font-size:.95rem;">
                    Confirmar contraseña <span style="color:#DC2626;">*</span>
                </label>
                <input type="password"
                       id="password_confirmation"
                       name="password_confirmation"
                       required
                       autocomplete="new-password"
                       placeholder="Repite la contraseña"
                       style="width:100%;padding:12px 16px;background:rgba(0,0,0,.3);border:2px solid rgba(220,38,38,.3);border-radius:8px;color:#fff;font-size:1rem;box-sizing:border-box;transition:border-color .3s;"
                       onfocus="this.style.borderColor='#DC2626'" onblur="this.style.borderColor='rgba(220,38,38,.3)'">
            </div>

            <button type="submit"
                    style="width:100%;padding:14px;background:linear-gradient(135deg,#DC2626,#991B1B);color:#fff;border:none;border-radius:8px;font-weight:700;font-size:1rem;cursor:pointer;letter-spacing:.5px;transition:opacity .2s;"
                    onmouseover="this.style.opacity='.88'" onmouseout="this.style.opacity='1'">
                Guardar contraseña y continuar
            </button>
        </form>
    </div>
</div>
@endsection
