<?php
// Koneksi ke database
include '../connection.php'; // pastikan sudah terkoneksi ke database

// Ambil kode_barang dari query string
if (isset($_GET['kode_barang'])) {
    $kode_barang = $_GET['kode_barang'];

    // Ambil data barang berdasarkan kode_barang
    $query = "SELECT * FROM barang WHERE kode_barang = '$kode_barang'";
    $result = $conn->query($query);

    // Periksa apakah query mengembalikan hasil
    if ($result->num_rows > 0) {
        $barang = $result->fetch_assoc();
    } else {
        // Jika tidak ada data, tampilkan pesan error atau redirect
        echo "Barang tidak ditemukan!";
        exit; // hentikan eksekusi jika barang tidak ditemukan
    }
} else {
    echo "Kode barang tidak diberikan!";
    exit; // hentikan eksekusi jika kode_barang tidak ada
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

    <!-- Css to Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>

    <!-- Modal Edit Data Barang -->
    <div class="container mt-4">
        <h2 class="text-center mb-4">Edit Data Barang</h2>

        <form action="barang_update.php" method="POST">
            <!-- Input Hidden untuk kode_barang -->
            <input type="hidden" name="kode_barang" value="<?php echo $barang['kode_barang']; ?>">

            <div class="mb-3">
                <label for="nama" class="form-label">Nama Barang</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $barang['nama']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="stok" class="form-label">Stok</label>
                <input type="number" class="form-control" id="stok" name="stok" value="<?php echo $barang['stok']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="number" class="form-control" id="harga" name="harga" value="<?php echo $barang['harga']; ?>" required>
            </div>

            <div class="d-flex justify-content-between">
                <a href="index.php" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>

    <!-- Link to Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>
