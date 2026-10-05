<?php

namespace Tests\Feature;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClienteCrudTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Todas las pruebas del CRUD se hacen con un usuario que inició sesión
        $this->actingAs(User::factory()->create());
    }

    public function test_lista_y_busca_clientes(): void
    {
        Cliente::factory()->create(['nombre' => 'Ana Torres']);
        Cliente::factory()->create(['nombre' => 'Luis Pérez']);

        $this->get('/clientes')->assertOk()->assertSee('Ana Torres')->assertSee('Luis Pérez');

        $this->get('/clientes?buscar=Ana')->assertOk()->assertSee('Ana Torres')->assertDontSee('Luis Pérez');
    }

    public function test_muestra_formularios_y_detalle(): void
    {
        $cliente = Cliente::factory()->create();

        $this->get('/clientes/create')->assertOk();
        $this->get("/clientes/{$cliente->id}")->assertOk()->assertSee($cliente->email);
        $this->get("/clientes/{$cliente->id}/edit")->assertOk()->assertSee($cliente->nombre);
    }

    public function test_crea_un_cliente(): void
    {
        $this->post('/clientes', [
            'nombre' => 'María López',
            'email' => 'maria@example.com',
            'telefono' => '0991234567',
            'direccion' => 'Av. Siempre Viva 123',
        ])->assertRedirect('/clientes')->assertSessionHas('success');

        $this->assertDatabaseHas('clientes', ['email' => 'maria@example.com']);
    }

    public function test_valida_datos_obligatorios_y_email_unico(): void
    {
        Cliente::factory()->create(['email' => 'repetido@example.com']);

        $this->post('/clientes', ['nombre' => '', 'email' => 'repetido@example.com'])
            ->assertSessionHasErrors(['nombre', 'email']);

        $this->assertDatabaseCount('clientes', 1);
    }

    public function test_actualiza_un_cliente_conservando_su_email(): void
    {
        $cliente = Cliente::factory()->create();

        $this->put("/clientes/{$cliente->id}", [
            'nombre' => 'Nombre Nuevo',
            'email' => $cliente->email,
        ])->assertRedirect('/clientes')->assertSessionHasNoErrors();

        $this->assertDatabaseHas('clientes', ['id' => $cliente->id, 'nombre' => 'Nombre Nuevo']);
    }

    public function test_elimina_un_cliente(): void
    {
        $cliente = Cliente::factory()->create();

        $this->delete("/clientes/{$cliente->id}")->assertRedirect('/clientes');

        $this->assertDatabaseMissing('clientes', ['id' => $cliente->id]);
    }
}
