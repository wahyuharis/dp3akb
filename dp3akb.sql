-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.13-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table dp3akb.jenis_pengaduan
DROP TABLE IF EXISTS `jenis_pengaduan`;
CREATE TABLE IF NOT EXISTS `jenis_pengaduan` (
  `id_jenis_aduan` int(11) NOT NULL AUTO_INCREMENT,
  `keterangan` varchar(255) NOT NULL,
  PRIMARY KEY (`id_jenis_aduan`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table dp3akb.jenis_pengaduan: ~6 rows (approximately)
/*!40000 ALTER TABLE `jenis_pengaduan` DISABLE KEYS */;
INSERT INTO `jenis_pengaduan` (`id_jenis_aduan`, `keterangan`) VALUES
	(1, 'Korban kekerasan fisik (KF)'),
	(2, 'Korban kekerasan psikis (KP)'),
	(3, 'Korban kekerasan seksual (KS)'),
	(4, 'Korban kekerasan penelantaran'),
	(5, 'Korban kekerasan perdagangan orang/trafficking'),
	(6, 'Anak Berhadapan dengan Hukum (ABH)');
/*!40000 ALTER TABLE `jenis_pengaduan` ENABLE KEYS */;

-- Dumping structure for table dp3akb.korban
DROP TABLE IF EXISTS `korban`;
CREATE TABLE IF NOT EXISTS `korban` (
  `id_korban` int(11) NOT NULL AUTO_INCREMENT,
  `id_pelapor` int(11) DEFAULT NULL,
  `id_jenis_aduan` int(11) DEFAULT NULL,
  `jenis_korban` enum('Perempuan','Anak') DEFAULT NULL,
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
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_korban`),
  KEY `id_pelapor` (`id_pelapor`),
  KEY `id_jenis_aduan` (`id_jenis_aduan`),
  CONSTRAINT `korban_ibfk_1` FOREIGN KEY (`id_pelapor`) REFERENCES `pelapor` (`id_pelapor`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `korban_ibfk_2` FOREIGN KEY (`id_jenis_aduan`) REFERENCES `jenis_pengaduan` (`id_jenis_aduan`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table dp3akb.korban: ~11 rows (approximately)
/*!40000 ALTER TABLE `korban` DISABLE KEYS */;
INSERT INTO `korban` (`id_korban`, `id_pelapor`, `id_jenis_aduan`, `jenis_korban`, `nama_korban`, `jkel_korban`, `umur_korban`, `nik_korban`, `nohp_korban`, `alamat_korban`, `aduan_lain`, `status_laporan`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 1, 1, 'Anak', 'Ipsum Lorem 1', 'L', 12, '3509127654335791', '087612843999', 'Jl. Jalan', NULL, 1, '2021-09-20 10:18:55', '2021-10-01 10:52:44', NULL),
	(2, 1, 3, 'Perempuan', 'Ipsum Lorem', 'P', 26, '3509127654339990', '087612843999', 'Jl. Indah', NULL, 1, '2021-09-30 03:39:13', '2021-10-01 10:53:19', NULL),
	(3, 1, 2, 'Anak', 'Ipsum Lorem 3', 'P', 17, '3509127654335795', '087612843955', 'Jl. Ruang', '-', 2, '2021-10-04 07:58:00', '2021-10-04 07:58:00', NULL),
	(4, 3, 1, 'Perempuan', 'haris', 'L', 12, NULL, '234234234234', 'sdfsdfsdf', '', NULL, '2021-10-05 11:00:47', '2021-10-05 11:00:47', NULL),
	(5, 4, 1, 'Anak', 'haris', 'L', 12, NULL, '234234234234', 'sdfsdfsdf', '', NULL, '2021-10-05 11:05:59', '2021-10-05 11:05:59', NULL),
	(6, 5, 1, 'Perempuan', 'sumiati', 'P', 34, NULL, '123123123123', 'jember', '', NULL, '2021-10-05 11:06:55', '2021-10-05 11:06:55', NULL),
	(8, 8, NULL, 'Perempuan', 'sdfsdfsdfsd', 'P', 23, NULL, '345345345345', 'sdfsdfsdf', 'sdfsdfsdfsdfs', NULL, '2021-10-05 11:21:04', '2021-10-05 11:21:04', NULL),
	(9, 9, 5, 'Perempuan', 'sdfsdfsdfsd', 'P', 23, NULL, '345345345345', 'sdfsdfsdf', 'sdfsdfsdfsdfs', NULL, '2021-10-05 11:21:33', '2021-10-05 11:21:33', NULL),
	(10, 10, 2, 'Perempuan', 'fgdfgdfg', 'P', 23, NULL, '234234234234', 'sdfsdfsdf', '', NULL, '2021-10-05 11:22:59', '2021-10-05 11:22:59', NULL),
	(11, 11, 1, 'Anak', 'Hhhhh', 'L', 12, NULL, '121212121212', 'Jember', '', NULL, '2021-10-05 11:28:31', '2021-10-05 11:28:31', NULL),
	(12, 12, NULL, 'Anak', 'Lorem Ipsum', 'P', 15, NULL, '085655322911', 'Jl. Semeru', 'Testing', NULL, '2021-10-05 14:51:19', '2021-10-05 14:51:19', NULL);
/*!40000 ALTER TABLE `korban` ENABLE KEYS */;

-- Dumping structure for table dp3akb.pelapor
DROP TABLE IF EXISTS `pelapor`;
CREATE TABLE IF NOT EXISTS `pelapor` (
  `id_pelapor` int(11) NOT NULL AUTO_INCREMENT,
  `nama_pelapor` varchar(255) NOT NULL,
  `jkel_pelapor` enum('L','P') NOT NULL,
  `umur_pelapor` int(11) DEFAULT NULL,
  `nik_pelapor` char(16) DEFAULT NULL,
  `nohp_pelapor` varchar(15) NOT NULL,
  `alamat_pelapor` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_pelapor`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table dp3akb.pelapor: ~11 rows (approximately)
/*!40000 ALTER TABLE `pelapor` DISABLE KEYS */;
INSERT INTO `pelapor` (`id_pelapor`, `nama_pelapor`, `jkel_pelapor`, `umur_pelapor`, `nik_pelapor`, `nohp_pelapor`, `alamat_pelapor`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'Lorem Ipsum 1', 'L', 20, '3509190405980001', '085123465888', 'Jl. Jalan', '2021-09-20 10:16:13', '2021-10-04 08:01:37', NULL),
	(2, 'Lorem Ipsum 2', 'P', 25, '3509810605870002', '089777444222', 'Jl. Pegangsaan Timur No. 56, Jakarta', '2021-09-20 10:16:13', '2021-10-04 08:01:40', NULL),
	(3, 'haris', 'L', 12, NULL, '3542334234234', 'asdfasdsad', '2021-10-05 11:00:47', '2021-10-05 11:00:47', NULL),
	(4, 'haris', 'L', 12, NULL, '3542334234234', 'asdfasdsad', '2021-10-05 11:05:59', '2021-10-05 11:05:59', NULL),
	(5, 'haris', 'L', 12, NULL, '123123123123123', 'jember', '2021-10-05 11:06:55', '2021-10-05 11:06:55', NULL),
	(6, 'sdgsdgsdf', 'L', 34, NULL, '346345345345', 'dfgdfgdfg', '2021-10-05 11:17:31', '2021-10-05 11:17:31', NULL),
	(7, 'sdgsdgsdf', 'L', 34, NULL, '346345345345', 'dfgdfgdfg', '2021-10-05 11:19:54', '2021-10-05 11:19:54', NULL),
	(8, 'sdgsdgsdf', 'L', 34, NULL, '346345345345', 'dfgdfgdfg', '2021-10-05 11:21:04', '2021-10-05 11:21:04', NULL),
	(9, 'sdgsdgsdf', 'L', 34, NULL, '346345345345', 'dfgdfgdfg', '2021-10-05 11:21:33', '2021-10-05 11:21:33', NULL),
	(10, 'fdsgdfg', 'L', 23, NULL, '234234234234', 'dfgdfgdfg', '2021-10-05 11:22:59', '2021-10-05 11:22:59', NULL),
	(11, 'Haris', 'L', 29, NULL, '085330067932', 'Jember', '2021-10-05 11:28:31', '2021-10-05 11:28:31', NULL),
	(12, 'Fathor Rosid', 'L', 24, NULL, '081233846841', 'Jl. Raung', '2021-10-05 14:51:18', '2021-10-05 14:51:18', NULL);
/*!40000 ALTER TABLE `pelapor` ENABLE KEYS */;

-- Dumping structure for table dp3akb.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `jabatan` varchar(255) NOT NULL,
  `level` enum('Superadmin','Admin') NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table dp3akb.users: ~3 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id_user`, `fullname`, `email`, `password`, `jabatan`, `level`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'Lorem Ipsum', 'admin@admin.com', '21232f297a57a5a743894a0e4a801fc3', 'Ka. Bidang Keluarga Berencana', 'Superadmin', '2021-09-20 10:13:22', '2021-09-24 14:06:37', NULL),
	(2, 'Lorem Ipsum 2', 'admin2@admin2.com', 'c84258e9c39059a89ab77d846ddab909', 'Ka. Bidang Keluarga Sejahtera', 'Admin', '2021-09-20 10:13:22', '2021-09-27 10:46:43', NULL),
	(5, 'testes', 'testes@gmail.com', '28b662d883b6d76fd96e4ddc5e9ba780', 'hgfhgfh', 'Admin', '2021-09-27 10:47:31', '2021-09-27 10:47:31', NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
