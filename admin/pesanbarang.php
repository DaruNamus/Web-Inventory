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
    <link href="../style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
        <h1>History Pesan</h1>
        <div class="button-container">
            <a href="pesanbarang_tambah.php">Pesan Barang</a> <!-- Tombol untuk pesan barang -->
        </div>

        <div class="table">
            <table class="table table-striped table-hover">
                <thead class="thead">
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
                            // Mengubah status berdasarkan nilai
                            if ($row['status'] == 0) {
                                $status = "Sedang Diproses";
                            } elseif ($row['status'] == 1) {
                                $status = "Sedang Dikirim";
                            } elseif ($row['status'] == 2) {
                                $status = "Selesai";
                            } else {
                                $status = "Status Tidak Dikenal";
                            }

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
                        echo "<tr><td colspan='7'>Tidak ada data pesan.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Link to Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu 0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>
<?php
$conn->close(); // Menutup koneksi database
?>