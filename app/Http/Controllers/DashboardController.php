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

            return view('dashboard', compact('totalBidan', 'bidanAktif', 'bidanNonaktif', 'ibuHamilTerdaftar', 'dinkesAktif', 'dinkesNonaktif'));
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

        // Ortu dashboard
        if ($user->isOrtu()) {
            $ibuHamil = IbuHamil::with(['pemeriksaanAncs' => function ($query) {
                $query->orderBy('tanggal_pemeriksaan', 'asc');
            }])->where('nik', $user->nik)->first();

            $labels = '[]';
            $dataTfu = '[]';
            $dataDjj = '[]';
            $dataBb = '[]';

            if ($ibuHamil && $ibuHamil->pemeriksaanAncs->count() > 0) {
                $ancData = $ibuHamil->pemeriksaanAncs;
                $labels = $ancData->map(function ($item) {
                    return $item->tanggal_pemeriksaan->format('d M y');
                })->toJson();

                $dataTfu = $ancData->map(function ($item) {
                    return $item->tinggi_fundus_uteri ?: 0;
                })->toJson();

                $dataDjj = $ancData->map(function ($item) {
                    return $item->denyut_jantung_janin ?: 0;
                })->toJson();

                $dataBb = $ancData->map(function ($item) {
                    return $item->berat_badan ?: 0;
                })->toJson();
            }

            return view('dashboard', compact('ibuHamil', 'labels', 'dataTfu', 'dataDjj', 'dataBb'));
        }

        // Default fallback (just in case)
        $totalPengguna = User::count();
        $bidanAktif = User::where('role', 'bidan')->count();

        return view('dashboard', compact('totalPengguna', 'bidanAktif'));
    }
}
