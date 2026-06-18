<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'phone', 'role', 'nik', 'nip', 'status', 'username', 'address', 'puskesmas_id', 'profile_photo_path', 'id_posyandu_kader', 'posyandu_id', 'kabupaten_id', 'kode_instansi_dinkes', 'hak_akses_master', 'log_aktivitas', 'wilayah_kerja'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Accessor to maintain backward compatibility with old KB code
     * that references $user->id_user.
     */
    public function getIdUserAttribute()
    {
        return $this->id;
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'hak_akses_master' => 'array',
            'log_aktivitas' => 'array',
        ];
    }

    /**
     * Check if the user is the Super Administrator (IbuHamil logic).
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === 'bidan' && $this->email === 'admin@satukia.com' || $this->role === 'super_admin';
    }

    /**
     * Check if the user is a regular Bidan (not Super Admin).
     */
    public function isBidanOnly(): bool
    {
        return $this->role === 'bidan' && $this->email !== 'admin@satukia.com';
    }

    /**
     * Check if the user is a Bidan.
     */
    public function isBidan(): bool
    {
        return $this->role === 'bidan';
    }

    /**
     * Check if the user is a Parent (Orang Tua).
     */
    public function isOrtu(): bool
    {
        return $this->role === 'ortu' || $this->role === 'patient';
    }

    public function isOrangTua(): bool
    {
        return $this->isOrtu();
    }

    /**
     * Check if the user is a Pregnant Mother.
     */
    public function isIbuHamil(): bool
    {
        return $this->role === 'ibu_hamil';
    }

    /**
     * Check if the user is a KB Patient.
     */
    public function isPasienKb(): bool
    {
        return $this->role === 'pasien_kb';
    }

    /**
     * Check if the user is Dinkes.
     */
    public function isDinkes(): bool
    {
        return $this->role === 'dinkes' || $this->role === 'dinas_kesehatan';
    }

    public function isAdmin(): bool
    {
        return $this->isSuperAdmin();
    }

    public function isUptKb(): bool
    {
        return $this->role === 'upt_kb';
    }

    public function isKader(): bool
    {
        return $this->role === 'kader';
    }

    public function hasRole(string|array $role): bool
    {
        if (is_array($role)) {
            return in_array($this->role, $role);
        }

        return $this->role === $role;
    }

    // --- Relationships ---

    public function kbAcceptor(): HasOne
    {
        return $this->hasOne(KBAcceptor::class, 'user_id', 'id');
    }

    public function puskesmas(): BelongsTo
    {
        return $this->belongsTo(Puskesmas::class, 'puskesmas_id', 'id');
    }

    public function kbServices(): HasMany
    {
        return $this->hasMany(KBService::class, 'created_by', 'id');
    }

    public function registeredAcceptors(): HasMany
    {
        return $this->hasMany(KBAcceptor::class, 'registered_by', 'id');
    }

    public function kabupaten(): BelongsTo
    {
        return $this->belongsTo(Kabupaten::class, 'kabupaten_id', 'id');
    }

    public function anak(): HasMany
    {
        // Foreign key in anak is 'id_user', pointing to 'id'
        return $this->hasMany(Anak::class, 'id_user', 'id');
    }

    public function tindakanMedis(): HasMany
    {
        return $this->hasMany(TindakanMedis::class, 'id_bidan', 'id');
    }

    public function imunisasi(): HasMany
    {
        return $this->hasMany(Imunisasi::class, 'id_bidan', 'id');
    }

    public function posyandu(): BelongsTo
    {
        return $this->belongsTo(Posyandu::class, 'posyandu_id', 'id');
    }
}
