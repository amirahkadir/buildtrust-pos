# BAB 4: DESAIN ANTARMUKA

## 4.1 Konsep Desain
Desain antarmuka aplikasi **BuildTrust-POS** mengusung konsep **Modern Minimalist & Clean Dashboard**. Pendekatan ini dipilih untuk memastikan aplikasi kasir mudah digunakan dalam situasi sibuk di toko material tanpa membebani konsentrasi pengguna.

Prinsip desain yang diterapkan meliputi:
1.  **Ergonomis & Intuitif:** Tata letak tombol navigasi, pencarian produk, dan keranjang belanja disusun secara logis. Kasir tidak memerlukan pelatihan intensif untuk memahami alur transaksi karena layout kasir dibagi secara natural (katalog di sisi kiri, keranjang di sisi kanan).
2.  **Skema Warna Kontras Tinggi:** Menggunakan basis warna *Slate* (abu-abu gelap modern) dan putih bersih, dengan aksen warna *Amber* (oranye-kuning hangat) sebagai penanda visual penting (seperti tombol aksi utama, logo toko material, dan indikator warning stok). Skema warna ini memberikan kesan profesional sekaligus memudahkan pembacaan teks di layar.
3.  **Tipografi Modern:** Menggunakan jenis huruf *Plus Jakarta Sans* yang memiliki tingkat keterbacaan (readability) tinggi pada berbagai ukuran layar monitor desktop, tablet, maupun mobile.
4.  **Responsive Grid Layout:** Layout dirancang fleksibel menggunakan grid Tailwind CSS agar tampilan sidebar dapat tersembunyi secara dinamis (collapsible menu) pada layar mobile, memberikan kenyamanan bagi owner yang memantau laporan dari smartphone.

---

## 4.2 Mockup / Wireframe (Struktur Antarmuka)
Berikut adalah gambaran sketsa tata letak (wireframe) halaman utama aplikasi BuildTrust-POS:

### A. Wireframe Halaman Kasir (Point of Sale)
```text
+---------------------------------------------------------------------------------------------------+
|  [Hammer] BuildTrust POS    User: Amirah (Kasir)                           [Status Keamanan Aktif] |
+---------------------------------------------------------------------------------------------------+
|  [Sidebar Nav]        |  Cari Produk: [...........................]  | Keranjang Transaksi        |
|  - Dashboard          |  Kategori: [Semua] [Semen] [Pipa] [Besi]     | Pelanggan: [Umum/Budi...]  |
|  - Transaksi Kasir    |  +---------------------+  +---------------+  | Metode: [Tunai         |v] |
|  - Jurnal Umum        |  | Semen Tiga Roda     |  | Pipa PVC      |  | +------------------------+ |
|  - Buku Besar         |  | Rp 68.000           |  | Rp 125.000    |  | | Semen x 2  = Rp 136.000 | |
|  - Inventaris         |  | Stok: 12 Sak        |  | Stok: 35 Btg  |  | | Pipa  x 1  = Rp 125.000 | |
|  - Log Keamanan       |  +---------------------+  +---------------+  | +------------------------+ |
|                       |  | Besi Beton 10mm     |  | Cat Dulux     |  | Subtotal   : Rp 261.000  |
|  [Pembuat Proyek]     |  | Rp 85.000           |  | Rp 245.000    |  | Pajak 11%  : Rp  28.710  |
|  Kelompok 28          |  | Stok: 8 Btg [Limit] |  | Stok: 4 Pail  |  | Total      : Rp 289.710  |
|                       |  +---------------------+  +---------------+  | Uang Bayar : [ 300000  ] |
|                       |                                              | Kembalian  : Rp  10.290  |
|                       |                                              | [ PROSES TRANSAKSI & NT ]  |
+---------------------------------------------------------------------------------------------------+
```

### B. Wireframe Halaman Buku Besar (T-Account)
```text
+---------------------------------------------------------------------------------------------------+
|  [Hammer] BuildTrust POS    User: Kayla (Admin)                            [Status Keamanan Aktif] |
+---------------------------------------------------------------------------------------------------+
|  [Sidebar Nav]        |  Buku Besar Akuntansi (T-Account)            Filter Akun: [Kas Toko     |v] |
|  - Dashboard          |  +---------------------------------------------------------------------+  |
|  - Transaksi Kasir    |  |                         111 - KAS TOKO                              |  |
|  - Jurnal Umum        |  +----------------------------------+----------------------------------+  |
|  - Buku Besar         |  | DEBET (MASUK)                    | KREDIT (KELUAR)                  |  |
|  - Inventaris         |  +----------------------------------+----------------------------------+  |
|  - Log Keamanan       |  | 18/05/2026   Rp 15.000.000 (Mdl) | 30/06/2026   Rp      0           |  |
|                       |  | 30/06/2026   Rp    289.710 (Nota)|                                  |  |
|  [Pembuat Proyek]     |  |                                  |                                  |  |
|  Kelompok 28          |  +----------------------------------+----------------------------------+  |
|                       |  | Total Debet: Rp 15.289.710       | Total Kredit: Rp 0               |  |
|                       |  +----------------------------------+----------------------------------+  |
|                       |  | SALDO AKHIR DEBET: Rp 15.289.710                                    |  |
|                       |  +---------------------------------------------------------------------+  |
+---------------------------------------------------------------------------------------------------+
```

---

## 4.3 Deskripsi Tampilan
Detail fungsional elemen visual pada setiap layar aplikasi BuildTrust-POS dijabarkan sebagai berikut:

### 1. Layar Login
*   **Latar Belakang:** Berwarna gelap pekat (*Slate-950*) dengan ornamen kisi-kisi titik oranye radial, menggambarkan sistem perlindungan yang aman.
*   **Elemen Utama:** Form login di tengah dengan kolom input *Username*, *Password*, dan tombol *Masuk ke Sistem*.
*   **Notifikasi Error:** Alert box merah jika kredensial salah, serta info kelulusan kelompok 28 di bagian footer.

### 2. Header Bar Utama
*   **Judul Halaman Dinamis:** Berubah otomatis menunjukkan nama menu yang aktif (Dashboard Utama, Transaksi Kasir, Jurnal Umum, dll.).
*   **Indikator Status Keamanan:** Badge hijau berkedip dengan tulisan *"Status Keamanan Aktif"*.
*   **Kartu User:** Profil pengguna aktif yang menunjukkan foto inisial nama, nama pengguna lengkap, dan wewenang (role).

### 3. Halaman Dashboard Utama
*   **KPI Cards:** Empat kartu ringkasan keuangan berwarna putih bersih dengan ikon Lucide (Wallet, Banknote, Package, Shield) untuk memantau: Saldo Kas, Total Pendapatan, Nilai Persediaan, dan Potensi Kebocoran Kas.
*   **financialChart:** Grafik garis (Line Chart) interaktif Chart.js yang memvisualisasikan tren kenaikan akun Kas Toko dan Pendapatan Penjualan.
*   **Alert Stok Minimum:** Sisi kanan dashboard menampilkan widget list barang-barang yang stoknya kritis (di bawah batas minimum) dengan label oranye *"Reorder!"* sebagai pengingat restock barang.

### 4. Halaman Transaksi Kasir
*   **Katalog Material (Kiri):** Filter kategori barang menggunakan model *chips* horizontal. Input teks pencarian berfungsi menyaring material secara instan berdasarkan nama atau merk.
*   **Keranjang Belanja (Kanan):** Daftar belanja kasir yang mencatat kuantitas barang dengan tombol pengubah kuantitas interaktif. Terdapat opsi pemilihan metode pembayaran (Tunai, Transfer, Tempo) dan kalkulator pembayaran tunai yang secara instan menghitung kembalian uang pelanggan secara real-time.

### 5. Halaman Jurnal Umum
*   **Tabel Jurnal:** Berisi data tanggal transaksi, nomor jurnal unik (misal: JRN-7281), nama akun akuntansi (Kas Toko, Pendapatan Penjualan, HPP, Persediaan), nomor referensi (ref), serta kolom Debet dan Kredit yang berimbang.
*   **Tombol Reset Jurnal:** Tombol khusus admin di sudut kanan atas untuk mengembalikan database keuangan toko ke kondisi seed modal awal.

### 6. Halaman Log Keamanan
*   **Log Timeline:** Visualisasi timeline vertikal dengan dot berwarna (biru untuk info sesi, hijau untuk transaksi sukses, dan merah untuk warning stok kritis). Setiap log mencatat timestamp presisi, nama aktor, dan deskripsi tindakan guna audit trail.
