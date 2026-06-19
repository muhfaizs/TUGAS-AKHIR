<?php

namespace App\Http\Controllers\Kader;

use App\Http\Controllers\Controller;
use App\Models\JadwalPosyandu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalPosyanduController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        if (! $user->isKader() || ! $user->posyandu_id) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini atau belum ditetapkan ke Posyandu tertentu.');
        }

        $jadwals = JadwalPosyandu::where('posyandu_id', $user->posyandu_id)
            ->orderBy('tanggal', 'desc')
            ->orderBy('waktu_mulai', 'desc')
            ->paginate(10);

        return view('dashboard.kader.jadwal.index', compact('jadwals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $posyanduName = $user->posyandu ? $user->posyandu->nama_posyandu : 'Balai Posyandu';

        return view('dashboard.kader.jadwal.create', compact('posyanduName'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
            'lokasi' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $user = Auth::user();

        JadwalPosyandu::create([
            'posyandu_id' => $user->posyandu_id,
            'tanggal' => $request->tanggal,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'lokasi' => $request->lokasi,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('kader.jadwal.index')->with('success', 'Jadwal Posyandu berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jadwal = JadwalPosyandu::findOrFail($id);

        if ($jadwal->posyandu_id !== Auth::user()->posyandu_id) {
            abort(403, 'Akses ditolak.');
        }

        $user = Auth::user();
        $posyanduName = $user->posyandu ? $user->posyandu->nama_posyandu : 'Balai Posyandu';

        return view('dashboard.kader.jadwal.edit', compact('jadwal', 'posyanduName'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $jadwal = JadwalPosyandu::findOrFail($id);

        if ($jadwal->posyandu_id !== Auth::user()->posyandu_id) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
            'lokasi' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $jadwal->update([
            'tanggal' => $request->tanggal,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'lokasi' => $request->lokasi,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('kader.jadwal.index')->with('success', 'Jadwal Posyandu berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jadwal = JadwalPosyandu::findOrFail($id);

        if ($jadwal->posyandu_id !== Auth::user()->posyandu_id) {
            abort(403, 'Akses ditolak.');
        }

        $jadwal->delete();

        return redirect()->route('kader.jadwal.index')->with('success', 'Jadwal Posyandu berhasil dihapus.');
    }
}
