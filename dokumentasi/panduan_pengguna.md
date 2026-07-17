# Panduan Instalasi & Penggunaan - BuildTrust POS

Panduan ini berisi langkah-langkah instalasi lingkungan lokal (localhost) serta panduan penggunaan fitur-fitur operasional pada aplikasi **BuildTrust POS**.

---

## 1. Prasyarat Sistem (Prerequisites)

Sebelum menjalankan aplikasi, pastikan komputer Anda telah memenuhi prasyarat berikut:
1.  **Web Server & Database:** Terinstal **XAMPP** atau **Laragon**.
2.  **PHP Version:** PHP versi 7.4 atau yang lebih baru (mendukung extension PDO MySQL).
3.  **Database Server:** MySQL / MariaDB aktif.
4.  **Browser:** Google Chrome, Mozilla Firefox, Microsoft Edge, atau browser modern lainnya.

---

## 2. Panduan Instalasi di Localhost (XAMPP)

Ikuti langkah-langkah berikut untuk memasang aplikasi di komputer Anda:

### Langkah 1: Pindahkan Berkas Proyek
1.  Salin atau pindahkan folder proyek `buildtrust-pos` ke dalam direktori root web server Anda:
    *   Jika menggunakan XAMPP: `C:\xampp\htdocs\buildtrust-pos\`
    *   Jika menggunakan Laragon: `C:\laragon\www\buildtrust-pos\`

### Langkah 2: Aktifkan Apache & MySQL
1.  Buka **XAMPP Control Panel** (atau kontrol panel Laragon).
2.  Klik tombol **Start** pada modul **Apache** dan **MySQL** hingga indikator berwarna hijau.

### Langkah 3: Konfigurasi Database di phpMyAdmin
1.  Buka browser dan akses halaman: [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
2.  Klik tab **Database** (Basis Data) di menu atas.
3.  Buat database baru dengan nama: **`db_buildtrust_pos`**, kemudian klik tombol **Create** (Buat).

### Langkah 4: Impor Tabel & Data Awal
1.  Pilih database **`db_buildtrust_pos`** pada panel kiri phpMyAdmin.
2.  Klik tab **Import** (Impor) di menu bagian atas.
3.  Klik tombol **Choose File** (Pilih Berkas) dan pilih file **`database.sql`** yang terletak di root folder proyek Anda:
    `C:\xampp\htdocs\buildtrust-pos\database.sql`
4.  Gulir ke bawah dan klik tombol **Import** (Kirim) di bagian pojok kanan bawah.
5.  Pastikan seluruh tabel (`products`, `transactions`, `transaction_items`, `jurnal`, `activity_logs`, `users`) berhasil diimpor.

---

## 3. Akun Pengguna Bawaan (Default Accounts)

Sistem telah memiliki tiga akun bawaan dengan hak akses berbeda yang dapat digunakan untuk masuk:

| Username | Password | Peran (Role) | Nama Pengguna | Hak Akses |
| :--- | :--- | :--- | :--- | :--- |
| **`admin`** | `admin` | Admin | Kayla Aura (Admin) | Akses Penuh (Transaksi, Akuntansi, Inventaris, Keamanan, Reset) |
| **`kasir`** | `kasir` | Kasir | Amirah Fauziyyah (Kasir) | Terbatas (Transaksi Kasir & Stok) |
| **`owner`** | `owner` | Owner | Kelompok 28 (Owner) | Terbatas (Dashboard, Jurnal Umum, Buku Besar, Log Keamanan) |

---

## 4. Panduan Fitur & Operasional Aplikasi

Buka browser Anda dan akses aplikasi melalui tautan berikut:
[http://localhost/buildtrust-pos/dashboard.php](http://localhost/buildtrust-pos/dashboard.php)

```text
Layar Login -> Dashboard Utama -> Navigasi Sidebar -> Fitur Operasional
```

### A. Fitur Masuk Sistem (Login)
1.  Masukkan **Username** dan **Password** dari salah satu akun di atas pada form login yang disediakan.
2.  Klik tombol **Masuk ke Sistem**. Jika berhasil, sistem akan mengarahkan Anda ke halaman Dashboard Utama atau halaman Kasir (sesuai peran akun Anda).

### B. Transaksi Kasir (Point of Sale)
*(Dapat diakses oleh Admin dan Kasir)*
1.  Klik menu **Transaksi Kasir** pada sidebar kiri.
2.  Pilih material dari **Katalog Produk** di sebelah kiri. Klik pada kartu produk untuk menambahkannya ke **Keranjang Transaksi**.
3.  Di bagian Keranjang Transaksi (kanan):
    *   Sesuaikan jumlah barang menggunakan tombol `+` atau `-`.
    *   Masukkan nama pelanggan (opsional).
    *   Pilih **Metode Pembayaran** (Tunai, Transfer Bank, atau Tempo).
    *   Jika memilih pembayaran Tunai, masukkan nominal uang yang diserahkan pelanggan pada kolom **Uang Diterima (Rp)** (atau klik **Uang Pas**).
4.  Klik tombol **Proses Transaksi & Cetak Nota**.
5.  **Nota Belanja Digital** akan muncul dalam bentuk pop-up. Anda dapat mengeklik **Cetak Struk Fisik** untuk mencetak nota melalui printer termal/biasa, atau mengeklik **Selesai & Tutup** untuk kembali ke aplikasi.

### C. Jurnal Umum & Buku Besar
*(Dapat diakses oleh Admin dan Owner)*
1.  **Jurnal Umum:** Klik menu **Jurnal Umum** untuk melihat pencatatan double-entry akuntansi dari setiap penjualan. Setiap entri memiliki status berpasangan (Debet pada *Kas Toko* dan Kredit pada *Pendapatan Penjualan*, serta Debet pada *HPP* dan Kredit pada *Persediaan Barang*).
2.  **Buku Besar:** Klik menu **Buku Besar (T-Account)** untuk memantau ringkasan mutasi debit/kredit per akun secara terperinci. Anda dapat memfilter tampilan akun tertentu menggunakan opsi drop-down di pojok kanan atas.

### D. Manajemen Stok & Tambah Material Baru
1.  Klik menu **Inventaris & Satuan** untuk memantau jumlah stok barang, limit stok reorder, dan status ketersediaan barang.
2.  *(Khusus Admin)* Klik tombol **Tambah Material Baru** di bagian kanan atas untuk mendaftarkan produk baru. Isilah formulir dengan lengkap (Nama, Merek, Kategori, Harga Satuan, Stok Awal, Stok Minimum, dan Rasio Konversi Satuan) lalu klik **Simpan Material**.

### E. Log Keamanan & Audit Keuangan
*(Dapat diakses oleh Admin dan Owner)*
1.  Klik menu **Log Keamanan** untuk melihat riwayat audit log aktivitas sensitif.
2.  Sistem merekam setiap aktivitas secara kronologis, seperti login/logout, penambahan barang, transaksi kasir sukses, dan peringatan stok kritis (di bawah limit minimum).
3.  *(Khusus Admin)* Klik tombol **Reset Log Aktivitas** di pojok kanan atas untuk membersihkan seluruh riwayat log sistem.

### F. Reset Data Keuangan
*(Khusus Admin)*
1.  Apabila Anda ingin membersihkan seluruh transaksi percobaan dan mengembalikan data keuangan serta stok barang ke setelan awal (modal awal Rp 15.000.000), buka menu **Jurnal Umum**.
2.  Klik tombol **Reset Jurnal** di pojok kanan atas tabel.
3.  Konfirmasi aksi tersebut. Sistem akan mengosongkan riwayat transaksi kasir, detail item transaksi, jurnal, log audit, serta mengembalikan jumlah stok produk ke data seeding bawaan.
