<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    protected $table = 'nilai';

    protected $fillable = [
        'pendaftaran_id',
        'praktikum_id',
        'nilai_akhir',
        'catatan',
    ];

    protected $casts = [
        'nilai_akhir' => 'decimal:2',
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(PendaftaranPraktikum::class, 'pendaftaran_id');
    }

    public function praktikum()
    {
        return $this->belongsTo(Praktikum::class);
    }
}
