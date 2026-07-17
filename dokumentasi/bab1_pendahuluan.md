# BAB 1: PENDAHULUAN

## 1.1 Latar Belakang
Toko material dan bahan bangunan tradisional sering kali menghadapi kendala serius dalam operasional harian mereka. Masalah utama yang sering muncul adalah ketidakakuratan pencatatan transaksi penjualan, kesulitan pemantauan stok fisik yang dinamis secara real-time, serta kerumitan dalam penyusunan laporan keuangan. Sebagian besar toko bangunan masih mengandalkan pencatatan manual di buku besar fisik atau menggunakan aplikasi kasir sederhana yang tidak terintegrasi langsung dengan modul akuntansi akurat. 

Selain itu, toko material menjual barang dengan variasi satuan yang kompleks (misalnya semen per sak atau kilogram, pipa per batang atau meter). Kondisi ini menyebabkan rawan terjadi selisih stok (inventory discrepancy) antara data catatan dengan fisik di gudang. Masalah lain yang tak kalah penting adalah risiko kebocoran kas (fraud) akibat tindakan manipulasi harga jual atau penghapusan transaksi penjualan secara sepihak oleh oknum karyawan tanpa adanya pengawasan log yang ketat. 

Oleh karena itu, pengembangan aplikasi **BuildTrust-POS** menjadi sangat krusial. Aplikasi ini dirancang untuk menjembatani celah tersebut dengan mengintegrasikan transaksi kasir (Point of Sale) secara real-time dengan modul pembukuan akuntansi otomatis (Jurnal Umum & Buku Besar) berbasis double-entry serta pengawasan aktivitas audit keamanan sistem yang andal.

---

## 1.2 Nama Aplikasi dan Dasar Ide
Nama **BuildTrust-POS** berasal dari penggabungan kata:
*   **Build** (Membangun): Merepresentasikan fokus bidang bisnis aplikasi ini, yaitu toko material/bahan bangunan, sekaligus menyimbolkan proses konstruksi sistem yang kokoh.
*   **Trust** (Kepercayaan): Melambangkan nilai integritas finansial dan transparansi yang ingin ditawarkan oleh sistem kepada pemilik toko (owner) melalui catatan pembukuan otomatis yang tidak dapat dimanipulasi serta log keamanan audit yang ketat.
*   **POS** (Point of Sale): Menunjukkan fungsi utama sistem sebagai aplikasi kasir penjualan.

Dasar ide pembuatan aplikasi ini muncul dari observasi kelompok 28 (Mahasiswa D4 Teknik Informatika, Universitas Logistik & Bisnis Internasional) terhadap manajemen keuangan toko kelontong dan toko bahan bangunan di lingkungan sekitar. Banyak pemilik toko mengeluhkan waktu yang tersita setiap malam untuk melakukan rekap manual penjualan harian, menghitung HPP (Harga Pokok Penjualan), mempostingnya ke jurnal, serta kecurigaan atas manipulasi kas oleh kasir. Melalui **BuildTrust-POS**, seluruh proses rekapitulasi manual tersebut dipotong dan diotomatisasi secara instan saat transaksi selesai diproses.

---

## 1.3 Tujuan Pengembangan
Tujuan dari pengembangan aplikasi BuildTrust-POS ini dapat dijabarkan sebagai berikut:

### Tujuan Umum:
*   Membangun sistem informasi Point of Sale (POS) berbasis web yang handal untuk memodernisasi manajemen kasir dan akuntansi pada toko material bangunan.

### Tujuan Khusus:
1.  Mengotomatiskan pencatatan pembukuan keuangan (double-entry accounting) ke dalam **Jurnal Umum** dan **Buku Besar** secara real-time setiap kali checkout selesai diproses.
2.  Menyediakan fitur manajemen inventaris material bangunan yang dinamis dengan visualisasi alert stok minimum untuk mencegah terjadinya kekosongan barang di gudang.
3.  Mengimplementasikan sistem audit trail melalui **Log Aktivitas Keamanan** yang mencatat setiap aksi sensitif user (login, checkout, add product, database reset) guna meminimalkan risiko fraud.
4.  Menerapkan mekanisme kontrol akses berbasis peran (RBAC) bagi Admin, Kasir, dan Owner demi menjaga kerahasiaan dan integritas data operasional toko.

---

## 1.4 Ruang Lingkup
Aplikasi BuildTrust-POS dibatasi oleh ruang lingkup pengembangan berikut:
1.  **Platform & Lingkungan:** Aplikasi dikembangkan berbasis web monolitik yang dijalankan pada server lokal (*localhost*) menggunakan Apache Web Server dan database MySQL (dikonfigurasi menggunakan XAMPP atau Laragon).
2.  **Pengguna Aplikasi (Aktor):** Sistem mendukung tiga peran pengguna utama dengan wewenang terbatas, yaitu **Admin** (akses penuh), **Kasir** (akses transaksi kasir dan stok), dan **Owner** (akses dashboard pemantauan, jurnal umum, buku besar, dan log keamanan).
3.  **Fitur Utama yang Dicakup:**
    *   Autentikasi pengguna menggunakan enkripsi password bcrypt.
    *   Transaksi kasir (checkout belanja) dengan input nama pelanggan, metode pembayaran (Tunai, Transfer, Tempo), input nominal uang pembayaran, kalkulator kembalian otomatis, dan pencetakan nota digital.
    *   Pencatatan akuntansi otomatis (mendebit Kas, mengkredit Pendapatan; mendebit HPP, mengkredit Persediaan) dengan asumsi nilai HPP flat sebesar 75% dari subtotal belanja.
    *   Modul Buku Besar interaktif bersaldo dinamis dalam bentuk visual T-Account.
    *   Manajemen stok barang dengan filter kategori material serta input batasan stok kritis reorder.
    *   Halaman log keamanan real-time untuk pengawasan aktivitas operasional sistem.
    *   Fitur reset basis data untuk memulihkan keuangan toko ke kondisi inisial default (seeding modal operasional Rp 15.000.000).
