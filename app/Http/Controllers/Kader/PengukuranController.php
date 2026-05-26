<?php

namespace App\Http\Controllers\Kader;

use App\Http\Controllers\Controller;
use App\Models\Anak;
use App\Models\Pengukuran;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PengukuranController extends Controller
{
    /**
     * Show the form for creating a new measurement.
     */
    public function create(): View
    {
        // For the form, we need a list of anak to select from.
        $anakList = Anak::orderBy('nama_anak')->get();
        return view('dashboard.kader.pengukuran.create', compact('anakList'));
    }

    /**
     * Store a newly created measurement in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_anak' => ['required', 'exists:tb_anak,id_anak'],
            'tanggal_pengukuran' => ['required', 'date'],
            'berat_badan' => ['required', 'numeric', 'min:0.1', 'max:100'],
            'tinggi_badan' => ['required', 'numeric', 'min:10', 'max:200'], // in cm for input
            'lingkar_kepala' => ['nullable', 'numeric', 'min:10', 'max:100'],
        ]);

        // Calculate IMT
        // Formula: Berat (kg) / (Tinggi (m) * Tinggi (m))
        $tinggiInMeters = $validated['tinggi_badan'] / 100;
        $imt = $validated['berat_badan'] / ($tinggiInMeters * $tinggiInMeters);

        // IMT Flagging logic (simplified for general toddlers/children)
        // Normally WHO charts are used. We use a simple threshold for the sake of the requirement:
        // E.g., < 14 (gizi kurang) or > 18 (risiko obesitas) for toddlers.
        // Let's use < 13.5 or > 19 as flag_risiko = true.
        $flagRisiko = ($imt < 13.5 || $imt > 19) ? true : false;

        Pengukuran::create([
            'id_anak' => $validated['id_anak'],
            'id_kader' => $request->user()->id_user,
            'tanggal_pengukuran' => $validated['tanggal_pengukuran'],
            'berat_badan' => $validated['berat_badan'],
            'tinggi_badan' => $validated['tinggi_badan'],
            'lingkar_kepala' => $validated['lingkar_kepala'] ?? null,
            'imt' => round($imt, 2),
            'flag_risiko' => $flagRisiko,
        ]);

        return redirect()->route('kader.pengukuran.create')
            ->with('success', 'Data pengukuran berhasil disimpan. IMT: ' . round($imt, 2) . ($flagRisiko ? ' (Perlu Perhatian)' : ' (Normal)'));
    }
}
