-- phpMyAdmin SQL Dump
-- version 4.6.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 20, 2017 at 08:52 PM
-- Server version: 5.7.13-log
-- PHP Version: 5.6.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `2048`
--

-- --------------------------------------------------------

--
-- Table structure for table `2048_user`
--

CREATE TABLE `2048_user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `score` int(11) NOT NULL,
  `bestscore` int(11) NOT NULL,
  `size` int(11) NOT NULL,
  `over` varchar(255) NOT NULL DEFAULT 'false',
  `won` varchar(255) NOT NULL DEFAULT 'false',
  `keepPlaying` varchar(255) NOT NULL DEFAULT 'false'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `2048_user`
--

INSERT INTO `2048_user` (`id`, `username`, `score`, `bestscore`, `size`, `over`, `won`, `keepPlaying`) VALUES
(1, 'mohamed', 0, 2732, 8, 'true', 'false', ''),
(2, '', 0, 0, 0, 'false', 'false', 'false');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `2048_user`
--
ALTER TABLE `2048_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `2048_user`
--
ALTER TABLE `2048_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
