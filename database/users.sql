-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 22, 2017 at 10:58 AM
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
  `hash` varchar(50) NOT NULL,
  `validtime` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `email`, `name`, `no_hp`, `password`, `status`, `hash`, `validtime`) VALUES
(1, 0, 'aaa@aaa.com', 'aaa aaa', NULL, '47bce5c74f589f4867dbd57e9ca9f808', '', '', 0),
(2, 0, 'sss@sss.sss', 'sss', NULL, '9f6e6800cfae7749eb6c486619254b9c', '', '', 0),
(4, 0, 'ddd@ddd.ddd', 'ddd ddd', NULL, '77963b7a931377ad4ab5ad6a9cd718aa', '', '', 0),
(5, 0, 'william@gmail.com', 'William Wijaya', NULL, 'fd820a2b4461bddd116c1518bc4b0f77', '', '', 0),
(6, 1, 'gprajena@binus.edu', 'gredion', NULL, '0cc175b9c0f1b6a831c399e269772661', 'active', '5e388103a391daabe3de1d76a6739ccd', 0),
(8, 1, 'dadrianto@binus.edu', 'dennise', NULL, '0cc175b9c0f1b6a831c399e269772661', 'active', '838ad3dec50e480b2159b2e0155fe25c', 221521),
(9, 2, 'admin@munafood.com', 'admin', NULL, '0cc175b9c0f1b6a831c399e269772661', 'active', '', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
