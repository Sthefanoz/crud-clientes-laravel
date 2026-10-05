<?php

namespace Database\Seeders;

use App\Models\Cliente;
use Illuminate\Database\Seeder;

class ClienteSeeder extends Seeder
{
    /**
     * Llena la tabla clientes con 15 registros de prueba.
     */
    public function run(): void
    {
        Cliente::factory(15)->create();
    }
}
