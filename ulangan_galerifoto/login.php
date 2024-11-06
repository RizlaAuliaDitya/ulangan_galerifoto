<?php 
include 'db.php'; 

// Memulai session jika belum dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Proses login jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Pastikan menggunakan prepared statement untuk keamanan
    $stmt = $conn->prepare("SELECT * FROM user WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Mengambil data pengguna
        $user = $result->fetch_assoc();

        // Menyimpan informasi pengguna dalam session
        $_SESSION['loggedInUser'] = $user['username'];
        $_SESSION['userid'] = $user['userid']; // Menyimpan user ID ke dalam session
        header("Location: home.php");
        exit();
    } else {
        $error = "Username atau password salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Galeri Foto</title>
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
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-container {
            background: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            width: 400px;
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
            </div>
        </div>
    </nav>

    <!-- Main content -->
    <main class="container mt-5">
        <div class="form-container">
            <h2>Login</h2>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger" role="alert">
                    <?= htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form action="login.php" method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>

            <p class="mt-3">Belum punya akun? <a href="register.php">Daftar sekarang!</a></p>
        </div>
    </main>

    <!-- Footer -->
    <footer class="text-center">
        <div class="container">
            <p>&copy; Ulangan 2024 Galeri Foto Made By RIZLA Version 2.</p>
        </div>
    </footer>

</body>
</html>
