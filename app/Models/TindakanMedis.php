<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TindakanMedis extends Model
{
    protected $table = 'tb_tindakan_medis';

    protected $primaryKey = 'id_tindakan';

    protected $fillable = [
        'id_anak',
        'id_bidan',
        'tanggal_pemeriksaan',
        'suhu_tubuh',
        'catatan_pemeriksaan',
        'diagnosa',
        'resep_obat',
        'puskesmas_id',
        'posyandu_id',
    ];

    protected $casts = [
        'tanggal_pemeriksaan' => 'date',
    ];

    /**
     * Get the child associated with this tindakan medis.
     */
    public function anak(): BelongsTo
    {
        return $this->belongsTo(Anak::class, 'id_anak', 'id_anak');
    }

    /**
     * Get the bidan who performed this tindakan medis.
     */
    public function bidan(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_bidan', 'id');
    }

    /**
     * Get the Puskesmas where this was performed.
     */
    public function puskesmas()
    {
        return $this->belongsTo(Puskesmas::class, 'puskesmas_id');
    }

    /**
     * Get the Posyandu where this was performed.
     */
    public function posyandu()
    {
        return $this->belongsTo(Posyandu::class, 'posyandu_id');
    }
}

