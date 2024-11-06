<?php
include 'db.php';
session_start();

// Pastikan pengguna telah login
if (!isset($_SESSION['loggedInUser'])) {
    header("Location: login.php");
    exit();
}

// Hapus foto
if (isset($_GET['fotoid'])) {
    $fotoid = $_GET['fotoid'];
    $sql_delete = "DELETE FROM foto WHERE fotoid = '$fotoid'";
    mysqli_query($conn, $sql_delete);
}

// Redirect kembali ke halaman album
header("Location: albums.php");
exit();
