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
        'nik_ortu',
        'kode_instansi_dinkes',
        'hak_akses_master',
        'log_aktivitas',
        'is_active',
        'wilayah_kerja',
        'email',
    ];

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
     * Get the children associated with this user (if Orang Tua).
     */
    public function anak()
    {
        return $this->hasMany(Anak::class, 'id_user', 'id_user');
    }
}
