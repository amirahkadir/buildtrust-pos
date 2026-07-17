# BAB 2: DESKRIPSI SISTEM

## 2.1 Gambaran Umum Aplikasi
Aplikasi **BuildTrust-POS** dirancang sebagai sistem POS kasir web dinamis terpadu. Antarmuka sistem dibagi menjadi dua wilayah visual utama: Sidebar Navigasi di sisi kiri dan Area Konten Dinamis di sisi kanan. Aplikasi ini bekerja secara satu halaman penuh (Single Page Application-like) yang diatur menggunakan manipulasi DOM JavaScript agar interaksi terasa sangat cepat dan responsif.

Alur interaksi pengguna secara ringkas dimulai saat pengguna masuk (login) ke dalam sistem menggunakan kredensial terdaftar. Setelah login berhasil diverifikasi oleh API backend `api.php`, pengguna akan diarahkan ke modul kerja yang sesuai dengan hak aksesnya:
1.  **Dashboard Utama:** Menampilkan indikator kinerja utama keuangan (KPI Cards) seperti Saldo Kas, Total Pendapatan, Nilai Persediaan, Chart Aliran Kas & Pendapatan harian, serta Alert Stok material kritis.
2.  **Transaksi Kasir:** Kasir memilih material bangunan dari katalog terfilter, memasukkan item belanja ke keranjang belanja, menentukan nama pelanggan, memilih metode pembayaran, menginput uang pembayaran (jika tunai), lalu mengeklik tombol proses transaksi. 
3.  **Pengolahan Otomatis Backend:** API backend memproses transaksi di dalam sebuah blok transaksi database MySQL. Sistem otomatis mengurangi stok material bangunan, mencetak nota transaksi, mencatat entri double-entry pada modul Jurnal Umum & Buku Besar akuntansi secara dinamis, dan mencatat log audit ke modul Log Keamanan.
4.  **Nota Digital:** Setelah checkout sukses, sistem menampilkan modal popup Nota Belanja Digital lunas yang siap dicetak ke printer fisik atau disimpan.

---

## 2.2 Stakeholder dan User
Sistem membedakan tiga stakeholder (pengguna) utama berdasarkan peran (role) yang terdaftar pada basis data MySQL dengan pemetaan hak akses sebagai berikut:

| Peran (Role) | Perwakilan Pengguna | Wewenang dan Fitur yang Dapat Diakses |
| :--- | :--- | :--- |
| **Admin** | Manajer Operasional Toko / Kepala Gudang | *   Mengakses form Kasir untuk penjualan.<br>*   Mengelola (menambah) produk/material bangunan baru.<br>*   Melihat dan mereset Jurnal Umum & Buku Besar.<br>*   Melihat dan mengosongkan Log Keamanan.<br>*   Melakukan reset database keuangan ke kondisi default. |
| **Kasir** | Staf Kasir Penjualan | *   Mengakses form Kasir untuk melayani penjualan pelanggan.<br>*   Melihat katalog produk beserta jumlah stok aktual di halaman Kasir.<br>*   Mengakses Nota Belanja untuk dicetak.<br>*   Dilarang mengakses menu Jurnal Umum, Buku Besar, Log Keamanan, serta fitur reset. |
| **Owner** | Pemilik Toko Material | *   Memantau grafik keuangan dan KPI finansial di Dashboard Utama.<br>*   Melihat laporan Jurnal Umum secara real-time.<br>*   Melihat pergerakan Buku Besar (T-Account) untuk audit saldo.<br>*   Memantau Log Keamanan untuk melacak kecurigaan fraud.<br>*   Dilarang memproses transaksi kasir, menambah material baru, menghapus log, atau mereset basis data. |

---

## 2.3 Kebutuhan Fungsional (Functional Requirements)
Aplikasi ini memiliki daftar kebutuhan fungsional utama agar dapat beroperasi sesuai dengan tujuan bisnis:

1.  **F-01: Login dan Logout Sesi:** Sistem harus membatasi akses ke API dan halaman dashboard hanya bagi pengguna yang memiliki sesi aktif. Sesi login dicatat ke dalam log audit keamanan.
2.  **F-02: Transaksi Penjualan (POS):** Kasir harus dapat menambahkan barang, memperbarui kuantitas (qty), menghitung subtotal belanja, PPN 11%, dan total belanja secara otomatis.
3.  **F-03: Pencatatan Pembukuan Otomatis (Auto-Ledger):** Setiap transaksi penjualan harus langsung memicu backend untuk membuat dua pasang entri jurnal umum secara double-entry:
    *   Mendebit akun *Kas Toko* dan mengkredit akun *Pendapatan Penjualan* sebesar Total Transaksi.
    *   Mendebit akun *HPP* dan mengkredit akun *Persediaan Barang* sebesar 75% dari Subtotal Transaksi.
4.  **F-04: Buku Besar Dinamis (T-Accounts):** Sistem wajib mengklasifikasikan transaksi jurnal ke dalam kartu T-Account (Kas Toko, Persediaan Barang, Pendapatan Penjualan, HPP) secara dinamis sesuai ref akun.
5.  **F-05: Peringatan Stok Limit (Low-Stock Alert):** Sistem harus menampilkan status barang "Harus Reorder!" di dashboard dan inventaris secara visual, serta otomatis mencatatkan log peringatan ("warning") ke dalam database apabila stok barang menyentuh atau berada di bawah limit minimum.
6.  **F-06: Manajemen Katalog Material:** Admin harus dapat menambahkan material baru dengan spesifikasi nama, merk, kategori, harga satuan, stok awal, limit stok reorder, dan catatan konversi satuan.
7.  **F-07: Log Aktivitas Keamanan (Audit Trail):** Sistem harus mendokumentasikan setiap aksi kritis (login sukses, transaksi sukses, tambah barang baru, stok di bawah limit, log dihapus, db reset) ke tabel log database.
8.  **F-08: Reset Database Keuangan:** Admin harus dapat membersihkan seluruh history transaksi, log, dan jurnal guna mengembalikan saldo modal operasional ke Rp 15.000.000 (Kas) dan pendapatan Rp 0.

---

## 2.4 Kebutuhan Non-Fungsional (Non-Functional Requirements)
Spesifikasi teknis di sisi kualitas sistem (non-fungsional) dijabarkan sebagai berikut:

1.  **Keamanan Finansial & Data (Security):**
    *   Semua password pengguna harus terenkripsi dengan aman di database menggunakan hash **bcrypt** (cost factor 12) untuk mencegah kebocoran kredensial.
    *   Setiap pemanggilan API backend di [api.php](file:///c:/xampp/htdocs/buildtrust-pos/api.php) wajib melalui pengecekan otorisasi session dan hak akses peran (RBAC) guna mencegah *direct endpoint manipulation* oleh kasir atau pihak eksternal.
2.  **Integritas Data (Data Integrity):**
    *   Penyimpanan database menggunakan engine InnoDB yang mendukung ACID (Atomicity, Consistency, Isolation, Durability).
    *   Seluruh proses penulisan transaksi kasir (pengurangan stok, insert transaksi, insert detail item, insert entri jurnal, insert log) dibungkus di dalam mekanisme Transaction PHP PDO (`beginTransaction()`, `commit()`, `rollBack()`) agar data tidak parsial/korup jika terjadi gangguan server di tengah jalan.
    *   Batasan Kunci Asing (Foreign Keys) disetel `ON DELETE CASCADE` untuk relasi item transaksi dan `ON DELETE SET NULL` untuk jurnal akuntansi agar data jurnal tetap utuh meskipun transaksi induk dibersihkan.
3.  **Performa & Rendering (Performance):**
    *   Aplikasi harus merespons interaksi front-end secara instan (load time halaman di bawah 1 detik di jaringan localhost).
    *   Visualisasi grafik aliran kas menggunakan Chart.js harus dirender secara real-time berdasarkan data state terbaru tanpa membebani browser.
4.  **Kemudahan Penggunaan (Usability):**
    *   Desain antarmuka responsif menggunakan Tailwind CSS agar nyaman dioperasikan baik pada layar monitor komputer (kasir) maupun layar tablet/smartphone (owner).
    *   Layout visual menggunakan ikon modern dari Lucide Icons dan font *Plus Jakarta Sans* yang ergonomis bagi mata kasir saat beroperasi dalam waktu lama.
