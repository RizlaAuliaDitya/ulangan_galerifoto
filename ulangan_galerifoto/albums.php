<?php 
include 'db.php'; 
session_start();

// Pastikan pengguna telah login
if (!isset($_SESSION['loggedInUser'])) {
    header("Location: login.php");
    exit();
}

// Proses komentar baru
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comment'])) {
    $fotoid = $_POST['fotoid'];
    $userid = $_SESSION['userid'];
    $isikomentar = $_POST['comment'];

    // Insert komentar ke database
    $sql_comment = "INSERT INTO komentar_foto (fotoid, userid, isikomentar, tanggalkomentar) VALUES ('$fotoid', '$userid', '$isikomentar', NOW())";
    mysqli_query($conn, $sql_comment);
}

// Proses hapus komentar
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['hapus_komentar'])) {
    $komentarid = $_POST['komentarid'];
    $userid = $_SESSION['userid'];

    // Periksa apakah pengguna memiliki izin untuk menghapus komentar ini
    $sql_cek = "SELECT * FROM komentar_foto WHERE komentarid = '$komentarid' AND userid = '$userid'";
    $result_cek = mysqli_query($conn, $sql_cek);

    if (mysqli_num_rows($result_cek) > 0) {
        // Jika pengguna memiliki izin, hapus komentar
        $sql_hapus = "DELETE FROM komentar_foto WHERE komentarid = '$komentarid'";
        mysqli_query($conn, $sql_hapus);
        echo "<div class='alert alert-success'>Komentar berhasil dihapus.</div>";
    } else {
        echo "<div class='alert alert-danger'>Anda tidak memiliki izin untuk menghapus komentar ini.</div>";
    }
}

// Proses like dan unlike
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $fotoid = $_POST['fotoid'];
    $userid = $_SESSION['userid'];

    if ($_POST['action'] == 'like') {
        // Cek apakah sudah like sebelumnya
        $sql_check_like = "SELECT * FROM likefoto WHERE fotoid = '$fotoid' AND userid = '$userid'";
        $result_check_like = mysqli_query($conn, $sql_check_like);

        if (mysqli_num_rows($result_check_like) == 0) {
            // Jika belum, tambahkan like
            $sql_like = "INSERT INTO likefoto (fotoid, userid) VALUES ('$fotoid', '$userid')";
            mysqli_query($conn, $sql_like);
        }
    } else if ($_POST['action'] == 'unlike') {
        // Jika ingin unlike, hapus like
        $sql_unlike = "DELETE FROM likefoto WHERE fotoid = '$fotoid' AND userid = '$userid'";
        mysqli_query($conn, $sql_unlike);
    }
}

// Proses hapus foto
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['hapus_foto'])) {
    $fotoid = $_POST['fotoid'];

    // Hapus foto dari database
    $sql_hapus_foto = "DELETE FROM foto WHERE fotoid = '$fotoid'";
    mysqli_query($conn, $sql_hapus_foto);
    echo "<div class='alert alert-success'>Foto berhasil dihapus.</div>";
}

// Proses hapus album
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['hapus_album'])) {
    $albumid = $_POST['albumid'];

    // Hapus album dari database
    $sql_hapus_album = "DELETE FROM album WHERE albumid = '$albumid'";
    mysqli_query($conn, $sql_hapus_album);
    echo "<div class='alert alert-success'>Album berhasil dihapus.</div>";
}

// Ambil data album dari database
$sql_album = "SELECT * FROM album WHERE userid = '" . $_SESSION['userid'] . "'";
$result_album = mysqli_query($conn, $sql_album);

$sql_foto = "SELECT f.*, COUNT(c.komentarid) as total_comments, 
             (SELECT COUNT(*) FROM likefoto WHERE fotoid = f.fotoid) as total_likes,
             IF(l.userid IS NOT NULL, 1, 0) AS liked
              FROM foto f
              LEFT JOIN komentar_foto c ON f.fotoid = c.fotoid
              LEFT JOIN likefoto l ON f.fotoid = l.fotoid AND l.userid = '" . $_SESSION['userid'] . "'
              WHERE f.userid = '" . $_SESSION['userid'] . "'
              GROUP BY f.fotoid";
$result_foto = mysqli_query($conn, $sql_foto);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Albums - Galeri Foto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
        }
        .album-container, .foto-container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        footer {
            background-color: #343a40;
            color: white;
            padding: 10px 0;
            text-align: center;
        }
        .like-button {
            cursor: pointer;
            font-size: 24px;
            color: gray;
            transition: color 0.3s ease;
        }
        .like-button.liked {
            color: red;
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
                <a class="btn btn-outline-light me-2" href="tambah_foto.php">Tambah Foto</a>
                <a class="btn btn-outline-light me-2" href="logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Main content -->
    <main class="container mt-5">
        <h2>Albums dan Foto Anda</h2>

        <div class="row">
            <div class="col-md-6">
                <h4>Album</h4>
                <?php if (mysqli_num_rows($result_album) > 0): ?>
                    <?php while ($album = mysqli_fetch_assoc($result_album)): ?>
                        <div class="album-container">
                            <h5><?= htmlspecialchars($album['namaalbum']); ?></h5>
                            <p><?= htmlspecialchars($album['deskripsi']); ?></p>
                            <p>Tanggal Dibuat: <?= htmlspecialchars($album['tanggaldibuat']); ?></p>

                            <!-- Tombol hapus album dengan ikon tempat sampah -->
                            <form method="POST" onsubmit="return confirm('Anda yakin ingin menghapus album ini?');" style="display:inline;">
                                <input type="hidden" name="albumid" value="<?= $album['albumid']; ?>">
                                <button type="submit" name="hapus_album" class="btn btn-link text-danger">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="album-container">
                        <p>Tidak ada album yang ditemukan.</p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-md-6">
                <h4>Foto</h4>
                <?php if (mysqli_num_rows($result_foto) > 0): ?>
                    <?php while ($foto = mysqli_fetch_assoc($result_foto)): ?>
                        <div class="foto-container">
                            <h5><?= htmlspecialchars($foto['judulfoto']); ?></h5>
                            <img src="<?= htmlspecialchars($foto['lokasifile']); ?>" alt="<?= htmlspecialchars($foto['judulfoto']); ?>" class="img-fluid" />
                            <p><?= htmlspecialchars($foto['deskripsifoto']); ?></p>
                            <p>Tanggal Unggah: <?= htmlspecialchars($foto['tanggalunggah']); ?></p>
                            
                            <span class="like-button <?= $foto['liked'] ? 'liked' : ''; ?>" data-fotoid="<?= $foto['fotoid']; ?>" data-action="<?= $foto['liked'] ? 'unlike' : 'like'; ?>">
                                <i class="fas fa-heart"></i> <?= $foto['total_likes']; ?>
                            </span>
                            <span>(<?= $foto['total_comments']; ?> komentar)</span>

                            <!-- Tombol hapus foto dengan ikon tempat sampah -->
                            <form method="POST" onsubmit="return confirm('Anda yakin ingin menghapus foto ini?');" style="display:inline;">
                                <input type="hidden" name="fotoid" value="<?= $foto['fotoid']; ?>">
                                <button type="submit" name="hapus_foto" class="btn btn-link text-danger">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>

                            <!-- Daftar komentar -->
                            <div class="comments-section">
                                <h6>Komentar:</h6>
                                <form method="POST">
                                    <input type="hidden" name="fotoid" value="<?= $foto['fotoid']; ?>">
                                    <input type="text" name="comment" placeholder="Tulis komentar..." required>
                                    <button type="submit" class="btn btn-primary">Kirim</button>
                                </form>

                                <?php
                                // Ambil komentar untuk foto ini
                                $sql_komentar = "SELECT * FROM komentar_foto WHERE fotoid = '" . $foto['fotoid'] . "'";
                                $result_komentar = mysqli_query($conn, $sql_komentar);
                                if (mysqli_num_rows($result_komentar) > 0) {
                                    while ($komentar = mysqli_fetch_assoc($result_komentar)) {
                                        echo "<div><strong>" . htmlspecialchars($komentar['userid']) . ":</strong> " . htmlspecialchars($komentar['isikomentar']) . "
                                                <form method='POST' style='display:inline;'>
                                                    <input type='hidden' name='komentarid' value='" . $komentar['komentarid'] . "'>
                                                    <button type='submit' name='hapus_komentar' class='btn btn-link text-danger' onclick=\"return confirm('Anda yakin ingin menghapus komentar ini?');\">Hapus</button>
                                                </form>
                                            </div>";
                                    }
                                } else {
                                    echo "<div>Tidak ada komentar.</div>";
                                }
                                ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="foto-container">
                        <p>Tidak ada foto yang ditemukan.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; Ulangan 2024 Galeri Foto Made By RIZLA Version 2.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Like/unlike functionality
        $(document).on('click', '.like-button', function() {
            var fotoid = $(this).data('fotoid');
            var action = $(this).data('action');
            var button = $(this);

            $.post('', { fotoid: fotoid, action: action }, function() {
                button.toggleClass('liked');
                button.data('action', action === 'like' ? 'unlike' : 'like');
                var likesCount = parseInt(button.text());
                button.html('<i class="fas fa-heart"></i> ' + (action === 'like' ? likesCount + 1 : likesCount - 1));
            });
        });

    </script>
</body>
</html>
