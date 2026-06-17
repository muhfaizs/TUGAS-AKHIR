<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KBAcceptorFamily extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kb_acceptor_families';

    protected $fillable = [
        'kb_acceptor_id',
        'family_member_name',
        'relationship',
        'date_of_birth',
        'gender',
        'phone',
        'address',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    /**
     * Get the KB acceptor
     */
    public function acceptor(): BelongsTo
    {
        return $this->belongsTo(KBAcceptor::class, 'kb_acceptor_id');
    }

    /**
     * Get age from date of birth
     */
    public function getAge(): ?int
    {
        if (!$this->date_of_birth) {
            return null;
        }
        return $this->date_of_birth->diffInYears(now());
    }
}
