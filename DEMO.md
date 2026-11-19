# Panduan Skenario Demo Aplikasi Perpustakaan Digital Kampus

Dokumen ini berisi urutan skenario demonstrasi fungsionalitas aplikasi **Perpustakaan Digital Kampus** (UAS Workshop Pemrograman Framework).

---

## Persiapan Sebelum Demo

1. **Pastikan Database PostgreSQL aktif** dan database `db_perpustakaan` tersedia.
2. **Jalankan Seeding Data Awal:**
   ```bash
   php artisan migrate:fresh --seed
   ```
3. **Nyalakan Dua Instance Server:**
   - **Terminal 1 (Aplikasi Web):**
     ```bash
     php artisan serve --port=8000
     ```
   - **Terminal 2 (Internal API Server):**
     ```bash
     php artisan serve --port=8011
     ```
4. Buka browser di `http://127.0.0.1:8000`.

---

## Urutan Skenario Demo

### 1. Autentikasi (Login & Proteksi Route)
- **Tindakan:** Coba akses langsung URL `http://127.0.0.1:8000/books`.
- **Hasil yang Diharapkan:** Otomatis redirect ke halaman `/login` karena belum login (proteksi middleware `auth`).
- **Tindakan:** Masukkan email `admin@pens.ac.id` dan password `password`, centang "Ingat saya", lalu klik **Login**.
- **Hasil yang Diharapkan:** Berhasil login, dialihkan ke halaman **Dashboard** (`/`), dan navbar menampilkan nama `Bambang Sutrisno (Admin)`.

---

### 2. Tampilkan Dashboard (Konsumsi API Internal)
- **Tindakan:** Amati kartu statistik di halaman Dashboard.
- **Hasil yang Diharapkan:**
  - Kartu menampilkan data riil hasil konsumsi endpoint `GET /api/stats` via port `8011`:
    - **Total Buku:** 20
    - **Total Anggota:** 15
    - **Peminjaman Aktif:** (sesuai data aktif seeder)
- **Catatan Demo Ketahanan:** Jika server port `8011` sengaja dimatikan, halaman Dashboard tidak error 500 melainkan menampilkan angka default 0 (mekanisme `try/catch ConnectionException`).

---

### 3. Manajemen Kategori (Hak Akses Khusus Admin)
- **Tindakan:** Klik menu **Kategori** pada navbar (`/categories`).
- **Tindakan:** Klik **Tambah Kategori**, masukkan:
  - **Nama Kategori:** `Referensi Akademik`
  - **Deskripsi:** `Buku teks panduan perkuliahan dan modul praktikum.`
- **Tindakan:** Simpan data.
- **Hasil yang Diharapkan:** Kategori baru muncul di daftar kategori dengan pesan flash sukses.

---

### 4. Manajemen Buku (CRUD & Validasi Form)
- **Tindakan:** Klik menu **Buku** pada navbar (`/books`).
- **Hasil yang Diharapkan:** Daftar buku tampil dengan nama penulis Indonesia dan pagination rapi berbasis teks di bagian bawah (`« Sebelumnya 1 2 Berikutnya »`).
- **Tindakan:** Klik **Tambah Buku**, isi data:
  - **Judul:** `Panduan Praktis Laravel 12`
  - **Penulis:** `Luthfi Bahrur Rozaq`
  - **Penerbit:** `Informatika Bandung`
  - **Tahun Terbit:** `2025`
  - **ISBN:** `978-602-9999-01-2`
  - **Stok:** `10`
  - **Kategori:** Pilih `Referensi Akademik`
- **Tindakan:** Klik tombol simpan.
- **Hasil yang Diharapkan:** Buku berhasil disimpan dan muncul pada daftar buku.

---

### 5. Manajemen Anggota
- **Tindakan:** Klik menu **Anggota** pada navbar (`/members`).
- **Tindakan:** Klik **Tambah Anggota**, masukkan:
  - **Nama:** `Achmad Maulana`
  - **NIM:** `3125600099`
  - **Email:** `achmad.maulana@pens.ac.id`
  - **Nomor Telepon:** `081234567899`
  - **Alamat:** `Surabaya, Jawa Timur`
  - **Status:** `aktif`
- **Tindakan:** Simpan data.
- **Hasil yang Diharapkan:** Anggota baru tersimpan ke database.

---

### 6. Transaksi Peminjaman (Otomatisasi Petugas)
- **Tindakan:** Klik menu **Peminjaman** (`/loans`), lalu klik **Tambah Peminjaman**.
- **Hasil yang Diharapkan:**
  - Form tidak lagi menampilkan dropdown pemilihan petugas manual, melainkan teks info:  
    *`Petugas pencatat: Bambang Sutrisno (otomatis dari akun yang login).`*
- **Tindakan:** Isi transaksi peminjaman:
  - **Anggota:** Pilih `Achmad Maulana`
  - **Buku yang Dipinjam:** Centang buku `Panduan Praktis Laravel 12`
  - **Tanggal Pinjam:** Tanggal hari ini
  - **Tanggal Kembali:** 7 hari ke depan
- **Tindakan:** Simpan transaksi peminjaman.
- **Hasil yang Diharapkan:** Transaksi peminjaman baru berstatus **Dipinjam** tercatat di daftar peminjaman dengan petugas `Bambang Sutrisno`.

---

### 7. Proses Pengembalian Buku
- **Tindakan:** Pada daftar peminjaman (`/loans`), temukan transaksi peminjaman yang baru dibuat.
- **Tindakan:** Klik tombol **Kembalikan**.
- **Hasil yang Diharapkan:**
  - Status peminjaman otomatis berubah menjadi **Dikembalikan** (badge hijau).
  - Kolom tanggal pengembalian terisi tanggal hari ini.

---

### 8. Laporan Peminjaman (Konsumsi API Internal)
- **Tindakan:** Klik menu **Laporan** pada navbar (`/loans/report`).
- **Hasil yang Diharapkan:**
  - Halaman menampilkan tabel transaksi peminjaman yang ditarik dari `GET /api/loans` (bukan query Eloquent langsung).
  - Terdapat kontrol navigasi pagination laporan (`Halaman 1 dari N`).

---

### 9. Otorisasi Role Petugas & 403 Forbidden
- **Tindakan:** Klik tombol **Logout** di navbar.
- **Tindakan:** Login kembali menggunakan akun petugas:
  - **Email:** `petugas1@pens.ac.id`
  - **Password:** `password`
- **Hasil yang Diharapkan:**
  - Navbar menampilkan `Siti Rahmawati (Petugas)`.
  - Menu **Kategori** tidak muncul di navbar.
- **Tindakan:** Coba akses manual via URL: `http://127.0.0.1:8000/categories`.
- **Hasil yang Diharapkan:** Server merespons `403 Forbidden` (*"Halaman ini hanya bisa diakses oleh admin"*).

---

### 10. Pengujian REST API (Thunder Client / Postman)
- **Tindakan:** Buka Thunder Client di VS Code atau Postman.
- **Tindakan:** Lakukan pengujian endpoint dengan header `Accept: application/json`:
  1. `GET http://127.0.0.1:8000/api/stats` &rarr; Status `200 OK` (JSON ringkasan data).
  2. `GET http://127.0.0.1:8000/api/books?judul=laravel` &rarr; Status `200 OK` (filter data buku).
  3. `POST http://127.0.0.1:8000/api/books` tanpa body &rarr; Status `422 Unprocessable Content` (validasi error per field).
  4. `GET http://127.0.0.1:8000/api/books/9999` &rarr; Status `404 Not Found`.
