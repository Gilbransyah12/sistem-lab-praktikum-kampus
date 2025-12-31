<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodePendaftaran extends Model
{
    use HasFactory;

    protected $table = 'periode_pendaftaran';

    protected $fillable = [
        'tahun_akademik',
        'semester',
        'praktikum_ke',
        'tanggal_awal',
        'tanggal_akhir',
        'is_aktif',
    ];

    protected $casts = [
        'tanggal_awal' => 'date',
        'tanggal_akhir' => 'date',
        'is_aktif' => 'boolean',
    ];

    public function pendaftaran()
    {
        return $this->hasMany(PendaftaranPraktikum::class, 'periode_id');
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'periode_id');
    }

    public function getPraktikumKeRomawiAttribute()
    {
        $number = $this->praktikum_ke;
        if (!$number) return '-';

        $map = [
            'M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400,
            'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40,
            'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1
        ];
        
        $returnValue = '';
        while ($number > 0) {
            foreach ($map as $roman => $int) {
                if ($number >= $int) {
                    $number -= $int;
                    $returnValue .= $roman;
                    break;
                }
            }
        }
        return $returnValue;
    }
}
