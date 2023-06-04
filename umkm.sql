-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2023 at 06:27 PM
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
-- Database: `umkm`
--

-- --------------------------------------------------------

--
-- Table structure for table `umkm`
--

CREATE TABLE `umkm` (
  `nib` varchar(15) NOT NULL,
  `nama_umkm` varchar(50) NOT NULL,
  `nama_pemilik` varchar(50) NOT NULL,
  `alamat` text NOT NULL,
  `no_telepon` varchar(50) NOT NULL,
  `tahun_berdiri` varchar(50) NOT NULL,
  `jenis_umkm` varchar(255) DEFAULT NULL,
  `keterangan` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `umkm`
--

INSERT INTO `umkm` (`nib`, `nama_umkm`, `nama_pemilik`, `alamat`, `no_telepon`, `tahun_berdiri`, `jenis_umkm`, `keterangan`) VALUES
('787663', 'UD. Sejahtera', 'Pratama Nasution', 'JL. Kotanopan No.100', '082277463510', '2015', 'Usaha Menengah', 'Usaha Agribisnis'),
('010289', 'Ayla fashion', 'Sehun Oh', 'Jl. Pancasila No.8', '087765243091', '2020', 'Usaha Kecil', 'Usaha Fashion'),
('124589', 'Uri Boba', 'Ayu Ratna', 'Jl. Pohan No. 12', '087162514265', '2022', 'Usaha Mikro', 'Usaha Kuliner');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
