<?php
session_start(); // Memulai session

// Menghapus semua variabel session
$_SESSION = array();

// Menghancurkan session
session_destroy();

// Mengarahkan pengguna kembali ke halaman login
header("Location: login.php");
exit();
?>
