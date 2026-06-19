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
            'attendance_status' => 'required|string',
            'absence_reason' => 'nullable|string',
            'condition' => 'nullable|string',
            'complaints' => 'nullable|string',
            'side_effects' => 'nullable|string',
            'risk_level' => 'nullable|string',
            'danger_signs' => 'nullable|string',
            'notes' => 'nullable|string',
            'bidan_actions' => 'nullable|string',
            'kb_method_decision' => 'nullable|string',
            'new_kb_method' => 'nullable|string',
            'method_change_reason' => 'nullable|string',
            'status' => 'required|string',
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

        if (!empty($validated['next_control_date'])) {
            $service->update(['follow_up_date' => $validated['next_control_date']]);
        }

        return redirect()->route('kb-services.index')->with('success', $message);
    }
}
