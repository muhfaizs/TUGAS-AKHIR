<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    /**
     * Handle an Orang Tua registration request.
     */
    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nik_ortu' => ['required', 'string', 'size:16', 'unique:users,nik'],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'nomor_kontak' => ['required', 'string', 'max:15'],
            'reg_username' => ['required', 'string', 'max:50', 'unique:users,username'],
            'reg_password' => ['required', 'string', 'min:8', Password::defaults(), 'confirmed'],
            'role' => ['required', 'in:ortu,pasien_kb'],
        ], [
            'nik_ortu.required' => 'NIK wajib diisi.',
            'nik_ortu.size' => 'NIK harus 16 digit.',
            'nik_ortu.unique' => 'NIK sudah terdaftar.',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'nomor_kontak.required' => 'Nomor kontak wajib diisi.',
            'reg_username.required' => 'Username wajib diisi.',
            'reg_username.unique' => 'Username sudah digunakan.',
            'reg_password.required' => 'Password wajib diisi.',
            'reg_password.min' => 'Password minimal 8 karakter.',
            'reg_password.confirmed' => 'Konfirmasi password tidak cocok.',
            'role.required' => 'Peran (Orang Tua / Pasien KB) wajib dipilih.',
            'role.in' => 'Peran yang dipilih tidak valid.',
        ]);

        $user = User::create([
            'nik' => $validated['nik_ortu'],
            'name' => $validated['nama_lengkap'],
            'phone' => $validated['nomor_kontak'],
            'username' => $validated['reg_username'],
            'password' => $validated['reg_password'],
            'role' => $validated['role'],
        ]);

        Auth::login($user);

        return redirect('/dashboard')
            ->with('success', 'Registrasi berhasil! Selamat datang, '.$user->name.'.');
    }
}
