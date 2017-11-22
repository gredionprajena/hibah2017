-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2017 at 07:14 AM
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
-- Table structure for table `bank`
--

DROP TABLE IF EXISTS `bank`;
CREATE TABLE `bank` (
  `id` int(11) NOT NULL,
  `urutan` int(11) NOT NULL,
  `nama_bank` text NOT NULL,
  `no_rek` text NOT NULL,
  `pemilik_rek` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bank`
--

INSERT INTO `bank` (`id`, `urutan`, `nama_bank`, `no_rek`, `pemilik_rek`) VALUES
(1, 1, 'Bank Mandiri', '1570002810837', 'Endah Kurnianingsih');

-- --------------------------------------------------------

--
-- Table structure for table `konsinyasi`
--

DROP TABLE IF EXISTS `konsinyasi`;
CREATE TABLE `konsinyasi` (
  `idKonsinyasi` int(11) NOT NULL,
  `idToko` text NOT NULL,
  `idProduct` text NOT NULL,
  `jumlahKirim` int(11) NOT NULL,
  `hargaKirim` text NOT NULL,
  `tanggalKirim` date DEFAULT NULL,
  `jumlahKembali` int(11) NOT NULL,
  `tanggalKembali` date DEFAULT NULL,
  `insert_at` date NOT NULL,
  `update_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `konsinyasi`
--

INSERT INTO `konsinyasi` (`idKonsinyasi`, `idToko`, `idProduct`, `jumlahKirim`, `hargaKirim`, `tanggalKirim`, `jumlahKembali`, `tanggalKembali`, `insert_at`, `update_at`) VALUES
(9, '3', '2', 50, '15000', NULL, 0, NULL, '2017-11-10', '0000-00-00'),
(10, '3', '2', 50, '15000', '2017-11-15', 10, '2017-11-16', '2017-11-15', '2017-11-16');

-- --------------------------------------------------------

--
-- Table structure for table `list_pembayaran`
--

DROP TABLE IF EXISTS `list_pembayaran`;
CREATE TABLE `list_pembayaran` (
  `id` int(11) NOT NULL,
  `kode_pemesanan` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `nama_pemilik_rekening` varchar(50) NOT NULL,
  `jumlah_transfer` int(11) NOT NULL,
  `tanggal` datetime NOT NULL,
  `catatan` varchar(100) DEFAULT NULL,
  `path_bukti` varchar(100) NOT NULL,
  `status_bayar` int(11) DEFAULT NULL,
  `status_check` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `list_pembayaran`
--

INSERT INTO `list_pembayaran` (`id`, `kode_pemesanan`, `email`, `nama_pemilik_rekening`, `jumlah_transfer`, `tanggal`, `catatan`, `path_bukti`, `status_bayar`, `status_check`) VALUES
(1, '171115040024825', 'gprajena@binus.edu', 'gredion', 161655, '2017-11-16 00:00:00', 'a', 'image/01/produk/product1.jpeg', NULL, NULL);

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

--
-- Dumping data for table `misi`
--

INSERT INTO `misi` (`id`, `urutan`, `misi`) VALUES
(1, 1, 'Menambah produk makanan olahan tradisonal yang dikemas secara modern menjadi alternatif untuk oleh oleh dari kota Depok'),
(2, 2, 'Meningkatkan pendapatan masyarakat sekitar'),
(3, 3, 'Memberikan alternatif pilihan makanan/camilan yang sehat, unik tapi enak'),
(4, 4, 'Memberikan kontribusi bagi pembangunan kota Depok yang mempunyai misi Depok Sahabat UKM'),
(5, 5, 'Menjadi perusahaan yang diperhitungkan di kancah Nasional dan mengharumkan nama Depok');

-- --------------------------------------------------------

--
-- Table structure for table `pemesanan`
--

DROP TABLE IF EXISTS `pemesanan`;
CREATE TABLE `pemesanan` (
  `kode_pemesanan` varchar(50) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `nama_penerima` varchar(100) NOT NULL,
  `no_telp` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `alamat_lengkap` varchar(500) NOT NULL,
  `provinsi` varchar(50) NOT NULL,
  `kota` varchar(50) NOT NULL,
  `kode_pos` varchar(10) NOT NULL,
  `jasa_pengiriman` varchar(50) NOT NULL,
  `tipe_pengiriman` varchar(50) NOT NULL,
  `harga_per_kg` int(11) NOT NULL,
  `total_berat` float NOT NULL,
  `total_harga` int(11) NOT NULL,
  `total_ongkir` int(11) NOT NULL,
  `total_bayar` int(11) NOT NULL,
  `status_kirim` varchar(50) NOT NULL,
  `tanggal_kirim` datetime DEFAULT NULL,
  `status_bayar` varchar(50) NOT NULL,
  `tanggal_bayar` datetime DEFAULT NULL,
  `kode_resi` varchar(50) DEFAULT NULL,
  `tanggal_pesan` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pemesanan`
--

INSERT INTO `pemesanan` (`kode_pemesanan`, `id_user`, `nama_penerima`, `no_telp`, `email`, `alamat_lengkap`, `provinsi`, `kota`, `kode_pos`, `jasa_pengiriman`, `tipe_pengiriman`, `harga_per_kg`, `total_berat`, `total_harga`, `total_ongkir`, `total_bayar`, `status_kirim`, `tanggal_kirim`, `status_bayar`, `tanggal_bayar`, `kode_resi`, `tanggal_pesan`) VALUES
('171114133123683', 0, 'rita layona', '0856123123123', 'rlayona@binus.edu', 'jalan kebon jeruk raya no 27', 'DKI Jakarta', 'Jakarta Barat', '11530', 'jne', 'CTC', 0, 0, 75000, 46800, 121800, '0', NULL, '0', NULL, NULL, '2017-11-14 19:31:23'),
('171115035832712', 0, 'dennise', '0817123213123', 'dadrianto@binus.edu', 'jl kebon jeruk raya', 'DKI Jakarta', 'Jakarta Barat', '11530', 'jne', 'CTCYES', 0, 0, 90000, 111600, 201600, '0', NULL, '0', NULL, NULL, '2017-11-15 09:58:32'),
('171115040024825', 6, 'gredion', '085694298664', 'gprajena@binus.edu', 'jalan binus', 'Kalimantan Barat', 'Bengkayang', '12345', 'pos', 'Paket Kilat Khusus', 0, 0, 45000, 116655, 161655, '0', NULL, '0', NULL, NULL, '2017-11-15 10:00:24'),
('171115040024826', 6, 'gredion', '085694298664', 'gprajena@binus.edu', 'jalan binus', 'Kalimantan Barat', 'Bengkayang', '12345', 'pos', 'Paket Kilat Khusus', 0, 0, 45000, 116655, 161655, '0', NULL, '0', NULL, NULL, '2017-11-15 10:00:24'),
('171115040024827', 6, 'gredion', '085694298664', 'gprajena@binus.edu', 'jalan binus', 'Kalimantan Barat', 'Bengkayang', '12345', 'pos', 'Paket Kilat Khusus', 0, 0, 45000, 116655, 161655, '0', NULL, '1', NULL, NULL, '2017-11-15 10:00:24'),
('171115062709629', 0, 'indra', '0813123123213', 'indra.rianto@binus.edu', 'jalan mangga', 'DKI Jakarta', 'Jakarta Selatan', '11530', 'JNE', 'CTCYES', 18000, 6.1, 90000, 109800, 199800, '0', NULL, '0', NULL, NULL, '2017-11-15 12:27:09');

-- --------------------------------------------------------

--
-- Table structure for table `pemesanan_detail`
--

DROP TABLE IF EXISTS `pemesanan_detail`;
CREATE TABLE `pemesanan_detail` (
  `kode_pemesanan` varchar(50) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `berat` float NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pemesanan_detail`
--

INSERT INTO `pemesanan_detail` (`kode_pemesanan`, `id_barang`, `harga`, `berat`, `qty`) VALUES
('171114133123683', 2, 15000, 1.1, 2),
('171114133123683', 4, 15000, 1, 3),
('171115035832712', 2, 15000, 1.1, 2),
('171115035832712', 4, 15000, 1, 4),
('171115040024825', 1, 15000, 1, 5),
('171115040024825', 2, 15000, 1.1, 1),
('171115040024825', 3, 15000, 1, 3),
('171115040024826', 2, 15000, 1.1, 1),
('171115040024826', 3, 15000, 1, 3),
('171115040024827', 2, 15000, 1.1, 1),
('171115040024827', 3, 15000, 1, 3),
('171115062200321', 2, 15000, 1.1, 1),
('171115062200325', 3, 15000, 1, 4);

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
  `beratlama` float NOT NULL,
  `hargabaru` int(11) DEFAULT NULL,
  `beratbaru` float NOT NULL,
  `updateharga_at` date DEFAULT NULL,
  `insert_at` date NOT NULL,
  `update_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `produk`, `deskripsi`, `image`, `hargalama`, `beratlama`, `hargabaru`, `beratbaru`, `updateharga_at`, `insert_at`, `update_at`) VALUES
(1, 'Original', 'Tempe Cokelat Original', 'image/01/produk/product1.jpeg', 15000, 0, 15000, 1, NULL, '2017-09-14', NULL),
(2, 'Wijen', 'Tempe Cokelat Wijen', 'image/01/produk/product2.jpeg', 15000, 0, 15000, 1.1, NULL, '2017-09-14', NULL),
(3, 'Green Tea', 'Tempe Cokelat Green Tea', 'image/01/produk/product3.jpeg', 15000, 0, 15000, 1, NULL, '2017-09-14', NULL),
(4, 'Madu', 'Tempe Cokelat Madu', 'image/01/produk/product4.jpeg', 15000, 0, 15000, 1, NULL, '2017-09-14', NULL);

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

--
-- Dumping data for table `sejarah`
--

INSERT INTO `sejarah` (`id`, `urutan`, `sejarah`) VALUES
(1, 1, 'Pada februari 2014 berawal dari keinginan pemilik UKM untuk mempunyai produk khas depok sebagai oleh-oleh yang dapat dibawa ke berbagai daerah.'),
(2, 2, 'Dibuatlah produk pertama dengan nama PeChoc, makanan unik perpaduan antara tempe dan cokelat, sebagai oleh oleh kota Depok.'),
(3, 3, 'Setelah 1 tahun produksi, maka dibentuklah sebuah badan usaha berbentuk cv dengan nama CV. Munafood pada tanggal 25 Desember 2015, beralamatkan di komp poinmas blok F2 no 20 B Kel. Rangkapan Jaya Kec. Pancoran Mas Kota Depok 16435.'),
(4, 4, 'Produk yang dihasilkan pun mulai beragam, diantaranya : Tempe Cokelat PeChoc, Keripik Tempe Sagu, Peyek Mini, Aneka Roti Manis Isi, dan Fancy Stick.'),
(5, 5, 'Pemasaran produk CV. Munafood melalui jaringan online maupun offline. Untuk penjualan offline, saat ini sudah ada 5 tenant toko oleh oleh yang menjual produk CV. Munafood dengan sistem konsinyasi. Sedangkan untuk penjualan online melalui sarana jejaring sosial seperti Facebook, WhatsApps, dan Instagram.');

-- --------------------------------------------------------

--
-- Table structure for table `toko`
--

DROP TABLE IF EXISTS `toko`;
CREATE TABLE `toko` (
  `id` int(11) NOT NULL,
  `toko` text NOT NULL,
  `alamatToko` text NOT NULL,
  `image` text NOT NULL,
  `insert_at` date NOT NULL,
  `update_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `toko`
--

INSERT INTO `toko` (`id`, `toko`, `alamatToko`, `image`, `insert_at`, `update_at`) VALUES
(3, 'Makmur', 'Kompleks Maba Indah', '/image/01/toko/toko5a0529575704b.png', '2017-11-08', '2017-11-10');

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
(1, 'CV. Munafood', '#034f84', '#034f84', '#034f84', 'image\\01\\logo\\logo01.jpg\n', 'Komp Poinmas Blok F2 No 20 B<br/>Kel. Rangkapan Jaya<br>Kec. Pancoran Mas <br/>Kota Depok 16435', 'Makanan sehat, masyarakat sehat, bangsa kuat');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `no_hp` varchar(50) DEFAULT NULL,
  `password` varchar(50) NOT NULL,
  `status` varchar(20) NOT NULL,
  `hash` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `email`, `name`, `no_hp`, `password`, `status`, `hash`) VALUES
(1, 0, 'aaa@aaa.com', 'aaa aaa', NULL, '47bce5c74f589f4867dbd57e9ca9f808', '', ''),
(2, 0, 'sss@sss.sss', 'sss', NULL, '9f6e6800cfae7749eb6c486619254b9c', '', ''),
(4, 0, 'ddd@ddd.ddd', 'ddd ddd', NULL, '77963b7a931377ad4ab5ad6a9cd718aa', '', ''),
(5, 0, 'william@gmail.com', 'William Wijaya', NULL, 'fd820a2b4461bddd116c1518bc4b0f77', '', ''),
(6, 1, 'gprajena@binus.edu', 'gredion', NULL, '0cc175b9c0f1b6a831c399e269772661', 'active', '5e388103a391daabe3de1d76a6739ccd'),
(8, 1, 'dadrianto@binus.edu', 'dennise', NULL, '0cc175b9c0f1b6a831c399e269772661', 'active', '07cdfd23373b17c6b337251c22b7ea57'),
(9, 2, 'admin@munafood.com', 'admin', NULL, '0cc175b9c0f1b6a831c399e269772661', 'active', '07cdfd23373b17c6b337251c22b7ea57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bank`
--
ALTER TABLE `bank`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `konsinyasi`
--
ALTER TABLE `konsinyasi`
  ADD PRIMARY KEY (`idKonsinyasi`);

--
-- Indexes for table `list_pembayaran`
--
ALTER TABLE `list_pembayaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `misi`
--
ALTER TABLE `misi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD PRIMARY KEY (`kode_pemesanan`);

--
-- Indexes for table `pemesanan_detail`
--
ALTER TABLE `pemesanan_detail`
  ADD PRIMARY KEY (`kode_pemesanan`,`id_barang`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sejarah`
--
ALTER TABLE `sejarah`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `toko`
--
ALTER TABLE `toko`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ukm`
--
ALTER TABLE `ukm`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bank`
--
ALTER TABLE `bank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `konsinyasi`
--
ALTER TABLE `konsinyasi`
  MODIFY `idKonsinyasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `list_pembayaran`
--
ALTER TABLE `list_pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `misi`
--
ALTER TABLE `misi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `sejarah`
--
ALTER TABLE `sejarah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `toko`
--
ALTER TABLE `toko`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `ukm`
--
ALTER TABLE `ukm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
