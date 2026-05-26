<?php

namespace App\Http\Controllers;

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
            $totalAnak = \App\Models\Anak::count();
            
            // Count unique children who had a risky measurement this month
            $anakBerisiko = \App\Models\Anak::whereHas('pengukuran', function ($query) {
                $query->where('flag_risiko', 1)
                      ->whereMonth('tanggal_pengukuran', now()->month)
                      ->whereYear('tanggal_pengukuran', now()->year);
            })->count();

            return view('dashboard.kader.index', compact('totalAnak', 'anakBerisiko'));
        }

        return view('dashboard.admin');
    }

    /**
     * Show the orang tua dashboard.
     */
    public function orangTuaDashboard(Request $request): View
    {
        $user = $request->user();
        
        // Fetch all children for the current parent
        $anakList = \App\Models\Anak::where('id_user', $user->id_user)->get();
        
        $selectedAnak = null;
        $pengukuranList = collect();

        if ($anakList->isNotEmpty()) {
            // For simplicity, default to the first child or handle query param `?anak_id=`
            $anakId = $request->query('anak_id', $anakList->first()->id_anak);
            $selectedAnak = $anakList->where('id_anak', $anakId)->first();
            
            if ($selectedAnak) {
                $pengukuranList = \App\Models\Pengukuran::where('id_anak', $selectedAnak->id_anak)
                    ->orderBy('tanggal_pengukuran', 'asc')
                    ->get();
            }
        }

        return view('dashboard.orangtua.index', compact('anakList', 'selectedAnak', 'pengukuranList'));
    }
}
