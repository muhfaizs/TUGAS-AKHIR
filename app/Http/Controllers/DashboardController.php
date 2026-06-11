<?php

namespace App\Http\Controllers;

use App\Models\Anak;
use App\Models\JadwalPosyandu;
use App\Models\Notifikasi;
use App\Models\Pengukuran;
use App\Models\User;
use Carbon\Carbon;
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

            $jadwalTerdekat = JadwalPosyandu::where('posyandu_id', $request->user()->posyandu_id)
                ->whereDate('tanggal', '>=', now()->toDateString())
                ->orderBy('tanggal', 'asc')
                ->first();

            return view('dashboard.kader.index', compact('totalAnak', 'anakBerisiko', 'jadwalTerdekat'));
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
        $tindakanList = collect();
        $imunisasiList = collect();

        $pengingatList = [];
        $jadwalTerdekat = null;

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

                // Jadwal Vaksin By Month Group
                $jadwalVaksinByBulan = [
                    0 => ['Hepatitis B0'],
                    1 => ['BCG', 'Polio 1'],
                    2 => ['DPT-HB-Hib 1', 'Polio 2'],
                    3 => ['DPT-HB-Hib 2', 'Polio 3'],
                    4 => ['DPT-HB-Hib 3', 'Polio 4'],
                    9 => ['Campak / MR'],
                ];

                $riwayatImunisasi = $selectedAnak->imunisasi->pluck('nama_vaksin')->toArray();
                $tanggalLahir = Carbon::parse($selectedAnak->tanggal_lahir);

                $lowestMissingMonth = null;
                $missingVaksinInMonth = [];

                foreach ($jadwalVaksinByBulan as $bulan => $vaksins) {
                    $missingInThisMonth = [];
                    foreach ($vaksins as $v) {
                        if (! in_array($v, $riwayatImunisasi)) {
                            // Check if this reminder is already dismissed
                            $notifTitle = "Pengingat Imunisasi: {$v} - {$selectedAnak->nama_anak}";
                            $isDismissed = Notifikasi::where('id_user', $user->id_user)
                                ->where('judul', $notifTitle)
                                ->exists();

                            if (! $isDismissed) {
                                $missingInThisMonth[] = $v;
                            }
                        }
                    }

                    if (count($missingInThisMonth) > 0) {
                        $lowestMissingMonth = $bulan;
                        $missingVaksinInMonth = $missingInThisMonth;
                        break; // Stop at the first month with active missing vaccines
                    }
                }

                if ($lowestMissingMonth !== null) {
                    foreach ($missingVaksinInMonth as $vaksin) {
                        $tanggalJadwal = $tanggalLahir->copy()->addMonths($lowestMissingMonth);
                        $selisihHari = now()->diffInDays($tanggalJadwal, false);

                        // Show if it's within next 7 days, or overdue (selisihHari < 0)
                        if ($selisihHari <= 7) {
                            $pengingatList[] = [
                                'vaksin' => $vaksin,
                                'tanggal' => $tanggalJadwal->format('d M Y'),
                                'hari' => (int) $selisihHari,
                                'anak_id' => $selectedAnak->id_anak,
                            ];
                        }
                    }
                }

                $jadwalTerdekat = JadwalPosyandu::where('posyandu_id', $request->user()->posyandu_id)
                    ->whereDate('tanggal', '>=', now()->toDateString())
                    ->orderBy('tanggal', 'asc')
                    ->first();
            }
        }

        return view('dashboard.orangtua.index', compact('anakList', 'selectedAnak', 'pengukuranList', 'pengingatList', 'tindakanList', 'imunisasiList', 'jadwalTerdekat'));
    }

    public function dismissReminder(Request $request)
    {
        $request->validate([
            'anak_id' => 'required|exists:tb_anak,id_anak',
            'vaksin' => 'required|string',
        ]);

        $anak = Anak::findOrFail($request->anak_id);

        if ($anak->id_user !== auth()->user()->id_user) {
            abort(403);
        }

        $notifTitle = "Pengingat Imunisasi: {$request->vaksin} - {$anak->nama_anak}";

        Notifikasi::create([
            'id_user' => auth()->user()->id_user,
            'judul' => $notifTitle,
            'pesan' => "Jadwal Imunisasi {$request->vaksin} untuk anak Anda ({$anak->nama_anak}) sudah dekat. Harap segera membawa anak Anda ke Puskesmas/Posyandu.",
            'wa_link' => null,
        ]);

        return back()->with('success', 'Pengingat telah ditandai selesai dan dipindahkan ke notifikasi.');
    }
}
