# Dokumentasi Sistem Perpustakaan

## Daftar Isi
1. [Sekilas Sistem](#1-sekilas-sistem)
2. [Role Pengguna](#2-role-pengguna)
3. [Halaman Login & Register](#3-halaman-login--register)
4. [Role: Admin](#4-role-admin)
5. [Role: Anggota (Siswa/Guru/Kepala Sekolah)](#5-role-anggota-siswagurukepala-sekolah)
6. [Tabel Perbandingan Fitur](#6-tabel-perbandingan-fitur)

---

## 1. Sekilas Sistem

Sistem Perpustakaan Digital adalah aplikasi berbasis web untuk mengelola:
- Koleksi buku
- Data anggota perpustakaan
- Transaksi peminjaman dan pengembalian
- Denda keterlambatan
- Laporan dan statistik

Sistem menggunakan **Laravel** dengan autentikasi bawaan dan middleware role-based.

---

## 2. Role Pengguna

Sistem memiliki **dua role utama**:

| Role       | Keterangan                                                      |
|------------|-----------------------------------------------------------------|
| **Admin**  | Petugas perpustakaan yang mengelola seluruh data dan transaksi. |
| **Anggota**| Pengguna biasa (siswa, guru, kepala sekolah) yang meminjam buku.|

Role anggota dibagi menjadi tiga sub-tipe:
- `siswa`
- `guru`
- `kepala_sekolah`

### 2.1 Akun Demo untuk Login

Jalankan `php artisan db:seed` untuk mengisi data awal, lalu gunakan akun berikut:

| Role             | Username   | Password      | Dashboard                    |
|------------------|------------|---------------|------------------------------|
| Admin            | `admin`    | `password123` | `/admin/dashboard`           |
| Anggota (Siswa)  | `siswa1`   | `password123` | `/member/dashboard`          |
| Anggota (Guru)   | `guru1`    | `password123` | `/member/dashboard`          |
| Kepala Sekolah   | `kepsek1`  | `password123` | `/member/dashboard`          |

> **Catatan**: Semua akun di atas sudah disediakan di `Database\\Seeders\\UserSeeder.php`. Jalankan migrasi & seeder dengan perintah:
> ```
> php artisan migrate:fresh --seed
> ```

---

## 3. Halaman Login & Register

### 3.1 Login (`/login`)
- Input: **Username** dan **Password**
- Fitur: Remember me, toggle show/hide password, link lupa password, link register
- Menampilkan pesan error jika username atau password salah
- Setelah login, sistem mengarahkan ke dashboard sesuai role:
  - Admin → `/admin/dashboard`
  - Siswa/Guru/Kepala Sekolah → `/member/dashboard`

### 3.2 Register (`/register`)
- Input: **Nama Lengkap**, **Email**, **Password**, **Konfirmasi Password**
- Fitur: Toggle show/hide password di kedua field password
- Setelah register, user dapat login menggunakan username yang dibuat saat registrasi

### 3.3 Lupa Password (`/forgot-password`)
- Input: **Email**
- Sistem mengirim tautan reset password ke email
- Tombol kembali ke halaman login

### 3.4 Reset Password (`/reset-password/{token}`)
- Input: **Email**, **Password Baru**, **Konfirmasi Password Baru**
- Fitur: Toggle show/hide password di kedua field password

### 3.5 Konfirmasi Password (`/confirm-password`)
- Digunakan sebelum mengakses area sensitif
- Input: **Password**
- Fitur: Toggle show/hide password

### 3.6 Verifikasi Email (`/verify-email`)
- Muncul jika fitur verifikasi email diaktifkan
- Tombol kirim ulang email verifikasi

---

## 4. Role: Admin

Admin memiliki akses penuh ke seluruh fitur sistem.

### 4.1 Dashboard Admin (`/admin/dashboard`)
- Statistik: total buku, anggota aktif, peminjaman berjalan, denda
- Tabel peminjaman terbaru
- Daftar peminjaman yang perlu perhatian (terlambat)

### 4.2 Manajemen Buku (`/admin/buku`)
- CRUD data buku
- Kolom: judul, penulis, penerbit, tahun terbit, ISBN, kategori, jumlah tersedia, lokasi rak

### 4.3 Kategori Buku (`/admin/kategori`)
- CRUD kategori buku

### 4.4 Peminjaman (`/admin/peminjaman`)
- Mencatat peminjaman buku oleh anggota
- Menentukan tanggal pinjam dan jatuh tempo

### 4.5 Pengembalian (`/admin/pengembalian`)
- Mencatat pengembalian buku
- Sistem otomatis menghitung denda jika terlambat

### 4.6 Denda (`/admin/denda`)
- Melihat daftar denda
- Mengubah status pembayaran denda

### 4.7 Data Anggota (`/admin/anggota`)
- CRUD data anggota
- Kolom: nomor anggota, user terkait, jenis anggota, kelas, status, tanggal daftar

### 4.8 Laporan & Statistik (`/admin/laporan`)
- Laporan peminjaman, pengembalian, denda
- Ekspor data

---

## 5. Role: Anggota (Siswa/Guru/Kepala Sekolah)

Anggota hanya dapat mengakses halaman member.

### 5.1 Dashboard Member (`/member/dashboard`)

#### Tab: Home (default)
- Statistik pribadi: total pinjam, sedang dipinjam, terlambat, denda
- Daftar buku yang sedang dipinjam
- Info keanggotaan (nomor anggota, jenis, kelas, status)
- Notifikasi denda jika ada

#### Tab: Pinjam Buku (`?tab=pinjam`)
- Mencari buku berdasarkan judul atau penulis
- Melihat daftar buku tersedia
- Informasi detail buku (penerbit, tahun, ISBN, lokasi rak)
- Untuk meminjam, anggota harus menghubungi petugas perpustakaan

#### Tab: Buku Dipinjam (`?tab=aktif`)
- Daftar buku yang sedang dipinjam
- Informasi tanggal pinjam, jatuh tempo
- Peringatan jika terlambat atau mendekati jatuh tempo

#### Tab: Riwayat (`?tab=riwayat`)
- Riwayat peminjaman yang sudah dikembalikan
- Informasi denda yang pernah dibayar

#### Tab: Denda Saya (`?tab=denda`)
- Daftar denda yang belum lunas
- Informasi cara pembayaran (hubungi petugas)

---

## 6. Tabel Perbandingan Fitur

| Fitur                          | Admin | Anggota |
|--------------------------------|:-----:|:-------:|
| Dashboard dengan statistik     |   ✓   |    ✓    |
| Manajemen Buku (CRUD)          |   ✓   |    ✗    |
| Manajemen Kategori             |   ✓   |    ✗    |
| Manajemen Anggota              |   ✓   |    ✗    |
| Catat Peminjaman               |   ✓   |    ✗    |
| Catat Pengembalian             |   ✓   |    ✗    |
| Kelola Denda                   |   ✓   |    ✗    |
| Lihat Laporan & Statistik      |   ✓   |    ✗    |
| Cari & Lihat Buku Tersedia     |   ✓   |    ✓    |
| Lihat Buku Dipinjam Sendiri    |   ✗   |    ✓    |
| Lihat Riwayat Peminjaman       |   ✗   |    ✓    |
| Lihat Denda Sendiri            |   ✗   |    ✓    |
| Edit Profil                    |   ✓   |    ✓    |
| Logout                         |   ✓   |    ✓    |

---

## Catatan Teknis

- **Autentikasi**: Laravel Breeze / Fortify
- **Middleware Role**: `App\Http\Middleware\RoleMiddleware` dengan parameter `role:admin` atau `role:siswa,guru,kepala_sekolah`
- **Route Prefix**:
  - Admin: `/admin/*` dengan name prefix `admin.`
  - Member: `/member/*` dengan name prefix `member.`
- **Layout**:
  - Halaman publik (login/register): `layouts/guest.blade.php`
  - Halaman admin: `layouts/admin.blade.php`
  - Halaman member: `layouts/member.blade.php`