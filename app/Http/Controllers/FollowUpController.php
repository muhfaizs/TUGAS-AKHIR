<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KBService;
use App\Models\FollowUp;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class FollowUpController extends Controller
{
    public function index()
    {
        // Fitur Pemantauan / Follow Up
        $services = KBService::with(['acceptor', 'bidan'])
            ->whereNotNull('follow_up_date')
            ->orderBy('follow_up_date', 'asc')
            ->paginate(15);
            
        return view('followups.index', compact('services'));
    }

    public function show($id)
    {
        $service = KBService::with(['acceptor'])->findOrFail($id);
        
        // Find existing follow up if any
        $followUp = FollowUp::where('kb_service_id', $id)->first();

        return view('followups.show', compact('service', 'followUp'));
    }

    public function store(Request $request, $id)
    {
        $service = KBService::findOrFail($id);

        $validated = $request->validate([
            'follow_up_date' => 'required|date',
            'attendance_status' => 'required|in:hadir,tidak_hadir',
            'condition' => 'nullable|string|max:255',
            'complaints' => 'nullable|string',
            'side_effects' => 'nullable|string',
            'notes' => 'nullable|string',
            'status' => 'required|in:belum_selesai,selesai',
            'next_control_date' => 'nullable|date',
            'next_control_notes' => 'nullable|string',
        ]);

        $validated['kb_service_id'] = $service->id;
        $validated['kb_acceptor_id'] = $service->kb_acceptor_id;

        $followUp = FollowUp::where('kb_service_id', $id)->first();

        if ($followUp) {
            $validated['updated_by'] = Auth::id();
            $followUp->update($validated);
            $message = 'Hasil follow-up berhasil diperbarui.';
        } else {
            $validated['created_by'] = Auth::id();
            FollowUp::create($validated);
            $message = 'Hasil follow-up berhasil disimpan.';
        }

        // Opsional: Jika status Selesai, kita bisa tandai service-nya jika diperlukan
        // tapi saat ini cukup disimpan di tabel follow_ups

        return redirect()->route('kb-acceptors.show', $service->kb_acceptor_id)->with('success', $message);
    }
}
