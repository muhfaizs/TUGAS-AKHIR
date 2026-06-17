<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class BidanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = User::whereIn('role', ['bidan', 'ortu', 'dinkes'])->orderBy('created_at', 'desc');

        if (request()->has('role')) {
            $query->where('role', request('role'));
        }

        if (request()->has('status')) {
            $query->where('status', request('status'));
        }

        $penggunas = $query->get();

        return view('bidan.index', compact('penggunas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('bidan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'max:20', 'regex:/^[0-9]+$/'],
            'nip' => ['required', 'string', 'size:18', 'regex:/^[0-9]+$/', 'unique:'.User::class],
            'status' => ['required', 'in:aktif,nonaktif'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'nip' => $request->nip,
            'role' => 'bidan',
            'status' => $request->status,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('bidan.index')->with('success', 'Data Bidan berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $bidan = User::where('role', 'bidan')->findOrFail($id);

        return view('bidan.edit', compact('bidan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $bidan = User::where('role', 'bidan')->findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($bidan->id)],
            'phone' => ['required', 'string', 'max:20', 'regex:/^[0-9]+$/'],
            'nip' => ['required', 'string', 'size:18', 'regex:/^[0-9]+$/', Rule::unique(User::class)->ignore($bidan->id)],
            'status' => ['required', 'in:aktif,nonaktif'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'nip' => $request->nip,
            'status' => $request->status,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $bidan->update($data);

        return redirect()->route('bidan.index')->with('success', 'Data Bidan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bidan = User::where('role', 'bidan')->findOrFail($id);
        $bidan->delete();

        return redirect()->route('bidan.index')->with('success', 'Data Bidan berhasil dihapus.');
    }
}
