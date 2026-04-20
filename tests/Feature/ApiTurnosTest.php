<?php

namespace Tests\Feature;

use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiTurnosTest extends TestCase
{
use RefreshDatabase;

public function test_barbero_puede_iniciar_sesion()
   {
      // Crea primero una persona
      $persona = \Database\Factories\PersonaFactory::new()->create();

      // Crea un usuario barbero asociado a esa persona
      $barbero = \Database\Factories\UsuarioFactory::new()->create([
         'rol' => 'barbero',
         'per_documento' => $persona->per_documento,
         'usuario' => 'barbero_test',
         'password' => bcrypt('barbero123'),
         'estado' => 'activo',
      ]);

      // Realiza el login
      $response = $this->post('/login', [
         'usuario' => 'barbero_test',
         'password' => 'barbero123',
      ]);

      // Verifica que redirige al dashboard de barbero
      $response->assertRedirect(route('barbero.dashboard'));
   }
}