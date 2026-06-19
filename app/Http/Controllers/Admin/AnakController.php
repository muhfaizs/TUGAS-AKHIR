<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anak;
use App\Models\User;
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
        $query = Anak::with('orangTua')->latest();

        if ($request->filled('search')) {
            $query->where('nama_anak', 'like', '%'.$request->search.'%')
                ->orWhere('nik_anak', 'like', '%'.$request->search.'%');
        }

        if ($request->filled('status')) {
            if ($request->status === 'berisiko') {
                $query->whereHas('latestPengukuran', function ($q) {
                    $q->where('flag_risiko', 1);
                });
            } elseif ($request->status === 'normal') {
                $query->whereHas('latestPengukuran', function ($q) {
                    $q->where('flag_risiko', 0);
                });
            }
        }

        $anak = $query->get();

        return view('dashboard.orangtua.anak.index', compact('anak'));
    }

    /**
     * Show the form for creating a new child.
     */
    public function create(): View
    {
        $orangTuaList = User::where('role', 'ortu')->orderBy('name')->get();

        return view('dashboard.orangtua.anak.create', compact('orangTuaList'));
    }

    /**
     * Store a newly created child in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_user' => ['required', 'exists:users,id'],
            'nik_anak' => ['required', 'string', 'size:16', 'unique:tb_anak,nik_anak'],
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
            'no_bpjs' => ['nullable', 'digits_between:1,20'],
            'riwayat_alergi' => ['nullable', 'string'],
            'lingkar_kepala_lahir' => ['nullable', 'numeric', 'min:0', 'max:50'],
            'kondisi_lahir' => ['nullable', 'string', 'max:255'],
            'alamat_domisili' => ['nullable', 'string'],
            'nomor_kontak_darurat' => ['nullable', 'string', 'max:255'],
        ], [
            'id_user.required' => 'Orang tua wajib dipilih.',
            'nik_anak.required' => 'NIK anak wajib diisi.',
            'nik_anak.size' => 'NIK anak harus 16 digit.',
            'nik_anak.unique' => 'NIK anak sudah terdaftar.',
            'nama_anak.required' => 'Nama anak wajib diisi.',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.before_or_equal' => 'Tanggal lahir tidak valid.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'berat_lahir.required' => 'Berat lahir wajib diisi.',
            'panjang_lahir.required' => 'Panjang lahir wajib diisi.',
            'no_bpjs.digits_between' => 'Nomor BPJS harus berupa angka.',
        ]);

        Anak::create($validated);

        $routePrefix = $request->user()->isBidan() ? 'bidan' : 'admin';

        return redirect()->route($routePrefix.'.anak.index')
            ->with('success', 'Data anak berhasil didaftarkan.');
    }

    /**
     * Display the integrated medical history timeline for a child.
     */
    public function show(Request $request, Anak $anak): View
    {
        // Eager load relations
        $anak->load(['orangTua', 'pengukuran.kader', 'tindakanMedis.bidan', 'imunisasi.bidan']);

        // Collect all history items into a single collection
        $history = collect();

        foreach ($anak->pengukuran as $p) {
            $history->push([
                'type' => 'pengukuran',
                'date' => $p->tanggal_pengukuran,
                'data' => $p,
                'actor' => $p->kader->name ?? 'Kader',
            ]);
        }

        foreach ($anak->tindakanMedis as $t) {
            $history->push([
                'type' => 'tindakan',
                'date' => $t->tanggal_pemeriksaan,
                'data' => $t,
                'actor' => $t->bidan->name ?? 'Bidan',
            ]);
        }

        foreach ($anak->imunisasi as $i) {
            $history->push([
                'type' => 'imunisasi',
                'date' => $i->tanggal_pemberian,
                'data' => $i,
                'actor' => $i->bidan->name ?? 'Bidan',
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
        $orangTuaList = User::where('role', 'ortu')->orderBy('name')->get();

        return view('dashboard.orangtua.anak.edit', compact('anak', 'orangTuaList'));
    }

    /**
     * Update the specified child in storage.
     */
    public function update(Request $request, Anak $anak): RedirectResponse
    {
        $validated = $request->validate([
            'id_user' => ['required', 'exists:users,id'],
            'nik_anak' => ['required', 'string', 'size:16', 'unique:tb_anak,nik_anak,'.$anak->id_anak.',id_anak'],
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
            'no_bpjs' => ['nullable', 'digits_between:1,20'],
            'riwayat_alergi' => ['nullable', 'string'],
            'lingkar_kepala_lahir' => ['nullable', 'numeric', 'min:0', 'max:50'],
            'kondisi_lahir' => ['nullable', 'string', 'max:255'],
            'alamat_domisili' => ['nullable', 'string'],
            'nomor_kontak_darurat' => ['nullable', 'string', 'max:255'],
        ], [
            'id_user.required' => 'Orang tua wajib dipilih.',
            'nik_anak.required' => 'NIK anak wajib diisi.',
            'nik_anak.size' => 'NIK anak harus 16 digit.',
            'nik_anak.unique' => 'NIK anak sudah terdaftar.',
            'no_bpjs.digits_between' => 'Nomor BPJS harus berupa angka.',
        ]);

        $anak->update($validated);

        // Sync to parent user if needed
        $user = User::find($validated['id_user']);
        if ($user) {
            $userUpdates = [];
            if (empty($user->alamat_domisili) && ! empty($validated['alamat_domisili'])) {
                $userUpdates['alamat_domisili'] = $validated['alamat_domisili'];
            }
            if (empty($user->nomor_kontak) && ! empty($validated['nomor_kontak_darurat'])) {
                $userUpdates['nomor_kontak'] = $validated['nomor_kontak_darurat'];
            }
            if (! empty($userUpdates)) {
                $user->update($userUpdates);
            }
        }

        $routePrefix = $request->user()->isBidan() ? 'bidan' : 'admin';

        return redirect()->route($routePrefix.'.anak.index')
            ->with('success', 'Data anak berhasil diperbarui.');
    }

    /**
     * Remove the specified child from storage.
     */
    public function destroy(Request $request, Anak $anak): RedirectResponse
    {
        $anak->delete();

        $routePrefix = $request->user()->isBidan() ? 'bidan' : 'admin';

        return redirect()->route($routePrefix.'.anak.index')
            ->with('success', 'Data anak berhasil dihapus.');
    }
}
