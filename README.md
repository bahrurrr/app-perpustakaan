# Sistem Perpustakaan Digital Kampus

Aplikasi manajemen perpustakaan berbasis web yang dikembangkan menggunakan framework **Laravel 12** dan database **PostgreSQL**. Aplikasi ini mengimplementasikan konsep MVC modern, autentikasi session tanpa starter kit, role-based authorization middleware, REST API lengkap dengan API Resource, konsumsi API internal menggunakan Laravel HTTP Client, serta data seeding realistis dengan Factory.

---

## Identitas Praktikan
* **Nama:** Luthfi Bahrur Rozaq
* **NRP:** 3125600069
* **Kelas:** 1 D4IT C
* **Mata Kuliah:** Workshop Pemrograman Framework

---

## Fitur Utama Aplikasi
1. **Autentikasi & Otorisasi:**
   - Login, logout, dan remember me berbasis session aman (CSRF protection, session fixation prevention).
   - Middleware `auth` untuk membatasi akses publik.
   - Middleware `CheckAdminRole` (`admin`) untuk pembatasan menu administratif (Kategori hanya untuk Admin).
   - Halaman Profil petugas dan fitur ganti password dengan validasi `Hash::check()`.
2. **Katalog & Sirkulasi (CRUD):**
   - Manajemen Buku (dengan upload sampul, pencarian, dan pagination rapi).
   - Manajemen Kategori Buku.
   - Manajemen Data Anggota Perpustakaan.
   - Transaksi Peminjaman Multi-buku dengan otomatisasi pencatatan petugas login (`auth()->id()`).
   - Fitur Pengembalian Buku dengan tracking tanggal riil.
3. **REST API Dasar (11 Endpoints):**
   - Endpoint CRUD Buku, Anggota, Transaksi Peminjaman, Pengembalian, dan Statistik.
   - Standardisasi response JSON menggunakan **Laravel API Resource** (`BookResource`, `MemberResource`, `LoanResource`).
   - Format dokumentasi lengkap di [API.md](API.md).
4. **Konsumsi API Internal & Laporan:**
   - Halaman **Dashboard** mengonsumsi `GET /api/stats` untuk menampilkan ringkasan data.
   - Halaman **Laporan Peminjaman** mengonsumsi `GET /api/loans` dengan metadata pagination.
   - Penanganan error toleran kegagalan koneksi (`ConnectionException`).
5. **Seeder & Factory Realistis:**
   - Data buku, kategori, anggota, dan transaksi dikurasi dengan nama dan identitas lokal Indonesia (locale `id_ID` dan domain `@pens.ac.id`).

---

## Kebutuhan Sistem
* PHP >= 8.2
* Composer
* PostgreSQL >= 14
* Ekstensi PHP: `pdo_pgsql`, `pgsql`, `curl`, `mbstring`, `openssl`

---

## Panduan Instalasi & Menjalankan Aplikasi

### 1. Clone Repository
```bash
git clone https://github.com/bahrurrr/app-perpustakaan.git
cd app-perpustakaan
```

### 2. Install Dependency PHP
```bash
composer install
```

### 3. Konfigurasi Environment (`.env`)
Salin file konfigurasi contoh:
```bash
cp .env.example .env
```
Generate application key:
```bash
php artisan key:generate
```

Sesuaikan konfigurasi database dan API internal pada file `.env`:
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=db_perpustakaan
DB_USERNAME=postgres
DB_PASSWORD=password_db_anda

# Konfigurasi Port API Internal (wajib berbeda dari server web utama)
INTERNAL_API_URL=http://127.0.0.1:8011
APP_FAKER_LOCALE=id_ID
```

### 4. Migrasi & Seeding Database
Jalankan migrasi database beserta pengisian data dummy realistis:
```bash
php artisan migrate:fresh --seed
```

Data akun bawaan:
| Role | Email | Password |
|---|---|---|
| **Admin** | `admin@pens.ac.id` | `password` |
| **Petugas 1** | `petugas1@pens.ac.id` | `password` |
| **Petugas 2** | `petugas2@pens.ac.id` | `password` |

### 5. Menjalankan Server Aplikasi (Dua Instance)
Karena server pengembangan lokal `php artisan serve` bersifat single-threaded (memproses satu request pada satu waktu), aplikasi ini membutuhkan **dua terminal berjalan bersamaan** agar pemanggilan API internal dari Dashboard dan Laporan tidak mengalami *deadlock*:

- **Terminal 1 — Server Web Utama (Aplikasi Browser):**
  ```bash
  php artisan serve --port=8000
  ```
- **Terminal 2 — Server API Internal:**
  ```bash
  php artisan serve --port=8011
  ```

Buka browser dan akses aplikasi di: **`http://127.0.0.1:8000`**

---

## Dokumentasi Pendukung
- **Skenario Demo Praktik & Pengujian:** Lihat panduan langkah demi langkah di [DEMO.md](DEMO.md).
- **Spesifikasi & Contoh REST API:** Lihat tabel 11 endpoint dan contoh JSON di [API.md](API.md).
