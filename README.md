# App Perpustakaan

Aplikasi manajemen perpustakaan berbasis web yang dikembangkan menggunakan framework Laravel 12 dan *database* PostgreSQL. Tujuan aplikasi ini adalah untuk mendigitalisasi proses pengelolaan daftar buku, pencatatan peminjaman, serta manajemen data anggota perpustakaan secara efisien.

## Identitas Praktikan
* **Nama:** Luthfi Bahrur Rozaq
* **NRP:** 3125600069
* **Kelas:** 1 D4IT C

## Cara Menjalankan Project Secara Lokal

1. Pastikan mesin PostgreSQL di laptop sudah berjalan.
2. Buka pgAdmin dan buat *database* kosong bernama `db_perpustakaan`.
3. Buka terminal di dalam folder proyek ini, lalu jalankan perintah migrasi tabel:
   ```bash
   php artisan migrate