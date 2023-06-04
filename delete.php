<?php
// Mengimpor file konfigurasi
require_once 'config.php';

// Memeriksa apakah parameter ID telah diberikan
if (isset($_GET['id'])) {
    $nib = $_GET['id'];

    // Menjalankan query DELETE untuk menghapus data umkm
    $query = "DELETE FROM umkm WHERE nib='$nib'";
    $result = mysqli_query($conn, $query);

    // Memeriksa apakah data berhasil dihapus
    if ($result) {
        echo "Data berhasil dihapus.";
    } else {
        echo "Terjadi kesalahan: " . mysqli_error($conn);
    }
}

// Mengarahkan kembali ke homepage setelah penghapusan
header("Location: index.php");
exit();
?>

<?php
// Menutup koneksi database
mysqli_close($conn);
?>
