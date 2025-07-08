<?php
session_start();
if (!isset($_SESSION['s_username'])) {
 header("Location: index.html");
 exit;
}
$vkoneksi = new mysqli("localhost", "root", "", "db_badar_furniture");
if ($vkoneksi->connect_error) {
 die("Koneksi gagal: " . $vkoneksi->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
 $id = $_POST['id'];
 $judul = $_POST['judul'];
 $tanggal = $_POST['tanggal'];
 $penulis = $_POST['penulis'];
 $cuplikan = $_POST['cuplikan'];
 $isi = $_POST['isi'];
 // Cek apakah ada file baru
 if ($_FILES['gambar']['name'] != "") {
 $nama_file = $_FILES['gambar']['name'];
 $lokasi_file = $_FILES['gambar']['tmp_name'];
 move_uploaded_file($lokasi_file, "uploads/" . $nama_file);
 $sql = "UPDATE berita SET judul='$judul', tanggal='$tanggal', penulis='$penulis',
 cuplikan='$cuplikan', gambar='$nama_file', isi='$isi'
 WHERE id=$id";
 } else {
 // Jika tidak ada gambar baru
 $sql = "UPDATE berita SET judul='$judul', tanggal='$tanggal', penulis='$penulis',
 cuplikan='$cuplikan', isi='$isi'
 WHERE id=$id";
 }
 if ($vkoneksi->query($sql) === TRUE) {
 echo "Data berhasil diupdate!";
 header("location: dashboard2.php");
 } else {
 echo "Error: " . $vkoneksi->error;
 }
}
?>