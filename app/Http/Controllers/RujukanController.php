<?php

namespace App\Http\Controllers;

use App\Models\IbuHamil;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RujukanController extends Controller
{
    public function index()
    {
        // Hanya Bidan yang bisa melihat halaman ini
        if (! Auth::user()->isBidanOnly()) {
            abort(403, 'Unauthorized action.');
        }

        // Ambil pasien ibu hamil dengan risiko Sangat Tinggi
        $pasienRujukan = IbuHamil::where('status_risiko_kehamilan', 'Sangat Tinggi')->get();

        return view('rujukan.index', compact('pasienRujukan'));
    }

    public function cetakPdf(Request $request, $id)
    {
        // Hanya Bidan yang bisa mencetak
        if (! Auth::user()->isBidanOnly()) {
            abort(403, 'Unauthorized action.');
        }

        $ibuHamil = IbuHamil::findOrFail($id);

        // Pastikan hanya yang berisiko Sangat Tinggi yang bisa dicetak rujukannya
        if ($ibuHamil->status_risiko_kehamilan !== 'Sangat Tinggi') {
            return back()->with('error', 'Hanya pasien dengan risiko Sangat Tinggi yang dapat dirujuk.');
        }

        $rumahSakitTujuan = $request->input('rumah_sakit', 'Rumah Sakit Rujukan / Dokter Spesialis Kandungan');

        // Render view PDF
        $pdf = Pdf::loadView('rujukan.pdf', [
            'ibuHamil' => $ibuHamil,
            'rumahSakitTujuan' => $rumahSakitTujuan,
            'bidan' => Auth::user(),
            'tanggal' => now()->translatedFormat('d F Y'),
        ]);

        return $pdf->download('Surat_Rujukan_'.str_replace(' ', '_', $ibuHamil->nama_lengkap).'.pdf');
    }
}
