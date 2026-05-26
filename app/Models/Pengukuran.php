<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengukuran extends Model
{
    use HasFactory;

    protected $table = 'tb_pengukuran';
    protected $primaryKey = 'id_pengukuran';

    protected $fillable = [
        'id_anak',
        'id_kader',
        'tanggal_pengukuran',
        'berat_badan',
        'tinggi_badan',
        'lingkar_kepala',
        'imt',
        'flag_risiko',
    ];

    protected $casts = [
        'tanggal_pengukuran' => 'date',
        'berat_badan' => 'float',
        'tinggi_badan' => 'float',
        'lingkar_kepala' => 'float',
        'imt' => 'float',
        'flag_risiko' => 'boolean',
    ];

    public function anak()
    {
        return $this->belongsTo(Anak::class, 'id_anak', 'id_anak');
    }

    public function kader()
    {
        return $this->belongsTo(User::class, 'id_kader', 'id_user');
    }
}
