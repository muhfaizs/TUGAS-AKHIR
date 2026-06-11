<?php

namespace App\Http\Controllers\OrangTua;

use App\Http\Controllers\Controller;
use App\Models\Anak;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnakController extends Controller
{
    /**
     * Display a listing of the children.
     */
    public function index(Request $request): View
    {
        $anak = $request->user()->anak()->latest()->get();

        return view('dashboard.orangtua.anak.index', compact('anak'));
    }

    /**
     * Show the form for creating a new child.
     */
    public function create(): View
    {
        return view('dashboard.orangtua.anak.create');
    }

    /**
     * Store a newly created child in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nik_anak' => ['required', 'digits:16', 'unique:tb_anak,nik_anak'],
            'nama_anak' => ['required', 'string', 'max:255'],
            'tempat_lahir' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date', 'before_or_equal:today'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'berat_lahir' => ['required', 'numeric', 'min:0', 'max:20'],
            'panjang_lahir' => ['required', 'numeric', 'min:0', 'max:100'],
            'nama_ayah' => ['nullable', 'string', 'max:255'],
            'nama_ibu' => ['nullable', 'string', 'max:255'],
            'catatan' => ['nullable', 'string'],
            'golongan_darah' => ['nullable', 'in:A,B,AB,O,Tidak Tahu'],
            'anak_ke' => ['nullable', 'integer', 'min:1'],
            'no_bpjs' => ['nullable', 'digits:13'],
            'riwayat_alergi' => ['nullable', 'string'],
            'lingkar_kepala_lahir' => ['nullable', 'numeric', 'min:0', 'max:50'],
            'kondisi_lahir' => ['nullable', 'string', 'max:255'],
        ], [
            'nik_anak.required' => 'NIK anak wajib diisi.',
            'nik_anak.digits' => 'NIK anak harus 16 digit angka.',
            'nik_anak.unique' => 'NIK anak sudah terdaftar.',
            'nama_anak.required' => 'Nama anak wajib diisi.',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.before_or_equal' => 'Tanggal lahir tidak valid.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'berat_lahir.required' => 'Berat lahir wajib diisi.',
            'panjang_lahir.required' => 'Panjang lahir wajib diisi.',
            'no_bpjs.digits' => 'Nomor BPJS harus 13 digit angka.',
        ]);

        $request->user()->anak()->create($validated);

        return redirect()->route('orangtua.anak.index')
            ->with('success', 'Data anak berhasil didaftarkan.');
    }

    /**
     * Display the integrated medical history timeline for a child.
     */
    public function show(Request $request, Anak $anak): View
    {
        // Ensure this child belongs to the logged-in user
        if ($anak->id_user !== $request->user()->id_user) {
            abort(403, 'Unauthorized action.');
        }

        // Eager load relations
        $anak->load(['orangTua', 'pengukuran.kader', 'tindakanMedis.bidan', 'imunisasi.bidan']);

        // Collect all history items into a single collection
        $history = collect();

        foreach ($anak->pengukuran as $p) {
            $history->push([
                'type' => 'pengukuran',
                'date' => $p->tanggal_pengukuran,
                'data' => $p,
                'actor' => $p->kader->nama_lengkap ?? 'Kader',
            ]);
        }

        foreach ($anak->tindakanMedis as $t) {
            $history->push([
                'type' => 'tindakan',
                'date' => $t->tanggal_pemeriksaan,
                'data' => $t,
                'actor' => $t->bidan->nama_lengkap ?? 'Bidan',
            ]);
        }

        foreach ($anak->imunisasi as $i) {
            $history->push([
                'type' => 'imunisasi',
                'date' => $i->tanggal_pemberian,
                'data' => $i,
                'actor' => $i->bidan->nama_lengkap ?? 'Bidan',
            ]);
        }

        // Sort descending by date
        $timeline = $history->sortByDesc('date')->values();

        return view('dashboard.orangtua.anak.show', compact('anak', 'timeline'));
    }

    /**
     * Show the form for editing the specified child.
     */
    public function edit(Request $request, Anak $anak): View
    {
        // Ensure this child belongs to the logged-in user
        if ($anak->id_user !== $request->user()->id_user) {
            abort(403, 'Unauthorized action.');
        }

        return view('dashboard.orangtua.anak.edit', compact('anak'));
    }

    /**
     * Update the specified child in storage.
     */
    public function update(Request $request, Anak $anak): RedirectResponse
    {
        if ($anak->id_user !== $request->user()->id_user) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'nik_anak' => ['required', 'digits:16', 'unique:tb_anak,nik_anak,'.$anak->id_anak.',id_anak'],
            'nama_anak' => ['required', 'string', 'max:255'],
            'tempat_lahir' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date', 'before_or_equal:today'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'berat_lahir' => ['required', 'numeric', 'min:0', 'max:20'],
            'panjang_lahir' => ['required', 'numeric', 'min:0', 'max:100'],
            'nama_ayah' => ['nullable', 'string', 'max:255'],
            'nama_ibu' => ['nullable', 'string', 'max:255'],
            'catatan' => ['nullable', 'string'],
            'golongan_darah' => ['nullable', 'in:A,B,AB,O,Tidak Tahu'],
            'anak_ke' => ['nullable', 'integer', 'min:1'],
            'no_bpjs' => ['nullable', 'digits:13'],
            'riwayat_alergi' => ['nullable', 'string'],
            'lingkar_kepala_lahir' => ['nullable', 'numeric', 'min:0', 'max:50'],
            'kondisi_lahir' => ['nullable', 'string', 'max:255'],
        ], [
            'nik_anak.required' => 'NIK anak wajib diisi.',
            'nik_anak.digits' => 'NIK anak harus 16 digit angka.',
            'nik_anak.unique' => 'NIK anak sudah terdaftar.',
            'no_bpjs.digits' => 'Nomor BPJS harus 13 digit angka.',
        ]);

        $anak->update($validated);

        return redirect()->route('orangtua.anak.index')
            ->with('success', 'Data anak berhasil diperbarui.');
    }

    /**
     * Remove the specified child from storage.
     */
    public function destroy(Request $request, Anak $anak): RedirectResponse
    {
        if ($anak->id_user !== $request->user()->id_user) {
            abort(403, 'Unauthorized action.');
        }

        $anak->delete();

        return redirect()->route('orangtua.anak.index')
            ->with('success', 'Data anak berhasil dihapus.');
    }
}
