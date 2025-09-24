<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 👉 acá llamás a tus seeders personalizados
        $this->call([
            RolesAndUsersSeeder::class,
        ]);

        // Si querés seguir creando usuarios de prueba con factories
        // User::factory(10)->create();

        // Ejemplo de un usuario de prueba simple:
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
