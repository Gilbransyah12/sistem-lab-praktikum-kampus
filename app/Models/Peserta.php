<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    use HasFactory;

    protected $table = 'peserta';

    protected $fillable = [
        'user_id',
        'nim',
        'nama',
        'no_hp_wa',
        'kelas_id',
    ];

    /**
     * Get the user account for this peserta
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get kelas for peserta
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    /**
     * Get pendaftaran for peserta
     */
    public function pendaftaran()
    {
        return $this->hasMany(PendaftaranPraktikum::class);
    }
}

