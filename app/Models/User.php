<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'phone', 'role', 'nik', 'nip', 'status'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Check if the user is the Super Administrator.
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === 'bidan' && $this->email === 'admin@satukia.com';
    }

    /**
     * Check if the user is a regular Bidan (not Super Admin).
     */
    public function isBidanOnly(): bool
    {
        return $this->role === 'bidan' && $this->email !== 'admin@satukia.com';
    }

    /**
     * Check if the user is a Bidan (either Super Admin or regular Bidan).
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
        return $this->role === 'ortu';
    }

    /**
     * Check if the user is Dinkes.
     */
    public function isDinkes(): bool
    {
        return $this->role === 'dinkes';
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
        ];
    }
}
