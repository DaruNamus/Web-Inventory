<?php
// Koneksi ke database
include '../connection.php'; // pastikan sudah terkoneksi ke database

// Ambil kode_barang dari query string
if (isset($_GET['kode_supplier'])) {
    $kode_supplier = $_GET['kode_supplier'];

    // Ambil data barang berdasarkan kode_barang
    $query = "SELECT * FROM supplier WHERE kode_supplier = '$kode_supplier'";
    $result = $conn->query($query);

    // Periksa apakah query mengembalikan hasil
    if ($result->num_rows > 0) {
        $supplier = $result->fetch_assoc();
    } else {
        // Jika tidak ada data, tampilkan pesan error atau redirect
        echo "Data Supplier tidak ditemukan!";
        exit; // hentikan eksekusi jika barang tidak ditemukan
    }
} else {
    echo "Kode Supplier tidak diberikan!";
    exit; // hentikan eksekusi jika kode_barang tidak ada
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Supplier</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="../style.css" rel="stylesheet">

    <!-- Css to Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/css/select2.min.css" rel="stylesheet" />

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
        searchable-select {
            width: 100%;
            max-width: 400px;
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

    <!-- Modal Edit Data Barang -->
    <div class="container mt-4">
        <h2 class="text-center mb-4 fw-bold">Edit Data Supplier</h2>

        <form action="supplier_update.php" method="POST">
            <!-- Input Hidden untuk kode_barang -->
            <input type="hidden" name="kode_supplier" value="<?php echo $supplier['kode_supplier']; ?>">

            <div class="mb-3">
                <label for="nama_supplier" class="form-label">Nama Supplier</label>
                <input type="text" class="form-control" id="nama_supplier" name="nama_supplier" value="<?php echo $supplier['nama_supplier']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $supplier['alamat']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="no_telp" class="form-label">No. Telp</label>
                <input type="number" class="form-control" id="no_telp" name="no_telp" value="<?php echo $supplier['no_telp']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo $supplier['username']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="text" class="form-control" id="password" name="password" value="<?php echo $supplier['password']; ?>" required>
            </div>

            <div class="d-flex justify-content-between">
                <a href="supplier.php" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>

    <!-- Link to Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>
