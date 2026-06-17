<?php

namespace App\Http\Controllers;

use App\Models\IbuHamil;
use App\Models\PemeriksaanAnc;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class OrtuController extends Controller
{
    public function create()
    {
        return view('ortu.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'max:20', 'regex:/^[0-9]+$/'],
            'nik' => ['required', 'string', 'size:16', 'regex:/^[0-9]+$/', 'unique:'.User::class],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'nik' => $request->nik,
            'role' => 'ortu',
            'status' => 'aktif',
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('bidan.index')->with('success', 'Akun Ibu Hamil berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $ortu = User::where('role', 'ortu')->findOrFail($id);

        return view('ortu.edit', compact('ortu'));
    }

    public function update(Request $request, string $id)
    {
        $ortu = User::where('role', 'ortu')->findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($ortu->id)],
            'phone' => ['required', 'string', 'max:20', 'regex:/^[0-9]+$/'],
            'nik' => ['required', 'string', 'size:16', 'regex:/^[0-9]+$/', Rule::unique(User::class)->ignore($ortu->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'nik' => $request->nik,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $ortu->update($data);

        return redirect()->route('bidan.index')->with('success', 'Akun Ibu Hamil berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $ortu = User::where('role', 'ortu')->findOrFail($id);
        $ortu->delete();

        return redirect()->route('bidan.index')->with('success', 'Akun Ibu Hamil berhasil dihapus.');
    }

    /**
     * Download Rekap Pemeriksaan ANC PDF for the logged in Ortu.
     */
    public function downloadRekap()
    {
        $user = Auth::user();

        $ibuHamil = IbuHamil::with(['pemeriksaanAncs' => function ($query) {
            $query->orderBy('tanggal_pemeriksaan', 'asc');
        }])->where('nik', $user->nik)->first();

        if (! $ibuHamil) {
            return back()->with('error', 'Data rekam medis Anda belum tersedia. Silakan hubungi Bidan Anda.');
        }

        $quickChartUrl = $ibuHamil->getQuickChartUrl();

        $pdf = Pdf::loadView('ibu-hamil.rekap-pdf', [
            'ibuHamil' => $ibuHamil,
            'quickChartUrl' => $quickChartUrl,
            'tanggal' => now()->translatedFormat('d F Y'),
        ]);

        return $pdf->download('Rekap_Pemeriksaan_ANC_'.str_replace(' ', '_', $ibuHamil->nama_lengkap).'.pdf');
    }

    public function pemeriksaan()
    {
        $user = Auth::user();

        $ibuHamil = IbuHamil::with(['pemeriksaanAncs' => function ($query) {
            $query->orderBy('tanggal_pemeriksaan', 'desc');
        }])->where('nik', $user->nik)->first();

        return view('ortu.pemeriksaan', compact('ibuHamil'));
    }

    public function pemeriksaanDetail($id)
    {
        $user = Auth::user();

        $anc = PemeriksaanAnc::where('id', $id)
            ->whereHas('ibuHamil', function ($q) use ($user) {
                $q->where('nik', $user->nik);
            })->firstOrFail();

        return view('ortu.pemeriksaan-detail', compact('anc'));
    }

    public function dismissPengingat(Request $request)
    {
        $user = Auth::user();
        $anakId = $request->input('anak_id');
        $vaksin = $request->input('vaksin');

        $anak = \App\Models\Anak::where('id_anak', $anakId)->where('id_user', $user->id)->firstOrFail();

        $notifTitle = "Pengingat Imunisasi: {$vaksin} - {$anak->nama_anak}";

        \App\Models\Notifikasi::create([
            'id_user' => $user->id,
            'judul' => $notifTitle,
            'pesan' => "Anda telah membaca jadwal imunisasi {$vaksin} untuk {$anak->nama_anak}.",
        ]);

        return back()->with('success', 'Jadwal imunisasi telah ditandai dibaca.');
    }
}
