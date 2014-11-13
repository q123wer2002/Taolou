-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2014 at 02:22 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `taolou`
--

-- --------------------------------------------------------

--
-- Table structure for table `taolou_company`
--

CREATE TABLE IF NOT EXISTS `taolou_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `recommendation` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n',
  `productName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `companyName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `CEO` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `logo` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `location` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `memberSize` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `website` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `createDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `detail` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `taolou_company`
--

INSERT INTO `taolou_company` (`id`, `recommendation`, `productName`, `companyName`, `CEO`, `logo`, `location`, `memberSize`, `website`, `createDate`, `detail`) VALUES
(1, 'y', 'test', 'taoloutest', 'yenchen', 'taolou/logo.img', 'taiwan', '50-100', 'http://taolou.com', '0000-00-00 00:00:00', '456');

-- --------------------------------------------------------

--
-- Table structure for table `taolou_company_finance`
--

CREATE TABLE IF NOT EXISTS `taolou_company_finance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `companyId` int(11) NOT NULL,
  `stage` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `date` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `taolou_company_skill`
--

CREATE TABLE IF NOT EXISTS `taolou_company_skill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `conpanyId` int(11) NOT NULL,
  `skillName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `taolou_job`
--

CREATE TABLE IF NOT EXISTS `taolou_job` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `companyId` int(11) NOT NULL,
  `jobName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `location` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `jobType` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `salary` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `stock_option` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `detail` longblob NOT NULL,
  `createDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `taolou_member`
--

CREATE TABLE IF NOT EXISTS `taolou_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comapnyHr` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n',
  `comapnyId` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `facebook` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `photo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `bron` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lastEducation` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `workYears` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `jobStatus` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `selfIntro` longblob NOT NULL,
  `messageEmail` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'y',
  `CVupdateEmail` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'y',
  `updateDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `createDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `taolou_member_cv`
--

CREATE TABLE IF NOT EXISTS `taolou_member_cv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `memberId` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `skill` longtext COLLATE utf8_unicode_ci NOT NULL,
  `intelligent` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'y',
  `size` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `createDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `taolou_member_education`
--

CREATE TABLE IF NOT EXISTS `taolou_member_education` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `memberId` int(11) NOT NULL,
  `educationBG` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `startYear` year(4) NOT NULL,
  `endYear` year(4) NOT NULL,
  `school` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `major` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `createDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `taolou_member_experience`
--

CREATE TABLE IF NOT EXISTS `taolou_member_experience` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `memberId` int(11) NOT NULL,
  `name` int(50) NOT NULL,
  `year` year(4) NOT NULL,
  `continueTime` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `company` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `detail` longblob NOT NULL,
  `createDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `taolou_member_wantjob`
--

CREATE TABLE IF NOT EXISTS `taolou_member_wantjob` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `memberId` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `jobType` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `leastSalary` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `stock_option` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'y',
  `location` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `telework` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'y',
  `updateDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
