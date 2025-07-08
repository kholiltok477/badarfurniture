<?php
session_start();
//session_destroy();
if (!isset($_SESSION['s_username'])){
    header("location: index.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Berita</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            padding: 20px;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <h1>Form Berita</h1>
    <form action="save_news.php" method=  "post" enctype="multipart/form-data">

    <label for="judul">Judul Berita</label>
    <input type="text" name="judul" id="judul" placeholder="Masukkan judul berita..."required>

    <label for="tanggal">Tanggal</label>
    <input type="date" name="tanggal" id="tanggal"required>

    <label for="penulis">Nama Penulis</label>
    <input type="text" name="penulis" id="penulis" placeholder="Masukkan nama penulis..."required>

    <label for="cuplikan">Cuplikan</label>
    <textarea name="cuplikan" id="cuplikan" rows="3" placeholder="Masukkan cuplikan berita..."required></textarea>

    <label for="gambar">Unggah Gambar</label>
    <input type="file" name="gambar" id="gambar"required>
    <p id="file-status">Tidak ada file yang dipilih</p>

    <label for="isi">Isi Berita</label>
    <textarea name="isi" id="isi" rows="5" placeholder="Masukkan isi berita..."required></textarea>

    <button onclick="submitForm()">Kirim</button>

    <script>
        // Menangani pemilihan file
        document.getElementById('gambar').addEventListener('change', function() {
            const fileStatus = document.getElementById('file-status');
            if (this.files.length > 0) {
                fileStatus.innerText = this.files[0].name;
            } else {
                fileStatus.innerText = "Tidak ada file yang dipilih";
            }
        });

        // Fungsi untuk menangani pengiriman form
        function submitForm() {
            alert('Form telah dikirim!');
            // Lanjutkan dengan pengolahan form di sini
        }
    </script>

</body>
</html>
