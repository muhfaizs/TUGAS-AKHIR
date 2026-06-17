<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Puskesmas extends Model
{
    //
    protected $fillable = ['kabupaten_id', 'nama_puskesmas'];

    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class, 'kabupaten_id');
    }

    public function posyandus()
    {
        return $this->hasMany(Posyandu::class, 'puskesmas_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'puskesmas_id');
    }
}
