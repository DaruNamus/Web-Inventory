<?php
// Koneksi ke database
include '../connection.php';

// Memeriksa apakah data POST diterima
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Menyimpan data yang dikirimkan dari form
    $kode_supplier = $_POST['kode_supplier'];
    $nama = $_POST['nama_supplier'];
    $alamat = $_POST['alamat'];
    $no_telp = $_POST['no_telp'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk memperbarui data barang
    $query = "UPDATE supplier SET nama_supplier='$nama', alamat='$alamat', no_telp='$no_telp', username='$username', password='$password' WHERE kode_supplier='$kode_supplier'";

    if ($conn->query($query) === TRUE) {
        echo "<script>alert('Data berhasil diperbarui'); window.location.href = 'supplier.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close(); // Menutup koneksi
}
?>
