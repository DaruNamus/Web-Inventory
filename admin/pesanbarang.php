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

if (isset($_POST['update_status'])) {
    $no_order = $_POST['no_order'];

    // Ambil jumlah dari order yang akan diupdate
    $order_query = "SELECT jumlah, kode_barang FROM orders WHERE no_order = '$no_order'";
    $order_result = $conn->query($order_query);
    $order_data = $order_result->fetch_assoc();

    if ($order_data) {
        $jumlah = $order_data['jumlah'];
        $kode_barang = $order_data['kode_barang'];

        // Update status dan tanggal_selesai
        $update_order_query = "UPDATE orders SET status = 2, tanggal_selesai = CURRENT_TIMESTAMP WHERE no_order = '$no_order'";
        if ($conn->query($update_order_query) === TRUE) {
            // Update stok barang
            $update_stock_query = "UPDATE barang SET stok = stok + $jumlah WHERE kode_barang = '$kode_barang'";
            if ($conn->query($update_stock_query) === TRUE) {
                echo "<script>alert('Status berhasil diperbarui dan stok ditambahkan!'); window.location.href='pesanbarang.php';</script>";
            } else {
                echo "Error updating stock: " . $conn->error;
            }
        } else {
            echo "Error updating order: " . $conn->error;
        }
    }
}

// Proses penghapusan order
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['no_order'])) {
    $no_order = $_GET['no_order'];

    // Query untuk menghapus data order
    $delete_query = "DELETE FROM orders WHERE no_order = ?";
    $delete_stmt = $conn->prepare($delete_query);
    $delete_stmt->bind_param("s", $no_order);

    if ($delete_stmt->execute()) {
        header("Location: pesanbarang.php?pesan=hapus_berhasil");
    } else {
        header("Location: pesanbarang.php?pesan=hapus_gagal");
    }

    $delete_stmt->close();
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
            <a href="index.php">Data Barang</a>
            <a href="pesanbarang.php">Pesan Barang</a>
            <a href="transaksi.php">Transaksi</a>
            <a href="supplier.php">Data Supplier</a>
        </div>
        <a href="logout.php" class="logout-button">Logout</a>
    </div>

    <div class="dashboard-container">
        <h1>History Pesan</h1>
        <div class="button-container">
            <a href="pesanbarang_tambah.php" class="btn my-2 btn-primary">Pesan Barang</a> <!-- Tombol untuk pesan barang -->
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
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result_history->num_rows > 0) {
                        while($row = $result_history->fetch_assoc()) {
                            // Mengubah status berdasarkan nilai
                            if ($row['status'] == 0) {
                                $status = "Sedang Diproses";
                                $disabled = "disabled"; // Nonaktifkan tombol
                            } elseif ($row['status'] == 1) {
                                $status = "Sedang Dikirim";
                                $disabled = ""; // Aktifkan tombol
                            } elseif ($row['status'] == 2) {
                                $status = "Selesai";
                                $disabled = "disabled"; // Nonaktifkan tombol
                            } else {
                                $status = "Status Tidak Dikenal";
                                $disabled = "disabled"; // Nonaktifkan tombol
                            }

                            echo "<tr>
                                    <td>{$row['no_order']}</td>
                                    <td>{$row['tanggal_order']}</td>
                                    <td>{$row['tanggal_selesai']}</td>
                                    <td>{$row['nama_supplier']}</td>
                                    <td>{$row['nama_barang']}</td>
                                    <td>{$row['jumlah']}</td>
                                    <td>{$status}</td>
                                    <td>
                                        <form method='POST' style='display:inline;'>
                                            <input type='hidden' name='no_order' value='{$row['no_order']}'>
                                            <button type='submit' name='update_status' class='btn btn-success' {$disabled}>Tandai Selesai</button>
                                        </form>
                                        <a href='pesanbarang.php?action=delete&no_order={$row['no_order']}' onclick='return confirm(\"Apakah Anda yakin ingin menghapus order ini?\");' class='btn btn-danger'>Hapus</a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>Tidak ada data pesan.</td></tr>";
                    }
                    ?>
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