<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sertifikat extends Model
{
    use HasFactory;

    protected $table = 'sertifikat';

    protected $fillable = [
        'pendaftaran_id',
        'kode_unik',
        'tanggal_terbit',
        'file_path',
        'status',
    ];

    protected $casts = [
        'tanggal_terbit' => 'date',
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(PendaftaranPraktikum::class, 'pendaftaran_id');
    }
}
