<?php
// Koneksi ke database
include '../connection.php';

// Memeriksa apakah data POST diterima
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Menyimpan data yang dikirimkan dari form
    $kode_barang = $_POST['kode_barang'];
    $nama = $_POST['nama'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga'];

    // Query untuk memperbarui data barang
    $query = "UPDATE barang SET nama='$nama', stok='$stok', harga='$harga' WHERE kode_barang='$kode_barang'";

    if ($conn->query($query) === TRUE) {
        echo "<script>alert('Data berhasil diperbarui'); window.location.href = 'index.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close(); // Menutup koneksi
}
?>
