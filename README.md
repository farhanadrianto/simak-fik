# SIMAK - Sistem Informasi Manajemen Akademik

Sistem informasi manajemen akademik berbasis web untuk mengelola seluruh aspek administrasi kampus, mulai dari akademik hingga manajemen data mahasiswa, dosen, dan mata kuliah dengan dukungan multi-peran (Admin, Dosen, Mahasiswa).

## Tentang Project

**SIMAK** adalah platform akademik yang dirancang untuk memudahkan institusi pendidikan dalam mengelola data akademik secara terpusat dan terintegrasi. Sistem ini menyediakan antarmuka yang user-friendly bagi ketiga aktor utama: admin, dosen, dan mahasiswa, dengan setiap peran memiliki fitur dan tanggung jawab spesifik sesuai kebutuhan akademik.

## Fitur

### 📚 Manajemen Akademik
- **Manajemen Mata Kuliah**: Admin dapat membuat, mengedit, menghapus, dan mencari mata kuliah dengan dukungan pencarian real-time
- **KRS (Kartu Rencana Studi)**: Mahasiswa dapat mengambil mata kuliah reguler (MKR) dan umum (MKU) dengan validasi SKS otomatis
- **Paket Semester**: Fitur ambil paket semester otomatis yang menyelamatkan jadwal bentrok untuk mahasiswa semester 2
- **Persetujuan KRS**: Dosen dapat menyetujui atau menolak KRS mahasiswa dengan status tracking
- **Laporan KRS**: Admin dapat melihat laporan status KRS berdasarkan kategori approval

### 👥 Multi-Role Management
- **Admin**: Manajemen penuh terhadap seluruh sistem, dashboard dengan statistik, dan laporan komprehensif
- **Dosen**: Dashboard profil, manajemen umpan balik per mahasiswa, dan persetujuan KRS mahasiswa
- **Mahasiswa**: Dashboard personal, pengambilan mata kuliah, manajemen profil, dan pengajuan umpan balik

### 🔐 Authentication & Authorization
- **Login Multi-Role**: Sistem login terpisah untuk Admin, Dosen, dan Mahasiswa
- **Session Management**: Manajemen sesi berbasis database dengan timeout otomatis
- **Role-Based Access Control**: Middleware CheckAdminRole untuk proteksi rute berdasarkan peran pengguna

### 📊 Dashboard & Statistik
- **Dashboard Admin**: Ringkasan total mahasiswa, dosen, mata kuliah, pengumuman, dan feedback dengan grafik mahasiswa per prodi dan feedback per prodi
- **Dashboard Dosen**: Informasi profil, program studi, dan statistik terkait feedback mahasiswa
- **Dashboard Mahasiswa**: Informasi semester, total SKS, dan akses ke semua fitur akademik

### 📢 Pengumuman & Feedback
- **Sistem Pengumuman**: Admin dapat membuat, mengedit, dan mengelola pengumuman akademik
- **Feedback System**: Mahasiswa dapat memberikan umpan balik terstruktur kepada dosen
- **Feedback Analytics**: Dosen dapat melihat feedback per kategori (tentang saya, prodi, pengajaran, fasilitas) dengan laporan terperinci

### 👤 Manajemen Profil
- **Profil Mahasiswa**: Edit data personal, upload foto profil, dan kelola informasi akademik
- **Profil Dosen**: Edit data dosen, upload foto, nomor WhatsApp, email kampus, dan alamat
- **Sistem Foto**: Upload file gambar dengan validasi tipe (JPG, PNG, WebP) dan ukuran maksimal 2MB

### 📋 Laporan & Analitik
- **Laporan Mahasiswa**: Data mahasiswa per program studi dengan visualisasi grafik
- **Laporan Feedback**: Analisis feedback berdasarkan program studi
- **Laporan KRS**: Status pengajuan KRS (menunggu, disetujui, ditolak) dengan statistik
- **Paket Semester**: Daftar paket kurikulum semester dengan informasi SKS dan jenis mata kuliah

### 🔍 Fitur Pendukung
- **Pencarian**: Fitur pencarian mata kuliah dan data lainnya dengan filter real-time
- **Validasi SKS Otomatis**: Sistem otomatis mengvalidasi total SKS per semester (maksimal 20 SKS untuk semester 1-2, maksimal 24 SKS untuk semester lanjutan)
- **Validasi Kapasitas Kelas**: Pemeriksaan otomatis ketersediaan tempat di setiap kelas
- **Responsive Design**: Desain responsif yang optimal di desktop dan perangkat mobile

## Teknologi

- **Backend**: Laravel 12.0 (PHP 8.2+)
- **Frontend**: Blade Template Engine, Tailwind CSS 4.0
- **Build Tool**: Vite 7.0.7 dengan Laravel Vite Plugin
- **Database**: SQLite (default), MySQL (production-ready)
- **CSS Framework**: Tailwind CSS 4.0 dengan plugin Vite
- **JavaScript**: Axios untuk HTTP requests, JavaScript vanilla untuk interaktivitas
- **Package Manager**: Composer (PHP), npm (Node.js)

## Struktur Project

```
simak_laravel/
├── app/                              # Kode aplikasi
│   ├── Http/
│   │   ├── Controllers/              # Business logic (Admin, Auth, Dosen, Mahasiswa, dll)
│   │   ├── Middleware/               # Custom middleware (CheckAdminRole)
│   │   └── Kernel.php                # Registrasi middleware & route groups
│   ├── Models/                       # Eloquent models (User, Matkul, KRS, Feedback, dll)
│   └── Providers/                    # Service providers
├── bootstrap/                        # Bootstrap aplikasi Laravel
├── config/                           # File konfigurasi (database, auth, cache, dll)
├── database/
│   ├── migrations/                   # Migrasi database schema
│   ├── seeders/                      # Database seeding
│   └── database.sqlite               # SQLite database (default)
├── public/                           # Root publik (index.php, assets, uploads)
│   └── uploads/profile/              # Folder penyimpanan foto profil pengguna
├── resources/
│   ├── views/                        # Blade template
│   │   ├── admin/                    # View admin (dashboard, matkul, pengumuman, laporan)
│   │   ├── mhs/                      # View mahasiswa (dashboard, feedback, mkr, mku, profile, krs)
│   │   ├── dosen/                    # View dosen (dashboard, profile, feedback, approve krs)
│   │   ├── auth/                     # View authentication (login)
│   │   └── layouts/                  # Template layout (header, sidebar, footer)
│   ├── css/                          # Stylesheet (app.css)
│   └── js/                           # JavaScript (app.js, bootstrap.js)
├── routes/
│   ├── web.php                       # Route definition (semua route aplikasi)
│   └── console.php                   # Console route
├── storage/                          # Penyimpanan file, cache, log
├── tests/                            # Unit & feature test
├── artisan                           # Laravel CLI command
├── composer.json                     # PHP dependencies & scripts
├── package.json                      # Node.js dependencies & scripts
├── vite.config.js                    # Konfigurasi Vite
├── phpunit.xml                       # Konfigurasi PHPUnit testing
└── .env.example                      # Template file environment
```

## Cara Menjalankan Project

### Prasyarat
- PHP 8.2 atau lebih tinggi
- Composer
- Node.js & npm
- Git

### Instalasi

1. **Clone Repository**
   ```bash
   git clone https://github.com/your-username/simak_laravel.git
   cd simak_laravel
   ```

2. **Install PHP Dependencies**
   ```bash
   composer install
   ```

3. **Install JavaScript Dependencies**
   ```bash
   npm install
   ```

4. **Setup Environment**
   ```bash
   cp .env.example .env
   ```

5. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

6. **Jalankan Migrasi Database**
   ```bash
   php artisan migrate
   ```

7. **Jalankan Development Server**
   Buka dua terminal:
   
   **Terminal 1** (Laravel Server):
   ```bash
   php artisan serve
   ```
   
   **Terminal 2** (Vite Dev Server):
   ```bash
   npm run dev
   ```

8. **Akses Aplikasi**
   Buka browser dan akses `http://localhost:8000`

## Arsitektur Sistem

### Alur Request
1. **Request Masuk** → Router (routes/web.php) menentukan controller dan method
2. **Middleware** → CheckAdminRole (jika diperlukan) memverifikasi akses berdasarkan role
3. **Controller** → Menangani business logic, query database, dan return view atau response
4. **Model** → Query database menggunakan Eloquent ORM (User, Matkul, KRS, dll)
5. **View** → Blade template render dengan data dari controller
6. **Response** → HTML dirender dan dikirim ke browser

### Sistem Autentikasi
- Menggunakan Laravel's built-in authentication
- Validasi login berdasarkan `npm` (mahasiswa), `nip` (dosen), atau `nik` (admin)
- Session disimpan di database untuk multi-device tracking
- Password di-hash menggunakan bcrypt dengan 12 rounds

### Role-Based Access Control
- **Admin**: Akses ke semua fitur manajemen via middleware CheckAdminRole
- **Dosen**: Akses dashboard, profil, feedback, dan persetujuan KRS
- **Mahasiswa**: Akses dashboard, pengambilan KRS, profil, dan feedback

### Database Schema
- **users**: Data login semua peran (admin, dosen, mahasiswa)
- **prodi**: Program studi
- **matkul**: Data mata kuliah dengan jadwal dan kapasitas
- **krs**: Kartu rencana studi dengan status approval
- **feedback**: Umpan balik mahasiswa kepada dosen
- **profile_dosen**: Data lengkap profil dosen
- **profile_mhs**: Data lengkap profil mahasiswa
- **pengumuman**: Pengumuman akademik
- **paket_semester**: Paket kurikulum per semester

## Tujuan Project

Proyek SIMAK dikembangkan dengan tujuan:

1. **Centralisasi Data Akademik**: Menyatukan data mahasiswa, dosen, mata kuliah, dan KRS dalam satu sistem terpusat
2. **Efisiensi Administrasi**: Mengurangi proses manual dalam manajemen akademik dan approval KRS
3. **Transparansi Akademik**: Memberikan mahasiswa dan dosen visibility penuh terhadap status akademik mereka
4. **Feedback System**: Memfasilitasi umpan balik akademik untuk continuous improvement
5. **Automated Scheduling**: Menyediakan fitur ambil paket semester otomatis yang menghindari jadwal bentrok
6. **Scalability**: Membangun fondasi yang scalable untuk pengembangan fitur akademik lebih lanjut

## Hal yang Dipelajari

Selama mengembangkan project SIMAK, beberapa konsep dan teknik penting yang dipelajari:

- **Multi-Role Authentication**: Implementasi sistem login dengan multiple roles dan session management
- **Authorization & Middleware**: Membuat custom middleware untuk proteksi rute berdasarkan peran pengguna
- **Database Design**: Merancang schema relasional untuk sistem akademik kompleks dengan relationships
- **Eloquent ORM**: Menggunakan Eloquent untuk query optimization dengan relationships dan aggregation
- **Blade Templating**: Template rendering dinamis dengan conditional logic dan loops
- **Form Handling**: Validasi form, mass assignment, dan handling file upload dengan Laravel
- **MVC Architecture**: Implementasi pola Model-View-Controller yang clean dan maintainable
- **Business Logic**: Logika validasi SKS, kapasitas kelas, dan conflict detection jadwal
- **Responsive Web Design**: Menggunakan Tailwind CSS untuk UI responsive di berbagai ukuran layar
- **Frontend-Backend Integration**: Komunikasi antara frontend dan backend dengan HTTP requests

## Lisensi

Proyek ini dibuat untuk keperluan pembelajaran dan portfolio pengembang. Silakan gunakan, modifikasi, dan kembangkan sesuai kebutuhan Anda.

---

**Dikembangkan dengan ❤️ menggunakan Laravel 12 dan Tailwind CSS**
