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
            'wilayah_kerja' => ['nullable', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'min:8', Password::defaults()],
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah digunakan oleh akun lain.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('kader.profile.edit')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}
