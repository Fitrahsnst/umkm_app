<?php
// Informasi koneksi database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'database_umkm';

// Membuat koneksi ke database
$conn = mysqli_connect($host, $username, $password, $database);

// Memeriksa apakah koneksi berhasil
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
