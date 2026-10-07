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
        $clientes = [
            ['Juan Pérez', 'juan.perez@example.com', '0991234567', 'Av. Principal 123'],
            ['María López', 'maria.lopez@example.com', '0987654321', 'Calle Bolívar 45'],
            ['Carlos García', 'carlos.garcia@example.com', '0998765432', 'Av. Amazonas 210'],
            ['Ana Martínez', 'ana.martinez@example.com', '0976543210', 'Calle Sucre 78'],
            ['Luis Rodríguez', 'luis.rodriguez@example.com', '0965432109', 'Av. 10 de Agosto 532'],
            ['Laura Sánchez', 'laura.sanchez@example.com', '0954321098', 'Calle Olmedo 19'],
            ['Pedro Gómez', 'pedro.gomez@example.com', '0943210987', 'Av. de los Shyris 340'],
            ['Sofía Torres', 'sofia.torres@example.com', '0932109876', 'Calle Rocafuerte 66'],
            ['Diego Ramírez', 'diego.ramirez@example.com', '0921098765', 'Av. 6 de Diciembre 801'],
            ['Valentina Flores', 'valentina.flores@example.com', '0910987654', 'Calle García Moreno 12'],
            ['Andrés Castro', 'andres.castro@example.com', '0999876543', 'Av. Colón 455'],
            ['Camila Morales', 'camila.morales@example.com', '0988765432', 'Calle Mejía 33'],
            ['Jorge Herrera', 'jorge.herrera@example.com', '0977654321', 'Av. América 720'],
            ['Daniela Vargas', 'daniela.vargas@example.com', '0966543210', 'Calle Guayaquil 90'],
            ['Miguel Rojas', 'miguel.rojas@example.com', '0955432109', 'Av. Patria 150'],
        ];

        foreach ($clientes as [$nombre, $email, $telefono, $direccion]) {
            Cliente::create(compact('nombre', 'email', 'telefono', 'direccion'));
        }
    }
}
