<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Carga los datos de prueba de la aplicación (php artisan db:seed).
     */
    public function run(): void
    {
        // Usuario para iniciar sesión (la contraseña se guarda cifrada automáticamente).
        // updateOrCreate evita duplicarlo si el seeder se ejecuta más de una vez.
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Administrador', 'password' => 'admin123'],
        );

        $this->call(ClienteSeeder::class);
    }
}
