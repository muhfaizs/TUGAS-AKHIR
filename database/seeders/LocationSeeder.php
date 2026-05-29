<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kabupaten;

class LocationSeeder extends Seeder
{
    public function run()
    {
        $kab = Kabupaten::create(['nama_kabupaten' => 'Kabupaten Bandung']);
        $pusk = $kab->puskesmas()->create(['nama_puskesmas' => 'Puskesmas Bojongsoang']);
        $pusk->posyandus()->create(['nama_posyandu' => 'Posyandu Anggrek 1']);
        $pusk->posyandus()->create(['nama_posyandu' => 'Posyandu Melati 2']);

        $kab2 = Kabupaten::create(['nama_kabupaten' => 'Kota Bandung']);
        $pusk2 = $kab2->puskesmas()->create(['nama_puskesmas' => 'Puskesmas Sukajadi']);
        $pusk2->posyandus()->create(['nama_posyandu' => 'Posyandu Cempaka 3']);
    }
}
