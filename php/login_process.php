<?php
include "connection.php";
// Mendapatkan data dari form
$username = $_POST['username'];
$password = $_POST['password'];

// Mencegah SQL Injection
$no_HP = $conn->real_escape_string($no_HP);
$password = $conn->real_escape_string($password);

// Mengecek apakah data ada dalam database
$sql = "SELECT * FROM kepala_toko WHERE username = '$username' AND password = '$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Data ditemukan, login berhasil
    echo "Login berhasil!";
    // Anda bisa mengarahkan ke halaman lain atau melakukan tindakan lain di sini
} else {
    // Data tidak ditemukan, login gagal
    echo "Login gagal, Username atau Password salah.";
}

// Menutup koneksi
$conn->close();
?>
