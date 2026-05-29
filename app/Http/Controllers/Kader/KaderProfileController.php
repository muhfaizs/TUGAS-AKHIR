<?php

namespace App\Http\Controllers\Kader;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class KaderProfileController extends Controller
{
    /**
     * Show the profile edit form.
     */
    public function edit(Request $request): View
    {
        return view('dashboard.kader.profile', [
            'user' => $request->user(),
            'kabupatenList' => \App\Models\Kabupaten::all(),
            'puskesmasList' => \App\Models\Puskesmas::all(),
            'posyanduList' => \App\Models\Posyandu::with('puskesmas')->get(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'nomor_kontak' => ['nullable', 'string', 'max:15'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:tb_user,email,' . $user->id_user . ',id_user'],
            'password' => ['nullable', 'string', 'min:8', Password::defaults()],
            'foto_profil' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'posyandu_id' => ['required', 'exists:posyandus,id'],
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah digunakan oleh akun lain.',
            'password.min' => 'Password minimal 8 karakter.',
            'posyandu_id.required' => 'Tempat tugas (Posyandu) wajib diisi.',
        ]);

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        if ($request->has('hapus_foto') && $request->hapus_foto == '1') {
            if ($user->foto_profil && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->foto_profil)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->foto_profil);
            }
            $validated['foto_profil'] = null;
        } elseif ($request->hasFile('foto_profil')) {
            if ($user->foto_profil && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->foto_profil)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->foto_profil);
            }
            $validated['foto_profil'] = $request->file('foto_profil')->store('profile_photos', 'public');
        }

        $user->update($validated);

        return redirect()->route('kader.profile.edit')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}
