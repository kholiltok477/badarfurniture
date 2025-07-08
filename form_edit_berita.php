form_edit_berita.php
<?php
session_start();
if (!isset($_SESSION['s_username'])) {
 header("Location: index.html");
 exit;
}
$koneksi = new mysqli("localhost", "root", "", "db_badar_furniture");
if ($koneksi->connect_error) {
 die("Koneksi gagal: " . $koneksi->connect_error);
}
$id = $_GET['id'];
$sql = "SELECT * FROM berita WHERE id = $id";
$result = $koneksi->query($sql);
$data = $result->fetch_assoc();
?>
<h2>Edit Berita</h2>
<form method="post" action="edit_berita.php" enctype="multipart/form-data">
 <input type="hidden" name="id" value="<?= $data['id'] ?>">
 <label>Judul:</label><br>
 <input type="text" name="judul" value="<?= $data['judul'] ?>"><br><br>
 <label>Tanggal:</label><br>
 <input type="date" name="tanggal" value="<?= $data['tanggal'] ?>"><br><br>
 <label>Penulis:</label><br>
 <input type="text" name="penulis" value="<?= $data['penulis'] ?>"><br><br>
 <label>Cuplikan:</label><br>
 <textarea name="cuplikan"><?= $data['cuplikan'] ?></textarea><br><br>
 <label>Gambar (biarkan kosong jika tidak ingin mengubah):</label><br>
 <input type="file" name="gambar"><br><br>
 <label>Isi:</label><br>
 <textarea name="isi"><?= $data['isi'] ?></textarea><br><br>
 <input type="submit" value="Simpan Perubahan">
</form>
