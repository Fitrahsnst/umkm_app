<?php
// Mengimpor file konfigurasi
require_once 'config.php';
session_start();

// Cek jika pengguna belum login, alihkan ke halaman login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Memeriksa apakah semua parameter telah diterima
    if (isset($_POST['id']) && isset($_POST['nama_umkm']) && isset($_POST['nama_pemilik']) && isset($_POST['alamat']) && isset($_POST['no_telepon']) && isset($_POST['tahun_berdiri']) && isset($_POST['jenis_umkm']) && isset($_POST['keterangan'])) {
        $id = $_POST['id'];
        $nama_umkm = $_POST['nama_umkm'];
        $nama_pemilik = $_POST['nama_pemilik'];
        $alamat = $_POST['alamat'];
        $no_telepon = $_POST['no_telepon'];
        $tahun_berdiri = $_POST['tahun_berdiri'];
        $jenis_umkm = $_POST['jenis_umkm'];
        $keterangan = $_POST['keterangan'];

        // Query untuk melakukan update data UMKM
        $query = "UPDATE umkm_sleman SET nama_umkm = ?, nama_pemilik = ?, alamat = ?, no_telepon = ?, tahun_berdiri = ?, jenis_umkm = ?, keterangan = ? WHERE nib = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ssssssss", $nama_umkm, $nama_pemilik, $alamat, $no_telepon, $tahun_berdiri, $jenis_umkm, $keterangan, $id);
        $result = mysqli_stmt_execute($stmt);

        // Query untuk melakukan update data UMKM
        $query = "UPDATE umkm_bantul SET nama_umkm = ?, nama_pemilik = ?, alamat = ?, no_telepon = ?, tahun_berdiri = ?, jenis_umkm = ?, keterangan = ? WHERE nib = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ssssssss", $nama_umkm, $nama_pemilik, $alamat, $no_telepon, $tahun_berdiri, $jenis_umkm, $keterangan, $id);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            // Jika update berhasil, alihkan kembali ke halaman utama
            header("Location: index.php");
            exit;
        } else {
            echo "Gagal melakukan update data.";
        }
    } else {
        echo "Parameter tidak lengkap.";
    }
} else {
    echo "Metode permintaan tidak valid.";
}
?>
