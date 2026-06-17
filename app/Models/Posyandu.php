<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Posyandu extends Model
{
    //
    protected $fillable = ['puskesmas_id', 'nama_posyandu'];

    public function puskesmas()
    {
        return $this->belongsTo(Puskesmas::class, 'puskesmas_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'posyandu_id');
    }

    public function jadwalPosyandus()
    {
        return $this->hasMany(JadwalPosyandu::class, 'posyandu_id');
    }
}
