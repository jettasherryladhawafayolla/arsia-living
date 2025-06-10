<?php
include 'admin/koneksi.php';
session_start();

if (!isset($_SESSION['id_user'])) {
    echo "<script>alert('Silahkan login terlebih dahulu!');window.location='login.php'";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset ($_POST['qty'])) {
    foreach ($_post['qty'] as $id_pesanan => $jumlah) {
        $jumlah = intval($jumlah);
        if ($jumlah >= 1) {
            // Ambil id_produk dari id_pesanan untuk cek stok
            $query_produk = "SELECT pr.id_produk, pr.stok FROM tb_pesanan p JOIN "
            $res = mysqli_query($koneksi, $query_produk);
            $produk = mysqli_fetch_assoc($res);

            if($jumlah <= $produk['stok']) {
                // Update qty dan total
                $query_update = "UPDATE tb_pesanan p
                                JOIN tb_produk pr ON p.id_produk = pr.id_produk
                                SET p.qty = '$jumlah' , p.total = (pr.harga * $jumlah
                                WHERE p.id_pesanan = '$id_pesanan'";
                mysqli_query($koneksi, $query_update);
            } else {
                echo "<script>alert('jumlah melebihi stok!'); window.localtion='belanja.php'";
                exit;
            }
        }
    }
}

echo "<script>
    alert('jumlah produk berhasil diperbarui!');
    window.location.href = 'cart.php';
    </script>";
    exit;

    ?>