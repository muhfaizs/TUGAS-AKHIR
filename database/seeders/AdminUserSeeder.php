<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Seed the Super Admin account.
     */
    public function run(): void
    {
        $username = 'superadmin';
        $password = 'SuperAdmin@2026';

        User::updateOrCreate(
            ['username' => $username],
            [
                'name' => 'Super Administrator',
                'email' => 'superadmin@satukia.com',
                'password' => Hash::make($password),
                'phone' => '081200000000',
                'role' => 'super_admin',
                'hak_akses_master' => ['full_access' => true],
            ]
        );

        $this->command->info('');
        $this->command->info('╔══════════════════════════════════════════════╗');
        $this->command->info('║       SUPER ADMIN CREDENTIALS CREATED       ║');
        $this->command->info('╠══════════════════════════════════════════════╣');
        $this->command->info('║  Username : superadmin                      ║');
        $this->command->info('║  Password : SuperAdmin@2026                 ║');
        $this->command->info('╚══════════════════════════════════════════════╝');
        $this->command->info('');
    }
}
