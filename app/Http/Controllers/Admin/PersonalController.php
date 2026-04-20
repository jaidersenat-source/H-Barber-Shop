<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Persona;
use App\Models\Personal_Sede;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PersonalController extends Controller
{
    public function index()
    {
        $personal = Personal_Sede::with(['persona.usuario', 'sede'])->get();
        // notificaciones del admin autenticado
        $notifications = [];
       if (Auth::check() === true) {
            $notifications = Auth::user()->unreadNotifications;
        }

        return view('admin.personal.index', compact('personal', 'notifications'));
    }

    public function create()
    {
        $sede = DB::table('sede')->get();
        return view('admin.personal.create', compact('sede'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'per_documento' => 'required|unique:persona,per_documento|digits_between:1,10',
            'per_nombre' => ['required','regex:/^[\pL\s\-]+$/u'],
            'per_apellido' => ['required','regex:/^[\pL\s\-]+$/u'],
            'per_correo' => 'required|email',
            'per_telefono' => 'required|unique:persona,per_telefono|digits:10',
            'sede_id' => 'required|exists:sede,sede_id',
            'rol' => 'required',
        ], [
            'per_documento.unique' => 'La cédula ya está registrada.',
            'per_documento.digits_between' => 'La cédula debe tener máximo 10 dígitos.',
            'per_telefono.unique' => 'El número de teléfono ya está registrado.',
            'per_telefono.digits' => 'El número de teléfono debe tener exactamente 10 dígitos.',
            'per_nombre.regex' => 'El nombre solo puede contener letras, espacios y guiones.',
            'per_apellido.regex' => 'El apellido solo puede contener letras, espacios y guiones.',
        ]);

        // Si el rol es admin, pedir y validar la contraseña del admin actual
        if ($request->rol === 'admin') {
            $request->validate([
                'rol_password' => 'required',
            ], [
                'rol_password.required' => 'Debes ingresar tu contraseña para registrar un nuevo administrador.'
            ]);
            $admin = Auth::user();
            if ($admin === null || Hash::check($request->rol_password, $admin->password) === false) {
                return back()->withErrors(['rol_password' => 'Contraseña incorrecta. No tienes permiso para registrar un administrador.'])->withInput();
            }
        }

        DB::beginTransaction();
        try {
            // 1. Crear persona
            $persona = Persona::create([
                'per_documento' => $request->per_documento,
                'per_nombre'    => $request->per_nombre,
                'per_apellido'  => $request->per_apellido,
                'per_correo'    => $request->per_correo,
                'per_telefono'  => $request->per_telefono,
            ]);

            // 2. Registrar la asignación a la sede
            Personal_Sede::create([
                'sede_id'                => $request->sede_id,
                'per_documento'          => $persona->per_documento,
                'persede_fecha_registro' => now(),
                'persede_estado'         => 'activo',
            ]);

            // 3. Crear usuario con el documento como usuario y contraseña temporal
            //    El barbero deberá cambiarla en su primer inicio de sesión.
            $documento = $request->per_documento;
            if (!Usuario::where('per_documento', $documento)->exists()) {
                Usuario::create([
                    'per_documento'          => $documento,
                    'usuario'                => $documento,
                    'password'               => Hash::make($documento),
                    'rol'                    => 'barbero',
                    'estado'                 => 'activo',
                    'debe_cambiar_password'  => true,
                    'ultimo_acceso'          => null,
                ]);
            }

            DB::commit();
            return redirect()->route('personal.index')->with('ok', 'Barbero registrado correctamente. Sus credenciales iniciales son su número de documento.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('personal.index')->with('error', 'No se pudo registrar el barbero. Intente nuevamente o contacte soporte.');
        }
    }

    public function desactivarUsuario($usuario_id)
    {
        $usuario = \App\Models\Usuario::findOrFail($usuario_id);
        $usuario->estado = 'inactivo';
        $usuario->save();
        return back()->with('ok', 'Usuario desactivado correctamente.');
    }
}
