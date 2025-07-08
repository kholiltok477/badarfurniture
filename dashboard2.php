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
// Pencarian
$cari = "";
if (isset($_GET['cari'])) {
 $cari = $koneksi->real_escape_string($_GET['cari']);
 $sql = "SELECT * FROM berita
 WHERE judul LIKE '%$cari%' OR penulis LIKE '%$cari%'
 ORDER BY tanggal DESC";
} else {
 $sql = "SELECT * FROM berita ORDER BY tanggal DESC";
}
$data = $koneksi->query($sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
 <meta charset="UTF-8">
 <title>Dashboard Berita</title>
 <link rel="stylesheet"
href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
 <div class="d-flex justify-content-between align-items-center mb-4">
 <h2>Dashboard Berita</h2>
 <a href="form_tambah_berita.php" class="btn btn-primary">+ Tambah Berita</a>
 </div>
 <!-- Form Pencarian -->
 <form method="get" class="form-inline mb-3">
 <input type="text" name="cari" value="<?= htmlspecialchars($cari) ?>" class="form-control mr-2"
placeholder="Cari judul atau penulis...">
 <button type="submit" class="btn btn-secondary">Cari</button>
 <?php if ($cari): ?>
 <a href="dashboard.php" class="btn btn-link">Reset</a>
 <?php endif; ?>
 </form>
 <table class="table table-bordered table-hover bg-white">
 <thead class="thead-dark">
 <tr>
 <th>Judul</th>
 <th>Tanggal</th>
 <th>Penulis</th>
 <th>Gambar</th>
 <th>Aksi</th>
 </tr>
 </thead>
 <tbody>
 <?php if ($data->num_rows > 0): ?>
 <?php while($row = $data->fetch_assoc()): ?>
 <tr>
 <td><?= htmlspecialchars($row['judul']) ?></td>
 <td><?= htmlspecialchars($row['tanggal']) ?></td>
 <td><?= htmlspecialchars($row['penulis']) ?></td>
 <td>
 <?php if (!empty($row['gambar'])): ?>
 <img src="uploads/<?= $row['gambar'] ?>" width="80" alt="gambar">
 <?php else: ?> -
 <?php endif; ?>
 </td>
 <td>
 <a href="form_edit_berita.php?id=<?= $row['id'] ?>" class="btn btn-sm btnwarning">Edit</a>
 <a href="hapus_berita.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger"
 onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
 </td>
 </tr>
 <?php endwhile; ?>
 <?php else: ?>
 <tr><td colspan="5" class="text-center">Data tidak ditemukan</td></tr>
 <?php endif; ?>
 </tbody>
 </table>
</div>
</body>
</html>