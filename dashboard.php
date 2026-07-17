<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BuildTrust POS - Manajemen Buku Besar & Pencatatan Keuangan</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Lucide Icons (Untuk icon modern) -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 flex flex-col min-h-screen">

    <!-- Kontainer Utama Aplikasi -->
    <div id="main-app" class="hidden flex flex-col md:flex-row min-h-screen w-full">
        
        <!-- SIDEBAR -->
        <aside class="w-full md:w-72 bg-slate-900 text-white flex flex-col justify-between border-r border-slate-800">
            <div>
                <!-- Header Sidebar -->
                <div class="p-6 border-b border-slate-800 flex items-center gap-3">
                    <div class="p-2.5 bg-amber-500 rounded-xl text-slate-950 font-black shadow-lg shadow-amber-500/20">
                        <i data-lucide="hammer" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h1 class="font-extrabold text-lg tracking-tight">BuildTrust <span class="text-amber-500">POS</span></h1>
                        <p class="text-xs text-slate-400 font-medium">Sistem Keuangan Toko Bangunan</p>
                    </div>
                </div>

                <!-- Navigasi -->
                <nav class="p-4 space-y-1">
                    <button onclick="switchView('dashboard')" id="nav-dashboard" class="nav-btn w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all bg-amber-500 text-slate-950">
                        <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                        <span>Dashboard Utama</span>
                    </button>
                    <button onclick="switchView('kasir')" id="nav-kasir" class="nav-btn w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-slate-300 hover:bg-slate-800 hover:text-white transition-all">
                        <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                        <span>Transaksi Kasir</span>
                    </button>
                    <button onclick="switchView('jurnal')" id="nav-jurnal" class="nav-btn w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-slate-300 hover:bg-slate-800 hover:text-white transition-all">
                        <i data-lucide="book-open" class="w-5 h-5"></i>
                        <span>Jurnal Umum</span>
                    </button>
                    <button onclick="switchView('bukubesar')" id="nav-bukubesar" class="nav-btn w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-slate-300 hover:bg-slate-800 hover:text-white transition-all">
                        <i data-lucide="scale" class="w-5 h-5"></i>
                        <span>Buku Besar (T-Account)</span>
                    </button>
                    <button onclick="switchView('stok')" id="nav-stok" class="nav-btn w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-slate-300 hover:bg-slate-800 hover:text-white transition-all">
                        <i data-lucide="boxes" class="w-5 h-5"></i>
                        <span>Inventaris & Satuan</span>
                    </button>
                    <button onclick="switchView('logs')" id="nav-logs" class="nav-btn w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-slate-300 hover:bg-slate-800 hover:text-white transition-all">
                        <i data-lucide="shield-check" class="w-5 h-5"></i>
                        <span>Log Aktivitas</span>
                    </button>
                </nav>
            </div>

            <!-- Footer Sidebar - Profil Pembuat Dokumen & Logout -->
            <div class="p-4 border-t border-slate-800 bg-slate-950/50 space-y-3">
                <!-- Logged in User Profile Card -->
                <div class="bg-slate-800/40 rounded-xl p-3 border border-slate-800 flex items-center justify-between gap-2">
                    <div class="flex items-center gap-2">
                        <div class="w-8.5 h-8.5 rounded-lg bg-amber-500 text-slate-950 font-extrabold flex items-center justify-center text-xs" id="sidebar-user-avatar">
                            U
                        </div>
                        <div class="text-left leading-tight">
                            <p id="sidebar-user-name" class="text-xs font-bold text-white truncate max-w-[125px]">User</p>
                            <p id="sidebar-user-role" class="text-[10px] text-slate-400 capitalize">Role</p>
                        </div>
                    </div>
                    <button onclick="handleLogout()" title="Keluar Sistem" class="p-2 text-rose-400 hover:text-white bg-rose-500/10 hover:bg-rose-500 rounded-lg transition-all">
                        <i data-lucide="log-out" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>
        </aside>

        <!-- KONTEN UTAMA -->
        <main class="flex-1 flex flex-col min-h-screen overflow-x-hidden">
            
            <!-- HEADER BAR -->
            <header class="bg-white border-b border-slate-200 h-20 px-6 flex items-center justify-between sticky top-0 z-30 shadow-sm">
                <div class="flex items-center gap-4">
                    <button class="md:hidden p-2 text-slate-600 rounded-lg hover:bg-slate-100">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>
                    <div>
                        <h2 id="view-title" class="text-xl font-bold text-slate-900">Dashboard Utama</h2>
                        <p class="text-xs text-slate-500 font-medium">Visualisasi Manajemen Kasir & Jurnal Akuntansi</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="bg-emerald-100 text-emerald-800 text-xs px-3 py-1.5 rounded-full font-bold flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        Status Sistem Online
                    </div>
                    <div class="h-8 w-px bg-slate-200"></div>
                    <div class="flex items-center gap-2">
                        <div class="w-10 h-10 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center font-bold text-slate-700">
                            BT
                        </div>
                        <div class="hidden sm:block text-left">
                            <p id="header-user-name" class="text-xs font-bold text-slate-800">Administrator Utama</p>
                            <p id="header-user-role" class="text-[10px] text-slate-400">Hak Akses: Penuh</p>
                        </div>
                    </div>
                </div>
            </header>

            <!-- AREA KONTEN DINAMIS -->
            <div class="p-6 flex-1 space-y-6">

                <!-- 1. VIEW: DASHBOARD -->
                <section id="view-dashboard" class="space-y-6">
                    <!-- Ringkasan Keuangan (KPI Cards) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex justify-between items-start">
                            <div>
                                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Saldo Kas Toko</p>
                                <h3 id="kpi-kas" class="text-2xl font-bold text-slate-900 mt-2">Rp 12.500.000</h3>
                                <p class="text-[11px] text-emerald-600 font-medium mt-1 flex items-center gap-0.5">
                                    <i data-lucide="trending-up" class="w-3.5 h-3.5"></i> +14.5% dari hari kemarin
                                </p>
                            </div>
                            <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                                <i data-lucide="wallet" class="w-6 h-6"></i>
                            </div>
                        </div>

                        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex justify-between items-start">
                            <div>
                                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Pendapatan</p>
                                <h3 id="kpi-revenue" class="text-2xl font-bold text-slate-900 mt-2">Rp 8.540.000</h3>
                                <p class="text-[11px] text-emerald-600 font-medium mt-1 flex items-center gap-0.5">
                                    <i data-lucide="trending-up" class="w-3.5 h-3.5"></i> Real-time terintegrasi POS
                                </p>
                            </div>
                            <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl">
                                <i data-lucide="banknote" class="w-6 h-6"></i>
                            </div>
                        </div>

                        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex justify-between items-start">
                            <div>
                                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Nilai Persediaan</p>
                                <h3 id="kpi-inventory" class="text-2xl font-bold text-slate-900 mt-2">Rp 45.300.000</h3>
                                <p class="text-[11px] text-slate-500 font-medium mt-1">
                                    Mengikuti HPP Aktual
                                </p>
                            </div>
                            <div class="p-3 bg-amber-50 text-amber-600 rounded-xl">
                                <i data-lucide="package" class="w-6 h-6"></i>
                            </div>
                        </div>

                        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex justify-between items-start">
                            <div>
                                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Potensi Selisih/Kebocoran</p>
                                <h3 class="text-2xl font-bold text-slate-900 mt-2">Rp 0</h3>
                                <p class="text-[11px] text-emerald-600 font-semibold mt-1 flex items-center gap-1">
                                    <i data-lucide="shield" class="w-3.5 h-3.5"></i> Monitoring Sistem Aktif
                                </p>
                            </div>
                            <div class="p-3 bg-rose-50 text-rose-600 rounded-xl">
                                <i data-lucide="alert-triangle" class="w-6 h-6"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Chart Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Chart Keuangan (Debit Kredit) -->
                        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm lg:col-span-2 flex flex-col justify-between">
                            <div class="flex justify-between items-center mb-4">
                                <div>
                                    <h4 class="font-bold text-slate-900">Aliran Akun Kas & Pendapatan</h4>
                                    <p class="text-xs text-slate-400">Pencatatan real-time otomatis dari Buku Besar</p>
                                </div>
                                <span class="text-xs font-bold text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-lg">Update Setiap Detik</span>
                            </div>
                            <div class="h-64 flex items-center justify-center">
                                <canvas id="financialChart" class="w-full h-full"></canvas>
                            </div>
                        </div>

                        <!-- Alert Stok Minimum & Konversi Satuan -->
                        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col">
                            <h4 class="font-bold text-slate-900 mb-1">Alert Stok & Reorder</h4>
                            <p class="text-xs text-slate-400 mb-4">Stok yang menyentuh batas kritis di gudang</p>
                            
                            <div id="stok-alert-container" class="space-y-3 flex-1 overflow-y-auto max-h-64">
                                <!-- Rendered dynamically by JS -->
                            </div>
                        </div>
                    </div>

                    <!-- Alur Kerja / Workflow Real-time POS -->
                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                        <div class="flex items-center gap-2 mb-4">
                            <i data-lucide="git-branch" class="text-amber-500 w-5 h-5"></i>
                            <h4 class="font-bold text-slate-900">Visualisasi Sistem Pengolahan Data (Input &rarr; Proses &rarr; Output)</h4>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
                            <div class="p-4 bg-amber-50/50 rounded-xl border border-amber-100">
                                <span class="px-2 py-0.5 text-[10px] bg-amber-500 text-slate-950 font-bold rounded">INPUT DATA</span>
                                <h5 class="font-semibold text-slate-800 text-sm mt-2">Detail Pembelian Material</h5>
                                <p class="text-xs text-slate-500 mt-1">Kasir memilih barang, menyesuaikan satuan (kg, dus, batang), dan memasukkan jumlah beli.</p>
                            </div>
                            <div class="p-4 bg-emerald-50/50 rounded-xl border border-emerald-100">
                                <span class="px-2 py-0.5 text-[10px] bg-emerald-500 text-white font-bold rounded">PROSES DIGITAL</span>
                                <h5 class="font-semibold text-slate-800 text-sm mt-2">Auto-Ledger & Update Stok</h5>
                                <p class="text-xs text-slate-500 mt-1">Sistem mengurangi stok material secara otomatis & menjurnal transaksi ke dalam akun debet-kredit.</p>
                            </div>
                            <div class="p-4 bg-blue-50/50 rounded-xl border border-blue-100">
                                <span class="px-2 py-0.5 text-[10px] bg-blue-500 text-white font-bold rounded">OUTPUT SISTEM</span>
                                <h5 class="font-semibold text-slate-800 text-sm mt-2">Struk Akurat & Buku Besar</h5>
                                <p class="text-xs text-slate-500 mt-1">Dokumen struk belanja terbit beserta riwayat buku besar lengkap untuk memvalidasi proses retur.</p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- 2. VIEW: TRANSAKSI KASIR (UPGRADED POS SYSTEM) -->
                <section id="view-kasir" class="hidden space-y-6">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        
                        <!-- Panel Katalog Produk (Kiri) -->
                        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm lg:col-span-2 space-y-4">
                            <!-- Search & Filter Controls -->
                            <div class="flex flex-col sm:flex-row gap-3 items-center justify-between">
                                <div class="relative w-full sm:w-72">
                                    <i data-lucide="search" class="absolute left-3.5 top-3 w-4.5 h-4.5 text-slate-400"></i>
                                    <input type="text" id="search-produk" oninput="filterKatalog()" placeholder="Cari nama atau merk material..." class="w-full bg-slate-50 border border-slate-200 pl-10 pr-4 py-2.5 text-xs rounded-xl focus:outline-none focus:border-amber-500 focus:bg-white transition-all">
                                </div>
                                
                                <!-- Category Chips -->
                                <div class="flex gap-1.5 overflow-x-auto w-full sm:w-auto pb-1 sm:pb-0" id="category-chips">
                                    <button onclick="setCategoryFilter('Semua')" class="chip-btn px-3 py-1.5 rounded-lg text-xs font-bold bg-slate-900 text-white transition-all">Semua</button>
                                    <button onclick="setCategoryFilter('Semen')" class="chip-btn px-3 py-1.5 rounded-lg text-xs font-semibold bg-slate-100 text-slate-600 hover:bg-slate-200 transition-all">Semen</button>
                                    <button onclick="setCategoryFilter('Pipa')" class="chip-btn px-3 py-1.5 rounded-lg text-xs font-semibold bg-slate-100 text-slate-600 hover:bg-slate-200 transition-all">Pipa</button>
                                    <button onclick="setCategoryFilter('Besi')" class="chip-btn px-3 py-1.5 rounded-lg text-xs font-semibold bg-slate-100 text-slate-600 hover:bg-slate-200 transition-all">Besi</button>
                                    <button onclick="setCategoryFilter('Cat')" class="chip-btn px-3 py-1.5 rounded-lg text-xs font-semibold bg-slate-100 text-slate-600 hover:bg-slate-200 transition-all">Cat</button>
                                    <button onclick="setCategoryFilter('Kayu')" class="chip-btn px-3 py-1.5 rounded-lg text-xs font-semibold bg-slate-100 text-slate-600 hover:bg-slate-200 transition-all">Kayu</button>
                                </div>
                            </div>
                            
                            <!-- Grid Produk -->
                            <div id="grid-produk-kasir" class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-h-[500px] overflow-y-auto pr-1">
                                <!-- Rendered dynamically by JS -->
                            </div>
                        </div>

                        <!-- Panel Checkout/Keranjang (Kanan) -->
                        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between space-y-6">
                            <div class="space-y-4">
                                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                                    <h4 class="font-bold text-slate-900 flex items-center gap-2">
                                        <i data-lucide="shopping-bag" class="text-amber-500"></i> Keranjang Transaksi
                                    </h4>
                                    <button onclick="clearCart()" class="text-xs text-rose-500 font-semibold hover:underline">Hapus Semua</button>
                                </div>

                                <!-- Input Detail Pelanggan -->
                                <div class="grid grid-cols-1 gap-2.5 bg-slate-50 p-3 rounded-xl border border-slate-200">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Informasi Transaksi</span>
                                    <div>
                                        <label class="block text-[10px] text-slate-500 font-semibold mb-1">Nama Pelanggan (Opsional)</label>
                                        <input type="text" id="kasir-pelanggan" placeholder="Umum / Nama Kontraktor" class="w-full bg-white border border-slate-200 px-3 py-1.5 text-xs rounded-lg focus:outline-none focus:border-amber-500">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] text-slate-500 font-semibold mb-1">Metode Pembayaran</label>
                                        <select id="kasir-metode" class="w-full bg-white border border-slate-200 px-3 py-1.5 text-xs rounded-lg focus:outline-none focus:border-amber-500">
                                            <option value="Tunai">Tunai / Cash</option>
                                            <option value="Transfer Bank">Transfer Bank / QRIS</option>
                                            <option value="Tempo">Kredit / Tempo</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Item Keranjang Belanja -->
                                <div id="cart-container" class="space-y-2.5 max-h-[220px] overflow-y-auto pr-1">
                                    <!-- Dynamic elements from JS -->
                                    <div class="text-center py-8 text-slate-400 text-xs">
                                        <i data-lucide="shopping-cart" class="w-10 h-10 mx-auto mb-2 stroke-1 text-slate-300"></i>
                                        Keranjang belanja kosong. <br>Pilih produk di sebelah kiri.
                                    </div>
                                </div>
                            </div>

                            <!-- Ringkasan Bayar & Kalkulator Pembayaran -->
                            <div class="border-t border-slate-100 pt-4 space-y-3.5">
                                <div class="space-y-1.5 text-xs">
                                    <div class="flex justify-between items-center text-slate-500 font-medium">
                                        <span>Subtotal</span>
                                        <span id="cart-subtotal" class="font-bold text-slate-800">Rp 0</span>
                                    </div>
                                    <div class="flex justify-between items-center text-slate-500 font-medium">
                                        <span>Pajak (11%)</span>
                                        <span id="cart-tax" class="font-bold text-slate-800">Rp 0</span>
                                    </div>
                                    <div class="flex justify-between items-center border-t border-dashed border-slate-200 pt-2 text-sm">
                                        <span class="text-slate-900 font-bold">Total Belanja</span>
                                        <span id="cart-total" class="text-base font-extrabold text-amber-600">Rp 0</span>
                                    </div>
                                </div>

                                <!-- Cash Calculator (Input Nominal Pembayaran & Kembalian) -->
                                <div class="bg-amber-50/50 border border-amber-100 p-3 rounded-xl space-y-2 text-xs">
                                    <div class="flex items-center justify-between">
                                        <label for="input-bayar" class="font-bold text-slate-700">Uang Diterima (Rp)</label>
                                        <button onclick="setNominalPas()" class="text-[10px] text-amber-700 font-bold hover:underline">Uang Pas</button>
                                    </div>
                                    <input type="number" id="input-bayar" oninput="hitungKembalian()" placeholder="Masukkan uang tunai..." class="w-full border border-slate-200 px-3 py-2 text-sm font-bold rounded-lg text-slate-800 focus:outline-none focus:border-amber-500">
                                    
                                    <div class="flex justify-between items-center pt-1 border-t border-amber-200/50 text-xs font-semibold">
                                        <span class="text-slate-500">Uang Kembalian:</span>
                                        <span id="cart-kembalian" class="font-bold text-slate-900">Rp 0</span>
                                    </div>
                                </div>

                              
                                <!-- Tombol Proses Pembayaran -->
                                <button onclick="checkout()" class="w-full bg-slate-900 hover:bg-amber-500 text-white hover:text-slate-950 transition-all py-3.5 rounded-xl font-bold text-sm shadow-md mt-1 flex items-center justify-center gap-2">
                                    <i data-lucide="check-circle" class="w-4.5 h-4.5"></i>
                                    Proses Transaksi & Cetak Nota
                                </button>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- 3. VIEW: JURNAL UMUM -->
                <section id="view-jurnal" class="hidden space-y-6">
                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                        <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-3">
                            <div>
                                <h4 class="font-bold text-slate-900 text-lg">Jurnal Umum Sistem (Pencatatan Otomatis)</h4>
                                <p class="text-xs text-slate-500">Pencatatan berpasangan otomatis setiap terjadi penjualan (Double-entry system)</p>
                            </div>
                            <button onclick="seedInitialJurnal()" class="text-xs bg-slate-100 text-slate-600 px-3 py-1.5 rounded-lg font-semibold hover:bg-slate-200">Reset Jurnal</button>
                        </div>

                        <!-- Tabel Jurnal -->
                        <div class="overflow-x-auto rounded-xl border border-slate-100">
                            <table class="w-full text-sm text-left">
                                <thead class="bg-slate-50 text-slate-500 uppercase text-xs font-bold tracking-wider">
                                    <tr>
                                        <th class="p-4 border-b border-slate-100">Tanggal & Kode</th>
                                        <th class="p-4 border-b border-slate-100">Keterangan Akun</th>
                                        <th class="p-4 border-b border-slate-100">Ref</th>
                                        <th class="p-4 border-b border-slate-100 text-right">Debet (Rp)</th>
                                        <th class="p-4 border-b border-slate-100 text-right">Kredit (Rp)</th>
                                    </tr>
                                </thead>
                                <tbody id="jurnal-table-body" class="divide-y divide-slate-100">
                                    <!-- Rendered dynamically by JS -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

                <!-- 4. VIEW: BUKU BESAR -->
                <section id="view-bukubesar" class="hidden space-y-6">
                    <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4">
                        <div>
                            <h4 class="font-bold text-slate-900 text-lg">Buku Besar Akuntansi Toko Bangunan (T-Accounts)</h4>
                            <p class="text-xs text-slate-500">Klasifikasi transaksi per akun utama untuk mendeteksi anomali aliran kas & material</p>
                        </div>
                        <div class="flex gap-2">
                            <select id="select-account-filter" onchange="renderBukuBesar()" class="text-xs font-semibold bg-white border border-slate-200 rounded-lg px-3 py-2">
                                <option value="all">Tampilkan Semua Akun</option>
                                <option value="111">111 - Kas Toko</option>
                                <option value="113">113 - Persediaan Barang</option>
                                <option value="411">411 - Pendapatan Penjualan</option>
                                <option value="511">511 - HPP (Beban Pokok Penjualan)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Grid Buku Besar -->
                    <div id="bukubesar-grid" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Rendered dynamically by JS (T-Accounts style) -->
                    </div>
                </section>

                <!-- 5. VIEW: STOK & INVENTARIS -->
                <section id="view-stok" class="hidden space-y-6">
                    <!-- Penjelasan Konversi Satuan Toko Bangunan -->
                    <div class="bg-gradient-to-r from-amber-500 to-amber-600 text-slate-950 p-6 rounded-2xl shadow-sm relative overflow-hidden">
                        <div class="relative z-10 max-w-xl space-y-2">
                            <span class="px-2 py-0.5 text-[10px] bg-slate-950 text-white font-bold rounded">LOGIKA SATUAN & KONVERSI</span>
                            <h4 class="font-extrabold text-xl">Sistem Satuan Fleksibel BuildTrust POS</h4>
                            <p class="text-xs text-slate-900/90 leading-relaxed font-medium">Toko bangunan menjual material dalam satuan yang beragam. Misalnya, semen dapat dijual per **Sak** atau **Kilogram (Kg)**, pipa per **Batang** atau per **Meter**. Sistem kami menghitung konversi stok secara real-time demi mencegah selisih fisik gudang.</p>
                        </div>
                        <i data-lucide="info" class="absolute right-6 bottom-6 w-32 h-32 opacity-10 -rotate-12"></i>
                    </div>

                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <h4 class="font-bold text-slate-900">Inventaris Barang & Pengaturan Stok</h4>
                                <p class="text-xs text-slate-400">Kelola stok material utama dan konfigurasi batas reorder minimum</p>
                            </div>
                            <button onclick="openAddProductModal()" class="bg-amber-500 hover:bg-amber-600 text-slate-950 text-xs px-3.5 py-2 rounded-xl font-bold flex items-center gap-1">
                                <i data-lucide="plus-circle" class="w-4 h-4"></i> Tambah Material Baru
                            </button>
                        </div>

                        <!-- Tabel Inventaris -->
                        <div class="overflow-x-auto rounded-xl border border-slate-100">
                            <table class="w-full text-sm text-left">
                                <thead class="bg-slate-50 text-slate-500 uppercase text-xs font-bold tracking-wider">
                                    <tr>
                                        <th class="p-4 border-b border-slate-100">Nama Barang & Merk</th>
                                        <th class="p-4 border-b border-slate-100">Kategori</th>
                                        <th class="p-4 border-b border-slate-100 text-right">Harga Satuan Utama</th>
                                        <th class="p-4 border-b border-slate-100 text-center">Stok Saat Ini</th>
                                        <th class="p-4 border-b border-slate-100 text-center">Stok Minimum</th>
                                        <th class="p-4 border-b border-slate-100 text-center">Konversi Satuan Terdaftar</th>
                                        <th class="p-4 border-b border-slate-100 text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody id="stok-table-body" class="divide-y divide-slate-100">
                                    <!-- Rendered dynamically by JS -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

                <!-- 6. VIEW: LOG AKTIVITAS -->
                <section id="view-logs" class="hidden space-y-6">
                    <div class="bg-rose-50 border border-rose-100 p-5 rounded-2xl flex items-start gap-4">
                        <div class="p-3 bg-rose-500 text-white rounded-xl shadow-md">
                            <i data-lucide="shield-alert" class="w-6 h-6"></i>
                        </div>
                        <div class="space-y-1">
                            <h4 class="font-bold text-rose-900 text-base">Fitur Keamanan: Pencegahan Fraud Toko (`Log_Activity`)</h4>
                            <p class="text-xs text-rose-700 leading-relaxed font-medium">Salah satu risiko terbesar toko bangunan tradisional adalah manipulasi harga jual dan penghapusan transaksi secara ilegal oleh oknum karyawan. Melalui pencatatan audit trail log ini, setiap tindakan kasir dan perubahan inventaris terekam permanen dan tidak dapat diedit kembali oleh kasir biasa.</p>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <h4 class="font-bold text-slate-900">Log Aktivitas Sistem (Keamanan Real-time)</h4>
                                <p class="text-xs text-slate-400">Riwayat audit digital yang mencatat segala bentuk interaksi sensitif sistem</p>
                            </div>
                            <button onclick="clearSystemLogs()" class="text-xs text-rose-500 font-semibold border border-rose-200 px-3 py-1.5 rounded-lg hover:bg-rose-50">Reset Log Aktivitas</button>
                        </div>

                        <!-- Timeline Log -->
                        <div class="relative pl-6 border-l-2 border-slate-100 space-y-6 id-logs-timeline" id="logs-container">
                            <!-- Rendered dynamically by JS -->
                        </div>
                    </div>
                </section>

            </div>
        </main>
    </div>

    <!-- MODAL POPUP: NOTA BELANJA DIGITAL -->
    <div id="nota-modal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center hidden z-50 p-4">
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 w-full max-w-md overflow-hidden flex flex-col animate-in fade-in zoom-in-95 duration-200">
            <!-- Header Nota -->
            <div class="bg-slate-950 p-5 text-white flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <i data-lucide="receipt" class="text-amber-500 w-5 h-5"></i>
                    <h4 class="font-bold text-sm uppercase tracking-wider">STRUK BELANJA DIGITAL #<span id="nota-no"></span></h4>
                </div>
                <button onclick="closeNotaModal()" class="text-slate-400 hover:text-white">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <!-- Isi Nota -->
            <div class="p-6 space-y-4 text-xs font-mono text-slate-800" id="nota-print-area">
                <div class="text-center space-y-1 pb-4 border-b border-dashed border-slate-200">
                    <h3 class="font-bold text-base text-slate-900">TOKO BANGUNAN BUILDTRUST</h3>
                    <p class="text-[10px] text-slate-500">Jl. Raya Sariwangi No. 10, Bandung</p>
                    <p class="text-[10px] text-slate-500">Telp: 0823-9806-1620</p>
                </div>

                <div class="flex justify-between text-slate-500 pt-1">
                    <span>Kasir:</span>
                    <span id="nota-kasir">Amirah / Kayla</span>
                </div>
                <div class="flex justify-between text-slate-500">
                    <span>Pelanggan:</span>
                    <span id="nota-pelanggan-name" class="font-bold text-slate-900"></span>
                </div>
                <div class="flex justify-between text-slate-500">
                    <span>Metode:</span>
                    <span id="nota-payment-method" class="font-bold text-slate-800"></span>
                </div>
                <div class="flex justify-between text-slate-500">
                    <span>Tanggal:</span>
                    <span id="nota-tanggal"></span>
                </div>
                <div class="flex justify-between text-slate-500 border-b border-dashed border-slate-200 pb-3">
                    <span>Status:</span>
                    <span class="text-emerald-600 font-bold">LUNAS - REGISTERED LEDGER</span>
                </div>

                <!-- Daftar Barang Terbeli -->
                <div class="space-y-2 py-3 border-b border-dashed border-slate-200">
                    <div class="flex justify-between text-[11px] font-bold text-slate-500">
                        <span>Nama Barang</span>
                        <span>Total</span>
                    </div>
                    <div id="nota-items" class="space-y-1.5">
                        <!-- Dynamic items -->
                    </div>
                </div>

                <!-- Bagian Keuangan -->
                <div class="space-y-1.5 text-right pt-2 text-slate-500">
                    <div class="flex justify-between">
                        <span>Subtotal:</span>
                        <span id="nota-subtotal">Rp 0</span>
                    </div>
                    <div class="flex justify-between">
                        <span>PPN (11%):</span>
                        <span id="nota-tax">Rp 0</span>
                    </div>
                    <div class="flex justify-between text-sm font-bold text-slate-950 pt-1.5 border-t border-slate-100">
                        <span>TOTAL AKHIR:</span>
                        <span id="nota-total">Rp 0</span>
                    </div>
                    <div class="flex justify-between text-slate-600 pt-1">
                        <span>Jumlah Dibayar:</span>
                        <span id="nota-bayar">Rp 0</span>
                    </div>
                    <div class="flex justify-between text-amber-700 font-bold">
                        <span>Uang Kembalian:</span>
                        <span id="nota-kembalian">Rp 0</span>
                    </div>
                </div>

                <div class="text-center pt-6 space-y-1 border-t border-dashed border-slate-200 text-slate-400 text-[10px]">
                    <p class="font-bold text-slate-600">Terima Kasih Atas Kunjungan Anda!</p>
                    <p>Barang yang sudah dibeli dapat diretur dalam 14 hari</p>
                    <p class="text-emerald-600">Struk tervalidasi database akuntansi BuildTrust POS</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="p-4 bg-slate-50 border-t border-slate-100 flex gap-2">
                <button onclick="window.print()" class="flex-1 bg-slate-900 text-white font-bold py-2.5 rounded-xl text-xs hover:bg-slate-800 transition-colors flex items-center justify-center gap-1.5">
                    <i data-lucide="printer" class="w-4 h-4"></i> Cetak Struk Fisik
                </button>
                <button onclick="closeNotaModal()" class="flex-1 border border-slate-200 text-slate-700 font-bold py-2.5 rounded-xl text-xs hover:bg-slate-100 transition-colors">
                    Selesai & Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- MODAL POPUP: TAMBAH MATERIAL BARU -->
    <div id="product-modal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center hidden z-50 p-4">
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 w-full max-w-md overflow-hidden flex flex-col animate-in fade-in zoom-in-95 duration-200">
            <div class="bg-slate-900 p-5 text-white flex justify-between items-center">
                <h4 class="font-bold text-sm">Tambah Material Bangunan Baru</h4>
                <button onclick="closeProductModal()" class="text-slate-400 hover:text-white">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <form onsubmit="handleNewProductSubmit(event)" class="p-5 space-y-4 text-xs">
                <div>
                    <label class="block text-slate-600 font-bold mb-1">Nama Barang</label>
                    <input type="text" id="add-nama" required class="w-full border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:outline-amber-500" placeholder="Contoh: Semen Gresik">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-slate-600 font-bold mb-1">Merek</label>
                        <input type="text" id="add-merk" required class="w-full border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:outline-amber-500" placeholder="Contoh: Gresik">
                    </div>
                    <div>
                        <label class="block text-slate-600 font-bold mb-1">Kategori</label>
                        <select id="add-kategori" class="w-full border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:outline-amber-500">
                            <option value="Semen">Semen</option>
                            <option value="Pipa">Pipa PVC</option>
                            <option value="Besi">Besi Beton</option>
                            <option value="Cat">Cat & Coating</option>
                            <option value="Kayu">Perkayuan</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-slate-600 font-bold mb-1">Harga Satuan (Rp)</label>
                        <input type="number" id="add-harga" required class="w-full border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:outline-amber-500" placeholder="Contoh: 75000">
                    </div>
                    <div>
                        <label class="block text-slate-600 font-bold mb-1">Satuan Utama</label>
                        <input type="text" id="add-satuan" required class="w-full border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:outline-amber-500" placeholder="Contoh: Sak / Batang / Pail">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-slate-600 font-bold mb-1">Stok Awal</label>
                        <input type="number" id="add-stok" required class="w-full border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:outline-amber-500" placeholder="Contoh: 100">
                    </div>
                    <div>
                        <label class="block text-slate-600 font-bold mb-1">Stok Minimum (Alert)</label>
                        <input type="number" id="add-stok-min" required class="w-full border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:outline-amber-500" placeholder="Contoh: 15">
                    </div>
                </div>
                <div>
                    <label class="block text-slate-600 font-bold mb-1">Rasio Konversi Satuan (Opsional)</label>
                    <input type="text" id="add-konversi" class="w-full border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:outline-amber-500" placeholder="Contoh: 1 Sak = 40 Kg">
                </div>

                <div class="pt-3 border-t border-slate-100 flex gap-2">
                    <button type="button" onclick="closeProductModal()" class="flex-1 border border-slate-200 py-2.5 rounded-xl font-bold text-slate-700 hover:bg-slate-50">Batalkan</button>
                    <button type="submit" class="flex-1 bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold py-2.5 rounded-xl">Simpan Material</button>
                </div>
            </form>
        </div>
    </div>

    <!-- LAYAR LOGIN & REGISTRASI MODERN -->
    <div id="login-screen" class="fixed inset-0 bg-slate-950 flex items-center justify-center z-50 p-4">
        <div class="absolute inset-0 opacity-20 bg-[radial-gradient(#f59e0b_1px,transparent_1px)] [background-size:24px_24px] pointer-events-none"></div>
        <div class="bg-slate-900 border border-slate-800/80 rounded-3xl shadow-2xl shadow-amber-500/5 w-full max-w-md overflow-hidden relative p-8 space-y-6 animate-in fade-in zoom-in-95 duration-300">
            <div class="text-center space-y-2">
                <div class="w-14 h-14 bg-amber-500 rounded-2xl text-slate-950 font-black flex items-center justify-center shadow-lg shadow-amber-500/20 mx-auto">
                    <i data-lucide="hammer" class="w-8 h-8"></i>
                </div>
                <h3 class="text-2xl font-black tracking-tight text-white">BuildTrust <span class="text-amber-500">POS</span></h3>
                <p id="auth-subtitle" class="text-xs text-slate-400 font-medium">Sistem Keuangan & Kasir Toko Bangunan</p>
            </div>
            
            <!-- FORM LOGIN -->
            <form id="login-form" onsubmit="handleLoginSubmit(event)" class="space-y-4 text-xs">
                <div id="login-error-msg" class="hidden p-3.5 bg-rose-500/10 border border-rose-500/30 text-rose-400 font-bold rounded-xl flex items-center gap-2">
                    <i data-lucide="alert-circle" class="w-4 h-4 flex-shrink-0"></i>
                    <span id="login-error-text">Kredensial tidak valid!</span>
                </div>
                
                <div class="space-y-1.5">
                    <label class="block text-slate-400 font-bold">Username</label>
                    <div class="relative">
                        <i data-lucide="user" class="absolute left-3.5 top-3 w-4.5 h-4.5 text-slate-500"></i>
                        <input type="text" id="login-username" required class="w-full bg-slate-950/50 border border-slate-800 focus:border-amber-500 focus:bg-slate-950 text-white pl-10 pr-4 py-3 rounded-xl focus:outline-none transition-all" placeholder="Masukkan username Anda">
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-slate-400 font-bold">Password</label>
                    <div class="relative">
                        <i data-lucide="lock" class="absolute left-3.5 top-3 w-4.5 h-4.5 text-slate-500"></i>
                        <input type="password" id="login-password" required class="w-full bg-slate-950/50 border border-slate-800 focus:border-amber-500 focus:bg-slate-950 text-white pl-10 pr-4 py-3 rounded-xl focus:outline-none transition-all" placeholder="Masukkan password Anda">
                    </div>
                </div>

                <button type="submit" id="login-btn-submit" class="w-full bg-amber-500 hover:bg-amber-600 text-slate-950 font-extrabold py-3.5 rounded-xl text-sm transition-all shadow-lg shadow-amber-500/10 hover:shadow-amber-500/20 active:scale-[0.98] mt-2 flex items-center justify-center gap-2">
                    <span>Masuk ke Sistem</span>
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </button>

                <p class="text-center text-[11px] text-slate-400 mt-4">
                    Belum memiliki akun? 
                    <a href="javascript:void(0)" onclick="toggleAuthView('register')" class="text-amber-500 hover:underline font-bold">Daftar Baru</a>
                </p>
            </form>

            <!-- FORM REGISTRASI -->
            <form id="register-form" onsubmit="handleRegisterSubmit(event)" class="hidden space-y-4 text-xs">
                <div id="register-error-msg" class="hidden p-3.5 bg-rose-500/10 border border-rose-500/30 text-rose-400 font-bold rounded-xl flex items-center gap-2">
                    <i data-lucide="alert-circle" class="w-4 h-4 flex-shrink-0"></i>
                    <span id="register-error-text">Registrasi gagal!</span>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-slate-400 font-bold">Nama Lengkap</label>
                    <div class="relative">
                        <i data-lucide="info" class="absolute left-3.5 top-3 w-4.5 h-4.5 text-slate-500"></i>
                        <input type="text" id="register-nama" required class="w-full bg-slate-950/50 border border-slate-800 focus:border-amber-500 focus:bg-slate-950 text-white pl-10 pr-4 py-3 rounded-xl focus:outline-none transition-all" placeholder="Contoh: Kayla Aura">
                    </div>
                </div>
                
                <div class="space-y-1.5">
                    <label class="block text-slate-400 font-bold">Username</label>
                    <div class="relative">
                        <i data-lucide="user" class="absolute left-3.5 top-3 w-4.5 h-4.5 text-slate-500"></i>
                        <input type="text" id="register-username" required class="w-full bg-slate-950/50 border border-slate-800 focus:border-amber-500 focus:bg-slate-950 text-white pl-10 pr-4 py-3 rounded-xl focus:outline-none transition-all" placeholder="Buat username unik">
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-slate-400 font-bold">Password</label>
                    <div class="relative">
                        <i data-lucide="lock" class="absolute left-3.5 top-3 w-4.5 h-4.5 text-slate-500"></i>
                        <input type="password" id="register-password" required class="w-full bg-slate-950/50 border border-slate-800 focus:border-amber-500 focus:bg-slate-950 text-white pl-10 pr-4 py-3 rounded-xl focus:outline-none transition-all" placeholder="Buat password aman">
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-slate-400 font-bold">Peran (Role)</label>
                    <div class="relative">
                        <i data-lucide="shield-check" class="absolute left-3.5 top-3 w-4.5 h-4.5 text-slate-500"></i>
                        <select id="register-role" required class="w-full bg-slate-900 border border-slate-800 focus:border-amber-500 text-white pl-10 pr-4 py-3 rounded-xl focus:outline-none transition-all cursor-pointer">
                            <option value="kasir">Kasir (Operator POS & Checkout)</option>
                            <option value="owner">Owner / Akuntan (Laporan & Buku Besar)</option>
                            <option value="admin">Administrator (Akses Penuh)</option>
                        </select>
                    </div>
                </div>

                <button type="submit" id="register-btn-submit" class="w-full bg-amber-500 hover:bg-amber-600 text-slate-950 font-extrabold py-3.5 rounded-xl text-sm transition-all shadow-lg shadow-amber-500/10 hover:shadow-amber-500/20 active:scale-[0.98] mt-2 flex items-center justify-center gap-2">
                    <span>Daftar Akun</span>
                    <i data-lucide="arrow-right" class="w-4.5 h-4.5"></i>
                </button>

                <p class="text-center text-[11px] text-slate-400 mt-4">
                    Sudah memiliki akun? 
                    <a href="javascript:void(0)" onclick="toggleAuthView('login')" class="text-amber-500 hover:underline font-bold">Masuk Sekarang</a>
                </p>
            </form>

            <div class="text-center pt-2 border-t border-slate-800/80">
                <span class="text-[10px] text-slate-500 font-medium">Kelompok 28 • Universitas Logistik & Bisnis Internasional</span>
            </div>
        </div>
    </div>

    <!-- JS LOGIC AND STATE MANAGEMENT -->
    <script>
        // --- DATA STATE UTAMA ---
        let products = [];
        let cart = [];
        let currentCategoryFilter = "Semua";
        let jurnal = [];
        let systemLogs = [];
        let financialChart;
        let currentUser = null;

        // Helper untuk format rupiah
        function formatRupiah(angka) {
            return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        // Fungsi mengecek status login di backend
        function checkAuth() {
            return fetch('api.php?action=get_user')
                .then(response => response.json())
                .then(res => {
                    if (res.status === 'success') {
                        currentUser = res.user;
                        document.getElementById('login-screen').classList.add('hidden');
                        document.getElementById('main-app').classList.remove('hidden');

                        // Update layout profil dinamis
                        document.getElementById('header-user-name').innerText = currentUser.nama;
                        document.getElementById('header-user-role').innerText = "Hak Akses: " + currentUser.role.toUpperCase();

                        document.getElementById('sidebar-user-name').innerText = currentUser.nama.split(' ')[0];
                        document.getElementById('sidebar-user-role').innerText = currentUser.role;
                        document.getElementById('sidebar-user-avatar').innerText = currentUser.nama.charAt(0);

                        applyRBAC(currentUser.role);
                        return true;
                    } else {
                        currentUser = null;
                        document.getElementById('main-app').classList.add('hidden');
                        document.getElementById('login-screen').classList.remove('hidden');
                        return false;
                    }
                })
                .catch(err => {
                    console.error("Gagal verifikasi autentikasi:", err);
                    return false;
                });
        }

        // Fungsi penyaringan menu sidebar berdasarkan role (RBAC)
        function applyRBAC(role) {
            const navDashboard = document.getElementById('nav-dashboard');
            const navKasir = document.getElementById('nav-kasir');
            const navJurnal = document.getElementById('nav-jurnal');
            const navBukuBesar = document.getElementById('nav-bukubesar');
            const navStok = document.getElementById('nav-stok');
            const navLogs = document.getElementById('nav-logs');

            const allNavs = [navDashboard, navKasir, navJurnal, navBukuBesar, navStok, navLogs];
            allNavs.forEach(nav => {
                if (nav) nav.classList.remove('hidden');
            });

            // Tampilkan tombol tambah material hanya untuk admin
            const btnAddMaterial = document.querySelector('button[onclick="openAddProductModal()"]');
            if (btnAddMaterial) {
                if (role === 'owner') {
                    btnAddMaterial.classList.remove('hidden');
                } else {
                    btnAddMaterial.classList.add('hidden');
                }
            }

            // Sembunyikan tombol reset log aktivitas jika bukan admin
            const btnClearLogs = document.querySelector('button[onclick="clearSystemLogs()"]');
            if (btnClearLogs) {
                if (role === 'owner') {
                    btnClearLogs.classList.remove('hidden');
                } else {
                    btnClearLogs.classList.add('hidden');
                }
            }

            // Sembunyikan tombol reset jurnal jika bukan admin
            const btnResetJurnal = document.querySelector('button[onclick="seedInitialJurnal()"]');
            if (btnResetJurnal) {
                if (role === 'owner') {
                    btnResetJurnal.classList.remove('hidden');
                } else {
                    btnResetJurnal.classList.add('hidden');
                }
            }

            if (role === 'kasir') {
                if (navJurnal) navJurnal.classList.add('hidden');
                if (navBukuBesar) navBukuBesar.classList.add('hidden');
                if (navLogs) navLogs.classList.add('hidden');

                const viewTitle = document.getElementById('view-title').innerText;
                if (!viewTitle.includes("Kasir") && !viewTitle.includes("Dashboard")) {
                    switchView('kasir');
                }
            } else if (role === 'admin') {
                if (navKasir) navKasir.classList.add('hidden');

                const viewTitle = document.getElementById('view-title').innerText;
                if (viewTitle.includes("Kasir")) {
                    switchView('dashboard');
                }
            }
        }

        // Toggle tampilan antara login dan register
        function toggleAuthView(view) {
            const loginForm = document.getElementById('login-form');
            const registerForm = document.getElementById('register-form');
            const subtitle = document.getElementById('auth-subtitle');
            
            if (view === 'register') {
                loginForm.classList.add('hidden');
                registerForm.classList.remove('hidden');
                subtitle.innerText = "Daftar Akun Baru BuildTrust POS";
                window.location.hash = 'register';
            } else {
                registerForm.classList.add('hidden');
                loginForm.classList.remove('hidden');
                subtitle.innerText = "Sistem Keuangan & Kasir Toko Bangunan";
                window.location.hash = '';
            }
            lucide.createIcons();
        }

        // Penanganan register form submit
        function handleRegisterSubmit(e) {
            e.preventDefault();
            const namaVal = document.getElementById('register-nama').value;
            const usernameVal = document.getElementById('register-username').value;
            const passwordVal = document.getElementById('register-password').value;
            const roleVal = document.getElementById('register-role').value;
            
            const errorMsg = document.getElementById('register-error-msg');
            const errorText = document.getElementById('register-error-text');
            const btnSubmit = document.getElementById('register-btn-submit');

            btnSubmit.disabled = true;
            btnSubmit.innerHTML = 'Memproses registrasi...';

            fetch('api.php?action=register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    nama: namaVal,
                    username: usernameVal,
                    password: passwordVal,
                    role: roleVal
                })
            })
            .then(res => res.json())
            .then(res => {
                btnSubmit.disabled = false;
                btnSubmit.innerHTML = `<span>Daftar Akun</span><i data-lucide="arrow-right" class="w-4.5 h-4.5"></i>`;
                lucide.createIcons();

                if (res.status === 'success') {
                    errorMsg.classList.add('hidden');
                    document.getElementById('register-nama').value = '';
                    document.getElementById('register-username').value = '';
                    document.getElementById('register-password').value = '';
                    
                    toggleAuthView('login');
                    showDialogMessage("Registrasi Berhasil", res.message || "Silakan masuk menggunakan akun baru Anda.", "sukses");
                } else {
                    errorText.innerText = res.message || "Gagal melakukan registrasi!";
                    errorMsg.classList.remove('hidden');
                }
            })
            .catch(err => {
                btnSubmit.disabled = false;
                btnSubmit.innerHTML = `<span>Daftar Akun</span><i data-lucide="arrow-right" class="w-4.5 h-4.5"></i>`;
                lucide.createIcons();
                
                errorText.innerText = "Gagal menghubungi server. Hubungkan ke database.";
                errorMsg.classList.remove('hidden');
                console.error(err);
            });
        }

        // Penanganan login form submit
        function handleLoginSubmit(e) {
            e.preventDefault();
            const usernameInput = document.getElementById('login-username').value;
            const passwordInput = document.getElementById('login-password').value;
            const errorMsg = document.getElementById('login-error-msg');
            const errorText = document.getElementById('login-error-text');
            const btnSubmit = document.getElementById('login-btn-submit');

            btnSubmit.disabled = true;
            btnSubmit.innerHTML = 'Memproses masuk...';

            fetch('api.php?action=login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    username: usernameInput,
                    password: passwordInput
                })
            })
            .then(res => res.json())
            .then(res => {
                btnSubmit.disabled = false;
                btnSubmit.innerHTML = `<span>Masuk ke Sistem</span><i data-lucide="arrow-right" class="w-4 h-4"></i>`;
                lucide.createIcons();

                if (res.status === 'success') {
                    errorMsg.classList.add('hidden');
                    document.getElementById('login-username').value = '';
                    document.getElementById('login-password').value = '';

                    checkAuth().then(() => {
                        loadState().then(() => {
                            if (currentUser.role === 'kasir') {
                                switchView('kasir');
                            } else {
                                switchView('dashboard');
                            }
                            showDialogMessage("Berhasil", "Selamat datang kembali, " + currentUser.nama + "!", "sukses");
                        });
                    });
                } else {
                    errorText.innerText = res.message || "Username atau password salah!";
                    errorMsg.classList.remove('hidden');
                }
            })
            .catch(err => {
                btnSubmit.disabled = false;
                btnSubmit.innerHTML = `<span>Masuk ke Sistem</span><i data-lucide="arrow-right" class="w-4 h-4"></i>`;
                lucide.createIcons();

                errorText.innerText = "Gagal menghubungi server. Hubungkan ke database.";
                errorMsg.classList.remove('hidden');
                console.error(err);
            });
        }

        // Penanganan logout
        function handleLogout() {
            fetch('api.php?action=logout')
                .then(res => res.json())
                .then(res => {
                    if (res.status === 'success') {
                        checkAuth().then(() => {
                            showDialogMessage("Berhasil", "Anda telah keluar dari sistem.", "sukses");
                        });
                    }
                })
                .catch(err => {
                    console.error("Gagal logout:", err);
                    showDialogMessage("Error", "Gagal memproses logout.", "error");
                });
        }

        // Fungsi untuk mengambil State terbaru dari backend
        function loadState() {
            return fetch('api.php?action=get_state')
                .then(response => response.json())
                .then(res => {
                    if (res.status === 'success') {
                        products = res.state.products;
                        jurnal = res.state.jurnal;
                        systemLogs = res.state.logs;
                    } else if (res.message === 'not_logged_in') {
                        checkAuth();
                    } else {
                        showDialogMessage("Error", res.message || "Gagal sinkronisasi data", "error");
                    }
                })
                .catch(err => {
                    console.error("Gagal menghubungi server:", err);
                    showDialogMessage("Koneksi Gagal", "Gagal memuat data dari database. Pastikan Apache & MySQL menyala.", "error");
                });
        }

        // --- SISTEM INISIALISASI ON-LOAD ---
        window.onload = function() {
            checkAuth().then(loggedIn => {
                if (loggedIn) {
                    loadState().then(() => {
                        if (currentUser.role === 'kasir') {
                            switchView('kasir');
                        } else {
                            switchView('dashboard');
                        }
                    });
                } else {
                    if (window.location.hash === '#register') {
                        toggleAuthView('register');
                    }
                }
            });
            lucide.createIcons();
        }

        // Listener perubahan hash URL untuk routing tampilan login/register
        window.addEventListener('hashchange', function() {
            if (!currentUser) {
                if (window.location.hash === '#register') {
                    toggleAuthView('register');
                } else {
                    toggleAuthView('login');
                }
            }
        });

        // --- ROUTING NAVIGASI VIEW ---
        function switchView(viewId) {
            // Sembunyikan semua section
            document.querySelectorAll('section').forEach(section => section.classList.add('hidden'));
            // Tampilkan yang dipilih
            document.getElementById('view-' + viewId).classList.remove('hidden');

            // Set Title Header
            const titleMap = {
                dashboard: "Dashboard Utama & Ringkasan Buku Besar",
                kasir: "Kasir Pembelian Material & POS",
                jurnal: "Pencatatan Jurnal Umum (Double-Entry)",
                bukubesar: "Buku Besar (Pengelompokan Akun Akuntansi)",
                stok: "Inventarisasi Stok & Konversi Satuan",
                logs: "Log Aktivitas Keamanan Sistem"
            };
            document.getElementById('view-title').innerText = titleMap[viewId];

            // Update Class Active Tombol Navigasi
            document.querySelectorAll('.nav-btn').forEach(btn => {
                btn.classList.remove(
                    "bg-amber-500",
                    "text-slate-950",
                    "shadow-lg",
                    "shadow-amber-500/10"
                );

                btn.classList.add(
                    "text-slate-300",
                    "hover:bg-slate-800",
                    "hover:text-white"
                );
            });
            const activeBtn = document.getElementById('nav-' + viewId);
            if (activeBtn) {
                activeBtn.classList.remove(
                    "text-slate-300",
                    "hover:bg-slate-800",
                    "hover:text-white"
                );

                activeBtn.classList.add(
                    "bg-amber-500",
                    "text-slate-950",
                    "shadow-lg",
                    "shadow-amber-500/10"
                );
            }

            // Segarkan data spesifik view dari database
            loadState().then(() => {
                if (viewId === 'dashboard') {
                    updateFinancialKPIs();
                    renderDashboard();
                    if (financialChart) financialChart.destroy();
                    initChart();
                } else if (viewId === 'kasir') {
                    renderKasir();
                } else if (viewId === 'jurnal') {
                    renderJurnal();
                } else if (viewId === 'bukubesar') {
                    renderBukuBesar();
                } else if (viewId === 'stok') {
                    renderStok();
                } else if (viewId === 'logs') {
                    renderLogs();
                }
            });
        }

        // --- RENDER COMPONENT: DASHBOARD ---
        function renderDashboard() {
            updateFinancialKPIs();
            renderLowStockAlerts();
        }

        function updateFinancialKPIs() {
            let totalKas = 0;
            let totalPendapatan = 0;

            jurnal.forEach(j => {
                if (j.ref === "111") totalKas += (j.d - j.k);
                if (j.ref === "411") totalPendapatan += (j.k - j.d);
            });

            // Nilai Persediaan Berdasarkan Harga * Stok Aktual di DB
            let totalNilaiPersediaan = products.reduce((acc, p) => acc + (p.harga * p.stok), 0);

            document.getElementById('kpi-kas').innerText = formatRupiah(totalKas);
            document.getElementById('kpi-revenue').innerText = formatRupiah(totalPendapatan);
            document.getElementById('kpi-inventory').innerText = formatRupiah(totalNilaiPersediaan);
        }

        function renderLowStockAlerts() {
            const container = document.getElementById('stok-alert-container');
            container.innerHTML = '';

            const lowStockProducts = products.filter(p => p.stok <= p.minStok);

            if (lowStockProducts.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-6 text-emerald-600 bg-emerald-50 rounded-xl border border-emerald-100 p-4">
                        <i data-lucide="check-circle" class="w-8 h-8 mx-auto mb-2 text-emerald-500"></i>
                        <p class="text-xs font-bold">Semua Stok Aman!</p>
                        <p class="text-[10px] text-slate-500 mt-1">Tidak ada stok di bawah batas kritis.</p>
                    </div>
                `;
                lucide.createIcons();
                return;
            }

            lowStockProducts.forEach(p => {
                const percent = Math.min(100, Math.max(10, (p.stok / p.minStok) * 100));
                container.innerHTML += `
                    <div class="p-3.5 bg-rose-50 border border-rose-100 rounded-xl space-y-2.5">
                        <div class="flex justify-between items-start">
                            <div>
                                <h5 class="font-bold text-xs text-rose-950">${p.nama}</h5>
                                <p class="text-[10px] text-rose-600 font-semibold mt-0.5">Sisa Stok: ${p.stok} ${p.satuan} (Batas Min: ${p.minStok})</p>
                            </div>
                            <span class="px-2 py-0.5 text-[9px] bg-rose-200 text-rose-700 font-bold rounded-md uppercase">${p.kategori}</span>
                        </div>
                        <div class="space-y-1">
                            <div class="w-full bg-rose-100 rounded-full h-1.5 overflow-hidden">
                                <div class="bg-rose-500 h-1.5 rounded-full" style="width: ${percent}%"></div>
                            </div>
                            <div class="flex justify-between text-[9px] text-rose-500 font-bold">
                                <span>Kapasitas: ${Math.round(percent)}%</span>
                                <span>Reorder Segera</span>
                            </div>
                        </div>
                    </div>
                `;
            });
            lucide.createIcons();
        }

        // --- INISIALISASI CHART DARI DATABASE JURNAL ---
        function initChart() {
            const ctx = document.getElementById('financialChart').getContext('2d');
            
            let kasValues = [];
            let pendapatanValues = [];
            let dates = [];

            let runningKas = 0;
            let runningPendapatan = 0;

            jurnal.forEach(j => {
                if (j.ref === "111") runningKas += (j.d - j.k);
                if (j.ref === "411") runningPendapatan += (j.k - j.d);
                
                // Format tanggal untuk visualisasi chart
                const formattedDate = new Date(j.tanggal).toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
                if (!dates.includes(formattedDate)) {
                    dates.push(formattedDate);
                    kasValues.push(runningKas);
                    pendapatanValues.push(runningPendapatan);
                }
            });

            // Fallback default jika data transaksi masih sedikit
            if (dates.length < 5) {
                dates = ["15 Mei", "16 Mei", "17 Mei", "18 Mei", "19 Mei"];
                kasValues = [10000000, 11200000, 12500000, 13800000, runningKas || 15000000];
                pendapatanValues = [300000, 1500000, 3000000, 4200000, runningPendapatan || 15000000];
            }

            financialChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: dates,
                    datasets: [
                        {
                            label: 'Akun Kas Toko (IDR)',
                            data: kasValues,
                            borderColor: '#3b82f6',
                            backgroundColor: 'rgba(59, 130, 246, 0.05)',
                            fill: true,
                            tension: 0.4,
                            borderWidth: 3
                        },
                        {
                            label: 'Total Pendapatan (IDR)',
                            data: pendapatanValues,
                            borderColor: '#10b981',
                            backgroundColor: 'rgba(16, 185, 129, 0.05)',
                            fill: true,
                            tension: 0.4,
                            borderWidth: 3
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                font: {
                                    family: 'Plus Jakarta Sans',
                                    size: 11,
                                    weight: 'bold'
                                }
                            }
                        }
                    }
                }
            });
        }

        // --- SYSTEM KASIR: KATALOG FILTER & CARI ---
        function setCategoryFilter(category) {
            currentCategoryFilter = category;
            document.querySelectorAll('.chip-btn').forEach(btn => {
                if (btn.innerText === category) {
                    btn.className = "chip-btn px-3 py-1.5 rounded-lg text-xs font-bold bg-slate-900 text-white transition-all";
                } else {
                    btn.className = "chip-btn px-3 py-1.5 rounded-lg text-xs font-semibold bg-slate-100 text-slate-600 hover:bg-slate-200 transition-all";
                }
            });
            filterKatalog();
        }

        function filterKatalog() {
            const searchQuery = document.getElementById('search-produk').value.toLowerCase();
            const container = document.getElementById('grid-produk-kasir');
            container.innerHTML = '';

            const filteredProducts = products.filter(p => {
                const matchesSearch = p.nama.toLowerCase().includes(searchQuery) || p.merk.toLowerCase().includes(searchQuery);
                const matchesCategory = currentCategoryFilter === "Semua" || p.kategori === currentCategoryFilter;
                return matchesSearch && matchesCategory;
            });

            if (filteredProducts.length === 0) {
                container.innerHTML = `
                    <div class="col-span-2 text-center py-12 text-slate-400">
                        <i data-lucide="info" class="w-12 h-12 mx-auto mb-2 stroke-1 text-slate-300"></i>
                        <p class="text-sm font-semibold">Material tidak ditemukan</p>
                        <p class="text-xs">Coba ketik kata kunci lain atau ubah filter kategori.</p>
                    </div>
                `;
                lucide.createIcons();
                return;
            }

            filteredProducts.forEach(p => {
                const isLow = p.stok <= p.minStok;
                const lowLabel = isLow ? `<span class="text-[9px] bg-rose-500 text-white font-extrabold px-1.5 py-0.5 rounded-full ml-1.5">STOK MINIMUM</span>` : '';

                container.innerHTML += `
                    <div class="border border-slate-200 hover:border-amber-400 p-4 rounded-2xl bg-slate-50 hover:bg-white transition-all duration-200 flex flex-col justify-between space-y-3 shadow-2xs">
                        <div class="space-y-1">
                            <div class="flex items-center justify-between">
                                <span class="px-2 py-0.5 text-[9px] bg-slate-200 text-slate-600 font-bold rounded-md uppercase">${p.kategori}</span>
                                <span class="text-[10px] font-semibold text-slate-400 font-mono">${p.konversi}</span>
                            </div>
                            <h5 class="font-extrabold text-slate-900 text-sm flex items-center">${p.nama} ${lowLabel}</h5>
                            <p class="text-amber-600 font-extrabold text-sm">${formatRupiah(p.harga)} <span class="text-[10px] text-slate-400 font-medium">/ ${p.satuan}</span></p>
                        </div>
                        
                        <div class="flex items-center justify-between pt-2 border-t border-slate-100">
                            <span class="text-xs text-slate-500 font-semibold">Stok: <strong class="text-slate-800">${p.stok}</strong> ${p.satuan}</span>
                            <button onclick="addToCart(${p.id})" class="bg-slate-950 text-white hover:bg-amber-500 hover:text-slate-950 transition-all px-3.5 py-2 rounded-xl font-bold text-xs flex items-center gap-1 shadow-xs">
                                <i data-lucide="plus" class="w-3.5 h-3.5"></i> Tambah
                            </button>
                        </div>
                    </div>
                `;
            });
            lucide.createIcons();
        }

        // --- RENDER COMPONENT: KASIR ---
        function renderKasir() {
            filterKatalog();
            renderCart();
        }

        function addToCart(productId) {
            const product = products.find(p => p.id === productId);
            if (!product) return;

            const itemInCart = cart.find(c => c.productId === productId);
            if (itemInCart) {
                if (itemInCart.qty >= product.stok) {
                    showDialogMessage("Gagal", `Stok produk ${product.nama} tidak mencukupi di gudang!`, "error");
                    return;
                }
                itemInCart.qty++;
            } else {
                if (product.stok <= 0) {
                    showDialogMessage("Gagal", `Stok produk ${product.nama} habis!`, "error");
                    return;
                }
                cart.push({
                    productId: product.id,
                    nama: product.nama,
                    harga: product.harga,
                    satuan: product.satuan,
                    qty: 1
                });
            }

            renderCart();
        }

        function renderCart() {
            const container = document.getElementById('cart-container');
            container.innerHTML = '';

            if (cart.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-8 text-slate-400 text-xs">
                        <i data-lucide="shopping-cart" class="w-10 h-10 mx-auto mb-2 stroke-1 text-slate-300"></i>
                        Keranjang belanja kosong. <br>Pilih produk di katalog.
                    </div>
                `;
                document.getElementById('cart-subtotal').innerText = "Rp 0";
                document.getElementById('cart-tax').innerText = "Rp 0";
                document.getElementById('cart-total').innerText = "Rp 0";
                document.getElementById('input-bayar').value = '';
                document.getElementById('cart-kembalian').innerText = "Rp 0";
                lucide.createIcons();
                return;
            }

            let subtotal = 0;

            cart.forEach(item => {
                const totalHargaItem = item.harga * item.qty;
                subtotal += totalHargaItem;

                container.innerHTML += `
                    <div class="flex items-center justify-between p-3 bg-slate-50 border border-slate-200 rounded-xl">
                        <div class="space-y-1 flex-1 pr-2">
                            <h6 class="font-bold text-xs text-slate-900 leading-snug">${item.nama}</h6>
                            <p class="text-[10px] text-slate-500">${formatRupiah(item.harga)} x ${item.qty} ${item.satuan}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-xs text-slate-800">${formatRupiah(totalHargaItem)}</span>
                            <div class="flex items-center border border-slate-300 rounded-lg overflow-hidden bg-white">
                                <button onclick="updateCartQty(${item.productId}, -1)" class="px-2 py-0.5 text-slate-600 hover:bg-slate-100 font-bold">-</button>
                                <span class="px-2 text-xs font-semibold text-slate-800">${item.qty}</span>
                                <button onclick="updateCartQty(${item.productId}, 1)" class="px-2 py-0.5 text-slate-600 hover:bg-slate-100 font-bold">+</button>
                            </div>
                        </div>
                    </div>
                `;
            });

            const tax = Math.round(subtotal * 0.11);
            const total = subtotal + tax;

            document.getElementById('cart-subtotal').innerText = formatRupiah(subtotal);
            document.getElementById('cart-tax').innerText = formatRupiah(tax);
            document.getElementById('cart-total').innerText = formatRupiah(total);

            hitungKembalian();
            lucide.createIcons();
        }

        function updateCartQty(productId, delta) {
            const item = cart.find(c => c.productId === productId);
            const product = products.find(p => p.id === productId);

            if (!item || !product) return;

            if (delta > 0 && item.qty >= product.stok) {
                showDialogMessage("Stok Terbatas", `Stok maksimum ${product.nama} adalah ${product.stok}.`, "warning");
                return;
            }

            item.qty += delta;

            if (item.qty <= 0) {
                cart = cart.filter(c => c.productId !== productId);
            }

            renderCart();
        }

        function clearCart() {
            cart = [];
            renderCart();
        }

        // --- SISTEM PEMBAYARAN KAS KEMBALIAN ---
        function setNominalPas() {
            const totalStr = document.getElementById('cart-total').innerText.replace(/[^0-9]/g, '');
            const totalVal = parseInt(totalStr) || 0;
            if (totalVal === 0) return;

            document.getElementById('input-bayar').value = totalVal;
            hitungKembalian();
        }

        function hitungKembalian() {
            const totalStr = document.getElementById('cart-total').innerText.replace(/[^0-9]/g, '');
            const totalVal = parseInt(totalStr) || 0;

            const bayarVal = parseInt(document.getElementById('input-bayar').value) || 0;
            const kembalianNode = document.getElementById('cart-kembalian');

            if (bayarVal < totalVal) {
                kembalianNode.innerText = "Uang Kurang!";
                kembalianNode.className = "font-bold text-rose-500";
            } else {
                const kembalian = bayarVal - totalVal;
                kembalianNode.innerText = formatRupiah(kembalian);
                kembalianNode.className = "font-bold text-emerald-600";
            }
        }

        // --- PROSES CHECKOUT API BACKEND ---
        function checkout() {
            if (cart.length === 0) {
                showDialogMessage("Keranjang Kosong", "Masukkan barang ke dalam keranjang belanja terlebih dahulu.", "error");
                return;
            }

            const totalStr = document.getElementById('cart-total').innerText.replace(/[^0-9]/g, '');
            const totalBayar = parseInt(totalStr) || 0;
            const bayarVal = parseInt(document.getElementById('input-bayar').value) || 0;
            const metode = document.getElementById('kasir-metode').value;
            const pelanggan = document.getElementById('kasir-pelanggan').value || "Pelanggan Umum";

            if (metode === "Tunai" && bayarVal < totalBayar) {
                showDialogMessage("Pembayaran Kurang", "Nominal pembayaran tunai kurang dari total belanja!", "error");
                return;
            }

            fetch('api.php?action=checkout', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    pelanggan: pelanggan,
                    metode: metode,
                    cart: cart,
                    bayar: bayarVal
                })
            })
            .then(res => res.json())
            .then(res => {
                if (res.status === 'success') {
                    // Update state lokal
                    products = res.state.products;
                    jurnal = res.state.jurnal;
                    systemLogs = res.state.logs;

                    // Bersihkan nota input & form
                    document.getElementById('kasir-pelanggan').value = '';
                    cart = [];
                    renderCart();

                    // Tampilkan nota belanja modal
                    const n = res.nota;
                    document.getElementById('nota-pelanggan-name').innerText = n.pelanggan;
                    document.getElementById('nota-payment-method').innerText = n.metode;
                    document.getElementById('nota-bayar').innerText = formatRupiah(n.bayar);
                    document.getElementById('nota-kembalian').innerText = formatRupiah(n.kembalian);
                    
                    document.getElementById('nota-no').innerText = n.txNo;
                    document.getElementById('nota-tanggal').innerText = n.tanggal;
                    document.getElementById('nota-subtotal').innerText = formatRupiah(n.subtotal);
                    document.getElementById('nota-tax').innerText = formatRupiah(n.tax);
                    document.getElementById('nota-total').innerText = formatRupiah(n.total);

                    const itemsContainer = document.getElementById('nota-items');
                    itemsContainer.innerHTML = '';
                    n.items.forEach(item => {
                        itemsContainer.innerHTML += `
                            <div class="flex justify-between leading-relaxed">
                                <span>${item.nama} x ${item.qty} ${item.satuan}</span>
                                <span>${formatRupiah(item.harga * item.qty)}</span>
                            </div>
                        `;
                    });

                    document.getElementById('nota-modal').classList.remove('hidden');
                    
                    renderKasir();
                    renderJurnal();
                    renderBukuBesar();
                    updateFinancialKPIs();

                    showDialogMessage("Sukses", res.message, "sukses");
                } else {
                    showDialogMessage("Gagal Transaksi", res.message || "Terjadi kesalahan", "error");
                }
            })
            .catch(err => {
                showDialogMessage("Error", "Gagal memproses transaksi di server.", "error");
                console.error(err);
            });
        }

        // --- RENDER COMPONENT: JURNAL UMUM ---
        function renderJurnal() {
            const tbody = document.getElementById('jurnal-table-body');
            tbody.innerHTML = '';

            let tempJurnal = [...jurnal].reverse();

            tempJurnal.forEach(j => {
                const debitText = j.d > 0 ? formatRupiah(j.d) : "-";
                const kreditText = j.k > 0 ? formatRupiah(j.k) : "-";
                const paddingClass = j.k > 0 ? "pl-8 text-slate-500 font-medium italic" : "font-semibold text-slate-900";

                tbody.innerHTML += `
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="p-4">
                            <span class="block font-bold text-xs text-slate-700">${j.tanggal}</span>
                            <span class="text-[10px] bg-slate-100 text-slate-500 px-1.5 py-0.5 rounded font-mono">${j.jurnal_no}</span>
                        </td>
                        <td class="p-4">
                            <div class="${paddingClass}">
                                ${j.akun}
                            </div>
                            <span class="text-[10px] text-slate-400 block mt-0.5">${j.desc}</span>
                        </td>
                        <td class="p-4 font-mono text-xs text-slate-500 font-bold">${j.ref}</td>
                        <td class="p-4 text-right font-bold text-emerald-600">${debitText}</td>
                        <td class="p-4 text-right font-bold text-rose-600">${kreditText}</td>
                    </tr>
                `;
            });
        }

        function seedInitialJurnal() {
            fetch('api.php?action=reset_jurnal', { method: 'POST' })
            .then(res => res.json())
            .then(res => {
                if (res.status === 'success') {
                    products = res.state.products;
                    jurnal = res.state.jurnal;
                    systemLogs = res.state.logs;

                    renderJurnal();
                    renderBukuBesar();
                    renderKasir();
                    renderStok();
                    updateFinancialKPIs();
                    if (financialChart) financialChart.destroy();
                    initChart();

                    showDialogMessage("Sukses", res.message, "sukses");
                } else {
                    showDialogMessage("Gagal", res.message || "Gagal melakukan reset", "error");
                }
            })
            .catch(err => {
                showDialogMessage("Error", "Gagal mereset database.", "error");
                console.error(err);
            });
        }

        // --- RENDER COMPONENT: BUKU BESAR ---
        function renderBukuBesar() {
            const grid = document.getElementById('bukubesar-grid');
            grid.innerHTML = '';

            const selectedFilter = document.getElementById('select-account-filter').value;

            const accounts = [
                { code: "111", name: "Kas Toko" },
                { code: "113", name: "Persediaan Barang" },
                { code: "411", name: "Pendapatan Penjualan" },
                { code: "511", name: "HPP (Beban Pokok Penjualan)" }
            ];

            accounts.forEach(acc => {
                if (selectedFilter !== 'all' && selectedFilter !== acc.code) return;

                const entries = jurnal.filter(j => j.ref === acc.code);

                let totalDebit = 0;
                let totalKredit = 0;
                let rowElements = '';

                entries.forEach(entry => {
                    totalDebit += entry.d;
                    totalKredit += entry.k;

                    rowElements += `
                        <div class="grid grid-cols-2 text-xs border-b border-slate-100 py-1.5 px-3">
                            <div class="border-r border-slate-200 pr-2">
                                ${entry.d > 0 ? `<div class="flex justify-between">
                                    <span class="text-slate-400 text-[10px]">${entry.tanggal}</span>
                                    <span class="font-bold text-emerald-600">${formatRupiah(entry.d)}</span>
                                </div>` : '<span class="text-slate-300">-</span>'}
                            </div>
                            <div class="pl-2">
                                ${entry.k > 0 ? `<div class="flex justify-between">
                                    <span class="font-bold text-rose-600">${formatRupiah(entry.k)}</span>
                                    <span class="text-slate-400 text-[10px]">${entry.tanggal}</span>
                                </div>` : '<span class="text-slate-300">-</span>'}
                            </div>
                        </div>
                    `;
                });

                let saldoAkhirHtml = '';
                if (acc.code.startsWith('1') || acc.code.startsWith('5')) {
                    const saldo = totalDebit - totalKredit;
                    saldoAkhirHtml = `
                        <div class="bg-amber-50 p-3 flex justify-between items-center border-t border-slate-200 text-xs">
                            <span class="font-bold text-slate-700">SALDO AKHIR DEBET:</span>
                            <span class="font-extrabold text-slate-900 text-sm">${formatRupiah(saldo)}</span>
                        </div>
                    `;
                } else {
                    const saldo = totalKredit - totalDebit;
                    saldoAkhirHtml = `
                        <div class="bg-amber-50 p-3 flex justify-between items-center border-t border-slate-200 text-xs">
                            <span class="font-bold text-slate-700">SALDO AKHIR KREDIT:</span>
                            <span class="font-extrabold text-slate-900 text-sm">${formatRupiah(saldo)}</span>
                        </div>
                    `;
                }

                grid.innerHTML += `
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col justify-between">
                        <div>
                            <div class="bg-slate-900 text-white p-3.5 flex justify-between items-center">
                                <span class="font-bold text-xs font-mono bg-slate-800 px-2 py-0.5 rounded text-amber-400">${acc.code}</span>
                                <span class="font-extrabold text-xs uppercase tracking-wider">${acc.name}</span>
                            </div>

                            <div class="grid grid-cols-2 bg-slate-50 text-center font-bold text-[10px] text-slate-500 border-b border-slate-200 py-1.5 uppercase tracking-wider">
                                <div class="border-r border-slate-200">DEBET (MASUK)</div>
                                <div>KREDIT (KELUAR)</div>
                            </div>

                            <div class="min-h-[120px] max-h-[220px] overflow-y-auto">
                                ${rowElements || '<div class="text-center py-8 text-slate-300 text-xs">Belum ada mutasi akun.</div>'}
                            </div>
                        </div>

                        <div class="border-t border-slate-200 bg-slate-50">
                            <div class="grid grid-cols-2 text-xs font-bold py-2 px-3 border-b border-slate-100">
                                <div class="border-r border-slate-200 pr-2 flex justify-between">
                                    <span class="text-[10px] text-slate-400">Total Dr:</span>
                                    <span>${formatRupiah(totalDebit)}</span>
                                </div>
                                <div class="pl-2 flex justify-between">
                                    <span class="text-[10px] text-slate-400">Total Kr:</span>
                                    <span>${formatRupiah(totalKredit)}</span>
                                </div>
                            </div>
                            ${saldoAkhirHtml}
                        </div>
                    </div>
                `;
            });
        }

        // --- RENDER COMPONENT: STOK ---
        function renderStok() {
            const tbody = document.getElementById('stok-table-body');
            tbody.innerHTML = '';

            products.forEach(p => {
                const isLow = p.stok <= p.minStok;
                const badgeClass = isLow 
                    ? "bg-rose-100 text-rose-800 border-rose-200 font-bold" 
                    : "bg-emerald-100 text-emerald-800 border-emerald-200 font-bold";
                const statusText = isLow ? "Harus Reorder!" : "Stok Aman";

                tbody.innerHTML += `
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="p-4">
                            <div class="font-bold text-slate-900">${p.nama}</div>
                            <div class="text-[10px] text-slate-400">Merek: ${p.merk}</div>
                        </td>
                        <td class="p-4">
                            <span class="px-2 py-1 text-xs bg-slate-100 rounded-lg text-slate-600 font-medium">${p.kategori}</span>
                        </td>
                        <td class="p-4 text-right font-bold text-slate-800">${formatRupiah(p.harga)}</td>
                        <td class="p-4 text-center font-extrabold text-slate-900">${p.stok} <span class="text-xs font-normal text-slate-400">(${p.satuan})</span></td>
                        <td class="p-4 text-center text-slate-500 font-bold">${p.minStok} ${p.satuan}</td>
                        <td class="p-4 text-center">
                            <span class="px-2 py-1 text-[10px] bg-amber-50 text-amber-700 border border-amber-200 rounded-md font-bold font-mono">${p.konversi}</span>
                        </td>
                        <td class="p-4 text-center">
                            <span class="px-2.5 py-1 text-[10px] rounded-full border ${badgeClass}">${statusText}</span>
                        </td>
                    </tr>
                `;
            });
        }

        // --- RENDER COMPONENT: AUDIT LOGS ---
        function renderLogs() {
            const container = document.getElementById('logs-container');
            container.innerHTML = '';

            let tempLogs = [...systemLogs].reverse();

            tempLogs.forEach(log => {
                let badgeColor = "bg-slate-200 text-slate-700";
                if (log.tipe === "sukses") badgeColor = "bg-emerald-500 text-white";
                if (log.tipe === "warning") badgeColor = "bg-rose-500 text-white";
                if (log.tipe === "info") badgeColor = "bg-blue-500 text-white";

                container.innerHTML += `
                    <div class="relative pl-6 pb-4">
                        <div class="absolute -left-1.5 top-1.5 w-3.5 h-3.5 rounded-full ${badgeColor} border-2 border-white flex items-center justify-center"></div>
                        <div class="bg-slate-50 p-3 rounded-xl border border-slate-200/60 shadow-2xs">
                            <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-1">
                                <span class="text-xs font-bold text-slate-900">${log.aksi}</span>
                                <span class="text-[9px] text-slate-400 font-mono">${log.waktu}</span>
                            </div>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-[9px] font-bold text-amber-600 uppercase">AKTOR: ${log.user}</span>
                                <span class="text-[9px] text-slate-400">• Secure MD5 Guard</span>
                            </div>
                        </div>
                    </div>
                `;
            });
        }

        function clearSystemLogs() {
            fetch('api.php?action=clear_logs', { method: 'POST' })
            .then(res => res.json())
            .then(res => {
                if (res.status === 'success') {
                    products = res.state.products;
                    jurnal = res.state.jurnal;
                    systemLogs = res.state.logs;

                    renderLogs();
                    showDialogMessage("Sukses", res.message, "sukses");
                } else {
                    showDialogMessage("Gagal", res.message || "Gagal membersihkan log", "error");
                }
            })
            .catch(err => {
                showDialogMessage("Error", "Gagal membersihkan log di server.", "error");
                console.error(err);
            });
        }

        // --- NOTA DIALOG & MODAL ---
        function showNotaModal(txNo, totalBayar, subtotal, tax) {
            // Logika digantikan sepenuhnya oleh data yang dikembalikan backend (ada di checkout)
        }

        function closeNotaModal() {
            document.getElementById('nota-modal').classList.add('hidden');
            switchView('dashboard');
        }

        // --- TAMBAH MATERIAL BARU ---
        function openAddProductModal() {
            document.getElementById('product-modal').classList.remove('hidden');
        }

        function closeProductModal() {
            document.getElementById('product-modal').classList.add('hidden');
        }

        function handleNewProductSubmit(e) {
            e.preventDefault();
            const nama = document.getElementById('add-nama').value;
            const merk = document.getElementById('add-merk').value;
            const kategori = document.getElementById('add-kategori').value;
            const harga = parseInt(document.getElementById('add-harga').value);
            const satuan = document.getElementById('add-satuan').value;
            const stok = parseInt(document.getElementById('add-stok').value);
            const minStok = parseInt(document.getElementById('add-stok-min').value);
            const konversiRaw = document.getElementById('add-konversi').value;

            fetch('api.php?action=add_product', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    nama: nama,
                    merk: merk,
                    kategori: kategori,
                    harga: harga,
                    satuan: satuan,
                    stok: stok,
                    minStok: minStok,
                    konversi: konversiRaw
                })
            })
            .then(res => res.json())
            .then(res => {
                if (res.status === 'success') {
                    products = res.state.products;
                    jurnal = res.state.jurnal;
                    systemLogs = res.state.logs;

                    closeProductModal();
                    e.target.reset();

                    renderStok();
                    renderKasir();
                    renderDashboard();
                    showDialogMessage("Sukses", res.message, "sukses");
                } else {
                    showDialogMessage("Gagal", res.message || "Gagal menambahkan produk", "error");
                }
            })
            .catch(err => {
                showDialogMessage("Error", "Gagal menyimpan material baru ke database.", "error");
                console.error(err);
            });
        }

        // --- DIALOG MESSAGE HELPER ---
        function showDialogMessage(title, text, type) {
            const alertDiv = document.createElement('div');
            alertDiv.className = `fixed bottom-5 right-5 z-50 p-4 rounded-2xl shadow-xl flex items-start gap-3 border animate-in slide-in-from-bottom-5 duration-200 ${
                type === 'error' ? 'bg-rose-50 border-rose-200 text-rose-900' :
                type === 'warning' ? 'bg-amber-50 border-amber-200 text-amber-900' :
                'bg-emerald-50 border-emerald-200 text-emerald-900'
            }`;
            
            const icon = type === 'error' ? 'x-circle' : type === 'warning' ? 'alert-triangle' : 'check-circle';
            const iconColor = type === 'error' ? 'text-rose-600' : type === 'warning' ? 'text-amber-600' : 'text-emerald-600';

            alertDiv.innerHTML = `
                <div class="p-1 bg-white rounded-lg shadow-sm ${iconColor}">
                    <i data-lucide="${icon}" class="w-5 h-5"></i>
                </div>
                <div>
                    <h5 class="font-extrabold text-sm">${title}</h5>
                    <p class="text-xs text-slate-600 mt-0.5">${text}</p>
                </div>
            `;
            document.body.appendChild(alertDiv);
            lucide.createIcons();

            setTimeout(() => {
                alertDiv.classList.add('animate-out', 'fade-out-0', 'slide-out-to-bottom-5');
                setTimeout(() => alertDiv.remove(), 250);
            }, 3500);
        }
    </script>
</body>
</html>