<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class PasswordResetController extends Controller
{
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'identity' => 'required|string|regex:/^[0-9]+$/',
            'recovery_method' => 'required|in:email,wa',
        ], [
            'identity.required' => 'NIK/NIP harus diisi.',
            'identity.regex' => 'NIK/NIP hanya boleh berisi angka.',
            'recovery_method.required' => 'Silakan pilih metode pemulihan.',
        ]);

        // Cek apakah NIK atau NIP ada
        $user = User::where('nik', $request->identity)
            ->orWhere('nip', $request->identity)
            ->first();

        if (! $user) {
            return back()->withErrors(['identity' => 'NIK/NIP tidak ditemukan dalam sistem kami.'])->withInput();
        }

        // Generate Token
        $token = Str::random(64);

        // Hapus token lama jika ada
        DB::table('password_reset_tokens')->where('email', $user->email)->delete();

        // Simpan token baru
        DB::table('password_reset_tokens')->insert([
            'email' => $user->email,
            'token' => Hash::make($token),
            'created_at' => now(),
        ]);

        $resetUrl = route('password.reset', ['token' => $token]).'?email='.urlencode($user->email);

        if ($request->recovery_method === 'email') {
            // Send via Email
            Mail::to($user->email)->send(new ResetPasswordMail($resetUrl, $user));

            return back()->with('success', 'Link pemulihan telah dikirim ke email Anda ('.$this->maskEmail($user->email).').');
        } else {
            // Simulate sending via WA
            // Normally, we'd call a WA API here.
            $phone = $user->phone;

            return back()->with('success', 'Tautan pemulihan simulasi WA. (Gunakan tautan ini untuk pengujian lokal: <a href="'.$resetUrl.'" class="underline font-bold text-teal-800">Klik Disini</a>). Seharusnya dikirim ke '.$phone);
        }
    }

    public function showResetForm(Request $request, $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required',
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
        ]);

        $tokenData = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        if (! $tokenData || ! Hash::check($request->token, $tokenData->token)) {
            return back()->withErrors(['email' => 'Token reset password tidak valid atau sudah kedaluwarsa.']);
        }

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return back()->withErrors(['email' => 'Pengguna dengan email tersebut tidak ditemukan.']);
        }

        // Update password
        $user->password = Hash::make($request->password);
        $user->save();

        // Hapus token
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Kata sandi Anda berhasil diperbarui. Silakan masuk dengan kata sandi baru.');
    }

    private function maskEmail($email)
    {
        $parts = explode('@', $email);
        $name = $parts[0];
        $domain = $parts[1];

        $maskedName = substr($name, 0, 2).str_repeat('*', max(strlen($name) - 2, 3));

        return $maskedName.'@'.$domain;
    }
}
