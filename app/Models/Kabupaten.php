<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kabupaten extends Model
{
    //
    protected $fillable = ['nama_kabupaten'];

    public function puskesmas()
    {
        return $this->hasMany(Puskesmas::class, 'kabupaten_id');
    }
}
