<?php
include 'db.php';
session_start();

if (!isset($_SESSION['userid']) || !isset($_POST['fotoid'])) {
    echo json_encode(['status' => 'error']);
    exit();
}

$fotoid = $_POST['fotoid'];
$userid = $_SESSION['userid'];

// Cek apakah sudah like atau belum
$sql_check = "SELECT * FROM likefoto WHERE fotoid = '$fotoid' AND userid = '$userid'";
$result_check = mysqli_query($conn, $sql_check);

if (mysqli_num_rows($result_check) > 0) {
    // Jika sudah like, maka unlike
    $sql_unlike = "DELETE FROM likefoto WHERE fotoid = '$fotoid' AND userid = '$userid'";
    mysqli_query($conn, $sql_unlike);
    echo json_encode(['status' => 'unliked']);
} else {
    // Jika belum like, tambahkan like
    $sql_like = "INSERT INTO likefoto (fotoid, userid) VALUES ('$fotoid', '$userid')";
    mysqli_query($conn, $sql_like);
    echo json_encode(['status' => 'liked']);
}
?>
