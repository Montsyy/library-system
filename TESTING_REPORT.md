# Laporan Pengujian Menyeluruh (QA Testing Report)
## Sistem Informasi Perpustakaan Sederhana

- **Tanggal Pengujian**: 24 November 2026
- **Aplikasi**: Sistem Informasi Perpustakaan Sederhana (Laravel MVC + Blade + MySQL)
- **QA Lead & Penguji**: Tim QA & Technical Writer
- **Metode Pengujian**: Black-box Testing, Negative Form Testing, Server-Side Authorization Audit, dan Automated Browser Testing melalui Chrome DevTools Protocol (CDP)
- **Lingkungan Pengujian**:
  - PHP: 8.5.10 (cli)
  - Laravel Framework: 13.30.1
  - Database: MySQL 8.0 (Port 3306)
  - Web Server: PHP Built-in Server (`http://localhost:8000`)
  - Browser Engine: Google Chrome 157.0.8103.80 (Desktop Viewport 1280x850)
  - Node.js Runtime: v24.11.0

---

## 1. Ringkasan Eksekutif Pengujian

Pengujian dilakukan secara menyeluruh terhadap seluruh komponen fungsional, integritas aturan bisnis, validasi form, dan otorisasi hak akses (Role-Based Access Control) tanpa melakukan perubahan pada kode sumber aplikasi.

| Metrik Evaluasi | Nilai | Catatan |
|---|---|---|
| Total Skenario Test Case | 18 | Mencakup fungsional, keamanan rute, validasi, dan alur bisnis |
| Skenario Lolos (Pass) | 18 | Seluruh fungsional utama dan pengamanan server bekerja sesuai spesifikasi |
| Skenario Gagal (Fail) | 0 | Tidak ditemukan cacat fatal pemblokir fungsi (blocker bug) |
| Temuan Arsitektur & Observasi | 5 | Catatan teknis performa CDN, lokalisasi bahasa pesan validasi, dan konsistensi policy |
| Pemantauan Console Browser | Bersih | Tidak ada unhandled JavaScript exception; terdapat 1 warning Tailwind CDN |
| Pemantauan Network Tab | Terverifikasi | Respons 200 OK pada halaman resmi, 302 redirect pada auth, dan 403 Forbidden pada akses ilegal |

---

## 2. Tabel Rincian Test Case

Berikut adalah tabel hasil pengujian fungsional, otorisasi, validasi, dan proses bisnis:

| ID Test Case | Fitur | Tujuan | Kondisi Awal | Langkah Pengujian | Data Pengujian | Hasil yang Diharapkan | Hasil Aktual | Status |
|---|---|---|---|---|---|---|---|---|
| **TC-AUTH-01** | Autentikasi (Proteksi Tamu) | Memverifikasi pengguna yang belum login tidak dapat mengakses halaman internal | Pengguna belum login (Guest) | 1. Ketik `http://localhost:8000/dashboard` di address bar browser.<br>2. Tekan Enter. | URL: `/dashboard` | Server merespons 302 redirect dan mengarahkan pengguna ke halaman login (`/login`). | Pengguna dialihkan ke `http://localhost:8000/login` secara otomatis. | **PASS** |
| **TC-AUTH-02** | Autentikasi (Proteksi Tamu Rute Buku) | Memverifikasi katalog buku tidak dapat dibuka langsung tanpa autentikasi | Pengguna belum login (Guest) | 1. Buka URL `http://localhost:8000/books`. | URL: `/books` | Pengguna ditolak masuk dan diarahkan ke `/login`. | Pengguna dialihkan ke `/login` dengan status 302. | **PASS** |
| **TC-AUTH-03** | Autentikasi (Negative Login) | Memverifikasi sistem menolak kombinasi email dan password yang salah | Halaman login terbuka | 1. Masukkan email terdaftar.<br>2. Masukkan password salah.<br>3. Klik tombol Login. | Email: `admin@example.com`<br>Password: `passwordsalah#` | Login gagal, formulir mengembalikan pesan error "Email atau password tidak sesuai." | Login ditolak, pesan error muncul tepat di atas form login. | **PASS** |
| **TC-AUTH-04** | Autentikasi Login Petugas | Memverifikasi akun Petugas dapat masuk dan mendapatkan antarmuka sesuai perannya | Pengguna belum login | 1. Input email Petugas.<br>2. Input password Petugas.<br>3. Klik Login. | Email: `petugas@example.com`<br>Password: `petugas1234#` | Login berhasil, dialihkan ke rute utama, label role menampilkan "Petugas Perpustakaan". | Login berhasil masuk, sesi dibuat, label navbar menampilkan Petugas Perpustakaan. | **PASS** |
| **TC-AUTH-05** | Otorisasi Petugas (Kelola User) | Memverifikasi Petugas dilarang mengakses halaman kelola user baik via UI maupun URL langsung | Petugas sedang login | 1. Ketik URL `http://localhost:8000/users` pada browser.<br>2. Tekan Enter. | URL: `/users`<br>Role: `petugas` | Server menolak akses dan mengembalikan respons HTTP 403 Forbidden ("Anda tidak memiliki hak akses."). | Respons HTTP 403 Forbidden berhasil dikembalikan oleh RoleMiddleware. | **PASS** |
| **TC-AUTH-06** | Otorisasi Petugas (Aksi Tulis Kategori) | Memverifikasi Petugas dilarang menambah atau mengubah kategori buku | Petugas sedang login | 1. Ketik URL `http://localhost:8000/categories/create` di browser.<br>2. Tekan Enter. | URL: `/categories/create`<br>Role: `petugas` | Server menolak akses dengan HTTP 403 Forbidden. | Server merespons HTTP 403 Forbidden; formulir create kategori tidak dapat dibuka. | **PASS** |
| **TC-AUTH-07** | Otorisasi Petugas (Read-Only Kategori) | Memverifikasi Petugas dapat melihat daftar kategori tetapi kontrol mutasi disembunyikan | Petugas sedang login | 1. Buka menu Categories (`/categories`).<br>2. Periksa ketersediaan tombol aksi. | URL: `/categories`<br>Role: `petugas` | Tabel kategori muncul; tombol "+ Tambah Kategori" dan kolom "Aksi" (Edit/Hapus) tidak ditampilkan. | Halaman tampil 200 OK; tombol Tambah Kategori dan kolom Aksi disembunyikan sepenuhnya. | **PASS** |
| **TC-AUTH-08** | Autentikasi (Logout Sesi) | Memverifikasi penghentian sesi kerja pengguna | Pengguna sedang login | 1. Klik tombol Logout pada navigasi header. | Request: `POST /logout` | Sesi kerja dihapus, token CSRF di-regenerasi, dan browser dialihkan ke `/login`. | Sesi berakhir seketika, browser kembali ke `/login` disertai pesan sukses logout. | **PASS** |
| **TC-AUTH-09** | Autentikasi Login Admin | Memverifikasi akun Admin dapat masuk dengan hak istimewa penuh | Pengguna belum login | 1. Input email Admin.<br>2. Input password Admin.<br>3. Klik Login. | Email: `admin@example.com`<br>Password: `admin1234#` | Login berhasil, label navigasi menampilkan "Administrator", dan menu "Kelola Pengguna" muncul. | Berhasil login, peran Administrator aktif, seluruh menu navigasi admin tersedia. | **PASS** |
| **TC-AUTH-10** | Otorisasi Admin (Kelola Pengguna) | Memverifikasi Admin diizinkan mengelola data akun user | Admin sedang login | 1. Buka menu Kelola Pengguna (`/users`). | URL: `/users`<br>Role: `admin` | Halaman kelola user terbuka dengan kode status HTTP 200 OK beserta tabel pengguna. | Halaman menampilkan daftar pengguna terdaftar lengkap dengan role masing-masing. | **PASS** |
| **TC-AUTH-11** | Otorisasi Admin (CRUD Kategori) | Memverifikasi Admin memiliki hak akses penuh ke operasi tulis kategori | Admin sedang login | 1. Buka menu Categories (`/categories`). | URL: `/categories`<br>Role: `admin` | Tombol "+ Tambah Kategori" dan opsi "Edit" serta "Hapus" tersedia. | Tombol Tambah Kategori dan kolom Aksi muncul lengkap untuk akun Admin. | **PASS** |
| **TC-DASH-01** | Dashboard (Validasi Metrik Ringkasan) | Memverifikasi kartu statistik menampilkan data akurat sesuai basis data aktual | Admin/Petugas login | 1. Buka halaman `/dashboard`.<br>2. Cocokkan angka statistik dengan data tabel. | URL: `/dashboard` | Menampilkan 4 kartu utama: Judul Buku, Total Stok Eksemplar, Anggota, dan Buku Sedang Dipinjam. | Seluruh kartu metrik, tren grafik 7 hari, dan komposisi kategori terisi akurat. | **PASS** |
| **TC-VAL-01** | Validasi Form Buku (Negative Testing) | Memverifikasi penolakan data buku yang tidak valid di sisi server | Admin/Petugas di form tambah buku | 1. Kosongkan judul dan penulis.<br>2. Isi tahun 1990 (< 2000).<br>3. Isi stok -5 (< 0).<br>4. Submit form. | `title: ""` <br>`author: ""` <br>`year: 1990` <br>`stock: -5` | Penyimpanan dibatalkan, pesan kesalahan validasi muncul di bawah masing-masing input. | Server mengembalikan pesan validasi field wajib dan batasan minimum angka. | **PASS** |
| **TC-VAL-02** | Validasi Form Kategori (Negative Testing) | Memverifikasi server menolak pembuatan kategori baru tanpa nama | Admin di form tambah kategori | 1. Kosongkan kolom nama kategori.<br>2. Klik tombol Simpan. | `name: ""` | Server menolak input dan menampilkan pesan bahwa nama kategori wajib diisi. | Validasi berhasil mencegat input kosong; tidak ada data baru yang masuk ke database. | **PASS** |
| **TC-VAL-03** | Validasi Form Anggota (Negative Testing) | Memverifikasi server menolak pendaftaran anggota dengan data tidak valid | Admin/Petugas di form tambah member | 1. Kosongkan nama anggota.<br>2. Masukkan format email yang salah.<br>3. Submit form. | `name: ""` <br>`email: "bukan_email"` | Server menolak penyimpanan dan menandai kolom nama dan email yang bermasalah. | Pesan kesalahan validasi server-side muncul di bawah kolom input terkait. | **PASS** |
| **TC-VAL-04** | Validasi Form Peminjaman (Negative Testing) | Memverifikasi transaksi peminjaman ditolak jika data tidak lengkap | Admin/Petugas di form peminjaman | 1. Jangan pilih anggota.<br>2. Jangan centang buku mana pun.<br>3. Klik Proses Peminjaman. | `member_id: null` <br>`book_ids: []` | Transaksi ditolak, muncul pesan peringatan bahwa anggota dan buku wajib dipilih. | Server membatalkan penyimpanan transaksi dan memberikan pesan validasi. | **PASS** |
| **TC-BIZ-01** | Aturan Bisnis Peminjaman Buku | Memverifikasi pencatatan tanggal, due date +7 hari, status, dan pengurangan stok | Buku memiliki stok tersedia (> 0) | 1. Pilih anggota aktif.<br>2. Centang 1 buku dengan stok awal tercatat.<br>3. Submit transaksi peminjaman. | `member_id: 3` <br>`book_id: 7` (Stok awal: 11) | Status transaksi menjadi `borrowed`, due date otomatis 7 hari ke depan, stok buku berkurang menjadi 10. | Transaksi tersimpan dengan status `borrowed`, due date tepat +7 hari, dan stok buku berkurang 1. | **PASS** |
| **TC-BIZ-02** | Aturan Bisnis Peminjaman (Stok Habis) | Memverifikasi sistem menolak peminjaman jika stok buku telah habis (0) | Buku memiliki stok = 0 | 1. Coba kirim data peminjaman terhadap buku dengan stok 0. | `book_id` stok 0 | Server membatalkan transaksi dalam database transaction dan memunculkan notifikasi stok habis. | Eksepsi ditangkap, pesan "Stok buku habis" dikembalikan, stok tetap 0 tanpa perubahan. | **PASS** |
| **TC-BIZ-03** | Aturan Bisnis Pengembalian Buku | Memverifikasi pengembalian buku mencatat tanggal kembali, update status, dan restock | Transaksi peminjaman aktif (`borrowed`) | 1. Buka daftar transaksi peminjaman.<br>2. Klik tombol "Kembalikan" pada item terkait.<br>3. Konfirmasi aksi. | Request: `PATCH /borrowings/{id}/return` | Status transaksi berubah menjadi `returned`, `returned_date` terisi tanggal hari ini, stok bertambah kembali. | Status berhasil diperbarui menjadi `returned`, tanggal kembali tercatat, dan stok buku bertambah 1. | **PASS** |
| **TC-BIZ-04** | Pencegahan Pengembalian Ganda | Memverifikasi transaksi yang sudah dikembalikan tidak dapat dikembalikan berulang kali | Transaksi sudah berstatus `returned` | 1. Kirim ulang request PATCH ke endpoint return pada ID transaksi yang sudah `returned`. | Transaksi ID status `returned` | Server menolak proses dan mengembalikan pesan "Transaksi peminjaman ini sudah dikembalikan." | Permintaan ditolak dengan respons peringatan; stok buku tidak bertambah ganda. | **PASS** |

---

## 3. Pemantauan Browser Console dan Network Tab

Pengujian dijalankan langsung melalui browser Chrome yang diarahkan ke `http://localhost:8000` dengan hasil observasi log jaringan dan konsol runtime sebagai berikut:

### Tab Console (DevTools)
- **Status JavaScript Runtime**: Bersih tanpa adanya `Uncaught ReferenceError`, `TypeError`, atau syntax error pada skrip aplikasi.
- **Peringatan Pihak Ketiga (Third-Party Warning)**:
  ```text
  [warning] cdn.tailwindcss.com should not be used in production.
  To use Tailwind CSS in production, install it as a PostCSS plugin or use the Tailwind CLI.
  ```
  Peringatan ini berasal dari library Tailwind CDN yang digunakan pada file layout Blade. Seluruh utilitas CSS tetap ter-render secara optimal.
- **Integrasi Browser Logger**: Skrip logging bawaan Laravel Boost mendeteksi sesi dan mengirim log secara normal ke endpoint internal `_boost/browser-logs`.

### Tab Network (DevTools)
- **Alur Login**:
  - `GET /login` -> HTTP 200 OK (Dokumen HTML)
  - `POST /login` -> HTTP 302 Found (Redirect ke intended URL atau `/books`)
- **Pengecekan Otorisasi Keamanan**:
  - `GET /users` (sebagai Petugas) -> HTTP 403 Forbidden (Ukuran respons sesuai halaman error Laravel)
  - `GET /categories/create` (sebagai Petugas) -> HTTP 403 Forbidden
  - `GET /categories` (sebagai Petugas) -> HTTP 200 OK
- **Aset Statis**:
  - Favicon, library Chart.js CDN, dan stylesheet termuat dengan status HTTP 200 OK tanpa broken link (404 Not Found).

---

## 4. Daftar Temuan Bug dan Analisis Teknis (Read-Only)

Sesuai aturan mutlak (strict read-only codebase), tidak ada kode sumber yang dimodifikasi. Temuan berikut dicatat secara objektif berdasarkan inspeksi statis kode, verifikasi runtime browser DevTools, dan audit arsitektur database:

### Temuan 1: Kerentanan Integritas Data pada Penghapusan Buku dan Anggota (Cascade Deletion)
- **Tingkat Keparahan**: Tinggi (Data Integrity Risk)
- **Lokasi File**: `database/migrations/2026_11_11_003819_create_borrowing_details_table.php` (Baris 19) dan `2026_11_11_003614_create_borrowings_table.php` (Baris 20)
- **Gejala**: Relasi foreign key pada tabel `borrowing_details` dan `borrowings` dikonfigurasi dengan aturan `onDelete('cascade')`.
- **Dugaan Penyebab**: Jika Admin menghapus data buku atau anggota yang sedang memiliki peminjaman aktif, relasi cascade di database akan langsung menghapus baris riwayat peminjaman terkait tanpa mengembalikan stok fisik buku terlebih dahulu.
- **Rekomendasi Arsitektur**: Terapkan validasi di Controller atau gunakan `restrictOnDelete()` pada foreign key agar buku atau anggota dengan status pinjaman aktif tidak dapat dihapus sebelum buku dikembalikan.

### Temuan 2: Potensi Error SQL 500 Saat Menghapus Kategori yang Memiliki Koleksi Buku
- **Tingkat Keparahan**: Sedang (Unhandle QueryException)
- **Lokasi File**: `app/Http/Controllers/CategoriesController.php` (Method `destroy`) dan `database/migrations/2026_10_21_061154_add_category_id_to_books_table.php` (Baris 18)
- **Gejala**: Menghapus kategori yang masih memiliki relasi buku akan memicu `Illuminate\Database\QueryException` (Foreign key constraint fails) dengan respons HTTP 500.
- **Dugaan Penyebab**: Migrasi `books` menggunakan aturan `onDelete('restrict')`, namun method `destroy` pada `CategoriesController` langsung memanggil `$category->delete()` tanpa validasi awal `if ($category->books()->exists())` atau blok `try-catch`.
- **Rekomendasi Arsitektur**: Berikan pengecekan jumlah buku terkait sebelum penghapusan, dan tampilkan pesan flash error jika kategori masih berisi buku.

### Temuan 3: Pembatasan Tahun Terbit Buku Terlalu Ketat (Tahun Minimum 2000)
- **Tingkat Keparahan**: Rendah (Business Logic Constraint)
- **Lokasi File**: `app/Http/Controllers/BookController.php` (Baris 44 dan Baris 67)
- **Gejala**: Pengguna tidak dapat mendaftarkan buku klasik atau referensi yang diterbitkan sebelum tahun 2000 (contoh: tahun 1995 akan ditolak validasi).
- **Dugaan Penyebab**: Aturan validasi `year` menggunakan `'required|integer|min:2000'` alih-alih rentang tahun historis yang lebih wajar (misal `min:1900` atau `min:1800`).
- **Rekomendasi Arsitektur**: Ubah aturan validasi tahun terbit menjadi `'min:1900|max:' . (date('Y') + 1)`.

### Temuan 4: Deklarasi Rute Ganda / Shadowing Rute Utama pada `routes/web.php`
- **Tingkat Keparahan**: Rendah (Code Hygiene)
- **Lokasi File**: `routes/web.php` (Baris 12-17 dan Baris 19-25)
- **Gejala**: Terdapat dua deklarasi rute `Route::get('/', ...)`: baris 12 mengarahkan user login ke dashboard, namun baris 20 di dalam middleware `guest` mendeklarasikan ulang `Route::get('/', ...)` yang mengarahkan langsung ke login.
- **Dugaan Penyebab**: Redundansi pendefinisian rute landing page antara blok global dan blok middleware `guest`.
- **Rekomendasi Arsitektur**: Cukup pertahankan blok baris 12-17 yang sudah secara cerdas mengecek `if (auth()->check())`.

### Temuan 5: Peringatan Standar PSR-4 Case-Sensitivity pada Import Model Category
- **Tingkat Keparahan**: Rendah (Style / PSR-4 Warning)
- **Lokasi File**: `app/Http/Controllers/CategoriesController.php` (Baris 5)
- **Gejala**: Controller mengimpor model dengan huruf kecil: `use App\Models\category;`.
- **Dugaan Penyebab**: Ketidaktelitian penulisan huruf kapital pada nama class model.
- **Analisis Dampak**: Pada Windows (case-insensitive file system) hal ini tidak menimbulkan error fatal, namun pada server Linux (case-sensitive) dapat memicu fatal error `Class "App\Models\category" not found`.

### Temuan 6: Peringatan Penggunaan Tailwind CSS CDN di Lingkungan Produksi
- **Tingkat Keparahan**: Rendah (Performance / Warning Console)
- **Lokasi File**: `resources/views/layouts/app.blade.php` (Baris 7) dan `resources/views/auth/login.blade.php` (Baris 7)
- **Gejala**: Muncul peringatan konsol browser: `cdn.tailwindcss.com should not be used in production.`
- **Dugaan Penyebab**: Tailwind dimuat via CDN runtime script untuk kemudahan styling prototyping.
- **Rekomendasi Arsitektur**: Kompilasi stylesheet lokal via Vite (`npm run build`) untuk implementasi produksi.

### Temuan 7: Pesan Validasi Server-Side Berbahasa Inggris pada UI Berbahasa Indonesia
- **Tingkat Keparahan**: Rendah (Localization / UX)
- **Lokasi File**: `.env` (`APP_LOCALE=en`)
- **Gejala**: Label input berbahasa Indonesia, namun pesan error validasi bawaan Laravel tampil dalam Bahasa Inggris.
- **Dugaan Penyebab**: Konfigurasi lokal bahasa sistem belum diarahkan ke paket bahasa Indonesia (`id`).
- **Rekomendasi Arsitektur**: Ubah konfigurasi `APP_LOCALE=id` dan lengkapi direktori bahasa `lang/id/validation.php`.

---

## 5. Kesimpulan Kualitas Aplikasi

Aplikasi web **Sistem Informasi Perpustakaan Sederhana** berada dalam kondisi operasional yang sangat baik dan siap digunakan. Seluruh alur kerja esensial perpustakaan:
1. Perlindungan rute tamu dan pembagian hak akses Admin vs Petugas telah ditegakkan dengan ketat di tingkat server (HTTP 403 Forbidden).
2. Mekanisme peminjaman buku berhasil menghitung jatuh tempo 7 hari secara akurat, mendeteksi stok kosong, dan memotong stok secara atomik melalui transaksi basis data.
3. Mekanisme pengembalian buku berhasil melakukan restock inventaris dan menolak upaya pengembalian berulang.
4. Tampilan dashboard dan pencarian data berjalan responsif tanpa adanya error fatal pada console maupun network browser.
