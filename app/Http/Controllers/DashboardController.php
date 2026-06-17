<?php

namespace App\Http\Controllers;

use App\Models\IbuHamil;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isSuperAdmin()) {
            $totalBidan = User::where('role', 'bidan')
                ->where('email', '!=', 'admin@satukia.com')
                ->count();
            $bidanAktif = User::where('role', 'bidan')
                ->where('email', '!=', 'admin@satukia.com')
                ->where('status', 'aktif')
                ->count();
            $bidanNonaktif = User::where('role', 'bidan')
                ->where('email', '!=', 'admin@satukia.com')
                ->where('status', 'nonaktif')
                ->count();

            $ibuHamilTerdaftar = User::where('role', 'ortu')->count();

            $dinkesAktif = User::where('role', 'dinkes')
                ->where('status', 'aktif')
                ->count();

            $dinkesNonaktif = User::where('role', 'dinkes')
                ->where('status', 'nonaktif')
                ->count();

            return view('dashboard.admin', compact('totalBidan', 'bidanAktif', 'bidanNonaktif', 'ibuHamilTerdaftar', 'dinkesAktif', 'dinkesNonaktif'));
        }

        if ($user->isBidanOnly()) {
            $totalPasien = IbuHamil::count();
            $pasienAktif = IbuHamil::where('status_pasien', 'Aktif')->count();
            $pasienRisikoTinggi = IbuHamil::whereIn('status_risiko_kehamilan', ['Tinggi', 'Sangat Tinggi'])->count();
            $ibuHamilMeninggalList = IbuHamil::where('status_ibu_meninggal', 'Meninggal')->get();
            $ibuHamilMeninggal = $ibuHamilMeninggalList->count();

            $pasienPrioritasList = IbuHamil::whereIn('status_risiko_kehamilan', ['Tinggi', 'Sangat Tinggi'])
                ->orderBy('updated_at', 'desc')
                ->take(10)
                ->get();

            return view('dashboard', compact('totalPasien', 'pasienAktif', 'pasienRisikoTinggi', 'ibuHamilMeninggal', 'ibuHamilMeninggalList', 'pasienPrioritasList'));
        }

        // Dasbor Khusus Kader
        if ($user->isKader()) {
            $totalAnak = \App\Models\Anak::count();

            // Hitung anak berisiko (berdasarkan pengukuran terakhir)
            $anakBerisiko = \App\Models\Anak::whereHas('latestPengukuran', function ($query) {
                $query->where('flag_risiko', 1);
            })->count();

            // Jadwal posyandu terdekat untuk wilayah kerja kader ini
            $jadwalTerdekat = \App\Models\JadwalPosyandu::where('posyandu_id', $user->posyandu_id)
                ->whereDate('tanggal', '>=', now()->toDateString())
                ->orderBy('tanggal', 'asc')
                ->first();

            // Pasien anak dengan prioritas risiko
            $pasienPrioritas = \App\Models\Anak::with(['orangTua', 'pengukuran' => function ($query) {
                $query->orderByDesc('tanggal_pengukuran');
            }])
                ->whereHas('latestPengukuran', function ($query) {
                    $query->where('flag_risiko', 1);
                })
                ->get();

            return view('dashboard.kader.index', compact('totalAnak', 'anakBerisiko', 'jadwalTerdekat', 'pasienPrioritas'));
        }

        if ($user->isDinkes()) {
            $totalIbuHamil = IbuHamil::count();
            $ibuHamilBerisiko = IbuHamil::whereIn('status_risiko_kehamilan', ['Tinggi', 'Sangat Tinggi'])->count();

            $risikoRendah = IbuHamil::where('status_risiko_kehamilan', 'Rendah')->count();
            $risikoTinggi = IbuHamil::where('status_risiko_kehamilan', 'Tinggi')->count();
            $risikoSangatTinggi = IbuHamil::where('status_risiko_kehamilan', 'Sangat Tinggi')->count();

            $ibuHamilMeninggalList = IbuHamil::where('status_ibu_meninggal', 'Meninggal')->get();
            $ibuHamilMeninggal = $ibuHamilMeninggalList->count();

            return view('dinkes.dashboard', compact('totalIbuHamil', 'ibuHamilBerisiko', 'risikoRendah', 'risikoTinggi', 'risikoSangatTinggi', 'ibuHamilMeninggal', 'ibuHamilMeninggalList'));
        }

        // Ortu dashboard (KMS Digital)
        if ($user->isOrtu()) {
            $anakList = \App\Models\Anak::where('id_user', $user->id)->get();

            $selectedAnak = null;
            $pengukuranList = collect();
            $tindakanList = collect();
            $imunisasiList = collect();
            $pengingatList = [];
            $jadwalTerdekat = null;

            if ($anakList->isNotEmpty()) {
                $anakId = request()->query('anak_id', $anakList->first()->id_anak);
                $selectedAnak = $anakList->where('id_anak', $anakId)->first();

                if (!$selectedAnak) {
                    abort(403, 'Akses Ditolak: Data anak tidak ditemukan atau bukan milik Anda.');
                }

                $pengukuranList = \App\Models\Pengukuran::where('id_anak', $selectedAnak->id_anak)
                    ->orderBy('tanggal_pengukuran', 'asc')
                    ->get();
                $tindakanList = $selectedAnak->tindakanMedis()->orderBy('tanggal_pemeriksaan', 'desc')->get();
                $imunisasiList = $selectedAnak->imunisasi()->orderBy('tanggal_pemberian', 'desc')->get();

                $jadwalVaksinByBulan = [
                    0 => ['Hepatitis B0'],
                    1 => ['BCG', 'Polio 1'],
                    2 => ['DPT-HB-Hib 1', 'Polio 2'],
                    3 => ['DPT-HB-Hib 2', 'Polio 3'],
                    4 => ['DPT-HB-Hib 3', 'Polio 4'],
                    9 => ['Campak / MR'],
                ];

                $riwayatImunisasi = $selectedAnak->imunisasi->pluck('nama_vaksin')->toArray();
                $tanggalLahir = \Carbon\Carbon::parse($selectedAnak->tanggal_lahir);

                $lowestMissingMonth = null;
                $missingVaksinInMonth = [];

                foreach ($jadwalVaksinByBulan as $bulan => $vaksins) {
                    $hasMissingInThisMonth = false;
                    foreach ($vaksins as $v) {
                        if (! in_array($v, $riwayatImunisasi)) {
                            $hasMissingInThisMonth = true;
                            $notifTitle = "Pengingat Imunisasi: {$v} - {$selectedAnak->nama_anak}";
                            $isDismissed = \App\Models\Notifikasi::where('id_user', $user->id)
                                ->where('judul', $notifTitle)
                                ->exists();

                            if (! $isDismissed) {
                                $missingVaksinInMonth[] = $v;
                            }
                        }
                    }

                    if ($hasMissingInThisMonth) {
                        $lowestMissingMonth = $bulan;
                        break;
                    }
                }

                if ($lowestMissingMonth !== null) {
                    foreach ($missingVaksinInMonth as $vaksin) {
                        $tanggalJadwal = $tanggalLahir->copy()->addMonths($lowestMissingMonth);
                        $selisihHari = now()->diffInDays($tanggalJadwal, false);

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

                $jadwalTerdekat = \App\Models\JadwalPosyandu::whereDate('tanggal', '>=', now()->toDateString())
                    ->orderBy('tanggal', 'asc')
                    ->first();
            }

            return view('dashboard.orangtua.index', compact('anakList', 'selectedAnak', 'pengukuranList', 'pengingatList', 'tindakanList', 'imunisasiList', 'jadwalTerdekat'));
        }

        // Default fallback (just in case)
        $totalPengguna = User::count();
        $bidanAktif = User::where('role', 'bidan')->count();

        return view('dashboard', compact('totalPengguna', 'bidanAktif'));
    }
}
