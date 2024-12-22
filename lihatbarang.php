<?php
include 'php/connection.php'; // Menghubungkan ke database

// Query untuk mengambil data dari tabel barang
$sql = "SELECT kode_barang, nama, stok, harga FROM barang";
$result = $conn->query($sql);

// Memeriksa apakah query berhasil
if (!$result) {
    die("Query gagal: " . $conn->error);
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
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f0f0;
            margin: 0;
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #007bff;
            color: white;
            padding: 15px 20px;
            border-radius: 0 0 8px 8px;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            font-weight: 700;
            padding: 10px 20px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        .navbar a:hover {
            background-color: #0056b3;
        }
        .logout-button {
            background-color: #dc3545; /* Merah untuk tombol logout */
            border: none;
            border-radius: 4px;
            color: white;
            font-weight: 700;
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .logout-button:hover {
            background-color: #c82333; /* Merah lebih gelap saat hover */
        }
        .dashboard-container {
            padding: 20px;
        }
        .table-container {
            margin-top: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ccc;
        }
        th {
            background-color: #f2f2f2;
            font-weight: 700;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div>
            <a href="#">Lihat Barang</a>
            <a href="pesanbarang.php">Pesan Barang</a>
            <a href="#">Nota</a>
        </div>
        <button class="logout-button">Log Out</button>
    </div>
    <div class="dashboard-container">
        <h1>Dashboard Kepala Toko</h1>
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
                    // Memeriksa apakah ada hasil
                    if ($result->num_rows > 0) {
                        // Menampilkan data setiap baris
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . $row["kode_barang"] . "</td>
                                    <td>" . $row["nama"] . "</td>
                                    <td <td>" . $row["stok"] . "</td>
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