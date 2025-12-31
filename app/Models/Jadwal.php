<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'jadwal';

    protected $fillable = [
        'periode_id',
        'kelas_id',
        'ruangan_id',
        'instruktur_id',
        'praktikum_id',
        'mata_kuliah',
        'hari',
        'jam_mulai',
        'jam_selesai',
    ];

    public function periode()
    {
        return $this->belongsTo(PeriodePendaftaran::class, 'periode_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class);
    }

    public function instruktur()
    {
        return $this->belongsTo(User::class, 'instruktur_id');
    }

    public function praktikum()
    {
        return $this->belongsTo(Praktikum::class);
    }

    public function sesi()
    {
        return $this->hasMany(JadwalSesi::class);
    }

    public function modul()
    {
        return $this->hasMany(Modul::class);
    }
}
