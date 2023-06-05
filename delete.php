<?php
// Mengimpor file konfigurasi
require_once 'config.php';
session_start();

// Cek jika pengguna belum login, alihkan ke halaman login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Memeriksa apakah parameter ID telah diterima
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Query untuk menghapus data UMKM dari tabel umkm_sleman
        $querySleman = "DELETE FROM umkm_sleman WHERE nib = ?";
        $stmtSleman = mysqli_prepare($conn, $querySleman);
        mysqli_stmt_bind_param($stmtSleman, "s", $id);
        $resultSleman = mysqli_stmt_execute($stmtSleman);

        // Query untuk menghapus data UMKM dari tabel umkm_bantul
        $queryBantul = "DELETE FROM umkm_bantul WHERE nib = ?";
        $stmtBantul = mysqli_prepare($conn, $queryBantul);
        mysqli_stmt_bind_param($stmtBantul, "s", $id);
        $resultBantul = mysqli_stmt_execute($stmtBantul);

        if ($resultSleman && $resultBantul) {
            // Jika penghapusan berhasil, alihkan kembali ke halaman utama
            header("Location: index.php");
            exit;
        } else {
            echo "Gagal menghapus data.";
        }
    } else {
        echo "Parameter tidak lengkap.";
    }
} else {
    echo "Metode permintaan tidak valid.";
}
?>
