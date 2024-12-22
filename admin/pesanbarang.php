<?php
include '../connection.php'; // Menghubungkan ke database

// Query untuk mengambil history pesan dengan JOIN
$sql_history = "
    SELECT ob.*, b.nama AS nama_barang, s.nama_supplier 
    FROM orders AS ob 
    JOIN barang AS b ON ob.kode_barang = b.kode_barang 
    JOIN supplier AS s ON ob.kode_supplier = s.kode_supplier 
    ORDER BY ob.tanggal_order DESC";
$result_history = $conn->query($sql_history);

// Memeriksa apakah query berhasil
if (!$result_history) {
    die("Query gagal: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History Pesan Barang</title>
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
        .button-container {
            margin-bottom: 20px;
        }
        .button-container a {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .button-container a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div>
            <a href="index.php">Lihat Barang</a>
            <a href="pesanbarang.php">Pesan Barang</a>
            <a href="#">Nota</a>
        </div>
        <button class="logout-button">Log Out</button>
    </div>
    <div class="dashboard-container">
        <h1>Pesan Barang</h1>

        <div class="button-container">
            <a href="pesanbarang_tambah.php">Pesan Barang</a> <!-- Tombol untuk pesan barang -->
        </div>

        <div class="table-container">
            <h2>History Pesan</h2>
            <table>
                <thead>
                    <tr>
                        <th>No Order</th>
                        <th>Tanggal Order</th>
                        <th>Tanggal Diterima</th>
                        <th>Nama Supplier</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result_history->num_rows > 0) {
                        while($row = $result_history->fetch_assoc()) {
                            $status = $row['status'] == 0 ? "Sedang Diproses" : "Selesai";
                            echo "<tr>
                                    <td>{$row['no_order']}</td>
                                    <td>{$row['tanggal_order']}</td>
                                    <td>{$row['tanggal_selesai']}</td>
                                    <td>{$row['nama_supplier']}</td>
                                    <td>{$row['nama_barang']}</td>
                                    <td>{$row['jumlah']}</td>
                                    <td>{$status}</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>Tidak ada data pesan.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
<?php
$conn->close(); // Menutup koneksi database
?>