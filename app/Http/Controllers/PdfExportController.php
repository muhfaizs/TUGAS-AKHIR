<?php

namespace App\Http\Controllers;

use App\Models\Anak;
use App\Models\Imunisasi;
use App\Models\TindakanMedis;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfExportController extends Controller
{
    /**
     * Download Rekam Medis (Semua Tindakan & Imunisasi) untuk Anak.
     */
    public function downloadRekamMedisAnak($id_anak)
    {
        $anak = Anak::with(['orangTua', 'tindakanMedis.bidan', 'tindakanMedis.puskesmas', 'tindakanMedis.posyandu', 'imunisasi.bidan', 'imunisasi.puskesmas', 'imunisasi.posyandu'])
            ->findOrFail($id_anak);

        // Security check
        if (auth()->user()->isOrtu() && auth()->id() !== $anak->id_user) {
            abort(403, 'Unauthorized access.');
        }

        $pdf = Pdf::loadView('pdf.rekam_medis_anak', compact('anak'));

        return $pdf->download('Rekam_Medis_'.str_replace(' ', '_', $anak->nama_anak).'.pdf');
    }

    /**
     * Download specific Tindakan Medis.
     */
    public function downloadTindakanMedis(TindakanMedis $tindakan)
    {
        $tindakan->load(['anak.orangTua', 'bidan', 'puskesmas', 'posyandu']);

        if (auth()->user()->isOrtu() && auth()->id() !== $tindakan->anak->id_user) {
            abort(403, 'Unauthorized access.');
        }

        $pdf = Pdf::loadView('pdf.tindakan_medis', compact('tindakan'));

        return $pdf->download('Tindakan_Medis_'.str_replace(' ', '_', $tindakan->anak->nama_anak).'_'.$tindakan->tanggal_pemeriksaan->format('Ymd').'.pdf');
    }

    /**
     * Download specific Imunisasi.
     */
    public function downloadImunisasi(Imunisasi $imunisasi)
    {
        $imunisasi->load(['anak.orangTua', 'bidan', 'puskesmas', 'posyandu']);

        if (auth()->user()->isOrtu() && auth()->id() !== $imunisasi->anak->id_user) {
            abort(403, 'Unauthorized access.');
        }

        $pdf = Pdf::loadView('pdf.imunisasi', compact('imunisasi'));

        return $pdf->download('Imunisasi_'.str_replace(' ', '_', $imunisasi->anak->nama_anak).'_'.$imunisasi->tanggal_pemberian->format('Ymd').'.pdf');
    }
}
