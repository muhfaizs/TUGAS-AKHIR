<?php

namespace App\Http\Controllers;

use App\Models\Imunisasi;
use App\Models\Notifikasi;
use App\Models\Pengukuran;
use App\Models\TbLaporanDinkes;
use App\Models\TindakanMedis;
use App\Models\User;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    private function getUnifiedLaporan(Request $request)
    {
        // Fetch Pengukuran
        $qPengukuran = Pengukuran::with(['anak.orangTua', 'kader']);
        if ($request->filled('posyandu')) {
            $qPengukuran->whereHas('kader', function ($q) use ($request) {
                $q->where('id_posyandu_kader', $request->posyandu);
            });
        }
        if ($request->filled('puskesmas')) {
            $qPengukuran->whereHas('kader', function ($q) use ($request) {
                $q->where('puskesmas_id', $request->puskesmas);
            });
        }
        if ($request->filled('tgl_awal')) {
            $qPengukuran->whereDate('tanggal_pengukuran', '>=', $request->tgl_awal);
        }
        if ($request->filled('tgl_akhir')) {
            $qPengukuran->whereDate('tanggal_pengukuran', '<=', $request->tgl_akhir);
        }
        $pengukurans = $qPengukuran->get();

        // Fetch TindakanMedis
        $qTindakan = TindakanMedis::with(['anak.orangTua', 'bidan', 'posyandu']);
        if ($request->filled('posyandu')) {
            $qTindakan->whereHas('posyandu', function ($q) use ($request) {
                $q->where('nama_posyandu', $request->posyandu);
            });
        }
        if ($request->filled('puskesmas')) {
            $qTindakan->where('puskesmas_id', $request->puskesmas);
        }
        if ($request->filled('tgl_awal')) {
            $qTindakan->whereDate('tanggal_pemeriksaan', '>=', $request->tgl_awal);
        }
        if ($request->filled('tgl_akhir')) {
            $qTindakan->whereDate('tanggal_pemeriksaan', '<=', $request->tgl_akhir);
        }
        $tindakans = $qTindakan->get();

        // Fetch Imunisasi
        $qImunisasi = Imunisasi::with(['anak.orangTua', 'bidan', 'posyandu']);
        if ($request->filled('posyandu')) {
            $qImunisasi->whereHas('posyandu', function ($q) use ($request) {
                $q->where('nama_posyandu', $request->posyandu);
            });
        }
        if ($request->filled('puskesmas')) {
            $qImunisasi->where('puskesmas_id', $request->puskesmas);
        }
        if ($request->filled('tgl_awal')) {
            $qImunisasi->whereDate('tanggal_pemberian', '>=', $request->tgl_awal);
        }
        if ($request->filled('tgl_akhir')) {
            $qImunisasi->whereDate('tanggal_pemberian', '<=', $request->tgl_akhir);
        }
        $imunisasais = $qImunisasi->get();

        $visits = [];

        foreach ($pengukurans as $p) {
            if (!$p->anak) {
                continue;
            }
            $date = $p->tanggal_pengukuran->format('Y-m-d');
            $key = $p->id_anak.'_'.$date;
            if (! isset($visits[$key])) {
                $visits[$key] = [
                    'id' => $key,
                    'tanggal' => $p->tanggal_pengukuran,
                    'anak' => $p->anak,
                    'posyandu' => $p->kader->id_posyandu_kader ?? '-',
                    'pelaksana' => [],
                    'pengukuran' => null,
                    'tindakan' => null,
                    'imunisasi' => null,
                ];
            }
            $visits[$key]['pengukuran'] = $p;
            if ($p->kader) {
                $visits[$key]['pelaksana'][] = 'Kader: '.$p->kader->nama_lengkap;
            }
        }

        foreach ($tindakans as $t) {
            if (!$t->anak) {
                continue;
            }
            $date = $t->tanggal_pemeriksaan->format('Y-m-d');
            $key = $t->id_anak.'_'.$date;
            if (! isset($visits[$key])) {
                $visits[$key] = [
                    'id' => $key,
                    'tanggal' => $t->tanggal_pemeriksaan,
                    'anak' => $t->anak,
                    'posyandu' => $t->posyandu->nama_posyandu ?? '-',
                    'pelaksana' => [],
                    'pengukuran' => null,
                    'tindakan' => null,
                    'imunisasi' => null,
                ];
            } elseif ($visits[$key]['posyandu'] === '-') {
                $visits[$key]['posyandu'] = $t->posyandu->nama_posyandu ?? '-';
            }
            $visits[$key]['tindakan'] = $t;
            if ($t->bidan) {
                $visits[$key]['pelaksana'][] = 'Bidan: '.$t->bidan->nama_lengkap;
            }
        }

        foreach ($imunisasais as $i) {
            if (!$i->anak) {
                continue;
            }
            $date = $i->tanggal_pemberian->format('Y-m-d');
            $key = $i->id_anak.'_'.$date;
            if (! isset($visits[$key])) {
                $visits[$key] = [
                    'id' => $key,
                    'tanggal' => $i->tanggal_pemberian,
                    'anak' => $i->anak,
                    'posyandu' => $i->posyandu->nama_posyandu ?? '-',
                    'pelaksana' => [],
                    'pengukuran' => null,
                    'tindakan' => null,
                    'imunisasi' => null,
                ];
            } elseif ($visits[$key]['posyandu'] === '-') {
                $visits[$key]['posyandu'] = $i->posyandu->nama_posyandu ?? '-';
            }
            $visits[$key]['imunisasi'] = $i;
            if ($i->bidan) {
                $visits[$key]['pelaksana'][] = 'Bidan: '.$i->bidan->nama_lengkap;
            }
        }

        return collect(array_values($visits))->map(function ($v) {
            $v['pelaksana'] = array_unique($v['pelaksana']);

            return (object) $v;
        });
    }

    public function index(Request $request)
    {
        // Dropdown List
        $puskesmasList = \App\Models\Puskesmas::all();
        $posyanduList = collect(); // Keep for backward compatibility if needed

        $laporan = $this->getUnifiedLaporan($request)->sortByDesc('tanggal')->values();

        return view('dashboard.laporan.index', compact('laporan', 'posyanduList', 'puskesmasList'));
    }

    public function print(Request $request)
    {
        $laporan = $this->getUnifiedLaporan($request)->sortBy('tanggal')->values();

        return view('dashboard.laporan.print', compact('laporan', 'request'));
    }

    public function excel(Request $request)
    {
        $laporan = $this->getUnifiedLaporan($request)->sortBy('tanggal')->values();

        return response(view('dashboard.laporan.excel', compact('laporan', 'request')))
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', 'attachment; filename="Laporan_KIA_'.date('Ymd').'.xls"');
    }

    public function submitToDinkes(Request $request)
    {
        // Require Bidan role
        if (! auth()->user()->isBidan()) {
            abort(403, 'Unauthorized');
        }

        if (! $request->has('selected_laporan') || empty($request->selected_laporan)) {
            return back()->with('error', 'Anda belum memilih laporan, silakan centang laporan terlebih dahulu untuk mengirim.');
        }

        $allLaporan = $this->getUnifiedLaporan($request);

        $selectedIds = $request->selected_laporan;
        $laporan = $allLaporan->filter(function ($visit) use ($selectedIds) {
            return in_array($visit->id, $selectedIds);
        })->sortByDesc('tanggal')->values();

        if ($laporan->isEmpty()) {
            return back()->with('error', 'Tidak ada data laporan yang valid untuk dikirim.');
        }

        // Store to tb_laporan_dinkes
        $laporanDinkes = TbLaporanDinkes::create([
            'id_bidan' => auth()->id(),
            'nama_puskesmas' => auth()->user()->puskesmas->nama_puskesmas ?? 'Puskesmas',
            'periode_awal' => $request->tgl_awal ?? $laporan->last()->tanggal->format('Y-m-d'),
            'periode_akhir' => $request->tgl_akhir ?? $laporan->first()->tanggal->format('Y-m-d'),
            'status' => 'Terkirim',
            'data_serialized' => $laporan->toJson(),
        ]);

        // Send Notification to all Dinkes users
        $dinkesUsers = User::where('role', 'dinkes')->get();
        foreach ($dinkesUsers as $dinkes) {
            Notifikasi::create([
                'id_user' => $dinkes->id_user,
                'judul' => 'Laporan Periodik Baru',
                'pesan' => 'Ada laporan periodik baru dari '.($laporanDinkes->nama_puskesmas).' oleh Bidan '.auth()->user()->nama_lengkap.'.',
                'wa_link' => null,
            ]);
        }

        return back()->with('success', 'Laporan berhasil disubmit ke Dinas Kesehatan.');
    }

    public function showDinkes($id)
    {
        if (! auth()->user()->isDinkes()) {
            abort(403, 'Unauthorized');
        }

        $laporanDinkes = TbLaporanDinkes::with('bidan')->findOrFail($id);
        
        $data = $laporanDinkes->data_serialized;
        if (is_string($data)) {
            $data = json_decode($data, true);
        }
        
        $laporan = collect($data)->map(function ($item) {
            return json_decode(json_encode($item));
        });

        return view('dashboard.dinkes.laporan_detail', compact('laporanDinkes', 'laporan'));
    }
}
