<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Cambiá el email/contraseña por valores seguros en tu entorno
        $email = 'admin@example.com';
        $password = 'secret123';

        $user = User::where('email', $email)->first();

        if (!$user) {
            User::create([
                'name' => 'Admin',
                'email' => $email,
                'password' => Hash::make($password),
                'role' => 'admin',
            ]);
        } else {
            // asegura que tenga rol admin
            $user->update(['role' => 'admin']);
        }
    }
}
