<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Peserta;
use App\Models\Praktikum;
use App\Models\Kelas;
use App\Models\Ruangan;
use App\Models\PeriodePendaftaran;
use App\Models\Jadwal;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create default admin
        User::firstOrCreate(
            ['username' => 'admin'],
            [
                'nama' => 'Administrator',
                'email' => 'admin@lab.test',
                'password' => Hash::make('password'),
                'no_hp_wa' => '081234567890',
                'role' => 'admin',
            ]
        );

        // Create sample instruktur
        $instruktur = User::firstOrCreate(
            ['username' => 'instruktur1'],
            [
                'nama' => 'Instruktur Demo',
                'email' => 'instruktur@lab.test',
                'password' => Hash::make('password'),
                'no_hp_wa' => '081234567891',
                'role' => 'instruktur',
            ]
        );

        // Create sample peserta/mahasiswa
        // Note: These will be updated with kelas_id after kelas is created
        $peserta1 = Peserta::firstOrCreate(
            ['nim' => '2021001001'],
            [
                'nama' => 'Ahmad Fauzi',
                'no_hp_wa' => '081234567892',
            ]
        );

        $peserta2 = Peserta::firstOrCreate(
            ['nim' => '2021001002'],
            [
                'nama' => 'Siti Nurhaliza',
                'no_hp_wa' => '081234567893',
            ]
        );

        $peserta3 = Peserta::firstOrCreate(
            ['nim' => '2021001003'],
            [
                'nama' => 'Budi Santoso',
                'no_hp_wa' => '081234567894',
            ]
        );

        // ============================================
        // SAMPLE DATA: Praktikum, Kelas, Ruangan, dll
        // ============================================

        // Praktikum
        $praktikum1 = Praktikum::firstOrCreate(
            ['nama_praktikum' => 'Pemrograman Web'],
            ['praktikum_ke' => 1]
        );

        $praktikum2 = Praktikum::firstOrCreate(
            ['nama_praktikum' => 'Basis Data'],
            ['praktikum_ke' => 2]
        );

        $praktikum3 = Praktikum::firstOrCreate(
            ['nama_praktikum' => 'Jaringan Komputer'],
            ['praktikum_ke' => 3]
        );

        // Kelas
        $kelas1 = Kelas::firstOrCreate(
            ['nama_kelas' => 'TI-2A'],
            ['kode_kelas' => 'TI2A']
        );

        $kelas2 = Kelas::firstOrCreate(
            ['nama_kelas' => 'TI-2B'],
            ['kode_kelas' => 'TI2B']
        );

        $kelas3 = Kelas::firstOrCreate(
            ['nama_kelas' => 'TI-4A'],
            ['kode_kelas' => 'TI4A']
        );

        // Update peserta dengan kelas
        $peserta1->update(['kelas_id' => $kelas1->id]);
        $peserta2->update(['kelas_id' => $kelas2->id]);
        $peserta3->update(['kelas_id' => $kelas1->id]);

        // Ruangan
        $ruangan1 = Ruangan::firstOrCreate(
            ['nama_ruangan' => 'Lab Komputer 1'],
            ['kode_ruangan' => 'LK1', 'kapasitas' => 40, 'status' => 'aktif']
        );

        $ruangan2 = Ruangan::firstOrCreate(
            ['nama_ruangan' => 'Lab Komputer 2'],
            ['kode_ruangan' => 'LK2', 'kapasitas' => 35, 'status' => 'aktif']
        );

        $ruangan3 = Ruangan::firstOrCreate(
            ['nama_ruangan' => 'Lab Jaringan'],
            ['kode_ruangan' => 'LJ1', 'kapasitas' => 30, 'status' => 'aktif']
        );

        // Periode Pendaftaran
        $periode = PeriodePendaftaran::firstOrCreate(
            ['tahun_akademik' => '2024/2025', 'semester' => 'Ganjil'],
            [
                'tanggal_awal' => '2024-08-01',
                'tanggal_akhir' => '2025-01-31',
                'is_aktif' => true,
            ]
        );

        // Jadwal (ditugaskan ke Instruktur Demo)
        Jadwal::firstOrCreate(
            [
                'periode_id' => $periode->id,
                'praktikum_id' => $praktikum1->id,
                'kelas_id' => $kelas1->id,
            ],
            [
                'ruangan_id' => $ruangan1->id,
                'instruktur_id' => $instruktur->id,
                'hari' => 'Senin',
                'jam_mulai' => '08:00',
                'jam_selesai' => '10:00',
            ]
        );

        Jadwal::firstOrCreate(
            [
                'periode_id' => $periode->id,
                'praktikum_id' => $praktikum2->id,
                'kelas_id' => $kelas2->id,
            ],
            [
                'ruangan_id' => $ruangan2->id,
                'instruktur_id' => $instruktur->id,
                'hari' => 'Selasa',
                'jam_mulai' => '10:00',
                'jam_selesai' => '12:00',
            ]
        );

        Jadwal::firstOrCreate(
            [
                'periode_id' => $periode->id,
                'praktikum_id' => $praktikum3->id,
                'kelas_id' => $kelas3->id,
            ],
            [
                'ruangan_id' => $ruangan3->id,
                'instruktur_id' => $instruktur->id,
                'hari' => 'Rabu',
                'jam_mulai' => '13:00',
                'jam_selesai' => '15:00',
            ]
        );

        $this->command->info('');
        $this->command->info('=== DATA LOGIN ===');
        $this->command->info('');
        $this->command->info('Admin:       admin / password');
        $this->command->info('Instruktur:  instruktur1 / password');
        $this->command->info('');
        $this->command->info('Peserta (login dengan NIM):');
        $this->command->info('  - 2021001001 (Ahmad Fauzi)');
        $this->command->info('  - 2021001002 (Siti Nurhaliza)');
        $this->command->info('  - 2021001003 (Budi Santoso)');
        $this->command->info('');
        $this->command->info('=== DATA SAMPLE ===');
        $this->command->info('');
        $this->command->info('Praktikum: Pemrograman Web, Basis Data, Jaringan Komputer');
        $this->command->info('Kelas: TI-2A, TI-2B, TI-4A');
        $this->command->info('Ruangan: Lab Komputer 1, Lab Komputer 2, Lab Jaringan');
        $this->command->info('Jadwal: 3 jadwal ditugaskan ke Instruktur Demo');
        $this->command->info('');
        $this->command->info('');
        
        $this->call(PendaftaranDummySeeder::class);
    }
}


