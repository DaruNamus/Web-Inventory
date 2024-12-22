<?php
include '../connection.php';

// Untuk mengambil data dari tabel barang
$sql = "SELECT kode_barang, nama, stok, harga FROM barang";
$result = $conn->query($sql);

if (!$result) {
    die("Query gagal: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Supplier</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="../style.css" rel="stylesheet">
</head>
<body>
    <div class="navbar">
        <div>
            <a href="#">Permintaan Restock</a>
            <a href="#">Akun</a>
        </div>
        <a href="logout.php" class="logout-button">Logout</a>
    </div>
    <div class="dashboard-container">
        <h1>Dashboard Supplier</h1>
        <h3 class="">Halo Supplier</h3>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Kode Barang</th>
                        <th>Nama</th>
                        <th>Stok</th>
                        <th>Harga</th>
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
    </div>
</body>
</html>