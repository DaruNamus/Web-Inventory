<?php
include '../connection.php'; // Menghubungkan ke database

$message = ""; // Variable untuk menyimpan pesan

// Memproses form jika ada pengiriman data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $spp = $_POST['nama_supplier'];
    $alamat = $_POST['alamat'];
    $telp = $_POST['telp'];
    $username = $_POST['username'];
    $password = $_POST['password']; 

    // Query untuk menyimpan data ke tabel supplier
    $sql_insert = "INSERT INTO supplier (nama_supplier, alamat, no_telp, username, password) VALUES ('$spp', '$alamat', '$telp', '$username', '$password')";

    if ($conn->query($sql_insert) === TRUE) {
        $message = "Data Supplier berhasil ditambah!";
    } else {
        $message = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Supplier</title>
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
        input[type="text"], input[type="number"] {
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
            <a href="index.php">Data Barang (Master)</a>
            <a href="pesanbarang.php">Pesan Barang</a>
            <a href="transaksi.php">Transaksi</a>
            <a href="supplier.php">Data Supplier (Master)</a>
        </div>
        <a href="logout.php" class="logout-button">Logout</a>
    </div>

    <!-- Body -->
    <div class="container">
        <h1 class="fw-bold">Tambah Data Master Supplier</h1>
        <div class="form-container">
            <?php if ($message): ?>
                <div class="message"><?php echo $message; ?></div>
            <?php endif; ?>
            <form action="" method="POST">
                <label for="nama_supplier">Nama Supplier:</label>
                <input class="form-control" type="text" id="nama_supplier" name="nama_supplier" required>

                <label for="alamat">Alamat:</label>
                <input class="form-control" type="text" id="alamat" name="alamat" required>
                
                <label for="telp">No. Telp:</label>
                <input class="form-control" type="number" id="telp" name="telp" required>

                <label for="username">Username:</label>
                <input class="form-control" type="text" id="username" name="username" required>

                <label for="password">Password:</label>
                <input class="form-control" type="text" id="password" name="password" required>

                <div class="button-bawah my-2">
                    <input type="submit" value="Tambah Data" class="btn btn-primary ">
                    <a href="supplier.php" class="btn btn-secondary">Kembali</a>
                </div>
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