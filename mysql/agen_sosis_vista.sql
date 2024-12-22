-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 22 Des 2024 pada 09.58
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
-- Database: `agen_sosis_vista`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `kode_barang` int(30) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `stok` int(30) DEFAULT NULL,
  `harga` int(30) DEFAULT NULL,
  `id_kepalatoko` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`kode_barang`, `nama`, `stok`, `harga`, `id_kepalatoko`) VALUES
(1, 'Sosis Okey', 30, 24000, 1),
(2, 'Nugget Okey', 30, 24000, 1),
(3, 'Sosis Asimo', 30, 16000, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kepala_toko`
--

CREATE TABLE `kepala_toko` (
  `id_kepalatoko` int(30) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `no_HP` varchar(12) DEFAULT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kepala_toko`
--

INSERT INTO `kepala_toko` (`id_kepalatoko`, `nama`, `no_HP`, `username`, `password`) VALUES
(1, 'Najwa', NULL, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `nota`
--

CREATE TABLE `nota` (
  `id_nota` int(30) NOT NULL,
  `harga` int(30) DEFAULT NULL,
  `tanggal` timestamp NULL DEFAULT current_timestamp(),
  `id_kepalatoko` int(30) NOT NULL,
  `kode_barang` int(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_barang`
--

CREATE TABLE `order_barang` (
  `no_order` int(30) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `tanggal_order` timestamp NULL DEFAULT current_timestamp(),
  `tanggal_selesai` date DEFAULT NULL,
  `id_kepalatoko` int(30) NOT NULL,
  `kode_supplier` int(30) NOT NULL,
  `kode_barang` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier`
--

CREATE TABLE `supplier` (
  `kode_supplier` int(30) NOT NULL,
  `nama_supplier` varchar(100) DEFAULT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `no_telp` varchar(12) DEFAULT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `supplier`
--

INSERT INTO `supplier` (`kode_supplier`, `nama_supplier`, `alamat`, `no_telp`, `username`, `password`) VALUES
(1, 'Agen Sosis', 'Megawon', '628132478591', 'agensosis', 'agensosis');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`kode_barang`),
  ADD KEY `idKT` (`id_kepalatoko`);

--
-- Indeks untuk tabel `kepala_toko`
--
ALTER TABLE `kepala_toko`
  ADD PRIMARY KEY (`id_kepalatoko`);

--
-- Indeks untuk tabel `nota`
--
ALTER TABLE `nota`
  ADD PRIMARY KEY (`id_nota`),
  ADD KEY `id_kepalatoko` (`id_kepalatoko`),
  ADD KEY `kode_barang` (`kode_barang`);

--
-- Indeks untuk tabel `order_barang`
--
ALTER TABLE `order_barang`
  ADD PRIMARY KEY (`no_order`),
  ADD KEY `kodebarang` (`kode_barang`),
  ADD KEY `id_kepalatoko` (`id_kepalatoko`),
  ADD KEY `kodeSPL` (`kode_supplier`);

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
  MODIFY `kode_barang` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `kepala_toko`
--
ALTER TABLE `kepala_toko`
  MODIFY `id_kepalatoko` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `nota`
--
ALTER TABLE `nota`
  MODIFY `id_nota` int(30) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `order_barang`
--
ALTER TABLE `order_barang`
  MODIFY `no_order` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `supplier`
--
ALTER TABLE `supplier`
  MODIFY `kode_supplier` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `id_KT` FOREIGN KEY (`id_kepalatoko`) REFERENCES `kepala_toko` (`id_kepalatoko`);

--
-- Ketidakleluasaan untuk tabel `nota`
--
ALTER TABLE `nota`
  ADD CONSTRAINT `id_kepalatoko` FOREIGN KEY (`id_kepalatoko`) REFERENCES `kepala_toko` (`id_kepalatoko`),
  ADD CONSTRAINT `kode_barang` FOREIGN KEY (`kode_barang`) REFERENCES `barang` (`kode_barang`);

--
-- Ketidakleluasaan untuk tabel `order_barang`
--
ALTER TABLE `order_barang`
  ADD CONSTRAINT `idKT` FOREIGN KEY (`id_kepalatoko`) REFERENCES `kepala_toko` (`id_kepalatoko`),
  ADD CONSTRAINT `kodeSP` FOREIGN KEY (`kode_supplier`) REFERENCES `supplier` (`kode_supplier`),
  ADD CONSTRAINT `kodebarang` FOREIGN KEY (`kode_barang`) REFERENCES `barang` (`kode_barang`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
