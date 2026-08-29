# App Perpustakaan

Aplikasi manajemen perpustakaan berbasis web yang dikembangkan menggunakan framework Laravel 12 dan *database* PostgreSQL. Tujuan aplikasi ini adalah untuk mendigitalisasi proses pengelolaan daftar buku, pencatatan peminjaman, serta manajemen data anggota perpustakaan secara efisien.

## Identitas Praktikan
* **Nama:** Luthfi Bahrur Rozaq
* **NRP:** 3125600069
* **Kelas:** 1 D4IT C

## Cara Menjalankan Project Secara Lokal

1. Pastikan mesin PostgreSQL di laptop sudah berjalan.
2. Buka pgAdmin jika anda ingin melihat isi data `db_perpustakaan`.
3. Buka teks editor dan buka folder proyekmu.
4. Buka terminal dan pastikan direktorinya sudah berada di folder proyekmu.
5. Nyalakan server lokal dengan mengetikkan perintah `php artisan serve`, lalu tekan enter.
6. Buka Browser lalu ketikkan alamat `http://127.0.0.1:8000` di pencarian, lalu tekan enter.
7. Halaman proyek Laravel-mu akan langsung muncul.

<!-- Perbedaan Model, View, Controller -->
<!-- Model: bagian pengelola yang menangani logika rumit untuk mengatur jalannya data, aturan bisnis, struktur tabel, dan bagaimana relasi antar tabel bekerja -->
<!-- View: adalah frontend atau bagian antarmuka yang dilihat oleh user dan murni hanya boleh menampilkan data yang sudah disiapkan -->
<!-- Controller: adalah bagian untuk menerima input dari user yang lalu memanggil model untuk menjalankan data yang diberikana user lalu memanggil view untuk menampilkan data yang sudah diolah -->
