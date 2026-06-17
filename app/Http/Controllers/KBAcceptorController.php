<?php

namespace App\Http\Controllers;

use App\Models\KBAcceptor;
use App\Models\KBAcceptorFamily;
use App\Models\Puskesmas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class KBAcceptorController extends Controller
{
    /**
     * Display a listing of KB acceptors
     */
    public function index(Request $request)
    {
        $query = KBAcceptor::with(['puskesmas', 'registeredBy']);

        if (auth()->user()->role === 'kader') {
            $query->where('registered_by', auth()->id());
        } elseif (auth()->user()->role === 'bidan') {
            $query->where('puskesmas_id', auth()->user()->puskesmas_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nik', 'like', "%{$search}%")
                  ->orWhere('full_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $acceptors = $query->orderBy('full_name', 'asc')->paginate(15)->withQueryString();

        return view('kb-acceptors.index', compact('acceptors'));
    }

    /**
     * Show the form for creating a new KB acceptor
     */
    public function create()
    {
        if (!in_array(auth()->user()->role, ['kader', 'bidan', 'admin'])) {
            abort(403);
        }

        $puskesmas = Puskesmas::orderBy('name')->get();
        return view('kb-acceptors.create', compact('puskesmas'));
    }

    /**
     * Store a newly created KB acceptor in database
     */
    public function store(Request $request)
    {
        if (!in_array(auth()->user()->role, ['kader', 'bidan', 'admin'])) {
            abort(403);
        }

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'nik' => 'required|string|size:16|unique:kb_acceptors,nik',
            'kk_number' => 'nullable|string|max:20',
            'date_of_birth' => 'required|date',
            'age' => 'nullable|integer|min:0|max:150',
            'gender' => 'required|in:M,F',
            'marital_status' => 'required|string',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'education' => 'nullable|string|max:50',
            'occupation' => 'nullable|string|max:100',
            'religion' => 'nullable|string|max:50',
            'blood_type' => 'nullable|string|max:3',
            'address' => 'nullable|string',
            'village' => 'nullable|string|max:100',
            'district' => 'nullable|string|max:100',
            'sub_district' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:10',
            'puskesmas_id' => 'required|exists:puskesmas,id',
            'status' => 'nullable|string',
            'health_history' => 'nullable|string',
            'bmi' => 'nullable|numeric',
            'allergies' => 'nullable|string',
        ], [
            'nik.unique' => 'NIK sudah terdaftar.'
        ]);

        $validated['registered_at'] = now();

        $validated['registered_by'] = auth()->id();

        // Jika Bidan atau Admin yang mendaftar, otomatis terverifikasi
        if (in_array(auth()->user()->role, ['bidan', 'admin'])) {
            $validated['is_verified'] = true;
            $validated['verified_by'] = auth()->id();
            $validated['verified_at'] = now();
        }

        // Handle file uploads
        if ($request->hasFile('photo_nik_path')) {
            $validated['photo_nik_path'] = $request->file('photo_nik_path')
                ->store('kb-acceptors/nik', 'public');
        }

        if ($request->hasFile('photo_profile_path')) {
            $validated['photo_profile_path'] = $request->file('photo_profile_path')
                ->store('kb-acceptors/profiles', 'public');
        }

        $acceptor = KBAcceptor::create($validated);

        return redirect()->route('kb-acceptors.show', $acceptor)
            ->with('success', 'Akseptor KB berhasil didaftarkan.');
    }

    /**
     * Display the specified KB acceptor
     */
    public function show(KBAcceptor $kbAcceptor)
    {
        $kbAcceptor->load(['familyMembers', 'kbServices', 'puskesmas', 'registeredBy']);
        return view('kb-acceptors.show', compact('kbAcceptor'));
    }

    /**
     * Show the form for editing the specified KB acceptor
     */
    public function edit(KBAcceptor $kbAcceptor)
    {
        if (!in_array(auth()->user()->role, ['kader', 'bidan', 'admin']) || (auth()->user()->role === 'kader' && $kbAcceptor->registered_by !== auth()->id())) {
            abort(403);
        }

        $puskesmas = Puskesmas::orderBy('name')->get();
        return view('kb-acceptors.edit', compact('kbAcceptor', 'puskesmas'));
    }

    /**
     * Update the specified KB acceptor in database
     */
    public function update(Request $request, KBAcceptor $kbAcceptor)
    {
        if (!in_array(auth()->user()->role, ['kader', 'bidan', 'admin']) || (auth()->user()->role === 'kader' && $kbAcceptor->registered_by !== auth()->id())) {
            abort(403);
        }

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'nik' => ['required', 'string', 'size:16', Rule::unique('kb_acceptors', 'nik')->ignore($kbAcceptor->id)],
            'kk_number' => 'nullable|string|max:20',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:M,F',
            'marital_status' => 'required|string',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'education' => 'nullable|string|max:50',
            'occupation' => 'nullable|string|max:100',
            'religion' => 'nullable|string|max:50',
            'blood_type' => 'nullable|string|max:3',
            'address' => 'nullable|string',
            'village' => 'nullable|string|max:100',
            'district' => 'nullable|string|max:100',
            'sub_district' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:10',
            'puskesmas_id' => 'required|exists:puskesmas,id',
            'status' => 'nullable|string',
            'health_history' => 'nullable|string',
            'bmi' => 'nullable|numeric',
            'allergies' => 'nullable|string',
        ], [
            'nik.unique' => 'NIK sudah terdaftar.'
        ]);

        // Handle file uploads
        if ($request->hasFile('photo_nik_path')) {
            if ($kbAcceptor->photo_nik_path) {
                Storage::disk('public')->delete($kbAcceptor->photo_nik_path);
            }
            $validated['photo_nik_path'] = $request->file('photo_nik_path')
                ->store('kb-acceptors/nik', 'public');
        }

        if ($request->hasFile('photo_profile_path')) {
            if ($kbAcceptor->photo_profile_path) {
                Storage::disk('public')->delete($kbAcceptor->photo_profile_path);
            }
            $validated['photo_profile_path'] = $request->file('photo_profile_path')
                ->store('kb-acceptors/profiles', 'public');
        }

        $kbAcceptor->update($validated);

        return redirect()->route('kb-acceptors.index')
            ->with('success', 'Data akseptor KB berhasil diperbarui.');
    }

    /**
     * Generate a unique Puskesmas code for new manual entries
     */
    private function generatePuskesmasCode(string $name): string
    {
        $base = Str::upper(preg_replace('/[^A-Z0-9]/', '', $name));
        $code = substr($base . str_repeat('X', 10), 0, 10);

        while (Puskesmas::where('code', $code)->exists()) {
            $suffix = mt_rand(10, 99);
            $code = substr($base . str_repeat('X', 10), 0, 8) . $suffix;
        }

        return $code;
    }

    /**
     * Delete (soft delete) the specified KB acceptor
     */
    public function destroy(KBAcceptor $kbAcceptor)
    {
        if (!in_array(auth()->user()->role, ['kader', 'bidan', 'admin'])) {
            abort(403);
        }

        $kbAcceptor->delete();
        return redirect()->route('kb-acceptors.index')
            ->with('success', 'Akseptor KB berhasil dihapus.');
    }

    /**
     * Submit KB acceptor for verification by bidan
     */
    public function submitForVerification(Request $request, KBAcceptor $kbAcceptor)
    {
        if ($request->isMethod('get')) {
            return redirect()->route('kb-acceptors.show', $kbAcceptor)
                ->with('info', 'Gunakan tombol pada halaman untuk mengirimkan data ke bidan.');
        }

        if (auth()->user()->role !== 'kader' || $kbAcceptor->registered_by !== auth()->id()) {
            abort(403);
        }

        if ($kbAcceptor->is_verified) {
            return back()->with('info', 'Akseptor sudah terverifikasi.');
        }

        if ($kbAcceptor->verification_requested_at) {
            return back()->with('info', 'Data sudah dikirim ke bidan.');
        }

        $kbAcceptor->update(['verification_requested_at' => now()]);

        return back()->with('success', 'Data akseptor berhasil dikirim ke bidan untuk verifikasi.');
    }

    /**
     * Search KB acceptor by NIK
     */
    public function search(Request $request)
    {
        $query = $request->input('q');
        
        $acceptors = KBAcceptor::where('nik', 'like', "%{$query}%")
            ->orWhere('full_name', 'like', "%{$query}%")
            ->orWhere('phone', 'like', "%{$query}%")
            ->limit(10)
            ->get(['id', 'nik', 'full_name', 'phone', 'puskesmas_id']);

        return response()->json($acceptors);
    }

    /**
     * Verify KB acceptor (admin only)
     */
    public function verify(Request $request, KBAcceptor $kbAcceptor)
    {
        if (auth()->user()->role !== 'bidan') {
            abort(403);
        }

        if (!$kbAcceptor->verification_requested_at) {
            return back()->with('warning', 'Akseptor belum dikirim ke bidan untuk verifikasi.');
        }

        $kbAcceptor->update([
            'is_verified' => true,
            'verified_by' => auth()->id(),
            'verified_at' => now(),
        ]);

        return back()->with('success', 'Akseptor KB berhasil diverifikasi.');
    }
}
