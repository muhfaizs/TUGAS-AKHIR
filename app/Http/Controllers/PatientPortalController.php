<?php

namespace App\Http\Controllers;

use App\Models\KBAcceptor;
use App\Models\KBService;
use Illuminate\Support\Facades\Auth;

class PatientPortalController extends Controller
{
    public function dashboard()
    {
        if (Auth::user()->role !== 'patient') {
            abort(403, 'Akses ditolak. Halaman khusus pasien.');
        }

        $user = Auth::user();

        // Fetch Akseptor profile based on user_id OR nik
        $acceptor = KBAcceptor::where('user_id', $user->id)
            ->orWhere('nik', $user->nik)
            ->first();

        // Auto-link jika belum terhubung
        if ($acceptor && empty($acceptor->user_id)) {
            $acceptor->update(['user_id' => $user->id]);
        }

        $services = collect();
        $nextFollowUp = null;

        if ($acceptor) {
            $services = KBService::with(['creator', 'puskesmasData'])
                ->where('kb_acceptor_id', $acceptor->id)
                ->orderBy('service_date', 'desc')
                ->get();

            $nextFollowUp = KBService::where('kb_acceptor_id', $acceptor->id)
                ->whereNotNull('follow_up_date')
                ->where('follow_up_date', '>=', now()->startOfDay())
                ->orderBy('follow_up_date', 'asc')
                ->first();
        }

        return view('patient.dashboard', compact('acceptor', 'services', 'nextFollowUp'));
    }
}
