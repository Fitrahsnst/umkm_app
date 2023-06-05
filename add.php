<?php
// Mengimpor file konfigurasi
require_once 'config.php';
session_start();

// Cek jika pengguna belum login, alihkan ke halaman login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Inisialisasi variabel pesan error
$error = '';

// Cek jika tombol Submit diklik
if (isset($_POST['submit'])) {
    $nib = $_POST['nib'];
    $nama_umkm = $_POST['nama_umkm'];
    $nama_pemilik = $_POST['nama_pemilik'];
    $alamat = $_POST['alamat'];
    $no_telepon = $_POST['no_telepon'];
    $tahun_berdiri = $_POST['tahun_berdiri'];
    $jenis_umkm = $_POST['jenis_umkm'];
    $keterangan = $_POST['keterangan'];
    
    // Validasi input
    if (empty($nib) || empty($nama_umkm) || empty($nama_pemilik) || empty($alamat) || empty($no_telepon) || empty($tahun_berdiri) || empty($jenis_umkm) || empty($keterangan)) {
        $error = 'Semua field harus diisi';
    } else {
        // Query untuk menambah data ke tabel umkm_sleman atau umkm_bantul sesuai jenis umkm yang dipilih
        if ($_POST['jenis'] === 'sleman') {
            $query = "INSERT INTO umkm_sleman (nib, nama_umkm, nama_pemilik, alamat, no_telepon, tahun_berdiri, jenis_umkm, keterangan) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        } elseif ($_POST['jenis'] === 'bantul') {
            $query = "INSERT INTO umkm_bantul (nib, nama_umkm, nama_pemilik, alamat, no_telepon, tahun_berdiri, jenis_umkm, keterangan) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        }
        
        $stmt = mysqli_prepare($conn, $query);
        
        // Binding parameter
        mysqli_stmt_bind_param($stmt, 'ssssssss', $nib, $nama_umkm, $nama_pemilik, $alamat, $no_telepon, $tahun_berdiri, $jenis_umkm, $keterangan);
        
        // Eksekusi statement
        if (mysqli_stmt_execute($stmt)) {
            // Redirect ke halaman utama setelah berhasil menambah data
            header("Location: index.php");
            exit;
        } else {
            $error = 'Terjadi kesalahan. Gagal menambahkan data.';
        }
    }
}

// Tutup koneksi database
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h2>Tambah Data</h2>
    <?php if ($error) { ?>
        <p class="error"><?php echo $error; ?></p>
    <?php } ?>
    <form method="POST" action="add.php">
        <input type="radio" name="jenis" value="sleman" required> UMKM Sleman
        <input type="radio" name="jenis" value="bantul" required> UMKM Bantul
        <br><br>
        <label for="nib">NIB:</label>
        <input type="text" id="nib" name="nib" required>
        <br><br>
        <label for="nama_umkm">Nama UMKM:</label>
        <input type="text" id="nama_umkm" name="nama_umkm" required>
        <br><br>
        <label for="nama_pemilik">Nama Pemilik:</label>
        <input type="text" id="nama_pemilik" name="nama_pemilik" required>
        <br><br>
        <label for="alamat">Alamat:</label>
        <input type="text" id="alamat" name="alamat" required>
        <br><br>
        <label for="no_telepon">No Telepon:</label>
        <input type="text" id="no_telepon" name="no_telepon" required>
        <br><br>
        <label for="tahun_berdiri">Tahun Berdiri:</label>
        <input type="text" id="tahun_berdiri" name="tahun_berdiri" required>
        <br><br>
        <label for="jenis_umkm">Jenis UMKM:</label>
        <input type="text" id="jenis_umkm" name="jenis_umkm" required>
        <br><br>
        <label for="keterangan">Keterangan:</label>
        <input type="text" id="keterangan" name="keterangan" required>
        <br><br>
        <button type="submit" name="submit" class="btn btn-submit">Submit</button>
    </form>
</body>
</html>
