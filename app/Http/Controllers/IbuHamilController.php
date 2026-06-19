<?php

namespace App\Http\Controllers;

use App\Mail\RekapPemeriksaanMail;
use App\Mail\ReminderPemeriksaanMail;
use App\Models\IbuHamil;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class IbuHamilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = IbuHamil::withSum('pemeriksaanAncs', 'jumlah_tablet_darah')->orderBy('created_at', 'desc');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', '%'.$search.'%')
                    ->orWhere('nik', 'like', '%'.$search.'%');
            });
        }

        $ibuHamils = $query->get();

        return view('ibu-hamil.index', compact('ibuHamils'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Generate nomor rekam medis otomatis (contoh sederhana)
        $lastPatient = IbuHamil::orderBy('id', 'desc')->first();
        $nextId = $lastPatient ? $lastPatient->id + 1 : 1;
        $nomorRekamMedis = 'RM-'.date('Ym').'-'.str_pad($nextId, 4, '0', STR_PAD_LEFT);

        return view('ibu-hamil.create', compact('nomorRekamMedis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            // Identitas
            'nik' => ['required', 'string', 'size:16', 'regex:/^[0-9]+$/', 'unique:ibu_hamils'],
            'nomor_bpjs' => ['nullable', 'string', 'size:13', 'regex:/^[0-9]+$/', 'unique:ibu_hamils'],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'tempat_lahir' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date'],
            'umur' => ['required', 'integer'],
            'alamat' => ['required', 'string'],
            'nomor_telepon' => ['required', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:255'],
            'nama_suami' => ['required', 'string', 'max:255'],
            'pekerjaan' => ['nullable', 'string', 'max:255'],
            'golongan_darah' => ['required', 'in:A,B,AB,O,Tidak Tahu'],

            // Kehamilan Dasar
            'hpht' => ['required', 'date'],
            'hpl' => ['required', 'date'],
            'usia_kehamilan' => ['required', 'integer'],
            'gravida' => ['required', 'integer'],
            'paritas' => ['required', 'integer'],
            'abortus' => ['required', 'integer'],
            'kehamilan_ke' => ['required', 'integer'],
            'status_risiko_kehamilan' => ['required', 'in:Rendah,Tinggi,Sangat Tinggi'],
            'bayi_meninggal_setelah_lahir' => ['required', 'integer', 'min:0'],

            // Administratif
            'tanggal_registrasi_pasien' => ['required', 'date'],
            'status_pasien' => ['required', 'in:Aktif,Nonaktif'],
            'status_ibu_meninggal' => ['required', 'in:Hidup,Meninggal'],
            'nomor_rekam_medis' => ['required', 'string', 'unique:ibu_hamils'],

            // Riwayat
            'tindakan_medis' => ['nullable', 'string'],
        ]);

        $validatedData['bidan_id'] = Auth::id();
        $validatedData['jumlah_pemeriksaan_anc'] = 0;

        IbuHamil::create($validatedData);

        // Notifikasi ke Dinkes dihapus sesuai permintaan, sekarang hanya saat bidan mengirimkan laporan

        return redirect()->route('ibu-hamil.index')->with('success', 'Data Pasien Ibu Hamil berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ibuHamil = IbuHamil::findOrFail($id);

        return view('ibu-hamil.show', compact('ibuHamil'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $ibuHamil = IbuHamil::findOrFail($id);

        return view('ibu-hamil.edit', compact('ibuHamil'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $ibuHamil = IbuHamil::findOrFail($id);

        $validatedData = $request->validate([
            // Identitas
            'nik' => ['required', 'string', 'size:16', 'regex:/^[0-9]+$/', Rule::unique('ibu_hamils')->ignore($ibuHamil->id)],
            'nomor_bpjs' => ['nullable', 'string', 'size:13', 'regex:/^[0-9]+$/', Rule::unique('ibu_hamils')->ignore($ibuHamil->id)],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'tempat_lahir' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date'],
            'umur' => ['required', 'integer'],
            'alamat' => ['required', 'string'],
            'nomor_telepon' => ['required', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:255'],
            'nama_suami' => ['required', 'string', 'max:255'],
            'pekerjaan' => ['nullable', 'string', 'max:255'],
            'golongan_darah' => ['required', 'in:A,B,AB,O,Tidak Tahu'],

            // Kehamilan Dasar
            'hpht' => ['required', 'date'],
            'hpl' => ['required', 'date'],
            'usia_kehamilan' => ['required', 'integer'],
            'gravida' => ['required', 'integer'],
            'paritas' => ['required', 'integer'],
            'abortus' => ['required', 'integer'],
            'kehamilan_ke' => ['required', 'integer'],
            'status_risiko_kehamilan' => ['required', 'in:Rendah,Tinggi,Sangat Tinggi'],
            'bayi_meninggal_setelah_lahir' => ['required', 'integer', 'min:0'],

            // Administratif
            'tanggal_registrasi_pasien' => ['required', 'date'],
            'status_pasien' => ['required', 'in:Aktif,Nonaktif'],
            'status_ibu_meninggal' => ['required', 'in:Hidup,Meninggal'],
            // nomor_rekam_medis biasanya tidak diubah

            // Riwayat Singkat (Opsional update manual)
            'jumlah_pemeriksaan_anc' => ['required', 'integer'],
            'pemeriksaan_terakhir' => ['nullable', 'date'],
            'status_kehamilan_terakhir' => ['nullable', 'string', 'max:255'],
            'tindakan_medis' => ['nullable', 'string'],
        ]);

        $ibuHamil->update($validatedData);

        return redirect()->route('ibu-hamil.index')->with('success', 'Data Pasien Ibu Hamil berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ibuHamil = IbuHamil::findOrFail($id);
        $ibuHamil->delete();

        return redirect()->route('ibu-hamil.index')->with('success', 'Data Pasien Ibu Hamil berhasil dihapus.');
    }

    /**
     * Turunkan status risiko kehamilan pasien menjadi Rendah.
     */
    public function turunRisiko(string $id)
    {
        $ibuHamil = IbuHamil::findOrFail($id);
        $ibuHamil->update([
            'status_risiko_kehamilan' => 'Rendah',
        ]);

        return back()->with('success', 'Status pasien berhasil diturunkan menjadi risiko Rendah.');
    }

    /**
     * Cetak rekapitulasi riwayat ANC dalam format PDF
     */
    public function cetakRekapPdf($id)
    {
        $ibuHamil = IbuHamil::with(['pemeriksaanAncs' => function ($query) {
            $query->orderBy('tanggal_pemeriksaan', 'asc');
        }])->findOrFail($id);

        $user = Auth::user();
        if ($user->isIbuHamil() && $user->nik !== $ibuHamil->nik) {
            abort(403, 'Akses ditolak. Anda hanya dapat mengunduh rekam medis milik Anda sendiri.');
        } elseif (! $user->isIbuHamil() && ! $user->isBidanOnly() && ! $user->isSuperAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengunduh rekam medis ini.');
        }

        $pdf = Pdf::loadView('ibu-hamil.rekap-pdf', [
            'ibuHamil' => $ibuHamil,
            'bidan' => Auth::user(),
            'tanggal' => now()->translatedFormat('d F Y'),
            'quickChartUrl' => $ibuHamil->getQuickChartUrl(),
        ]);

        return $pdf->download('Rekap_Pemeriksaan_ANC_'.str_replace(' ', '_', $ibuHamil->nama_lengkap).'.pdf');
    }

    /**
     * Kirim email pengingat pemeriksaan berikutnya
     */
    public function sendReminder(Request $request, $id)
    {
        $request->validate([
            'tanggal_kembali' => 'required|date|after:today',
            'catatan' => 'nullable|string',
        ]);

        $ibuHamil = IbuHamil::findOrFail($id);

        if (! $ibuHamil->email) {
            return back()->with('error', 'Pasien ini tidak memiliki alamat email yang terdaftar.');
        }

        Mail::to($ibuHamil->email)->send(
            new ReminderPemeriksaanMail($ibuHamil, $request->tanggal_kembali, $request->catatan)
        );

        return back()->with('success', 'Email pengingat pemeriksaan berikutnya berhasil dikirim ke pasien.');
    }

    /**
     * Generate PDF Rekap dan Kirim via Email
     */
    public function sendRekapPdf($id)
    {
        $ibuHamil = IbuHamil::with(['pemeriksaanAncs' => function ($query) {
            $query->orderBy('tanggal_pemeriksaan', 'asc');
        }])->findOrFail($id);

        if (! $ibuHamil->email) {
            return back()->with('error', 'Pasien ini tidak memiliki alamat email yang terdaftar.');
        }

        $pdf = Pdf::loadView('ibu-hamil.rekap-pdf', [
            'ibuHamil' => $ibuHamil,
            'bidan' => Auth::user(),
            'tanggal' => now()->translatedFormat('d F Y'),
            'quickChartUrl' => $ibuHamil->getQuickChartUrl(),
        ]);

        $latestAnc = $ibuHamil->pemeriksaanAncs->last();
        $tanggalBerikutnya = null;

        if ($latestAnc) {
            $usiaMinggu = $ibuHamil->usia_kehamilan;
            $hariTambahan = 28;
            if ($usiaMinggu >= 36) {
                $hariTambahan = 7;
            } elseif ($usiaMinggu >= 28) {
                $hariTambahan = 14;
            }
            $tanggalBerikutnya = $latestAnc->tanggal_pemeriksaan->copy()->addDays($hariTambahan)->isoFormat('dddd, D MMMM Y');
        }

        Mail::to($ibuHamil->email)->send(
            new RekapPemeriksaanMail($ibuHamil, base64_encode($pdf->output()), $tanggalBerikutnya)
        );

        return back()->with('success', 'Rekap medis dan pengingat jadwal pemeriksaan selanjutnya berhasil dikirim sekaligus ke email pasien.');
    }
}
