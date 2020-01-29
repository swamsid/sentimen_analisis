-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.36-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table sentimen.data_crawling
DROP TABLE IF EXISTS `data_crawling`;
CREATE TABLE IF NOT EXISTS `data_crawling` (
  `dc_id` int(11) NOT NULL AUTO_INCREMENT,
  `dc_author` varchar(50) NOT NULL,
  `dc_tanggal` varchar(50) NOT NULL,
  `dc_link` varchar(255) NOT NULL,
  `dc_sumber` varchar(255) NOT NULL,
  `dc_inputan` varchar(255) NOT NULL,
  PRIMARY KEY (`dc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

-- Dumping data for table sentimen.data_crawling: ~30 rows (approximately)
/*!40000 ALTER TABLE `data_crawling` DISABLE KEYS */;
REPLACE INTO `data_crawling` (`dc_id`, `dc_author`, `dc_tanggal`, `dc_link`, `dc_sumber`, `dc_inputan`) VALUES
	(1, 'Hendy Alex Roesli', '26 Juli 2019', 'mediakonsumen.com', 'mediakonsumen.com', '1,5 Tahun Menunggu Jaringan Indihome yang Tak Kunjung Usai'),
	(2, 'andika_andika', '23 Juli 2019', 'mediakonsumen.com', 'mediakonsumen.com', 'Status Pasang Baru Indihome Tidak Jelas karena ODP Penuh'),
	(3, 'pardo frans', '18 Juli 2019', 'mediakonsumen.com', 'mediakonsumen.com', 'Kurang Paham dengan Sistem Tagihan Indihome Karena Harus Selalu Dikomplain'),
	(4, '31', '16 Juli 2019', 'mediakonsumen.com', 'mediakonsumen.com', 'Laporan Kerusakan Indihome Tidak Kunjung Diperbaiki'),
	(5, 'Fandri', '6 Juli 2019', 'mediakonsumen.com', 'mediakonsumen.com', 'Tagihan Telkom Indihome Dua Kali Dinaikkan Secara Sepihak'),
	(6, 'Ade Faldy', '2 Juli 2019', 'mediakonsumen.com', 'mediakonsumen.com', 'Kendala Pasang Baru Indihome karena ODP Penuh???'),
	(7, 'Kaware Ita', '30 Juni 2019', 'mediakonsumen.com', 'mediakonsumen.com', 'Indihome Sangat Merugikan Pelanggan, Permohonan Pencabutan sejak April Belum Diproses'),
	(8, 'Suriyanto', '27 Juni 2019', 'mediakonsumen.com', 'mediakonsumen.com', 'Kecewa Lambannya Penanganan Keluhan Indihome Telkom'),
	(9, 'Mochamad Wiby Erton Firmanda', '20 Juni 2019', 'mediakonsumen.com', 'mediakonsumen.com', 'Pemasangan Indihome Sudah Selesai Tetapi Belum Bisa Aktif Internetnya'),
	(10, 'pardo frans', '12 Juni 2019', 'mediakonsumen.com', 'mediakonsumen.com', 'Tagihan Indihome Mei dan Juni 2019 Meningkat Mantap'),
	(11, '@tamaraylnd_', '30 Mei', 'twitter.com', 'twitter.com', 'INDIHOME GANGGUAN LAGI YA'),
	(12, '@X1APASI', '30 Mei', 'twitter.com', 'twitter.com', 'INDIHOME LEMOT BGT NAPASI'),
	(13, '@AjirRcs', '30 Mei', 'twitter.com', 'twitter.com', 'Cari wifi saja! kapan cari wife?â€#RECEHKANTWITER #recehkantwiterjilid2 #indihome #gombalfilsafat'),
	(14, '@Destinasimu', '30 Mei', 'twitter.com', 'twitter.com', 'Ada anak indihome yg bisa liat huntu? Mo nanya'),
	(15, '@cucikolong', '30 Mei', 'twitter.com', 'twitter.com', 'Mati aja lo keong gblk @IndiHome pic.twitter.com/lH7rvkKSa3'),
	(16, '@CantikTamara1', '29 Mei', 'twitter.com', 'twitter.com', 'Kalo mau ngurusin hidup orang jangan setengah setengah dong mas/mbak, sekalian aja bayarin itu cicilan motor,  indovision,  indihome, listrik,  air sama utang di caffe sebelah. pic.twitter.com/K19SMNG9eV'),
	(17, '@Bagas_Pewe', '30 Mei', 'twitter.com', 'twitter.com', 'Apa bener indigo yang kerjaannya dirumah terus, jadinya indihome ?'),
	(18, '@hedwigus', '29 Mei', 'twitter.com', 'twitter.com', 'Teknisi @IndiHome manggil gw "Pak".\n\nTeknisi @xlhomeid manggil gw "Oom".\n\n#asikaja'),
	(19, '@babykoala__', 'Â ', 'twitter.com', 'twitter.com', 'Indihome asuuu. Yahmene sinyale bosok tenan.'),
	(20, '@utisiregar', '30 Mei', 'twitter.com', 'twitter.com', 'Ngadet bgttt. Perbuatan tidak menyenangkan nihh @IndiHome'),
	(21, '@illesebrous', '29 Mei', 'twitter.com', 'twitter.com', 'Selamat hari jadi ya Kak Zui dan cemewewnya. Semoga kalian selalu dilimpahkan kebahagiaan, kesedihan, kesenangan, kebaikan, asal jangan dilimpahkan selingkuhan. Semoga awet sampai indihome berubah jadi indigo. \n\n( @nutellattes & @kwonthedean )pic.twitter.'),
	(22, '@clumsyaphrodite', '28 Mei', 'twitter.com', 'twitter.com', 'Iy aku tau aku norak tp gimana ya buka netflix di hengpong pake indihome????? Udh nganuin vpn dns kok g bs bs y nangis'),
	(23, '@SYAEFULAMSORI21', '29 Mei', 'twitter.com', 'twitter.com', 'Apa kabar indhome ...\nPositif aja mungkin Indihome puasa jadi GK ada tenaga \nTapi kok udah buka masih aja GK ada tenaga Indihome sobat Miramar \n#indihome #erorrpic.twitter.com/Ks3TJpzedp'),
	(24, '@phikoSB', '29 Mei', 'twitter.com', 'twitter.com', 'giliran dah bener tinggal koneksi nya yang down, sh*t lah indihome'),
	(25, '@papahavi', '29 Mei', 'twitter.com', 'twitter.com', 'Saya tunggu kedatangan teknisi hari Kamis tanggal 30 Mei 2019. Tidak perlu repot telp konfirmasi. Besok saya sudah libur kerja. Saya mau tunggu layanan Indihome saya dibenarkan sampai normal. 12 hari sudah tidak ada wifi dan useetv keluarga jadi kacau, ke'),
	(26, '@tanya2rl', '30 Mei', 'twitter.com', 'twitter.com', '[tanyarl] ada yg pernah ngubah sandi indihome? Nyoba di google failed pas dipraktekin. Ini orang2 entah drmn byk banget nyambungin wifi di rumah jd lemot'),
	(27, '@tongtjilap', '30 Mei', 'twitter.com', 'twitter.com', 'Kabar gembira untuk pelanggan Indihome dan Netflix:\n\nNetflix sudah bisa diakses kembali dengan Indihome, lo'),
	(28, '@angelichim95', 'â€', 'twitter.com', 'twitter.com', 'Aduh kamu jadi ngegas gini biar gak keinget setan makanya bilang indihome'),
	(29, '@angelichim95', 'â€', 'twitter.com', 'twitter.com', 'waaa terharu dispesialkan\nserem aku juga pdhl aku bukan anak indihome wkwk gak tau deh perasaan dunia aku ya disini2 aja'),
	(30, '@UseeTVcom', 'Â ', 'twitter.com', 'twitter.com', 'Yuk #Nobar #Liga1 bareng IndiHome besok di Pekan Raya Jakarta Hall-D. Akan ada special performance dari @intansaumadina dan @t10nugroho loh. Jangan sampai kelewatan!pic.twitter.com/KjLKdANnyD');
/*!40000 ALTER TABLE `data_crawling` ENABLE KEYS */;

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
