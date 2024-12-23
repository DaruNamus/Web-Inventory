<?php
session_start();
include 'connection.php';


// Fungsi login
if (isset($_POST['btn-login'])) {
    // Mengambil data dari form
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query untuk memeriksa user di database
    $query = "SELECT * FROM kepala_toko WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);

if ($result->num_rows > 0) {
    // Data ditemukan, login berhasil
    header("location:Admin/index.php");
    // Anda bisa mengarahkan ke halaman lain atau melakukan tindakan lain di sini
} else {
    // Data tidak ditemukan, login gagal
    header("location:index.php?pesan=gagal");
}
}
?>



<html>
<head>
    <title>Login Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="login.css" rel="stylesheet">
    <style>
        .btn-login {
            display: inline-block;
            background-color: #4CAF50; /* Warna hijau */
            color: white; /* Warna teks */
            font-size: 16px; /* Ukuran font */
            font-family: 'Roboto', sans-serif; /* Font keluarga */
            padding: 10px 20px; /* Spasi dalam tombol */
            border: none; /* Menghilangkan border */
            border-radius: 5px; /* Membuat sudut melengkung */
            cursor: pointer; /* Mengubah kursor jadi pointer */
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); /* Efek bayangan */
            transition: all 0.3s ease; /* Animasi transisi */
        }       

        .btn-login:hover {
            background-color: #45a049; /* Warna saat hover */
            transform: translateY(-2px); /* Efek naik sedikit */
            box-shadow: 0px 6px 8px rgba(0, 0, 0, 0.2); /* Perubahan bayangan */
        }

        .btn-login:active {
            transform: translateY(0); /* Mengembalikan posisi saat diklik */
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1); /* Mengurangi bayangan */
        }

    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login Owner Toko</h2>
        <form method="POST" action="">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" name="btn-login" class="btn-login">Login</button>
        </form>
        <a href="loginsupplier.php">Login sebagai Supplier</a>
        <?php
        if (isset($_GET['pesan']) && $_GET['pesan'] == "gagal") {
            echo "<p style='color:red;'>Username atau Password salah!</p>";
        }
        ?>
    </div>
</body>
</html>
