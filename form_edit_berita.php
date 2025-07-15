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
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Berita</title>
    <style>
      
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1, h2 {
            color: #343a40;
            margin-bottom: 30px;
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
            color: #495057;
        }

        input[type="text"],
        input[type="date"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        input[type="file"] {
            margin-bottom: 0;
        }

        #file-status {
            margin-top: 5px;
            margin-bottom: 15px;
            font-size: 0.9em;
            color: #666;
        }

        input[type="submit"],
        button {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
            align-self: flex-start;
            margin-top: 15px;
            width: auto;
        }

        input[type="submit"]:hover,
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Berita</h2>
        <form method="post" action="edit_berita.php" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $data['id'] ?>">

            <label for="judul">Judul Berita</label>
            <input type="text" name="judul" id="judul" value="<?= $data['judul'] ?>" placeholder="Masukkan judul berita..." required>

            <label for="tanggal">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" value="<?= $data['tanggal'] ?>" required>

            <label for="penulis">Nama Penulis</label>
            <input type="text" name="penulis" id="penulis" value="<?= $data['penulis'] ?>" placeholder="Masukkan nama penulis..." required>

            <label for="cuplikan">Cuplikan</label>
            <textarea name="cuplikan" id="cuplikan" rows="3" placeholder="Masukkan cuplikan berita..." required><?= $data['cuplikan'] ?></textarea>

            <label for="gambar">Gambar (biarkan kosong jika tidak ingin mengubah):</label>
            <input type="file" name="gambar" id="gambar">
            <p id="file-status">Gambar saat ini: <?= !empty($data['gambar']) ? basename($data['gambar']) : 'Tidak ada gambar' ?></p>

            <label for="isi">Isi Berita</label>
            <textarea name="isi" id="isi" rows="5" placeholder="Masukkan isi berita..." required><?= $data['isi'] ?></textarea>

            <input type="submit" value="Simpan Perubahan">
        </form>
    </div>

    <script>
        // Menangani pemilihan file untuk form edit
        document.getElementById('gambar').addEventListener('change', function() {
            const fileStatus = document.getElementById('file-status');
            if (this.files.length > 0) {
                fileStatus.innerText = this.files[0].name;
            } else {
                // Jika tidak ada file baru yang dipilih, tampilkan nama gambar yang sudah ada (jika ada)
                fileStatus.innerText = "Gambar saat ini: <?= !empty($data['gambar']) ? basename($data['gambar']) : 'Tidak ada gambar' ?>";
            }
        });
    </script>
</body>
</html>
