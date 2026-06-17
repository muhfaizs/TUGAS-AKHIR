<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TbLaporanDinkes extends Model
{
    protected $table = 'tb_laporan_dinkes';

    protected $fillable = [
        'id_bidan',
        'nama_puskesmas',
        'periode_awal',
        'periode_akhir',
        'status',
        'data_serialized',
    ];

    protected $casts = [
        'periode_awal' => 'date',
        'periode_akhir' => 'date',
        'data_serialized' => 'array',
    ];

    public function bidan()
    {
        return $this->belongsTo(User::class, 'id_bidan', 'id_user');
    }
}
