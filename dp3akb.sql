-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 15, 2021 at 03:48 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dp3akb`
--

-- --------------------------------------------------------

--
-- Table structure for table `jenis_pengaduan`
--

CREATE TABLE `jenis_pengaduan` (
  `id_jenis_aduan` int(11) NOT NULL,
  `keterangan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jenis_pengaduan`
--

INSERT INTO `jenis_pengaduan` (`id_jenis_aduan`, `keterangan`) VALUES
(1, 'Korban kekerasan fisik (KF)'),
(2, 'Korban kekerasan psikis (KP)'),
(3, 'Korban kekerasan seksual (KS)'),
(4, 'Korban kekerasan penelantaran'),
(5, 'Korban kekerasan perdagangan orang/trafficking'),
(6, 'Anak Berhadapan dengan Hukum (ABH)');

-- --------------------------------------------------------

--
-- Table structure for table `korban`
--

CREATE TABLE `korban` (
  `id_korban` int(11) NOT NULL,
  `id_pelapor` int(11) DEFAULT NULL,
  `id_jenis_aduan` int(11) DEFAULT NULL,
  `jenis_korban` enum('Perempuan','Anak') DEFAULT NULL,
  `nama_korban` varchar(255) NOT NULL,
  `jkel_korban` enum('L','P') NOT NULL,
  `umur_korban` int(11) NOT NULL,
  `nik_korban` char(16) DEFAULT NULL,
  `nohp_korban` varchar(15) DEFAULT NULL,
  `alamat_korban` varchar(255) DEFAULT NULL,
  `aduan_lain` text DEFAULT NULL,
  `status_laporan` int(11) DEFAULT NULL COMMENT '1:Selesai, 2:Belum, 3:Dalam Proses',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `korban`
--

INSERT INTO `korban` (`id_korban`, `id_pelapor`, `id_jenis_aduan`, `jenis_korban`, `nama_korban`, `jkel_korban`, `umur_korban`, `nik_korban`, `nohp_korban`, `alamat_korban`, `aduan_lain`, `status_laporan`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, NULL, 'Perempuan', 'Ipsum Lorem 1', 'P', 26, NULL, NULL, NULL, 'Testing', 1, '2021-10-06 01:35:25', '2021-10-14 01:32:21', NULL),
(2, 1, NULL, 'Perempuan', 'Ipsum Lorem 2', 'P', 26, '3509127654338880', '087612843999', 'Jl. Semeru, Dusun Klanceng RT 003 / RW 003, Kelurahan Ajung, Kecamatan Ajung', NULL, 2, '2021-10-06 02:09:49', '2021-10-14 07:23:17', NULL),
(3, 1, NULL, 'Perempuan', 'Ipsum Lorem 3', 'P', 26, '3509180327659991', '084321758912', 'Jl. Bromo', 'Testing', 2, '2021-10-07 02:09:49', '2021-10-14 01:50:43', NULL),
(4, 1, NULL, 'Perempuan', 'Ipsum Lorem 4', 'P', 26, '3509127654338880', '084321758912', 'Jl. Rinjani', 'Testing', 3, '2021-10-07 02:11:54', '2021-10-14 01:51:15', NULL),
(5, 1, NULL, 'Perempuan', 'Ipsum Lorem 5', 'P', 26, '3509164358760002', '084321758912', 'Jl. Raung', NULL, 1, '2021-10-06 02:11:54', '2021-10-14 01:51:09', NULL),
(6, 1, NULL, 'Anak', 'Ipsum Lorem 6', 'L', 12, NULL, NULL, NULL, NULL, 2, '2021-10-06 02:32:28', '2021-10-14 01:51:55', NULL),
(7, 1, NULL, 'Anak', 'Ipsum Lorem 7', 'P', 12, '3509127654338880', '084321758912', 'Jl. Kenangan', 'Testing', 1, '2021-10-06 02:33:25', '2021-10-13 06:43:56', NULL),
(14, 19, NULL, 'Anak', 'Ipsum Lorem 8', 'L', 16, NULL, '085321964875', 'Jember', NULL, 2, '2021-10-14 07:37:07', '2021-10-14 07:37:07', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `korban_jenis_pengaduan_rel`
--

CREATE TABLE `korban_jenis_pengaduan_rel` (
  `id_korban_jenis_pengaduan_rel` int(11) NOT NULL,
  `id_korban` int(11) NOT NULL,
  `id_jenis_aduan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `korban_jenis_pengaduan_rel`
--

INSERT INTO `korban_jenis_pengaduan_rel` (`id_korban_jenis_pengaduan_rel`, `id_korban`, `id_jenis_aduan`) VALUES
(1, 2, 2),
(2, 2, 6),
(3, 5, 3),
(4, 6, 3),
(5, 6, 2),
(6, 6, 5),
(7, 14, 2);

-- --------------------------------------------------------

--
-- Table structure for table `pelapor`
--

CREATE TABLE `pelapor` (
  `id_pelapor` int(11) NOT NULL,
  `device_id` varchar(200) DEFAULT NULL,
  `nama_pelapor` varchar(255) NOT NULL,
  `jkel_pelapor` enum('L','P') NOT NULL,
  `umur_pelapor` int(11) DEFAULT NULL,
  `nik_pelapor` char(16) DEFAULT NULL,
  `foto_ktp` varchar(200) DEFAULT NULL,
  `nohp_pelapor` varchar(15) NOT NULL,
  `alamat_pelapor` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pelapor`
--

INSERT INTO `pelapor` (`id_pelapor`, `device_id`, `nama_pelapor`, `jkel_pelapor`, `umur_pelapor`, `nik_pelapor`, `foto_ktp`, `nohp_pelapor`, `alamat_pelapor`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '12c1e41af22e30e0', 'Lorem Ipsum 1', 'L', 20, NULL, '1344b7c9-c920-40d0-ac69-7b89cfb705a14.jpg', '085123465888', 'Jl. Jalan, Dusun Klanceng RT 003 / RW 003, Kelurahan Ajung, Kecamatan Ajung', '2021-10-06 01:36:36', '2021-10-14 07:23:45', NULL),
(19, '12c1e41af22e30e0', 'Lorem Ipsum 1', 'L', 20, NULL, '1344b7c9-c920-40d0-ac69-7b89cfb705a14.jpg', '085123465888', 'Jl. Jalan, Dusun Klanceng RT 003 / RW 003, Kelurahan Ajung, Kecamatan Ajung', '2021-10-14 07:37:07', '2021-10-14 07:37:07', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `jabatan` varchar(255) NOT NULL,
  `level` enum('Superadmin','Admin') NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `fullname`, `email`, `password`, `jabatan`, `level`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Lorem Ipsum', 'admin@admin.com', '21232f297a57a5a743894a0e4a801fc3', 'Ka. Bidang Keluarga Berencana', 'Superadmin', '2021-09-20 03:13:22', '2021-09-24 07:06:37', NULL),
(2, 'Lorem Ipsum 2', 'admin2@admin2.com', 'c84258e9c39059a89ab77d846ddab909', 'Ka. Bidang Keluarga Sejahtera', 'Admin', '2021-09-20 03:13:22', '2021-09-27 03:46:43', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jenis_pengaduan`
--
ALTER TABLE `jenis_pengaduan`
  ADD PRIMARY KEY (`id_jenis_aduan`);

--
-- Indexes for table `korban`
--
ALTER TABLE `korban`
  ADD PRIMARY KEY (`id_korban`) USING BTREE;

--
-- Indexes for table `korban_jenis_pengaduan_rel`
--
ALTER TABLE `korban_jenis_pengaduan_rel`
  ADD PRIMARY KEY (`id_korban_jenis_pengaduan_rel`);

--
-- Indexes for table `pelapor`
--
ALTER TABLE `pelapor`
  ADD PRIMARY KEY (`id_pelapor`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jenis_pengaduan`
--
ALTER TABLE `jenis_pengaduan`
  MODIFY `id_jenis_aduan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `korban`
--
ALTER TABLE `korban`
  MODIFY `id_korban` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `korban_jenis_pengaduan_rel`
--
ALTER TABLE `korban_jenis_pengaduan_rel`
  MODIFY `id_korban_jenis_pengaduan_rel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pelapor`
--
ALTER TABLE `pelapor`
  MODIFY `id_pelapor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
