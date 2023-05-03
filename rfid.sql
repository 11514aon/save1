-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2023 at 07:04 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rfid`
--

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE `test` (
  `id` int(6) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `time` time(6) NOT NULL,
  `tag` varchar(11) NOT NULL,
  `checkin_type` varchar(11) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trainee`
--

CREATE TABLE `trainee` (
  `id` int(6) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `time` time(6) NOT NULL,
  `tag` varchar(11) NOT NULL,
  `checkin_type` varchar(11) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trainee`
--

INSERT INTO `trainee` (`id`, `date`, `time`, `tag`, `checkin_type`, `name`) VALUES
(7797, '2023-05-03', '11:52:15.753879', '2904606550', 'check-in', 'Preenapa');

-- --------------------------------------------------------

--
-- Table structure for table `trainnee`
--

CREATE TABLE `trainnee` (
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `tag` varchar(11) DEFAULT NULL,
  `checkin_type` varchar(11) DEFAULT NULL,
  `name` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trainnee`
--

INSERT INTO `trainnee` (`date`, `time`, `tag`, `checkin_type`, `name`) VALUES
('2023-04-28', '11:45:35', '0676089268', 'check-in', 'Adtakowit'),
('2023-04-28', '11:45:38', '2903761750', 'check-in', 'Suphakit'),
('2023-04-28', '11:49:18', '0676089268', 'check-in', 'Adtakowit'),
('2023-04-28', '12:55:15', '2903761750', 'check-out', 'Suphakit'),
('0000-00-00', '00:00:00', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `date_2` (`date`,`time`,`tag`),
  ADD KEY `date` (`date`),
  ADD KEY `time` (`time`),
  ADD KEY `tag` (`tag`);

--
-- Indexes for table `trainee`
--
ALTER TABLE `trainee`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `date` (`date`,`time`,`tag`);

--
-- Indexes for table `trainnee`
--
ALTER TABLE `trainnee`
  ADD UNIQUE KEY `date` (`date`,`time`,`tag`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `test`
--
ALTER TABLE `test`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `trainee`
--
ALTER TABLE `trainee`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7799;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
