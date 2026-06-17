<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    /**
     * Handle a login request using username.
     *
     * @throws ValidationException
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            /** @var User $user */
            $user = Auth::user();

            if (! $user->is_active) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                throw ValidationException::withMessages([
                    'username' => 'Akun Anda sedang dinonaktifkan. Silakan hubungi administrator.',
                ]);
            }

            $request->session()->regenerate();

            return match ($user->role) {
                'super admin' => redirect()->intended(route('admin.dashboard')),
                'bidan' => redirect()->intended(route('bidan.dashboard')),
                'kader' => redirect()->intended(route('admin.dashboard')),
                'orang tua' => redirect()->intended(route('orangtua.dashboard')),
                'dinkes' => redirect()->intended(route('dashboard')),
                default => redirect()->intended('/'),
            };
        }

        throw ValidationException::withMessages([
            'username' => __('Username atau password salah.'),
        ]);
    }

    /**
     * Handle a logout request.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
