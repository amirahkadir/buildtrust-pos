# Software Requirements Specification (SRS) - BuildTrust POS

Dokumen ini menjabarkan spesifikasi kebutuhan fungsional dan non-fungsional untuk aplikasi **BuildTrust POS** (Point of Sale), sebuah sistem kasir dan akuntansi terintegrasi yang dirancang khusus untuk toko material/bahan bangunan.

---

## 1. Deskripsi Umum Sistem
**BuildTrust POS** adalah sistem kasir dinamis berbasis web yang mengintegrasikan transaksi penjualan dengan pencatatan keuangan akuntansi (Jurnal Umum & Buku Besar) secara otomatis. Aplikasi ini mempermudah pemilik toko bangunan untuk memantau stok material secara real-time, memproses transaksi secara cepat, menghasilkan pembukuan akuntansi yang akurat, serta memonitor aktivitas keamanan guna mencegah tindakan fraud oleh karyawan.

---

## 2. Aktor dan Hak Akses (User Roles)
Aplikasi ini mendukung kontrol akses berbasis peran (Role-Based Access Control / RBAC) dengan tiga tipe aktor:

| Peran (Role) | Hak Akses Utama | Batasan |
| :--- | :--- | :--- |
| **Admin** | Mengelola material baru, memproses transaksi kasir, melihat jurnal umum & buku besar, melihat & membersihkan log keamanan, serta melakukan reset data keuangan. | Tidak memiliki batasan aksi di dalam sistem. |
| **Kasir** | Mengakses halaman kasir untuk memproses transaksi belanja pelanggan dan mencetak nota. | Dibatasi untuk menambah material baru, menghapus log keamanan, melihat pembukuan akuntansi, dan melakukan reset data. |
| **Owner** | Memantau dashboard keuangan, melihat laporan jurnal umum & buku besar, serta memantau log keamanan. | Tidak dapat memproses transaksi kasir, menambah material baru, menghapus log, atau mereset data keuangan. |

---

## 3. Aturan Bisnis (Business Rules)

> [!IMPORTANT]
> Aturan berikut diimplementasikan secara langsung di dalam kode aplikasi dan harus dipenuhi oleh setiap transaksi:

1.  **Pajak Transaksi (PPN):** Setiap transaksi dikenakan PPN sebesar **11%** dari subtotal belanja.
2.  **Perhitungan HPP (Harga Pokok Penjualan):** Untuk kebutuhan akuntansi otomatis, nilai HPP diasumsikan sebesar **75%** dari subtotal transaksi (mengimplikasikan margin keuntungan kotor rata-rata sebesar 25%).
3.  **Metode Pembayaran:** Transaksi mendukung metode pembayaran **Tunai** dan **Nontunai** (Transfer/Debit). Untuk metode Tunai, jumlah pembayaran dari pelanggan wajib sama dengan atau lebih besar dari total tagihan.
4.  **Buku Besar Akuntansi (Double-Entry):**
    *   Setiap transaksi kasir sukses akan menghasilkan entri jurnal:
        *   **Jurnal Penjualan:** Mendebit akun *Kas Toko* (Ref 111) dan mengkredit akun *Pendapatan Penjualan* (Ref 411) sebesar Nilai Total (Subtotal + PPN).
        *   **Jurnal HPP:** Mendebit akun *HPP* (Ref 511) dan mengkredit akun *Persediaan Barang* (Ref 113) sebesar Nilai HPP (75% dari Subtotal).
5.  **Limit Stok Minimum:** Sistem memantau batas minimum stok (`min_stok`). Apabila stok produk berkurang hingga menyentuh atau di bawah batas minimum setelah transaksi, sistem otomatis mengeluarkan peringatan keamanan/stok.

---

## 4. Kebutuhan Fungsional (Functional Requirements)

### F-01: Autentikasi Pengguna (Login/Logout)
*   Sistem harus menyediakan form masuk (login) yang aman.
*   Sistem memverifikasi kecocokan username dan password menggunakan enkripsi yang kuat.
*   Setiap sesi login dan logout dicatat di dalam Log Keamanan.

### F-02: Transaksi Kasir (Point of Sale)
*   Sistem menampilkan daftar produk material yang siap dijual beserta detail stok aktual.
*   Kasir dapat memasukkan produk ke keranjang belanja, memperbarui kuantitas (qty), dan memilih metode pembayaran.
*   Sistem menghitung subtotal, PPN (11%), total bayar, dan nominal kembalian (jika tunai) secara otomatis.
*   Stok material berkurang secara real-time setelah transaksi berhasil diproses.
*   Sistem menghasilkan struk/nota digital dalam bentuk pop-up yang siap dicetak.

### F-03: Pembukuan Akuntansi Otomatis
*   Sistem mencatat transaksi secara otomatis ke dalam **Jurnal Umum** menggunakan kaidah double-entry akuntansi (Debit & Kredit berimbang).
*   Sistem memperbarui saldo akun di **Buku Besar** secara dinamis berdasarkan posting transaksi.
*   Akun yang dipantau meliputi: Kas Toko, Persediaan Barang, Pendapatan Penjualan, dan HPP.

### F-04: Manajemen Stok Material
*   Admin dapat menambahkan produk material baru ke dalam katalog (nama, merk, kategori, harga, stok awal, limit stok minimum, dan detail konversi satuan).
*   Sistem menampilkan indikator peringatan visual jika stok suatu barang menipis atau habis.

### F-05: Log Aktivitas Keamanan (Audit Trail)
*   Sistem mencatat aktivitas kritis untuk audit internal toko.
*   Aktivitas yang wajib dicatat meliputi: user masuk/keluar sistem, transaksi kasir sukses, penambahan barang baru, stok menipis (dibawah minimum limit), pembersihan log, dan reset data keuangan.

### F-06: Reset Data Keuangan
*   Admin dapat melakukan pembersihan total data transaksi, item transaksi, jurnal, dan log aktivitas guna memulihkan sistem ke kondisi inisial (seeding data bawaan).

---

## 5. Kebutuhan Non-Fungsional (Non-Functional Requirements)

### NF-01: Keamanan (Security)
*   Semua password pengguna disimpan menggunakan hashing satu arah berstandar industri (**bcrypt** dengan cost 12).
*   Validasi sesi (session-based authentication) diterapkan pada setiap pemanggilan API backend untuk membatasi akses ilegal tanpa login.

### NF-02: Integritas Data (Data Integrity)
*   Penyimpanan data menggunakan relational database engine (InnoDB) dengan batasan kunci asing (Foreign Keys) untuk mencegah adanya data yatim (orphaned data) saat transaksi atau item dihapus.
*   Penggunaan transaksi database (`beginTransaction`, `commit`, `rollBack`) pada backend API untuk memastikan atomisitas transaksi (Atomicity) saat menulis transaksi, memperbarui stok, dan membuat jurnal secara bersamaan.
