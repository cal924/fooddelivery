-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 07, 2016 at 08:05 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `delivery`
--

-- --------------------------------------------------------

--
-- Table structure for table `noodleorder`
--

CREATE TABLE `noodleorder` (
  `id` int(11) NOT NULL,
  `name` varchar(200) CHARACTER SET utf16 COLLATE utf16_bin DEFAULT '',
  `createDate` datetime DEFAULT CURRENT_TIMESTAMP,
  `createip` varchar(100) DEFAULT NULL,
  `cxl` int(11) DEFAULT '0',
  `cxlDate` datetime DEFAULT '1900-01-01 00:00:00',
  `cxlip` varchar(1000) DEFAULT NULL,
  `soup` varchar(100) CHARACTER SET utf16 COLLATE utf16_bin DEFAULT '',
  `noodle` varchar(100) CHARACTER SET utf16 COLLATE utf16_bin DEFAULT '',
  `extra` int(11) DEFAULT '0',
  `food1` varchar(100) CHARACTER SET utf16 COLLATE utf16_bin DEFAULT '',
  `food2` varchar(100) CHARACTER SET utf16 COLLATE utf16_bin DEFAULT '',
  `food3` varchar(100) CHARACTER SET utf16 COLLATE utf16_bin DEFAULT '',
  `food4` varchar(100) CHARACTER SET utf16 COLLATE utf16_bin DEFAULT '',
  `remarks` varchar(1000) CHARACTER SET utf16 COLLATE utf16_bin DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `noodleorder`
--
ALTER TABLE `noodleorder`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `noodleorder`
--
ALTER TABLE `noodleorder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
