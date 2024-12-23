<?php
include '../connection.php';

// Untuk mengambil data dari tabel barang
$sql = "SELECT kode_barang, nama, stok, harga FROM barang";
$result = $conn->query($sql);

if (!$result) {
    die("Query gagal: " . $conn->error);
}

// Kode untuk EDIT Modal Barang -> agar barangnya bisa muncul saat diedit
if (isset($_GET['kode_barang'])) {
    $kode_barang = $_GET['kode_barang'];

    // Ambil data barang berdasarkan kode_barang
    $query = "SELECT * FROM barang WHERE kode_barang = '$kode_barang'";
    $result = $conn->query($query);
    $barang = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $jumlah = $_POST['stok'];
    $harga = $_POST['harga'];

    // Query untuk menyimpan data pesan ke tabel barang
    $sql_insert = "INSERT INTO barang (nama, stok, harga) VALUES ('$nama', '$jumlah', '$harga')";

    if ($conn->query($sql_insert) === TRUE) {
        $message = "Data Barang berhasil ditambah!";
    } else {
        $message = "Error: " . $conn->error;
    }
}
?> 

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="../style.css" rel="stylesheet">

    <!-- Css to Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <div>
            <a href="index.php">Data Barang</a>
            <a href="pesanbarang.php">Pesan Barang</a>
            <a href="transaksi.php">Transaksi</a>
            <a href="supplier.php">Data Supplier</a>
        </div>
        <a href="logout.php" class="logout-button">Logout</a>
    </div>

    <!-- Bagian Isi/Body -->
    <div class="dashboard-container">
        <h1 class="page-title">Dashboard Kepala Toko</h1>
        <h2 class="mt-5 mb-2">Data Barang</h2>
        <button type="button" class="btn my-2 btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">+ Tambah Data Barang</button>
        <?php if (isset($_GET['pesan'])): ?>
            <div class="alert alert-info">
            <?php
            if ($_GET['pesan'] == 'hapus_berhasil') {
                echo "Barang berhasil dihapus.";
            } elseif ($_GET['pesan'] == 'barang_sedang_diorder') {
                echo "Barang tidak bisa dihapus karena sedang dalam pemesanan.";
            } elseif ($_GET['pesan'] == 'kode_tidak_ada') {
                echo "Kode barang tidak ditemukan.";
            } elseif ($_GET['pesan'] == 'hapus_gagal') {
                echo "Gagal menghapus barang.";
            }
                ?>
            </div>
        <?php endif; ?>
        <!-- Data di Table -->
        <div class="table">
            <table class="table table-striped table-hover">
                <thead class="thead">
                    <tr>
                        <th>Kode Barang</th>
                        <th>Nama</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Memeriksa
                    if ($result->num_rows > 0) {
                        // Menampilkan data
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . $row["kode_barang"] . "</td>
                                    <td>" . $row["nama"] . "</td>
                                    <td>" . $row["stok"] . "</td>
                                    <td>Rp " . number_format($row["harga"], 0, ',', '.') . "</td>
                                     <td>
                                        <a href='barang_edit.php?kode_barang=" . $row["kode_barang"] . "&nama=" . urlencode($row["nama"]) . "&stok=" . $row["stok"] . "&harga=" . $row["harga"] . "' class='btn btn-warning btn-sm'>Edit</a>
                                        <a href='barang_hapus.php?kode_barang=" . $row["kode_barang"] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Apakah Anda yakin ingin menghapus barang ini?\")'>Hapus</a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>Tidak ada data</td></tr>";
                    }
                    $conn->close(); // Menutup koneksi
                    ?>
                </tbody>
            </table>
        </div>


        <!-- Data Modal TAMBAH Barang -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Data Barang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="index.php" method="POST">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Barang</label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>
                            <div class="mb-3">
                                <label for="stok" class="form-label">Stok</label>
                                <input type="number" class="form-control" id="stok" name="stok" required>
                            </div>
                            <div class="mb-3">
                                <label for="harga" class="form-label">Harga</label>
                                <input type="number" class="form-control" id="harga" name="harga" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Link to Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>