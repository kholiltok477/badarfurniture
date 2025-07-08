<?php

session_start();

  $host="localhost";
  $user="root";
  $password="";
  $nama_db="db_badar_furniture";

  $koneksi = new mysqli($host, $user, $password, $nama_db);
  if ($koneksi->connect_error){
    die("koneksi database gagal");
  }
  else
   {echo "koneksi sukses";}

 $admin = $_POST['username'];
 $password =$_POST['password'];
 echo $admin. "-". $password;

 $sql = "SELECT * FROM pengguna WHERE admin = '$admin' AND password= '$password'";
 $hasil = $koneksi->query($sql);

 //periksa hasil pencarian dari database
 if ($hasil->num_rows>0){
   $data = $hasil->fetch_array();
   $nama = $data[0];
   $aktivitas = "login";
   $waktu = date ('d-m-Y H:i:s');
  $_SESSION['s_username'] = $admin;
  header("Location: dashboard2.php");
}
else{
  header("Location: index.html");
}
?>