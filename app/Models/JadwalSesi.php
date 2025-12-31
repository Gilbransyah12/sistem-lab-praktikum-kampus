<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalSesi extends Model
{
    use HasFactory;

    protected $table = 'jadwal_sesi';

    protected $fillable = [
        'jadwal_id',
        'pertemuan_ke',
        'tanggal',
        'materi',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class);
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'sesi_id');
    }
}
