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
        'no_bpjs',
        'nama_anak',
        'anak_ke',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'golongan_darah',
        'berat_lahir',
        'panjang_lahir',
        'lingkar_kepala_lahir',
        'kondisi_lahir',
        'nama_ayah',
        'nama_ibu',
        'catatan',
        'riwayat_alergi',
        'alamat_domisili',
        'nomor_kontak_darurat',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'berat_lahir' => 'float',
        'panjang_lahir' => 'float',
        'lingkar_kepala_lahir' => 'float',
        'anak_ke' => 'integer',
    ];

    /**
     * Get the parent user (Orang Tua).
     */
    public function orangTua()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    /**
     * Get the pengukuran records associated with the anak.
     */
    public function pengukuran()
    {
        return $this->hasMany(Pengukuran::class, 'id_anak', 'id_anak');
    }

    /**
     * Get the latest pengukuran record.
     */
    public function latestPengukuran()
    {
        return $this->hasOne(Pengukuran::class, 'id_anak', 'id_anak')->latestOfMany('tanggal_pengukuran');
    }

    /**
     * Get the tindakan medis records associated with the anak.
     */
    public function tindakanMedis()
    {
        return $this->hasMany(TindakanMedis::class, 'id_anak', 'id_anak');
    }

    /**
     * Get the imunisasi records associated with the anak.
     */
    public function imunisasi()
    {
        return $this->hasMany(Imunisasi::class, 'id_anak', 'id_anak');
    }
}

