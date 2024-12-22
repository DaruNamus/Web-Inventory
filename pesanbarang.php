<?php
include 'php/connection.php'; // Menghubungkan ke database

$message = ""; // Variable untuk menyimpan pesan

// Memproses form jika ada pengiriman data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kode_supplier = $_POST['kode_supplier']; // Mengganti nama variabel
    $kode_barang = $_POST['kode_barang'];
    $tanggal_order = date('Y-m-d H:i:s'); // Mengambil tanggal saat ini

    // Query untuk menyimpan data pesan ke tabel order_barang
    $sql_insert = "INSERT INTO order_barang (kode_supplier, kode_barang, tanggal_order, status) VALUES ('$kode_supplier', '$kode_barang', '$tanggal_order', '0')";

    if ($conn->query($sql_insert) === TRUE) {
        $message = "Pesan berhasil dibuat!";
    } else {
        $message = "Error: " . $conn->error;
    }
}

// Query untuk mengambil history pesan dengan JOIN
$sql_history = "
    SELECT ob.*, b.nama AS nama_barang, s.nama_supplier 
    FROM order_barang ob 
    JOIN barang b ON ob.kode_barang = b.kode_barang 
    JOIN supplier s ON ob.kode_supplier = s.kode_supplier 
    ORDER BY ob.tanggal_order DESC";
$result_history = $conn->query($sql_history);

// Memeriksa apakah query berhasil
if (!$result_history) {
    die("Query gagal: " . $conn->error);
}

// Query untuk mengambil data supplier
$sql_supplier = "SELECT kode_supplier, nama_supplier FROM supplier";
$result_supplier = $conn->query($sql_supplier);

// Memeriksa apakah query berhasil
if (!$result_supplier) {
    die("Query gagal: " . $conn->error);
}

// Query untuk mengambil data barang
$sql_barang = "SELECT kode_barang FROM barang";
$result_barang = $conn->query($sql_barang);

// Memeriksa apakah query berhasil
if (!$result_barang) {
    die("Query gagal: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Barang</title>
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
        .form-container {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .table-container {
            margin-top: 20px;
            background-color: #fff;
            border-radius: 8 px;
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
        .message {
            color: green;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div>
            <a href="lihatbarang.php">Lihat Barang</a>
            <a href="pesan_barang.php">Pesan Barang</a>
            <a href="#">Nota</a>
        </div>
        <button class="logout-button">Log Out</button>
    </div>
    <div class="dashboard-container">
        <h1>Pesan Barang</h1>
        
        <div class="form-container">
            <h2>Buat Pesan</h2>
            <?php if ($message): ?>
                <div class="message"><?php echo $message; ?></div>
            <?php endif; ?>
            <form action="" method="POST">
                <label for="kode_supplier">Kode Supplier:</label>
                <select id="kode_supplier" name="kode_supplier" required>
                    <?php while ($row = $result_supplier->fetch_assoc()): ?>
                        <option value="<?php echo $row['kode_supplier']; ?>"><?php echo $row['nama_supplier']; ?></option>
                    <?php endwhile; ?>
                </select>
                <br><br>
                <label for="kode_barang">Kode Barang:</label>
                <select id="kode_barang" name="kode_barang" required>
                    <?php while ($row = $result_barang->fetch_assoc()): ?>
                        <option value="<?php echo $row['kode_barang']; ?>"><?php echo $row['kode_barang']; ?></option>
                    <?php endwhile; ?>
                </select>
                <br><br>
                <input type="submit" value="Kirim Pesan">
            </form>
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