# BAB 5: IMPLEMENTASI DASAR

## 5.1 Tools dan Teknologi
Implementasi BuildTrust-POS menggunakan kombinasi stack teknologi web monolitik yang ringan, cepat, dan mudah dipasang pada server lokal:

1.  **Bahasa Pemrograman Backend:** **PHP Native** (v7.4 atau yang lebih baru). Dipilih karena kemudahan integrasi dengan server lokal apache dan fleksibilitas penanganan session autentikasi.
2.  **Driver Database:** **PHP Data Objects (PDO)**. Digunakan untuk berinteraksi dengan database MySQL karena mendukung *Prepared Statements* (pencegah SQL Injection) serta kemudahan manajemen transaksi database (`beginTransaction`, `commit`, `rollback`).
3.  **Sistem Manajemen Basis Data:** **MySQL** (v5.7 / v8.0). Menyediakan engine InnoDB relasional untuk penyimpanan data terstruktur serta penegakan integritas data dengan Foreign Keys.
4.  **Bahasa Pemrograman Frontend:** **JavaScript (Vanilla ES6)**. Digunakan untuk mengelola state lokal (keranjang belanja, filter kategori, hitung kembalian) dan mengirim HTTP request asinkron ke server menggunakan API `fetch()`.
5.  **Desain & Styling:** **Tailwind CSS** (v3.0, diimpor via CDN). Digunakan untuk mempercepat proses styling antarmuka modern yang bersih dan memastikan layout responsif.
6.  **Ikonografi:** **Lucide Icons** (diimpor via script unpkg). Menyediakan paket ikon vektor SVG modern yang ringan untuk melengkapi antarmuka visual menu sidebar dan tombol aksi.
7.  **Visualisasi Data Keuangan:** **Chart.js** (diimpor via CDN). Digunakan untuk menggambar grafik garis interaktif yang memantau aliran kas dan pendapatan di dashboard.

---

## 5.2 Struktur Folder Proyek
Susunan file dan direktori di dalam server web lokal (`htdocs` / `www`) adalah sebagai berikut:

```text
buildtrust-pos/                   # Direktori Utama Aplikasi
│
├── API/                          # Direktori API Cadangan (Prosedural Lama)
│   ├── get_product.php           # API mengambil produk tunggal
│   └── save_transaction.php      # API menyimpan transaksi model lama
│
├── config/                       # Direktori Konfigurasi Database Cadangan
│   └── db.php                    # Hubungan database menggunakan mysqli
│
├── dokumentasi/                  # Direktori Dokumentasi Proyek 1 (Parsial)
│   ├── bab1_pendahuluan.md       # Dokumen Bab 1 Laporan Akhir
│   ├── bab2_deskripsi_sistem.md  # Dokumen Bab 2 Laporan Akhir
│   ├── bab3_perancangan_sistem.md# Dokumen Bab 3 Laporan Akhir
│   ├── bab4_desain_antarmuka.md  # Dokumen Bab 4 Laporan Akhir
│   ├── bab5_implementasi_dasar.md# Dokumen Bab 5 Laporan Akhir (Berkas ini)
│   ├── bab6_penutup.md           # Dokumen Bab 6 Laporan Akhir
│   ├── api_endpoints.md          # Dokumen teknis REST API
│   ├── arsitektur_dan_desain.md  # Dokumen teknis struktur database & ERD
│   ├── panduan_pengguna.md       # Panduan operasional sistem
│   └── srs.md                    # Dokumen Spesifikasi Kebutuhan Sistem
│
├── petunjuk/                     # Direktori Panduan Pembuatan Dokumen
│   └── outline_buku.md           # Outline panduan laporan akhir dari dosen
│
├── api.php                       # Backend API Router Utama (PDO MySQL)
├── dashboard.php                 # Tampilan Utama Dashboard Aplikasi terintegrasi
├── dashboard_inmemory.php        # Versi in-memory legacy (cadangan non-database)
├── database.sql                  # Skema database MySQL & data seeding awal
├── db.php                        # File koneksi database utama berbasis PDO
└── README.md                     # File panduan awal proyek
```

---

## 5.3 Petunjuk Menjalankan Aplikasi
Untuk menjalankan dan menguji aplikasi BuildTrust-POS di lingkungan lokal Anda, ikuti langkah-langkah berikut:

### Langkah 1: Persiapan Server Lokal
1.  Pastikan program **XAMPP** atau **Laragon** sudah terinstal di komputer Anda.
2.  Buka **XAMPP Control Panel**, lalu aktifkan modul **Apache** dan **MySQL** dengan mengklik tombol **Start** di sebelah masing-masing modul.

### Langkah 2: Penempatan File
1.  Pindahkan atau ekstrak seluruh folder proyek `buildtrust-pos` ke dalam direktori root server web Anda:
    *   XAMPP: `C:\xampp\htdocs\buildtrust-pos\`
    *   Laragon: `C:\laragon\www\buildtrust-pos\`

### Langkah 3: Konfigurasi & Impor Database
1.  Buka browser dan buka halaman phpMyAdmin melalui alamat: [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
2.  Buat basis data baru bernama **`db_buildtrust_pos`** dengan mengklik menu **New**, ketikkan nama database, lalu klik **Create**.
3.  Pilih database `db_buildtrust_pos` yang baru dibuat di panel sebelah kiri.
4.  Klik menu **Import** di bar atas phpMyAdmin.
5.  Klik **Choose File** (Pilih Berkas), kemudian cari dan arahkan ke file **`database.sql`** yang terletak di folder proyek Anda (`C:\xampp\htdocs\buildtrust-pos\database.sql`).
6.  Gulir ke bawah dan klik tombol **Import** (Kirim). Pastikan semua struktur tabel dan data user berhasil terbuat.

### Langkah 4: Uji Coba Aplikasi
1.  Buka tab baru di browser Anda dan akses aplikasi melalui alamat:
    [http://localhost/buildtrust-pos/dashboard.php](http://localhost/buildtrust-pos/dashboard.php)
2.  Layar login akan muncul. Gunakan akun berikut untuk menguji sistem:
    *   **Admin:** Username: `admin` | Password: `admin`
    *   **Kasir:** Username: `kasir` | Password: `kasir`
    *   **Owner:** Username: `owner` | Password: `owner`
