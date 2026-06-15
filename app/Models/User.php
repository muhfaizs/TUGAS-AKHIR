<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'username', 'nik', 'password', 'role', 'status', 'phone', 'address', 'puskesmas_id', 'profile_photo_path'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function hasRole(string|array $role): bool
    {
        if (is_array($role)) {
            return in_array($this->role, $role);
        }
        return $this->role === $role;
    }

    public function isAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isBidan(): bool
    {
        return $this->role === 'bidan';
    }

    public function isUptKb(): bool
    {
        return $this->role === 'upt_kb';
    }

    public function kbAcceptor(): HasOne
    {
        return $this->hasOne(KBAcceptor::class);
    }

    public function puskesmas(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Puskesmas::class);
    }

    public function kbServices(): HasMany
    {
        return $this->hasMany(KBService::class, 'created_by');
    }

    public function registeredAcceptors(): HasMany
    {
        return $this->hasMany(KBAcceptor::class, 'registered_by');
    }
}
