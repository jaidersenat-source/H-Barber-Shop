<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UsuarioFactory extends Factory
{
    protected $model = Usuario::class;

    public function definition()
    {
        return [
            'per_documento' => $this->faker->unique()->numerify('#########'),
            'usuario' => $this->faker->unique()->userName,
            'password' => bcrypt('password'),
            'rol' => 'admin',
            'ultimo_acceso' => now(),
            'estado' => 'activo',
        ];
    }
}
