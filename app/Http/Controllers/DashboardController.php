<?php

namespace App\Http\Controllers;

use App\Models\Anak;
use App\Models\Pengukuran;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function adminDashboard(Request $request): View
    {
        $role = $request->user()->role;

        if ($role === 'kader') {
            $totalAnak = Anak::count();

            // Count unique children who had a risky measurement this month
            $anakBerisiko = Anak::whereHas('pengukuran', function ($query) {
                $query->where('flag_risiko', 1)
                    ->whereMonth('tanggal_pengukuran', now()->month)
                    ->whereYear('tanggal_pengukuran', now()->year);
            })->count();

            return view('dashboard.kader.index', compact('totalAnak', 'anakBerisiko'));
        }

        return view('dashboard.admin');
    }

    /**
     * Show the Bidan dashboard with stats and at-risk patients.
     */
    public function bidanDashboard(Request $request): View
    {
        $totalAnak = Anak::count();
        $totalPengukuran = Pengukuran::count();

        // Children flagged at-risk from their most recent measurement
        $anakBerisiko = Anak::whereHas('pengukuran', function ($query) {
            $query->where('flag_risiko', 1);
        })->count();

        // Fetch at-risk children with latest pengukuran for the priority table
        $pasienPrioritas = Anak::with(['orangTua', 'pengukuran' => function ($query) {
            $query->where('flag_risiko', 1)->orderByDesc('tanggal_pengukuran');
        }])
            ->whereHas('pengukuran', function ($query) {
                $query->where('flag_risiko', 1);
            })
            ->get();

        // Count Bidan users for the stat card
        $totalBidan = User::where('role', 'bidan')->count();

        return view('dashboard.bidan.index', compact(
            'totalAnak',
            'totalPengukuran',
            'anakBerisiko',
            'pasienPrioritas',
            'totalBidan',
        ));
    }

    /**
     * Show the orang tua dashboard.
     */
    public function orangTuaDashboard(Request $request): View
    {
        $user = $request->user();

        // Fetch all children for the current parent
        $anakList = Anak::where('id_user', $user->id_user)->get();

        $selectedAnak = null;
        $pengukuranList = collect();

        $pengingatList = [];

        if ($anakList->isNotEmpty()) {
            // For simplicity, default to the first child or handle query param `?anak_id=`
            $anakId = $request->query('anak_id', $anakList->first()->id_anak);
            $selectedAnak = $anakList->where('id_anak', $anakId)->first();

            if ($selectedAnak) {
                $pengukuranList = Pengukuran::where('id_anak', $selectedAnak->id_anak)
                    ->orderBy('tanggal_pengukuran', 'asc')
                    ->get();
                $tindakanList = $selectedAnak->tindakanMedis()->orderBy('tanggal_pemeriksaan', 'desc')->get();
                $imunisasiList = $selectedAnak->imunisasi()->orderBy('tanggal_pemberian', 'desc')->get();
                    
                // Pengingat Terjadwal Imunisasi
                $jadwalVaksin = [
                    'Hepatitis B0' => 0,
                    'BCG' => 1,
                    'Polio 1' => 1,
                    'DPT-HB-Hib 1' => 2,
                    'Polio 2' => 2,
                    'DPT-HB-Hib 2' => 3,
                    'Polio 3' => 3,
                    'DPT-HB-Hib 3' => 4,
                    'Polio 4' => 4,
                    'Campak / MR' => 9,
                ];
                $riwayatImunisasi = $selectedAnak->imunisasi->pluck('nama_vaksin')->toArray();
                $tanggalLahir = \Carbon\Carbon::parse($selectedAnak->tanggal_lahir);
                
                foreach ($jadwalVaksin as $vaksin => $bulan) {
                    if (!in_array($vaksin, $riwayatImunisasi)) {
                        $tanggalJadwal = $tanggalLahir->copy()->addMonths($bulan);
                        $selisihHari = now()->diffInDays($tanggalJadwal, false);
                        
                        // Show if it's within next 7 days, or missed by up to 30 days
                        if ($selisihHari <= 7 && $selisihHari >= -30) {
                            $pengingatList[] = [
                                'vaksin' => $vaksin,
                                'tanggal' => $tanggalJadwal->format('d M Y'),
                                'hari' => (int) $selisihHari
                            ];
                        }
                    }
                }
            }
        }

        return view('dashboard.orangtua.index', compact('anakList', 'selectedAnak', 'pengukuranList', 'pengingatList', 'tindakanList', 'imunisasiList'));
    }
}
