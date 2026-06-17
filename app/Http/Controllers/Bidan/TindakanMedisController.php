<?php

namespace App\Http\Controllers\Bidan;

use App\Http\Controllers\Controller;
use App\Mail\MedicalResultMail;
use App\Models\Anak;
use App\Models\Notifikasi;
use App\Models\Posyandu;
use App\Models\Puskesmas;
use App\Models\TindakanMedis;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TindakanMedisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tindakan = TindakanMedis::with(['anak', 'bidan'])->latest()->get();

        return view('dashboard.bidan.tindakan.index', compact('tindakan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $anakList = Anak::orderBy('nama_anak')->get();
        $puskesmasList = Puskesmas::all();
        $posyanduList = Posyandu::with('puskesmas')->get();

        return view('dashboard.bidan.tindakan.create', compact('anakList', 'puskesmasList', 'posyanduList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_anak' => 'required|exists:tb_anak,id_anak',
            'tanggal_pemeriksaan' => 'required|date|before_or_equal:today',
            'suhu_tubuh' => 'required|numeric|min:30|max:45',
            'catatan_pemeriksaan' => 'required|string',
            'diagnosa' => 'required|string',
            'resep_obat' => 'required|string',
            'puskesmas_id' => 'required|exists:puskesmas,id',
            'posyandu_id' => 'required|exists:posyandus,id',
        ]);

        $validated['id_bidan'] = auth()->id();

        $tindakan = TindakanMedis::create($validated);

        // Fetch parent for Notification & Email
        $anak = Anak::with('orangTua')->find($validated['id_anak']);
        if ($anak && $anak->orangTua) {
            $pesan = "Halo, ini pemberitahuan dari Puskesmas. Anak Anda, {$anak->nama_anak}, baru saja menerima tindakan medis dengan diagnosa: ".($validated['diagnosa'] ?? 'Pemeriksaan Rutin').'.';

            // WA Link
            $waLink = 'https://api.whatsapp.com/send?phone='.preg_replace('/[^0-9]/', '', $anak->orangTua->phone).'&text='.urlencode($pesan);

            // In-App Notification
            Notifikasi::create([
                'id_user' => $anak->orangTua->id_user,
                'judul' => 'Tindakan Medis Baru',
                'pesan' => $pesan,
                'wa_link' => $waLink,
            ]);

            // PDF & Email
            if ($anak->orangTua->email) {
                try {
                    $tindakan->load(['anak.orangTua', 'bidan', 'puskesmas', 'posyandu']);
                    $pdf = Pdf::loadView('dashboard.pdf.tindakan', compact('tindakan'));
                    $pdfData = $pdf->output();

                    Mail::to($anak->orangTua->email)->send(
                        new MedicalResultMail($pesan, $pdfData, 'Tindakan_Medis_'.$anak->nama_anak.'.pdf')
                    );
                } catch (\Exception $e) {
                    \Log::error('Failed to send Tindakan Medis email: '.$e->getMessage());
                }
            }
        }

        // Send Notification to Kader in the selected Posyandu
        $kaders = User::where('role', 'kader')
            ->where('id_posyandu_kader', $validated['posyandu_id'])
            ->get();

        foreach ($kaders as $kader) {
            $pesanKader = "Pemberitahuan Kader: Anak {$anak->nama_anak} baru saja mendapatkan tindakan medis di posyandu wilayah Anda.";
            $waLinkKader = $kader->phone ? 'https://api.whatsapp.com/send?phone='.preg_replace('/[^0-9]/', '', $kader->phone).'&text='.urlencode($pesanKader) : null;
            Notifikasi::create([
                'id_user' => $kader->id_user,
                'judul' => 'Tindakan Medis di Wilayah Anda',
                'pesan' => $pesanKader,
                'wa_link' => $waLinkKader,
            ]);
        }

        return redirect()->route('bidan.tindakan.index')
            ->with('success', 'Data pemeriksaan/tindakan medis berhasil ditambahkan. Notifikasi dikirim.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TindakanMedis $tindakan)
    {
        $anakList = Anak::orderBy('nama_anak')->get();
        $puskesmasList = Puskesmas::all();
        $posyanduList = Posyandu::with('puskesmas')->get();

        return view('dashboard.bidan.tindakan.edit', compact('tindakan', 'anakList', 'puskesmasList', 'posyanduList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TindakanMedis $tindakan)
    {
        $validated = $request->validate([
            'id_anak' => 'required|exists:tb_anak,id_anak',
            'tanggal_pemeriksaan' => 'required|date|before_or_equal:today',
            'suhu_tubuh' => 'required|numeric|min:30|max:45',
            'catatan_pemeriksaan' => 'required|string',
            'diagnosa' => 'required|string',
            'resep_obat' => 'required|string',
            'puskesmas_id' => 'required|exists:puskesmas,id',
            'posyandu_id' => 'required|exists:posyandus,id',
        ]);

        $tindakan->update($validated);

        return redirect()->route('bidan.tindakan.index')
            ->with('success', 'Data pemeriksaan/tindakan medis berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TindakanMedis $tindakan)
    {
        $tindakan->delete();

        return redirect()->route('bidan.tindakan.index')
            ->with('success', 'Data pemeriksaan/tindakan medis berhasil dihapus.');
    }
}
