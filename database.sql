-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 25, 2026 at 04:12 PM
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
-- Database: `db_buildtrust_pos`
--
CREATE DATABASE IF NOT EXISTS `db_buildtrust_pos` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `db_buildtrust_pos`;

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE IF NOT EXISTS `activity_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `waktu` timestamp NOT NULL DEFAULT current_timestamp(),
  `user` varchar(100) NOT NULL,
  `aksi` text NOT NULL,
  `tipe` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `waktu`, `user`, `aksi`, `tipe`) VALUES
(1, '2026-06-24 04:47:19', 'System Guard', 'Basis data berhasil diinisialisasi', 'info'),
(2, '2026-06-24 04:55:13', 'System Guard', 'Basis data berhasil diinisialisasi', 'info'),
(3, '2026-06-24 04:56:49', 'Kayla Aura (Admin)', 'Berhasil masuk ke sistem', 'info'),
(4, '2026-06-24 05:03:15', 'Kayla Aura (Admin)', 'Berhasil masuk ke sistem', 'info'),
(5, '2026-06-24 05:07:03', 'Kayla Aura (Admin)', 'Keluar dari sistem', 'info'),
(6, '2026-06-24 05:07:12', 'Amirah Fauziyyah (Kasir)', 'Berhasil masuk ke sistem', 'info'),
(7, '2026-06-24 05:08:40', 'Amirah Fauziyyah (Kasir)', 'Keluar dari sistem', 'info'),
(8, '2026-06-24 05:08:55', 'Kelompok 28 (Owner)', 'Berhasil masuk ke sistem', 'info'),
(9, '2026-06-24 05:40:46', 'Kelompok 28 (Owner)', 'Keluar dari sistem', 'info')
ON DUPLICATE KEY UPDATE `id`=`id`;

-- --------------------------------------------------------

--
-- Table structure for table `jurnal`
--

CREATE TABLE IF NOT EXISTS `jurnal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jurnal_no` varchar(50) NOT NULL,
  `transaction_id` int(11) DEFAULT NULL,
  `tanggal` date NOT NULL,
  `ref` varchar(10) NOT NULL,
  `akun` varchar(100) NOT NULL,
  `d` int(11) NOT NULL DEFAULT 0,
  `k` int(11) NOT NULL DEFAULT 0,
  `desc` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `transaction_id` (`transaction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jurnal`
--

INSERT INTO `jurnal` (`id`, `jurnal_no`, `transaction_id`, `tanggal`, `ref`, `akun`, `d`, `k`, `desc`, `created_at`) VALUES
(1, 'JRN-001', NULL, '2026-05-18', '111', 'Kas Toko', 15000000, 0, 'Inisialisasi Modal Operasional Awal', '2026-06-24 04:47:19'),
(2, 'JRN-001', NULL, '2026-05-18', '411', 'Pendapatan Penjualan', 0, 15000000, 'Inisialisasi Modal Operasional Awal', '2026-06-24 04:47:19'),
(3, 'JRN-001', NULL, '2026-05-18', '111', 'Kas Toko', 15000000, 0, 'Inisialisasi Modal Operasional Awal', '2026-06-24 04:55:13'),
(4, 'JRN-001', NULL, '2026-05-18', '411', 'Pendapatan Penjualan', 0, 15000000, 'Inisialisasi Modal Operasional Awal', '2026-06-24 04:55:13')
ON DUPLICATE KEY UPDATE `id`=`id`;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(150) NOT NULL,
  `merk` varchar(100) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `harga` int(11) NOT NULL,
  `satuan` varchar(20) NOT NULL,
  `stok` int(11) NOT NULL,
  `min_stok` int(11) NOT NULL,
  `konversi` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `nama`, `merk`, `kategori`, `harga`, `satuan`, `stok`, `min_stok`, `konversi`, `created_at`, `updated_at`) VALUES
(1, 'Semen Tiga Roda 40kg', 'Tiga Roda', 'Semen', 68000, 'Sak', 12, 20, '1 Sak = 40 Kg', '2026-06-24 04:47:19', '2026-06-24 04:47:19'),
(2, 'Pipa PVC Wavin AW 3\"', 'Wavin', 'Pipa', 125000, 'Batang', 35, 10, '1 Batang = 4 Meter', '2026-06-24 04:47:19', '2026-06-24 04:47:19'),
(3, 'Besi Beton 10mm SNI', 'KS', 'Besi', 85000, 'Batang', 8, 15, '1 Batang = 12 Meter', '2026-06-24 04:47:19', '2026-06-24 04:47:19'),
(4, 'Cat Tembok Dulux Weather Shield 2.5L', 'Dulux', 'Cat', 245000, 'Pail', 4, 5, '1 Pail = 2.5 Liter', '2026-06-24 04:47:19', '2026-06-24 04:47:19'),
(5, 'Papan Kayu Meranti 2x20x400', 'Lokal', 'Kayu', 45000, 'Lembar', 50, 30, '1 Lembar = 4 Meter', '2026-06-24 04:47:19', '2026-06-24 04:47:19')
ON DUPLICATE KEY UPDATE `id`=`id`;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nota_no` varchar(50) NOT NULL,
  `pelanggan` varchar(100) NOT NULL,
  `metode_pembayaran` varchar(50) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `tax` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `bayar` int(11) NOT NULL,
  `kembalian` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `nota_no` (`nota_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaction_items`
--

CREATE TABLE IF NOT EXISTS `transaction_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `satuan` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `transaction_id` (`transaction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `role` enum('admin','kasir','owner') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `nama`, `role`, `created_at`) VALUES
(1, 'admin', '$2y$12$y5GwkY6LI2hMAHhecaJ8HuZBBdZoB9MgOhC7oFyw9WdIBLZKwYU5W', 'Kayla Aura (Admin)', 'admin', '2026-06-24 04:55:13'),
(2, 'kasir', '$2y$12$5vJ48XJIPjJ2ej03hDtXKe2qS5uoNkE0eIeU5meoMAISzFhFtNIEC', 'Amirah Fauziyyah (Kasir)', 'kasir', '2026-06-24 04:55:13'),
(3, 'owner', '$2y$12$8GYJsHz1c0KWCI0Gz6STvek2y.Z6hg1NXP9Y4g2EOp.5n.uo7vb8K', 'Kelompok 28 (Owner)', 'owner', '2026-06-24 04:55:13')
ON DUPLICATE KEY UPDATE `id`=`id`;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jurnal`
--
ALTER TABLE `jurnal`
  ADD CONSTRAINT `jurnal_ibfk_1` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `transaction_items`
--
ALTER TABLE `transaction_items`
  ADD CONSTRAINT `transaction_items_ibfk_1` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
