<?php 
include 'db.php'; 

// Memulai session jika belum dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Ambil album berdasarkan ID dari query string
$albumId = isset($_GET['albumid']) ? intval($_GET['albumid']) : 0;
$query = "SELECT * FROM album WHERE albumid = $albumId";
$result = mysqli_query($conn, $query);
$album = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Album - Galeri Foto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
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
                
                <!-- Dynamic Auth Buttons -->
                <?php if (isset($_SESSION['loggedInUser'])): ?>
                    <a class="btn btn-outline-light me-2" href="logout.php">Logout</a>
                <?php else: ?>
                    <a class="btn btn-outline-light me-2" href="login.php">Login</a>
                    <a class="btn btn-outline-light me-2" href="register.php">Register</a>
                <?php endif; ?>

                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-light" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main content -->
    <main class="container mt-4">
        <h2 class="mb-4 text-center"><?php echo htmlspecialchars($album['namaalbum']); ?></h2>
        <p class="text-center"><?php echo htmlspecialchars($album['deskripsi']); ?></p>
        <p class="text-center"><small>Dibuat pada: <?php echo htmlspecialchars($album['tanggaldibuat']); ?></small></p>
        
        <!-- Di sini, Anda bisa menambahkan kode untuk menampilkan foto-foto di dalam album -->
    </main>

    <!-- Footer -->
    <footer class="text-center">
        <div class="container">
            <p>&copy; Ulangan 2024 Galeri Foto Made By RIZLA Version 2.</p>
        </div>
    </footer>

</body>
</html>
