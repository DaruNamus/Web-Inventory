<?php
session_start();
include '../connection.php'; // Menghubungkan ke database

$message = ""; // Variable untuk menyimpan pesan

// Inisialisasi keranjang di sesi jika belum ada
if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = [];
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add-to-cart'])) {
    $kode_barang = $_POST['nama_barang'];
    $jumlah = $_POST['jumlah'];

    // Ambil data barang berdasarkan kode_barang
    $query_barang = "SELECT nama, harga, stok FROM barang WHERE kode_barang = '$kode_barang'";
    $result_barang = $conn->query($query_barang);

    if ($result_barang->num_rows > 0) {
        $barang = $result_barang->fetch_assoc();
        $nama_barang = $barang['nama'];
        $harga = $barang['harga'];
        $stok = $barang['stok'];

        if ($stok >= $jumlah) {
            $sub_total = $harga * $jumlah;

            // Tambahkan data ke keranjang (session)
            $_SESSION['keranjang'][] = [
                'kode_barang' => $kode_barang,
                'nama_barang' => $nama_barang,
                'harga' => $harga,
                'jumlah' => $jumlah,
                'sub_total' => $sub_total
            ];

            $message = "Barang berhasil dimasukkan ke keranjang.";
        } else {
            $message = "Stok tidak mencukupi.";
        }
    } else {
        $message = "Barang tidak ditemukan.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_transaction'])) {
    if (!empty($_SESSION['keranjang'])) {
        // Buat ID Nota unik

        // Simpan data transaksi
        foreach ($_SESSION['keranjang'] as $item) {
            $kode_barang = $item['kode_barang'];
            $jumlah = $item['jumlah'];
            $sub_total = $item['sub_total'];
            $nama_barang = $item['nama_barang'];
            $harga = $item['harga'];

            // Kurangi stok barang
            $query_barang = "SELECT stok FROM barang WHERE kode_barang = '$kode_barang'";
            $result_barang = $conn->query($query_barang);
            $barang = $result_barang->fetch_assoc();
            $stok_baru = $barang['stok'] - $jumlah;

            $sql_update_stok = "UPDATE barang SET stok = '$stok_baru' WHERE kode_barang = '$kode_barang'";
            $conn->query($sql_update_stok);

            // Simpan data transaksi ke tabel nota
            $sql_insert = "
                INSERT INTO nota (id_nota, tanggal, nama, harga, jumlah, pendapatan) 
                VALUES ('', NOW(), '$nama_barang', '$harga', '$jumlah', '$sub_total')";
            $conn->query($sql_insert);
        }

        // Bersihkan keranjang
        $_SESSION['keranjang'] = [];
        $message = "Transaksi berhasil disimpan";
    } else {
        $message = "Keranjang kosong, tambahkan barang terlebih dahulu.";
    }
}

// Ambil data barang untuk dropdown
$sql_barang = "SELECT kode_barang, nama, stok, harga FROM barang";
$result_barang = $conn->query($sql_barang);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Transaksi Baru</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="../style.css" rel="stylesheet">

    <!-- Css to Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f0f0;
            margin: 0;
        }
        .container {
            padding: 20px;
        }
        .form-container {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .message {
            color: green;
            font-weight: bold;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        select, input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
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

    <!-- Body -->
    <div class="container">
        <h1 class="fw-bold">Tambah Data Transaksi Baru</h1>
        <div class="form-container">
            <?php if ($message): ?>
                <div class="alert alert-info"><?php echo $message; ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label for="nama_barang" class="form-label">Nama Barang:</label>
                    <select id="nama_barang" name="nama_barang" class="form-select" required>
                        <option value="">Pilih Barang</option>
                        <?php while ($row = $result_barang->fetch_assoc()): ?>
                            <option value="<?php echo $row['kode_barang']; ?>">
                                <?php echo $row['nama'] . " (Stok: " . $row['stok'] . ") | Harga: " . $row['harga']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="jumlah" class="form-label">Jumlah:</label>
                    <input type="number" id="jumlah" name="jumlah" class="form-control" required min="1">
                </div>

                <button class="btn" style="background-color: #4CAF50; color: white;" name="add-to-cart">Masukkan ke Keranjang</button>
                <a href="transaksi.php" class="btn btn-secondary">Kembali</a>
            </form>

            <h2 class="mt-5">Keranjang</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['keranjang'] as $item): ?>
                        <tr>
                            <td><?php echo $item['nama_barang']; ?></td>
                            <td>Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?></td>
                            <td><?php echo $item['jumlah']; ?></td>
                            <td>Rp <?php echo number_format($item['sub_total'], 0, ',', '.'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <form method="POST">
                <button type="submit" name="save_transaction" class="btn btn-primary">Simpan Transaksi</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
$conn->close(); // Menutup koneksi database
?>