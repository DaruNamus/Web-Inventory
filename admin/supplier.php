<?php
include '../connection.php';

// Kode untuk Pencarian
$search_query = isset($_GET['search']) ? $_GET['search'] : '';

// Query untuk mengambil data supplier dengan pencarian berdasarkan kode_supplier atau nama_supplier
$sql = "SELECT * FROM supplier WHERE kode_supplier LIKE '%$search_query%' OR nama_supplier LIKE '%$search_query%' OR alamat LIKE '%$search_query%' OR username LIKE '%$search_query%' OR no_telp LIKE '%$search_query%' OR password LIKE '%$search_query%'";
$result = $conn->query($sql);

if (!$result) {
    die("Query gagal: " . $conn->error);
}

// Kode untuk EDIT Modal Supplier (Bukan barang)
// Cek jika ada kode_supplier untuk edit
if (isset($_GET['kode_supplier'])) {
    $kode_supplier = $_GET['kode_supplier'];

    // Ambil data supplier berdasarkan kode_supplier
    $query = "SELECT * FROM supplier WHERE kode_supplier = '$kode_supplier'";
    $result = $conn->query($query);
    $supplier = $result->fetch_assoc();
}
?> 

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Akun Supplier</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="../style.css" rel="stylesheet">

    <!-- Css to Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
        .search-container {
            margin-bottom: 20px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        .search-form {
            display: flex;
        }

        .search-bar {
            width: 100%;
            max-width: 400px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            margin-right: 10px;
        }

        .search-btn {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .search-btn:hover {
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

    <!-- Bagian Isi/Body -->
    <div class="dashboard-container">
        <h1 class="page-title">Data Akun Supplier</h1>
        <h2 class="mt-5 mb-2">Data Supplier</h2>
        <a href="supplier_tambah.php" class="btn my-2 btn-primary">+ Tambah Data</a>
        
        <!-- Search Bar -->
        <div class="search-container">
            <form action="" method="GET" class="search-form">
                <input type="text" name="search" class="search-bar" placeholder="Cari nama supplier..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                <button type="submit" class="search-btn">Cari</button>
            </form>
        </div>

        <!-- Data di Table -->
        <div class="table">
            <table class="table table-striped table-hover">
                <thead class="thead">
                    <tr>
                        <th>Kode Supplier</th>
                        <th>Nama Supplier</th>
                        <th>Alamat</th>
                        <th>No Telp.</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . $row["kode_supplier"] . "</td>
                                    <td>" . $row["nama_supplier"] . "</td>
                                    <td>" . $row["alamat"] . "</td>
                                    <td>" . $row["no_telp"] . "</td>
                                    <td>" . $row["username"] . "</td>
                                    <td>" . $row["password"] . "</td>
                                    <td>
                                        <a href='supplier_edit.php?kode_supplier=" . $row["kode_supplier"] . "' class='btn btn-warning btn-sm'>Edit</a>
                                        <a href='supplier_hapus.php?kode_supplier=" . $row["kode_supplier"] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Apakah Anda yakin ingin menghapus supplier ini?\")'>Hapus</a>
                                    </td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>Tidak ada data</td></tr>";
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
