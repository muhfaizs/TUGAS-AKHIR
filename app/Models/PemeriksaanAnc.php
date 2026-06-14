<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemeriksaanAnc extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'tanggal_pemeriksaan' => 'date',
        'diberikan_imunisasi_tt' => 'boolean',
        'diberikan_tablet_tambah_darah' => 'boolean',
        'rujuk_laboratorium' => 'boolean',
        'ditemukan_risiko' => 'boolean',
    ];

    public function ibuHamil()
    {
        return $this->belongsTo(IbuHamil::class);
    }
}
