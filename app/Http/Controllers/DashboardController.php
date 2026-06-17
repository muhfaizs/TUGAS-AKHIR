<?php

namespace App\Http\Controllers;

use App\Models\KBService;
use App\Models\KBAcceptor;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->role === 'patient') {
            return redirect()->route('patient.dashboard');
        }

        if (in_array(auth()->user()->role, ['super_admin', 'admin'])) {
            $totalPengguna = User::count();
            $bidanAktif = User::whereIn('role', ['bidan', 'Bidan'])->count();
            $pasienTerdaftar = User::whereIn('role', ['patient', 'Pasien'])->count();
            $kaderPosyandu = User::whereIn('role', ['kader', 'Kader'])->count();
            $petugasDinkes = User::whereIn('role', ['dinas_kesehatan', 'Dinas Kesehatan'])->count();
            
            return view('dashboard.admin', compact(
                'totalPengguna', 
                'bidanAktif', 
                'pasienTerdaftar', 
                'kaderPosyandu', 
                'petugasDinkes'
            ));
        }

        $today = Carbon::today();
        
        // ===== 1. Ringkasan Statistik (KPI Cards) =====
        
        // Total Akseptor Aktif
        $totalAkseptorAktif = KBAcceptor::where('status', 'Aktif')->count();
        if ($totalAkseptorAktif == 0 && KBAcceptor::count() > 0) {
            // fallback if status field isn't reliably populated yet
            $totalAkseptorAktif = KBAcceptor::where('is_verified', true)->count();
        }
        
        // Pelayanan Hari Ini
        $pelayananHariIni = KBService::whereDate('service_date', $today)->count();
        
        // Jadwal Kontrol Hari Ini
        $jadwalKontrolHariIni = KBService::whereDate('follow_up_date', $today)->count();
        
        // Terlambat Kontrol
        $akseptorTerlambat = KBService::whereDate('follow_up_date', '<', $today)
            ->where('is_verified', false)
            ->count();

        // ===== 2. Grafik Pelayanan KB Bulanan (Bar Chart) =====
        $monthlyServicesData = [];
        $monthlyServicesLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        
        for ($i = 1; $i <= 12; $i++) {
            $monthlyServicesData[$i] = 0;
        }
        
        $servicesThisYear = KBService::whereYear('service_date', $today->year)
            ->selectRaw('MONTH(service_date) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();
            
        foreach ($servicesThisYear as $month => $count) {
            $monthlyServicesData[$month] = $count;
        }
        
        $monthlyServicesData = array_values($monthlyServicesData);

        // ===== 3. Distribusi Metode Kontrasepsi (Donut Chart) =====
        $methodDistribution = KBService::selectRaw('service_method, COUNT(*) as count')
            ->groupBy('service_method')
            ->orderBy('count', 'desc')
            ->get();
            
        $methodLabels = $methodDistribution->pluck('service_method')->toArray();
        $methodCounts = $methodDistribution->pluck('count')->toArray();

        // ===== 4. Jadwal Kontrol Terdekat =====
        $jadwalKontrolTerdekat = KBService::with('acceptor')
            ->whereNotNull('follow_up_date')
            ->whereDate('follow_up_date', '>=', $today)
            ->where('is_verified', false)
            ->orderBy('follow_up_date', 'asc')
            ->limit(5)
            ->get();

        // ===== 5. Reminder Akseptor Terlambat =====
        $daftarAkseptorTerlambat = KBService::with('acceptor')
            ->whereNotNull('follow_up_date')
            ->whereDate('follow_up_date', '<', $today)
            ->where('is_verified', false)
            ->orderBy('follow_up_date', 'asc')
            ->limit(5)
            ->get();

        // ===== 6. Aktivitas Terbaru =====
        $recentServices = KBService::with('acceptor')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function($service) {
                return [
                    'time' => $service->created_at,
                    'text' => "Pelayanan KB ({$service->service_method}) diinput",
                    'type' => 'service'
                ];
            });
            
        $recentAcceptors = KBAcceptor::orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function($acceptor) {
                return [
                    'time' => $acceptor->created_at,
                    'text' => "Akseptor baru ditambahkan: " . ($acceptor->full_name ?? 'N/A'),
                    'type' => 'acceptor'
                ];
            });
            
        $recentActivities = $recentServices->concat($recentAcceptors)
            ->sortByDesc('time')
            ->take(10)
            ->values();

        // ===== 7. Status Akseptor (Donut Chart) =====
        $statusAkseptorAktif = KBAcceptor::where('status', 'Aktif')->count();
        $statusAkseptorNonaktif = KBAcceptor::where('status', 'Nonaktif')->count();
        $statusAkseptorDropOut = KBAcceptor::where('status', 'Drop Out')->count();

        if ($statusAkseptorAktif == 0 && $statusAkseptorNonaktif == 0 && $statusAkseptorDropOut == 0 && KBAcceptor::count() > 0) {
            $statusAkseptorAktif = KBAcceptor::where('is_verified', true)->count();
            $statusAkseptorNonaktif = KBAcceptor::where('is_verified', false)->count();
            $statusAkseptorDropOut = 0;
        }
        
        $statusLabels = ['Aktif', 'Nonaktif', 'Drop Out'];
        $statusCounts = [$statusAkseptorAktif, $statusAkseptorNonaktif, $statusAkseptorDropOut];

        return view('dashboard.index', compact(
            'totalAkseptorAktif',
            'pelayananHariIni',
            'jadwalKontrolHariIni',
            'akseptorTerlambat',
            'monthlyServicesLabels',
            'monthlyServicesData',
            'methodLabels',
            'methodCounts',
            'jadwalKontrolTerdekat',
            'daftarAkseptorTerlambat',
            'recentActivities',
            'statusLabels',
            'statusCounts'
        ));
    }

    public function getStats()
    {
        return response()->json([
            'totalAkseptorAktif' => KBAcceptor::where('status', 'Aktif')->count(),
            'pelayananHariIni' => KBService::whereDate('service_date', today())->count(),
            'jadwalKontrolHariIni' => KBService::whereDate('follow_up_date', today())->count(),
            'akseptorTerlambat' => KBService::whereDate('follow_up_date', '<', today())->where('is_verified', false)->count(),
        ]);
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

            // Count unique children who are currently at risk (based on latest measurement)
            $anakBerisiko = Anak::whereHas('latestPengukuran', function ($query) {
                $query->where('flag_risiko', 1);
            })->count();

            $jadwalTerdekat = JadwalPosyandu::where('posyandu_id', $request->user()->posyandu_id)
                ->whereDate('tanggal', '>=', now()->toDateString())
                ->orderBy('tanggal', 'asc')
                ->first();

            // Fetch at-risk children with latest pengukuran for the priority table
            $pasienPrioritas = Anak::with(['orangTua', 'pengukuran' => function ($query) {
                $query->orderByDesc('tanggal_pengukuran');
            }])
                ->whereHas('latestPengukuran', function ($query) {
                    $query->where('flag_risiko', 1);
                })
                ->get();

            return view('dashboard.kader.index', compact('totalAnak', 'anakBerisiko', 'jadwalTerdekat', 'pasienPrioritas'));
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
        $anakBerisiko = Anak::whereHas('latestPengukuran', function ($query) {
            $query->where('flag_risiko', 1);
        })->count();

        // Fetch at-risk children with latest pengukuran for the priority table
        $pasienPrioritas = Anak::with(['orangTua', 'pengukuran' => function ($query) {
            $query->orderByDesc('tanggal_pengukuran');
        }])
            ->whereHas('latestPengukuran', function ($query) {
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

            if (!$selectedAnak) {
                abort(403, 'Akses Ditolak: Data anak tidak ditemukan atau bukan milik Anda.');
            }

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
                    $hasMissingInThisMonth = false;
                    
                    foreach ($vaksins as $v) {
                        if (! in_array($v, $riwayatImunisasi)) {
                            $hasMissingInThisMonth = true;
                            
                            // Check if this reminder is already dismissed
                            $notifTitle = "Pengingat Imunisasi: {$v} - {$selectedAnak->nama_anak}";
                            $isDismissed = Notifikasi::where('id_user', $user->id_user)
                                ->where('judul', $notifTitle)
                                ->exists();

                            if (! $isDismissed) {
                                $missingVaksinInMonth[] = $v;
                            }
                        }
                    }

                    if ($hasMissingInThisMonth) {
                        $lowestMissingMonth = $bulan;
                        break; // Stop at the first month with active missing vaccines, even if dismissed
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
