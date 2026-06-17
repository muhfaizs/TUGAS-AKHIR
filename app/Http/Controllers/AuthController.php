<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * Handle user registration.
     */
    public function register(Request $request)
    {
        $request->validate([
            'nik_ortu' => 'required|string|size:16|regex:/^[0-9]+$/|unique:users,nik',
            'nama_lengkap' => 'required|string|max:255',
            'nomor_kontak' => 'required|string|regex:/^[0-9]+$/',
            'reg_username' => 'required|string|max:255|unique:users,username',
            'reg_password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
        ], [
            'nik_ortu.size' => 'NIK harus tepat 16 angka.',
            'nik_ortu.regex' => 'NIK hanya boleh berisi angka.',
            'nomor_kontak.regex' => 'Nomor ponsel hanya boleh berisi angka.',
        ]);

        $user = User::create([
            'nik' => $request->nik_ortu,
            'name' => $request->nama_lengkap,
            'phone' => '+62'.ltrim($request->nomor_kontak, '0'), // Handle the +62 prefix conceptually
            'username' => $request->reg_username,
            'password' => Hash::make($request->reg_password),
            'role' => 'ortu', // Default role for open registration
        ]);

        Auth::login($user);

        return redirect()->intended('dashboard')->with('success', 'Pendaftaran berhasil!');
    }

    /**
     * Handle user login.
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            if (in_array($user->role, ['bidan', 'dinkes']) && $user->status !== 'aktif') {
                Auth::logout();
                return back()->with('error', 'Akun Anda telah dinonaktifkan. Silakan hubungi Super Administrator.')->onlyInput('username');
            }

            $request->session()->regenerate();

            return redirect()->intended('dashboard')->with('success', 'Selamat datang kembali!');
        }

        return back()->with('error', 'Username atau password salah.')->onlyInput('username');
    }

    /**
     * Handle user logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
