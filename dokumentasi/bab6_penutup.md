# BAB 6: PENUTUP

## 6.1 Kesimpulan
Pengembangan aplikasi **BuildTrust-POS** oleh kelompok 28 (D4 Teknik Informatika, Universitas Logistik & Bisnis Internasional) telah berhasil diselesaikan dan diimplementasikan dengan sukses pada lingkungan web server lokal. Berdasarkan hasil pengujian sistem dan operasional fitur, seluruh tujuan pengembangan khusus yang telah ditetapkan pada Bab 1 berhasil dicapai sepenuhnya:
1.  **Integrasi Otomatis Akuntansi:** Sistem terbukti mampu melakukan posting entri akuntansi (double-entry) ke dalam Jurnal Umum dan memperbarui Buku Besar (T-Account) secara instan dan berimbang sesaat setelah kasir memproses transaksi checkout.
2.  **Manajemen Persediaan Real-Time:** Pengurangan jumlah stok produk/material berjalan dinamis dengan indikator visual stok menipis dan sistem warning stok yang akurat.
3.  **Audit Trail Keamanan:** Modul Log Keamanan berhasil mendokumentasikan setiap riwayat operasional kritis (seperti masuk/keluar sistem, transaksi kasir, tambah material baru, stok di bawah limit minimum, dan pembersihan data) secara kronologis untuk mencegah kecurangan (fraud).
4.  **Kontrol Akses yang Kuat:** Pembatasan menu antarmuka berbasis peran (RBAC) bagi Admin, Kasir, dan Owner telah diuji coba dan berfungsi dengan baik guna melindungi integritas database toko material.

Secara keseluruhan, BuildTrust-POS berhasil memberikan solusi modern, transparan, dan efisien bagi toko material bangunan tradisional untuk bertransaksi sekaligus mencatat laporan pembukuan keuangan secara otomatis tanpa harus menguasai keahlian akuntansi yang rumit.

---

## 6.2 Saran Pengembangan
Demi penyempurnaan dan pengembangan aplikasi BuildTrust-POS ke depannya agar memiliki nilai guna komersial yang lebih tinggi, berikut beberapa saran peningkatan fitur yang dapat diimplementasikan:

1.  **Sistem Backup Database Otomatis:** Menambahkan fitur sinkronisasi dan backup database basis data otomatis secara berkala ke cloud storage (seperti Google Drive API atau AWS S3) untuk meminimalkan risiko kehilangan data jika server lokal mengalami kerusakan hardware.
2.  **Modul Laporan Laba Rugi & Neraca:** Mengembangkan modul keuangan lanjutan yang mampu menghasilkan laporan laba rugi bulanan otomatis, neraca keuangan, serta grafik persentase profitabilitas bersih toko untuk memudahkan pengambilan keputusan bisnis oleh owner.
3.  **Integrasi Pemindai Barcode (Barcode Scanner):** Mengintegrasikan form transaksi kasir dengan pustaka pemindai barcode menggunakan kamera web atau hardware scanner agar kasir dapat menginput material ke keranjang belanja lebih cepat dan akurat.
4.  **Modul Manajemen Supplier & Pembelian (Purchasing):** Menambahkan modul untuk mengelola transaksi pembelian barang masuk dari supplier, pencatatan utang dagang toko material, serta histori harga beli barang dari vendor.
5.  **Multi-Cabang Toko (Multi-Outlet):** Mengembangkan arsitektur aplikasi agar mendukung pengelolaan beberapa cabang toko bangunan secara terpusat dengan data inventaris terpisah bagi pemilik toko skala besar.
