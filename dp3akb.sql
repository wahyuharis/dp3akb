-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 04, 2021 at 03:05 AM
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
  `id_pelapor` int(11) NOT NULL,
  `id_jenis_aduan` int(11) NOT NULL,
  `jenis_korban` enum('Perempuan','Anak') NOT NULL,
  `nama_korban` varchar(255) NOT NULL,
  `jkel_korban` enum('L','P') NOT NULL,
  `umur_korban` int(11) NOT NULL,
  `nik_korban` char(16) DEFAULT NULL,
  `nohp_korban` varchar(15) NOT NULL,
  `alamat_korban` varchar(255) NOT NULL,
  `aduan_lain` text DEFAULT NULL,
  `status_laporan` int(11) DEFAULT NULL COMMENT '1:Selesai, 2:Belum,',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `korban`
--

INSERT INTO `korban` (`id_korban`, `id_pelapor`, `id_jenis_aduan`, `jenis_korban`, `nama_korban`, `jkel_korban`, `umur_korban`, `nik_korban`, `nohp_korban`, `alamat_korban`, `aduan_lain`, `status_laporan`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 'Anak', 'Ipsum Lorem 1', 'L', 12, '3509127654335791', '087612843999', 'Jl. Jalan', NULL, 1, '2021-09-20 03:18:55', '2021-10-01 03:52:44', NULL),
(2, 1, 3, 'Perempuan', 'Ipsum Lorem', 'P', 26, '3509127654339990', '087612843999', 'Jl. Indah', NULL, 1, '2021-09-29 20:39:13', '2021-10-01 03:53:19', NULL),
(3, 1, 2, 'Anak', 'Ipsum Lorem 3', 'P', 17, '3509127654335795', '087612843955', 'Jl. Ruang', '-', 2, '2021-10-04 00:58:00', '2021-10-04 00:58:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pelapor`
--

CREATE TABLE `pelapor` (
  `id_pelapor` int(11) NOT NULL,
  `nama_pelapor` varchar(255) NOT NULL,
  `jkel_pelapor` enum('L','P') NOT NULL,
  `umur_pelapor` int(11) NOT NULL,
  `nik_pelapor` char(16) NOT NULL,
  `nohp_pelapor` varchar(15) NOT NULL,
  `alamat_pelapor` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pelapor`
--

INSERT INTO `pelapor` (`id_pelapor`, `nama_pelapor`, `jkel_pelapor`, `umur_pelapor`, `nik_pelapor`, `nohp_pelapor`, `alamat_pelapor`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Lorem Ipsum 1', 'L', 20, '3509190405980001', '085123465888', 'Jl. Jalan', '2021-09-20 03:16:13', '2021-10-04 01:01:37', NULL),
(2, 'Lorem Ipsum 2', 'P', 25, '3509810605870002', '089777444222', 'Jl. Pegangsaan Timur No. 56, Jakarta', '2021-09-20 03:16:13', '2021-10-04 01:01:40', NULL);

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
(2, 'Lorem Ipsum 2', 'admin2@admin2.com', 'c84258e9c39059a89ab77d846ddab909', 'Ka. Bidang Keluarga Sejahtera', 'Admin', '2021-09-20 03:13:22', '2021-09-27 03:46:43', NULL),
(5, 'testes', 'testes@gmail.com', '28b662d883b6d76fd96e4ddc5e9ba780', 'hgfhgfh', 'Admin', '2021-09-27 03:47:31', '2021-09-27 03:47:31', NULL);

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
  ADD PRIMARY KEY (`id_korban`),
  ADD KEY `id_pelapor` (`id_pelapor`),
  ADD KEY `id_jenis_aduan` (`id_jenis_aduan`);

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
  MODIFY `id_korban` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pelapor`
--
ALTER TABLE `pelapor`
  MODIFY `id_pelapor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `korban`
--
ALTER TABLE `korban`
  ADD CONSTRAINT `korban_ibfk_1` FOREIGN KEY (`id_pelapor`) REFERENCES `pelapor` (`id_pelapor`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `korban_ibfk_2` FOREIGN KEY (`id_jenis_aduan`) REFERENCES `jenis_pengaduan` (`id_jenis_aduan`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
