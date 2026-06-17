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
        'kabupaten_id', 
        'nama_puskesmas'
    ];

    /**
     * Get all users in this puskesmas
     */
public function users()
    {
        return $this->hasMany(User::class, 'puskesmas_id');
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
  
    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class, 'kabupaten_id');
    }

    public function posyandus()
    {
        return $this->hasMany(Posyandu::class, 'puskesmas_id');
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
