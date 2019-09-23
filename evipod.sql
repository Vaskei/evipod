-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 23, 2019 at 10:53 PM
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
  `business_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `business_owner` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_oib` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_mibpg` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_county` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_location` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_post` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_address` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_tel` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_mob` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`business_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `business`
--

INSERT INTO `business` (`business_id`, `business_name`, `user_id`, `business_owner`, `business_oib`, `business_mibpg`, `business_county`, `business_location`, `business_post`, `business_address`, `business_email`, `business_tel`, `business_mob`, `created_at`, `updated_at`) VALUES
(48, 'Gospodarstvo 1', 17, 'Djed Mraz', '12345678901', '1234567', 'Međimurje', 'Doma&scaron;inec', '40318', 'Selska 41', 'test@test.com', '911', '098911', '2019-07-05 18:52:47', '2019-08-13 01:22:55'),
(49, 'Test 2', 17, 'Macho Orach', '10000000000', '6969696', 'Zagorje', 'Kamenjara', '10101', 'Sumska 99', 'seljak@test.com', '555100', '099199000', '2019-07-05 18:54:48', '2019-08-07 23:29:13'),
(50, '&lt;!-- č &scaron; đ ć ž Č &Scaron; Đ Ć Ž afdasda', 17, 'Vrijeme', '', '', '', '', '', '', '', '', '', '2019-07-05 21:01:55', '2019-09-04 18:42:53'),
(55, 'sfsdfsdfadasda1', 17, '', '', '', 'afjbfiawiabhifahsf', '', '', '', '', '0718128596203722', '0718128', '2019-08-03 00:45:38', '2019-09-09 12:28:49'),
(56, 'OPG 1', 30, 'Tester 2', '', '', '', '', '', '', '', '', '', '2019-08-07 19:47:57', '2019-08-07 19:47:57'),
(57, 'OPG 2', 30, 'Tester 2', '', '', 'Međimurje', '', '', '', '', '', '', '2019-08-07 19:48:16', '2019-08-07 19:48:16'),
(58, 'OPG 3', 30, 'Tester 2', '', '', '', '', '', '', '', '', '', '2019-08-07 19:48:27', '2019-08-07 19:48:27'),
(72, '1111', 17, '', '', '', '', '', '', '', '', '', '', '2019-08-08 00:28:07', '2019-08-08 00:36:42'),
(78, 'OPG Ferenc', 33, 'Dragutin Ferenc', '', '17901', 'Medimurje', 'Doma&scaron;inec', '40318', 'Marka Kovaca 4', 'opgferenc@gmail.com', '863000', '098000000', '2019-09-15 21:36:42', '2019-09-15 21:36:42'),
(79, 'OPG Ivo', 33, 'Ferenc Ivan', '', '', 'Medimurje', 'Čakovec', '40000', '', '', '', '', '2019-09-15 22:13:04', '2019-09-15 22:13:04');

-- --------------------------------------------------------

--
-- Table structure for table `care`
--

DROP TABLE IF EXISTS `care`;
CREATE TABLE IF NOT EXISTS `care` (
  `care_id` int(11) NOT NULL AUTO_INCREMENT,
  `field_id` int(11) NOT NULL,
  `business_id` int(11) NOT NULL,
  `care_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `care_culture` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `care_date` date NOT NULL,
  `care_note` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`care_id`),
  KEY `field_id` (`field_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `care`
--

INSERT INTO `care` (`care_id`, `field_id`, `business_id`, `care_name`, `care_culture`, `care_date`, `care_note`, `created_at`, `updated_at`) VALUES
(1, 12, 48, 'Rezidba', 'Jabuka', '2019-04-04', 'Puno grana', '2019-09-03 21:32:49', '2019-09-03 21:32:49'),
(2, 12, 48, 'Nadzor', 'Jabuka', '2019-03-30', 'Potrebna rezidba', '2019-09-03 21:45:45', '2019-09-03 21:45:45'),
(3, 12, 48, 'Prorjeđivanje', 'Jabuka', '2019-05-20', 'Suvi&scaron;ak jabuka', '2019-09-03 21:47:07', '2019-09-03 21:47:07'),
(4, 11, 48, 'Rezidba', '&lt;!--', '2019-09-04', 'Puno grana', '2019-09-04 17:04:43', '2019-09-04 17:04:43'),
(5, 60, 78, 'Rezidba', 'Jabuka', '2019-02-12', 'Do 25. 02.', '2019-09-15 21:50:14', '2019-09-15 21:50:14'),
(6, 59, 78, 'Rezidba', 'Jabuka', '2019-03-09', 'Do 21. 03.', '2019-09-15 21:50:38', '2019-09-15 21:50:38'),
(7, 60, 78, 'Prorjeđivanje', 'Jabuka', '2019-06-05', '', '2019-09-15 21:51:12', '2019-09-15 21:51:12'),
(8, 59, 78, 'Prorjeđivanje', 'Jabuka', '2019-06-13', '', '2019-09-15 21:51:31', '2019-09-15 21:51:31'),
(9, 60, 78, 'Ručno odstranjivanje biljaka', 'Jabuka', '2019-05-07', 'Herbicidni pojas', '2019-09-15 21:52:25', '2019-09-15 21:52:25'),
(10, 59, 78, 'Ručno odstranjivanje biljaka', 'Jabuka', '2019-05-07', 'Herbicidni pojas', '2019-09-15 21:52:42', '2019-09-15 21:52:42');

-- --------------------------------------------------------

--
-- Table structure for table `fertilization`
--

DROP TABLE IF EXISTS `fertilization`;
CREATE TABLE IF NOT EXISTS `fertilization` (
  `fertilization_id` int(11) NOT NULL AUTO_INCREMENT,
  `field_id` int(11) NOT NULL,
  `business_id` int(11) NOT NULL,
  `fertilization_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fertilization_date` date NOT NULL,
  `fertilization_amount` decimal(10,2) NOT NULL,
  `fertilization_note` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`fertilization_id`),
  KEY `field_id` (`field_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fertilization`
--

INSERT INTO `fertilization` (`fertilization_id`, `field_id`, `business_id`, `fertilization_name`, `fertilization_date`, `fertilization_amount`, `fertilization_note`, `created_at`, `updated_at`) VALUES
(1, 12, 48, 'Petrokemija d.d. - NPK 15-15-15', '2019-04-01', '800.00', '200 kg nestalo na putu.', '2019-09-03 15:20:30', '2019-09-03 15:20:30'),
(2, 12, 48, 'Petrokemija d.d. - NPK 15-15-15', '2019-05-02', '200.20', '', '2019-09-03 15:28:48', '2019-09-03 15:28:48'),
(3, 16, 48, 'Elixir Zorka - NPK 16-16-16 Special', '2019-05-31', '50.00', 'Ostatak', '2019-09-03 15:29:50', '2019-09-03 15:29:50'),
(4, 60, 78, 'Petrokemija d.d. - NPK 15-15-15', '2019-03-15', '250.00', '', '2019-09-15 21:42:45', '2019-09-15 21:44:19'),
(5, 59, 78, 'Petrokemija d.d. - NPK 15-15-15', '2019-03-15', '185.00', '', '2019-09-15 21:43:23', '2019-09-15 21:44:31'),
(6, 60, 78, 'Petrokemija d.d. - UREA N 46', '2019-05-04', '125.00', '', '2019-09-15 21:45:18', '2019-09-15 21:45:18'),
(7, 59, 78, 'Petrokemija d.d. - UREA N 46', '2019-05-04', '125.00', '', '2019-09-15 21:45:35', '2019-09-15 21:45:35');

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
  `field_arkod` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `field_note` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`field_id`),
  KEY `business_id` (`business_id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fields`
--

INSERT INTO `fields` (`field_id`, `business_id`, `field_name`, `field_size`, `field_arkod`, `field_note`, `created_at`, `updated_at`) VALUES
(11, 48, 'Ekonomija Rulek', '14.45', '1390367', 'Državno', '2019-08-04 23:13:19', '2019-09-03 20:10:13'),
(12, 48, 'Voćnjak', '1.54', '1384453', 'update', '2019-08-04 23:13:42', '2019-08-23 15:42:06'),
(16, 48, 'Mur&scaron;ćak', '0.64', '', 'dfsdfsdfs', '2019-08-04 23:29:36', '2019-08-23 15:41:55'),
(17, 48, 'Vever&scaron;čica', '0.81', '1397589', 'Prazno', '2019-08-04 23:32:41', '2019-09-03 20:37:31'),
(18, 49, 'zemlja 77', '0.00', '1234567', 'Drugo.', '2019-08-04 23:45:44', '2019-08-04 23:45:44'),
(19, 57, 'Polje 1', '0.50', '', '', '2019-08-07 19:48:53', '2019-08-13 00:21:16'),
(20, 57, 'Polje 2', '4.00', '', '', '2019-08-07 19:49:02', '2019-08-13 00:21:17'),
(29, 72, '111', '0.00', '', '', '2019-08-08 00:28:14', '2019-08-13 00:21:19'),
(30, 48, 'aronija', '1.26', '3408664', 'nekaj null 2 test test test test test test test test test test test test test test test test test te', '2019-08-13 00:19:05', '2019-09-09 22:12:45'),
(31, 48, 'zemlja 10', '0.00', '', '', '2019-08-13 01:15:45', '2019-08-13 01:15:45'),
(32, 48, '&lt;!-- zemlja 11 &scaron; đ č ć ž &Scaron; Đ Č Ć Ž', '0.00', '', '', '2019-08-13 01:15:56', '2019-09-04 18:58:03'),
(33, 48, 'zemlja 12', '0.00', '', '', '2019-08-13 01:16:02', '2019-09-04 17:03:57'),
(34, 48, 'zemlja 13', '0.00', '', '', '2019-08-13 01:16:07', '2019-08-13 01:16:07'),
(35, 48, 'zemlja 14', '0.00', '', '', '2019-08-13 01:16:12', '2019-08-13 01:16:12'),
(36, 48, 'zemlja 15', '0.00', '', '', '2019-08-13 01:16:17', '2019-08-13 01:16:17'),
(37, 48, 'zemlja 16', '0.00', '', '', '2019-08-13 01:16:23', '2019-08-13 01:16:23'),
(38, 48, 'zemlja 17', '0.00', '', '', '2019-08-13 01:16:27', '2019-08-13 01:16:27'),
(39, 48, 'zemlja 18', '0.00', '3127704', '', '2019-08-13 01:16:31', '2019-08-13 01:17:09'),
(40, 48, 'zemlja 19', '0.00', '', '', '2019-08-13 01:16:36', '2019-08-13 01:16:36'),
(42, 48, 'test zemlja', '3.20', '', '', '2019-08-21 23:24:33', '2019-08-21 23:24:33'),
(44, 48, '11', '0.00', '', '', '2019-09-09 22:07:54', '2019-09-09 22:07:54'),
(45, 48, '12', '0.00', '', '', '2019-09-09 22:07:57', '2019-09-09 22:07:57'),
(46, 48, '13', '0.00', '', '', '2019-09-09 22:08:00', '2019-09-09 22:08:00'),
(47, 48, '14', '0.00', '', '', '2019-09-09 22:08:02', '2019-09-09 22:08:02'),
(48, 48, '15', '0.00', '', '', '2019-09-09 22:08:05', '2019-09-09 22:08:05'),
(49, 48, '16', '0.00', '', '', '2019-09-09 22:08:08', '2019-09-09 22:08:08'),
(50, 48, '17', '0.00', '', '', '2019-09-09 22:08:10', '2019-09-09 22:08:10'),
(51, 48, '18', '0.00', '', '', '2019-09-09 22:08:14', '2019-09-09 22:08:14'),
(52, 48, '19', '0.00', '', '', '2019-09-09 22:08:16', '2019-09-09 22:08:16'),
(53, 48, '20', '0.00', '', '', '2019-09-09 22:08:19', '2019-09-09 22:08:19'),
(54, 48, '21', '0.00', '', '', '2019-09-09 22:09:57', '2019-09-09 22:09:57'),
(55, 48, '22', '0.00', '', '', '2019-09-09 22:09:59', '2019-09-09 22:09:59'),
(56, 48, '23', '0.00', '', '', '2019-09-09 22:10:02', '2019-09-09 22:10:02'),
(57, 48, '24', '0.00', '', '', '2019-09-09 22:10:05', '2019-09-09 22:10:05'),
(58, 48, '25', '0.00', '', '', '2019-09-09 22:10:07', '2019-09-09 22:10:07'),
(59, 78, 'VOĆNJAK JABUKA', '1.27', '1384453', 'Jabuka', '2019-09-15 21:38:07', '2019-09-15 21:54:48'),
(60, 78, 'VEVER&Scaron;ČICA', '0.81', '1397589', 'Jabuka', '2019-09-15 21:38:28', '2019-09-15 21:38:28'),
(61, 78, 'DRVAJA', '0.25', '2317284', '', '2019-09-15 21:38:56', '2019-09-15 21:38:56'),
(62, 78, 'PODROKITJE', '0.16', '2317345', '', '2019-09-15 21:39:18', '2019-09-15 21:39:18'),
(63, 78, 'VOĆNJAK ORANICA', '0.23', '3676258', 'Oranica kod voćnjaka', '2019-09-15 21:40:10', '2019-09-15 21:55:15');

-- --------------------------------------------------------

--
-- Table structure for table `harvest`
--

DROP TABLE IF EXISTS `harvest`;
CREATE TABLE IF NOT EXISTS `harvest` (
  `harvest_id` int(11) NOT NULL AUTO_INCREMENT,
  `field_id` int(11) NOT NULL,
  `business_id` int(11) NOT NULL,
  `harvest_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harvest_amount` int(11) NOT NULL,
  `harvest_amount_unit` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harvest_date` date NOT NULL,
  `harvest_note` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`harvest_id`),
  KEY `field_id` (`field_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `harvest`
--

INSERT INTO `harvest` (`harvest_id`, `field_id`, `business_id`, `harvest_name`, `harvest_amount`, `harvest_amount_unit`, `harvest_date`, `harvest_note`, `created_at`, `updated_at`) VALUES
(1, 12, 48, 'Jabuka', 15000, 'kg', '2019-09-02', 'Gala', '2019-09-06 21:35:19', '2019-09-06 21:35:19'),
(2, 16, 48, 'Grah', 2, 't', '2019-09-06', '', '2019-09-06 21:49:52', '2019-09-06 21:49:52'),
(3, 32, 48, 'test', 3, 'kg', '2019-09-08', 'Gala', '2019-09-08 21:51:00', '2019-09-08 21:51:00'),
(5, 17, 48, 'Kuruza', 1001, 't', '2019-09-09', 'Mokra', '2019-09-08 22:16:17', '2019-09-08 22:23:31'),
(6, 59, 78, 'Jabuka Gala', 10, 't', '2019-09-01', '', '2019-09-15 22:05:25', '2019-09-15 22:05:25'),
(7, 59, 78, 'Jabuka Jonagold', 5000, 'kg', '2019-09-14', '', '2019-09-15 22:05:59', '2019-09-15 22:05:59');

-- --------------------------------------------------------

--
-- Table structure for table `landing_page`
--

DROP TABLE IF EXISTS `landing_page`;
CREATE TABLE IF NOT EXISTS `landing_page` (
  `id` int(11) NOT NULL DEFAULT '1',
  `section_1_title` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'DOBRODOŠLI U EVIPOD',
  `section_1_desc` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Aplikacija omogućuje korisniku evidentiranje resursa (gospodarstva, zemljišta), nasada (sadnja/sjetva), aktivnosti (zaštita, gnojidba, obrada tla, njega usjeva/nasada), te rezultate (berba/žetva).',
  `section_2_title` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Usluge',
  `section_2_desc` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Web aplikacija Evipod nudi brojne mogućnosti koje olakšavaju rad i poslovanje modernom poljoprivredniku, sve na jednom centraliziranom mjestu.',
  `section_2_icon_1` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'map-marker-alt',
  `section_2_title_1` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Centralizirano',
  `section_2_desc_1` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Svi podaci i evidencije su na jednome mjestu, uvijek dostupni.',
  `section_2_icon_2` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'laptop-code',
  `section_2_title_2` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Neovisno o uređaju',
  `section_2_desc_2` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Računalo, laptop, mobitel, tablet. Pristupite aplikaciji sa svakog uređaja s internet vezom.',
  `section_2_icon_3` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'globe',
  `section_2_title_3` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Bilo gdje',
  `section_2_desc_3` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Mogućnost uporabe aplikacije doma ili na polju/poslu. Jedini uvjet je prisutnost internet veze.',
  `section_2_icon_4` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'calendar-alt',
  `section_2_title_4` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Podrška',
  `section_2_desc_4` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Podrška 24 sata, 7 dana u tjednu. Osim na blagdane.',
  `section_3_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-',
  `section_3_address` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-',
  `section_3_post` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-',
  `section_3_website` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-',
  `section_3_email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-',
  `section_3_tel` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-',
  `section_3_mob` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `landing_page`
--

INSERT INTO `landing_page` (`id`, `section_1_title`, `section_1_desc`, `section_2_title`, `section_2_desc`, `section_2_icon_1`, `section_2_title_1`, `section_2_desc_1`, `section_2_icon_2`, `section_2_title_2`, `section_2_desc_2`, `section_2_icon_3`, `section_2_title_3`, `section_2_desc_3`, `section_2_icon_4`, `section_2_title_4`, `section_2_desc_4`, `section_3_name`, `section_3_address`, `section_3_post`, `section_3_website`, `section_3_email`, `section_3_tel`, `section_3_mob`) VALUES
(1, 'DOBRODOŠLI U EVIPOD', 'Aplikacija omogućuje korisniku evidentiranje resursa (gospodarstva, zemljišta), nasada (sadnja/sjetva), aktivnosti (zaštita, gnojidba, obrada tla, njega usjeva/nasada), te rezultate (berba/žetva).', 'Usluge', 'Web aplikacija Evipod nudi brojne mogućnosti koje olakšavaju rad i poslovanje modernom poljoprivredniku, sve na jednom centraliziranom mjestu.', 'map-marker-alt', 'Centralizirano', 'Svi podaci i evidencije su na jednome mjestu, uvijek dostupni.', 'laptop-code', 'Neovisno o uređaju', 'Računalo, laptop, mobitel, tablet. Pristupite aplikaciji sa svakog uređaja s internet vezom.', 'globe', 'Bilo gdje', 'Mogućnost uporabe aplikacije doma ili na polju/poslu. Jedini uvjet je prisutnost internet veze.', 'calendar-alt', 'Podrška', 'Podrška 24 sata, 7 dana u tjednu. Osim na blagdane.', 'Međimursko veleučilište u Čakovcu', 'BANA JOSIPA JELAČIĆA 22a', '40 000 Čakovec', 'https://www.mev.hr', 'veleuciliste@mev.hr', '+385(0)40396 990', '+385(0)40396 980');

-- --------------------------------------------------------

--
-- Table structure for table `planting`
--

DROP TABLE IF EXISTS `planting`;
CREATE TABLE IF NOT EXISTS `planting` (
  `planting_id` int(11) NOT NULL AUTO_INCREMENT,
  `field_id` int(11) NOT NULL,
  `business_id` int(11) NOT NULL,
  `planting_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `planting_count` int(11) NOT NULL,
  `planting_date` date NOT NULL,
  `planting_source` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `planting_note` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`planting_id`),
  KEY `field_id` (`field_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `planting`
--

INSERT INTO `planting` (`planting_id`, `field_id`, `business_id`, `planting_name`, `planting_count`, `planting_date`, `planting_source`, `planting_note`, `created_at`, `updated_at`) VALUES
(1, 12, 48, 'Tre&scaron;nja', 100, '2019-08-01', 'Neretvanske doline', 'Količina je broj sadnica.', '2019-08-22 12:36:06', '2019-08-23 15:08:26'),
(2, 16, 48, 'Kukuruz', 500, '2017-10-09', '', '', '2019-08-22 14:21:44', '2019-08-23 15:30:00'),
(3, 12, 48, 'Jabuka', 2300, '2010-04-01', '', '', '2019-08-23 10:34:13', '2019-08-23 15:08:37'),
(4, 18, 49, 'Repa na 77', 420, '2019-08-08', '', 'Test', '2019-08-23 11:06:27', '2019-08-23 15:08:54'),
(8, 16, 48, 'P&scaron;enica', 1001, '2018-10-10', 'Skladiste 12', 'Plodored', '2019-08-23 14:48:22', '2019-08-23 15:30:36'),
(10, 18, 49, 'kult 77', 4, '2014-08-07', 'Tam', 'asdadwa', '2019-08-23 15:11:12', '2019-08-23 15:11:12'),
(11, 61, 78, 'Krumpir', 1600, '2019-03-28', '', '', '2019-09-15 22:09:16', '2019-09-15 22:09:16'),
(12, 62, 78, 'Soja', 120, '2019-04-15', 'BASF', '', '2019-09-15 22:11:15', '2019-09-15 22:11:15');

-- --------------------------------------------------------

--
-- Table structure for table `protection`
--

DROP TABLE IF EXISTS `protection`;
CREATE TABLE IF NOT EXISTS `protection` (
  `protection_id` int(11) NOT NULL AUTO_INCREMENT,
  `field_id` int(11) NOT NULL,
  `business_id` int(11) NOT NULL,
  `protection_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `protection_organism` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `protection_date` datetime NOT NULL,
  `protection_amount` decimal(10,2) NOT NULL,
  `protection_amount_unit` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `protection_plant` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `protection_note` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`protection_id`),
  KEY `field_id` (`field_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `protection`
--

INSERT INTO `protection` (`protection_id`, `field_id`, `business_id`, `protection_name`, `protection_organism`, `protection_date`, `protection_amount`, `protection_amount_unit`, `protection_plant`, `protection_note`, `created_at`, `updated_at`) VALUES
(1, 11, 48, 'BORDO&Scaron;KA JUHA 20 WP - MANICA', 'Muha', '2019-04-01 12:00:00', '2.04', 'kg/ha', 'Jabuka 11', '&lt;!-- To 11', '2019-09-02 23:55:16', '2019-09-04 18:58:47'),
(2, 12, 48, 'ASEF-gnojivo i herbicid za travnjak 3 u 1', 'Trava', '2019-05-01 05:30:00', '4.13', 'kg/ha', 'Jabuka 2', 'To 2', '2019-09-02 23:56:50', '2019-09-03 10:31:20'),
(3, 12, 48, 'MERPAN 80 WDG', 'Krastavost', '2019-06-03 06:00:00', '2.50', 'kg/ha', 'Jabuka', '', '2019-09-05 16:33:09', '2019-09-05 16:33:09'),
(4, 12, 48, 'PYRINEX 250 ME', 'U&scaron;i', '2019-06-04 07:00:00', '2.51', 'l/ha', 'Jabuka', '', '2019-09-05 16:33:51', '2019-09-06 19:35:10'),
(5, 12, 48, 'DIFCOR', 'Pepelnica', '2019-06-05 05:00:00', '0.18', 'l/ha', 'Jabuka', '', '2019-09-05 16:34:21', '2019-09-05 16:34:21'),
(6, 12, 48, 'DELAN 700 WDG', 'Pepelnica', '2019-06-17 05:00:00', '0.60', 'kg/ha', 'Jabuka', '', '2019-09-05 16:34:55', '2019-09-05 16:35:55'),
(7, 12, 48, 'STROBY WG', 'Krastavost, pepelnica', '2019-06-18 05:00:00', '0.18', 'kg/ha', 'Jabuka', '', '2019-09-05 16:35:42', '2019-09-05 16:35:42'),
(8, 12, 48, 'CALYPSO SC 480', 'Savijači', '2019-06-19 06:30:00', '0.15', 'l/ha', 'Jabuka', '', '2019-09-05 16:36:35', '2019-09-05 16:36:35'),
(9, 59, 78, 'CUPRABLAU-Z', 'Krastavost', '2019-03-23 06:00:00', '4.30', 'kg/ha', 'Jabuka', '', '2019-09-15 21:57:26', '2019-09-15 21:58:22'),
(10, 59, 78, 'BIJELO ULJE', 'U&scaron;i', '2019-03-23 06:00:00', '5.00', 'l/ha', 'Jabuka', '', '2019-09-15 21:57:55', '2019-09-15 21:57:55'),
(11, 59, 78, 'CHROMODIN S-65', 'Krastavost', '2019-04-04 06:00:00', '0.90', 'kg/ha', 'Jabuka', '', '2019-09-15 21:59:06', '2019-09-15 21:59:06'),
(12, 59, 78, 'DITHANE DG NEOTEC', 'Krastavost', '2019-04-15 07:00:00', '2.50', 'kg/ha', 'Jabuka', '', '2019-09-15 21:59:45', '2019-09-15 21:59:45'),
(13, 59, 78, 'CHROMOSUL 80', 'Pepelnica', '2019-04-15 07:00:00', '2.50', 'kg/ha', 'Jabuka', '', '2019-09-15 22:00:11', '2019-09-15 22:00:11'),
(14, 59, 78, 'CALYPSO SC 480', 'Savijači', '2019-04-15 07:00:00', '0.15', 'l/ha', 'Jabuka', '', '2019-09-15 22:00:37', '2019-09-15 22:00:37'),
(15, 59, 78, 'DELAN 700 WDG', 'Krastavost', '2019-04-25 06:00:00', '0.75', 'kg/ha', 'Jabuka', '', '2019-09-15 22:01:14', '2019-09-15 22:01:14'),
(16, 59, 78, 'CRYSTAL', 'Pepelnica', '2019-04-25 06:00:00', '0.18', 'l/ha', 'Jabuka', '', '2019-09-15 22:01:42', '2019-09-15 22:01:42'),
(17, 59, 78, 'KASTOR', 'Krastavost', '2019-05-02 07:00:00', '2.50', 'kg/ha', 'Jabuka', '', '2019-09-15 22:02:11', '2019-09-15 22:02:11'),
(18, 59, 78, 'PYRUS 400 SC', 'Pepelnica', '2019-05-02 07:00:00', '0.90', 'l/ha', 'Jabuka', '', '2019-09-15 22:03:01', '2019-09-15 22:03:01'),
(19, 59, 78, 'DELAN 700 WDG', 'Krastavost', '2019-05-09 06:00:00', '0.60', 'kg/ha', 'Jabuka', '', '2019-09-15 22:03:35', '2019-09-15 22:03:35'),
(20, 59, 78, 'CHORUS 75 WG', 'U&scaron;i', '2019-05-09 06:00:00', '0.18', 'kg/ha', 'Jabuka', '', '2019-09-15 22:04:07', '2019-09-15 22:04:07'),
(21, 59, 78, 'MOSPILAN 20 SP', 'Savijači', '2019-05-09 06:00:00', '0.30', 'kg/ha', 'Jabuka', '', '2019-09-15 22:04:36', '2019-09-15 22:04:36');

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
-- Table structure for table `rotation`
--

DROP TABLE IF EXISTS `rotation`;
CREATE TABLE IF NOT EXISTS `rotation` (
  `rotation_id` int(11) NOT NULL AUTO_INCREMENT,
  `field_id` int(11) NOT NULL,
  `business_id` int(11) NOT NULL,
  `rotation_year` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rotation_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rotation_note` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`rotation_id`),
  KEY `field_id` (`field_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rotation`
--

INSERT INTO `rotation` (`rotation_id`, `field_id`, `business_id`, `rotation_year`, `rotation_name`, `rotation_note`, `created_at`, `updated_at`) VALUES
(1, 16, 48, '2018', 'Kukuruz', '', '2019-09-10 13:02:14', '2019-09-10 13:02:14'),
(2, 12, 48, '2020', 'Jabuka', 'Budući planovi', '2019-09-10 13:02:27', '2019-09-10 13:26:09'),
(3, 11, 48, '2017', 'Suncokret', '', '2019-09-10 13:06:44', '2019-09-10 13:06:44'),
(4, 16, 48, '2016', 'Soja', 'Probna godina', '2019-09-10 13:10:02', '2019-09-10 13:10:02'),
(5, 32, 48, '2015', '&lt;!-- test --&gt;', '&lt;!-- test --&gt;', '2019-09-10 13:19:44', '2019-09-10 13:19:44'),
(6, 61, 78, '2018', 'Kukuruz', '', '2019-09-15 22:11:54', '2019-09-15 22:11:54'),
(7, 62, 78, '2018', 'Krumpir', '', '2019-09-15 22:12:05', '2019-09-15 22:12:05');

-- --------------------------------------------------------

--
-- Table structure for table `tillage`
--

DROP TABLE IF EXISTS `tillage`;
CREATE TABLE IF NOT EXISTS `tillage` (
  `tillage_id` int(11) NOT NULL AUTO_INCREMENT,
  `field_id` int(11) NOT NULL,
  `business_id` int(11) NOT NULL,
  `tillage_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tillage_date` date NOT NULL,
  `tillage_note` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`tillage_id`),
  KEY `field_id` (`field_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tillage`
--

INSERT INTO `tillage` (`tillage_id`, `field_id`, `business_id`, `tillage_name`, `tillage_date`, `tillage_note`, `created_at`, `updated_at`) VALUES
(1, 17, 48, 'Malčiranje', '2019-07-01', 'Korov', '2019-09-03 20:38:34', '2019-09-03 20:38:34'),
(2, 11, 48, 'Oranje', '2019-02-02', 'Puno posla', '2019-09-03 20:53:41', '2019-09-03 20:53:41'),
(3, 60, 78, 'Malčiranje', '2019-03-11', '', '2019-09-15 21:47:39', '2019-09-15 21:47:39'),
(4, 59, 78, 'Malčiranje', '2019-03-11', '', '2019-09-15 21:47:50', '2019-09-15 21:47:50'),
(5, 60, 78, 'Ko&scaron;nja', '2019-05-15', '', '2019-09-15 21:48:08', '2019-09-15 21:48:08'),
(6, 59, 78, 'Ko&scaron;nja', '2019-05-15', '', '2019-09-15 21:48:21', '2019-09-15 21:48:21'),
(7, 60, 78, 'Ko&scaron;nja', '2019-06-19', '', '2019-09-15 21:48:41', '2019-09-15 21:48:41'),
(8, 59, 78, 'Ko&scaron;nja', '2019-06-19', '', '2019-09-15 21:48:56', '2019-09-15 21:48:56'),
(9, 60, 78, 'Ko&scaron;nja', '2019-08-15', '', '2019-09-15 21:49:13', '2019-09-15 21:49:13'),
(10, 59, 78, 'Ko&scaron;nja', '2019-08-15', '', '2019-09-15 21:49:25', '2019-09-15 21:49:25');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_role` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `is_banned` tinyint(4) NOT NULL DEFAULT '0',
  `is_email_confirmed` tinyint(4) NOT NULL DEFAULT '0',
  `token_confirm` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `current_business_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_email` (`user_email`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_password`, `user_role`, `is_banned`, `is_email_confirmed`, `token_confirm`, `current_business_id`, `created_at`, `updated_at`) VALUES
(17, 'Tester One', 'evipodtest1@gmail.com', '$2y$10$WRsE9.v9szzsxErmOkj32uLMtLkQTi/Wi4KiPnWYRpd9pvYSDicZW', 'user', 0, 1, '', 48, '2018-12-29 00:33:40', '2019-09-19 20:54:16'),
(30, 'Osoba', 'evipodtest2@gmail.com', '$2y$10$MO0JH51G5Yha87VNLw9fquf8Q6bC5/UrH/2APprdMVPrdtxFTTY.C', 'user', 1, 1, '', 57, '2019-04-05 14:11:59', '2019-09-19 20:54:19'),
(31, 'Tester 3', 'evipodtest3@gmail.com', '$2y$10$bcD8utlBwNPfDTUEWU4/ge5L55BDgKOf42LhcmLqFkjXUyPG1e0/i', 'user', 0, 1, '', NULL, '2019-08-07 19:50:30', '2019-09-19 20:53:54'),
(32, 'Admin', 'evipodtech@gmail.com', '$2y$10$xU8khM5jkT8r9H8Cq/gYcOm/nFEtzBTPQVrMDPW/BY7cEEDWP8mlK', 'admin', 0, 1, '', NULL, '2019-09-13 22:27:30', '2019-09-13 22:27:57'),
(33, 'Goran', 'opgferenc@gmail.com', '$2y$10$Vs2RHaZAbiOeAlILfsBiqeZZNUkmPKooFclDwsTsVZOJBuhH/q7Wi', 'user', 0, 1, '', 78, '2019-09-15 21:34:03', '2019-09-16 00:25:37');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `business`
--
ALTER TABLE `business`
  ADD CONSTRAINT `business_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `care`
--
ALTER TABLE `care`
  ADD CONSTRAINT `care_ibfk_1` FOREIGN KEY (`field_id`) REFERENCES `fields` (`field_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `fertilization`
--
ALTER TABLE `fertilization`
  ADD CONSTRAINT `fertilization_ibfk_1` FOREIGN KEY (`field_id`) REFERENCES `fields` (`field_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `fields`
--
ALTER TABLE `fields`
  ADD CONSTRAINT `fields_ibfk_1` FOREIGN KEY (`business_id`) REFERENCES `business` (`business_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `harvest`
--
ALTER TABLE `harvest`
  ADD CONSTRAINT `harvest_ibfk_1` FOREIGN KEY (`field_id`) REFERENCES `fields` (`field_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `planting`
--
ALTER TABLE `planting`
  ADD CONSTRAINT `planting_ibfk_1` FOREIGN KEY (`field_id`) REFERENCES `fields` (`field_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `protection`
--
ALTER TABLE `protection`
  ADD CONSTRAINT `protection_ibfk_1` FOREIGN KEY (`field_id`) REFERENCES `fields` (`field_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rotation`
--
ALTER TABLE `rotation`
  ADD CONSTRAINT `rotation_ibfk_1` FOREIGN KEY (`field_id`) REFERENCES `fields` (`field_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tillage`
--
ALTER TABLE `tillage`
  ADD CONSTRAINT `tillage_ibfk_1` FOREIGN KEY (`field_id`) REFERENCES `fields` (`field_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
