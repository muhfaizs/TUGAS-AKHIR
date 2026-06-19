<?php

namespace App\Http\Controllers;

use App\Models\KBService;
use App\Models\ServiceReport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $reports = ServiceReport::with(['submittedBy', 'verifiedBy'])
            ->orderBy('year', 'desc')
            ->get();

        return view('reports.index', compact('reports'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required|integer|min:2000|max:'.(date('Y') + 5),
        ]);

        $year = $request->year;

        // Cek apakah laporan untuk tahun tersebut sudah ada
        $existingReport = ServiceReport::where('year', $year)->first();

        if ($existingReport) {
            return redirect()->route('reports.index')->with('error', 'Laporan untuk tahun '.$year.' sudah ada.');
        }

        ServiceReport::create([
            'year' => $year,
            'submitted_by' => auth()->id(),
            'status' => 'draft',
        ]);

        return redirect()->route('reports.index')->with('success', 'Draft laporan tahun '.$year.' berhasil dibuat.');
    }

    public function download(ServiceReport $report)
    {
        $services = KBService::with(['acceptor', 'bidan', 'creator', 'puskesmasData'])
            ->whereHas('acceptor')
            ->whereYear('created_at', $report->year)
            ->orderBy('created_at', 'asc')
            ->get();

        $pdf = Pdf::loadView('reports.pdf', [
            'report' => $report,
            'services' => $services,
            'year' => $report->year,
        ]);

        return $pdf->download('Laporan_Pelayanan_KB_Tahun_'.$report->year.'.pdf');
    }

    public function submit(ServiceReport $report)
    {
        if ($report->status !== 'draft' && $report->status !== 'rejected') {
            return back()->with('error', 'Hanya draft atau laporan ditolak yang bisa dikirim.');
        }

        $report->update([
            'status' => 'submitted',
        ]);

        return back()->with('success', 'Laporan tahun '.$report->year.' berhasil dikirim ke Dinas Kesehatan.');
    }

    public function verify(Request $request, ServiceReport $report)
    {
        // Pastikan hanya role dinas_kesehatan yang bisa verifikasi
        if (auth()->user()->role !== 'dinas_kesehatan') {
            return back()->with('error', 'Anda tidak memiliki akses untuk memverifikasi laporan.');
        }

        if ($report->status === 'verified') {
            return back()->with('error', 'Laporan sudah diverifikasi.');
        }

        $report->update([
            'status' => 'verified',
            'verified_by' => auth()->id(),
        ]);

        return back()->with('success', 'Laporan tahun '.$report->year.' berhasil diverifikasi.');
    }

    public function destroy(ServiceReport $report)
    {
        $report->delete();

        return back()->with('success', 'Laporan R1 KB Tahun '.$report->year.' berhasil dihapus.');
    }
}
