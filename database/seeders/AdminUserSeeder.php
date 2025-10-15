<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = 'admin@example.com';
        $password = 'secret123';

        $adminRole = Role::ensureExists('admin', Role::ADMIN_NAMES);

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => 'Admin',
                'password' => Hash::make($password),
                'role_id' => $adminRole->id,
                'email_verified_at' => now(),
            ]
        );
    }
}
