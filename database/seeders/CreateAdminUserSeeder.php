<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use App\Models\Persona;
use Illuminate\Support\Facades\Hash;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $perDocumento = '102802699';
        $username = 'admin102802699';
        $password = 'Admin2025!'; // Cambia esto si quieres otra contraseña

        // Primero aseguramos que exista la persona relacionada
        if (!Persona::where('per_documento', $perDocumento)->exists()) {
            Persona::create([
                'per_documento' => $perDocumento,
                'per_nombre' => 'Administrador',
                'per_apellido' => 'Sistema',
                'per_correo' => 'admin@example.com',
                'per_telefono' => null,
            ]);
            $this->command->info("Persona creada para per_documento {$perDocumento}.");
        } else {
            $this->command->info("Persona para per_documento {$perDocumento} ya existe. Se usará la existente.");
        }

        if (Usuario::where('per_documento', $perDocumento)->exists() === true) {
            $this->command->info("Usuario para per_documento {$perDocumento} ya existe. No se creará.");
            return;
        }

        Usuario::create([
            'per_documento' => $perDocumento,
            'usuario' => $username,
            'password' => Hash::make($password),
            'rol' => 'admin',
            'ultimo_acceso' => now(),
            'estado' => 'activo',
        ]);

        $this->command->info("Usuario admin creado: usuario={$username} contraseña={$password}");
    }
}
