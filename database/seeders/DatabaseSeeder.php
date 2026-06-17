<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            LocationSeeder::class,
        ]);

        // Seed default Bidan user
        User::create([
            'name' => 'super administrator',
            'email' => 'admin@satukia.com',
            'phone' => '081234567890',
            'role' => 'bidan',
            'nip' => '199001012026062001',
            'password' => Hash::make('Password123'),
        ]);

        // Seed default Ortu (Orang Tua) user
        User::create([
            'name' => 'Diva Lunetta',
            'email' => 'diva@gmail.com',
            'phone' => '+6285645551399',
            'role' => 'ortu',
            'nik' => '1202220184123456',
            'password' => Hash::make('Password123'),
        ]);

        // Seed default Dinkes (Dinas Kesehatan) user
        User::create([
            'name' => 'Tim Dinas Kesehatan',
            'email' => 'dinkes@satukia.com',
            'phone' => '081112223334',
            'role' => 'dinkes',
            'nip' => '198001012026062002',
            'password' => Hash::make('Password123'),
        ]);
    }
}
