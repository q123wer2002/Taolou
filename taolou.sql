-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2014 at 03:57 PM
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
-- Table structure for table `taolou_account`
--

CREATE TABLE IF NOT EXISTS `taolou_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `memberId` int(11) NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `createDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `taolou_account`
--

INSERT INTO `taolou_account` (`id`, `memberId`, `email`, `password`, `createDate`) VALUES
(1, 1, 'q123wer2002@gmail.com', 'c0c493ca346af5ca1a45839351a3b656', '2014-11-23 17:22:10'),
(2, 2, 'q123wer2002@livemail.tw', 'b7d9e2e1fea3c1aa481c50a63dafde65', '2014-11-23 17:25:35'),
(3, 3, 'q123wer2002@gmail', 'b7d9e2e1fea3c1aa481c50a63dafde65', '2014-11-24 12:38:25'),
(4, 4, 'q123wer2002@gg.com', 'b7d9e2e1fea3c1aa481c50a63dafde65', '2014-11-27 10:01:07'),
(6, 5, 'test@test.com', 'b7d9e2e1fea3c1aa481c50a63dafde65', '2014-12-02 13:39:23');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `taolou_company`
--

INSERT INTO `taolou_company` (`id`, `recommendation`, `productName`, `companyName`, `CEO`, `logo`, `location`, `memberSize`, `website`, `createDate`, `detail`) VALUES
(1, 'y', 'test', 'taoloutest', 'yenchen', 'taolou_logo.jpg', 'taiwan', '50-100', 'http://taolou.com', '0000-00-00 00:00:00', '456'),
(2, 'n', 'nnnnnn', 'CarryBazi', 'YYYYY', 'ASDFAS', 'QWW', '10', '4040', '2014-12-12 11:18:38', '');

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
(1, 'show something title', 1, 'IOS工程師', 'taiwan', 'software', '50000', 'y', '', 'y', '2014-12-12 06:04:05'),
(2, 'show something title', 1, 'Android工程師', 'taiwan', 'software', '50000', '', '', 'y', '2014-12-12 06:04:09');

-- --------------------------------------------------------

--
-- Table structure for table `taolou_member_cv`
--

CREATE TABLE IF NOT EXISTS `taolou_member_cv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `memberId` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `skill` longtext COLLATE utf8_unicode_ci NOT NULL,
  `intelligence` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'y',
  `size` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `src` longtext COLLATE utf8_unicode_ci NOT NULL,
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
  `photo` longtext COLLATE utf8_unicode_ci NOT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `taolou_member_detail`
--

INSERT INTO `taolou_member_detail` (`id`, `companyHr`, `companyId`, `name`, `email`, `phone`, `facebook`, `google+`, `photo`, `born`, `lastEducation`, `workYears`, `jobStatus`, `selfIntro`, `messageEmail`, `CVupdateEmail`, `updateDate`, `createDate`) VALUES
(1, 'n', 0, '', 'q123wer2002@gmail.com', '', '', '', '', '', '', '', '', '', 'y', 'y', '2014-12-12 14:36:01', '2014-11-23 17:22:10'),
(2, 'n', 0, '林彥丞', 'q123wer2002@livemail.tw', '0911400733', '', '', 'userObject/q123wer2002@livemail.tw/profilePhoto/userPhoto.jpeg', '1991', '碩士', '1', '正在找工作', '123456789', 'y', 'n', '2014-12-12 14:56:03', '2014-11-23 17:25:35'),
(3, 'y', 1, 'yoyoMan', 'q123wer2002@gmail', '', '', '', '', '', '', '', '', '', 'y', 'y', '2014-12-12 14:36:04', '2014-11-24 12:38:25'),
(4, 'y', 2, 'GG人', 'q123wer2002@gg.com', '0911400733', '', '', '', '1994', '博士', '3', '正在找工作', '', 'y', 'y', '2014-12-12 14:36:05', '2014-11-27 10:01:07'),
(5, 'n', 0, '', 'test@test.com', '', '', '', '', '', '', '', '', '', 'y', 'y', '2014-12-12 14:36:07', '2014-12-02 13:39:23');

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
  `updateDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `taolou_member_education`
--

INSERT INTO `taolou_member_education` (`id`, `memberId`, `educationBG`, `startYear`, `endYear`, `school`, `major`, `updateDate`, `createDate`) VALUES
(1, 2, '碩士', 2012, 2014, 'NCTU', 'IIM_and_IMF', '2014-12-05 12:02:36', '2014-12-05 07:16:46');

-- --------------------------------------------------------

--
-- Table structure for table `taolou_member_experience`
--

CREATE TABLE IF NOT EXISTS `taolou_member_experience` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `memberId` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `year` year(4) NOT NULL,
  `continueTime` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `company` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `detail` longtext COLLATE utf8_unicode_ci NOT NULL,
  `updateDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `taolou_member_experience`
--

INSERT INTO `taolou_member_experience` (`id`, `memberId`, `name`, `year`, `continueTime`, `company`, `role`, `detail`, `updateDate`, `createDate`) VALUES
(2, 2, 'PPPPPPPPPPP', 2012, '一年以上', 'QQQQQQQQQQQ', 'RRRRRRRRRRRRR', 'BBBBBBBBBBBBB', '2014-12-05 14:33:59', '2014-12-05 14:33:59');

-- --------------------------------------------------------

--
-- Table structure for table `taolou_member_jobmanage`
--

CREATE TABLE IF NOT EXISTS `taolou_member_jobmanage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `memberId` int(11) NOT NULL,
  `jobId` int(11) NOT NULL,
  `cvId` int(11) NOT NULL,
  `intelligence` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `createDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `taolou_member_jobmanage`
--

INSERT INTO `taolou_member_jobmanage` (`id`, `memberId`, `jobId`, `cvId`, `intelligence`, `status`, `createDate`) VALUES
(1, 2, 1, 0, 'y', 'wait', '2014-12-10 09:19:31'),
(2, 2, 2, 0, 'y', 'collect', '2014-12-10 09:21:58');

-- --------------------------------------------------------

--
-- Table structure for table `taolou_member_message`
--

CREATE TABLE IF NOT EXISTS `taolou_member_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sendUserId` int(11) NOT NULL,
  `receiveUserId` int(11) NOT NULL,
  `message` longtext COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'y',
  `createDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

--
-- Dumping data for table `taolou_member_message`
--

INSERT INTO `taolou_member_message` (`id`, `sendUserId`, `receiveUserId`, `message`, `status`, `createDate`) VALUES
(1, 2, 4, 'yo', 'y', '2014-12-12 07:04:49'),
(2, 4, 2, 'good', 'y', '2014-12-12 07:04:50'),
(3, 4, 2, 'what''s up?', 'y', '2014-12-12 07:10:21'),
(4, 3, 2, 'haha', 'y', '2014-12-12 07:10:48'),
(5, 2, 4, 'hi,你好，我想加入貴公司一起打拼', 'y', '2014-12-12 11:58:39'),
(6, 4, 2, '謝謝你們的回覆，我目前還在台灣讀研究所，我很樂意也很願意與你們多聊 我的信箱與QQ： q123wer2002@gmail.com 謝謝你', 'y', '2014-12-12 12:05:38'),
(7, 2, 4, '謝謝你', 'y', '2014-12-12 12:41:34'),
(8, 2, 4, '對了，順便問一下，貴公司很厲害嗎？', 'y', '2014-12-12 12:42:32'),
(9, 2, 4, '謝謝', 'y', '2014-12-12 12:55:33'),
(10, 2, 3, 'yoyoMan', 'y', '2014-12-12 12:56:10'),
(11, 2, 3, '123456', 'y', '2014-12-12 13:12:02'),
(12, 2, 4, '123456', 'y', '2014-12-12 13:12:18');

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
(2, 2, '1|2|3', '2014-12-05 07:06:57', '2014-11-30 13:51:13'),
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `taolou_system_specialskill`
--

INSERT INTO `taolou_system_specialskill` (`id`, `classId`, `skill`, `status`, `createDate`) VALUES
(1, 0, 'PHP', 'y', '2014-12-05 07:06:43'),
(2, 0, 'MySQL', 'y', '2014-12-05 07:06:48'),
(3, 0, 'AngularJS', 'y', '2014-12-05 07:06:55');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
