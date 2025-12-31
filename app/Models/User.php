<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'nim',
        'nama',
        'email',
        'password',
        'no_hp_wa',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

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

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is instruktur
     */
    public function isInstruktur(): bool
    {
        return $this->role === 'instruktur';
    }

    /**
     * Check if user is mahasiswa
     */
    public function isMahasiswa(): bool
    {
        return $this->role === 'mahasiswa';
    }

    /**
     * Get peserta record for this user (mahasiswa)
     */
    public function peserta()
    {
        return $this->hasOne(Peserta::class);
    }

    /**
     * Get pendaftaran for this user (mahasiswa)
     */
    public function pendaftaran()
    {
        return $this->hasMany(PendaftaranPraktikum::class);
    }

    /**
     * Get jadwal for instruktur
     */
    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'instruktur_id');
    }

    /**
     * Get notifikasi for user
     */
    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class);
    }

    /**
     * Get log aktivitas for user
     */
    public function logAktivitas()
    {
        return $this->hasMany(LogAktivitas::class);
    }
}

