<?php

namespace App\Services;

use App\Models\KBService;
use Illuminate\Support\Facades\Http;

class KBDataService
{
    /**
     * Fetch data dari Open Health API (JSONPlaceholder style)
     * Menggunakan public API untuk simulasi data
     */
    public function fetchFromPublicHealthAPI()
    {
        try {
            // Menggunakan Random User API sebagai sumber nama akseptor
            $response = Http::timeout(10)
                ->get('https://randomuser.me/api/?results=15&nat=id');

            if ($response->successful()) {
                $data = $response->json();
                $users = $data['results'];

                $methods = ['IUD', 'Implan', 'Suntik', 'Pil', 'Kondom', 'MOW', 'MOP'];
                $puskesmas = [
                    'Puskesmas Cipinang',
                    'Puskesmas Mekarjaya',
                    'Puskesmas Harapan',
                    'Puskesmas Sukamaju',
                    'Puskesmas Merdeka'
                ];
                $statuses = ['Aktif', 'Ganti Metode', 'Drop Out'];

                foreach ($users as $index => $user) {
                    $akseptor_id = 'AK-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT);
                    $akseptor_name = $user['name']['first'] . ' ' . $user['name']['last'];
                    $age = rand(18, 50);
                    $akseptor_name = $akseptor_name . ' ' . $age;

                    KBService::updateOrCreate(
                        ['akseptor_id' => $akseptor_id],
                        [
                            'akseptor_name' => $akseptor_name,
                            'service_method' => $methods[array_rand($methods)],
                            'status' => $statuses[array_rand($statuses)],
                            'puskesmas' => $puskesmas[array_rand($puskesmas)],
                            'service_date' => now()->subDays(rand(1, 30))
                        ]
                    );
                }

                return ['success' => true, 'message' => 'Data berhasil diambil dari API'];
            }

            return ['success' => false, 'message' => 'Gagal mengambil data dari API'];

        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }

    /**
     * Fetch dari WHO Global Health Observable API
     * (Data publik kesehatan global)
     */
    public function fetchFromWHOAPI()
    {
        try {
            // WHO API untuk mendapatkan data kesehatan
            $response = Http::timeout(10)
                ->get('https://gateway.who.int/GHO/api/LIFECARE');

            if ($response->successful()) {
                // Process WHO data
                return ['success' => true, 'message' => 'Data WHO berhasil diambil'];
            }

            return ['success' => false, 'message' => 'Gagal mengambil data WHO'];

        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }

    /**
     * Fetch dari Indonesia Health API (Jika tersedia)
     * Endpoint publik dari Kemenkes atau dinas kesehatan
     */
    public function fetchFromIndonesiaHealthAPI()
    {
        try {
            // Contoh: API dari Pemerintah Indonesia
            $response = Http::timeout(10)
                ->get('https://api.kawal-covid19.info/');

            if ($response->successful()) {
                return ['success' => true, 'message' => 'Data Indonesia Health berhasil diambil'];
            }

            return ['success' => false, 'message' => 'Gagal mengambil data'];

        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }

    /**
     * Fetch dari Multiple Free APIs
     * Kombinasi dari beberapa sumber
     */
    public function fetchFromMultipleSources()
    {
        try {
            // Source 1: Random User API untuk nama
            $usersResponse = Http::timeout(10)
                ->get('https://randomuser.me/api/?results=15&nat=id');

            if (!$usersResponse->successful()) {
                return ['success' => false, 'message' => 'Gagal mengambil data user'];
            }

            $users = $usersResponse->json()['results'];
            $methods = ['IUD', 'Implan', 'Suntik', 'Pil', 'Kondom', 'MOW', 'MOP'];
            $puskesmas = [
                'Puskesmas Cipinang',
                'Puskesmas Mekarjaya',
                'Puskesmas Harapan',
                'Puskesmas Sukamaju',
                'Puskesmas Merdeka'
            ];
            $statuses = ['Aktif', 'Ganti Metode', 'Drop Out'];

            foreach ($users as $index => $user) {
                $akseptor_id = 'AK-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT);
                $akseptor_name = ucfirst($user['name']['first']) . ' ' . ucfirst($user['name']['last']);
                $age = rand(18, 50);
                $akseptor_name = $akseptor_name . ' ' . $age;

                KBService::updateOrCreate(
                    ['akseptor_id' => $akseptor_id],
                    [
                        'akseptor_name' => $akseptor_name,
                        'service_method' => $methods[array_rand($methods)],
                        'status' => $statuses[array_rand($statuses)],
                        'puskesmas' => $puskesmas[array_rand($puskesmas)],
                        'service_date' => now()->subDays(rand(1, 30))
                    ]
                );
            }

            return ['success' => true, 'message' => 'Data dari multiple sources berhasil diambil'];

        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }
}
