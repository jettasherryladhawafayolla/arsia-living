<?php
include 'admin/koneksi.php';
session_start();

if (!isset($_SESSION['id_user'])) {
    echo "<script>alert('silahkan login terlebih dahulu'); window.location= 'login.
    php' "
}

