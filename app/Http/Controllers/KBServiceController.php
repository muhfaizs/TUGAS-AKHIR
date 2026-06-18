<?php

namespace App\Http\Controllers;

use App\Models\KBService;
use App\Models\KBAcceptor;
use App\Models\Puskesmas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class KBServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = KBService::with('acceptor', 'bidan', 'puskesmasData');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('acceptor', function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        if ($request->filled('method')) {
            $query->where('service_method', $request->method);
        }

        if ($request->filled('status')) {
            if ($request->status === 'verified') {
                $query->where('is_verified', true);
            } elseif ($request->status === 'pending') {
                $query->where('is_verified', false);
            }
        }

        $services = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        return view('kb-services.index', compact('services'));
    }

    public function create(Request $request)
    {
        $acceptors = KBAcceptor::where('is_verified', true)
            ->orderBy('full_name')
            ->get();

        $selectedAcceptorId = $request->query('acceptor_id');

        return view('kb-services.create', compact('acceptors', 'selectedAcceptorId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kb_acceptor_id' => 'required|exists:kb_acceptors,id',
            'service_method' => 'required|string|in:IUD,MOW,MOP,Implant,Tubektomi,Vasektomi,Pil,Suntik,Kondom,Jelly',
            'service_date' => 'required|date',
            'location' => 'nullable|string|max:255',
            'batch_number' => 'nullable|string|max:50',
            'blood_pressure' => 'nullable|string|max:20',
            'weight' => 'nullable|numeric|min:0|max:500',
            'clinical_findings' => 'nullable|string',
            'contraindication' => 'nullable|string',
            'side_effects' => 'nullable|string',
            'follow_up_date' => 'nullable|date',
            'follow_up_type' => 'nullable|string|in:phone,visit,sms',
            'notes' => 'nullable|string',
        ]);

        $acceptor = KBAcceptor::findOrFail($validated['kb_acceptor_id']);
        
        $validated['bidan_id'] = Auth::id();
        $validated['puskesmas_id'] = $acceptor->puskesmas_id;
        $validated['created_by'] = Auth::id();
        
        // Ensure service_date is set to now if empty (although it should be required now)
        if (empty($validated['service_date'])) {
            $validated['service_date'] = now();
        }

        KBService::create($validated);

        return redirect()
            ->route('kb-acceptors.show', $acceptor->id)
            ->with('success', 'Layanan KB berhasil ditambahkan');
    }

    public function show(KBService $kbService)
    {
        $kbService->load('acceptor', 'bidan', 'puskesmasData', 'creator', 'verifier');
        
        return view('kb-services.show', compact('kbService'));
    }

    public function edit(KBService $kbService)
    {
        $kbService->load('acceptor');
        $acceptors = KBAcceptor::where('is_verified', true)
            ->orderBy('full_name')
            ->get();

        return view('kb-services.edit', compact('kbService', 'acceptors'));
    }

    public function update(Request $request, KBService $kbService)
    {
        $validated = $request->validate([
            'kb_acceptor_id' => 'required|exists:kb_acceptors,id',
            'service_method' => 'required|string|in:IUD,MOW,MOP,Implant,Tubektomi,Vasektomi,Pil,Suntik,Kondom,Jelly',
            'service_date' => 'required|date',
            'location' => 'nullable|string|max:255',
            'batch_number' => 'nullable|string|max:50',
            'blood_pressure' => 'nullable|string|max:20',
            'weight' => 'nullable|numeric|min:0|max:500',
            'clinical_findings' => 'nullable|string',
            'contraindication' => 'nullable|string',
            'side_effects' => 'nullable|string',
            'follow_up_date' => 'nullable|date',
            'follow_up_type' => 'nullable|string|in:phone,visit,sms',
            'notes' => 'nullable|string',
        ]);

        $acceptor = KBAcceptor::findOrFail($validated['kb_acceptor_id']);
        $validated['puskesmas_id'] = $acceptor->puskesmas_id;
        $validated['updated_by'] = Auth::id();

        $kbService->update($validated);

        return redirect()
            ->route('kb-services.show', $kbService->id)
            ->with('success', 'Layanan KB berhasil diperbarui');
    }

    public function destroy(KBService $kbService)
    {
        $acceptorId = $kbService->kb_acceptor_id;
        $kbService->delete();

        return redirect()
            ->route('kb-acceptors.show', $acceptorId)
            ->with('success', 'Layanan KB berhasil dihapus');
    }

    public function verify(Request $request, KBService $kbService)
    {
        if (!Auth::user()->hasRole(['super_admin', 'bidan', 'dinas_kesehatan'])) {
            abort(403, 'Akses Ditolak: Anda tidak memiliki izin untuk memverifikasi layanan ini.');
        }

        $kbService->update([
            'is_verified' => true,
            'verified_by' => Auth::id(),
            'verified_at' => now(),
        ]);

        return back()->with('success', 'Layanan KB berhasil diverifikasi');
    }

    public function search(Request $request)
    {
        $query = $request->get('q', '');

        $acceptors = KBAcceptor::where('is_verified', true)
            ->where(function($q) use ($query) {
                $q->where('full_name', 'like', "%{$query}%")
                  ->orWhere('nik', 'like', "%{$query}%")
                  ->orWhere('phone', 'like', "%{$query}%");
            })
            ->limit(10)
            ->get(['id', 'full_name', 'nik', 'phone']);

        return response()->json($acceptors);
    }

    public function jadwalKontrol(Request $request)
    {
        // Get services with follow_up_date within the next 14 days or overdue but not resolved yet
        // For simplicity, just get all upcoming or recent follow_up_dates
        $query = KBService::with(['acceptor' => function($q) {
                $q->select('id', 'full_name', 'nik', 'phone', 'address');
            }])
            ->whereNotNull('follow_up_date')
            ->orderBy('follow_up_date', 'asc');

        if ($request->filled('status')) {
            if ($request->status == 'upcoming') {
                $query->where('follow_up_date', '>=', now()->toDateString());
            } elseif ($request->status == 'overdue') {
                $query->where('follow_up_date', '<', now()->toDateString());
            }
        }

        if ($request->filled('method')) {
            $query->where('service_method', $request->method);
        }

        $jadwalKontrols = $query->paginate(20)->withQueryString();

        return view('kb-services.jadwal_kontrol', compact('jadwalKontrols'));
    }

    public function sendReminder(Request $request, KBService $kbService)
    {
        $acceptor = $kbService->acceptor;
        if (!$acceptor || !$acceptor->phone) {
            return back()->with('error', 'Nomor telepon akseptor tidak ditemukan.');
        }

        // Create the WhatsApp message
        $tanggalKontrol = \Carbon\Carbon::parse($kbService->follow_up_date)->translatedFormat('l, d F Y');
        
        $pesan = "Halo Ibu {$acceptor->full_name},\n\n";
        $pesan .= "Ini adalah pesan pengingat otomatis dari *SatuKIA (Sistem Informasi KIA)*.\n\n";
        $pesan .= "Kami mengingatkan bahwa jadwal kunjungan ulang / kontrol KB Ibu untuk metode *{$kbService->service_method}* adalah pada:\n";
        $pesan .= "🗓️ *{$tanggalKontrol}*\n\n";
        $pesan .= "Silakan datang ke Faskes pada tanggal tersebut. Jangan ragu untuk menghubungi kami jika ada keluhan.\n\n";
        $pesan .= "Salam hangat,\nBidan Anda";

        $phone = preg_replace('/[^0-9]/', '', $acceptor->phone);
        // Replace leading 0 with 62
        if (strpos($phone, '0') === 0) {
            $phone = '62' . substr($phone, 1);
        }

        $waUrl = "https://wa.me/{$phone}?text=" . urlencode($pesan);

        return redirect()->away($waUrl);
    }
}
