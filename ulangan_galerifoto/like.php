<?php
include 'db.php';
session_start();

// Pastikan pengguna telah login
if (!isset($_SESSION['loggedInUser'])) {
    echo json_encode(['success' => false]);
    exit();
}

if (isset($_GET['like_fotoid'])) {
    $fotoid = $_GET['like_fotoid'];
    $userid = $_SESSION['userid'];

    // Cek apakah user sudah memberi like pada foto ini
    $check_like = "SELECT * FROM likefoto WHERE fotoid = '$fotoid' AND userid = '$userid'";
    $result_check = mysqli_query($conn, $check_like);

    if (mysqli_num_rows($result_check) == 0) {
        // Jika belum memberi like, insert like ke database
        $sql_like = "INSERT INTO likefoto (fotoid, userid) VALUES ('$fotoid', '$userid')";
        mysqli_query($conn, $sql_like);
    } else {
        // Jika sudah memberi like, hapus like dari database
        $sql_unlike = "DELETE FROM likefoto WHERE fotoid = '$fotoid' AND userid = '$userid'";
        mysqli_query($conn, $sql_unlike);
    }

    // Hitung total likes setelah penambahan atau pengurangan
    $count_likes = "SELECT COUNT(*) AS total_likes FROM likefoto WHERE fotoid = '$fotoid'";
    $result_count = mysqli_query($conn, $count_likes);
    $likes = mysqli_fetch_assoc($result_count)['total_likes'];

    echo json_encode(['success' => true, 'total_likes' => $likes]);
} else {
    echo json_encode(['success' => false]);
}
?>
