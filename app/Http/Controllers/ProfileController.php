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
        $posyandus = \App\Models\Posyandu::all();
        
        return view('profile.edit', [
            'user' => Auth::user(),
            'posyandus' => $posyandus,
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
            'profile_photo' => ['nullable', 'image', 'max:2048'],
        ];

        if ($user->isSuperAdmin() || $user->isBidanOnly() || $user->isDinkes()) {
            $rules['nip'] = ['nullable', 'string', 'max:16', 'regex:/^[0-9]+$/', Rule::unique('users')->ignore($user->id)];
        } else {
            $rules['nik'] = ['nullable', 'string', 'size:16', 'regex:/^[0-9]+$/', Rule::unique('users')->ignore($user->id)];
        }

        if ($user->isKader()) {
            $rules['posyandu_id'] = ['nullable', 'exists:posyandus,id'];
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

        if ($user->isKader() && $request->has('posyandu_id')) {
            $user->posyandu_id = $request->posyandu_id;
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->profile_photo_path)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->profile_photo_path);
            }
            $user->profile_photo_path = $request->file('profile_photo')->store('profile-photos', 'public');
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui.');
    }
}
