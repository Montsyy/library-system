<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Library System

## Description
Simple Library Information System

## Requirements
- PHP
- Composer
- MySQL
- Laravel

## Installation
1. Buat Proyek Baru

Jalankan perintah `create-project` untuk mengunduh kerangka kerja Laravel dan seluruh dependensinya secara otomatis:

```bash
composer create-project laravel/laravel nama-proyek
```

2. Masuk ke Direktori Proyek

Pindahkan direktori kerja terminal ke dalam folder proyek yang baru dibuat:

```bash
cd nama-proyek
```

3. Konfigurasi Lingkungan (.env)

Proses instalasi Composer biasanya otomatis menduplikasi berkas `.env.example` menjadi `.env` serta membuat application key. Jika berkas `.env` belum tersedia atau kunci aplikasi belum terpasang, jalankan:

```bash
cp .env.example .env
php artisan key:generate
```

Buka berkas `.env` untuk menyesuaikan koneksi database (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`) sesuai kebutuhan sistem lokal.

4. Jalankan Server Pengembangan

Nyalakan server lokal bawaan Laravel:

```bash
php artisan serve
```

Aplikasi siap diakses melalui browser di alamat http://127.0.0.1:8000.

## Clone Repository

```bash
git clone https://github.com/Montsyy/library-system.git
```

## Author
Nama    : DHAFI PUTRA ALFAREZI
NPM     : 2410631250008
KELAS   : 5A SISTEM INFORMASI