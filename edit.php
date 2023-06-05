<?php
// Mengimpor file konfigurasi
require_once 'config.php';
session_start();

// Cek jika pengguna belum login, alihkan ke halaman login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Memastikan parameter ID ada dan bukan kosong
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk mendapatkan data UMKM berdasarkan ID
    $query = "SELECT * FROM umkm_sleman WHERE nib = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $query = "SELECT * FROM umkm_bantul WHERE nib = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Memeriksa apakah data UMKM ditemukan
    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        // Menampilkan form edit
        ?>

        <!DOCTYPE html>
        <html>
        <head>
            <title>Edit Data UMKM</title>
            <link rel="stylesheet" type="text/css" href="style.css">
        </head>
        <body>
            <h2>Edit Data UMKM</h2>
            <form method="POST" action="update.php">
                <input type="hidden" name="id" value="<?php echo $row['nib']; ?>">
                <label for="nama_umkm">Nama UMKM:</label>
                <input type="text" id="nama_umkm" name="nama_umkm" value="<?php echo $row['nama_umkm']; ?>" required><br>

                <label for="nama_pemilik">Nama Pemilik:</label>
                <input type="text" id="nama_pemilik" name="nama_pemilik" value="<?php echo $row['nama_pemilik']; ?>" required><br>

                <label for="alamat">Alamat:</label>
                <input type="text" id="alamat" name="alamat" value="<?php echo $row['alamat']; ?>" required><br>

                <label for="no_telepon">No Telepon:</label>
                <input type="text" id="no_telepon" name="no_telepon" value="<?php echo $row['no_telepon']; ?>" required><br>

                <label for="tahun_berdiri">Tahun Berdiri:</label>
                <input type="text" id="tahun_berdiri" name="tahun_berdiri" value="<?php echo $row['tahun_berdiri']; ?>" required><br>

                <label for="jenis_umkm">Jenis UMKM:</label>
                <input type="text" id="jenis_umkm" name="jenis_umkm" value="<?php echo $row['jenis_umkm']; ?>" required><br>

                <label for="keterangan">Keterangan:</label>
                <input type="text" id="keterangan" name="keterangan" value="<?php echo $row['keterangan']; ?>" required><br>

                <button type="submit" class="btn btn-update">Update</button>
            </form>
        </body>
        </html>

        <?php
    } else {
        echo "Data UMKM tidak ditemukan.";
    }
} else {
    echo "ID tidak valid.";
}
?>
