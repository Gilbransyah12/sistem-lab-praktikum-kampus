# 🧪 Lab Praktikum UMPAR

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/Vite-5.x-646CFF?style=for-the-badge&logo=vite&logoColor=white" alt="Vite">
</p>

<p align="center">
  <strong>Sistem Informasi Laboratorium Praktikum</strong><br>
  Universitas Muhammadiyah Parepare (UMPAR)
</p>

---

## 📋 Deskripsi

**Lab Praktikum UMPAR** adalah sistem informasi berbasis web yang dirancang untuk mengelola seluruh aktivitas praktikum di Universitas Muhammadiyah Parepare. Sistem ini menyediakan platform terintegrasi untuk pendaftaran praktikum online, manajemen jadwal, absensi digital, pengelolaan nilai, dan distribusi modul pembelajaran.

### 🎯 Tujuan Sistem
- Memudahkan mahasiswa dalam mendaftar praktikum secara online
- Mengotomatisasi pengelolaan jadwal dan ruangan laboratorium
- Menyediakan sistem absensi digital yang akurat
- Memfasilitasi instruktur dalam mengelola kelas dan penilaian
- Memberikan transparansi nilai dan progress praktikum kepada mahasiswa

---

## ✨ Fitur Utama

### 👨‍💼 Admin Dashboard
- **Manajemen Peserta** - CRUD data peserta dengan export Excel/PDF
- **Manajemen Instruktur** - Kelola data instruktur praktikum
- **Manajemen Praktikum** - Pengaturan mata praktikum
- **Manajemen Kelas** - Pembagian kelas praktikum
- **Manajemen Ruangan** - Data laboratorium/ruangan
- **Periode Pendaftaran** - Pengaturan periode pendaftaran praktikum
- **Jadwal Praktikum** - Penjadwalan dengan export PDF
- **Verifikasi Pendaftaran** - Approval pendaftaran mahasiswa
- **Laporan Absensi** - Monitoring kehadiran dengan export

### 👨‍🏫 Instruktur Dashboard
- **Dashboard Statistik** - Overview kelas yang diampu
- **Manajemen Absensi** - Input kehadiran per sesi
- **Manajemen Nilai** - Input dan edit nilai praktikum
- **Upload Modul** - Upload materi praktikum (PDF)

### 👨‍🎓 Mahasiswa Dashboard
- **Pendaftaran Online** - Daftar praktikum dengan upload KRS
- **Lihat Jadwal** - Jadwal praktikum yang diikuti
- **Kartu Kontrol** - Kartu kontrol digital dengan export PDF
- **Download Modul** - Akses materi praktikum
- **Monitoring Nilai** - Pantau nilai real-time
- **Sertifikat** - Akses sertifikat praktikum

---

## 🏗️ Arsitektur Sistem

### Tech Stack
| Layer | Teknologi |
|-------|-----------|
| **Backend** | Laravel 11.x (PHP 8.2+) |
| **Frontend** | Blade Templates + Vanilla CSS |
| **Build Tool** | Vite 5.x |
| **Database** | MySQL 8.0+ |
| **Icons** | Font Awesome 6.x |
| **Fonts** | Inter (Google Fonts) |

### Struktur Direktori
```
lab-umpar/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          # Controller untuk admin
│   │   │   ├── Auth/           # Authentication controllers
│   │   │   ├── Instruktur/     # Controller untuk instruktur
│   │   │   ├── Mahasiswa/      # Controller untuk mahasiswa
│   │   │   └── Peserta/        # Controller untuk peserta
│   │   └── Middleware/         # Custom middleware (role-based)
│   └── Models/                 # Eloquent models
├── database/
│   ├── migrations/             # Database migrations
│   └── seeders/                # Database seeders
├── resources/
│   ├── views/
│   │   ├── admin/              # Views untuk admin
│   │   ├── auth/               # Login & register views
│   │   ├── components/         # Reusable blade components
│   │   ├── instruktur/         # Views untuk instruktur
│   │   ├── layouts/            # Layout templates
│   │   └── mahasiswa/          # Views untuk mahasiswa
│   ├── css/                    # Stylesheets
│   └── js/                     # JavaScript files
├── routes/
│   ├── web.php                 # Main routes
│   ├── admin.php               # Admin routes
│   ├── instruktur.php          # Instruktur routes
│   └── mahasiswa.php           # Mahasiswa routes
└── public/                     # Public assets
```

### Database Schema (ERD)
```
┌─────────────┐     ┌─────────────────────┐     ┌─────────────┐
│    users    │────<│ pendaftaran_praktikum│>────│  praktikum  │
└─────────────┘     └─────────────────────┘     └─────────────┘
       │                      │                        │
       │                      │                        │
       ▼                      ▼                        ▼
┌─────────────┐         ┌─────────────┐         ┌─────────────┐
│   peserta   │         │   jadwal    │─────────│   ruangan   │
└─────────────┘         └─────────────┘         └─────────────┘
                              │
                              ▼
                        ┌─────────────┐
                        │ jadwal_sesi │
                        └─────────────┘
                              │
              ┌───────────────┼───────────────┐
              ▼               ▼               ▼
        ┌─────────────┐ ┌─────────────┐ ┌─────────────┐
        │   absensi   │ │    nilai    │ │    modul    │
        └─────────────┘ └─────────────┘ └─────────────┘
```

### Model & Relasi
| Model | Deskripsi |
|-------|-----------|
| `User` | User authentication dengan role (admin, instruktur, mahasiswa) |
| `Peserta` | Data peserta praktikum |
| `Praktikum` | Mata praktikum |
| `Kelas` | Kelas praktikum |
| `Ruangan` | Data laboratorium/ruangan |
| `PeriodePendaftaran` | Periode pendaftaran praktikum |
| `PendaftaranPraktikum` | Data pendaftaran mahasiswa |
| `Jadwal` | Jadwal praktikum |
| `JadwalSesi` | Sesi per jadwal praktikum |
| `Absensi` | Data kehadiran per sesi |
| `Nilai` | Nilai praktikum |
| `Modul` | Modul/materi praktikum |
| `Notifikasi` | Sistem notifikasi |
| `LogAktivitas` | Log aktivitas sistem |

---

## 🚀 Instalasi

### Prasyarat
- PHP >= 8.2
- Composer
- Node.js >= 18.x
- MySQL >= 8.0
- Git

### Langkah Instalasi

1. **Clone Repository**
   ```bash
   git clone https://github.com/Gilbransyah12/sistem-lab-praktikum-kampus.git
   cd sistem-lab-praktikum-kampus
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Setup Database**
   
   Edit file `.env` dan sesuaikan konfigurasi database:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=lab_umpar
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Jalankan Migrasi**
   ```bash
   php artisan migrate
   ```

6. **Build Assets**
   ```bash
   npm run build
   ```

7. **Jalankan Server**
   ```bash
   php artisan serve
   ```

8. Akses aplikasi di `http://localhost:8000`

---

## 👥 User Roles & Akses

| Role | Akses | Prefix URL |
|------|-------|------------|
| **Admin** | Full access ke seluruh sistem | `/admin/*` |
| **Instruktur** | Manajemen absensi, nilai, dan modul | `/instruktur/*` |
| **Mahasiswa** | Pendaftaran, jadwal, kartu kontrol | `/mahasiswa/*` |

### Default Credentials (Development)
| Role | Email | Password |
|------|-------|----------|
| Admin | admin@umpar.ac.id | password |
| Instruktur | instruktur@umpar.ac.id | password |
| Mahasiswa | (Register sendiri) | - |

---

## 📱 Screenshots

### Landing Page
- Modern design dengan animated gradient background
- Glassmorphism UI elements
- Responsive untuk mobile devices

### Dashboard Admin
- Statistik overview
- Quick actions menu
- Manajemen data komprehensif

### Dashboard Mahasiswa
- Status pendaftaran
- Jadwal praktikum
- Kartu kontrol digital

---

## 🔒 Keamanan

- **Authentication** - Laravel built-in authentication
- **Authorization** - Role-based middleware
- **CSRF Protection** - Token-based protection
- **Input Validation** - Server-side validation
- **File Upload Security** - Validasi tipe dan ukuran file

---

## 📝 API Routes

### Authentication
```
GET  /login              # Halaman login
POST /login              # Proses login
POST /logout             # Logout
GET  /register           # Halaman registrasi mahasiswa
POST /register           # Proses registrasi
```

### Admin Routes (`/admin`)
```
GET  /dashboard                    # Dashboard admin
GET  /peserta                      # List peserta
GET  /peserta/export               # Export Excel
GET  /peserta/export-pdf           # Export PDF
GET  /instruktur                   # List instruktur
GET  /praktikum                    # List praktikum
GET  /kelas                        # List kelas
GET  /ruangan                      # List ruangan
GET  /periode                      # List periode
GET  /jadwal                       # List jadwal
GET  /pendaftaran                  # List pendaftaran
GET  /absensi                      # Laporan absensi
```

### Mahasiswa Routes (`/mahasiswa`)
```
GET  /dashboard                    # Dashboard mahasiswa
GET  /pendaftaran                  # Riwayat pendaftaran
POST /pendaftaran                  # Submit pendaftaran
GET  /jadwal                       # Jadwal praktikum
GET  /kartu-kontrol                # Kartu kontrol
GET  /modul/{id}/download          # Download modul
```

---

## 🛠️ Development

### Development Server
```bash
# Terminal 1 - Laravel
php artisan serve

# Terminal 2 - Vite (Hot Reload)
npm run dev
```

### Database Seeder
```bash
php artisan db:seed
```

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

---

## 📄 Lisensi

Proyek ini dikembangkan untuk keperluan akademik dan pembelajaran di Universitas Muhammadiyah Parepare.

---

## 👨‍💻 Pengembang

**Gilbransyah**
- GitHub: [@Gilbransyah12](https://github.com/Gilbransyah12)

---

## 🤝 Kontribusi

Kontribusi sangat diterima! Silakan buat pull request atau buka issue untuk saran dan perbaikan.

1. Fork repository
2. Buat branch fitur (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

---

## 📞 Kontak

Jika ada pertanyaan atau masalah, silakan buka issue di repository ini atau hubungi pengembang.

---

<p align="center">
  Made with ❤️ for Universitas Muhammadiyah Parepare
</p>
