<?php
include "koneksi.php";
$id = $_GET['id'];

$hapus = mysqli_query($koneksi, "delete from tb_ktg where id_ktg = 'sid'");

if($hapus){
    echo "<script>alert('data berhasil dihapus!')</script>";
    header("refresh:0, kategori.php");
}else{
    echo "<script>alert('data gagal dihapus!')</script>";
    header("refresh:0, kategori.php");
}
?>