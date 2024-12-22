<?php
include '../connection.php'; // Menghubungkan ke database

$message = ""; // Variable untuk menyimpan pesan

// Memproses form jika ada pengiriman data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kode_barang = $_POST['kode_barang'];
    $kode_supplier = $_POST['kode_supplier'];
    $jumlah = $_POST['jumlah'];
    $tanggal_order = date('Y-m-d H:i:s'); // Mengambil tanggal saat ini

    // Query untuk menyimpan data pesan ke tabel order_barang
    $sql_insert = "INSERT INTO orders (kode_supplier, kode_barang, tanggal_order, status, jumlah) VALUES ('$kode_supplier', '$kode_barang', '$tanggal_order', '0', '$jumlah')";

    if ($conn->query($sql_insert) === TRUE) {
        $message = "Pesanan berhasil dibuat!";
    } else {
        $message = "Error: " . $conn->error;
    }
}

// Query untuk mengambil data barang
$sql_barang = "SELECT kode_barang, nama FROM barang";
$result_barang = $conn->query($sql_barang);

// Memeriksa apakah query berhasil
if (!$result_barang) {
    die("Query gagal: " . $conn->error);
}

// Query untuk mengambil data supplier
$sql_supplier = "SELECT kode_supplier, nama_supplier FROM supplier";
$result_supplier = $conn->query($sql_supplier);

// Memeriksa apakah query berhasil
if (!$result_supplier) {
    die("Query gagal: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Pesanan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
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
    <div class="container">
        <h1>Buat Pesanan</h1>
        <div class="form-container">
            <?php if ($message): ?>
                <div class="message"><?php echo $message; ?></div>
            <?php endif; ?>
            <form action="" method="POST">
                <label for="kode_barang">Nama Barang:</label>
                <select id="kode_barang" name="kode_barang" required>
                    <option value="">Pilih Nama Barang</option>
                    <?php while ($row = $result_barang->fetch_assoc()): ?>
                        <option value="<?php echo $row['kode_barang']; ?>"><?php echo $row['nama']; ?></option>
                    <?php endwhile; ?>
                </select>

                <label for="jumlah">Jumlah:</label>
                <input type="number" id="jumlah" name="jumlah" required min="1">

                <label for="kode_supplier">Nama Supplier:</label>
                <select id="kode_supplier" name="kode_supplier" required>
                    <option value="">Pilih Nama Supplier</option>
                    <?php while ($row = $result_supplier->fetch_assoc()): ?>
                        <option value="<?php echo $row['kode_supplier']; ?>"><?php echo $row['nama_supplier']; ?></option>
                    <?php endwhile; ?>
                </select>

                <input type="submit" value="Pesan Barang">
            </form>
        </div>
    </div>
</body>
</html>
<?php
$conn->close(); // Menutup koneksi database
?>