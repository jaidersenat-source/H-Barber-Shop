<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Persona;
use App\Models\Usuario;



class PerfilController extends Controller
{
    public function show()
    {
        /** @var \App\Models\Usuario $user */
        $user = Auth::user();
        // Puedes pasar la relación persona si la necesitas en la vista:
        $persona = $user->persona ?? null;
        return view('admin.perfil.configuracion', compact('user', 'persona'));
    }

    public function update(Request $request)
    {
        /** @var \App\Models\Usuario $user */
        $user = Auth::user();
        $request->validate([
            'username' => 'required|string|max:255|unique:usuarios,usuario,' . $user->usuario_id . ',usuario_id',
            'documento' => 'required|string|max:30|unique:usuarios,per_documento,' . $user->usuario_id . ',usuario_id',
            'email' => 'required|email',
        ]);
        
        $user->usuario = $request->username;
        $user->per_documento = $request->documento;
        $user->save();

        // Actualizar correo en la tabla persona (si existe relación)
        if ($user->persona !== null) {
            $user->persona->per_correo = $request->email;
            $user->persona->save();
        }

        // Cambiar contraseña si se solicita
        if ($request->filled('current_password') === true && $request->filled('password') === true) {
            if (Hash::check($request->current_password, $user->password) === false) {
                return back()->withErrors(['current_password' => 'La contraseña actual es incorrecta.']);
            }
            $request->validate([
                'password' => [
                    'required',
                    'min:8',
                    'confirmed',
                    'regex:/^(?=.*[A-Z])(?=.*\d).+$/', // Al menos una mayúscula y un número
                ],
            ], [
                'password.regex' => 'La contraseña debe tener al menos una mayúscula y un número.'
            ]);
            $user->password = Hash::make($request->password);
            $user->save();
        }
        return back()->with('success', 'Perfil actualizado correctamente.');
    }

    /**
     * Mostrar la página de información personal
     */
    public function informacion()
    {
        /** @var \App\Models\Usuario $user */
        $user = Auth::user();
        $persona = $user->persona ?? null;
        return view('admin.perfil.informacion', compact('user', 'persona'));
    }

    /**
     * Actualizar información personal
     */
    public function updateInformacion(Request $request)
    {
        /** @var \App\Models\Usuario $user */
        $user = Auth::user();
        
        $request->validate([
            'usuario' => 'required|string|max:255|unique:usuarios,usuario,' . $user->usuario_id . ',usuario_id',
            'per_documento' => 'required|string|max:30|unique:usuarios,per_documento,' . $user->usuario_id . ',usuario_id',
            'per_nombres' => 'required|string|max:80',
            'per_apellidos' => 'required|string|max:80',
            'per_correo' => 'required|email|max:120',
            'per_celular' => 'nullable|string|max:20',
        ]);

        // Actualizar datos del usuario
        $user->update([
            'usuario' => $request->usuario,
            'per_documento' => $request->per_documento,
        ]);

        // Actualizar o crear persona
        if ($user->persona) {
            $user->persona->update([
                'per_nombres' => $request->per_nombres,
                'per_apellidos' => $request->per_apellidos,
                'per_correo' => $request->per_correo,
                'per_celular' => $request->per_celular,
            ]);
        } else {
            // Crear persona si no existe
            Persona::create([
                'per_documento' => $request->per_documento,
                'per_nombres' => $request->per_nombres,
                'per_apellidos' => $request->per_apellidos,
                'per_correo' => $request->per_correo,
                'per_celular' => $request->per_celular,
                'per_estado' => 'activo',
            ]);
        }

        return back()->with('success', 'Información personal actualizada correctamente.');
    }

    /**
     * Actualizar contraseña
     */
    public function updatePassword(Request $request)
    {
        /** @var \App\Models\Usuario $user */
        $user = Auth::user();
        
        $request->validate([
            'current_password' => 'required',
            'password' => [
                'required',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[A-Z])(?=.*\d).+$/', // Al menos una mayúscula y un número
            ],
        ], [
            'password.regex' => 'La contraseña debe tener al menos una mayúscula y un número.',
            'current_password.required' => 'La contraseña actual es obligatoria.',
        ]);

        // Verificar contraseña actual
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual es incorrecta.']);
        }

        // Actualizar contraseña
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Contraseña actualizada correctamente.');
    }

    /**
     * Mostrar configuraciones de redes sociales
     */
    public function configuracionesGenerales()
    {
        $redes_sociales = config('site.redes_sociales');
        $whatsapp = config('site.contacto.whatsapp');
        return view('admin.perfil.configuraciones-generales', compact('redes_sociales', 'whatsapp'));
    }

    /**
     * Actualizar configuraciones de redes sociales
     */
    public function updateConfiguracionesGenerales(Request $request)
    {
        $request->validate([
            'whatsapp' => 'required|string|max:20',
            'instagram' => 'nullable|url|max:500',
            'facebook' => 'nullable|url|max:500',
            'tiktok' => 'nullable|url|max:500',
            'youtube' => 'nullable|url|max:500',
        ], [
            'whatsapp.required' => 'El número de WhatsApp es obligatorio.',
            'instagram.url' => 'El enlace de Instagram debe ser una URL válida.',
            'facebook.url' => 'El enlace de Facebook debe ser una URL válida.',
        ]);

        // Obtener configuraciones actuales
        $configuraciones = config('site');

        // Actualizar solo redes sociales y WhatsApp
        $configuraciones['contacto']['whatsapp'] = $request->input('whatsapp');
        $configuraciones['redes_sociales']['instagram'] = $request->input('instagram');
        $configuraciones['redes_sociales']['facebook'] = $request->input('facebook');
        $configuraciones['redes_sociales']['tiktok'] = $request->input('tiktok');
        $configuraciones['redes_sociales']['youtube'] = $request->input('youtube');

        // Escribir el archivo de configuración
        $this->writeConfigFile($configuraciones);

        return back()->with('success', 'Configuraciones actualizadas correctamente.');
    }

    /**
     * Escribir archivo de configuración
     */
    private function writeConfigFile($configuraciones)
    {
        $configPath = config_path('site.php');
        
        // Generar el contenido del archivo de manera más robusta
        $content = $this->arrayToPhpString($configuraciones);
        
        File::put($configPath, $content);
        
        // Limpiar cache de configuración
        \Illuminate\Support\Facades\Artisan::call('config:clear');
        
        // Recargar configuración
        app('config')->set('site', include $configPath);
    }
    
    /**
     * Convertir array a string PHP de manera segura
     */
    private function arrayToPhpString($array, $indent = 0)
    {
        $indentStr = str_repeat('  ', $indent);
        $items = [];
        
        foreach ($array as $key => $value) {
            $keyStr = "'$key'";
            
            if (is_array($value)) {
                $valueStr = "\n$indentStr  [\n" . $this->arrayToPhpString($value, $indent + 2) . "\n$indentStr  ]";
            } elseif (is_null($value)) {
                $valueStr = 'NULL';
            } elseif (is_string($value)) {
                $valueStr = "'" . addslashes($value) . "'";
            } else {
                $valueStr = var_export($value, true);
            }
            
            $items[] = "$indentStr  $keyStr => $valueStr";
        }
        
        if ($indent === 0) {
            return "<?php\n\nreturn [\n" . implode(",\n", $items) . ",\n];\n";
        } else {
            return implode(",\n", $items);
        }
    }

    /**
     * Página principal de configuración
     */
    public function index()
    {
        // Puedes cambiar la vista por la que desees mostrar como principal
        return view('admin.perfil.configuracion');
    }

    /**
     * Manual de usuario accesible
     */
    public function manualUsuario()
    {
        return view('admin.perfil.manual_usuario');
    }

    public function manualUsuarioPdf()
    {
        $pdf = Pdf::loadView('admin.perfil.manual_usuario_pdf')
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => false,
            ]);

        return $pdf->download('manual-usuario-h-barber-shop.pdf');
    }

      /**
     * Guardar la foto de perfil del usuario
     */

      public function guardarFoto(Request $request)
{
    $user = Auth::user();
    $request->validate([
        'foto_perfil' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048'
    ]);

    // Guardar archivo en storage/public/perfiles
    $path = $request->file('foto_perfil')->store('perfiles', 'public');

    // Eliminar imagen anterior si existe
    if ($user->foto_perfil && \Illuminate\Support\Facades\File::exists(public_path('storage/' . $user->foto_perfil))) {
        \Illuminate\Support\Facades\File::delete(public_path('storage/' . $user->foto_perfil));
    }

    // Guardar ruta en la base de datos
    $user->foto_perfil = $path;
    $user->save();

    return back()->with('success', 'Foto de perfil actualizada correctamente.');
}

    public function updateFoto(Request $request)
    {
        $user = Auth::user();
        // Eliminar archivo físico si existe
        if ($user->foto_perfil && File::exists(public_path('storage/' . $user->foto_perfil))) {
            File::delete(public_path('storage/' . $user->foto_perfil));
        }
        // Eliminar referencia en la base de datos
        $user->update(['foto_perfil' => null]);
        return back()->with('success', 'Foto de perfil eliminada correctamente.');
    }


}
