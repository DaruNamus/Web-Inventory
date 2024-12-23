-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 23 Des 2024 pada 08.37
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 7.4.29

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
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `kode_barang` int(30) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `stok` int(30) DEFAULT NULL,
  `harga` int(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`kode_barang`, `nama`, `stok`, `harga`) VALUES
(19, 'Sosis So Nice', 91, 24000),
(22, 'Sosis Asimo 750g', 64, 34000),
(23, 'Sosis Asimos 1 Kg', 23, 43000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kepala_toko`
--

CREATE TABLE `kepala_toko` (
  `id_kepalatoko` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `no_hp` varchar(12) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kepala_toko`
--

INSERT INTO `kepala_toko` (`id_kepalatoko`, `nama`, `no_hp`, `username`, `password`) VALUES
(3, 'Najwa', '88249034278', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `nota`
--

CREATE TABLE `nota` (
  `id_nota` int(30) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `tanggal` datetime NOT NULL,
  `harga` int(30) DEFAULT NULL,
  `jumlah` int(30) DEFAULT NULL,
  `pendapatan` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `nota`
--

INSERT INTO `nota` (`id_nota`, `nama`, `tanggal`, `harga`, `jumlah`, `pendapatan`) VALUES
(3, 'Sosis So Nice', '2024-12-23 14:31:25', 24000, 1, 24000),
(4, 'Sosis So Nice', '2024-12-23 14:34:53', 24000, 3, 72000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `no_order` int(30) NOT NULL,
  `status` int(2) NOT NULL,
  `tanggal_order` datetime NOT NULL DEFAULT current_timestamp(),
  `tanggal_selesai` timestamp NULL DEFAULT NULL,
  `jumlah` int(30) DEFAULT NULL,
  `kode_supplier` int(30) DEFAULT NULL,
  `kode_barang` int(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `orders`
--

INSERT INTO `orders` (`no_order`, `status`, `tanggal_order`, `tanggal_selesai`, `jumlah`, `kode_supplier`, `kode_barang`) VALUES
(6, 2, '2024-12-23 08:31:45', '2024-12-23 07:34:34', 20, 9, 19);

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier`
--

CREATE TABLE `supplier` (
  `kode_supplier` int(30) NOT NULL,
  `nama_supplier` varchar(100) DEFAULT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `no_telp` varchar(12) DEFAULT NULL,
  `username` varchar(25) DEFAULT NULL,
  `password` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `supplier`
--

INSERT INTO `supplier` (`kode_supplier`, `nama_supplier`, `alamat`, `no_telp`, `username`, `password`) VALUES
(8, 'PT. Sumber Rejeki', 'Jalan Angkasa No. 8, Surabaya', '087890123456', 'supplier8', 'password8'),
(9, 'CV. Bintang Terang', 'Jalan Pelita No. 9, Medan', '088901234567', 'supplier9', 'password9'),
(10, 'PT. Maju Jaya', 'Jalan Kembang No. 10, Jakarta', '089012345678', 'supplier10', 'password10'),
(11, 'Pak Joko', 'Klumpit', '082474282838', 'joko', 'joko');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`kode_barang`);

--
-- Indeks untuk tabel `kepala_toko`
--
ALTER TABLE `kepala_toko`
  ADD PRIMARY KEY (`id_kepalatoko`);

--
-- Indeks untuk tabel `nota`
--
ALTER TABLE `nota`
  ADD PRIMARY KEY (`id_nota`);

--
-- Indeks untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`no_order`),
  ADD KEY `kode_supplier` (`kode_supplier`),
  ADD KEY `kode_barang` (`kode_barang`);

--
-- Indeks untuk tabel `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`kode_supplier`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `kode_barang` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `kepala_toko`
--
ALTER TABLE `kepala_toko`
  MODIFY `id_kepalatoko` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `nota`
--
ALTER TABLE `nota`
  MODIFY `id_nota` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `no_order` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `supplier`
--
ALTER TABLE `supplier`
  MODIFY `kode_supplier` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`kode_supplier`) REFERENCES `supplier` (`kode_supplier`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`kode_barang`) REFERENCES `barang` (`kode_barang`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
