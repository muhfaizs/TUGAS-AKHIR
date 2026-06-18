<?php

namespace App\Http\Controllers;

use App\Models\Anak;
use App\Models\IbuHamil;
use App\Models\JadwalPosyandu;
use App\Models\Notifikasi;
use App\Models\Pengukuran;
use App\Models\User;
use Carbon\Carbon;
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
                ->whereIn('status', ['aktif', 'active'])
                ->count();
            $bidanNonaktif = User::where('role', 'bidan')
                ->where('email', '!=', 'admin@satukia.com')
                ->whereIn('status', ['nonaktif', 'inactive'])
                ->count();

            $ibuHamilTerdaftar = User::where('role', 'ortu')->count();

            $dinkesAktif = User::where('role', 'dinkes')
                ->whereIn('status', ['aktif', 'active'])
                ->count();

            $dinkesNonaktif = User::where('role', 'dinkes')
                ->whereIn('status', ['nonaktif', 'inactive'])
                ->count();

            return view('dashboard.admin', compact('totalBidan', 'bidanAktif', 'bidanNonaktif', 'ibuHamilTerdaftar', 'dinkesAktif', 'dinkesNonaktif'));
        }

        if ($user->isBidanOnly()) {
            // Data Ibu Hamil
            $totalPasien = IbuHamil::count();
            $pasienAktif = IbuHamil::where('status_pasien', 'Aktif')->count();
            $pasienRisikoTinggi = IbuHamil::whereIn('status_risiko_kehamilan', ['Tinggi', 'Sangat Tinggi'])->count();
            $ibuHamilMeninggalList = IbuHamil::where('status_ibu_meninggal', 'Meninggal')->get();
            $ibuHamilMeninggal = $ibuHamilMeninggalList->count();

            $pasienPrioritasList = IbuHamil::whereIn('status_risiko_kehamilan', ['Tinggi', 'Sangat Tinggi'])
                ->orderBy('updated_at', 'desc')
                ->take(10)
                ->get();

            // Data Anak
            $totalAnak = Anak::count();
            $anakBerisiko = Anak::whereHas('latestPengukuran', function ($query) {
                $query->where('flag_risiko', 1);
            })->count();

            $anakPrioritasList = Anak::with(['orangTua', 'pengukuran' => function ($query) {
                $query->orderByDesc('tanggal_pengukuran');
            }])
                ->whereHas('latestPengukuran', function ($query) {
                    $query->where('flag_risiko', 1);
                })
                ->get();

            // Data KB
            $kbTotalAkseptorAktif = \App\Models\KbAcceptor::where('status', 'active')->count();
            $kbPelayananHariIni = \App\Models\KBService::whereDate('service_date', now()->toDateString())->count();
            $kbJadwalKontrolHariIni = \App\Models\KBService::whereDate('follow_up_date', now()->toDateString())->count();
            
            $kbTerlambatKontrolList = \App\Models\KbAcceptor::where('status', 'active')
                ->whereHas('kbServices', function($q) {
                    $q->whereDate('follow_up_date', '<', now()->toDateString());
                })
                ->with(['kbServices' => function($q) {
                    $q->orderBy('service_date', 'desc')->limit(1);
                }])
                ->get()
                ->filter(function($acceptor) {
                    $latestService = $acceptor->kbServices->first();
                    return $latestService && $latestService->follow_up_date && $latestService->follow_up_date < now()->toDateString();
                });
            $kbTerlambatKontrol = $kbTerlambatKontrolList->count();

            // Data Grafik Pelayanan KB Bulanan (Contoh 6 bulan terakhir)
            $kbChartData = [];
            for ($i = 5; $i >= 0; $i--) {
                $month = now()->subMonths($i);
                $count = \App\Models\KBService::whereMonth('service_date', $month->month)
                            ->whereYear('service_date', $month->year)->count();
                $kbChartData['labels'][] = $month->translatedFormat('M');
                $kbChartData['data'][] = $count;
            }

            // Distribusi Metode KB
            $kbMethodDistribution = \App\Models\KBService::selectRaw('service_method, count(*) as count')
                                        ->groupBy('service_method')->pluck('count', 'service_method')->toArray();

            return view('dashboard', compact(
                'totalPasien', 'pasienAktif', 'pasienRisikoTinggi', 'ibuHamilMeninggal', 'ibuHamilMeninggalList', 'pasienPrioritasList',
                'totalAnak', 'anakBerisiko', 'anakPrioritasList',
                'kbTotalAkseptorAktif', 'kbPelayananHariIni', 'kbJadwalKontrolHariIni', 'kbTerlambatKontrol', 'kbTerlambatKontrolList',
                'kbChartData', 'kbMethodDistribution'
            ));
        }

        // Dasbor Khusus Kader
        if ($user->isKader()) {
            $totalAnak = Anak::count();

            // Hitung anak berisiko (berdasarkan pengukuran terakhir)
            $anakBerisiko = Anak::whereHas('latestPengukuran', function ($query) {
                $query->where('flag_risiko', 1);
            })->count();

            // Jadwal posyandu terdekat untuk wilayah kerja kader ini
            $jadwalTerdekat = JadwalPosyandu::where('posyandu_id', $user->posyandu_id)
                ->whereDate('tanggal', '>=', now()->toDateString())
                ->orderBy('tanggal', 'asc')
                ->first();

            // Pasien anak dengan prioritas risiko
            $pasienPrioritas = Anak::with(['orangTua', 'pengukuran' => function ($query) {
                $query->orderByDesc('tanggal_pengukuran');
            }])
                ->whereHas('latestPengukuran', function ($query) {
                    $query->where('flag_risiko', 1);
                })
                ->get();
                
            // Data KB
            $totalAkseptor = \App\Models\KbAcceptor::count();

            return view('dashboard.kader.index', compact('totalAnak', 'anakBerisiko', 'jadwalTerdekat', 'pasienPrioritas', 'totalAkseptor'));
        }

        if ($user->isDinkes()) {
            // Data Ibu Hamil
            $totalIbuHamil = IbuHamil::count();
            $ibuHamilBerisiko = IbuHamil::whereIn('status_risiko_kehamilan', ['Tinggi', 'Sangat Tinggi'])->count();
            $risikoRendah = IbuHamil::where('status_risiko_kehamilan', 'Rendah')->count();
            $risikoTinggi = IbuHamil::where('status_risiko_kehamilan', 'Tinggi')->count();
            $risikoSangatTinggi = IbuHamil::where('status_risiko_kehamilan', 'Sangat Tinggi')->count();
            $ibuHamilMeninggalList = IbuHamil::where('status_ibu_meninggal', 'Meninggal')->get();
            $ibuHamilMeninggal = $ibuHamilMeninggalList->count();

            // Data Anak
            $totalAnak = Anak::count();
            $anakBerisiko = Anak::whereHas('latestPengukuran', function ($q) {
                $q->where('flag_risiko', true);
            })->count();
            $anakDiimunisasi = Anak::whereHas('imunisasi')->count();
            $persentaseImunisasi = $totalAnak > 0 ? round(($anakDiimunisasi / $totalAnak) * 100, 1) : 0;

            // Data KB
            $totalAkseptor = \App\Models\KbAcceptor::count();
            $akseptorAktif = \App\Models\KbAcceptor::where('status', 'active')->count();
            $kbPending = \App\Models\KbAcceptor::where('status', 'pending')->count();
            $kbInactive = $totalAkseptor - $akseptorAktif - $kbPending;
            $anakNormal = $totalAnak - $anakBerisiko;

            // Laporan dari Bidan
            $laporanDinkes = \App\Models\TbLaporanDinkes::with('bidan')->latest()->take(5)->get();

            return view('dinkes.dashboard', compact(
                'totalIbuHamil', 'ibuHamilBerisiko', 'risikoRendah', 'risikoTinggi', 'risikoSangatTinggi', 'ibuHamilMeninggal', 'ibuHamilMeninggalList',
                'totalAnak', 'anakBerisiko', 'anakNormal', 'persentaseImunisasi',
                'totalAkseptor', 'akseptorAktif', 'kbPending', 'kbInactive',
                'laporanDinkes'
            ));
        }

        // Ortu dashboard (KMS Digital)
        if ($user->isOrtu()) {
            $anakList = Anak::where('id_user', $user->id)->get();

            $selectedAnak = null;
            $pengukuranList = collect();
            $tindakanList = collect();
            $imunisasiList = collect();
            $pengingatList = [];
            $jadwalTerdekat = null;

            if ($anakList->isNotEmpty()) {
                $anakId = request()->query('anak_id', $anakList->first()->id_anak);
                $selectedAnak = $anakList->where('id_anak', $anakId)->first();

                if (! $selectedAnak) {
                    abort(403, 'Akses Ditolak: Data anak tidak ditemukan atau bukan milik Anda.');
                }

                $pengukuranList = Pengukuran::where('id_anak', $selectedAnak->id_anak)
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
                $tanggalLahir = Carbon::parse($selectedAnak->tanggal_lahir);

                $lowestMissingMonth = null;
                $missingVaksinInMonth = [];

                foreach ($jadwalVaksinByBulan as $bulan => $vaksins) {
                    $hasMissingInThisMonth = false;
                    foreach ($vaksins as $v) {
                        if (! in_array($v, $riwayatImunisasi)) {
                            $hasMissingInThisMonth = true;
                            $notifTitle = "Pengingat Imunisasi: {$v} - {$selectedAnak->nama_anak}";
                            $isDismissed = Notifikasi::where('id_user', $user->id)
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
                        
                        $pengingatList[] = [
                            'vaksin' => $vaksin,
                            'tanggal' => $tanggalJadwal->format('d M Y'),
                            'hari' => (int) $selisihHari,
                            'anak_id' => $selectedAnak->id_anak,
                        ];
                    }
                }

                $jadwalTerdekat = JadwalPosyandu::whereDate('tanggal', '>=', now()->toDateString())
                    ->orderBy('tanggal', 'asc')
                    ->first();
            }

            return view('dashboard.orangtua.index', compact('anakList', 'selectedAnak', 'pengukuranList', 'pengingatList', 'tindakanList', 'imunisasiList', 'jadwalTerdekat'));
        }

        // Pasien KB dashboard
        if ($user->isPasienKb()) {
            $acceptor = \App\Models\KbAcceptor::where('nik', $user->nik)->first();
            
            // if we found acceptor but user_id is null, link it
            if ($acceptor && !$acceptor->user_id) {
                $acceptor->user_id = $user->id;
                $acceptor->save();
            }

            $services = $acceptor ? $acceptor->services()->orderBy('created_at', 'desc')->get() : collect();
            return view('dashboard.pasien_kb.index', compact('acceptor', 'services'));
        }

        // Default fallback (just in case)
        $totalPengguna = User::count();
        $bidanAktif = User::where('role', 'bidan')->count();

        return view('dashboard', compact('totalPengguna', 'bidanAktif'));
    }
}
