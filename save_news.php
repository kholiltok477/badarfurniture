<?php
session_start();
if (!isset($_SESSION['s_username'])){
    header("location: index.html");
    exit;
}
  $host="localhost";
  $user="root";
  $password="";
  $nama_db="db_badar_furniture";
  $koneksi = new mysqli($host, $user, $password, $nama_db);
  if ($koneksi->connect_error){
    die("koneksi database gagal");}

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $judul = $_POST['judul'];
    $tanggal = $_POST['tanggal'];
    $penulis = $_POST['penulis'];
    $cuplikan = $_POST['cuplikan'];
    $isi = $_POST['isi'];

    //proses upload gambar
    $nama_file = $_FILES['gambar']['name'];
    $lokasi_file = $_FILES['gambar']['tmp_name'];
    move_uploaded_file($lokasi_file, "uploads/". $nama_file);

    $sql = "INSERT INTO berita (judul, tanggal, penulis, cuplikan, gambar, isi)  VALUES ('$judul','$tanggal', '$penulis', '$cuplikan' ,'$nama_file', '$isi')";
    $hasil = $koneksi->query($sql);
    if($hasil) {
    echo "berhasil";
    }else {
        echo "gagal menyimpan: ". $koneksi->error;
    } 
    header("location: dashboard2.php");
}
?>
