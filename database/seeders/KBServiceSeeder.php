<?php

namespace Database\Seeders;

use App\Models\KBService;
use Illuminate\Database\Seeder;

class KBServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            ['AK-0010', 'Wulan Sari 29', 'Implan', 'Puskesmas Cipinang', '2026-05-17', 'Aktif'],
            ['AK-0018', 'Wulan Sari 17', 'Pil', 'Puskesmas Cipinang', '2026-05-14', 'Aktif'],
            ['AK-0027', 'Rina Marlina 26', 'MOW', 'Puskesmas Mekarjaya', '2026-05-14', 'Aktif'],
            ['AK-0036', 'Fitri Wahyuni 35', 'IUD', 'Puskesmas Harapan', '2026-05-11', 'Ganti Metode'],
            ['AK-0029', 'Ani Suryani 28', 'IUD', 'Puskesmas Sukamaju', '2026-05-05', 'Ganti Metode'],
            ['AK-0008', 'Lia Permata', 'IUD', 'Puskesmas Harapan', '2026-05-02', 'Ganti Metode'],
            ['AK-0042', 'Siti Nurhaliza 31', 'Suntik', 'Puskesmas Cipinang', '2026-04-28', 'Aktif'],
            ['AK-0051', 'Dewi Lestari 24', 'Kondom', 'Puskesmas Mekarjaya', '2026-04-25', 'Drop Out'],
            ['AK-0068', 'Ratna Wijaya 33', 'MOP', 'Puskesmas Harapan', '2026-04-20', 'Aktif'],
            ['AK-0075', 'Susi Handayani 27', 'Implan', 'Puskesmas Sukamaju', '2026-04-18', 'Aktif'],
            ['AK-0083', 'Budi Astuti 30', 'Pil', 'Puskesmas Cipinang', '2026-04-15', 'Drop Out'],
            ['AK-0091', 'Hendra Kusuma 26', 'Suntik', 'Puskesmas Harapan', '2026-04-12', 'Aktif'],
            ['AK-0105', 'Joko Widodo 35', 'MOW', 'Puskesmas Mekarjaya', '2026-04-10', 'Aktif'],
            ['AK-0112', 'Mira Santoso 28', 'IUD', 'Puskesmas Sukamaju', '2026-04-08', 'Ganti Metode'],
            ['AK-0128', 'Nita Wardhani 32', 'Kondom', 'Puskesmas Cipinang', '2026-04-05', 'Aktif'],
        ];

        foreach ($services as $service) {
            KBService::create([
                'akseptor_id' => $service[0],
                'akseptor_name' => $service[1],
                'service_method' => $service[2],
                'puskesmas' => $service[3],
                'service_date' => $service[4],
                'status' => $service[5],
            ]);
        }
    }
}
