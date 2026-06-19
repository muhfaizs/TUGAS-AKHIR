<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FollowUp extends Model
{
    use HasFactory;

    protected $fillable = [
        'kb_service_id',
        'kb_acceptor_id',
        'follow_up_date',
        'attendance_status',
        'absence_reason',
        'condition',
        'complaints',
        'side_effects',
        'risk_level',
        'danger_signs',
        'notes',
        'bidan_actions',
        'kb_method_decision',
        'new_kb_method',
        'method_change_reason',
        'status',
        'next_control_date',
        'next_control_notes',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'follow_up_date' => 'date',
        'next_control_date' => 'date',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(KBService::class, 'kb_service_id');
    }

    public function acceptor(): BelongsTo
    {
        return $this->belongsTo(KBAcceptor::class, 'kb_acceptor_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
