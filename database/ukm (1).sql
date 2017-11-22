-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 15, 2017 at 11:05 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ukm`
--

-- --------------------------------------------------------

--
-- Table structure for table `misi`
--

CREATE TABLE IF NOT EXISTS `misi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `urutan` int(11) NOT NULL,
  `misi` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `misi01`
--

CREATE TABLE IF NOT EXISTS `misi01` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `urutan` int(11) NOT NULL,
  `misi` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `misi01`
--

INSERT INTO `misi01` (`id`, `urutan`, `misi`) VALUES
(1, 1, 'Menambah produk makanan olahan tradisonal yang dikemas secara modern menjadi alternatif untuk oleh oleh dari kota Depok'),
(2, 2, 'Meningkatkan pendapatan masyarakat sekitar'),
(3, 3, 'Memberikan alternatif pilihan makanan/camilan yang sehat, unik tapi enak'),
(4, 4, 'Memberikan kontribusi bagi pembangunan kota Depok yang mempunyai misi Depok Sahabat UKM'),
(5, 5, 'Menjadi perusahaan yang diperhitungkan di kancah Nasional dan mengharumkan nama Depok');

-- --------------------------------------------------------

--
-- Table structure for table `misi02`
--

CREATE TABLE IF NOT EXISTS `misi02` (
  `id` int(11) NOT NULL DEFAULT '0',
  `urutan` int(11) NOT NULL,
  `misi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pengiriman`
--

CREATE TABLE IF NOT EXISTS `pengiriman` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iduser` int(11) NOT NULL,
  `nama_alamat` varchar(50) NOT NULL,
  `nama_penerima` varchar(100) NOT NULL,
  `no_telepon` varchar(20) NOT NULL,
  `alamat_lengkap` varchar(500) NOT NULL,
  `provinsi` varchar(50) NOT NULL,
  `kota` varchar(50) NOT NULL,
  `kecamatan` varchar(50) NOT NULL,
  `kode_pos` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE IF NOT EXISTS `produk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `produk` text NOT NULL,
  `deskripsi` text NOT NULL,
  `image` text NOT NULL,
  `hargalama` int(11) NOT NULL,
  `hargabaru` int(11) NOT NULL,
  `updateharga_at` date NOT NULL,
  `insert_at` date NOT NULL,
  `update_at` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `produk01`
--

CREATE TABLE IF NOT EXISTS `produk01` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `produk` text NOT NULL,
  `deskripsi` text NOT NULL,
  `image` text NOT NULL,
  `hargalama` int(11) NOT NULL,
  `hargabaru` int(11) DEFAULT NULL,
  `updateharga_at` date DEFAULT NULL,
  `insert_at` date NOT NULL,
  `update_at` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `produk01`
--

INSERT INTO `produk01` (`id`, `produk`, `deskripsi`, `image`, `hargalama`, `hargabaru`, `updateharga_at`, `insert_at`, `update_at`) VALUES
(1, 'Original', 'Tempe Cokelat Original', '../image/01/produk/product1.jpeg', 15000, 15000, NULL, '2017-09-14', NULL),
(2, 'Wijen', 'Tempe Cokelat Wijen', '../image/01/produk/product2.jpeg', 15000, 15000, NULL, '2017-09-14', NULL),
(3, 'Green Tea', 'Tempe Cokelat Green Tea', '../image/01/produk/product3.jpeg', 15000, 15000, NULL, '2017-09-14', NULL),
(4, 'Madu', 'Tempe Cokelat Madu', '../image/01/produk/product4.jpeg', 15000, 15000, NULL, '2017-09-14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `produk02`
--

CREATE TABLE IF NOT EXISTS `produk02` (
  `id` int(11) NOT NULL DEFAULT '0',
  `produk` text NOT NULL,
  `deskripsi` text NOT NULL,
  `image` text NOT NULL,
  `hargalama` int(11) NOT NULL,
  `hargabaru` int(11) NOT NULL,
  `updateharga_at` date NOT NULL,
  `insert_at` date NOT NULL,
  `update_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sejarah`
--

CREATE TABLE IF NOT EXISTS `sejarah` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `urutan` int(11) NOT NULL,
  `sejarah` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sejarah01`
--

CREATE TABLE IF NOT EXISTS `sejarah01` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `urutan` int(11) NOT NULL,
  `sejarah` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `sejarah01`
--

INSERT INTO `sejarah01` (`id`, `urutan`, `sejarah`) VALUES
(1, 1, 'Pada februari 2014 berawal dari keinginan pemilik UKM untuk mempunyai produk khas depok sebagai oleh-oleh yang dapat dibawa ke berbagai daerah.'),
(2, 2, 'Dibuatlah produk pertama dengan nama PeChoc, makanan unik perpaduan antara tempe dan cokelat, sebagai oleh oleh kota Depok.'),
(3, 3, 'Setelah 1 tahun produksi, maka dibentuklah sebuah badan usaha berbentuk cv dengan nama CV. Munafood pada tanggal 25 Desember 2015, beralamatkan di komp poinmas blok F2 no 20 B Kel. Rangkapan Jaya Kec. Pancoran Mas Kota Depok 16435.'),
(4, 4, 'Produk yang dihasilkan pun mulai beragam, diantaranya : Tempe Cokelat PeChoc, Keripik Tempe Sagu, Peyek Mini, Aneka Roti Manis Isi, dan Fancy Stick.'),
(5, 5, 'Pemasaran produk CV. Munafood melalui jaringan online maupun offline. Untuk penjualan offline, saat ini sudah ada 5 tenant toko oleh oleh yang menjual produk CV. Munafood dengan sistem konsinyasi. Sedangkan untuk penjualan online melalui sarana jejaring sosial seperti Facebook, WhatsApps, dan Instagram.');

-- --------------------------------------------------------

--
-- Table structure for table `sejarah02`
--

CREATE TABLE IF NOT EXISTS `sejarah02` (
  `id` int(11) NOT NULL DEFAULT '0',
  `urutan` int(11) NOT NULL,
  `sejarah` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ukm`
--

CREATE TABLE IF NOT EXISTS `ukm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `headercolor` text NOT NULL,
  `contentcolor` text NOT NULL,
  `footercolor` text NOT NULL,
  `logo` text NOT NULL,
  `alamat` text NOT NULL,
  `visi` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `ukm`
--

INSERT INTO `ukm` (`id`, `name`, `headercolor`, `contentcolor`, `footercolor`, `logo`, `alamat`, `visi`) VALUES
(1, 'CV. Munafood', '#034f84', '#034f84', '#034f84', '..\\image\\01\\logo\\logo01.jpg\r\n', 'Komp Poinmas Blok F2 No 20 B<br/>Kel. Rangkapan Jaya<br>Kec. Pancoran Mas <br/>Kota Depok 16435', 'Makanan sehat, masyarakat sehat, bangsa kuat');

-- --------------------------------------------------------

--
-- Table structure for table `users01`
--

CREATE TABLE IF NOT EXISTS `users01` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `users01`
--

INSERT INTO `users01` (`id`, `email`, `name`, `password`) VALUES
(1, 'aaa@aaa.com', 'aaa aaa', '47bce5c74f589f4867dbd57e9ca9f808'),
(2, 'sss@sss.sss', 'sss', '9f6e6800cfae7749eb6c486619254b9c'),
(4, 'ddd@ddd.ddd', 'ddd ddd', '77963b7a931377ad4ab5ad6a9cd718aa'),
(5, 'william@gmail.com', 'William Wijaya', 'fd820a2b4461bddd116c1518bc4b0f77');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
