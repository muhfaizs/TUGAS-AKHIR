<?php

namespace App\Http\Controllers;

use App\Models\Anak;
use App\Models\IbuHamil;
use App\Models\Imunisasi;
use App\Models\KbAcceptor;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class DinkesController extends Controller
{
    private function calculateMetrics($ibuHamils)
    {
        $metrics = [
            'k1' => 0,
            'triple_eliminasi' => 0,
            'kek' => 0,
            'anemia' => 0,
            'faktor_risiko' => 0,
            'komplikasi' => 0,
            'rujukan' => 0,
            'ttd_90' => 0,
            'kematian' => 0,
        ];

        foreach ($ibuHamils as $pasien) {
            if ($pasien->status_ibu_meninggal == 'Meninggal') {
                $metrics['kematian']++;
            }

            // Rujukan & Komplikasi (Proxy: Risiko Sangat Tinggi)
            if ($pasien->status_risiko_kehamilan == 'Sangat Tinggi') {
                $metrics['rujukan']++;
                $metrics['komplikasi']++;
            }

            $hasFaktorRisiko = false;
            if ($pasien->umur < 20 || $pasien->umur > 35) {
                $hasFaktorRisiko = true;
            }

            $hasK1 = false;
            $hasTripleEliminasi = false;
            $hasKek = false;
            $hasAnemia = false;
            $hasTtd90 = false;

            foreach ($pasien->pemeriksaanAncs as $anc) {
                if ($anc->usia_kehamilan_minggu <= 12) {
                    $hasK1 = true;
                }
                if ($anc->lab_hiv || $anc->lab_sifilis || $anc->lab_hepatitis_b) {
                    $hasTripleEliminasi = true;
                }
                if ($anc->lingkar_lengan_atas && $anc->lingkar_lengan_atas < 23.5) {
                    $hasKek = true;
                }
                if ($anc->lab_hb && $anc->lab_hb < 11) {
                    $hasAnemia = true;
                }
                if ($anc->tinggi_badan && $anc->tinggi_badan < 145) {
                    $hasFaktorRisiko = true;
                }
                if ($anc->jumlah_tablet_darah >= 90) {
                    $hasTtd90 = true;
                }
            }

            if ($hasK1) {
                $metrics['k1']++;
            }
            if ($hasTripleEliminasi) {
                $metrics['triple_eliminasi']++;
            }
            if ($hasKek) {
                $metrics['kek']++;
            }
            if ($hasAnemia) {
                $metrics['anemia']++;
            }
            if ($hasFaktorRisiko) {
                $metrics['faktor_risiko']++;
            }
            if ($hasTtd90) {
                $metrics['ttd_90']++;
            }
        }

        return $metrics;
    }

    /**
     * Show Laporan Rekapitulasi for Dinkes
     */
    public function laporan(Request $request)
    {
        $query = IbuHamil::with(['bidan', 'pemeriksaanAncs'])->orderBy('created_at', 'desc');

        if ($request->has('risiko') && $request->risiko == 'tinggi') {
            $query->whereIn('status_risiko_kehamilan', ['Tinggi', 'Sangat Tinggi']);
        }

        $ibuHamils = $query->get();
        $metrics = $this->calculateMetrics($ibuHamils);

        // Metrics Anak
        $anaks = Anak::with(['pengukuran.kader.posyandu', 'orangTua.posyandu', 'orangTua.puskesmas', 'tindakanMedis.bidan.puskesmas', 'tindakanMedis.posyandu', 'tindakanMedis.puskesmas', 'imunisasi.bidan.puskesmas', 'imunisasi.posyandu', 'imunisasi.puskesmas'])->get();
        $totalAnak = $anaks->count();
        $anakBerisiko = $anaks->filter(function ($a) {
            $latest = $a->latestPengukuran;

            return $latest && $latest->flag_risiko;
        })->count();
        $totalImunisasi = Imunisasi::count();

        // Metrics KB
        $kbAkseptors = KbAcceptor::get();
        $totalKb = $kbAkseptors->count();
        $kbAktif = $kbAkseptors->where('status', 'active')->count();
        $kbRisikoTinggi = $kbAkseptors->filter(function ($kb) {
            $lastService = $kb->lastService();

            return $lastService && $lastService->risk_level === 'Tinggi';
        })->count();

        // Unified Laporan Anak
        $laporanController = new LaporanController;
        $laporanAnak = $laporanController->getUnifiedLaporan($request)->sortByDesc('tanggal')->values();

        return view('dinkes.laporan', compact('ibuHamils', 'metrics', 'totalAnak', 'anakBerisiko', 'totalImunisasi', 'totalKb', 'kbAktif', 'kbRisikoTinggi', 'anaks', 'kbAkseptors', 'laporanAnak'));
    }

    /**
     * Export Laporan Rekapitulasi to PDF
     */
    public function exportPdf()
    {
        $ibuHamils = IbuHamil::with(['bidan', 'pemeriksaanAncs'])->orderBy('created_at', 'desc')->get();
        $metrics = $this->calculateMetrics($ibuHamils);
        $pdf = Pdf::loadView('dinkes.exports.pdf', compact('ibuHamils', 'metrics'));
        // Set paper size to A4 landscape
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('Laporan_KIA_'.date('Ymd').'.pdf');
    }

    /**
     * Export Laporan Rekapitulasi to Excel (HTML table trick)
     */
    public function exportExcel()
    {
        $ibuHamils = IbuHamil::with(['bidan', 'pemeriksaanAncs'])->orderBy('created_at', 'desc')->get();
        $metrics = $this->calculateMetrics($ibuHamils);

        return response()->view('dinkes.exports.excel', compact('ibuHamils', 'metrics'))
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', 'attachment; filename="Laporan_IbuHamil_'.date('Ymd').'.xls"');
    }

    public function exportBayiPdf()
    {
        $anaks = Anak::with(['pengukuran.kader.posyandu', 'orangTua.posyandu', 'orangTua.puskesmas', 'tindakanMedis.bidan.puskesmas', 'tindakanMedis.posyandu', 'tindakanMedis.puskesmas', 'imunisasi.bidan.puskesmas', 'imunisasi.posyandu', 'imunisasi.puskesmas'])->orderBy('created_at', 'desc')->get();
        $pdf = Pdf::loadView('dinkes.exports.pdf_bayi', compact('anaks'))->setPaper('a4', 'landscape');

        return $pdf->download('Laporan_Bayi_'.date('Ymd').'.pdf');
    }

    public function exportBayiExcel()
    {
        $anaks = Anak::with(['pengukuran.kader.posyandu', 'orangTua.posyandu', 'orangTua.puskesmas', 'tindakanMedis.bidan.puskesmas', 'tindakanMedis.posyandu', 'tindakanMedis.puskesmas', 'imunisasi.bidan.puskesmas', 'imunisasi.posyandu', 'imunisasi.puskesmas'])->orderBy('created_at', 'desc')->get();

        return response()->view('dinkes.exports.excel_bayi', compact('anaks'))
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', 'attachment; filename="Laporan_Bayi_'.date('Ymd').'.xls"');
    }

    public function exportKbPdf()
    {
        $akseptors = KbAcceptor::with(['user', 'puskesmas', 'kader', 'activeServices'])->orderBy('created_at', 'desc')->get();
        $pdf = Pdf::loadView('dinkes.exports.pdf_kb', compact('akseptors'))->setPaper('a4', 'landscape');

        return $pdf->download('Laporan_KB_'.date('Ymd').'.pdf');
    }

    public function exportKbExcel()
    {
        $akseptors = KbAcceptor::with(['user', 'puskesmas', 'kader', 'activeServices'])->orderBy('created_at', 'desc')->get();

        return response()->view('dinkes.exports.excel_kb', compact('akseptors'))
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', 'attachment; filename="Laporan_KB_'.date('Ymd').'.xls"');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penggunas = User::where('role', 'dinkes')->orderBy('created_at', 'desc')->get();

        return view('dinkes_admin.index', compact('penggunas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dinkes_admin.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'max:20', 'regex:/^[0-9]+$/'],
            'nip' => ['required', 'string', 'size:18', 'regex:/^[0-9]+$/', 'unique:'.User::class],
            'status' => ['required', 'in:aktif,nonaktif'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'nip' => $request->nip,
            'role' => 'dinkes',
            'status' => $request->status,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('bidan.index')->with('success', 'Data Dinkes berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $dinkes = User::where('role', 'dinkes')->findOrFail($id);

        return view('dinkes_admin.edit', compact('dinkes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $dinkes = User::where('role', 'dinkes')->findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($dinkes->id)],
            'phone' => ['required', 'string', 'max:20', 'regex:/^[0-9]+$/'],
            'nip' => ['required', 'string', 'size:18', 'regex:/^[0-9]+$/', Rule::unique(User::class)->ignore($dinkes->id)],
            'status' => ['required', 'in:aktif,nonaktif'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'nip' => $request->nip,
            'status' => $request->status,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $dinkes->update($data);

        return redirect()->route('bidan.index')->with('success', 'Data Dinkes berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dinkes = User::where('role', 'dinkes')->findOrFail($id);
        $dinkes->delete();

        return redirect()->route('bidan.index')->with('success', 'Data Dinkes berhasil dihapus.');
    }
}
