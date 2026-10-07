-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 07, 2026 at 05:54 AM
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
-- Database: `kas`
--

-- --------------------------------------------------------

--
-- Table structure for table `kas_anda`
--

CREATE TABLE `kas_anda` (
  `id_km` int(11) NOT NULL,
  `tgl_km` date NOT NULL,
  `uraian_km` varchar(200) NOT NULL,
  `masuk` int(11) NOT NULL,
  `keluar` int(11) NOT NULL,
  `jenis` enum('Masuk','Keluar') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `kas_anda`
--

INSERT INTO `kas_anda` (`id_km`, `tgl_km`, `uraian_km`, `masuk`, `keluar`, `jenis`) VALUES
(6, '2026-09-09', 'gaji', 5000000, 0, 'Masuk'),
(7, '2026-09-09', 'makan', 0, 500000, 'Keluar'),
(8, '2026-09-01', 'makan', 0, 100000, 'Keluar'),
(9, '2026-09-11', 'gaji', 800000000, 0, 'Masuk'),
(10, '2026-09-10', 'gaji', 5000000, 0, 'Masuk'),
(11, '2026-09-12', 'gaji', 90000000, 0, 'Masuk'),
(12, '2026-09-16', 'makan', 0, 100000000, 'Keluar'),
(13, '2026-09-16', 'gaji', 80000000, 0, 'Masuk');

-- --------------------------------------------------------

--
-- Table structure for table `kas_sosial`
--

CREATE TABLE `kas_sosial` (
  `id_ks` int(11) NOT NULL,
  `tgl_ks` date NOT NULL,
  `uraian_ks` varchar(200) NOT NULL,
  `masuk` int(11) NOT NULL,
  `keluar` int(11) NOT NULL,
  `jenis` enum('Masuk','Keluar') NOT NULL,
  `username_ks` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `kas_sosial`
--

INSERT INTO `kas_sosial` (`id_ks`, `tgl_ks`, `uraian_ks`, `masuk`, `keluar`, `jenis`, `username_ks`) VALUES
(4, '2026-09-18', 'samson', 5000000, 0, 'Masuk', ''),
(5, '2026-09-18', 'gaji', 5000000, 0, 'Masuk', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `target_kas_sosial`
--

CREATE TABLE `target_kas_sosial` (
  `id_target` int(11) NOT NULL,
  `nama_target` varchar(100) NOT NULL DEFAULT 'Target Kas Sosial',
  `target_nominal` bigint(20) NOT NULL DEFAULT 0,
  `target_tanggal` date DEFAULT NULL,
  `dibuat_pada` datetime NOT NULL DEFAULT current_timestamp(),
  `diperbarui_pada` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `target_kas_sosial`
--

INSERT INTO `target_kas_sosial` (`id_target`, `nama_target`, `target_nominal`, `target_tanggal`, `dibuat_pada`, `diperbarui_pada`) VALUES
(1, 'Target Kas Sosial', 1000000000, '2026-10-09', '2026-09-18 11:01:37', '2026-09-18 11:02:01');

-- --------------------------------------------------------

--
-- Table structure for table `target_tabungan`
--

CREATE TABLE `target_tabungan` (
  `id_target` int(11) NOT NULL,
  `nama_target` varchar(100) NOT NULL DEFAULT 'Target Tabungan',
  `target_nominal` bigint(20) NOT NULL DEFAULT 0,
  `target_tanggal` date DEFAULT NULL,
  `dibuat_pada` datetime NOT NULL DEFAULT current_timestamp(),
  `diperbarui_pada` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `target_tabungan`
--

INSERT INTO `target_tabungan` (`id_target`, `nama_target`, `target_nominal`, `target_tanggal`, `dibuat_pada`, `diperbarui_pada`) VALUES
(1, 'Target Tabungan', 1000000000, '2026-09-19', '2026-09-11 12:19:00', '2026-09-16 10:52:33');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pengguna`
--

CREATE TABLE `tb_pengguna` (
  `id_pengguna` int(11) NOT NULL,
  `nama_pengguna` varchar(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `level` enum('Administrator','Bendahara') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_pengguna`
--

INSERT INTO `tb_pengguna` (`id_pengguna`, `nama_pengguna`, `username`, `password`, `level`) VALUES
(1, 'Admin', 'admin', 'admin', 'Administrator'),
(2, 'Bendahara', 'bendahara', 'bendahara', 'Bendahara');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kas_anda`
--
ALTER TABLE `kas_anda`
  ADD PRIMARY KEY (`id_km`);

--
-- Indexes for table `kas_sosial`
--
ALTER TABLE `kas_sosial`
  ADD PRIMARY KEY (`id_ks`);

--
-- Indexes for table `target_kas_sosial`
--
ALTER TABLE `target_kas_sosial`
  ADD PRIMARY KEY (`id_target`);

--
-- Indexes for table `target_tabungan`
--
ALTER TABLE `target_tabungan`
  ADD PRIMARY KEY (`id_target`);

--
-- Indexes for table `tb_pengguna`
--
ALTER TABLE `tb_pengguna`
  ADD PRIMARY KEY (`id_pengguna`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kas_anda`
--
ALTER TABLE `kas_anda`
  MODIFY `id_km` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `kas_sosial`
--
ALTER TABLE `kas_sosial`
  MODIFY `id_ks` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `target_kas_sosial`
--
ALTER TABLE `target_kas_sosial`
  MODIFY `id_target` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `target_tabungan`
--
ALTER TABLE `target_tabungan`
  MODIFY `id_target` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_pengguna`
--
ALTER TABLE `tb_pengguna`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
