<?php

namespace App\Http\Controllers;

use App\Models\IbuHamil;
use App\Models\User;
use App\Notifications\LaporanBidanDikirim;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class BidanReportController extends Controller
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

    public function bulanan(Request $request)
    {
        $bulan = $request->query('bulan', date('m'));
        $tahun = $request->query('tahun', date('Y'));

        $ibuHamils = IbuHamil::with(['bidan', 'pemeriksaanAncs' => function ($query) use ($bulan, $tahun) {
            $query->whereMonth('tanggal_pemeriksaan', $bulan)
                ->whereYear('tanggal_pemeriksaan', $tahun)
                ->orderBy('tanggal_pemeriksaan', 'desc');
        }])
            ->where('bidan_id', auth()->id())
            ->whereHas('pemeriksaanAncs', function ($query) use ($bulan, $tahun) {
                $query->whereMonth('tanggal_pemeriksaan', $bulan)
                    ->whereYear('tanggal_pemeriksaan', $tahun);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $metrics = $this->calculateMetrics($ibuHamils);

        return view('bidan.laporan-bulanan', compact('ibuHamils', 'bulan', 'tahun', 'metrics'));
    }

    public function tahunan(Request $request)
    {
        $tahun = $request->query('tahun', date('Y'));

        $ibuHamils = IbuHamil::with(['bidan', 'pemeriksaanAncs' => function ($query) use ($tahun) {
            $query->whereYear('tanggal_pemeriksaan', $tahun)
                ->orderBy('tanggal_pemeriksaan', 'desc');
        }])
            ->where('bidan_id', auth()->id())
            ->whereHas('pemeriksaanAncs', function ($query) use ($tahun) {
                $query->whereYear('tanggal_pemeriksaan', $tahun);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $metrics = $this->calculateMetrics($ibuHamils);

        return view('bidan.laporan-tahunan', compact('ibuHamils', 'tahun', 'metrics'));
    }

    public function export(Request $request)
    {
        $type = $request->query('type');
        $format = $request->query('format');
        $tahun = $request->query('tahun', date('Y'));

        $query = IbuHamil::with(['bidan'])->where('bidan_id', auth()->id());

        if ($type == 'bulanan') {
            $bulan = $request->query('bulan', date('m'));
            $months = [
                '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
                '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
                '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember',
            ];
            $periode = 'Bulan '.($months[$bulan] ?? $bulan).' Tahun '.$tahun;

            $query->with(['pemeriksaanAncs' => function ($q) use ($bulan, $tahun) {
                $q->whereMonth('tanggal_pemeriksaan', $bulan)
                    ->whereYear('tanggal_pemeriksaan', $tahun)
                    ->orderBy('tanggal_pemeriksaan', 'desc');
            }])->whereHas('pemeriksaanAncs', function ($q) use ($bulan, $tahun) {
                $q->whereMonth('tanggal_pemeriksaan', $bulan)
                    ->whereYear('tanggal_pemeriksaan', $tahun);
            });
        } else {
            $periode = 'Tahun '.$tahun;

            $query->with(['pemeriksaanAncs' => function ($q) use ($tahun) {
                $q->whereYear('tanggal_pemeriksaan', $tahun)
                    ->orderBy('tanggal_pemeriksaan', 'desc');
            }])->whereHas('pemeriksaanAncs', function ($q) use ($tahun) {
                $q->whereYear('tanggal_pemeriksaan', $tahun);
            });
        }

        $ibuHamils = $query->orderBy('created_at', 'desc')->get();
        $metrics = $this->calculateMetrics($ibuHamils);
        $title = 'Laporan Pemeriksaan ANC '.($type == 'bulanan' ? 'Bulanan' : 'Tahunan');

        if ($format == 'pdf') {
            $pdf = Pdf::loadView('bidan.exports.pdf', compact('ibuHamils', 'periode', 'title', 'metrics'));
            $pdf->setPaper('A4', 'landscape');

            return $pdf->download('Laporan_KIA_'.date('YmdHis').'.pdf');
        } else {
            return response()->view('bidan.exports.excel', compact('ibuHamils', 'periode', 'title', 'metrics'))
                ->header('Content-Type', 'application/vnd.ms-excel')
                ->header('Content-Disposition', 'attachment; filename="Laporan_KIA_'.date('YmdHis').'.xls"');
        }
    }

    public function kirim(Request $request)
    {
        $periode = $request->input('periode'); // e.g. "Bulan 05 Tahun 2026" or "Tahun 2026"

        // Kirim Notifikasi ke Dinkes
        $dinkesUsers = User::where('role', 'dinkes')->get();
        if ($dinkesUsers->count() > 0) {
            Notification::send($dinkesUsers, new LaporanBidanDikirim(auth()->user()->name, $periode));
        }

        return back()->with('success', 'Laporan berhasil dikirim ke Dinkes.');
    }
}
