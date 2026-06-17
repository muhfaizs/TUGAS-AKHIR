<?php

namespace Database\Seeders;

use App\Models\Kabupaten;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run()
    {
        $kab = Kabupaten::create(['nama_kabupaten' => 'Kabupaten Bandung']);
        $pusk = $kab->puskesmas()->create([
            'nama_puskesmas' => 'Puskesmas Bojongsoang', 
            'name' => 'Puskesmas Bojongsoang', 
            'code' => 'P3204001', 
            'address' => 'Jl. Raya Bojongsoang No. 1',
            'village' => 'Bojongsoang',
            'district' => 'Bojongsoang',
            'sub_district' => 'Bandung',
            'postal_code' => '40288'
        ]);
        $pusk->posyandus()->create(['nama_posyandu' => 'Posyandu Anggrek 1']);
        $pusk->posyandus()->create(['nama_posyandu' => 'Posyandu Melati 2']);

        $kab2 = Kabupaten::create(['nama_kabupaten' => 'Kota Bandung']);
        $pusk2 = $kab2->puskesmas()->create([
            'nama_puskesmas' => 'Puskesmas Sukajadi', 
            'name' => 'Puskesmas Sukajadi', 
            'code' => 'P3273001', 
            'address' => 'Jl. Sukajadi No. 2',
            'village' => 'Sukajadi',
            'district' => 'Sukajadi',
            'sub_district' => 'Bandung',
            'postal_code' => '40161'
        ]);
        $pusk2->posyandus()->create(['nama_posyandu' => 'Posyandu Cempaka 3']);
    }
}
