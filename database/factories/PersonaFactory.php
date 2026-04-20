<?php

namespace Database\Factories;

use App\Models\Persona;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonaFactory extends Factory
{
    protected $model = Persona::class;

    public function definition()
    {
        return [
            'per_documento' => $this->faker->unique()->numerify('#########'),
            'per_nombre' => $this->faker->firstName,
            'per_apellido' => $this->faker->lastName,
            'per_correo' => $this->faker->unique()->safeEmail,
            'per_telefono' => $this->faker->phoneNumber,
            'per_fecha_nacimiento' => $this->faker->date(),
            // Agrega aquí los campos obligatorios de la tabla persona
        ];
    }
}
