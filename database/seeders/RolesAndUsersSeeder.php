<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesAndUsersSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::ensureExists('admin', Role::ADMIN_NAMES);

        $userRole = Role::ensureExists('user', Role::USER_NAMES);

        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('prueba1'),
                'role_id' => $adminRole->id,
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Usuario Normal',
                'password' => Hash::make('123465'),
                'role_id' => $userRole->id,
                'email_verified_at' => now(),
            ]
        );
    }
}
