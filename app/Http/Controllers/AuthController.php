<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            $redirectRoute = match (Auth::user()->role) {
                'super_admin', 'admin' => route('dashboard'),
                'kader'                => route('kb-acceptors.index'),
                'patient', 'Pasien'    => route('patient.dashboard'),
                'dinas_kesehatan'      => route('reports.index'),
                default                => route('dashboard'),
            };
            return redirect()->intended($redirectRoute);
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required',
        ]);

        $credentials = [
            'password' => $request->password,
        ];
        
        $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        
        // Jika input berupa 16 digit angka murni, anggap itu NIK
        if (preg_match('/^[0-9]{16}$/', $request->username)) {
            $fieldType = 'nik';
        }

        $credentials[$fieldType] = $request->username;

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $redirectRoute = match (Auth::user()->role) {
                'super_admin', 'admin' => route('dashboard'),
                'kader'           => route('kb-acceptors.index'),
                'bidan'           => route('kb-acceptors.index'),
                'patient'         => route('patient.dashboard'),
                'dinas_kesehatan' => route('reports.index'),
                default           => route('dashboard'),
            };

            return redirect()->intended($redirectRoute);
        }

        $errorMessage = ($request->role === 'ortu') ? 'NIK yang dimasukkan salah.' : 'Username atau NIP yang dimasukkan salah.';

        return back()->withErrors([
            'username' => $errorMessage,
        ])->withInput($request->except('password'));
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|max:255|unique:users,email',
            'nik'                   => 'required|string|size:16|unique:users,nik',
            'phone'                 => 'nullable|string|max:20',
            'address'               => 'nullable|string|max:500',
            'password'              => 'required|string|min:8|confirmed',
        ], [
            'name.required'         => 'Nama lengkap wajib diisi.',
            'email.required'        => 'Email wajib diisi.',
            'email.email'           => 'Format email tidak valid.',
            'email.unique'          => 'Email sudah digunakan, gunakan email lain.',
            'nik.required'          => 'NIK wajib diisi.',
            'nik.size'              => 'NIK harus 16 digit.',
            'nik.unique'            => 'NIK sudah terdaftar.',
            'password.required'     => 'Kata sandi wajib diisi.',
            'password.min'          => 'Kata sandi minimal 8 karakter.',
            'password.confirmed'    => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'username' => $request->email, // Gunakan email sebagai username
            'email'    => $request->email,
            'nik'      => $request->nik,
            'phone'    => $request->phone,
            'address'  => $request->address,
            'password' => Hash::make($request->password),
            'role'     => 'patient',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        $redirectRoute = match ($user->role) {
            'super_admin', 'admin' => route('dashboard'),
            'kader'           => route('kb-acceptors.index'),
            'bidan'           => route('kb-acceptors.index'),
            'patient'         => route('patient.dashboard'),
            'Pasien'          => route('patient.dashboard'),
            'dinas_kesehatan' => route('reports.index'),
            default           => route('dashboard'),
        };

        return redirect()->intended($redirectRoute)->with('success', 'Akun berhasil dibuat. Selamat datang, ' . $user->name . '!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login');
    }
}
