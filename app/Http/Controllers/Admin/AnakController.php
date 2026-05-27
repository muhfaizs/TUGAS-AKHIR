<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anak;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AnakController extends Controller
{
    /**
     * Display a listing of the children.
     */
    public function index(Request $request): View
    {
        // Admins, bidan, and kader can see all children
        $anak = Anak::with('orangTua')->latest()->get();

        return view('dashboard.orangtua.anak.index', compact('anak'));
    }

    /**
     * Show the form for creating a new child.
     */
    public function create(): View
    {
        $orangTuaList = User::where('role', 'orang tua')->orderBy('nama_lengkap')->get();
        return view('dashboard.orangtua.anak.create', compact('orangTuaList'));
    }

    /**
     * Store a newly created child in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_user' => ['required', 'exists:tb_user,id_user'],
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
            'no_bpjs' => ['nullable', 'string', 'max:20'],
            'riwayat_alergi' => ['nullable', 'string'],
            'lingkar_kepala_lahir' => ['nullable', 'numeric', 'min:0', 'max:50'],
            'kondisi_lahir' => ['nullable', 'string', 'max:255'],
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
        ]);

        Anak::create($validated);

        return redirect()->route('admin.anak.index')
            ->with('success', 'Data anak berhasil didaftarkan.');
    }

    /**
     * Show the form for editing the specified child.
     */
    public function edit(Request $request, Anak $anak): View
    {
        $orangTuaList = User::where('role', 'orang tua')->orderBy('nama_lengkap')->get();
        return view('dashboard.orangtua.anak.edit', compact('anak', 'orangTuaList'));
    }

    /**
     * Update the specified child in storage.
     */
    public function update(Request $request, Anak $anak): RedirectResponse
    {
        $validated = $request->validate([
            'id_user' => ['required', 'exists:tb_user,id_user'],
            'nik_anak' => ['required', 'string', 'size:16', 'unique:tb_anak,nik_anak,' . $anak->id_anak . ',id_anak'],
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
            'no_bpjs' => ['nullable', 'string', 'max:20'],
            'riwayat_alergi' => ['nullable', 'string'],
            'lingkar_kepala_lahir' => ['nullable', 'numeric', 'min:0', 'max:50'],
            'kondisi_lahir' => ['nullable', 'string', 'max:255'],
        ], [
            'id_user.required' => 'Orang tua wajib dipilih.',
            'nik_anak.required' => 'NIK anak wajib diisi.',
            'nik_anak.size' => 'NIK anak harus 16 digit.',
            'nik_anak.unique' => 'NIK anak sudah terdaftar.'
        ]);

        $anak->update($validated);

        return redirect()->route('admin.anak.index')
            ->with('success', 'Data anak berhasil diperbarui.');
    }

    /**
     * Remove the specified child from storage.
     */
    public function destroy(Request $request, Anak $anak): RedirectResponse
    {
        $anak->delete();

        return redirect()->route('admin.anak.index')
            ->with('success', 'Data anak berhasil dihapus.');
    }
}
