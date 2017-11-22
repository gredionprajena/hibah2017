-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 08, 2017 at 11:23 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ukm`
--
CREATE DATABASE IF NOT EXISTS `ukm` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `ukm`;

-- --------------------------------------------------------

--
-- Table structure for table `konsinyasi`
--

DROP TABLE IF EXISTS `konsinyasi`;
CREATE TABLE `konsinyasi` (
  `id` int(11) NOT NULL,
  `idToko` text NOT NULL,
  `idProduct` text NOT NULL,
  `jumlahKirim` int(11) NOT NULL,
  `hargaKirim` text NOT NULL,
  `tanggalKirim` date NOT NULL,
  `jumlahKembali` int(11) NOT NULL,
  `tanggalKembali` date NOT NULL,
  `insert_at` date NOT NULL,
  `update_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `konsinyasi`
--

INSERT INTO `konsinyasi` (`id`, `idToko`, `idProduct`, `jumlahKirim`, `hargaKirim`, `tanggalKirim`, `jumlahKembali`, `tanggalKembali`, `insert_at`, `update_at`) VALUES
(1, '3', '1', 0, '15000', '2017-11-08', 0, '0000-00-00', '2017-11-08', '2017-11-08'),
(4, '3', '2', 0, '15000', '2017-11-08', 0, '0000-00-00', '2017-11-08', '2017-11-08'),
(5, '3', '3', 0, '15000', '2017-11-08', 0, '0000-00-00', '2017-11-08', '2017-11-08'),
(6, '3', '4', 0, '15000', '2017-11-08', 0, '0000-00-00', '2017-11-08', '2017-11-08');

-- --------------------------------------------------------

--
-- Table structure for table `misi`
--

DROP TABLE IF EXISTS `misi`;
CREATE TABLE `misi` (
  `id` int(11) NOT NULL,
  `urutan` int(11) NOT NULL,
  `misi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `misi01`
--

DROP TABLE IF EXISTS `misi01`;
CREATE TABLE `misi01` (
  `id` int(11) NOT NULL,
  `urutan` int(11) NOT NULL,
  `misi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

DROP TABLE IF EXISTS `misi02`;
CREATE TABLE `misi02` (
  `id` int(11) NOT NULL DEFAULT '0',
  `urutan` int(11) NOT NULL,
  `misi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pengiriman`
--

DROP TABLE IF EXISTS `pengiriman`;
CREATE TABLE `pengiriman` (
  `id` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `nama_alamat` varchar(50) NOT NULL,
  `nama_penerima` varchar(100) NOT NULL,
  `no_telepon` varchar(20) NOT NULL,
  `alamat_lengkap` varchar(500) NOT NULL,
  `provinsi` varchar(50) NOT NULL,
  `kota` varchar(50) NOT NULL,
  `kecamatan` varchar(50) NOT NULL,
  `kode_pos` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

DROP TABLE IF EXISTS `produk`;
CREATE TABLE `produk` (
  `id` int(11) NOT NULL,
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
-- Table structure for table `produk01`
--

DROP TABLE IF EXISTS `produk01`;
CREATE TABLE `produk01` (
  `id` int(11) NOT NULL,
  `produk` text NOT NULL,
  `deskripsi` text NOT NULL,
  `image` text NOT NULL,
  `hargalama` int(11) NOT NULL,
  `beratlama` float NOT NULL,
  `hargabaru` int(11) DEFAULT NULL,
  `beratbaru` float NOT NULL,
  `updateharga_at` date DEFAULT NULL,
  `insert_at` date NOT NULL,
  `update_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `produk01`
--

INSERT INTO `produk01` (`id`, `produk`, `deskripsi`, `image`, `hargalama`, `beratlama`, `hargabaru`, `beratbaru`, `updateharga_at`, `insert_at`, `update_at`) VALUES
(1, 'Original', 'Tempe Cokelat Original', 'image/01/produk/product1.jpeg', 15000, 0, 15000, 1, NULL, '2017-09-14', NULL),
(2, 'Wijen', 'Tempe Cokelat Wijen', 'image/01/produk/product2.jpeg', 15000, 0, 15000, 1.1, NULL, '2017-09-14', NULL),
(3, 'Green Tea', 'Tempe Cokelat Green Tea', 'image/01/produk/product3.jpeg', 15000, 0, 15000, 1, NULL, '2017-09-14', NULL),
(4, 'Madu', 'Tempe Cokelat Madu', 'image/01/produk/product4.jpeg', 15000, 0, 15000, 1, NULL, '2017-09-14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `produk02`
--

DROP TABLE IF EXISTS `produk02`;
CREATE TABLE `produk02` (
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

DROP TABLE IF EXISTS `sejarah`;
CREATE TABLE `sejarah` (
  `id` int(11) NOT NULL,
  `urutan` int(11) NOT NULL,
  `sejarah` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sejarah01`
--

DROP TABLE IF EXISTS `sejarah01`;
CREATE TABLE `sejarah01` (
  `id` int(11) NOT NULL,
  `urutan` int(11) NOT NULL,
  `sejarah` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

DROP TABLE IF EXISTS `sejarah02`;
CREATE TABLE `sejarah02` (
  `id` int(11) NOT NULL DEFAULT '0',
  `urutan` int(11) NOT NULL,
  `sejarah` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `toko01`
--

DROP TABLE IF EXISTS `toko01`;
CREATE TABLE `toko01` (
  `id` int(11) NOT NULL,
  `toko` text NOT NULL,
  `alamatToko` text NOT NULL,
  `image` text NOT NULL,
  `insert_at` date NOT NULL,
  `update_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `toko01`
--

INSERT INTO `toko01` (`id`, `toko`, `alamatToko`, `image`, `insert_at`, `update_at`) VALUES
(3, 'Makmur', 'Kompleks Maba Indah', '/image/01/toko/toko5a02b577441b6.png', '2017-11-08', '2017-11-08');

-- --------------------------------------------------------

--
-- Table structure for table `ukm`
--

DROP TABLE IF EXISTS `ukm`;
CREATE TABLE `ukm` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `headercolor` text NOT NULL,
  `contentcolor` text NOT NULL,
  `footercolor` text NOT NULL,
  `logo` text NOT NULL,
  `alamat` text NOT NULL,
  `visi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ukm`
--

INSERT INTO `ukm` (`id`, `name`, `headercolor`, `contentcolor`, `footercolor`, `logo`, `alamat`, `visi`) VALUES
(1, 'CV. Munafood', '#034f84', '#034f84', '#034f84', 'image\\01\\logo\\logo01.jpg\r\n', 'Komp Poinmas Blok F2 No 20 B<br/>Kel. Rangkapan Jaya<br>Kec. Pancoran Mas <br/>Kota Depok 16435', 'Makanan sehat, masyarakat sehat, bangsa kuat');

-- --------------------------------------------------------

--
-- Table structure for table `users01`
--

DROP TABLE IF EXISTS `users01`;
CREATE TABLE `users01` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `status` varchar(20) NOT NULL,
  `hash` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users01`
--

INSERT INTO `users01` (`id`, `email`, `name`, `password`, `status`, `hash`) VALUES
(1, 'aaa@aaa.com', 'aaa aaa', '47bce5c74f589f4867dbd57e9ca9f808', '', ''),
(2, 'sss@sss.sss', 'sss', '9f6e6800cfae7749eb6c486619254b9c', '', ''),
(4, 'ddd@ddd.ddd', 'ddd ddd', '77963b7a931377ad4ab5ad6a9cd718aa', '', ''),
(5, 'william@gmail.com', 'William Wijaya', 'fd820a2b4461bddd116c1518bc4b0f77', '', ''),
(6, 'gprajena@binus.edu', 'gredion', '0cc175b9c0f1b6a831c399e269772661', 'active', '5e388103a391daabe3de1d76a6739ccd'),
(8, 'adrianto.dennise@yahoo.com', 'asdadsa', 'c3ec0f7b054e729c5a716c8125839829', 'active', '07cdfd23373b17c6b337251c22b7ea57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `konsinyasi`
--
ALTER TABLE `konsinyasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `misi`
--
ALTER TABLE `misi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `misi01`
--
ALTER TABLE `misi01`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengiriman`
--
ALTER TABLE `pengiriman`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produk01`
--
ALTER TABLE `produk01`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sejarah`
--
ALTER TABLE `sejarah`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sejarah01`
--
ALTER TABLE `sejarah01`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `toko01`
--
ALTER TABLE `toko01`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ukm`
--
ALTER TABLE `ukm`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users01`
--
ALTER TABLE `users01`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `konsinyasi`
--
ALTER TABLE `konsinyasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `misi`
--
ALTER TABLE `misi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `misi01`
--
ALTER TABLE `misi01`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `pengiriman`
--
ALTER TABLE `pengiriman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `produk01`
--
ALTER TABLE `produk01`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `sejarah`
--
ALTER TABLE `sejarah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sejarah01`
--
ALTER TABLE `sejarah01`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `toko01`
--
ALTER TABLE `toko01`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `ukm`
--
ALTER TABLE `ukm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users01`
--
ALTER TABLE `users01`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
