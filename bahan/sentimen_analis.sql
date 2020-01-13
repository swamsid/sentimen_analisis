-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.3.16-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             10.3.0.5771
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table sentimen.case_folding
DROP TABLE IF EXISTS `case_folding`;
CREATE TABLE IF NOT EXISTS `case_folding` (
  `cf_data` int(11) NOT NULL,
  `cf_case_folding` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`cf_data`),
  CONSTRAINT `FK_case_folding_data_crawling` FOREIGN KEY (`cf_data`) REFERENCES `data_crawling` (`dc_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table sentimen.case_folding: ~10 rows (approximately)
/*!40000 ALTER TABLE `case_folding` DISABLE KEYS */;
REPLACE INTO `case_folding` (`cf_data`, `cf_case_folding`, `created_at`) VALUES
	(1, 'tidak bisa pasang indihome karena odp penuh', '2020-01-13 05:59:57'),
	(2, 'indihome, sudah deposit tapi belum dipasang juga', '2020-01-13 05:59:57'),
	(3, 'sudah 2 pekan indihome offline, kecewa dengan pelayanan indihome', '2020-01-13 05:59:57'),
	(4, 'penambahan item biaya internet content pada tagihan telkom indihome desember 2019 dan januari 2020', '2020-01-13 05:59:57'),
	(5, 'odp penuh indihome', '2020-01-13 05:59:57'),
	(6, '3 bulan bayar tagihan double setelah upgrade speed indihome 10 mbps ke 50 mbps', '2020-01-13 05:59:57'),
	(7, 'laporan gangguan telkom indihome semakin tidak praktis', '2020-01-13 05:59:57'),
	(8, 'kecewa pembayaran indihome melalui shopee', '2020-01-13 05:59:58'),
	(11, 'tagihan indihome tiba-tiba naik hampir dua kali lipat', '2020-01-13 05:59:58'),
	(12, 'tidak bisa pasang indihome, alasan teknisi kurang tiang', '2020-01-13 05:59:58');
/*!40000 ALTER TABLE `case_folding` ENABLE KEYS */;

-- Dumping structure for table sentimen.data_crawling
DROP TABLE IF EXISTS `data_crawling`;
CREATE TABLE IF NOT EXISTS `data_crawling` (
  `dc_id` int(11) NOT NULL AUTO_INCREMENT,
  `dc_post_id` varchar(50) DEFAULT NULL,
  `dc_author` varchar(200) DEFAULT NULL,
  `dc_tanggal` varchar(50) DEFAULT NULL,
  `dc_link` varchar(100) DEFAULT NULL,
  `dc_sumber` varchar(100) DEFAULT NULL,
  `dc_inputan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`dc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- Dumping data for table sentimen.data_crawling: ~10 rows (approximately)
/*!40000 ALTER TABLE `data_crawling` DISABLE KEYS */;
REPLACE INTO `data_crawling` (`dc_id`, `dc_post_id`, `dc_author`, `dc_tanggal`, `dc_link`, `dc_sumber`, `dc_inputan`, `created_at`) VALUES
	(1, 'Mkpost-58925', 'Abdullatif Assalam', '8 Januari 2020', 'mediakonsumen.com', 'mediakonsumen.com', 'Tidak Bisa Pasang IndiHome karena ODP Penuh', '2020-01-09 15:10:41'),
	(2, 'Mkpost-58896', 'annisa sari', '7 Januari 2020', 'mediakonsumen.com', 'mediakonsumen.com', 'IndiHome, Sudah Deposit Tapi Belum Dipasang Juga', '2020-01-09 15:10:41'),
	(3, 'Mkpost-58775', 'Nuri Hanif', '6 Januari 2020', 'mediakonsumen.com', 'mediakonsumen.com', 'Sudah 2 Pekan IndiHome Offline, Kecewa dengan Pelayanan IndiHome', '2020-01-09 15:10:41'),
	(4, 'Mkpost-58737', 'pardo frans', '5 Januari 2020', 'mediakonsumen.com', 'mediakonsumen.com', 'Penambahan Item Biaya Internet Content pada Tagihan Telkom Indihome Desember 2019 Dan Januari 2020', '2020-01-09 15:10:41'),
	(5, 'Mkpost-58689', 'M. Irwan', '4 Januari 2020', 'mediakonsumen.com', 'mediakonsumen.com', 'ODP Penuh IndiHome', '2020-01-09 15:10:41'),
	(6, 'Mkpost-58702', 'tomi_candra', '4 Januari 2020', 'mediakonsumen.com', 'mediakonsumen.com', '3 Bulan Bayar Tagihan Double Setelah Upgrade Speed IndiHome 10 Mbps ke 50 Mbps', '2020-01-09 15:10:41'),
	(7, 'Mkpost-58249', 'pardo frans', '29 Desember 2019', 'mediakonsumen.com', 'mediakonsumen.com', 'Laporan Gangguan Telkom IndiHome Semakin Tidak Praktis', '2020-01-09 15:10:41'),
	(8, 'Mkpost-57990', 'Veri Fadilah Djuhara', '25 Desember 2019', 'mediakonsumen.com', 'mediakonsumen.com', 'Kecewa Pembayaran Indihome melalui Shopee', '2020-01-09 15:10:41'),
	(11, 'Mkpost-57895', 'Dimas Satrya', '22 Desember 2019', 'mediakonsumen.com', 'mediakonsumen.com', 'Tagihan IndiHome Tiba-tiba Naik Hampir Dua Kali Lipat', '2020-01-09 15:31:17'),
	(12, 'Mkpost-57792', 'hasbi_aal', '21 Desember 2019', 'mediakonsumen.com', 'mediakonsumen.com', 'Tidak Bisa Pasang IndiHome, Alasan Teknisi Kurang Tiang', '2020-01-09 15:31:17');
/*!40000 ALTER TABLE `data_crawling` ENABLE KEYS */;

-- Dumping structure for table sentimen.stemmer
DROP TABLE IF EXISTS `stemmer`;
CREATE TABLE IF NOT EXISTS `stemmer` (
  `s_data` int(11) NOT NULL,
  `s_stemmer` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`s_data`),
  CONSTRAINT `FK_stemmer_data_crawling` FOREIGN KEY (`s_data`) REFERENCES `stopword` (`s_data`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table sentimen.stemmer: ~10 rows (approximately)
/*!40000 ALTER TABLE `stemmer` DISABLE KEYS */;
REPLACE INTO `stemmer` (`s_data`, `s_stemmer`, `created_at`) VALUES
	(1, 'tidak|bisa|pasang|indihome|odp|penuh', '2020-01-13 05:59:57'),
	(2, 'indihome|sudah|deposit|tapi|belum|dipasang|juga', '2020-01-13 05:59:57'),
	(3, 'sudah|2|pekan|indihome|offline|kecewa|pelayanan|indihome', '2020-01-13 05:59:57'),
	(4, 'penambahan|item|biaya|internet|content|tagihan|telkom|indihome|desember|2019|januari|2020', '2020-01-13 05:59:57'),
	(5, 'odp|penuh|indihome', '2020-01-13 05:59:57'),
	(6, '3|bulan|bayar|tagihan|double|setelah|upgrade|speed|indihome|10|mbps|50|mbps', '2020-01-13 05:59:57'),
	(7, 'laporan|gangguan|telkom|indihome|semakin|tidak|praktis', '2020-01-13 05:59:57'),
	(8, 'kecewa|pembayaran|indihome|shopee', '2020-01-13 05:59:58'),
	(11, 'tagihan|indihome|tiba-tiba|naik|hampir|dua|kali|lipat', '2020-01-13 05:59:58'),
	(12, 'tidak|bisa|pasang|indihome|alasan|teknisi|kurang|tiang', '2020-01-13 05:59:58');
/*!40000 ALTER TABLE `stemmer` ENABLE KEYS */;

-- Dumping structure for table sentimen.stopword
DROP TABLE IF EXISTS `stopword`;
CREATE TABLE IF NOT EXISTS `stopword` (
  `s_data` int(11) NOT NULL,
  `s_stopword` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`s_data`),
  CONSTRAINT `FK_stopword_data_crawling` FOREIGN KEY (`s_data`) REFERENCES `tokenize` (`t_data`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table sentimen.stopword: ~10 rows (approximately)
/*!40000 ALTER TABLE `stopword` DISABLE KEYS */;
REPLACE INTO `stopword` (`s_data`, `s_stopword`, `created_at`) VALUES
	(1, 'tidak|bisa|pasang|indihome|odp|penuh', '2020-01-13 05:59:57'),
	(2, 'indihome|,|sudah|deposit|tapi|belum|dipasang|juga', '2020-01-13 05:59:57'),
	(3, 'sudah|2|pekan|indihome|offline|,|kecewa|pelayanan|indihome', '2020-01-13 05:59:57'),
	(4, 'penambahan|item|biaya|internet|content|tagihan|telkom|indihome|desember|2019|januari|2020', '2020-01-13 05:59:57'),
	(5, 'odp|penuh|indihome', '2020-01-13 05:59:57'),
	(6, '3|bulan|bayar|tagihan|double|setelah|upgrade|speed|indihome|10|mbps|50|mbps', '2020-01-13 05:59:57'),
	(7, 'laporan|gangguan|telkom|indihome|semakin|tidak|praktis', '2020-01-13 05:59:57'),
	(8, 'kecewa|pembayaran|indihome|shopee', '2020-01-13 05:59:58'),
	(11, 'tagihan|indihome|tiba-tiba|naik|hampir|dua|kali|lipat', '2020-01-13 05:59:58'),
	(12, 'tidak|bisa|pasang|indihome|,|alasan|teknisi|kurang|tiang', '2020-01-13 05:59:58');
/*!40000 ALTER TABLE `stopword` ENABLE KEYS */;

-- Dumping structure for table sentimen.tokenize
DROP TABLE IF EXISTS `tokenize`;
CREATE TABLE IF NOT EXISTS `tokenize` (
  `t_data` int(11) NOT NULL,
  `t_tokenize` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`t_data`),
  CONSTRAINT `FK_tokenize_data_crawling` FOREIGN KEY (`t_data`) REFERENCES `case_folding` (`cf_data`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table sentimen.tokenize: ~10 rows (approximately)
/*!40000 ALTER TABLE `tokenize` DISABLE KEYS */;
REPLACE INTO `tokenize` (`t_data`, `t_tokenize`, `created_at`) VALUES
	(1, 'tidak|bisa|pasang|indihome|karena|odp|penuh', '2020-01-13 05:59:57'),
	(2, 'indihome|,|sudah|deposit|tapi|belum|dipasang|juga', '2020-01-13 05:59:57'),
	(3, 'sudah|2|pekan|indihome|offline|,|kecewa|dengan|pelayanan|indihome', '2020-01-13 05:59:57'),
	(4, 'penambahan|item|biaya|internet|content|pada|tagihan|telkom|indihome|desember|2019|dan|januari|2020', '2020-01-13 05:59:57'),
	(5, 'odp|penuh|indihome', '2020-01-13 05:59:57'),
	(6, '3|bulan|bayar|tagihan|double|setelah|upgrade|speed|indihome|10|mbps|ke|50|mbps', '2020-01-13 05:59:57'),
	(7, 'laporan|gangguan|telkom|indihome|semakin|tidak|praktis', '2020-01-13 05:59:57'),
	(8, 'kecewa|pembayaran|indihome|melalui|shopee', '2020-01-13 05:59:58'),
	(11, 'tagihan|indihome|tiba-tiba|naik|hampir|dua|kali|lipat', '2020-01-13 05:59:58'),
	(12, 'tidak|bisa|pasang|indihome|,|alasan|teknisi|kurang|tiang', '2020-01-13 05:59:58');
/*!40000 ALTER TABLE `tokenize` ENABLE KEYS */;

-- Dumping structure for table sentimen.user
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `us_id` int(11) NOT NULL AUTO_INCREMENT,
  `us_username` varchar(255) DEFAULT NULL,
  `us_password` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`us_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table sentimen.user: ~0 rows (approximately)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
REPLACE INTO `user` (`us_id`, `us_username`, `us_password`) VALUES
	(1, 'admin', '123456');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
