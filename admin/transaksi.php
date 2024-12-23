<?php
include '../connection.php'; // Menghubungkan ke database

// Cek parameter pencarian
$search_query = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

// Query utama untuk transaksi
$sql = "
    SELECT 
        nota.id_nota, 
        nota.tanggal, 
        nota.nama AS nama_barang, 
        nota.harga, 
        nota.jumlah, 
        (nota.harga * nota.jumlah) AS sub_total
    FROM nota
    WHERE nota.id_nota LIKE '%$search_query%' 
       OR nota.nama LIKE '%$search_query%'
    ORDER BY nota.id_nota, nota.tanggal DESC
";

$result = $conn->query($sql);

// Query untuk total pendapatan
$totalPendapatanQuery = "
    SELECT SUM(nota.harga * nota.jumlah) AS total_pendapatan
    FROM nota
";

$totalPendapatanResult = $conn->query($totalPendapatanQuery);
$totalPendapatanRow = $totalPendapatanResult->fetch_assoc();
$totalPendapatan = $totalPendapatanRow['total_pendapatan'] ?? 0;

?> 

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="../style.css" rel="stylesheet">

    <!-- Css to Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
        .search-container {
            margin-bottom: 20px;
            display: flex;
            justify-content: flex-end; /* Atur posisi elemen ke kiri */
            align-items: center; /* Menjaga agar tombol dan input berada pada level yang sama */
        }

        .search-form {
            display: flex; /* Membuat form menggunakan flexbox */
            justify-content: flex-start; /* Menjaga agar input dan tombol berada pada satu baris */
        }

        .search-bar {
            width: 100%;
            max-width: 400px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            margin-right: 10px; /* Spasi antara input dan tombol */
        }

        .search-btn {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .search-btn:hover {
            background-color: #0056b3;
        }
    </style>
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
        <h1 class="page-title">Transaksi</h1>
        <h2 class="mt-5 mb-2">Data Transaksi</h2>
        <a href="transaksi_tambah.php" class="btn my-2 btn-primary">+ Tambah Transaksi</a>
        
        <!-- Search Bar -->
        <div class="search-container">
            <form action="" method="GET" class="search-form">
                <input type="text" name="search" class="search-bar" placeholder="Cari nama barang..." value="<?php echo htmlspecialchars($search_query); ?>">
                <button type="submit" class="search-btn">Cari</button>
            </form>
        </div>

        <!-- Data di Table -->
        <div class="table">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID Transaksi</th>
                        <th>Tanggal</th>
                        <th>Nama Barang</th>
                        <th>Harga</th>
                        <th>Jumlah / Qty</th>
                        <th>Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . $row["id_nota"] . "</td>
                                    <td>" . $row["tanggal"] . "</td>
                                    <td>" . $row["nama_barang"] . "</td>
                                    <td>Rp " . number_format($row["harga"], 0, ',', '.') . "</td>
                                    <td>" . $row["jumlah"] . "</td>
                                    <td>Rp " . number_format($row["sub_total"], 0, ',', '.') . "</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>Tidak ada data</td></tr>";
                    }
                    ?>
                    <tr>
                        <td colspan="5"><strong>Total Pendapatan:</strong></td>
                        <td>Rp <?php echo number_format($totalPendapatan, 0, ',', '.'); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Link to Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>

<?php
$conn->close(); // Menutup koneksi database
?>