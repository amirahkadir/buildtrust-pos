<?php
session_start();

require_once 'db.php';
header('Content-Type: application/json');

// Parsing input request body (jika JSON)
$input = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
    if (strpos($contentType, 'application/json') !== false) {
        $input = json_decode(file_get_contents('php://input'), true) ?? [];
    } else {
        $input = $_POST;
    }
}

$action = $_GET['action'] ?? $input['action'] ?? '';

// Helper untuk format rupiah (untuk keperluan log)
function formatRupiah($angka) {
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

// Helper untuk mengambil state global terbaru
function getGlobalState($pdo) {
    // 1. Get Products
    $stmtProd = $pdo->query("SELECT * FROM products ORDER BY id ASC");
    $products = $stmtProd->fetchAll();

    // Map tipe data agar numerik (supaya JS membaca sebagai angka)
    foreach ($products as &$p) {
        $p['id'] = (int)$p['id'];
        $p['harga'] = (int)$p['harga'];
        $p['stok'] = (int)$p['stok'];
        $p['minStok'] = (int)$p['min_stok']; // mapping min_stok ke minStok
        unset($p['min_stok']);
    }

    // 2. Get Jurnal
    $stmtJurnal = $pdo->query("SELECT id, tanggal, ref, akun, d, k, `desc` FROM jurnal ORDER BY tanggal ASC, id ASC");
    $jurnal = $stmtJurnal->fetchAll();
    foreach ($jurnal as &$j) {
        $j['d'] = (int)$j['d'];
        $j['k'] = (int)$j['k'];
    }

    // 3. Get Logs
    $stmtLogs = $pdo->query("SELECT waktu, user, aksi, tipe FROM activity_logs ORDER BY waktu ASC, id ASC");
    $logs = $stmtLogs->fetchAll();
    foreach ($logs as &$l) {
        // Format waktu agar sesuai tampilan "YYYY-MM-DD HH:MM"
        $l['waktu'] = date('Y-m-d H:i', strtotime($l['waktu']));
    }

    return [
        'products' => $products,
        'jurnal' => $jurnal,
        'logs' => $logs
    ];
}

try {
    // Middleware Autentikasi & Otorisasi
    $publicActions = ['login', 'logout', 'get_user', 'register'];
    if (!in_array($action, $publicActions)) {
        if (!isset($_SESSION['user_id'])) {
            echo json_encode([
                'status' => 'error',
                'message' => 'not_logged_in'
            ]);
            exit;
        }

        // Otorisasi Peran
        $role = $_SESSION['role'];
        if (in_array($action, ['add_product', 'clear_logs', 'reset_jurnal'])) {
            if ($role !== 'admin') {
                throw new Exception('Anda tidak memiliki hak akses (Administrator) untuk melakukan aksi ini!');
            }
        } elseif ($action === 'checkout') {
            if ($role !== 'admin' && $role !== 'kasir') {
                throw new Exception('Hanya Administrator atau Kasir yang memiliki akses untuk melakukan transaksi!');
            }
        }
    }

    switch ($action) {
        case 'register':
            $username = trim($input['username'] ?? '');
            $password = trim($input['password'] ?? '');
            $nama = trim($input['nama'] ?? '');
            $role = trim($input['role'] ?? '');

            if (empty($username) || empty($password) || empty($nama) || empty($role)) {
                throw new Exception('Semua kolom data registrasi harus diisi!');
            }

            if (!in_array($role, ['admin', 'kasir', 'owner'])) {
                throw new Exception('Peran pengguna tidak valid!');
            }

            $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
            $stmt->execute([$username]);
            if ($stmt->fetchColumn() > 0) {
                throw new Exception('Username sudah terdaftar! Gunakan username lain.');
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $pdo->beginTransaction();
            try {
                $stmtInsert = $pdo->prepare("INSERT INTO users (username, password, nama, role) VALUES (?, ?, ?, ?)");
                $stmtInsert->execute([$username, $hashedPassword, $nama, $role]);

                // Catat log
                $stmtLog = $pdo->prepare("INSERT INTO activity_logs (user, aksi, tipe) VALUES (?, ?, ?)");
                $stmtLog->execute([$nama, "Berhasil mendaftar akun baru dengan peran: $role", 'info']);

                $pdo->commit();

                echo json_encode([
                    'status' => 'success',
                    'message' => 'Registrasi berhasil! Silakan masuk.'
                ]);
            } catch (Exception $e) {
                $pdo->rollBack();
                throw $e;
            }
            break;
        case 'login':
            $username = trim($input['username'] ?? '');
            $password = trim($input['password'] ?? '');

            if (empty($username) || empty($password)) {
                throw new Exception('Username dan password harus diisi!');
            }

            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            if (!$user || !password_verify($password, $user['password'])) {
                throw new Exception('Username atau password salah!');
            }

            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['role'] = $user['role'];

            // Catat log
            $stmtLog = $pdo->prepare("INSERT INTO activity_logs (user, aksi, tipe) VALUES (?, ?, ?)");
            $stmtLog->execute([$user['nama'], "Berhasil masuk ke sistem", 'info']);

            echo json_encode([
                'status' => 'success',
                'message' => 'Login berhasil!',
                'user' => [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'nama' => $user['nama'],
                    'role' => $user['role']
                ],
                'state' => getGlobalState($pdo)
            ]);
            break;

        case 'logout':
            if (isset($_SESSION['nama'])) {
                $stmtLog = $pdo->prepare("INSERT INTO activity_logs (user, aksi, tipe) VALUES (?, ?, ?)");
                $stmtLog->execute([$_SESSION['nama'], "Keluar dari sistem", 'info']);
            }
            session_unset();
            session_destroy();
            echo json_encode([
                'status' => 'success',
                'message' => 'Logout berhasil!'
            ]);
            break;

        case 'get_user':
            if (isset($_SESSION['user_id'])) {
                echo json_encode([
                    'status' => 'success',
                    'user' => [
                        'id' => $_SESSION['user_id'],
                        'username' => $_SESSION['username'],
                        'nama' => $_SESSION['nama'],
                        'role' => $_SESSION['role']
                    ]
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'not_logged_in'
                ]);
            }
            break;

        case 'get_state':
            echo json_encode([
                'status' => 'success',
                'state' => getGlobalState($pdo)
            ]);
            break;

        case 'add_product':
            $nama = trim($input['nama'] ?? '');
            $merk = trim($input['merk'] ?? '');
            $kategori = trim($input['kategori'] ?? '');
            $harga = (int)($input['harga'] ?? 0);
            $satuan = trim($input['satuan'] ?? '');
            $stok = (int)($input['stok'] ?? 0);
            $minStok = (int)($input['minStok'] ?? $input['min_stok'] ?? 0);
            $konversi = trim($input['konversi'] ?? '');

            if (empty($nama) || empty($merk) || empty($kategori) || $harga <= 0 || empty($satuan) || $stok < 0 || $minStok < 0) {
                throw new Exception('Input data produk tidak valid!');
            }

            if (empty($konversi)) {
                $konversi = "1 $satuan = 1 Unit";
            }

            $pdo->beginTransaction();

            $stmt = $pdo->prepare("INSERT INTO products (nama, merk, kategori, harga, satuan, stok, min_stok, konversi) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$nama, $merk, $kategori, $harga, $satuan, $stok, $minStok, $konversi]);

            // Catat log
            $stmtLog = $pdo->prepare("INSERT INTO activity_logs (user, aksi, tipe) VALUES (?, ?, ?)");
            $stmtLog->execute([$_SESSION['nama'], "Berhasil menambah material baru: {$nama} (Stok: {$stok})", 'sukses']);

            $pdo->commit();

            echo json_encode([
                'status' => 'success',
                'message' => "Material {$nama} berhasil ditambahkan!",
                'state' => getGlobalState($pdo)
            ]);
            break;

        case 'checkout':
            $pelanggan = trim($input['pelanggan'] ?? 'Pelanggan Umum');
            if (empty($pelanggan)) $pelanggan = 'Pelanggan Umum';
            
            $metode = trim($input['metode'] ?? 'Tunai');
            $cart = $input['cart'] ?? [];
            $bayarVal = (int)($input['bayar'] ?? 0);

            if (empty($cart)) {
                throw new Exception('Keranjang belanja kosong!');
            }

            $pdo->beginTransaction();

            // 1. Validasi & Hitung Subtotal
            $subtotal = 0;
            $itemsToProcess = [];

            foreach ($cart as $item) {
                $prodId = (int)$item['productId'];
                $qty = (int)$item['qty'];

                if ($qty <= 0) continue;

                // Ambil info produk terupdate
                $stmtP = $pdo->prepare("SELECT * FROM products WHERE id = ? FOR UPDATE");
                $stmtP->execute([$prodId]);
                $product = $stmtP->fetch();

                if (!$product) {
                    throw new Exception("Produk dengan ID {$prodId} tidak ditemukan!");
                }

                if ($product['stok'] < $qty) {
                    throw new Exception("Stok produk {$product['nama']} tidak mencukupi!");
                }

                $itemSubtotal = $product['harga'] * $qty;
                $subtotal += $itemSubtotal;

                $itemsToProcess[] = [
                    'product_id' => $product['id'],
                    'nama' => $product['nama'],
                    'harga' => (int)$product['harga'],
                    'satuan' => $product['satuan'],
                    'qty' => $qty,
                    'new_stok' => $product['stok'] - $qty
                ];
            }

            if (empty($itemsToProcess)) {
                throw new Exception('Tidak ada item valid untuk diproses!');
            }

            $tax = (int)round($subtotal * 0.11);
            $totalVal = $subtotal + $tax;

            if ($metode === 'Tunai' && $bayarVal < $totalVal) {
                throw new Exception('Nominal pembayaran tunai kurang!');
            }

            $kembalianVal = ($metode === 'Tunai') ? ($bayarVal - $totalVal) : 0;
            $txNo = "TX-" . rand(100000, 999999);
            $dateStr = date('Y-m-d');

            // 2. Simpan Transaksi Utama
            $stmtTx = $pdo->prepare("INSERT INTO transactions (nota_no, pelanggan, metode_pembayaran, subtotal, tax, total, bayar, kembalian) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmtTx->execute([$txNo, $pelanggan, $metode, $subtotal, $tax, $totalVal, $bayarVal, $kembalianVal]);
            $txId = $pdo->lastInsertId();

            // 3. Simpan Detail Item & Kurangi Stok
            $stmtItem = $pdo->prepare("INSERT INTO transaction_items (transaction_id, product_id, qty, harga, satuan) VALUES (?, ?, ?, ?, ?)");
            $stmtUpdStok = $pdo->prepare("UPDATE products SET stok = ? WHERE id = ?");

            foreach ($itemsToProcess as $it) {
                $stmtItem->execute([$txId, $it['product_id'], $it['qty'], $it['harga'], $it['satuan']]);
                $stmtUpdStok->execute([$it['new_stok'], $it['product_id']]);
            }

            // 4. Jurnal Pembukuan Akuntansi (Double-Entry)
            $jrnId1 = "JRN-" . rand(1000, 9999);
            $jrnId2 = "JRN-" . rand(1000, 9999);

            // Jurnal 1: Kas bertambah (Ref 111, Debit), Pendapatan bertambah (Ref 411, Kredit)
            $stmtJrn = $pdo->prepare("INSERT INTO jurnal (jurnal_no, transaction_id, tanggal, ref, akun, d, k, `desc`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            
            $descJurnalSales = "Penjualan Kasir [Pelanggan: {$pelanggan}, Metode: {$metode}] - Nota #{$txNo}";
            $stmtJrn->execute([$jrnId1, $txId, $dateStr, '111', 'Kas Toko', $totalVal, 0, $descJurnalSales]);
            $stmtJrn->execute([$jrnId1, $txId, $dateStr, '411', 'Pendapatan Penjualan', 0, $totalVal, $descJurnalSales]);

            // Jurnal 2: HPP bertambah (Ref 511, Debit), Persediaan Barang berkurang (Ref 113, Kredit)
            $totalHpp = (int)round($subtotal * 0.75); // Margin profit diasumsikan 25% (HPP 75%)
            $descJurnalHpp = "Pelepasan HPP Material - Nota #{$txNo}";
            $stmtJrn->execute([$jrnId2, $txId, $dateStr, '511', 'HPP (Beban Pokok Penjualan)', $totalHpp, 0, $descJurnalHpp]);
            $stmtJrn->execute([$jrnId2, $txId, $dateStr, '113', 'Persediaan Barang', 0, $totalHpp, $descJurnalHpp]);

            // 5. Catat ke Log Audit Keamanan
            $stmtLog = $pdo->prepare("INSERT INTO activity_logs (user, aksi, tipe) VALUES (?, ?, ?)");
            $stmtLog->execute([$_SESSION['nama'], "Sukses Transaksi #{$txNo} senilai " . formatRupiah($totalVal) . " (Oleh: {$pelanggan})", 'sukses']);

            // Cek jika ada produk yang stoknya habis/menyentuh limit untuk auto-warning
            foreach ($itemsToProcess as $it) {
                // Ambil stok min
                $stmtCheckMin = $pdo->prepare("SELECT min_stok FROM products WHERE id = ?");
                $stmtCheckMin->execute([$it['product_id']]);
                $minStokVal = (int)$stmtCheckMin->fetchColumn();

                if ($it['new_stok'] <= $minStokVal) {
                    $stmtLog->execute(['System Monitor', "Peringatan: Stok {$it['nama']} dibawah limit minimum ({$it['new_stok']} {$it['satuan']})", 'warning']);
                }
            }

            $pdo->commit();

            // Format data nota untuk pop-up receipt
            $notaData = [
                'txNo' => $txNo,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $totalVal,
                'bayar' => ($metode === 'Tunai') ? $bayarVal : $totalVal,
                'kembalian' => $kembalianVal,
                'pelanggan' => $pelanggan,
                'metode' => $metode,
                'tanggal' => date('d/m/Y H:i'),
                'items' => array_map(function($it) {
                    return [
                        'nama' => $it['nama'],
                        'qty' => $it['qty'],
                        'satuan' => $it['satuan'],
                        'harga' => $it['harga']
                    ];
                }, $itemsToProcess)
            ];

            echo json_encode([
                'status' => 'success',
                'message' => 'Transaksi berhasil diproses!',
                'nota' => $notaData,
                'state' => getGlobalState($pdo)
            ]);
            break;

        case 'clear_logs':
            $pdo->beginTransaction();
            $pdo->exec("TRUNCATE TABLE activity_logs");

            $stmtLog = $pdo->prepare("INSERT INTO activity_logs (user, aksi, tipe) VALUES (?, ?, ?)");
            $stmtLog->execute(['System Guard', 'Log sistem dibersihkan oleh ' . $_SESSION['nama'], 'info']);
            
            $pdo->commit();

            echo json_encode([
                'status' => 'success',
                'message' => 'Log aktivitas berhasil dibersihkan.',
                'state' => getGlobalState($pdo)
            ]);
            break;

        case 'reset_jurnal':
            $pdo->beginTransaction();

            // Matikan foreign key check agar bisa truncate aman
            $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
            $pdo->exec("TRUNCATE TABLE transaction_items");
            $pdo->exec("TRUNCATE TABLE transactions");
            $pdo->exec("TRUNCATE TABLE jurnal");
            $pdo->exec("TRUNCATE TABLE activity_logs");
            $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");

            // Reset stok produk default
            $stocks = [
                1 => 12, // Semen
                2 => 35, // Pipa
                3 => 8,  // Besi
                4 => 4,  // Cat
                5 => 50  // Kayu
            ];

            $stmtUpd = $pdo->prepare("UPDATE products SET stok = ? WHERE id = ?");
            foreach ($stocks as $id => $stok) {
                $stmtUpd->execute([$stok, $id]);
            }

            // Seed Modal Awal
            $stmtJ = $pdo->prepare("INSERT INTO jurnal (jurnal_no, tanggal, ref, akun, d, k, `desc`) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmtJ->execute(['JRN-001', '2026-05-18', '111', 'Kas Toko', 15000000, 0, 'Inisialisasi Modal Operasional Awal']);
            $stmtJ->execute(['JRN-001', '2026-05-18', '411', 'Pendapatan Penjualan', 0, 15000000, 'Inisialisasi Modal Operasional Awal']);

            // Seed Log Awal
            $stmtL = $pdo->prepare("INSERT INTO activity_logs (user, aksi, tipe) VALUES (?, ?, ?)");
            $stmtL->execute([$_SESSION['nama'], 'Melakukan reset basis data keuangan dan inisialisasi ulang Jurnal', 'warning']);

            $pdo->commit();

            echo json_encode([
                'status' => 'success',
                'message' => 'Data keuangan dan jurnal umum berhasil di-reset.',
                'state' => getGlobalState($pdo)
            ]);
            break;

        default:
            throw new Exception('Aksi API tidak dikenali!');
    }
} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
