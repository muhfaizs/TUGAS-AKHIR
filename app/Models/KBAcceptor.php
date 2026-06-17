<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KBAcceptor extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kb_acceptors';

    protected $fillable = [
        'user_id',
        'nik',
        'kk_number',
        'full_name',
        'date_of_birth',
        'age',
        'gender',
        'marital_status',
        'education',
        'occupation',
        'religion',
        'phone',
        'email',
        'blood_type',
        'health_history',
        'allergies',
        'bmi',
        'address',
        'village',
        'district',
        'sub_district',
        'postal_code',
        'photo_nik_path',
        'photo_profile_path',
        'registered_by',
        'registered_at',
        'verification_requested_at',
        'puskesmas_id',
        'kader_id',
        'status',
        'is_verified',
        'verified_by',
        'verified_at',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'registered_at' => 'datetime',
        'verification_requested_at' => 'datetime',
        'verified_at' => 'datetime',
        'is_verified' => 'boolean',
        'bmi' => 'decimal:2',
    ];

    /**
     * Get the user associated with this acceptor
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user who registered this acceptor
     */
    public function registeredBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'registered_by');
    }

    /**
     * Get the user who verified this acceptor
     */
    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Get puskesmas
     */
    public function puskesmas(): BelongsTo
    {
        return $this->belongsTo(Puskesmas::class);
    }

    /**
     * Get kader
     */
    public function kader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'kader_id');
    }

    /**
     * Get family members
     */
    public function familyMembers(): HasMany
    {
        return $this->hasMany(KBAcceptorFamily::class, 'kb_acceptor_id');
    }

    /**
     * Get KB services
     */
    public function kbServices(): HasMany
    {
        return $this->hasMany(KBService::class, 'kb_acceptor_id')->orderByDesc('service_date');
    }

    /**
     * Get last service
     */
    public function lastService()
    {
        return $this->kbServices()->latest('service_date')->first();
    }

    /**
     * Get active services
     */
    public function activeServices(): HasMany
    {
        return $this->hasMany(KBService::class, 'kb_acceptor_id')
            ->where('status', 'Aktif')
            ->orderByDesc('service_date');
    }

    /**
     * Calculate age from date of birth
     */
    public function calculateAge(): int
    {
        return $this->date_of_birth->diffInYears(now());
    }
}
