<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_sin_sesion_redirige_al_login(): void
    {
        $this->get('/clientes')->assertRedirect('/login');
        $this->get('/')->assertRedirect('/login');
    }

    public function test_muestra_el_formulario_de_login(): void
    {
        $this->get('/login')->assertOk()->assertSee('Iniciar sesión');
    }

    public function test_abrir_el_login_con_sesion_iniciada_vuelve_a_pedir_los_datos(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/login')
            ->assertOk()
            ->assertSee('Iniciar sesión');

        $this->assertGuest();
        $this->get('/clientes')->assertRedirect('/login');
    }

    public function test_inicia_sesion_con_datos_correctos(): void
    {
        $usuario = User::factory()->create(['password' => 'secreta123']);

        $this->post('/login', ['email' => $usuario->email, 'password' => 'secreta123'])
            ->assertRedirect('/clientes');

        $this->assertAuthenticatedAs($usuario);
    }

    public function test_rechaza_contrasena_incorrecta(): void
    {
        $usuario = User::factory()->create(['password' => 'secreta123']);

        $this->post('/login', ['email' => $usuario->email, 'password' => 'otra'])
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_registra_un_usuario_e_inicia_su_sesion(): void
    {
        $this->get('/register')->assertOk()->assertSee('Crear cuenta');

        $this->post('/register', [
            'name' => 'Carla Ruiz',
            'email' => 'carla@example.com',
            'password' => 'clave12345',
            'password_confirmation' => 'clave12345',
        ])->assertRedirect('/clientes');

        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', ['email' => 'carla@example.com']);

        // Con la cuenta nueva también se puede iniciar sesión después
        $this->post('/logout');
        $this->post('/login', ['email' => 'carla@example.com', 'password' => 'clave12345'])
            ->assertRedirect('/clientes');
    }

    public function test_registro_valida_email_repetido_y_confirmacion(): void
    {
        User::factory()->create(['email' => 'usado@example.com']);

        $this->post('/register', [
            'name' => 'Otro',
            'email' => 'usado@example.com',
            'password' => 'clave12345',
            'password_confirmation' => 'diferente',
        ])->assertSessionHasErrors(['email', 'password']);

        $this->assertGuest();
    }

    public function test_cierra_sesion(): void
    {
        $this->actingAs(User::factory()->create())
            ->post('/logout')
            ->assertRedirect('/login');

        $this->assertGuest();
    }
}
