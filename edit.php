<?php
// Mengimpor file konfigurasi
require_once 'config.php';
session_start();

// Cek jika pengguna belum login, alihkan ke halaman login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Memastikan parameter 'id' ada dan bukan kosong
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Parameter 'id' tidak valid";
    exit;
}

$id = $_GET['id'];

// Memastikan id merupakan angka
if (!is_numeric($id)) {
    echo "ID tidak valid";
    exit;
}

// Mendapatkan data UMKM berdasarkan ID
$query = "SELECT * FROM umkm WHERE nib = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Memastikan data UMKM dengan ID tersebut ada
if (mysqli_num_rows($result) === 0) {
    echo "Data UMKM dengan ID tersebut tidak ditemukan";
    exit;
}

$row = mysqli_fetch_assoc($result);

// Memproses pembaruan data jika tombol "Update" diklik
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nib = $_POST['nib'];
    $nama_umkm = $_POST['nama_umkm'];
    $nama_pemilik = $_POST['nama_pemilik'];
    $alamat = $_POST['alamat'];
    $no_telepon = $_POST['no_telepon'];
    $tahun_berdiri = $_POST['tahun_berdiri'];
    $jenis_umkm = $_POST['jenis_umkm'];
    $keterangan = $_POST['keterangan'];

    // Memperbarui data UMKM dalam database
    $query = "UPDATE umkm SET nib=?, nama_umkm=?, nama_pemilik=?, alamat=?, no_telepon=?, tahun_berdiri=?, jenis_umkm=?, keterangan=? WHERE nib=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sssssssss", $nib, $nama_umkm, $nama_pemilik, $alamat, $no_telepon, $tahun_berdiri, $jenis_umkm, $keterangan, $id);
    mysqli_stmt_execute($stmt);

    // Mengalihkan kembali ke halaman utama setelah pembaruan berhasil
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit UMKM</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h2>Edit UMKM</h2>
    <form method="POST" action="edit.php?id=<?php echo $id; ?>" class="edit-form">
        <label for="nib">NIB:</label>
        <input type="text" id="nib" name="nib" value="<?php echo $row['nib']; ?>" required>
        
        <label for="nama_umkm">Nama UMKM:</label>
        <input type="text" id="nama_umkm" name="nama_umkm" value="<?php echo $row['nama_umkm']; ?>" required>
        
        <label for="nama_pemilik">Nama Pemilik:</label>
        <input type="text" id="nama_pemilik" name="nama_pemilik" value="<?php echo $row['nama_pemilik']; ?>" required>
        
        <label for="alamat">Alamat:</label>
        <input type="text" id="alamat" name="alamat" value="<?php echo $row['alamat']; ?>" required>
        
        <label for="no_telepon">No Telepon:</label>
        <input type="text" id="no_telepon" name="no_telepon" value="<?php echo $row['no_telepon']; ?>" required>
        
        <label for="tahun_berdiri">Tahun Berdiri:</label>
        <input type="text" id="tahun_berdiri" name="tahun_berdiri" value="<?php echo $row['tahun_berdiri']; ?>" required>
        
        <label for="jenis_umkm">Jenis UMKM:</label>
        <input type="text" id="jenis_umkm" name="jenis_umkm" value="<?php echo $row['jenis_umkm']; ?>" required><br>
        
        <label for="keterangan">Keterangan:</label>
        <input type="text" id="keterangan" name="keterangan" value="<?php echo $row['keterangan']; ?>" required><br>
        

        <br><button type="submit" class="btn btn-update">Update</button><br>

    </form>

    
</body>
</html>

<?php
// Menutup koneksi database
mysqli_close($conn);
?>
