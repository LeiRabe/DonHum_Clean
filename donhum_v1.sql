-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 27, 2021 at 04:26 AM
-- Server version: 8.0.25-0ubuntu0.20.04.1
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `donhum_v1`
--

-- --------------------------------------------------------

--
-- Table structure for table `association`
--

CREATE TABLE `association` (
  `idAsso` int NOT NULL,
  `emailAsso` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `mdpAsso` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `numTelAsso` varchar(10) NOT NULL,
  `descAsso` longtext NOT NULL,
  `nomAsso` varchar(200) NOT NULL,
  `RNA` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `besoin`
--

CREATE TABLE `besoin` (
  `idBesoin` int NOT NULL,
  `idAsso` int NOT NULL,
  `articleName` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `articleQuantite` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `particulier`
--

CREATE TABLE `particulier` (
  `idPar` int NOT NULL,
  `emailPar` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `numTelPar` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `mdpPar` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `descPar` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `nomPar` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `prenomPar` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `cptDmd` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci COMMENT='This table host the Particulier data';

-- --------------------------------------------------------

--
-- Table structure for table `produit`
--

CREATE TABLE `produit` (
  `productID` int NOT NULL,
  `idPar` int NOT NULL,
  `productImage` varchar(255) NOT NULL,
  `productName` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `productDesc` tinytext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `productKeywords` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `productValidite` int NOT NULL DEFAULT '0',
  `productOwnerType` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `productNewOwnerID` int DEFAULT NULL,
  `productBesoinID` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `association`
--
ALTER TABLE `association`
  ADD PRIMARY KEY (`idAsso`);

--
-- Indexes for table `besoin`
--
ALTER TABLE `besoin`
  ADD PRIMARY KEY (`idBesoin`),
  ADD KEY `idAsso` (`idAsso`);

--
-- Indexes for table `particulier`
--
ALTER TABLE `particulier`
  ADD PRIMARY KEY (`idPar`);

--
-- Indexes for table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`productID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `association`
--
ALTER TABLE `association`
  MODIFY `idAsso` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `besoin`
--
ALTER TABLE `besoin`
  MODIFY `idBesoin` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `particulier`
--
ALTER TABLE `particulier`
  MODIFY `idPar` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `produit`
--
ALTER TABLE `produit`
  MODIFY `productID` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `besoin`
--
ALTER TABLE `besoin`
  ADD CONSTRAINT `idAsso` FOREIGN KEY (`idAsso`) REFERENCES `association` (`idAsso`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
