<?php
// Mengimpor file konfigurasi
require_once 'config.php';

// Memeriksa apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mengambil data dari form
    $nib = $_POST['nib'];
    $nama_umkm = $_POST['nama_umkm'];
    $nama_pemilik = $_POST['nama_pemilik'];
    $alamat = $_POST['alamat'];
    $no_telepon = $_POST['no_telepon'];
    $tahun_berdiri = $_POST['tahun_berdiri'];
    $jenis_umkm = $_POST['jenis_umkm'];
    $keterangan = $_POST['keterangan'];

    // Menjalankan query INSERT untuk memasukkan data umkm baru
    $query = "INSERT INTO umkm (nib, nama_umkm, nama_pemilik, alamat, no_telepon, tahun_berdiri, jenis_umkm, keterangan) VALUES ('$nib', '$nama_umkm', '$nama_pemilik', '$alamat', '$no_telepon', '$tahun_berdiri', '$jenis_umkm', '$keterangan')";
    $result = mysqli_query($conn, $query);

    // Memeriksa apakah data berhasil ditambahkan
    if ($result) {
        echo "Data berhasil ditambahkan.";
    } else {
        echo "Terjadi kesalahan: " . mysqli_error($conn);
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Tambahkan UMKM Baru</title>
    <link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
    <h1>Tambahkan UMKM Baru</h1>
    <form method="post" action="">
        <label for="nib">NIB:</label>
        <input type="text" name="nib" id="nib" required><br>
        
        <label for="nama_umkm">Nama UMKM:</label>
        <input type="text" name="nama_umkm" id="nama_umkm" required><br>
        
        <label for="nama_pemilik">Nama Pemilik:</label>
        <input type="text" name="nama_pemilik" id="nama_pemilik" required><br>
        
        <label for="alamat">Alamat:</label>
        <textarea name="alamat" id="alamat" required></textarea><br>
        
        <label for="no_telepon">No Telepon:</label>
        <input type="text" name="no_telepon" id="no_telepon" required><br>
        
        <label for="tahun_berdiri">Tahun Berdiri:</label>
        <input type="text" name="tahun_berdiri" id="tahun_berdiri" required><br>
        
        <label for="jenis_umkm">Jenis UMKM:</label>
        <input type="text" name="jenis_umkm" id="jenis_umkm" required><br>

        <label for="keterangan">Keterangan:</label>
        <input type="text" name="keterangan" id="keterangan" required><br>

        <br> <input type="submit" value="Tambahkan">
    </form>
</body>
</html>

<?php ?>
<br><button class="btn btn-back" onclick="location.href='index.php'">Kembali ke Beranda</button>
    <?php ?>

<?php
// Menutup koneksi database
mysqli_close($conn);
?>
