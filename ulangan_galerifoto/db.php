<?php
$servername = "localhost";
$username = "root";     // Sesuaikan dengan username MySQL Anda, biasanya "root"
$password = "";         // Kosongkan jika tidak ada password
$dbname = "ulangan_galerifoto";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
