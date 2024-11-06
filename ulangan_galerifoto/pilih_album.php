<?php
include 'db.php';
session_start();

// Cek jika pengguna belum login
if (!isset($_SESSION['loggedInUser'])) {
    header("Location: login.php");
    exit();
}

// Mendapatkan daftar album dari database
$sql = "SELECT albumid, nama_album FROM album WHERE userid = '" . $_SESSION['userid'] . "'";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Album - Galeri Foto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

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

<div class="container mt-5">
    <h2>Pilih Album</h2>
    <form action="tambah_foto.php" method="POST">
        <div class="mb-3">
            <label for="albumid" class="form-label">Album</label>
            <select class="form-select" id="albumid" name="albumid" required>
                <option value="">Pilih Album</option>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <option value="<?= $row['albumid']; ?>"><?= $row['nama_album']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Pilih Album</button>
    </form>
</div>

<?php
// Menangani pengiriman form untuk memilih album
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['default_album_id'] = $_POST['albumid'];
    header("Location: tambah_foto.php"); // Arahkan ke halaman tambah foto
    exit();
}
?>

</body>
</html>
