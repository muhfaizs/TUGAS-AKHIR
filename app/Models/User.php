<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The table associated with the model.
     */
    protected $table = 'tb_user';

    /**
     * The primary key for the model.
     */
    protected $primaryKey = 'id_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'password',
        'nama_lengkap',
        'nomor_kontak',
        'role',
        'nip_bidan',
        'id_posyandu_kader',
        'puskesmas_id',
        'posyandu_id',
        'kabupaten_id',
        'nik_ortu',
        'kode_instansi_dinkes',
        'hak_akses_master',
        'log_aktivitas',
        'is_active',
        'wilayah_kerja',
        'email',
        'foto_profil',
        'alamat_domisili',
    ];

    /**
     * Get the Kabupaten associated with the user.
     */
    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class, 'kabupaten_id');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'is_active' => 'boolean',
            'hak_akses_master' => 'array',
            'log_aktivitas' => 'array',
        ];
    }

    /**
     * Check if the user is a Super Admin.
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === 'super admin';
    }

    /**
     * Check if the user is a Bidan.
     */
    public function isBidan(): bool
    {
        return $this->role === 'bidan';
    }

    /**
     * Check if the user is an Orang Tua.
     */
    public function isOrangTua(): bool
    {
        return $this->role === 'orang tua';
    }

    /**
     * Check if the user is a Kader.
     */
    public function isKader(): bool
    {
        return $this->role === 'kader';
    }

    /**
     * Check if the user is Dinkes.
     */
    public function isDinkes(): bool
    {
        return $this->role === 'dinkes';
    }

    /**
     * Get the children associated with this user (if Orang Tua).
     */
    public function anak()
    {
        return $this->hasMany(Anak::class, 'id_user', 'id_user');
    }

    /**
     * Get the tindakan medis records associated with this bidan.
     */
    public function tindakanMedis()
    {
        return $this->hasMany(TindakanMedis::class, 'id_bidan', 'id_user');
    }

    /**
     * Get the imunisasi records associated with this bidan.
     */
    public function imunisasi()
    {
        return $this->hasMany(Imunisasi::class, 'id_bidan', 'id_user');
    }

    /**
     * Get the Puskesmas associated with the Bidan/Admin.
     */
    public function puskesmas()
    {
        return $this->belongsTo(Puskesmas::class, 'puskesmas_id');
    }

    /**
     * Get the Posyandu associated with the Kader.
     */
    public function posyandu()
    {
        return $this->belongsTo(Posyandu::class, 'posyandu_id');
    }
}
