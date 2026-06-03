<?php

namespace App\Http\Controllers\Bidan;

use App\Http\Controllers\Controller;
use App\Mail\MedicalResultMail;
use App\Models\Anak;
use App\Models\Imunisasi;
use App\Models\Notifikasi;
use App\Models\Posyandu;
use App\Models\Puskesmas;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ImunisasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $imunisasi = Imunisasi::with(['anak', 'bidan'])->latest()->get();

        return view('dashboard.bidan.imunisasi.index', compact('imunisasi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $anakList = Anak::orderBy('nama_anak')->get();
        $puskesmasList = Puskesmas::all();
        $posyanduList = Posyandu::with('puskesmas')->get();

        return view('dashboard.bidan.imunisasi.create', compact('anakList', 'puskesmasList', 'posyanduList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_anak' => 'required|exists:tb_anak,id_anak',
            'nama_vaksin' => 'required|string|max:255',
            'tanggal_pemberian' => 'required|date|before_or_equal:today',
            'batch_vaksin' => 'required|string|max:255',
            'lokasi_suntikan' => 'required|string|max:255',
            'suhu_tubuh' => 'required|numeric|min:30|max:45',
            'catatan' => 'required|string',
            'puskesmas_id' => 'required|exists:puskesmas,id',
            'posyandu_id' => 'required|exists:posyandus,id',
        ]);

        // Age Validation Logic
        $anak = Anak::findOrFail($validated['id_anak']);
        $tanggalLahir = Carbon::parse($anak->tanggal_lahir);
        $tanggalPemberian = Carbon::parse($validated['tanggal_pemberian']);

        $ageFloat = $tanggalLahir->floatDiffInMonths($tanggalPemberian);
        $ageRounded = round($ageFloat, 1);

        $vaksin = $validated['nama_vaksin'];
        $minAge = 0;

        if ($vaksin === 'Hepatitis B0') {
            $minAge = 0;
        } elseif (in_array($vaksin, ['BCG', 'Polio 1'])) {
            $minAge = 1;
        } elseif (in_array($vaksin, ['DPT-HB-Hib 1', 'Polio 2'])) {
            $minAge = 2;
        } elseif (in_array($vaksin, ['DPT-HB-Hib 2', 'Polio 3'])) {
            $minAge = 3;
        } elseif (in_array($vaksin, ['DPT-HB-Hib 3', 'Polio 4'])) {
            $minAge = 4;
        } elseif ($vaksin === 'Campak / MR') {
            $minAge = 9;
        }

        if ($ageFloat < $minAge) {
            return back()->withErrors(['tanggal_pemberian' => 'Peringatan Batas Usia: Usia anak ('.$ageRounded.' bulan) belum mencukupi untuk vaksin '.$vaksin.' (Minimal '.$minAge.' bulan).'])->withInput();
        }

        $validated['id_bidan'] = auth()->id();

        $imunisasi = Imunisasi::create($validated);

        // Fetch parent for Notification & Email
        $anak = Anak::with('orangTua')->find($validated['id_anak']);
        if ($anak && $anak->orangTua) {
            $pesan = "Halo, ini pemberitahuan dari Puskesmas. Anak Anda, {$anak->nama_anak}, baru saja menerima Imunisasi: {$vaksin}.";

            // WA Link
            $waLink = 'https://api.whatsapp.com/send?phone='.preg_replace('/[^0-9]/', '', $anak->orangTua->nomor_kontak).'&text='.urlencode($pesan);

            // In-App Notification
            Notifikasi::create([
                'id_user' => $anak->orangTua->id_user,
                'judul' => 'Imunisasi Baru',
                'pesan' => $pesan,
                'wa_link' => $waLink,
            ]);

            // PDF & Email
            if ($anak->orangTua->email) {
                try {
                    $imunisasi->load(['anak.orangTua', 'bidan', 'puskesmas', 'posyandu']);
                    $pdf = Pdf::loadView('dashboard.pdf.imunisasi', compact('imunisasi'));
                    $pdfData = $pdf->output();

                    Mail::to($anak->orangTua->email)->send(
                        new MedicalResultMail($pesan, $pdfData, 'Imunisasi_'.$anak->nama_anak.'.pdf')
                    );
                } catch (\Exception $e) {
                    \Log::error('Failed to send Imunisasi email: '.$e->getMessage());
                }
            }
        }

        // Send Notification to Kader in the selected Posyandu
        $kaders = User::where('role', 'kader')
            ->where('id_posyandu_kader', $validated['posyandu_id'])
            ->get();

        foreach ($kaders as $kader) {
            $pesanKader = "Pemberitahuan Kader: Anak {$anak->nama_anak} baru saja mendapatkan imunisasi {$vaksin} di posyandu wilayah Anda.";
            $waLinkKader = $kader->nomor_kontak ? 'https://api.whatsapp.com/send?phone='.preg_replace('/[^0-9]/', '', $kader->nomor_kontak).'&text='.urlencode($pesanKader) : null;
            Notifikasi::create([
                'id_user' => $kader->id_user,
                'judul' => 'Imunisasi di Wilayah Anda',
                'pesan' => $pesanKader,
                'wa_link' => $waLinkKader,
            ]);
        }

        return redirect()->route('bidan.imunisasi.index')
            ->with('success', 'Data imunisasi berhasil ditambahkan. Notifikasi dikirim.');
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
    public function edit(Imunisasi $imunisasi)
    {
        $anakList = Anak::orderBy('nama_anak')->get();
        $puskesmasList = Puskesmas::all();
        $posyanduList = Posyandu::with('puskesmas')->get();

        return view('dashboard.bidan.imunisasi.edit', compact('imunisasi', 'anakList', 'puskesmasList', 'posyanduList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Imunisasi $imunisasi)
    {
        $validated = $request->validate([
            'id_anak' => 'required|exists:tb_anak,id_anak',
            'nama_vaksin' => 'required|string|max:255',
            'tanggal_pemberian' => 'required|date|before_or_equal:today',
            'batch_vaksin' => 'required|string|max:255',
            'lokasi_suntikan' => 'required|string|max:255',
            'suhu_tubuh' => 'required|numeric|min:30|max:45',
            'catatan' => 'required|string',
            'puskesmas_id' => 'required|exists:puskesmas,id',
            'posyandu_id' => 'required|exists:posyandus,id',
        ]);

        // Age Validation Logic
        $anak = Anak::findOrFail($validated['id_anak']);
        $tanggalLahir = Carbon::parse($anak->tanggal_lahir);
        $tanggalPemberian = Carbon::parse($validated['tanggal_pemberian']);

        $ageFloat = $tanggalLahir->floatDiffInMonths($tanggalPemberian);
        $ageRounded = round($ageFloat, 1);

        $vaksin = $validated['nama_vaksin'];
        $minAge = 0;

        if ($vaksin === 'Hepatitis B0') {
            $minAge = 0;
        } elseif (in_array($vaksin, ['BCG', 'Polio 1'])) {
            $minAge = 1;
        } elseif (in_array($vaksin, ['DPT-HB-Hib 1', 'Polio 2'])) {
            $minAge = 2;
        } elseif (in_array($vaksin, ['DPT-HB-Hib 2', 'Polio 3'])) {
            $minAge = 3;
        } elseif (in_array($vaksin, ['DPT-HB-Hib 3', 'Polio 4'])) {
            $minAge = 4;
        } elseif ($vaksin === 'Campak / MR') {
            $minAge = 9;
        }

        if ($ageFloat < $minAge) {
            return back()->withErrors(['tanggal_pemberian' => 'Peringatan Batas Usia: Usia anak ('.$ageRounded.' bulan) belum mencukupi untuk vaksin '.$vaksin.' (Minimal '.$minAge.' bulan).'])->withInput();
        }

        $imunisasi->update($validated);

        return redirect()->route('bidan.imunisasi.index')
            ->with('success', 'Data imunisasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Imunisasi $imunisasi)
    {
        $imunisasi->delete();

        return redirect()->route('bidan.imunisasi.index')
            ->with('success', 'Data imunisasi berhasil dihapus.');
    }
}
