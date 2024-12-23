<?php
session_start(); // Memulai sesi
include '../connection.php'; // Menghubungkan ke database

// Memeriksa apakah pengguna sudah login
if (!isset($_SESSION['kode_supplier'])) {
    header("Location: ../index.php"); // Arahkan ke halaman login jika belum login
    exit();
}

// Ambil kode_supplier dari sesi
$kode_supplier = $_SESSION['kode_supplier'];

// Query untuk mengambil history pesan dengan JOIN dan filter berdasarkan kode_supplier
$sql_history = "
    SELECT ob.*, b.nama AS nama_barang, s.nama_supplier 
    FROM orders AS ob 
    JOIN barang AS b ON ob.kode_barang = b.kode_barang 
    JOIN supplier AS s ON ob.kode_supplier = s.kode_supplier 
    WHERE ob.kode_supplier = '$kode_supplier' 
    ORDER BY ob.tanggal_order DESC";
$result_history = $conn->query($sql_history);

// Memeriksa apakah query berhasil
if (!$result_history) {
    die("Query gagal: " . $conn->error);
}

// Proses untuk mengubah status
if (isset($_POST['update_status'])) {
    $no_order = $_POST['no_order'];
    $update_query = "UPDATE orders SET status = 1 WHERE no_order = '$no_order' AND kode_supplier = '$kode_supplier'";
    if ($conn->query($update_query) === TRUE) {
        echo "<script>alert('Status berhasil diperbarui!'); window.location.href='index.php';</script>";
    } else {
        echo "Error updating record: " . $conn->error;
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="navbar">
        <div>
            <a href="index.php">Permintaan Restock</a>
            <a href="akun.php">Akun</a>
        </div>
        <div class="user-info">
            <span>Welcome, <?php echo $_SESSION['username']; ?></span> <!-- Menampilkan nama pengguna -->
            <form method="POST" action="logout.php" style="display:inline;">
                <button type="submit" class="logout-button">Log Out</button>
            </form>
        </div>
    </div>
    <div class="dashboard-container">
        <h1>History Pesan</h1>
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
                        <th>Action</th> <!-- Kolom Action -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result_history->num_rows > 0) {
                        while($row = $result_history->fetch_assoc()) {
                            // Mengubah status berdasarkan nilai
                            if ($row['status'] == 0) {
                                $status = "Sedang Diproses";
                                $disabled = ""; // Aktifkan tombol
                            } elseif ($row['status'] == 1) {
                                $status = "Sedang Dikirim";
                                $disabled = "disabled"; // Nonaktifkan tombol
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
                                            <button type='submit' name='update_status' class='btn btn-success' {$disabled}>Kirim</button>
                                        </form>
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