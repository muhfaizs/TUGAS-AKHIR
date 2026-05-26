<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anak extends Model
{
    protected $table = 'tb_anak';
    protected $primaryKey = 'id_anak';

    protected $fillable = [
        'id_user',
        'nik_anak',
        'nama_anak',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'berat_lahir',
        'panjang_lahir',
        'nama_ayah',
        'nama_ibu',
        'catatan',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'berat_lahir' => 'float',
        'panjang_lahir' => 'float',
    ];

    /**
     * Get the parent user (Orang Tua).
     */
    public function orangTua()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    /**
     * Get the pengukuran records associated with the anak.
     */
    public function pengukuran()
    {
        return $this->hasMany(Pengukuran::class, 'id_anak', 'id_anak');
    }
}
