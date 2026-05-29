<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    use HasFactory;

    protected $table = 'tb_notifikasi';
    protected $primaryKey = 'id_notifikasi';
    protected $fillable = ['id_user', 'judul', 'pesan', 'wa_link', 'is_read'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
