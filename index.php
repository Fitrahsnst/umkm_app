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

// Mendapatkan daftar jenis usaha yang tersedia
$queryJenisUsaha = "SELECT DISTINCT jenis_umkm FROM umkm";
$resultJenisUsaha = mysqli_query($conn, $queryJenisUsaha);

// Mendapatkan daftar tahun berdiri yang tersedia
$queryTahunBerdiri = "SELECT DISTINCT tahun_berdiri FROM umkm";
$resultTahunBerdiri = mysqli_query($conn, $queryTahunBerdiri);

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

// Mendapatkan tahun berdiri yang dipilih dari parameter URL
$selectedTahunBerdiri = isset($_GET['tahun_berdiri']) ? $_GET['tahun_berdiri'] : '';

// Membuat kondisi tambahan untuk filter berdasarkan jenis usaha dan tahun berdiri
$filterCondition = '';
$filterParams = array();

if (!empty($selectedJenisUsaha)) {
    $filterCondition .= " jenis_umkm = ?";
    $filterParams[] = $selectedJenisUsaha;
}

if (!empty($selectedTahunBerdiri)) {
    if (!empty($filterCondition)) {
        $filterCondition .= " AND";
    }
    $filterCondition .= " tahun_berdiri = ?";
    $filterParams[] = $selectedTahunBerdiri;
}

// Memodifikasi query untuk memasukkan kondisi filter
$query = "SELECT * FROM umkm";
if (!empty($filterCondition)) {
    $query .= " WHERE $filterCondition";
}
$query .= " ORDER BY $column $direction";

$stmt = mysqli_prepare($conn, $query);
if (!empty($filterParams)) {
    mysqli_stmt_bind_param($stmt, str_repeat('s', count($filterParams)), ...$filterParams);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Mengubah arah sorting untuk tombol tautan
$nextDirection = $direction === 'asc' ? 'desc' : 'asc';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Halaman Utama</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <div class="welcome-section">
        <h1>Selamat datang, <?php echo $_SESSION['username']; ?>!</h1>
        <p>Ini adalah halaman utama</p>
    </div>
    <link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
<br> <a href="add.php" class="btn btn-add-user">Daftar UMKM</a><br>
 
    <form method="GET" action="index.php" class="filter-form">
        <label for="jenis_usaha">Filter berdasarkan Jenis Usaha:</label>
        <select id="jenis_usaha" name="jenis_usaha">
            <option value="">Semua</option>
            <?php while ($rowJenisUsaha = mysqli_fetch_assoc($resultJenisUsaha)) { ?>
                <option value="<?php echo $rowJenisUsaha['jenis_umkm']; ?>" <?php echo $selectedJenisUsaha === $rowJenisUsaha['jenis_umkm'] ? 'selected' : ''; ?>><?php echo $rowJenisUsaha['jenis_umkm']; ?></option>
            <?php } ?>
        </select>
        
        <label for="tahun_berdiri">Filter berdasarkan Tahun Berdiri:</label>
        <select id="tahun_berdiri" name="tahun_berdiri">
            <option value="">Semua</option>
            <?php while ($rowTahunBerdiri = mysqli_fetch_assoc($resultTahunBerdiri)) { ?>
                <option value="<?php echo $rowTahunBerdiri['tahun_berdiri']; ?>" <?php echo $selectedTahunBerdiri === $rowTahunBerdiri['tahun_berdiri'] ? 'selected' : ''; ?>><?php echo $rowTahunBerdiri['tahun_berdiri']; ?></option>
            <?php } ?>
        </select>
        
        <button type="submit" class="btn btn-filter">Filter</button>
    </form>

    <h2>Daftar UMKM</h2>

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
        // Menampilkan data umkm dalam tabel
        while ($row = mysqli_fetch_assoc($result)) {
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
    
    <button class="btn btn-logout" onclick="location.href='index.php?logout=true'">Logout</button>

</body>
</html>

<?php
// Menutup koneksi database
mysqli_close($conn);
?>
