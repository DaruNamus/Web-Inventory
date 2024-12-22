-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 22, 2024 at 02:16 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lat_kasir_jksi`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `kode_barang` int(30) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `stok` int(30) DEFAULT NULL,
  `harga` int(30) DEFAULT NULL,
  `kode_supplier` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`kode_barang`, `nama`, `stok`, `harga`, `kode_supplier`) VALUES
(1, 'Pocari Sweat 500ml', 120, 10000, 1),
(2, 'Indomie Goreng Rendang', 200, 3000, 2),
(3, 'Teh Botol Sosro 330ml', 150, 5000, 3),
(4, 'Selai Kacang ABC 250gr', 120, 15000, 4),
(5, 'Kopi Kapal Api 200gr', 80, 22000, 5),
(6, 'Mie Sedaap Rasa Soto', 180, 3500, 6),
(7, 'Kecap Bango 500ml', 75, 12000, 7),
(8, 'Tepung Terigu Cakra Kembar 1kg', 140, 10000, 8),
(9, 'Susu Indomilk Full Cream 1L', 90, 15000, 9),
(10, 'Biskuit Oreo 137gr', 250, 15000, 10),
(11, 'Minyak Goreng Filma 1L', 130, 19000, 1),
(13, 'Detergen Rinso 1kg', 160, 22000, 3),
(14, 'Indomilk Susu Kental Manis 370gr', 140, 11000, 4);

-- --------------------------------------------------------

--
-- Table structure for table `nota`
--

CREATE TABLE `nota` (
  `id_nota` int(30) NOT NULL,
  `tanggal` datetime NOT NULL,
  `harga` int(30) DEFAULT NULL,
  `jumlah` int(30) DEFAULT NULL,
  `kode_barang` int(30) DEFAULT NULL,
  `pendapatan` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `no_order` int(30) NOT NULL,
  `status` int(2) NOT NULL,
  `tanggal_order` datetime NOT NULL DEFAULT current_timestamp(),
  `tanggal_selesai` date NOT NULL DEFAULT current_timestamp(),
  `jumlah` int(30) DEFAULT NULL,
  `kode_supplier` int(30) DEFAULT NULL,
  `kode_barang` int(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`no_order`, `status`, `tanggal_order`, `tanggal_selesai`, `jumlah`, `kode_supplier`, `kode_barang`) VALUES
(1, 0, '2024-12-22 14:08:37', '0000-00-00', 20, 2, 5),
(2, 0, '2024-12-22 14:09:23', '0000-00-00', 12, 3, 3),
(3, 0, '2024-12-22 14:09:33', '0000-00-00', 40, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `kode_supplier` int(30) NOT NULL,
  `nama_supplier` varchar(100) DEFAULT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `no_telp` varchar(12) DEFAULT NULL,
  `username` varchar(25) DEFAULT NULL,
  `password` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`kode_supplier`, `nama_supplier`, `alamat`, `no_telp`, `username`, `password`) VALUES
(1, 'PT. ABC', 'Jalan Mawar No. 1, Jakarta', '081234567890', 'supplier1', 'password1'),
(2, 'PT. XYZ', 'Jalan Melati No. 2, Surabaya', '081987654321', 'supplier2', 'password2'),
(3, 'CV. Jaya Sentosa', 'Jalan Anggrek No. 3, Bandung', '082345678901', 'supplier3', 'password3'),
(4, 'PT. Karya Mandiri', 'Jalan Cendana No. 4, Yogyakarta', '083456789012', 'supplier4', 'password4'),
(5, 'CV. Pasti Sukses', 'Jalan Cemara No. 5, Medan', '084567890123', 'supplier5', 'password5'),
(6, 'PT. Mega Abadi', 'Jalan Pinus No. 6, Bali', '085678901234', 'supplier6', 'password6'),
(7, 'CV. Sejahtera', 'Jalan Dahlia No. 7, Makassar', '086789012345', 'supplier7', 'password7'),
(8, 'PT. Sumber Rejeki', 'Jalan Angkasa No. 8, Surabaya', '087890123456', 'supplier8', 'password8'),
(9, 'CV. Bintang Terang', 'Jalan Pelita No. 9, Medan', '088901234567', 'supplier9', 'password9'),
(10, 'PT. Maju Jaya', 'Jalan Kembang No. 10, Jakarta', '089012345678', 'supplier10', 'password10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(20) NOT NULL,
  `role` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `nama`, `role`) VALUES
(1, 'admin', 'admin', 'Admin', 'admin'),
(2, 'supplier', 'supplier1', 'Supplier Agus', 'supplier');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`kode_barang`),
  ADD KEY `fk_kode_supplier` (`kode_supplier`);

--
-- Indexes for table `nota`
--
ALTER TABLE `nota`
  ADD PRIMARY KEY (`id_nota`),
  ADD KEY `fk_kode_barang` (`kode_barang`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`no_order`),
  ADD KEY `kode_supplier` (`kode_supplier`),
  ADD KEY `kode_barang` (`kode_barang`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`kode_supplier`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `kode_barang` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `nota`
--
ALTER TABLE `nota`
  MODIFY `id_nota` int(30) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `no_order` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `kode_supplier` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `fk_kode_supplier` FOREIGN KEY (`kode_supplier`) REFERENCES `supplier` (`kode_supplier`);

--
-- Constraints for table `nota`
--
ALTER TABLE `nota`
  ADD CONSTRAINT `fk_kode_barang` FOREIGN KEY (`kode_barang`) REFERENCES `barang` (`kode_barang`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`kode_supplier`) REFERENCES `supplier` (`kode_supplier`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`kode_barang`) REFERENCES `barang` (`kode_barang`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
