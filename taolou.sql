-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2014 at 06:53 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

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
-- Table structure for table `taolou_account`
--

CREATE TABLE IF NOT EXISTS `taolou_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `memberId` int(11) NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `createDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `taolou_account`
--

INSERT INTO `taolou_account` (`id`, `memberId`, `email`, `password`, `createDate`) VALUES
(1, 1, 'q123wer2002@gmail.com', 'c0c493ca346af5ca1a45839351a3b656', '2014-11-23 17:22:10'),
(2, 2, 'q123wer2002@livemail.tw', 'b7d9e2e1fea3c1aa481c50a63dafde65', '2014-11-23 17:25:35'),
(3, 3, 'q123wer2002@gmail', 'b7d9e2e1fea3c1aa481c50a63dafde65', '2014-11-24 12:38:25'),
(4, 4, 'q123wer2002@gg.com', 'b7d9e2e1fea3c1aa481c50a63dafde65', '2014-11-27 10:01:07');

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
  `companyId` int(11) NOT NULL,
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
  `detail` longtext COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'y',
  `createDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `taolou_job`
--

INSERT INTO `taolou_job` (`id`, `title`, `companyId`, `jobName`, `location`, `jobType`, `salary`, `stock_option`, `detail`, `status`, `createDate`) VALUES
(1, 'show something title', 1, 'IOS', 'taiwan', 'software', '50000', '', '', 'y', '2014-11-13 02:19:36'),
(2, 'show something title', 1, 'IOS', 'taiwan', 'software', '50000', '', '', 'y', '2014-11-13 04:42:02');

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
-- Table structure for table `taolou_member_detail`
--

CREATE TABLE IF NOT EXISTS `taolou_member_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `companyHr` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n',
  `companyId` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `facebook` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `google+` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `photo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `born` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lastEducation` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `workYears` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `jobStatus` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `selfIntro` longtext COLLATE utf8_unicode_ci NOT NULL,
  `messageEmail` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'y',
  `CVupdateEmail` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'y',
  `updateDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `createDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `taolou_member_detail`
--

INSERT INTO `taolou_member_detail` (`id`, `companyHr`, `companyId`, `name`, `email`, `phone`, `facebook`, `google+`, `photo`, `born`, `lastEducation`, `workYears`, `jobStatus`, `selfIntro`, `messageEmail`, `CVupdateEmail`, `updateDate`, `createDate`) VALUES
(1, 'n', 0, '', 'q123wer2002@gmail.com', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00', '2014-11-23 17:22:10'),
(2, 'n', 0, '林彥丞', 'q123wer2002@livemail.tw', '0911400733', '', '', '', '1991', '碩士', '1', '正在找工作', '', '', '', '2014-11-27 07:43:07', '2014-11-23 17:25:35'),
(3, 'y', 0, '', 'q123wer2002@gmail', '', '', '', '', '', '', '', '', '', '', '', '2014-11-24 13:12:29', '2014-11-24 12:38:25'),
(4, 'n', 0, 'GG人', 'q123wer2002@gg.com', '0911400733', '', '', '', '1994', '博士', '3', '正在找工作', '', '', '', '2014-11-28 04:47:37', '2014-11-27 10:01:07');

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
  `detail` longtext COLLATE utf8_unicode_ci NOT NULL,
  `createDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `taolou_member_specialskill`
--

CREATE TABLE IF NOT EXISTS `taolou_member_specialskill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `memberId` int(11) NOT NULL,
  `skillList` longtext COLLATE utf8_unicode_ci NOT NULL,
  `updateDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `taolou_member_specialskill`
--

INSERT INTO `taolou_member_specialskill` (`id`, `memberId`, `skillList`, `updateDate`, `createDate`) VALUES
(1, 1, '', '2014-11-30 13:51:13', '2014-11-30 13:51:13'),
(2, 2, '3|5', '2014-11-30 15:48:39', '2014-11-30 13:51:13'),
(3, 3, '', '2014-11-30 13:51:20', '2014-11-30 13:51:20'),
(4, 4, '', '2014-11-30 13:51:20', '2014-11-30 13:51:20');

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
  `stock_option` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'true',
  `location` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `telework` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'true',
  `updateDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `taolou_member_wantjob`
--

INSERT INTO `taolou_member_wantjob` (`id`, `memberId`, `name`, `jobType`, `leastSalary`, `stock_option`, `location`, `telework`, `updateDate`, `createDate`) VALUES
(1, 4, 'iOS develop', 'true|true|true', '40000', 'true', '1', 'true', '2014-11-30 07:50:28', '2014-11-27 10:13:25'),
(2, 1, '', '', '', 'true', '', 'true', '2014-11-27 10:13:41', '2014-11-27 10:13:41'),
(3, 2, 'Android', 'true|false|false', '40000', 'true', '1|2|3|5', 'true', '2014-11-29 06:38:49', '2014-11-27 10:13:41'),
(4, 3, '', '', '', 'true', '', 'true', '2014-11-27 10:13:46', '2014-11-27 10:13:46');

-- --------------------------------------------------------

--
-- Table structure for table `taolou_system_class_speaicalskill`
--

CREATE TABLE IF NOT EXISTS `taolou_system_class_speaicalskill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `className` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'y',
  `createDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `taolou_system_location`
--

CREATE TABLE IF NOT EXISTS `taolou_system_location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'y',
  `createDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `taolou_system_location`
--

INSERT INTO `taolou_system_location` (`id`, `location`, `status`, `createDate`) VALUES
(1, '台北', 'y', '2014-11-28 05:50:00'),
(2, '桃園', 'y', '2014-11-28 05:50:09'),
(3, '新竹', 'y', '2014-11-28 05:50:09'),
(4, '高雄', 'y', '2014-11-28 08:13:35'),
(5, '新北', 'y', '2014-11-28 08:14:32'),
(6, '中國大陸', 'y', '2014-11-28 08:27:42'),
(7, '台灣全地區', 'y', '2014-11-28 08:30:58');

-- --------------------------------------------------------

--
-- Table structure for table `taolou_system_specialskill`
--

CREATE TABLE IF NOT EXISTS `taolou_system_specialskill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `classId` int(11) NOT NULL,
  `skill` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'y',
  `createDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `taolou_system_specialskill`
--

INSERT INTO `taolou_system_specialskill` (`id`, `classId`, `skill`, `status`, `createDate`) VALUES
(1, 0, 'PHP', 'y', '2014-11-30 14:07:02'),
(2, 0, 'JAVASCRIPT', 'y', '2014-11-30 14:07:02'),
(3, 0, 'HTML5', 'y', '2014-11-30 14:07:21'),
(4, 0, 'AngularJS', 'y', '2014-11-30 14:07:21'),
(5, 0, 'CSS3', 'n', '2014-11-30 15:14:24');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
