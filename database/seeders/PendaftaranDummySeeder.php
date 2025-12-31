<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\PeriodePendaftaran;
use App\Models\Praktikum;
use App\Models\Kelas;
use App\Models\PendaftaranPraktikum;
use Illuminate\Support\Facades\Hash;

class PendaftaranDummySeeder extends Seeder
{
    public function run()
    {
        // 1. Ensure Active Periode (Based on screenshot: 2025/2026 Ganjil is Active)
        $periode = PeriodePendaftaran::where('is_aktif', true)->first();
        if (!$periode) {
            $periode = PeriodePendaftaran::create([
                'tahun_akademik' => '2025/2026',
                'semester' => 'ganjil',
                'praktikum_ke' => 1,
                'tanggal_awal' => now()->subDays(10),
                'tanggal_akhir' => now()->addDays(20),
                'is_aktif' => true,
            ]);
        }

        // 2. Ensure Praktikum
        // Table only has: praktikum_ke, nama_praktikum
        $praktikum = Praktikum::firstOrCreate(
            ['nama_praktikum' => 'Pemrograman Web'],
            ['praktikum_ke' => '1'] 
        );

        // 3. Ensure Kelas
        // Table has: kode_kelas, nama_kelas. NO praktikum_id.
        $kelas = Kelas::firstOrCreate(
            ['kode_kelas' => 'A'],
            ['nama_kelas' => 'Kelas A']
        );

        // 4. Create Dummy Users and Pending Pendaftaran
        $students = [
            ['nama' => 'Budi Santoso', 'email' => 'budi02@mhs.com', 'nim' => 'D02125021'],
            ['nama' => 'Siti Aminah', 'email' => 'siti02@mhs.com', 'nim' => 'D02125022'],
            ['nama' => 'Rudi Hartono', 'email' => 'rudi02@mhs.com', 'nim' => 'D02125023'],
            ['nama' => 'Dewi Persik', 'email' => 'dewi02@mhs.com', 'nim' => 'D02125024'],
            ['nama' => 'Agus Setiawan', 'email' => 'agus02@mhs.com', 'nim' => 'D02125025'],
        ];

        foreach ($students as $student) {
            $user = User::firstOrCreate(
                ['email' => $student['email']],
                [
                    'nama' => $student['nama'],
                    'nim' => $student['nim'],
                    'password' => Hash::make('password'),
                    'role' => 'mahasiswa',
                ]
            );

            // Check if pendaftaran exists
            $exists = PendaftaranPraktikum::where('user_id', $user->id)
                ->where('praktikum_id', $praktikum->id)
                ->where('periode_id', $periode->id)
                ->exists();

            if (!$exists) {
                $pendaftaran = new PendaftaranPraktikum();
                $pendaftaran->user_id = $user->id;
                $pendaftaran->praktikum_id = $praktikum->id;
                $pendaftaran->kelas_id = $kelas->id;
                $pendaftaran->periode_id = $periode->id;
                $pendaftaran->tanggal_daftar = now();
                $pendaftaran->status = 'pending';
                $pendaftaran->save();
            }
        }
    }
}
