-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 05, 2023 at 06:05 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `database_umkm`
--

-- --------------------------------------------------------

--
-- Table structure for table `umkm_bantul`
--

CREATE TABLE `umkm_bantul` (
  `nib` int(11) NOT NULL,
  `nama_umkm` varchar(100) DEFAULT NULL,
  `nama_pemilik` varchar(100) DEFAULT NULL,
  `alamat` varchar(200) DEFAULT NULL,
  `no_telepon` varchar(20) DEFAULT NULL,
  `tahun_berdiri` int(11) DEFAULT NULL,
  `jenis_umkm` varchar(50) DEFAULT NULL,
  `keterangan` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `umkm_sleman`
--

CREATE TABLE `umkm_sleman` (
  `nib` int(11) NOT NULL,
  `nama_umkm` varchar(100) DEFAULT NULL,
  `nama_pemilik` varchar(100) DEFAULT NULL,
  `alamat` varchar(200) DEFAULT NULL,
  `no_telepon` varchar(20) DEFAULT NULL,
  `tahun_berdiri` int(11) DEFAULT NULL,
  `jenis_umkm` varchar(50) DEFAULT NULL,
  `keterangan` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `umkm_sleman`
--

INSERT INTO `umkm_sleman` (`nib`, `nama_umkm`, `nama_pemilik`, `alamat`, `no_telepon`, `tahun_berdiri`, `jenis_umkm`, `keterangan`) VALUES
(124589, 'UD. Sejahtera', 'Pratama S.', 'JL. Kotanopan No.101', '082277463510', 2018, 'Usaha Menengah', 'Usaha Agribisnis'),
(5645467, 'Ayla fashion', 'Ayu Ratna', 'Jl. Otto No.13', '0812637453', 2019, 'Usaha Kecil', 'Usaha Fashion');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `umkm_bantul`
--
ALTER TABLE `umkm_bantul`
  ADD PRIMARY KEY (`nib`);

--
-- Indexes for table `umkm_sleman`
--
ALTER TABLE `umkm_sleman`
  ADD PRIMARY KEY (`nib`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
