<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftaranPraktikum extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran_praktikum';

    protected $fillable = [
        'user_id',
        'peserta_id',
        'kelas_id',
        'praktikum_id',
        'periode_id',
        'tanggal_daftar',
        'kartu_kontrol_path',
        'krs_path',
        'berkas_path',
        'status',
    ];

    protected $casts = [
        'tanggal_daftar' => 'date',
    ];

    /**
     * Accessor for NIM from related Peserta
     */
    public function getNimAttribute()
    {
        return $this->peserta?->nim;
    }

    /**
     * Accessor for Nama from related Peserta
     */
    public function getNamaAttribute()
    {
        return $this->peserta?->nama;
    }

    /**
     * Accessor for No HP/WA from related Peserta
     */
    public function getNoHpWaAttribute()
    {
        return $this->peserta?->no_hp_wa;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function praktikum()
    {
        return $this->belongsTo(Praktikum::class);
    }

    public function periode()
    {
        return $this->belongsTo(PeriodePendaftaran::class, 'periode_id');
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'pendaftaran_id');
    }

    public function nilai()
    {
        return $this->hasOne(Nilai::class, 'pendaftaran_id');
    }

    public function jadwal()
    {
        return $this->hasOneThrough(
            Jadwal::class,
            Kelas::class,
            'id',
            'kelas_id',
            'kelas_id',
            'id'
        );
    }
}
