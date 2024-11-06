<?php 
include 'db.php'; 
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['userid'])) {
    // Jika belum login, alihkan ke halaman login
    header("Location: login.php");
    exit();
}

// Proses untuk menambahkan foto dan album
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Variabel untuk menampung status
    $fotoDitambahkan = false;
    $albumDitambahkan = false;

    // Proses menambahkan foto jika data foto ada
    if (isset($_POST['judulfoto'])) {
        $judulfoto = $_POST['judulfoto'];
        $deskripsifoto = $_POST['deskripsifoto'];
        $lokasifile = $_FILES['file']['name'];
        $tanggalunggah = date("Y-m-d H:i:s"); // Tanggal unggah
        $target_dir = "uploads/"; // Pastikan folder ini sudah ada
        $target_file = $target_dir . basename($_FILES["file"]["name"]);

        // Pindahkan file yang diupload ke direktori tujuan
        move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);

        // Simpan informasi foto ke database
        $sql_foto = "INSERT INTO foto (judulfoto, deskripsifoto, tanggalunggah, lokasifile, userid) VALUES ('$judulfoto', '$deskripsifoto', '$tanggalunggah', '$target_file', '" . $_SESSION['userid'] . "')";
        mysqli_query($conn, $sql_foto);
        $fotoDitambahkan = true; // Set status foto ditambahkan
    }

    // Proses menambahkan album jika data album ada
    if (isset($_POST['namaalbum'])) {
        $namaalbum = $_POST['namaalbum'];
        $deskripsi = $_POST['deskripsi'];
        $tanggaldibuat = date("Y-m-d H:i:s"); // Tanggal dibuat

        // Simpan informasi album ke database
        $sql_album = "INSERT INTO album (namaalbum, deskripsi, tanggaldibuat, userid) VALUES ('$namaalbum', '$deskripsi', '$tanggaldibuat', '" . $_SESSION['userid'] . "')";
        mysqli_query($conn, $sql_album);
        $albumDitambahkan = true; // Set status album ditambahkan
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Foto dan Album - Galeri Foto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background: linear-gradient(135deg, #8bff00, #00c3ff, #b2ff00, #ff007f);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        main {
            flex: 1;
            padding: 20px;
        }
        footer {
            background-color: #343a40;
            color: white;
            padding: 10px 0;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Galeri Foto</a>
            <div class="d-flex align-items-center ms-3">
                <a class="btn btn-outline-light me-2" href="home.php">Home</a>
                <a class="btn btn-outline-light me-2" href="albums.php">Albums</a>
                <a class="btn btn-outline-light me-2" href="tambah_foto.php">Tambah Foto</a>
                <a class="btn btn-outline-light me-2" href="logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Main content -->
    <main class="container mt-5">
        <h2>Tambah Foto dan Album</h2>
        <form action="tambah_foto.php" method="POST" enctype="multipart/form-data">
            <div class="mb-4">
                <h4>Tambah Foto</h4>
                <div class="mb-3">
                    <label for="judulfoto" class="form-label">Judul Foto</label>
                    <input type="text" class="form-control" id="judulfoto" name="judulfoto" required>
                </div>
                <div class="mb-3">
                    <label for="deskripsifoto" class="form-label">Deskripsi Foto</label>
                    <textarea class="form-control" id="deskripsifoto" name="deskripsifoto" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="file" class="form-label">Pilih File</label>
                    <input type="file" class="form-control" id="file" name="file" accept="image/*" required>
                </div>
            </div>

            <div class="mb-4">
                <h4>Tambah Album</h4>
                <div class="mb-3">
                    <label for="namaalbum" class="form-label">Nama Album</label>
                    <input type="text" class="form-control" id="namaalbum" name="namaalbum" required>
                </div>
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi Album</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" required></textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Tambah Foto dan Album</button>
        </form>

        <?php if (isset($fotoDitambahkan) && $fotoDitambahkan): ?>
            <div class="alert alert-success mt-3">Foto berhasil ditambahkan!</div>
        <?php endif; ?>
        
        <?php if (isset($albumDitambahkan) && $albumDitambahkan): ?>
            <div class="alert alert-success mt-3">Album berhasil ditambahkan!</div>
        <?php endif; ?>
    </main>

    <!-- Footer -->
    <footer class="text-center">
        <div class="container">
            <p>&copy; Ulangan 2024 Galeri Foto Made By RIZLA Version 2.</p>
        </div>
    </footer>
</body>
</html>
