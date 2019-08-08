-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 08, 2019 at 12:48 AM
-- Server version: 5.7.21
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `evipod`
--
CREATE DATABASE IF NOT EXISTS `evipod` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `evipod`;

-- --------------------------------------------------------

--
-- Table structure for table `business`
--

DROP TABLE IF EXISTS `business`;
CREATE TABLE IF NOT EXISTS `business` (
  `business_id` int(11) NOT NULL AUTO_INCREMENT,
  `business_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `business_owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_oib` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_mibpg` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_county` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_post` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_tel` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_mob` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`business_id`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `business`
--

INSERT INTO `business` (`business_id`, `business_name`, `user_id`, `business_owner`, `business_oib`, `business_mibpg`, `business_county`, `business_location`, `business_post`, `business_address`, `business_email`, `business_tel`, `business_mob`, `created_at`, `updated_at`) VALUES
(48, 'Test 1', 17, 'Djed Mraz', '12345678901', '1234567', 'Medimurje', 'Domasinec', '40318', 'Selska 41', 'test@test.com', '911', '098911', '2019-07-05 18:52:47', '2019-07-05 18:52:47'),
(49, 'Test 2', 17, 'Macho Orach', '10000000000', '6969696', 'Zagorje', 'Kamenjara', '10101', 'Sumska 99', 'seljak@test.com', '555100', '099199000', '2019-07-05 18:54:48', '2019-08-07 23:29:13'),
(50, 'Test 3', 17, 'Vrijeme', '', '', '', '', '', '', '', '', '', '2019-07-05 21:01:55', '2019-07-05 21:01:55'),
(55, 'sfsdfsdfadasda1', 17, '', '', '', 'afjbfiawiabhifahsfauigsduipgasdigaisdauisgyduaigysduagvsduavsduagsduhavbsduhvausdagdouiawgyduagywduagwuodgyuaolgy', '', '', '', '', '0718128596203722704284674073240596279441761014487880794533553230907265813352151627929174204537135764', '0718128596203722704284674073240596279441761014487880794533553230907265813352151627929174204537135764', '2019-08-03 00:45:38', '2019-08-07 23:25:35'),
(56, 'OPG 1', 30, 'Tester 2', '', '', '', '', '', '', '', '', '', '2019-08-07 19:47:57', '2019-08-07 19:47:57'),
(57, 'OPG 2', 30, 'Tester 2', '', '', 'Međimurje', '', '', '', '', '', '', '2019-08-07 19:48:16', '2019-08-07 19:48:16'),
(58, 'OPG 3', 30, 'Tester 2', '', '', '', '', '', '', '', '', '', '2019-08-07 19:48:27', '2019-08-07 19:48:27'),
(72, '1111', 17, '', '', '', '', '', '', '', '', '', '', '2019-08-08 00:28:07', '2019-08-08 00:36:42');

-- --------------------------------------------------------

--
-- Table structure for table `fields`
--

DROP TABLE IF EXISTS `fields`;
CREATE TABLE IF NOT EXISTS `fields` (
  `field_id` int(11) NOT NULL AUTO_INCREMENT,
  `business_id` int(11) NOT NULL,
  `field_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `field_size` decimal(10,2) NOT NULL,
  `field_arkod` int(7) NOT NULL,
  `field_note` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`field_id`),
  KEY `business_id` (`business_id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fields`
--

INSERT INTO `fields` (`field_id`, `business_id`, `field_name`, `field_size`, `field_arkod`, `field_note`, `created_at`, `updated_at`) VALUES
(11, 48, 'zemlja 1', '14.26', 1384453, 'To.', '2019-08-04 23:13:19', '2019-08-04 23:13:19'),
(12, 48, 'zemlja 245694586y9346yng3693876g923874b93746b9374b693793', '0.00', 0, '', '2019-08-04 23:13:42', '2019-08-04 23:13:42'),
(16, 48, 'zemlja 4', '0.00', 0, 'dfsdfsdfs', '2019-08-04 23:29:36', '2019-08-04 23:33:28'),
(17, 48, 'zemlja 2', '0.00', 0, 'sdfsdfsdf\r\n', '2019-08-04 23:32:41', '2019-08-04 23:33:34'),
(18, 49, 'zemlja 77', '0.00', 1234567, 'Drugo.', '2019-08-04 23:45:44', '2019-08-04 23:45:44'),
(19, 57, 'Polje 1', '0.50', 0, '', '2019-08-07 19:48:53', '2019-08-07 19:48:53'),
(20, 57, 'Polje 2', '4.00', 0, '', '2019-08-07 19:49:02', '2019-08-07 19:49:02'),
(29, 72, '111', '0.00', 0, '', '2019-08-08 00:28:14', '2019-08-08 00:28:14');

-- --------------------------------------------------------

--
-- Table structure for table `pwd_reset`
--

DROP TABLE IF EXISTS `pwd_reset`;
CREATE TABLE IF NOT EXISTS `pwd_reset` (
  `pwd_id` int(11) NOT NULL AUTO_INCREMENT,
  `pwd_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pwd_selector` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pwd_token` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `pwd_expiration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`pwd_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_email_confirmed` tinyint(4) NOT NULL DEFAULT '0',
  `token_confirm` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `current_business_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_email` (`user_email`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_password`, `is_email_confirmed`, `token_confirm`, `current_business_id`, `created_at`, `updated_at`) VALUES
(17, 'Tester One', 'evipodtest1@gmail.com', '$2y$10$PtCaSRY2fIsG.iBc8ETA/.oeYvPOLFNwWpXX1sDhplMBY3xGC0VZ6', 1, '', 48, '2018-12-29 00:33:40', '2019-08-08 00:39:35'),
(30, 'Osoba', 'evipodtest2@gmail.com', '$2y$10$OONFIjH2iFVplQQ/TVUVIOuPRoUcsaE/4eaRtNXbiqH6si285l63.', 1, '', 57, '2019-04-05 14:11:59', '2019-08-07 19:48:36'),
(31, 'Tester 3', 'evipodtest3@gmail.com', '$2y$10$DkZaLOoFAcyC0nXEx5XkNuCxlvgYFi4dIjn3RYG6FgdnW0LByjmQa', 1, '', NULL, '2019-08-07 19:50:30', '2019-08-08 00:06:18');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `fields`
--
ALTER TABLE `fields`
  ADD CONSTRAINT `fields_ibfk_1` FOREIGN KEY (`business_id`) REFERENCES `business` (`business_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
