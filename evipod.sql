-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 11, 2019 at 08:58 PM
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
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `business`
--

INSERT INTO `business` (`business_id`, `business_name`, `user_id`, `business_owner`, `business_oib`, `business_mibpg`, `business_county`, `business_location`, `business_post`, `business_address`, `business_email`, `business_tel`, `business_mob`, `created_at`, `updated_at`) VALUES
(2, 'Test 1', 17, 'Djed Mraz', '00123456789', '123123', 'Međimurje', 'Doma&scaron;inec', '40318', 'Ulica 3', 'test@test.com', '', '098111111', '2019-06-07 15:17:22', '2019-06-07 15:17:22'),
(3, 'Test 2', 17, 'Djed Mraz', '00123456789', '00123', 'Međimurje', 'Doma&scaron;inec', '40318', 'Ulica 3', 'test@test.com', '', '098111111', '2019-06-07 15:17:22', '2019-06-07 15:17:22'),
(4, 'Test 3', 17, 'Djed Mraz', '', '', 'Međimurje', 'Doma&scaron;inec', '', '', '', '', '098111111', '2019-06-07 15:17:22', '2019-06-07 15:17:22'),
(20, 'dfgdfgd45444gvhg', 17, '', '', '', '', '', '', '', '', '', '', '2019-06-07 16:19:16', '2019-06-07 16:19:16'),
(21, 'dfgdfgd45444gvhg', 17, '', '', '', '', '', '', '', '', '', '', '2019-06-07 16:26:02', '2019-06-07 16:26:02'),
(22, 'sfsdffse', 17, '', '', '', '', '', '', '', '', '', '', '2019-06-07 16:27:27', '2019-06-07 16:27:27');

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
  `last_business_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_email` (`user_email`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_password`, `is_email_confirmed`, `token_confirm`, `last_business_id`, `created_at`, `updated_at`) VALUES
(17, 'Tester One', 'evipodtest1@gmail.com', '$2y$10$PtCaSRY2fIsG.iBc8ETA/.oeYvPOLFNwWpXX1sDhplMBY3xGC0VZ6', 1, '', 22, '2018-12-29 00:33:40', '2019-06-07 16:27:27'),
(23, 'Žbulj', 'evipodtest3@gmail.com', '$2y$10$iD2Y6KQckevvGPCxlPZiCuYieJK/1WF.7pbpqMgZEP2fRpSTLtYY2', 1, '', NULL, '2019-03-02 23:28:47', '2019-03-02 23:29:23'),
(30, 'Osoba', 'evipodtest2@gmail.com', '$2y$10$OONFIjH2iFVplQQ/TVUVIOuPRoUcsaE/4eaRtNXbiqH6si285l63.', 1, '', NULL, '2019-04-05 14:11:59', '2019-04-05 14:12:15');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
