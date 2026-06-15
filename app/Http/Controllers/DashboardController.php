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
    }
}
