<?php
// Mengimpor file konfigurasi
require_once 'config.php';
session_start();

// Cek jika pengguna belum login, alihkan ke halaman login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Proses logout jika tombol logout diklik
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

// Mendapatkan daftar jenis usaha yang tersedia dari tabel umkm_sleman
$queryJenisUsahaSleman = "SELECT DISTINCT jenis_umkm FROM umkm_sleman";
$resultJenisUsahaSleman = mysqli_query($conn, $queryJenisUsahaSleman);

// Mendapatkan daftar keterangan yang tersedia dari tabel umkm_sleman
$queryKeteranganSleman = "SELECT DISTINCT keterangan FROM umkm_sleman";
$resultKeteranganSleman = mysqli_query($conn, $queryKeteranganSleman);

// Mendapatkan daftar jenis usaha yang tersedia dari tabel umkm_bantul
$queryJenisUsahaBantul = "SELECT DISTINCT jenis_umkm FROM umkm_bantul";
$resultJenisUsahaBantul = mysqli_query($conn, $queryJenisUsahaBantul);

// Mendapatkan daftar keterangan yang tersedia dari tabel umkm_bantul
$queryKeteranganBantul = "SELECT DISTINCT keterangan FROM umkm_bantul";
$resultKeteranganBantul = mysqli_query($conn, $queryKeteranganBantul);

// Mengatur kolom dan arah sorting default
$column = isset($_GET['column']) ? $_GET['column'] : 'nib';
$direction = isset($_GET['direction']) ? $_GET['direction'] : 'asc';

// Memvalidasi kolom sorting
$validColumns = ['nib', 'nama_umkm', 'nama_pemilik', 'alamat', 'no_telepon', 'tahun_berdiri', 'jenis_umkm', 'keterangan'];
if (!in_array($column, $validColumns)) {
    $column = 'nib'; // Kolom default jika kolom yang dimasukkan tidak valid
}

// Mendapatkan jenis usaha yang dipilih dari parameter URL
$selectedJenisUsaha = isset($_GET['jenis_usaha']) ? $_GET['jenis_usaha'] : '';

// Mendapatkan keterangan yang dipilih dari parameter URL
$selectedKeterangan = isset($_GET['keterangan']) ? $_GET['keterangan'] : '';

// Membuat kondisi tambahan untuk filter berdasarkan jenis usaha dan keterangan
$filterCondition = '';
$filterParams = array();

if (!empty($selectedJenisUsaha)) {
    $filterCondition .= " jenis_umkm = ?";
    $filterParams[] = $selectedJenisUsaha;
}

if (!empty($selectedKeterangan)) {
    if (!empty($filterCondition)) {
        $filterCondition .= " AND";
    }
    $filterCondition .= " keterangan = ?";
    $filterParams[] = $selectedKeterangan;
}

// Memodifikasi query untuk memasukkan kondisi filter untuk UMKM Sleman
$querySleman = "SELECT * FROM umkm_sleman";
if (!empty($filterCondition)) {
    $querySleman .= " WHERE $filterCondition";
}
$querySleman .= " ORDER BY $column $direction";

$stmtSleman = mysqli_prepare($conn, $querySleman);
if (!empty($filterParams)) {
    mysqli_stmt_bind_param($stmtSleman, str_repeat('s', count($filterParams)), ...$filterParams);
}
mysqli_stmt_execute($stmtSleman);
$resultSleman = mysqli_stmt_get_result($stmtSleman);

// Memodifikasi query untuk memasukkan kondisi filter untuk UMKM Bantul
$queryBantul = "SELECT * FROM umkm_bantul";
if (!empty($filterCondition)) {
    $queryBantul .= " WHERE $filterCondition";
}
$queryBantul .= " ORDER BY $column $direction";

$stmtBantul = mysqli_prepare($conn, $queryBantul);
if (!empty($filterParams)) {
    mysqli_stmt_bind_param($stmtBantul, str_repeat('s', count($filterParams)), ...$filterParams);
}
mysqli_stmt_execute($stmtBantul);
$resultBantul = mysqli_stmt_get_result($stmtBantul);

// Mengubah arah sorting untuk tombol tautan
$nextDirection = $direction === 'asc' ? 'desc' : 'asc';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Halaman Utama</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="welcome-section">
        <h1>Selamat datang, <?php echo $_SESSION['username']; ?>!</h1>
        <p>Ini adalah halaman utama</p>
    </div>

    <div>

    <br><a href="add.php" class="btn btn-add">Tambah Data</a>
    

        <form method="GET" action="index.php" class="filter-form">
            <label for="jenis_usaha_sleman">Filter berdasarkan Jenis Usaha:</label>
            <select id="jenis_usaha_sleman" name="jenis_usaha">
                <option value="">Semua</option>
                <?php while ($rowJenisUsaha = mysqli_fetch_assoc($resultJenisUsahaSleman)) { ?>
                    <option value="<?php echo $rowJenisUsaha['jenis_umkm']; ?>" <?php echo $selectedJenisUsaha === $rowJenisUsaha['jenis_umkm'] ? 'selected' : ''; ?>><?php echo $rowJenisUsaha['jenis_umkm']; ?></option>
                <?php } ?>
            </select>

            <label for="keterangan_sleman">Filter berdasarkan Keterangan:</label>
            <select id="keterangan_sleman" name="keterangan">
                <option value="">Semua</option>
                <?php while ($rowKeterangan = mysqli_fetch_assoc($resultKeteranganSleman)) { ?>
                    <option value="<?php echo $rowKeterangan['keterangan']; ?>" <?php echo $selectedKeterangan === $rowKeterangan['keterangan'] ? 'selected' : ''; ?>><?php echo $rowKeterangan['keterangan']; ?></option>
                <?php } ?>
            </select>

            <button type="submit" class="btn btn-filter">Filter</button>
        </form>

        <h2>UMKM Kabupaten Sleman</h2>

        <table>
            <tr>
                <th>NIB</th>
                <th>Nama UMKM</th>
                <th>Nama Pemilik</th>
                <th>Alamat</th>
                <th>No Telepon</th>
                <th>Tahun Berdiri</th>
                <th>Jenis UMKM</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
            <?php
            // Menampilkan data umkm Sleman dalam tabel
            while ($row = mysqli_fetch_assoc($resultSleman)) {
                echo "<tr>";
                echo "<td>".$row['nib']."</td>";
                echo "<td>".$row['nama_umkm']."</td>";
                echo "<td>".$row['nama_pemilik']."</td>";
                echo "<td>".$row['alamat']."</td>";
                echo "<td>".$row['no_telepon']."</td>";
                echo "<td>".$row['tahun_berdiri']."</td>";
                echo "<td>".$row['jenis_umkm']."</td>";
                echo "<td>".$row['keterangan']."</td>";
                echo "<td><a href='edit.php?id=".$row['nib']."'>Edit</a> | <a href='delete.php?id=".$row['nib']."'>Delete</a></td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>

    <div>
        <h2>UMKM Kabupaten Bantul</h2>

        <table>
            <tr>
                <th>NIB</th>
                <th>Nama UMKM</th>
                <th>Nama Pemilik</th>
                <th>Alamat</th>
                <th>No Telepon</th>
                <th>Tahun Berdiri</th>
                <th>Jenis UMKM</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
            <?php
            // Menampilkan data umkm Bantul dalam tabel
            while ($row = mysqli_fetch_assoc($resultBantul)) {
                echo "<tr>";
                echo "<td>".$row['nib']."</td>";
                echo "<td>".$row['nama_umkm']."</td>";
                echo "<td>".$row['nama_pemilik']."</td>";
                echo "<td>".$row['alamat']."</td>";
                echo "<td>".$row['no_telepon']."</td>";
                echo "<td>".$row['tahun_berdiri']."</td>";
                echo "<td>".$row['jenis_umkm']."</td>";
                echo "<td>".$row['keterangan']."</td>";
                echo "<td><a href='edit.php?id=".$row['nib']."'>Edit</a> | <a href='delete.php?id=".$row['nib']."'>Delete</a></td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>

    <div class="logout-section">
        <a href="index.php?logout=true" class="btn btn-logout">Logout</a>
    </div>
</body>
</html>
