<?php
session_start();

if (!isset($_SESSION['s_username'])) {
    header("Location: index.html");
    exit;
}

if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
    session_destroy();
    header("Location: index.html");
    exit;
}

$host = "localhost";
$user = "root";
$password = "";
$nama_db = "db_badar_furniture";

$koneksi = new mysqli($host, $user, $password, $nama_db);

if ($koneksi->connect_error) {
    die("Koneksi database gagal: " . $koneksi->connect_error);
}

$cari = "";
$data = null;

if (isset($_GET['cari']) && !empty($_GET['cari'])) {
    $cari = $_GET['cari'];
    
    $sql = "SELECT * FROM berita WHERE judul LIKE ? OR penulis LIKE ? ORDER BY tanggal DESC";
    
    if ($stmt = $koneksi->prepare($sql)) {
        $search_term_wildcard = "%" . $cari . "%";
        $stmt->bind_param("ss", $search_term_wildcard, $search_term_wildcard);
        
        $stmt->execute();
        
        $data = $stmt->get_result();
        
        $stmt->close();
    } else {
        echo "Error saat mempersiapkan statement pencarian: " . $koneksi->error;
        $sql = "SELECT * FROM berita ORDER BY tanggal DESC";
        $data = $koneksi->query($sql);
    }
} else {
    $sql = "SELECT * FROM berita ORDER BY tanggal DESC";
    $data = $koneksi->query($sql);
}

$koneksi->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Berita</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .table img {
            max-width: 80px;
            height: auto;
            display: block;
            margin: auto;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Dashboard Berita</h2>
            <div>
                <a href="form.php" class="btn btn-primary mr-2">+ Tambah Berita</a>
                <a href="?logout=true" class="btn btn-danger">Logout</a>
            </div>
        </div>

        <form method="get" class="form-inline mb-3">
            <input 
                type="text" 
                name="cari" 
                value="<?= htmlspecialchars($cari) ?>" 
                class="form-control mr-2"
                placeholder="Cari judul atau penulis..."
            >
            <button type="submit" class="btn btn-secondary">Cari</button>
            <?php if (!empty($cari)): ?>
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
                <?php if ($data && $data->num_rows > 0): ?>
                    <?php while($row = $data->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['judul']) ?></td>
                            <td><?= htmlspecialchars($row['tanggal']) ?></td>
                            <td><?= htmlspecialchars($row['penulis']) ?></td>
                            <td>
                                <?php if (!empty($row['gambar'])): ?>
                                    <img src="uploads/<?= htmlspecialchars($row['gambar']) ?>" alt="gambar berita">
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="form_edit_berita.php?id=<?= htmlspecialchars($row['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="hapus_berita.php?id=<?= htmlspecialchars($row['id']) ?>" class="btn btn-sm btn-danger"
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
