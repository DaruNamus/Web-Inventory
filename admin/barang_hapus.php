<?php
// Koneksi ke database
include '../connection.php'; // Pastikan koneksi ke database tersedia

// Periksa apakah parameter kode_barang ada di URL
if (isset($_GET['kode_barang'])) {
    $kode_barang = $_GET['kode_barang'];

    // Query untuk menghapus data barang berdasarkan kode_barang
    $query = "DELETE FROM barang WHERE kode_barang = ?";
    $stmt = $conn->prepare($query); // Gunakan prepared statement untuk keamanan
    $stmt->bind_param("s", $kode_barang);

    if ($stmt->execute()) {
        // Jika berhasil, redirect ke halaman index dengan pesan sukses
        header("Location: index.php?pesan=hapus_berhasil");
    } else {
        // Jika gagal, redirect ke halaman index dengan pesan error
        header("Location: index.php?pesan=hapus_gagal");
    }

    $stmt->close(); // Tutup statement
    $conn->close(); // Tutup koneksi
} else {
    // Jika kode_barang tidak ada, redirect ke halaman index
    header("Location: index.php?pesan=kode_tidak_ada");
    exit; // Hentikan eksekusi lebih lanjut
}
?>