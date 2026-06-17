<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Imunisasi extends Model
{
    protected $table = 'tb_imunisasi';

    protected $primaryKey = 'id_imunisasi';

    protected $fillable = [
        'id_anak',
        'id_bidan',
        'nama_vaksin',
        'batch_vaksin',
        'lokasi_suntikan',
        'suhu_tubuh',
        'tanggal_pemberian',
        'catatan',
        'puskesmas_id',
        'posyandu_id',
    ];

    protected $casts = [
        'tanggal_pemberian' => 'date',
    ];

    /**
     * Get the child associated with this imunisasi.
     */
    public function anak(): BelongsTo
    {
        return $this->belongsTo(Anak::class, 'id_anak', 'id_anak');
    }

    /**
     * Get the bidan who administered this imunisasi.
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

