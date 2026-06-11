<?php

namespace App\Http\Controllers\OrangTua;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $posyandus = \App\Models\Posyandu::all();
        return view('dashboard.orangtua.profile', [
            'user' => $request->user(),
            'posyandus' => $posyandus,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'nomor_kontak' => ['required', 'string', 'max:15'],
            'nik_ortu' => ['required', 'digits:16', Rule::unique('tb_user')->ignore($user->id_user, 'id_user')],
            'posyandu_id' => ['nullable', 'exists:posyandus,id'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:tb_user,email,'.$user->id_user.',id_user'],
            'password' => ['nullable', 'string', 'min:8', Password::defaults()],
            'foto_profil' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'nomor_kontak.required' => 'Nomor kontak wajib diisi.',
            'nik_ortu.required' => 'NIK wajib diisi.',
            'nik_ortu.digits' => 'NIK harus 16 digit angka.',
            'nik_ortu.unique' => 'NIK sudah digunakan akun lain.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah digunakan oleh akun lain.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        $user->fill([
            'nama_lengkap' => $validated['nama_lengkap'],
            'nomor_kontak' => $validated['nomor_kontak'],
            'nik_ortu' => $validated['nik_ortu'],
            'posyandu_id' => $validated['posyandu_id'] ?? null,
            'email' => $validated['email'] ?? null,
        ]);

        if (! empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        if ($request->has('hapus_foto') && $request->hapus_foto == '1') {
            if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                Storage::disk('public')->delete($user->foto_profil);
            }
            $user->foto_profil = null;
        } elseif ($request->hasFile('foto_profil')) {
            if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                Storage::disk('public')->delete($user->foto_profil);
            }
            $user->foto_profil = $request->file('foto_profil')->store('profile_photos', 'public');
        }

        $user->save();

        return redirect()->route('orangtua.profile.edit')->with('success', 'Profil berhasil diperbarui.');
    }
}
