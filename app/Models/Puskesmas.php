<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Puskesmas extends Model
{
    use HasFactory;

    protected $table = 'puskesmas';

    protected $fillable = [
        'name',
        'code',
        'address',
        'village',
        'district',
        'sub_district',
        'postal_code',
        'phone',
        'email',
        'head_of_puskesmas',
        'status',
    ];

    /**
     * Get all users in this puskesmas
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get all KB acceptors
     */
    public function kbAcceptors(): HasMany
    {
        return $this->hasMany(KBAcceptor::class);
    }

    /**
     * Get all KB services
     */
    public function kbServices(): HasMany
    {
        return $this->hasMany(KBService::class);
    }

    /**
     * Get total acceptors
     */
    public function getTotalAcceptorsAttribute(): int
    {
        return $this->kbAcceptors()->count();
    }

    /**
     * Get active acceptors
     */
    public function getActiveAcceptorsAttribute(): int
    {
        return $this->kbAcceptors()
            ->whereHas('kbServices', function ($query) {
                $query->where('status', 'Aktif');
            })
            ->distinct()
            ->count();
    }
}
