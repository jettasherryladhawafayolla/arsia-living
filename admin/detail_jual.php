<?php
session_start();
include "koneksi.php";

// Cek apakah sudah login
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

// Cek apakah status tersedia dan pastikan user adalah admin
if (!isset($_SESSION["status"]) || $_SESSION["status"] !== "admin") {
    echo "<script>
    alert('Akses ditolak! Halaman ini hanya untuk Admin.');
    window.location.href='login.php';
    </script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Keranjang - Arsialiving</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="index.php" class="logo d-flex align-items-center">
                <img src="assets/img/logo.png" alt="">
                <span class="d-none d-lg-block">Arsialiving</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->


        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">


                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
                        <!-- profile-img.jpg diganti dengan foto kalian -->
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6>Jetta</h6>
                            <span>Admin</span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </a>
                        </li>

                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->

            </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->

    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link collapsed" href="index.php">
                    <i class="bi bi-grid"></i>
                    <span>Beranda</span>
                </a>
            </li><!-- End Dashboard Nav -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="kategori.php">
                    <i class="bi bi-airplane"></i>
                    <span>Kategori</span>
                </a>
            </li><!-- End Kategori Page Nav -->

            <li class="nav-item">
                <a class="nav-link" href="produk.php">
                    <i class="bi bi-question-circle"></i>
                    <span>Produk</span>
                </a>
            </li><!-- End Produk Page Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="keranjang.php">
                    <i class="bi bi-envelope"></i>
                    <span>Keranjang</span>
                </a>
            </li><!-- End Keranjang Page Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="transaksi.php">
                    <i class="bi bi-card-list"></i>
                    <span>Transaksi</span>
                </a>
            </li><!-- End Transaksi Page Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="laporan.php">
                    <i class="bi bi-box-arrow-in-right"></i>
                    <span>Laporan</span>
                </a>
            </li><!-- End Laporan Page Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="pengguna.php">
                    <i class="bi bi-dash-circle"></i>
                    <span>Pengguna</span>
                </a>
            </li><!-- End pengguna Page Nav -->
        </ul>

    </aside><!-- End Sidebar-->

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Detail Jual</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
                    <li class="breadcrumb-item ">Transaksi</li>
                    <li class="breadcrumb-item active">Detail Jual</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"> Lihat Detail Transaksi</h5>
                        <div class="table-responsive">
                        <?php 
                        include 'koneksi.php'; // pastikan koneksi DB kamu benar

                        $id_jual = $_GET['id']; // misalnya dari URL atau request

                        // Ambil data tb_jual
                        $jual = mysqli_fetch_assoc(mysqli_query($koneksi, "
                        SELECT = FROM tb_jual tj
                        JOIN tb_user tu ON tj.id_user = tu.id_user
                        WHERE tj.id_jual = '$id_jual'
                        "));
                       
                         // ambil data detail jual
                         $detail = mysqli_query($koneksi, "
                        SELECT tjd.id_produk, tjd.qty, tjd.harga AS subtotal, tp.nm_produk, tp.harga AS harga_produk
                        FROM tb_jualdtl tjd
                        JOIN tb_produk tp ON tjd.id_produk = tp.id_produk
                        WHERE tjd.id_jual = '$id_jual'
                        ");
                        ?>

                        <table class="table table-striped mt-2">
                            <tbody>
                                <tr>
                                    <th>Kode Belanja</th>
                                    <td><?=$jual['id_jual'] ?></td>
</tr>
<tr>
    <th>Pengguna</th>
    <td><?=$jual['username'] ?></td>
</tr>
<tr>
    <th>Tanggal</th>
    <td><?=date('d-m-Y H:i:s', strtotime($jual['tgl_jual'])) ?></td>
</tr>
<tr>
    <th>Total Bayar</th>
    <td>RP <?=number_format($jual['total'], 0, ',','.') ?></td>  
</tr>
<tr>
    <th>Diskon</th>
    <td>Rp <?=number_format($jual['total'], 0, ',','.') ?></td>
</tr>
</tbody>
</table> 

<h5>Detail Pembelian:</h5>
<table class="table table-bordered">
<thead>
    <tr>
        <th>No</th>
        <th>Nama Produk</th>
        <th>Harga</th>
        <th>Qty</th>
        <th>Subtotal</th>
    </tr>
</thead> 
<tbody>
    <?php
    while ($d = mysqli_fetch_assoc($detail)):
    ?>

    <tr>
        <td><?= $no++ ?></td>
        <td><?= $d['nm_produk'] ?></td>
        <td>Rp <?= number_format($d['harga_produk'], 0, ',','.') ?></td>
        <td><?= $d['qty'] ?></td>
        <td>RP <?= number_format($d['subtotal'], 0, ',','.') ?></td>
    </tr>
    <?php endwhile; ?>
</tbody>
</table>

    </div>
    <a href="transaksi.php" class="btn btn-secondary">Kembali</a>
    </div>
    </div>
    </div>
    </div>
        </section>

                        </div><!-- End Filter Bar -->

                        </div>
                          </div>
                            </div>
                              </div>

                        <section class="section">
                            <div class="row">
                        </div class="col-lg-12">
                        <div class="card">
                        </div class="card-body">
                        <!-- Table with stripped rows -->
                         <?php
                         include 'koneksi.php';

                         // Query untuk mengambil data pesanan dengan join ke produk dan kategori
                         $sql = "SELECT p.id_pesanan, p.id_produk, p.qty, p.total, u.username
                         FROM tb_pesanan p
                         JOIN tb_user u ON p.id_user = u.id_user
                         JOIN tb_produk pr ON p.id_produk = pr.id_produk
                         JOIN tb_kategori k ON pr.id_kategori = k.id_kategori";

                         // Tambahkan filter kategori jika dipilih
                         if (!empty($filter_kategori)) {
                            $sql . "WHERE k.id_kategori = '$filter_kategori'";
                         }

                         $result = $koneksi->query($sql);
                         ?>

                         <table class="table table-striped mt-2">
                         <thead>
                         <tr>
                            <th>No</th>
                            <th>Kode Pesanan</th>
                            <th>Kode Produk</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                            <th>Pengguna</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<tr>" . $no++. "</td";
                                    echo "<tr>" . $row["id_pesanan"]. "</td";
                                    echo "<tr>" . $row["id_produk"]. "</td";
                                    echo "<tr>" . $row["qty"]. "</td";
                                    echo "<tr>Rp" . number_format($row["total"], 0, ",", ".
                                    ") . "</td>";
                                    echo "<td>" . $row["username"] . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6' class='text-center'> Belum ada data
                                pesanan</td></tr>";
                            }
                            ?>
                        </tbody>
                        </table>
                        <!-- End Table with stripped rows -->
                        </div>
                        </div>
                        </div>
                        </div>
                        </section>

                        </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>arsialiving</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
            Designed by <a href="https://www.instagram.com/ettaashhe?igsh=MTRqdnM0Y2s0bjk4bg==">Jetta</a>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.min.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>