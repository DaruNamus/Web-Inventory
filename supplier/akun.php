<?php
include '../connection.php'; // Menghubungkan ke database

// Memeriksa apakah ada sesi login untuk supplier
session_start();
if (!isset($_SESSION['kode_supplier'])) {
    echo "<script>alert('Anda harus login terlebih dahulu!'); window.location.href='../index.php';</script>";
    exit();
}

// Mendapatkan ID supplier dari sesi login
$supplier_id = $_SESSION['kode_supplier'];

// Query untuk mendapatkan data akun supplier
$sql_supplier = "SELECT nama_supplier, username, password FROM supplier WHERE kode_supplier = ?";
$stmt = $conn->prepare($sql_supplier);
$stmt->bind_param("i", $supplier_id);
$stmt->execute();
$result_supplier = $stmt->get_result();

// Periksa apakah data ditemukan
if ($result_supplier->num_rows === 0) {
    echo "<script>alert('Data supplier tidak ditemukan!'); window.location.href='index.php';</script>";
    exit();
}

$data_supplier = $result_supplier->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Akun</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <!-- Link to CSS -->
    <link href="../style.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f0f0;
            margin: 0;
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #007bff;
            color: white;
            padding: 15px 20px;
            border-radius: 0 0 8px 8px;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            font-weight: 700;
            padding: 10px 20px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        .navbar a:hover {
            background-color: #0056b3;
        }
        .logout-button {
            background-color: #dc3545; 
            border: none;
            border-radius: 4px;
            color: white;
            font-weight: 700;
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .logout-button:hover {
            background-color: #c82333;
        }
        .dashboard-container {
            padding: 30px;
        }
        .account-container {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: 0 auto;
        }
        .account-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #007bff;
        }
        .form-group {
            margin-bottom: 20px;
            margin-right: 20px
        }
        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-group input:disabled {
            background-color: #e9ecef;
        }
        .btn-primary {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            margin-bottom: 20px;
            border-radius: 4px;
            border: none;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
            text-decoration: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <div>
            <a href="index.php">Permintaan Restock</a>
            <a href="akun.php">Akun</a>
        </div>
        <a href="logout.php" class="logout-button">Logout</a>
    </div>

    <!-- Container -->
    <div class="dashboard-container">
        <div class="account-container">
            <h2>Pengaturan Akun</h2>
            <form>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" value="<?php echo htmlspecialchars($data_supplier['username']); ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="text" id="password" value="<?php echo htmlspecialchars($data_supplier['password']); ?>" disabled>
                </div>
                <a href="akun_edit.php" class="btn btn-primary">Edit Akun</a>
            </form>
        </div>
    </div>
</body>
</html>

<?php
$conn->close(); // Menutup koneksi database
?>