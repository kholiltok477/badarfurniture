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
if (isset($_GET['id'])) {
 $id = $_GET['id'];
 // Opsional: hapus file gambar jika ingin
 $query = "SELECT gambar FROM berita WHERE id=$id";
 $result = $vkoneksi->query($query);
 if ($result && $row = $result->fetch_assoc()) {
 $gambar = $row['gambar'];
 if (file_exists("uploads/" . $gambar)) {
 unlink("uploads/" . $gambar);
 }
 }
 // Hapus dari database
 $sql = "DELETE FROM berita WHERE id=$id";
 if ($vkoneksi->query($sql) === TRUE) {
 echo "Data berhasil dihapus!";
 } else {
 echo "Error: " . $vkoneksi->error;
 }
}
?>