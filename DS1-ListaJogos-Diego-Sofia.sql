-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2023 at 04:00 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ds1-listajogos-diego-sofia`
--

-- --------------------------------------------------------

--
-- Table structure for table `cartuchos`
--

CREATE TABLE `cartuchos` (
  `userID` int(11) NOT NULL,
  `gameID` int(11) NOT NULL,
  `titulo` text NOT NULL,
  `sistema` int(11) DEFAULT NULL,
  `ano` year(4) NOT NULL,
  `empresa` text NOT NULL,
  `imgpath` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `historicoderemocao`
--

CREATE TABLE `historicoderemocao` (
  `deletionUserID` int(11) NOT NULL,
  `gameUserID` int(11) NOT NULL,
  `gameID` int(11) NOT NULL,
  `titulo` text NOT NULL,
  `sistema` text DEFAULT NULL,
  `ano` year(4) NOT NULL,
  `empresa` text NOT NULL,
  `dataremocao` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sistemas`
--

CREATE TABLE `sistemas` (
  `id` int(11) NOT NULL,
  `nome` text NOT NULL,
  `fabricante` text NOT NULL,
  `ano` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `admin`) VALUES
(1, 'admin', 'admin@mail.com', '$2y$10$05C4JMUNfv6Qzse3k6V0aeR7JlwhJ810VLyd78AoD2WPIvuY7P0Q2', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cartuchos`
--
ALTER TABLE `cartuchos`
  ADD PRIMARY KEY (`gameID`),
  ADD KEY `userID` (`userID`),
  ADD KEY `sistema` (`sistema`);

--
-- Indexes for table `historicoderemocao`
--
ALTER TABLE `historicoderemocao`
  ADD PRIMARY KEY (`gameID`);

--
-- Indexes for table `sistemas`
--
ALTER TABLE `sistemas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`) USING HASH;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cartuchos`
--
ALTER TABLE `cartuchos`
  MODIFY `gameID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `sistemas`
--
ALTER TABLE `sistemas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cartuchos`
--
ALTER TABLE `cartuchos`
  ADD CONSTRAINT `cartuchos_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cartuchos_ibfk_2` FOREIGN KEY (`sistema`) REFERENCES `sistemas` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
