<?php
// Koneksi ke database
include '../connection.php'; // Pastikan koneksi ke database tersedia

// Periksa apakah parameter kode_barang ada di URL
if (isset($_GET['kode_supplier'])) {
    $kode_supplier = $_GET['kode_supplier'];

    // Query untuk menghapus data barang berdasarkan kode_supplier
    $query = "DELETE FROM supplier WHERE kode_supplier = ?";
    $stmt = $conn->prepare($query); // Gunakan prepared statement untuk keamanan
    $stmt->bind_param("s", $kode_supplier);

    if ($stmt->execute()) {
        // Jika berhasil, redirect ke halaman index dengan pesan sukses
        header("Location: supplier.php?pesan=hapus_berhasil");
    } else {
        // Jika gagal, redirect ke halaman index dengan pesan error
        header("Location: supplier.php?pesan=hapus_gagal");
    }

    $stmt->close(); // Tutup statement
    $conn->close(); // Tutup koneksi
} else {
    // Jika kode_supplier tidak ada, redirect ke halaman index
    header("Location: index.php?pesan=kode_tidak_ada");
    exit; // Hentikan eksekusi lebih lanjut
}
?>