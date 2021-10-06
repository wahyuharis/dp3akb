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
  PRIMARY KEY (`id_korban`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table dp3akb.korban: ~0 rows (approximately)
/*!40000 ALTER TABLE `korban` DISABLE KEYS */;
/*!40000 ALTER TABLE `korban` ENABLE KEYS */;

-- Dumping structure for table dp3akb.pelapor
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

-- Dumping data for table dp3akb.pelapor: ~0 rows (approximately)
/*!40000 ALTER TABLE `pelapor` DISABLE KEYS */;
/*!40000 ALTER TABLE `pelapor` ENABLE KEYS */;

-- Dumping structure for table dp3akb.users
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
