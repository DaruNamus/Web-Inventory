<?php
// Koneksi ke database
include '../connection.php'; // Pastikan koneksi ke database tersedia

// Periksa apakah parameter kode_barang ada di URL
if (isset($_GET['kode_barang'])) {
    $kode_barang = $_GET['kode_barang'];

    // Cek apakah barang sedang dalam pemesanan
    // Misalkan kita memeriksa berdasarkan nama barang
    $checkOrderQuery = "SELECT COUNT(*) as count FROM nota WHERE nama = (SELECT nama FROM barang WHERE kode_barang = ?)";
    $checkOrderStmt = $conn->prepare($checkOrderQuery);

    if ($checkOrderStmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $checkOrderStmt->bind_param("s", $kode_barang);
    $checkOrderStmt->execute();
    $checkOrderResult = $checkOrderStmt->get_result();
    $orderCount = $checkOrderResult->fetch_assoc()['count'];

    if ($orderCount > 0) {
        // Jika barang sedang dalam pemesanan
        header("Location: index.php?pesan=barang_sedang_diorder");
    } else {
        // Query untuk menghapus data barang berdasarkan kode_barang
        $query = "DELETE FROM barang WHERE kode_barang = ?";
        $stmt = $conn->prepare($query); // Gunakan prepared statement untuk keamanan

        if ($stmt === false) {
            die("Error preparing delete statement: " . $conn->error);
        }

        $stmt->bind_param("s", $kode_barang);

        if ($stmt->execute()) {
            // Jika berhasil, redirect ke halaman index dengan pesan sukses
            header("Location: index.php?pesan=hapus_berhasil");
        } else {
            // Jika gagal, redirect ke halaman index dengan pesan error
            header("Location: index.php?pesan=hapus_gagal");
        }

        $stmt->close(); // Tutup statement
    }

    $checkOrderStmt->close(); // Tutup statement untuk pengecekan pemesanan
    $conn->close(); // Tutup koneksi
} else {
    // Jika kode_barang tidak ada, redirect ke halaman index
    header("Location: index.php?pesan=kode_tidak_ada");
    exit; // Hentikan eksekusi lebih lanjut
}
?>