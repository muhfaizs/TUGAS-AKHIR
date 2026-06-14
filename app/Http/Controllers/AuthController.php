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
            'nik' => 'required|string|size:16|regex:/^[0-9]+$/|unique:users',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|size:11|regex:/^[0-9]+$/',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
        ], [
            'nik.size' => 'NIK harus tepat 16 angka.',
            'nik.regex' => 'NIK hanya boleh berisi angka.',
            'phone.size' => 'Nomor ponsel harus tepat 11 angka.',
            'phone.regex' => 'Nomor ponsel hanya boleh berisi angka.',
        ]);

        $user = User::create([
            'nik' => $request->nik,
            'name' => $request->name,
            'phone' => '+62'.ltrim($request->phone, '0'), // Handle the +62 prefix conceptually
            'email' => $request->email,
            'password' => Hash::make($request->password),
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
            'role' => 'required|in:bidan,ortu',
            'identity' => [
                'required',
                'string',
                'regex:/^[0-9]+$/',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->role === 'bidan' && strlen($value) !== 18) {
                        $fail('NIP harus tepat 18 angka.');
                    }
                    if ($request->role === 'ortu' && strlen($value) !== 16) {
                        $fail('NIK harus tepat 16 angka.');
                    }
                },
            ],
            'password' => 'required|string',
        ], [
            'identity.regex' => 'Kredensial hanya boleh berisi angka.',
        ]);

        // Determine which column to check against based on role
        $identityColumn = $request->role === 'bidan' ? 'nip' : 'nik';

        $credentials = [
            $identityColumn => $request->identity,
            'password' => $request->password,
        ];

        $remember = $request->has('remember-me');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            if (in_array($user->role, ['bidan', 'dinkes']) && $user->status !== 'aktif') {
                Auth::logout();

                return back()->withErrors([
                    'identity' => 'Akun Anda telah dinonaktifkan. Silakan hubungi Super Administrator.',
                ])->onlyInput('identity', 'role');
            }

            $request->session()->regenerate();

            return redirect()->intended('dashboard')->with('success', 'Selamat datang kembali!');
        }

        return back()->withErrors([
            'identity' => 'NIP/NIK SALAH',
        ])->onlyInput('identity', 'role');
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
