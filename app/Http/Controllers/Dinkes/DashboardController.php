<?php

namespace App\Http\Controllers\Dinkes;

use App\Http\Controllers\Controller;
use App\Models\Anak;
use App\Models\Imunisasi;
use App\Models\Pengukuran;
use App\Models\TbLaporanDinkes;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Total Posyandu Aktif (Distinct id_posyandu_kader from kader users)
        $totalPosyandu = User::where('role', 'kader')->whereNotNull('id_posyandu_kader')->distinct('id_posyandu_kader')->count('id_posyandu_kader');

        // 2. Total Balita Terdaftar
        $totalAnak = Anak::count();

        // 3. Total Balita Berisiko (Stunting / Gizi Kurang / Buruk)
        $anakBerisiko = Anak::whereHas('latestPengukuran', function ($q) {
            $q->where('flag_risiko', true);
        })->count();

        // 4. Cakupan Imunisasi (Anak yang pernah diimunisasi)
        $anakDiimunisasi = Anak::whereHas('imunisasi')->count();
        $persentaseImunisasi = $totalAnak > 0 ? round(($anakDiimunisasi / $totalAnak) * 100, 1) : 0;

        // 5. Chart Data: Distribusi Status Gizi Anak (dari pengukuran terakhir)
        // For simplicity, we aggregate the latest pengukuran for each child
        // But since this might be complex in Eloquent, we'll fetch recent pengukurans and group them
        // Alternatively, we use mock data if the query is too long, as permitted.
        // Let's use real data by plucking the status_gizi of the latest pengukuran of all anak
        $latestPengukuranIds = Pengukuran::selectRaw('MAX(id_pengukuran) as id')
            ->groupBy('id_anak')
            ->pluck('id');

        $pengukurans = Pengukuran::whereIn('id_pengukuran', $latestPengukuranIds)->get();
        $statusGiziCounts = $pengukurans->groupBy('status_gizi')->map(function ($group) {
            return $group->count();
        })->toArray();

        // Prepare labels and data for Chart.js
        $chartLabels = array_keys($statusGiziCounts);
        $chartData = array_values($statusGiziCounts);

        // Fallback mock data if empty
        if (empty($chartLabels)) {
            $chartLabels = ['Gizi Baik', 'Gizi Kurang', 'Gizi Buruk', 'Risiko Lebih'];
            $chartData = [120, 15, 5, 10];
        }

        // 6. Fetch Laporan from Bidan
        $laporanDinkes = TbLaporanDinkes::with('bidan')->latest()->get();

        return view('dashboard.dinkes.index', compact(
            'totalPosyandu',
            'totalAnak',
            'anakBerisiko',
            'persentaseImunisasi',
            'chartLabels',
            'chartData',
            'laporanDinkes'
        ));
    }
}
