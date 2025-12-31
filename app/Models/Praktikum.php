<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Praktikum extends Model
{
    use HasFactory;

    protected $table = 'praktikum';

    protected $fillable = [
        'praktikum_ke',
        'nama_praktikum',
    ];

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class);
    }

    public function pendaftaran()
    {
        return $this->hasMany(PendaftaranPraktikum::class);
    }
}
