<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

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
                'nama_lengkap' => 'Super Administrator',
                'password' => $password,
                'nomor_kontak' => '081200000000',
                'role' => 'super admin',
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
