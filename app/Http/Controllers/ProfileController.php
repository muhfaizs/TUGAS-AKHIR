<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', [
            'user' => Auth::user(),
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20', 'regex:/^[0-9]+$/'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ];

        if ($user->isSuperAdmin() || $user->isBidanOnly() || $user->isDinkes()) {
            $rules['nip'] = ['nullable', 'string', 'size:18', 'regex:/^[0-9]+$/', Rule::unique('users')->ignore($user->id)];
        } else {
            $rules['nik'] = ['nullable', 'string', 'size:16', 'regex:/^[0-9]+$/', Rule::unique('users')->ignore($user->id)];
        }

        $request->validate($rules);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        if ($user->isSuperAdmin() || $user->isBidanOnly() || $user->isDinkes()) {
            $user->nip = $request->nip;
        } else {
            $user->nik = $request->nik;
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui.');
    }
}
