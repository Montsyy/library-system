<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Library System

Sistem informasi perpustakaan berbasis Laravel untuk mengelola data buku, kategori, anggota, peminjaman, serta manajemen user dengan pembagian hak akses admin dan petugas.

## Fitur Utama

- Autentikasi pengguna
- Role akses:
  - Admin
  - Petugas
- Manajemen buku
- Manajemen kategori buku
- Manajemen anggota perpustakaan
- Transaksi peminjaman buku
- Pengembalian buku
- Dashboard utama
- Manajemen user (khusus admin)

## Teknologi yang Digunakan

- PHP 8.3
- Laravel 13
- MySQL
- Blade Templates
- Vite

## Persyaratan

Sebelum menjalankan aplikasi, pastikan perangkat Anda sudah terpasang:

- PHP 8.3+
- Composer
- MySQL / MariaDB
- Node.js dan npm
- Web browser

## Langkah Instalasi

1. Clone repository

```bash
git clone https://github.com/Montsyy/library-system.git
cd library-system
```

2. Install dependency PHP

```bash
composer install
```

3. Install dependency frontend

```bash
npm install
```

4. Salin file environment

```bash
copy .env.example .env
```

atau pada Linux/macOS:

```bash
cp .env.example .env
```

5. Generate application key

```bash
php artisan key:generate
```

6. Konfigurasi database

Buka file `.env` lalu sesuaikan pengaturan database Anda:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=library_system
DB_USERNAME=root
DB_PASSWORD=
```

7. Jalankan migrasi dan seeder

```bash
php artisan migrate --seed
```

8. Build asset frontend

```bash
npm run build
```

9. Jalankan aplikasi

```bash
php artisan serve
```

Aplikasi akan tersedia di:

```text
http://127.0.0.1:8000
```

## Akun Default

Seeder telah membuat akun default berikut:

### Admin
- Email: `admin@example.com`
- Password: `admin1234#`

### Petugas
- Email: `petugas@example.com`
- Password: `petugas1234#`

## Struktur Aplikasi

- `app/Http/Controllers` → logika controller
- `app/Models` → model aplikasi
- `resources/views` → tampilan Blade
- `routes/web.php` → route aplikasi
- `database/migrations` → struktur database
- `database/seeders` → data awal aplikasi

## Role Akses

- Admin:
  - dapat mengelola user
  - dapat mengelola kategori
  - dapat mengelola buku
  - dapat mengelola anggota
  - dapat melihat semua peminjaman

- Petugas:
  - dapat mengelola buku
  - dapat mengelola anggota
  - dapat mengelola peminjaman
  - tidak dapat mengelola user atau kategori

## Developer

- Nama: DHAFI PUTRA ALFAREZI
- NPM: 2410631250008
- Kelas: 5A Sistem Informasi

## Catatan

Project ini merupakan sistem perpustakaan sederhana yang fokus pada proses pengelolaan data buku dan transaksi peminjaman. Jika Anda ingin dikembangkan lebih lanjut, fitur yang dapat ditambahkan antara lain:

- riwayat peminjaman per user
- laporan statistik
- export PDF/Excel
- upload cover buku
- notifikasi pengembalian