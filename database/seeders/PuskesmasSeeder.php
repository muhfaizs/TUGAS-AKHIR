<?php

namespace Database\Seeders;

use App\Models\Puskesmas;
use Illuminate\Database\Seeder;

class PuskesmasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $puskesmas = [
            [
                'name' => 'Puskesmas Bojongsoang',
                'code' => 'PSK001',
                'address' => 'Jl. Bojongsoang Raya',
                'village' => 'Bojongsoang',
                'district' => 'Bojongsoang',
                'sub_district' => 'Bandung',
                'postal_code' => '40288',
                'phone' => '(022) 1234567',
                'email' => 'bojongsoang@puskesmas.id',
                'head_of_puskesmas' => 'Dr. Kepala Puskesmas',
                'status' => 'active',
            ]
        ];

        foreach ($puskesmas as $item) {
            Puskesmas::create($item);
        }
    }
}
