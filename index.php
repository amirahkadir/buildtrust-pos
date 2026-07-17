<!DOCTYPE html>
<html class="no-js" lang="id">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>BuildTrust POS - Sistem Keuangan & Kasir Toko Bangunan</title>
    <meta name="description" content="Aplikasi Point of Sales (POS) dinamis khusus toko bahan bangunan dengan fitur pembukuan akuntansi ganda otomatis, kontrol stok, dan log audit keamanan harian." />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
    <!-- ========================= CSS here ========================= -->
    <link rel="stylesheet" href="Nova-Bootstrap5_beta1-1.0.0/assets/css/bootstrap-5.0.0-beta1.min.css" />
    <link rel="stylesheet" href="Nova-Bootstrap5_beta1-1.0.0/assets/css/LineIcons.2.0.css"/>
    <link rel="stylesheet" href="Nova-Bootstrap5_beta1-1.0.0/assets/css/tiny-slider.css"/>
    <link rel="stylesheet" href="Nova-Bootstrap5_beta1-1.0.0/assets/css/animate.css"/>
    <link rel="stylesheet" href="Nova-Bootstrap5_beta1-1.0.0/assets/css/lindy-uikit.css"/>
    
    <style>
      /* --- GLOBAL THEME OVERRIDES --- */
      body {
        background-color: #ffffff !important;
        color: #111827 !important;
        font-family: 'Plus Jakarta Sans', Inter, sans-serif;
      }
      
      h1, h2, h3, h4, h5, h6, .section-title h3 {
        color: #111827 !important;
        font-weight: 800;
      }
      
      p, .section-title p {
        color: #6b7280 !important;
      }

      /* Background & Section Colors */
      .bg-white-custom {
        background-color: #ffffff !important;
      }
      .bg-grey-custom {
        background-color: #f3f4f6 !important;
      }

      /* --- PRELOADER --- */
      .preloader {
        background-color: #111827 !important;
      }
      .spinner-rotator .spinner-left .spinner-circle,
      .spinner-rotator .spinner-right .spinner-circle {
        border-color: #f59e0b !important;
      }

      /* --- HERO & NAVBAR SECTION --- */
      .hero-section-wrapper-5 {
        background-color: #111827 !important;
      }
      
      .navbar-brand {
        font-weight: 900;
        font-size: 1.6rem;
        color: #ffffff !important;
        letter-spacing: -0.03em;
      }
      .navbar-brand span {
        color: #f59e0b !important;
      }

      .header-6 .navbar-area .navbar .navbar-nav .nav-item a {
        color: #ffffff !important;
        font-weight: 600;
      }
      .header-6 .navbar-area .navbar .navbar-nav .nav-item a.active, 
      .header-6 .navbar-area .navbar .navbar-nav .nav-item a:hover {
        color: #f59e0b !important;
      }

      /* Sticky Header Navbar */
      .header.sticky {
        background-color: #ffffff !important;
        box-shadow: 0px 10px 30px rgba(17, 24, 39, 0.06) !important;
      }
      .header.sticky .navbar-area .navbar-brand {
        color: #111827 !important;
      }
      .header.sticky .navbar-area .navbar .navbar-nav .nav-item a {
        color: #111827 !important;
      }
      .header.sticky .navbar-area .navbar .navbar-nav .nav-item a.active,
      .header.sticky .navbar-area .navbar .navbar-nav .nav-item a:hover {
        color: #f59e0b !important;
      }
      .header.sticky .navbar-area .header-action a {
        color: #111827 !important;
      }

      /* --- BUTTONS --- */
      .button {
        background: #f59e0b !important;
        color: #111827 !important;
        font-weight: 700 !important;
        border-color: #f59e0b !important;
        border-radius: 12px !important;
        padding: 14px 30px !important;
        transition: all 0.3s ease !important;
      }
      .button:hover {
        background: #d97706 !important;
        color: #ffffff !important;
        border-color: #d97706 !important;
        transform: translateY(-2px);
      }
      .button-outline {
        border: 2px solid #f59e0b !important;
        color: #f59e0b !important;
        background: transparent !important;
        border-radius: 12px !important;
        padding: 12px 30px !important;
      }
      .button-outline:hover {
        background: #f59e0b !important;
        color: #111827 !important;
        border-color: #f59e0b !important;
        transform: translateY(-2px);
      }
      
      .btn-outline-warning {
        border-color: #f59e0b !important;
        color: #ffffff !important;
        border-radius: 20px;
        font-weight: 700;
        transition: all 0.3s ease;
      }
      .btn-outline-warning:hover {
        background-color: #f59e0b !important;
        color: #111827 !important;
        border-color: #f59e0b !important;
      }
      .header.sticky .navbar-area .btn-outline-warning {
        color: #111827 !important;
      }
      .header.sticky .navbar-area .btn-outline-warning:hover {
        color: #111827 !important;
        background-color: #f59e0b !important;
      }

      /* --- BUILDTRUST CUSTOM CARDS & HOVER --- */
      .buildtrust-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        padding: 30px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
      }
      .buildtrust-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: #f59e0b;
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.3s ease;
      }
      .buildtrust-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(245, 158, 11, 0.08);
        border-color: #f59e0b;
      }
      .buildtrust-card:hover::before {
        transform: scaleX(1);
      }
      .buildtrust-card .icon {
        width: 60px;
        height: 60px;
        background: #fef3c7;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
        transition: all 0.3s ease;
      }
      .buildtrust-card .icon i {
        font-size: 24px;
        color: #f59e0b;
      }
      .buildtrust-card:hover .icon {
        background: #f59e0b;
      }
      .buildtrust-card:hover .icon i {
        color: #111827;
      }

      /* --- SECTION STATISTIK (NEW) --- */
      .stats-section {
        background: #111827;
        padding: 60px 0;
        position: relative;
        z-index: 10;
        margin-top: -30px;
        border-radius: 24px;
        box-shadow: 0 20px 50px rgba(17, 24, 39, 0.3);
      }
      .stat-item {
        text-align: center;
      }
      .stat-number {
        font-size: 3.5rem;
        font-weight: 900;
        color: #f59e0b;
        line-height: 1;
        margin-bottom: 10px;
      }
      .stat-label {
        font-size: 0.95rem;
        color: #9ca3af;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
      }

      /* --- SECTION PREVIEW DASHBOARD (NEW) --- */
      .browser-mockup {
        border-radius: 16px;
        border: 1px solid #374151;
        background: #1f2937;
        box-shadow: 0 30px 60px rgba(17, 24, 39, 0.15);
        overflow: hidden;
        transition: transform 0.4s ease;
      }
      .browser-mockup:hover {
        transform: scale(1.015);
      }
      .browser-header {
        background: #111827;
        padding: 12px 20px;
        display: flex;
        align-items: center;
        gap: 8px;
        border-bottom: 1px solid #374151;
      }
      .browser-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
      }
      .browser-dot.red { background: #ef4444; }
      .browser-dot.yellow { background: #f59e0b; }
      .browser-dot.green { background: #10b981; }
      .browser-address {
        background: #1f2937;
        color: #9ca3af;
        font-size: 0.75rem;
        padding: 4px 20px;
        border-radius: 6px;
        margin-left: 20px;
        width: 300px;
        text-align: center;
        font-family: monospace;
      }
      .browser-content img {
        width: 100%;
        display: block;
      }

      /* --- SECTION FLOW / ALUR (NEW) --- */
      .flow-step {
        text-align: center;
        position: relative;
        padding: 20px;
      }
      .flow-step-number {
        width: 70px;
        height: 70px;
        background: #f3f4f6;
        border: 3px solid #e5e7eb;
        color: #6b7280;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        font-weight: 900;
        margin: 0 auto 24px;
        transition: all 0.3s ease;
        position: relative;
        z-index: 2;
      }
      .flow-step:hover .flow-step-number {
        background: #f59e0b;
        color: #111827;
        border-color: #f59e0b;
        box-shadow: 0 0 20px rgba(245, 158, 11, 0.4);
      }
      .flow-step h5 {
        margin-bottom: 12px;
        font-weight: 700;
      }

      /* --- SECTION FAQ (NEW) --- */
      .faq-wrapper {
        max-width: 800px;
        margin: 0 auto;
      }
      details.faq-item {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        margin-bottom: 15px;
        padding: 20px;
        transition: all 0.3s ease;
      }
      details.faq-item[open] {
        border-color: #f59e0b;
        box-shadow: 0 10px 20px rgba(245, 158, 11, 0.04);
      }
      summary.faq-question {
        font-weight: 700;
        font-size: 1.05rem;
        color: #111827;
        cursor: pointer;
        list-style: none;
        position: relative;
        padding-right: 30px;
        outline: none;
      }
      summary.faq-question::-webkit-details-marker {
        display: none;
      }
      summary.faq-question::after {
        content: '+';
        position: absolute;
        right: 0;
        top: 50%;
        transform: translateY(-50%);
        font-size: 20px;
        font-weight: bold;
        color: #f59e0b;
        transition: transform 0.3s ease;
      }
      details.faq-item[open] summary.faq-question::after {
        content: '-';
        transform: translateY(-50%) rotate(180deg);
      }
      .faq-answer {
        margin-top: 15px;
        line-height: 1.6;
        color: #6b7280;
      }

      /* --- FOOTER OVERRIDES --- */
      .footer-style-4 {
        background-color: #111827 !important;
      }
      .footer-style-4 .footer-widget h4,
      .footer-style-4 .footer-widget h6 {
        color: #ffffff !important;
      }
      .footer-style-4 .footer-widget p,
      .footer-style-4 .footer-widget .links li a {
        color: #9ca3af !important;
      }
      .footer-style-4 .footer-widget .links li a:hover {
        color: #f59e0b !important;
      }
      .footer-style-4 .footer-widget .socials li a {
        color: #9ca3af !important;
      }
      .footer-style-4 .footer-widget .socials li a:hover {
        color: #f59e0b !important;
      }
      .footer-style-4 .copyright-wrapper {
        border-top: 1px solid #1f2937 !important;
      }
      .footer-style-4 .copyright-wrapper p {
        color: #6b7280 !important;
      }
      .footer-style-4 .copyright-wrapper p a {
        color: #9ca3af !important;
      }
      .footer-style-4 .copyright-wrapper p a:hover {
        color: #f59e0b !important;
      }

      /* --- SCROLL TOP & SLIDER NAV --- */
      .scroll-top {
        background-color: #f59e0b !important;
        color: #111827 !important;
      }
      .scroll-top:hover {
        background-color: #d97706 !important;
        color: #ffffff !important;
      }
    </style>
  </head>
  <body>
    <!-- ========================= preloader start ========================= -->
    <div class="preloader">
      <div class="loader">
        <div class="spinner">
          <div class="spinner-container">
            <div class="spinner-rotator">
              <div class="spinner-left">
                <div class="spinner-circle"></div>
              </div>
              <div class="spinner-right">
                <div class="spinner-circle"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- ========================= preloader end ========================= -->

    <!-- ========================= hero-section-wrapper-5 start ========================= -->
    <section id="home" class="hero-section-wrapper-5">

      <!-- ========================= header-6 start ========================= -->
      <header class="header header-6">
        <div class="navbar-area">
          <div class="container">
            <div class="row align-items-center">
              <div class="col-lg-12">
                <nav class="navbar navbar-expand-lg">
                  <a class="navbar-brand text-white" href="index.php">
                    BuildTrust<span>POS</span>
                  </a>
                  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent6" aria-controls="navbarSupportedContent6" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="toggler-icon"></span>
                    <span class="toggler-icon"></span>
                    <span class="toggler-icon"></span>
                  </button>
  
                  <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent6">
                    <ul id="nav6" class="navbar-nav ms-auto">
                      <li class="nav-item">
                        <a class="page-scroll active" href="#home">Beranda</a>
                      </li>
                      <li class="nav-item">
                        <a class="page-scroll" href="#feature">Fitur POS</a>
                      </li>
                      <li class="nav-item">
                        <a class="page-scroll" href="#dashboard-preview">Dashboard</a>
                      </li>
                      <li class="nav-item">
                        <a class="page-scroll" href="#flow">Alur Kerja</a>
                      </li>
                      <li class="nav-item">
                        <a class="page-scroll" href="#faq">FAQ</a>
                      </li>
                    </ul>
                  </div>
                  
                  <div class="header-action d-flex align-items-center ms-3">
                    <a href="dashboard.php" class="btn btn-sm btn-outline-warning text-white font-bold border-2 px-4 py-2 rounded-pill transition-all">Masuk</a>
                  </div>
                  <!-- navbar collapse -->
                </nav>
                <!-- navbar -->
              </div>
            </div>
            <!-- row -->
          </div>
          <!-- container -->
        </div>
        <!-- navbar area -->
      </header>
      <!-- ========================= header-6 end ========================= -->

      <!-- ========================= hero-5 start ========================= -->
      <div class="hero-section hero-style-5 img-bg" style="background-image: url('Nova-Bootstrap5_beta1-1.0.0/assets/img/hero/hero-5/hero-bg.svg')">
        <div class="container">
          <!-- UBAH BENTUK HERO: SWAP KOLOM (Gambar di Kiri, Teks di Kanan) -->
          <div class="row align-items-center">
            <div class="col-lg-6 order-2 order-lg-1">
              <div class="hero-image wow fadeInUp" data-wow-delay=".3s">
                <img src="Nova-Bootstrap5_beta1-1.0.0/assets/img/hero/hero-5/hero-img.svg" alt="BuildTrust POS Dashboard Preview">
              </div>
            </div>
            <div class="col-lg-6 order-1 order-lg-2">
              <div class="hero-content-wrapper ps-lg-5 text-lg-start text-center">
                <h2 class="mb-30 wow fadeInUp text-white" data-wow-delay=".2s">Akurasi Pembukuan & Kontrol Stok Toko Bahan Bangunan</h2>
                <p class="mb-30 wow fadeInUp text-slate-300" data-wow-delay=".4s">Aplikasi kasir Point of Sales pintar yang secara otomatis memposting jurnal akuntansi ganda secara real-time. Hilangkan risiko manipulasi transaksi dan selisih stok material selamanya.</p>
                <div class="d-flex flex-wrap justify-content-lg-start justify-content-center gap-3 wow fadeInUp" data-wow-delay=".6s">
                  <a href="dashboard.php" class="button button-lg">Masuk Sistem <i class="lni lni-chevron-right"></i> </a>
                  <a href="dashboard.php#register" class="button button-lg button-outline">Daftar Akun <i class="lni lni-user"></i> </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- ========================= hero-5 end ========================= -->

    </section>
    <!-- ========================= hero-section-wrapper-5 end ========================= -->

    <!-- ========================= SECTION STATISTIK (NEW) ========================= -->
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <section class="stats-section wow fadeInUp" data-wow-delay=".2s">
            <div class="container">
              <div class="row justify-content-center">
                <div class="col-md-4 col-sm-6 mb-4 mb-md-0">
                  <div class="stat-item">
                    <div class="stat-number">10.000+</div>
                    <div class="stat-label">Total Transaksi POS</div>
                  </div>
                </div>
                <div class="col-md-4 col-sm-6 mb-4 mb-md-0">
                  <div class="stat-item">
                    <div class="stat-number">3 Peran</div>
                    <div class="stat-label">Hak Akses Sistem (RBAC)</div>
                  </div>
                </div>
                <div class="col-md-4 col-sm-12">
                  <div class="stat-item">
                    <div class="stat-number">100%</div>
                    <div class="stat-label">Akurasi Jurnal Ganda</div>
                  </div>
                </div>
              </div>
            </div>
          </section>
        </div>
      </div>
    </div>

    <!-- ========================= SECTION FITUR ASIMETRIS (MODIFIED) ========================= -->
    <section id="feature" class="feature-section pt-120 pb-90 bg-white-custom">
      <div class="container">
        <!-- TATA LETAK ASIMETRIS 2-KOLOM (Header kiri sticky, grid fitur kanan) -->
        <div class="row">
          <div class="col-lg-4 col-md-12 mb-50 mb-lg-0">
            <div class="section-title sticky-top" style="top: 100px;">
              <span class="text-warning font-bold uppercase tracking-wider text-xs block mb-2">Mengapa Memilih Kami</span>
              <h3 class="mb-20">Sistem POS Terintegrasi Akuntansi</h3>
              <p class="text-slate-500">Bukan sekadar mencatat penjualan harian. BuildTrust POS mensinkronkan transaksi kasir dengan jurnal debit-kredit dan Buku Besar secara otomatis dan aman.</p>
              <div class="mt-40">
                <a href="dashboard.php" class="btn btn-outline-warning px-4 py-2 text-dark font-bold"> Masuk Dashboard <i class="lni lni-arrow-right"></i></a>
              </div>
            </div>
          </div>
          <div class="col-lg-8 col-md-12">
            <div class="row">
              <div class="col-md-6 mb-30">
                <div class="buildtrust-card wow fadeInUp" data-wow-delay=".2s">
                  <div class="icon">
                    <i class="lni lni-calculator"></i>
                  </div>
                  <h5>Transaksi POS Kasir</h5>
                  <p class="text-slate-500">Keranjang transaksi modular, kalkulator PPN 11%, dan kembalian instan guna meminimalisir kesalahan operasional checkout.</p>
                </div>
              </div>
              <div class="col-md-6 mb-30">
                <div class="buildtrust-card wow fadeInUp" data-wow-delay=".4s">
                  <div class="icon">
                    <i class="lni lni-database"></i>
                  </div>
                  <h5>Jurnal Akuntansi Ganda</h5>
                  <p class="text-slate-500">Otomatis memposting mutasi Debit & Kredit ke akun Kas dan Pendapatan serta pengakuan HPP persediaan setiap checkout.</p>
                </div>
              </div>
              <div class="col-md-6 mb-30 mb-md-0">
                <div class="buildtrust-card wow fadeInUp" data-wow-delay=".2s">
                  <div class="icon">
                    <i class="lni lni-stats-up"></i>
                  </div>
                  <h5>Buku Besar T-Account</h5>
                  <p class="text-slate-500">Pengelompokan transaksi otomatis untuk melacak akun kas dan persediaan sehingga mutasi keuangan terpantau jelas.</p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="buildtrust-card wow fadeInUp" data-wow-delay=".4s">
                  <div class="icon">
                    <i class="lni lni-shield"></i>
                  </div>
                  <h5>Audit Trail Keamanan</h5>
                  <p class="text-slate-500">Log aktivitas sistem merekam operator, tindakan, dan timestamp untuk mendeteksi serta meminimalisir risiko kebocoran keuangan.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ========================= SECTION PREVIEW DASHBOARD (NEW) ========================= -->
    <section id="dashboard-preview" class="pt-100 pb-100 bg-grey-custom">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-xxl-6 col-xl-7 col-lg-8 col-md-10">
            <div class="section-title text-center mb-60">
              <span class="text-warning font-bold uppercase tracking-wider text-xs block mb-2">Desain Premium</span>
              <h3 class="mb-15">Antarmuka Dasbor Modern & Intuitif</h3>
              <p class="text-slate-500">Dasbor dengan tema gelap (Dark Theme) premium yang didesain secara visual untuk memudahkan operator dan manajemen memantau kinerja toko bahan bangunan.</p>
            </div>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-lg-10">
            <div class="browser-mockup wow fadeInUp" data-wow-delay=".2s">
              <div class="browser-header">
                <div class="browser-dot red"></div>
                <div class="browser-dot yellow"></div>
                <div class="browser-dot green"></div>
                <div class="browser-address">http://localhost:8000/dashboard.php</div>
              </div>
              <div class="browser-content">
                <img src="Nova-Bootstrap5_beta1-1.0.0/assets/img/dashboard-preview.png" alt="BuildTrust POS Dashboard Screenshot">
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ========================= SECTION ALUR PENGGUNAAN (NEW) ========================= -->
    <section id="flow" class="pt-120 pb-120 bg-white-custom">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-xxl-6 col-xl-7 col-lg-8 col-md-10">
            <div class="section-title text-center mb-70">
              <span class="text-warning font-bold uppercase tracking-wider text-xs block mb-2">Panduan Cepat</span>
              <h3 class="mb-15">3 Langkah Mudah Penggunaan Sistem</h3>
              <p class="text-slate-500">Mulailah mengoperasikan sistem BuildTrust POS di toko bangunan Anda secara asinkron dalam hitungan menit.</p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
            <div class="flow-step wow fadeInUp" data-wow-delay=".2s">
              <div class="flow-step-number">1</div>
              <h5>Daftar & Atur Peran</h5>
              <p class="text-slate-500">Daftarkan karyawan Anda di menu registrasi dan atur peran mereka sebagai Administrator, Kasir, atau Owner sesuai tanggung jawabnya.</p>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
            <div class="flow-step wow fadeInUp" data-wow-delay=".4s">
              <div class="flow-step-number">2</div>
              <h5>Checkout Transaksi</h5>
              <p class="text-slate-500">Kasir menambahkan material pesanan ke dalam keranjang, memasukkan jumlah pembayaran tunai, dan melakukan checkout transaksi penjualan.</p>
            </div>
          </div>
          <div class="col-lg-4 col-md-12">
            <div class="flow-step wow fadeInUp" data-wow-delay=".6s">
              <div class="flow-step-number">3</div>
              <h5>Pantau Pembukuan</h5>
              <p class="text-slate-500">Owner atau Akuntan dapat langsung melihat postingan mutasi Debit-Kredit Jurnal Umum dan Buku Besar secara otomatis dan real-time.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ========================= SECTION FAQ (NEW) ========================= -->
    <section id="faq" class="pt-100 pb-100 bg-grey-custom">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-xxl-6 col-xl-7 col-lg-8 col-md-10">
            <div class="section-title text-center mb-60">
              <span class="text-warning font-bold uppercase tracking-wider text-xs block mb-2">Tanya & Jawab</span>
              <h3 class="mb-15">Pertanyaan yang Sering Diajukan</h3>
              <p class="text-slate-500">Temukan jawaban cepat atas pertanyaan seputar fitur Point of Sales dan Akuntansi BuildTrust POS.</p>
            </div>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-lg-10">
            <div class="faq-wrapper">
              <details class="faq-item wow fadeInUp" data-wow-delay=".1s">
                <summary class="faq-question">Apakah sistem akuntansi jurnal berjalan secara otomatis?</summary>
                <div class="faq-answer">
                  Ya, sistem akuntansi BuildTrust POS dikonfigurasi secara real-time. Setiap transaksi checkout kasir yang berhasil diproses secara otomatis akan memposting data Debit-Kredit ganda ke tabel Jurnal Umum dan langsung dialokasikan ke Buku Besar.
                </div>
              </details>
              
              <details class="faq-item wow fadeInUp" data-wow-delay=".2s">
                <summary class="faq-question">Apakah hak akses menu aplikasi kasir dibatasi?</summary>
                <div class="faq-answer">
                  Ya, aplikasi menggunakan pembatasan akses berbasis peran (RBAC). Kasir hanya diizinkan membuka menu kasir checkout. Owner hanya dapat melihat grafik dasbor, jurnal umum, dan buku besar. Administrator memiliki akses penuh termasuk pengelolaan master barang dan reset database.
                </div>
              </details>

              <details class="faq-item wow fadeInUp" data-wow-delay=".3s">
                <summary class="faq-question">Bagaimana log keamanan (Audit Trail) mencegah fraud?</summary>
                <div class="faq-answer">
                  Setiap operator kasir yang masuk, melakukan transaksi checkout, mengubah stok material, atau administrator yang membersihkan log akan terekam secara otomatis. Log merekam waktu server, operator aktif, aksi, dan status kepentingan keamanan secara permanen.
                </div>
              </details>

              <details class="faq-item wow fadeInUp" data-wow-delay=".4s">
                <summary class="faq-question">Bagaimana jika terjadi mati listrik atau koneksi gagal?</summary>
                <div class="faq-answer">
                  BuildTrust POS dirancang sebagai aplikasi intranet localhost yang andal. Selama server lokal XAMPP menyala di jaringan toko bangunan Anda, aplikasi kasir dapat diakses oleh perangkat gawai operator mana pun tanpa bergantung pada internet eksternal.
                </div>
              </details>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ========================= footer style-4 start ========================= -->
    <footer class="footer footer-style-4 bg-dark text-white pt-80 pb-50">
      <div class="container">
        <div class="widget-wrapper">
          <div class="row">
            <div class="col-xl-4 col-lg-4 col-md-6">
              <div class="footer-widget wow fadeInUp" data-wow-delay=".2s">
                <div class="logo mb-4">
                  <h4 class="text-white font-black tracking-tight">BuildTrust<span>POS</span></h4>
                </div>
                <p class="desc text-slate-400 mb-4">Aplikasi kasir Point of Sales yang mensinkronkan transaksi penjualan material bangunan secara langsung dengan pembukuan jurnal akuntansi ganda.</p>
                <ul class="socials d-flex gap-3">
                  <li> <a href="#0" class="text-white hover:text-amber-500"> <i class="lni lni-facebook-filled"></i> </a> </li>
                  <li> <a href="#0" class="text-white hover:text-amber-500"> <i class="lni lni-twitter-filled"></i> </a> </li>
                  <li> <a href="#0" class="text-white hover:text-amber-500"> <i class="lni lni-instagram-filled"></i> </a> </li>
                </ul>
              </div>
            </div>
            <div class="col-xl-3 offset-xl-1 col-lg-2 col-md-6 col-sm-6">
              <div class="footer-widget wow fadeInUp" data-wow-delay=".3s">
                <h6 class="text-white mb-3">Tautan Pintas</h6>
                <ul class="links list-unstyled">
                  <li class="mb-2"> <a href="#home" class="text-slate-400 hover:text-amber-500 text-decoration-none">Beranda</a> </li>
                  <li class="mb-2"> <a href="#feature" class="text-slate-400 hover:text-amber-500 text-decoration-none">Fitur POS</a> </li>
                  <li class="mb-2"> <a href="#dashboard-preview" class="text-slate-400 hover:text-amber-500 text-decoration-none">Dashboard</a> </li>
                  <li class="mb-2"> <a href="#flow" class="text-slate-400 hover:text-amber-500 text-decoration-none">Alur Kerja</a> </li>
                  <li class="mb-2"> <a href="#faq" class="text-slate-400 hover:text-amber-500 text-decoration-none">FAQ</a> </li>
                </ul>
              </div>
            </div>
            <div class="col-xl-4 col-lg-3 col-md-6 col-sm-6">
              <div class="footer-widget wow fadeInUp" data-wow-delay=".4s">
                <h6 class="text-white mb-3">Profil Pengembang</h6>
                <p class="text-slate-400 text-sm mb-2"><b>Kelompok 28 • D4 TI</b></p>
                <ul class="list-unstyled text-slate-400 text-sm">
                  <li class="mb-1">Kayla Aura S. (714250062)</li>
                  <li class="mb-1">Amirah Fauziyyah T. (714250008)</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="copyright-wrapper border-top border-slate-800 pt-4 mt-5 text-center text-slate-500 text-xs">
          <p>Design and Developed by <a href="https://uideck.com" rel="nofollow" target="_blank" class="text-slate-400 hover:text-amber-500 text-decoration-none">UIdeck</a>. Distributed by <a href="https://themewagon.com" target="_blank" class="text-slate-400 hover:text-amber-500 text-decoration-none">ThemeWagon</a>. Customized for BuildTrust POS.</p>
        </div>
      </div>
    </footer>
    <!-- ========================= footer style-4 end ========================= -->

    <!-- ========================= scroll-top start ========================= -->
    <a href="#" class="scroll-top"> <i class="lni lni-chevron-up"></i> </a>
    <!-- ========================= scroll-top end ========================= -->

    <!-- ========================= JS here ========================= -->
    <script src="Nova-Bootstrap5_beta1-1.0.0/assets/js/bootstrap-5.0.0-beta1.min.js"></script>
    <script src="Nova-Bootstrap5_beta1-1.0.0/assets/js/tiny-slider.js"></script>
    <script src="Nova-Bootstrap5_beta1-1.0.0/assets/js/wow.min.js"></script>
    <script src="Nova-Bootstrap5_beta1-1.0.0/assets/js/main.js"></script>
  </body>
</html>
