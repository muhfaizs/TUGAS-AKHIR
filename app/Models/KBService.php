<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KBService extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kb_services';

    protected $fillable = [
        'kb_acceptor_id',
        'akseptor_id',
        'akseptor_name',
        'service_method',
        'status',
        'puskesmas',
        'service_date',
        'bidan_id',
        'puskesmas_id',
        'location',
        'batch_number',
        'blood_pressure',
        'weight',
        'clinical_findings',
        'contraindication',
        'side_effects',
        'follow_up_date',
        'follow_up_type',
        'notes',
        'is_verified',
        'verified_by',
        'verified_at',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'service_date' => 'date',
        'follow_up_date' => 'date',
        'verified_at' => 'datetime',
        'is_verified' => 'boolean',
        'weight' => 'decimal:2',
    ];

    /**
     * Get the KB acceptor
     */
    public function acceptor(): BelongsTo
    {
        return $this->belongsTo(KBAcceptor::class, 'kb_acceptor_id');
    }

    /**
     * Get the bidan who created this service
     */
    public function bidan(): BelongsTo
    {
        return $this->belongsTo(User::class, 'bidan_id');
    }

    /**
     * Get puskesmas
     */
    public function puskesmasData(): BelongsTo
    {
        return $this->belongsTo(Puskesmas::class, 'puskesmas_id');
    }

    /**
     * Get the user who created this service
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who verified this service
     */
    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Scope to get only verified services
     */
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    /**
     * Scope to get only active services
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'Aktif');
    }

    /**
     * Scope to filter by month and year
     */
    public function scopeForMonth($query, $month, $year)
    {
        return $query->whereMonth('service_date', $month)
                     ->whereYear('service_date', $year);
    }
}

