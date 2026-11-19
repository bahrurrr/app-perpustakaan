# Dokumentasi REST API - Perpustakaan Digital Kampus

Dokumentasi ini mencakup 11 endpoint REST API dasar pada aplikasi `app-perpustakaan` (Pertemuan 9).  
Base URL: `http://127.0.0.1:8000/api`  
Semua request wajib menyertakan header:
```http
Accept: application/json
```

---

## Ringkasan Endpoint

| No | Method | URL | Deskripsi | Status Code |
|---|---|---|---|---|
| 1 | `GET` | `/api/books` | Mengambil daftar buku (mendukung pagination & filter `?judul=`, `?category_id=`) | `200 OK` |
| 2 | `GET` | `/api/books/{id}` | Mengambil detail buku berdasarkan ID | `200 OK`, `404 Not Found` |
| 3 | `POST` | `/api/books` | Menambahkan data buku baru | `201 Created`, `422 Unprocessable` |
| 4 | `PUT` | `/api/books/{id}` | Memperbarui data buku | `200 OK`, `404 Not Found`, `422 Unprocessable` |
| 5 | `DELETE` | `/api/books/{id}` | Menghapus buku | `200 OK`, `404 Not Found` |
| 6 | `GET` | `/api/members` | Mengambil daftar anggota perpustakaan (paginated) | `200 OK` |
| 7 | `GET` | `/api/members/{id}` | Mengambil detail anggota | `200 OK`, `404 Not Found` |
| 8 | `GET` | `/api/loans` | Mengambil daftar transaksi peminjaman | `200 OK` |
| 9 | `POST` | `/api/loans` | Membuat transaksi peminjaman baru | `201 Created`, `422 Unprocessable` |
| 10 | `PUT` | `/api/loans/{id}/kembalikan` | Mengembalikan peminjaman buku | `200 OK`, `404 Not Found` |
| 11 | `GET` | `/api/stats` | Statistik dashboard (jumlah buku, anggota, peminjaman aktif) | `200 OK` |

---

## Rincian Endpoint & Contoh Response

### 1. `GET /api/books`
Mengambil daftar buku dengan format paginasi dan relasi kategori. Mendukung query param `?judul=` dan `?category_id=`.

- **Query Parameters (Opsional):**
  - `judul`: Mencari sebagian judul buku (contoh: `?judul=laskar`)
  - `category_id`: Filter berdasarkan ID kategori (contoh: `?category_id=1`)
  - `page`: Nomor halaman (contoh: `?page=1`)
- **Status Code:** `200 OK`
- **Contoh Response:**
```json
{
  "data": [
    {
      "id": 1,
      "judul": "Laskar Pelangi",
      "penulis": "Andrea Hirata",
      "penerbit": "Bentang Pustaka",
      "tahun_terbit": 2005,
      "isbn": "9789793062792",
      "stok": 10,
      "sampul": null,
      "category": {
        "id": 1,
        "nama_kategori": "Novel"
      },
      "created_at": "2026-11-19T03:18:42.000000Z",
      "updated_at": "2026-11-19T03:18:42.000000Z"
    }
  ],
  "links": {
    "first": "http://127.0.0.1:8000/api/books?page=1",
    "last": "http://127.0.0.1:8000/api/books?page=1",
    "prev": null,
    "next": null
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 1,
    "per_page": 10,
    "to": 1,
    "total": 1
  }
}
```

---

### 2. `GET /api/books/{id}`
Mengambil detail informasi satu buku.

- **Status Code Sukses:** `200 OK`
- **Contoh Response Sukses (`GET /api/books/1`):**
```json
{
  "data": {
    "id": 1,
    "judul": "Laskar Pelangi",
    "penulis": "Andrea Hirata",
    "penerbit": "Bentang Pustaka",
    "tahun_terbit": 2005,
    "isbn": "9789793062792",
    "stok": 10,
    "sampul": null,
    "category": {
      "id": 1,
      "nama_kategori": "Novel"
    },
    "created_at": "2026-11-19T03:18:42.000000Z",
    "updated_at": "2026-11-19T03:18:42.000000Z"
  }
}
```
- **Status Code Gagal:** `404 Not Found` (jika id tidak ditemukan)
```json
{
  "message": "No query results for model [App\\Models\\Book] 999"
}
```

---

### 3. `POST /api/books`
Menambahkan data buku baru.

- **Request Headers:** `Content-Type: application/json`
- **Request Body:**
```json
{
  "judul": "Pemrograman Web Modern",
  "penulis": "Budi Santoso",
  "penerbit": "Informatika",
  "tahun_terbit": 2024,
  "isbn": "978-602-1234-56-7",
  "stok": 15,
  "category_id": 1
}
```
- **Status Code Sukses:** `201 Created`
- **Contoh Response Sukses:**
```json
{
  "data": {
    "id": 2,
    "judul": "Pemrograman Web Modern",
    "penulis": "Budi Santoso",
    "penerbit": "Informatika",
    "tahun_terbit": 2024,
    "isbn": "978-602-1234-56-7",
    "stok": 15,
    "sampul": null,
    "category": {
      "id": 1,
      "nama_kategori": "Komputer & Teknologi"
    },
    "created_at": "2026-11-19T03:20:00.000000Z",
    "updated_at": "2026-11-19T03:20:00.000000Z"
  }
}
```
- **Status Code Gagal Validasi:** `422 Unprocessable Content` (misal body kosong)
```json
{
  "message": "Judul buku wajib diisi. (and 5 more errors)",
  "errors": {
    "judul": [
      "Judul buku wajib diisi."
    ],
    "penulis": [
      "Nama penulis wajib diisi."
    ],
    "penerbit": [
      "Nama penerbit wajib diisi."
    ],
    "tahun_terbit": [
      "Tahun terbit wajib diisi."
    ],
    "stok": [
      "Stok wajib diisi."
    ],
    "category_id": [
      "Kategori wajib dipilih."
    ]
  }
}
```

---

### 4. `PUT /api/books/{id}`
Memperbarui data buku.

- **Request Body:**
```json
{
  "judul": "Pemrograman Web Modern (Edisi 2)",
  "penulis": "Budi Santoso",
  "penerbit": "Informatika",
  "tahun_terbit": 2024,
  "isbn": "978-602-1234-56-7",
  "stok": 20,
  "category_id": 1
}
```
- **Status Code Sukses:** `200 OK`
- **Contoh Response Sukses:**
```json
{
  "data": {
    "id": 2,
    "judul": "Pemrograman Web Modern (Edisi 2)",
    "penulis": "Budi Santoso",
    "penerbit": "Informatika",
    "tahun_terbit": 2024,
    "isbn": "978-602-1234-56-7",
    "stok": 20,
    "sampul": null,
    "category": {
      "id": 1,
      "nama_kategori": "Komputer & Teknologi"
    },
    "created_at": "2026-11-19T03:20:00.000000Z",
    "updated_at": "2026-11-19T03:22:10.000000Z"
  }
}
```
- **Status Code Gagal Validasi:** `422 Unprocessable Content`

---

### 5. `DELETE /api/books/{id}`
Menghapus data buku berdasarkan ID.

- **Status Code Sukses:** `200 OK`
- **Contoh Response Sukses:**
```json
{
  "message": "Buku berhasil dihapus."
}
```
- **Status Code Gagal:** `404 Not Found` (jika id buku tidak ada)

---

### 6. `GET /api/members`
Mengambil daftar anggota perpustakaan dengan pagination.

- **Status Code:** `200 OK`
- **Contoh Response:**
```json
{
  "data": [
    {
      "id": 1,
      "nama": "Luthfi Bahrur Rozaq",
      "nim": "3125600069",
      "email": "luthfi@gmail.com",
      "nomor_telepon": "085928978578",
      "alamat": "surabaya",
      "status": "aktif",
      "created_at": "2026-09-26T16:42:41.000000Z",
      "updated_at": "2026-09-26T16:42:41.000000Z"
    }
  ],
  "links": {
    "first": "http://127.0.0.1:8000/api/members?page=1",
    "last": "http://127.0.0.1:8000/api/members?page=1",
    "prev": null,
    "next": null
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 1,
    "per_page": 10,
    "to": 1,
    "total": 1
  }
}
```

---

### 7. `GET /api/members/{id}`
Mengambil detail satu anggota perpustakaan.

- **Status Code Sukses:** `200 OK`
- **Contoh Response Sukses:**
```json
{
  "data": {
    "id": 1,
    "nama": "Luthfi Bahrur Rozaq",
    "nim": "3125600069",
    "email": "luthfi@gmail.com",
    "nomor_telepon": "085928978578",
    "alamat": "surabaya",
    "status": "aktif",
    "created_at": "2026-09-26T16:42:41.000000Z",
    "updated_at": "2026-09-26T16:42:41.000000Z"
  }
}
```
- **Status Code Gagal:** `404 Not Found`

---

### 8. `GET /api/loans`
Mengambil daftar peminjaman beserta relasi `member`, `petugas` (user), dan `books` (items).

- **Status Code:** `200 OK`
- **Contoh Response:**
```json
{
  "data": [
    {
      "id": 1,
      "member": {
        "id": 1,
        "nama": "Luthfi Bahrur Rozaq"
      },
      "petugas": {
        "id": 1,
        "name": "Admin Perpustakaan"
      },
      "tanggal_pinjam": "2026-11-19",
      "tanggal_kembali": "2026-11-26",
      "tanggal_dikembalikan": null,
      "status": "dipinjam",
      "books": [
        {
          "id": 1,
          "judul": "Laskar Pelangi"
        }
      ]
    }
  ],
  "links": {
    "first": "http://127.0.0.1:8000/api/loans?page=1",
    "last": "http://127.0.0.1:8000/api/loans?page=1",
    "prev": null,
    "next": null
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 1,
    "per_page": 10,
    "to": 1,
    "total": 1
  }
}
```

---

### 9. `POST /api/loans`
Membuat transaksi peminjaman baru.

- **Request Body:**
```json
{
  "member_id": 1,
  "user_id": 1,
  "tanggal_pinjam": "2026-11-19",
  "tanggal_kembali": "2026-11-26",
  "book_ids": [1]
}
```
- **Status Code Sukses:** `201 Created`
- **Contoh Response Sukses:**
```json
{
  "data": {
    "id": 2,
    "member": {
      "id": 1,
      "nama": "Luthfi Bahrur Rozaq"
    },
    "petugas": {
      "id": 1,
      "name": "Admin Perpustakaan"
    },
    "tanggal_pinjam": "2026-11-19",
    "tanggal_kembali": "2026-11-26",
    "tanggal_dikembalikan": null,
    "status": "dipinjam",
    "books": [
      {
        "id": 1,
        "judul": "Laskar Pelangi"
      }
    ]
  }
}
```
- **Status Code Gagal Validasi:** `422 Unprocessable Content` (misal body tidak lengkap)
```json
{
  "message": "Anggota wajib dipilih. (and 4 more errors)",
  "errors": {
    "member_id": [
      "Anggota wajib dipilih."
    ],
    "user_id": [
      "Petugas (user_id) wajib diisi."
    ],
    "tanggal_pinjam": [
      "Tanggal pinjam wajib diisi."
    ],
    "tanggal_kembali": [
      "Tanggal kembali wajib diisi."
    ],
    "book_ids": [
      "Pilih minimal satu buku."
    ]
  }
}
```

---

### 10. `PUT /api/loans/{id}/kembalikan`
Memproses pengembalian buku yang sedang dipinjam.

- **Status Code Sukses:** `200 OK`
- **Contoh Response Sukses:**
```json
{
  "data": {
    "id": 1,
    "member": {
      "id": 1,
      "nama": "Luthfi Bahrur Rozaq"
    },
    "petugas": {
      "id": 1,
      "name": "Admin Perpustakaan"
    },
    "tanggal_pinjam": "2026-11-19",
    "tanggal_kembali": "2026-11-26",
    "tanggal_dikembalikan": "2026-11-19",
    "status": "dikembalikan",
    "books": [
      {
        "id": 1,
        "judul": "Laskar Pelangi"
      }
    ]
  }
}
```
- **Status Code Gagal:** `404 Not Found` (jika ID pinjaman tidak ditemukan)

---

### 11. `GET /api/stats`
Mengambil ringkasan statistik aplikasi untuk dashboard.

- **Status Code:** `200 OK`
- **Contoh Response:**
```json
{
  "total_buku": 12,
  "total_anggota": 3,
  "peminjaman_aktif": 1
}
```
