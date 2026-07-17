# BAB 3: PERANCANGAN SISTEM

## 3.1 Arsitektur Sistem
Aplikasi **BuildTrust-POS** menerapkan arsitektur Client-Server Monolitik 2-Tier. Frontend (Client-side) berinteraksi dengan API Backend (Server-side) secara asinkron menggunakan protokol HTTP dengan payload data terformat JSON.

```graphviz
digraph Arsitektur {
    rankdir=LR;
    node [shape=box, style=filled, fontname="Helvetica,Arial,sans-serif", fontsize=10];
    edge [fontname="Helvetica,Arial,sans-serif", fontsize=9];

    subgraph cluster_client {
        label = "Client-Side (Frontend)";
        color = lightgrey;
        style = dashed;
        UI [label="User Interface (HTML/CSS)", fillcolor="#eff6ff", color="#3b82f6"];
        JS [label="JavaScript Engine\n(Fetch API & Chart.js)", fillcolor="#eff6ff", color="#3b82f6"];
    }

    subgraph cluster_server {
        label = "Server-Side (Backend & DB)";
        color = lightgrey;
        style = dashed;
        API [label="api.php\n(API Router & Controllers)", fillcolor="#ecfdf5", color="#10b981"];
        DB [label="MySQL Database\n(db_buildtrust_pos)", shape=cylinder, fillcolor="#fffbeb", color="#f59e0b"];
    }

    UI -> JS [label="Interaksi / Event"];
    JS -> UI [label="Update DOM"];
    JS -> API [label="HTTP Request (JSON)", color="#2563eb"];
    API -> JS [label="HTTP Response (JSON)", color="#16a34a"];
    API -> DB [label="PDO Prepared Statement", color="#d97706"];
    DB -> API [label="Result Set", color="#d97706"];
}
```

---

## 3.2 Workflow Sistem
Workflow sistem mendeskripsikan siklus pemrosesan data, dari input transaksi hingga penulisan jurnal keuangan otomatis dan log aktivitas.

```graphviz
digraph Workflow {
    node [shape=box, style=filled, fontname="Helvetica,Arial,sans-serif", fontsize=10];
    edge [fontname="Helvetica,Arial,sans-serif", fontsize=9];

    Start [label="Mulai", shape=ellipse, fillcolor="#f1f5f9"];
    InputCart [label="Input: Pilih Material & Masukkan Keranjang", fillcolor="#fffbeb"];
    CheckStock [label="Proses: Validasi Stok Gudang", fillcolor="#fffbeb"];
    StockEnough [label="Apakah Stok Cukup?", shape=diamond, fillcolor="#f1f5f9"];
    ErrorStock [label="Tampilkan Error: Stok Kurang", fillcolor="#fecdd3", shape=note];
    
    BeginTx [label="Buka Database Transaction\n(beginTransaction)", fillcolor="#ecfdf5"];
    WriteTx [label="1. Catat Transaksi Utama & Item", fillcolor="#ecfdf5"];
    ReduceStock [label="2. Kurangi Stok Material", fillcolor="#ecfdf5"];
    AutoJournal [label="3. Posting Jurnal Otomatis\n(Kas, Pendapatan, HPP, Persediaan)", fillcolor="#ecfdf5"];
    WriteLog [label="4. Catat Log Audit Keamanan", fillcolor="#ecfdf5"];
    CommitTx [label="Selesai & Simpan\n(commit)", fillcolor="#ecfdf5"];
    
    PrintNota [label="Output: Tampilkan Struk / Nota Lunas", fillcolor="#eff6ff"];
    End [label="Selesai", shape=ellipse, fillcolor="#f1f5f9"];

    Start -> InputCart;
    InputCart -> CheckStock;
    CheckStock -> StockEnough;
    StockEnough -> ErrorStock [label="Tidak"];
    StockEnough -> BeginTx [label="Ya"];
    
    BeginTx -> WriteTx;
    WriteTx -> ReduceStock;
    ReduceStock -> AutoJournal;
    AutoJournal -> WriteLog;
    WriteLog -> CommitTx;
    
    CommitTx -> PrintNota;
    ErrorStock -> InputCart;
    PrintNota -> End;
}
```

### Narasi Alur Kerja Transaksi Kasir:
1.  **Input:** Kasir memilih material bangunan dari katalog dan memasukkan jumlah barang.
2.  **Validasi:** Sistem mencocokkan jumlah pesanan dengan stok material aktual di database menggunakan query ber-kunci eksklusif (`FOR UPDATE`). Jika stok tidak mencukupi, transaksi dibatalkan dengan pesan peringatan.
3.  **Proses Transaksi Aman:** Jika stok cukup, transaksi database dimulai. Sistem melakukan penulisan berurutan: menyimpan nota di tabel `transactions` & `transaction_items`, mengurangi stok barang di tabel `products`, memposting entri akuntansi double-entry di tabel `jurnal`, dan menulis status log sukses di tabel `activity_logs`.
4.  **Commit & Output:** Semua perubahan disimpan secara permanen (`commit`). Jika di tengah jalan terdapat salah satu langkah penulisan yang gagal, seluruh rangkaian transaksi dibatalkan (`rollBack`). Setelah berhasil, popup nota lunas dirender untuk kasir.

---

## 3.3 Class Diagram
Meskipun aplikasi ini menggunakan PHP Native dengan pendekatan fungsional/prosedural pada `api.php`, berikut adalah **Class Diagram Konseptual** yang menggambarkan representasi modul-modul logika berorientasi objek dalam perancangan sistem:

```graphviz
classdiagram
digraph ClassDiagram {
    node [shape=record, style=filled, fillcolor="#f8fafc", fontname="Courier New,Courier,monospace", fontsize=9];
    edge [arrowhead=vee, fontname="Helvetica,Arial,sans-serif", fontsize=9];

    DatabaseConnection [label="{DatabaseConnection|- host: string\l- db: string\l- user: string\l- pass: string\l- pdo: PDO\l|+ connect(): PDO\l+ disconnect(): void\l}"];
    
    AuthController [label="{AuthController||+ login(username, password): bool\l+ logout(): bool\l+ getUserSession(): User\l}"];
    
    ProductController [label="{ProductController||+ getProducts(): Array\l+ addProduct(data): bool\l+ updateStock(productId, qty): bool\l}"];
    
    TransactionController [label="{TransactionController||+ checkout(pelanggan, metode, cart, bayar): Array\l- saveTransaction(): int\l- saveItems(txId, items): void\l}"];
    
    JournalController [label="{JournalController||+ getJournals(): Array\l+ postJournalEntry(txId, ref, akun, d, k, desc): bool\l+ resetJournal(): bool\l}"];
    
    AuditLogger [label="{AuditLogger||+ getLogs(): Array\l+ logActivity(user, action, type): bool\l+ clearLogs(): bool\l}"];

    // Relationships
    AuthController -> DatabaseConnection [label="uses"];
    ProductController -> DatabaseConnection [label="uses"];
    TransactionController -> DatabaseConnection [label="uses"];
    JournalController -> DatabaseConnection [label="uses"];
    AuditLogger -> DatabaseConnection [label="uses"];
    
    TransactionController -> ProductController [label="updates stock"];
    TransactionController -> JournalController [label="posts journals"];
    TransactionController -> AuditLogger [label="logs security"];
}
```

---

## 3.4 Entity Relationship Diagram (ERD)
Perancangan struktur basis data BuildTrust-POS dirancang relasional untuk menjamin konsistensi data penjualan dan data keuangan.

```graphviz
digraph ERD {
    node [shape=record, style=filled, fontname="Helvetica,Arial,sans-serif", fontsize=9];
    edge [arrowtail=none, arrowhead=crow, dir=both, fontname="Helvetica,Arial,sans-serif", fontsize=9];

    users [label="users | {PK | id : int\l| username : varchar(50)\l| password : varchar(255)\l| nama : varchar(100)\l| role : enum('admin','kasir','owner')\l}", fillcolor="#eff6ff"];
    
    products [label="products | {PK | id : int\l| nama : varchar(150)\l| merk : varchar(100)\l| kategori : varchar(50)\l| harga : int\l| satuan : varchar(20)\l| stok : int\l| min_stok : int\l| konversi : varchar(100)\l}", fillcolor="#eff6ff"];
    
    transactions [label="transactions | {PK | id : int\l| nota_no : varchar(50) [U]\l| pelanggan : varchar(100)\l| metode_pembayaran : varchar(50)\l| subtotal : int\l| tax : int\l| total : int\l| bayar : int\l| kembalian : int\l}", fillcolor="#eff6ff"];
    
    transaction_items [label="transaction_items | {PK | id : int\l| FK | transaction_id : int\l| FK | product_id : int\l| qty : int\l| harga : int\l| satuan : varchar(20)\l}", fillcolor="#fdf2f8"];
    
    jurnal [label="jurnal | {PK | id : int\l| jurnal_no : varchar(50)\l| FK | transaction_id : int\l| tanggal : date\l| ref : varchar(10)\l| akun : varchar(100)\l| d : int\l| k : int\l| desc : text\l}", fillcolor="#fef2f2"];
    
    activity_logs [label="activity_logs | {PK | id : int\l| waktu : timestamp\l| user : varchar(100)\l| aksi : text\l| tipe : varchar(20)\l}", fillcolor="#f0fdf4"];

    // Relationships
    transactions -> transaction_items [label="1 : N\n(ON DELETE CASCADE)", arrowhead=crow, arrowtail=none, dir=both];
    products -> transaction_items [label="1 : N", arrowhead=crow, arrowtail=none, dir=both];
    transactions -> jurnal [label="1 : N\n(ON DELETE SET NULL)", arrowhead=crow, arrowtail=none, dir=both];
}
```
