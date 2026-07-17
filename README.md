# Panduan Menjalankan BuildTrust POS di Localhost

Aplikasi **BuildTrust POS** telah berhasil dimigrasikan dari aplikasi *in-memory* menjadi aplikasi dinamis penuh menggunakan **PHP Native & MySQL**. 

Berikut adalah langkah-langkah untuk mencoba aplikasi ini di localhost Anda (XAMPP / Laragon).

---

## Prasyarat
1. Terinstal **XAMPP** atau **Laragon** di komputer Anda.
2. Apache dan MySQL Web Server harus aktif.

---

## Langkah 1: Aktifkan Server & MySQL
1. Buka aplikasi **XAMPP Control Panel** (atau Laragon).
2. Klik tombol **Start** pada modul **Apache** dan **MySQL**.

---

## Langkah 2: Buat Database di phpMyAdmin
1. Buka browser Anda dan akses: [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
2. Klik tab **Database** (Basis Data).
3. Buat database baru dengan nama: **`db_buildtrust_pos`**
4. Klik tombol **Create** (Buat).

---

## Langkah 3: Impor Tabel & Data Awal (`database.sql`)
1. Pilih database **`db_buildtrust_pos`** di panel sebelah kiri phpMyAdmin.
2. Klik tab **Import** (Impor) di bagian menu atas.
3. Klik tombol **Choose File** (Pilih File) dan pilih berkas **`database.sql`** yang terletak di folder proyek Anda:
   `C:\xampp\htdocs\buildtrust-pos\database.sql`
4. Gulir ke bawah dan klik tombol **Import** (Impor / Kirim).
5. Pastikan semua tabel (`products`, `transactions`, `transaction_items`, `jurnal`, `activity_logs`) berhasil terbuat.

---

## Langkah 4: Coba Aplikasi di Browser
1. Buka browser Anda dan akses:
   [http://localhost/buildtrust-pos/dashboard.php](http://localhost/buildtrust-pos/dashboard.php)
2. Aplikasi BuildTrust POS siap digunakan!

---

## Fitur yang Dapat Dicoba:
1. **Transaksi Kasir**: Tambahkan barang ke keranjang belanja di tab Kasir, pilih metode pembayaran, masukkan uang yang dibayarkan (jika Tunai), lalu klik **Proses Transaksi**. Struk belanja digital (Nota) akan muncul secara pop-up dan stok material akan berkurang secara real-time.
2. **Jurnal Umum & Buku Besar**: Setelah transaksi, beralihlah ke tab **Jurnal Umum** dan **Buku Besar**. Anda akan melihat entri pembukuan akuntansi (double-entry) terbuat otomatis, dan Buku Besar (Kas, Persediaan, Pendapatan, HPP) terupdate sesuai nilai transaksi.
3. **Stok & Inventaris**: Anda dapat memantau stok produk, melihat alert stok minimum, dan menambahkan produk baru dengan tombol **Tambah Material Baru**.
4. **Log Aktivitas Keamanan**: Setiap aksi transaksi sukses, peringatan stok menipis, atau reset data terekam secara aman pada tab **Log Keamanan** untuk mencegah fraud karyawan.
5. **Reset Keuangan**: Di tab Jurnal Umum, Anda dapat mengklik tombol **Reset Jurnal** untuk membersihkan semua riwayat transaksi dan mengembalikan kondisi keuangan & stok ke kondisi inisial default (seeding).
