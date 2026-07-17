<?php
include '../config/db.php';

$data = json_decode(file_get_contents("php://input"), true);

$total = $data['total'];
$cart = $data['cart'];

$query = "INSERT INTO transaksi (total_harga)
          VALUES ('$total')";

if (mysqli_query($conn, $query)) {

    $idTransaksi = mysqli_insert_id($conn);

    foreach ($cart as $item) {

    $idProduk = $item['productId'];
    $qty = $item['qty'];
    $subtotalItem = $item['harga'] * $item['qty'];

    $queryDetail = "
        INSERT INTO detail_transaksi
        (id_transaksi, id_produk, qty, subtotal)
        VALUES
        ('$idTransaksi', '$idProduk', '$qty', '$subtotalItem')
    ";

    mysqli_query($conn, $queryDetail);

    $queryStok = "
        UPDATE produk
        SET stok = stok - $qty
        WHERE id_produk = $idProduk
";

mysqli_query($conn, $queryStok);
}

    echo json_encode([
        "status" => "success",
        "id_transaksi" => $idTransaksi
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => mysqli_error($conn)
    ]);
}
?>