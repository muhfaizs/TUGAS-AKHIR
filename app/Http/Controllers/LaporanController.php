<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pengukuran;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Posyandu List for Dropdown
        $posyanduList = User::where('role', 'kader')
            ->whereNotNull('id_posyandu_kader')
            ->pluck('id_posyandu_kader')
            ->unique();

        // Query Pengukuran joined with Anak, Kader, and Tindakan Medis
        $query = Pengukuran::with(['anak', 'kader', 'anak.tindakanMedis', 'anak.imunisasi']);

        if ($request->filled('posyandu')) {
            $query->whereHas('kader', function($q) use ($request) {
                $q->where('id_posyandu_kader', $request->posyandu);
            });
        }

        if ($request->filled('tgl_awal')) {
            $query->whereDate('tanggal_pengukuran', '>=', $request->tgl_awal);
        }

        if ($request->filled('tgl_akhir')) {
            $query->whereDate('tanggal_pengukuran', '<=', $request->tgl_akhir);
        }

        $laporan = $query->orderBy('tanggal_pengukuran', 'desc')->get();

        return view('dashboard.laporan.index', compact('laporan', 'posyanduList'));
    }

    public function print(Request $request)
    {
        // Query Pengukuran joined with Anak, Kader, and Tindakan Medis
        $query = Pengukuran::with(['anak', 'kader', 'anak.tindakanMedis', 'anak.imunisasi']);

        if ($request->filled('posyandu')) {
            $query->whereHas('kader', function($q) use ($request) {
                $q->where('id_posyandu_kader', $request->posyandu);
            });
        }

        if ($request->filled('tgl_awal')) {
            $query->whereDate('tanggal_pengukuran', '>=', $request->tgl_awal);
        }

        if ($request->filled('tgl_akhir')) {
            $query->whereDate('tanggal_pengukuran', '<=', $request->tgl_akhir);
        }

        $laporan = $query->orderBy('tanggal_pengukuran', 'asc')->get();

        return view('dashboard.laporan.print', compact('laporan', 'request'));
    }
}
