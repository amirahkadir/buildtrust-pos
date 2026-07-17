# Dokumentasi API Endpoint - BuildTrust POS

Dokumen ini menjabarkan spesifikasi API yang digunakan untuk komunikasi antara antarmuka web (frontend) dan server database (backend) pada aplikasi **BuildTrust POS**.

---

## 1. Spesifikasi Umum API

*   **Base URL:** `/api.php` (diarahkan ke file root [api.php](file:///c:/Users/youth/Downloads/buildtrust-pos/api.php))
*   **Format Data:** Request & Response menggunakan format **JSON** (`Content-Type: application/json`).
*   **Parameter Aksi (`action`):** Ditentukan melalui parameter query parameter GET `?action=<nama_aksi>` atau parameter POST di dalam body request JSON.
*   **Keamanan Sesi:** Menggunakan sesi PHP (`session_start()`). Jika user belum masuk (belum ada `$_SESSION['user_id']`), memanggil API terproteksi akan mengembalikan response error `not_logged_in`.

---

## 2. Struktur Global State Response

Sebagian besar API sukses akan mengembalikan data state sistem terbaru (`state`) untuk sinkronisasi state di frontend. Struktur `state` adalah:

```json
{
  "products": [
    {
      "id": 1,
      "nama": "Semen Tiga Roda 40kg",
      "merk": "Tiga Roda",
      "kategori": "Semen",
      "harga": 68000,
      "satuan": "Sak",
      "stok": 12,
      "minStok": 20,
      "konversi": "1 Sak = 40 Kg"
    }
  ],
  "jurnal": [
    {
      "id": 1,
      "tanggal": "2026-05-18",
      "ref": "111",
      "akun": "Kas Toko",
      "d": 15000000,
      "k": 0,
      "desc": "Inisialisasi Modal Operasional Awal"
    }
  ],
  "logs": [
    {
      "waktu": "2026-06-30 18:00",
      "user": "System Guard",
      "aksi": "Basis data berhasil diinisialisasi",
      "tipe": "info"
    }
  ]
}
```

---

## 3. Daftar Endpoint API

### A. Autentikasi & Pengguna

#### 1. Login Pengguna
*   **Aksi:** `login`
*   **Metode:** `POST`
*   **Payload Request (JSON):**
    ```json
    {
      "action": "login",
      "username": "admin",
      "password": "password123"
    }
    ```
*   **Response Sukses:**
    ```json
    {
      "status": "success",
      "message": "Login berhasil!",
      "user": {
        "id": 1,
        "username": "admin",
        "nama": "Kayla Aura (Admin)",
        "role": "admin"
      },
      "state": { ... } // Global State
    }
    ```

#### 2. Logout Pengguna
*   **Aksi:** `logout`
*   **Metode:** `POST` / `GET`
*   **Response Sukses:**
    ```json
    {
      "status": "success",
      "message": "Logout berhasil!"
    }
    ```

#### 3. Ambil Sesi Pengguna Aktif
*   **Aksi:** `get_user`
*   **Metode:** `GET`
*   **Response Sukses:**
    ```json
    {
      "status": "success",
      "user": {
        "id": 1,
        "username": "admin",
        "nama": "Kayla Aura (Admin)",
        "role": "admin"
      }
    }
    ```
*   **Response Error (Belum Login):**
    ```json
    {
      "status": "error",
      "message": "not_logged_in"
    }
    ```

---

### B. Transaksi & Keuangan

#### 4. Ambil State Terkini
*   **Aksi:** `get_state`
*   **Metode:** `GET`
*   **Response Sukses:**
    ```json
    {
      "status": "success",
      "state": { ... } // Global State
    }
    ```

#### 5. Proses Transaksi Kasir (Checkout)
*   *Akses Peran:* Admin & Kasir.
*   **Aksi:** `checkout`
*   **Metode:** `POST`
*   **Payload Request (JSON):**
    ```json
    {
      "action": "checkout",
      "pelanggan": "Budi Santoso",
      "metode": "Tunai",
      "bayar": 500000,
      "cart": [
        {
          "productId": 1,
          "qty": 2
        },
        {
          "productId": 2,
          "qty": 1
        }
      ]
    }
    ```
*   **Response Sukses:**
    ```json
    {
      "status": "success",
      "message": "Transaksi berhasil diproses!",
      "nota": {
        "txNo": "TX-398271",
        "subtotal": 261000,
        "tax": 28710,
        "total": 289710,
        "bayar": 500000,
        "kembalian": 210290,
        "pelanggan": "Budi Santoso",
        "metode": "Tunai",
        "tanggal": "30/06/2026 18:50",
        "items": [
          {
            "nama": "Semen Tiga Roda 40kg",
            "qty": 2,
            "satuan": "Sak",
            "harga": 68000
          },
          {
            "nama": "Pipa PVC Wavin AW 3\"",
            "qty": 1,
            "satuan": "Batang",
            "harga": 125000
          }
        ]
      },
      "state": { ... } // Global State (Stok & Jurnal telah diperbarui)
    }
    ```

#### 6. Reset Data Keuangan & Seeding Awal
*   *Akses Peran:* Admin saja.
*   **Aksi:** `reset_jurnal`
*   **Metode:** `POST`
*   **Response Sukses:**
    ```json
    {
      "status": "success",
      "message": "Data keuangan dan jurnal umum berhasil di-reset.",
      "state": { ... } // Global State
    }
    ```

---

### C. Manajemen Inventaris & Log Keamanan

#### 7. Tambah Material Baru
*   *Akses Peran:* Admin saja.
*   **Aksi:** `add_product`
*   **Metode:** `POST`
*   **Payload Request (JSON):**
    ```json
    {
      "action": "add_product",
      "nama": "Cat Tembok Avian Putih 5kg",
      "merk": "Avian",
      "kategori": "Cat",
      "harga": 140000,
      "satuan": "Pail",
      "stok": 15,
      "minStok": 5,
      "konversi": "1 Pail = 5 Kg"
    }
    ```
*   **Response Sukses:**
    ```json
    {
      "status": "success",
      "message": "Material Cat Tembok Avian Putih 5kg berhasil ditambahkan!",
      "state": { ... } // Global State
    }
    ```

#### 8. Hapus/Bersihkan Log Aktivitas
*   *Akses Peran:* Admin saja.
*   **Aksi:** `clear_logs`
*   **Metode:** `POST`
*   **Response Sukses:**
    ```json
    {
      "status": "success",
      "message": "Log aktivitas berhasil dibersihkan.",
      "state": { ... } // Global State
    }
    ```

---

## 4. Penanganan Error (Error Handling)

Apabila terjadi kesalahan saat eksekusi backend, API akan melempar error dalam format JSON dengan HTTP Status `200` (atau `500` jika koneksi DB gagal):

```json
{
  "status": "error",
  "message": "Deskripsi pesan kesalahan sistem (misal: 'Stok produk Semen tidak mencukupi!')"
}
```
