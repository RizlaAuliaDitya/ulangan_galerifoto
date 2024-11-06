<?php
include 'db.php';
session_start();

// Pastikan pengguna telah login
if (!isset($_SESSION['loggedInUser'])) {
    header("Location: login.php");
    exit();
}

// Hapus album
if (isset($_GET['albumid'])) {
    $albumid = $_GET['albumid'];
    $sql_delete = "DELETE FROM album WHERE albumid = '$albumid'";
    mysqli_query($conn, $sql_delete);
}

// Redirect kembali ke halaman album
header("Location: albums.php");
exit();
