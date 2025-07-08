<?php
session_start();
if (!isset($_SESSION['s_username'])) {
    header("Location: index.html");
    exit;
}
  $host="localhost";
  $user="root";
  $password="";
  $nama_db="db_badar_furniture";

  $koneksi = new mysqli($host, $user, $password, $nama_db);


$data = $koneksi->query("SELECT * FROM tb_berita ORDER BY tanggal DESC");
?>

<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <title>Dashboard Berita</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    </head>
    <body class="bg-light">
        <div class="container mt-5">
            <h2 class="mb-4">Dashboard Berita</h2>
            <form id="login-form" method="POST" action=".php">
            <a href="form.php" class="btn btn-primary mb-3">+ Tambah Berita</a>
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
                    <?php while($row = $data->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['judul']) ?></td>
                            <td><?= htmlspecialchars($row['tanggal']) ?></td>
                            <td><?= htmlspecialchars($row['penulis']) ?></td>
                            <td>
                                <?php if (!empty($row['gambar'])): ?>
                                    <img src="uploads/<?= $row['gambar'] ?>" width="80" alt="gambar">
                                    <?php else: ?>
                                        -
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="form_edit_berita.php?id=<?= $row['id'] ?>" class="btn btn-sm btnwarning">Edit</a>
                                        <a href="hapus_berita.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </body>
                </html>