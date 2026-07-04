Sistem Manajemen Perpustakaan Digital

Aplikasi manajemen perpustakaan berbasis web dengan Laravel, dilengkapi fitur pengelolaan buku, anggota, peminjaman, pengembalian, denda, dan laporan.

Fitur

- Multi Role User — Admin, Siswa, Guru, Kepala Sekolah
- Manajemen Buku — CRUD buku, kategori, dan lokasi rak
- Manajemen Anggota — Data anggota perpustakaan
- Peminjaman & Pengembalian — Transaksi peminjaman dengan detail
- Denda — Perhitungan denda otomatis
- Laporan & Statistik — Dashboard admin dan anggota
- UI Modern — Desain premium dengan Tailwind CSS + Lucide Icons

Instalasi

```bash
# 1. Clone repositori
git clone https://github.com/username/sistem-perpustakaan.git
cd sistem-perpustakaan

# 2. Install dependencies
composer install
npm install

# 3. Copy environment
cp .env.example .env
# Sesuaikan konfigurasi database di .env

# 4. Generate key
php artisan key:generate

# 5. Jalankan migrasi & seeder
php artisan migrate:fresh --seed

# 6. Build assets
npm run build

# 7. Jalankan server
php artisan serve
```

 Akses Demonstrasi

Setelah menjalankan `php artisan migrate:fresh --seed`, pengguna dapat mengakses aplikasi melalui mode demonstrasi yang telah disediakan oleh sistem.

> Catatan: Untuk keperluan demonstrasi dan pengujian fungsional, tombol demo tersedia pada halaman login sehingga pengguna dapat langsung mengakses dashboard tanpa melalui proses autentikasi yang lebih kompleks.

 Konfigurasi Database Hosting

Untuk deployment pada hosting InfinityFree, konfigurasi database yang digunakan dapat disesuaikan dengan data berikut:



Testing

```bash
# Jalankan semua test
php artisan test

# Atau test spesifik
php artisan test --filter=UserTest
```

 🛠️ Tech Stack

- Backend: Laravel 11
- Frontend: Tailwind CSS, Alpine.js, Lucide Icons
- Database: MySQL / SQLite
- Auth: Laravel Breeze

 📁 Struktur Direktori

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/       # Controller untuk admin
│   │   ├── Auth/        # Controller autentikasi
│   │   └── Member/      # Controller untuk anggota
│   └── Middleware/
│       └── RoleMiddleware.php  # Middleware role-based
├── Models/
│   ├── User.php
│   ├── Role.php
│   ├── Anggota.php
│   ├── Buku.php
│   ├── KategoriBuku.php
│   ├── Peminjaman.php
│   ├── DetailPeminjaman.php
│   ├── Denda.php
│   └── Notifikasi.php
└── ...
```

