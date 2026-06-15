<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'year',
        'submitted_by',
        'verified_by',
        'status',
        'file_path',
    ];

    public function submittedBy()
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
