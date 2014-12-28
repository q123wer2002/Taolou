-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 28, 2014 at 12:59 PM
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Dumping data for table `taolou_account`
--

INSERT INTO `taolou_account` (`id`, `memberId`, `email`, `password`, `createDate`) VALUES
(1, 1, 'q123wer2002@gmail.com', 'c0c493ca346af5ca1a45839351a3b656', '2014-11-23 17:22:10'),
(2, 2, 'q123wer2002@livemail.tw', 'b7d9e2e1fea3c1aa481c50a63dafde65', '2014-11-23 17:25:35'),
(3, 3, 'q123wer2002@gmail', 'b7d9e2e1fea3c1aa481c50a63dafde65', '2014-11-24 12:38:25'),
(4, 4, 'q123wer2002@gg.com', 'b7d9e2e1fea3c1aa481c50a63dafde65', '2014-11-27 10:01:07'),
(6, 5, 'test@test.com', 'b7d9e2e1fea3c1aa481c50a63dafde65', '2014-12-02 13:39:23'),
(7, 6, 'tony507yu@gmail.com', 'a141c47927929bc2d1fb6d336a256df4', '2014-12-24 04:43:20'),
(8, 6, 'q123wer2002@123.com', 'b7d9e2e1fea3c1aa481c50a63dafde65', '2014-12-28 09:02:20'),
(9, 7, 'q123wer2002@456.com', 'e10adc3949ba59abbe56e057f20f883e', '2014-12-28 09:12:40'),
(10, 8, 'q123wer2002@789.com', 'b7d9e2e1fea3c1aa481c50a63dafde65', '2014-12-28 09:31:01');

-- --------------------------------------------------------

--
-- Table structure for table `taolou_company`
--

CREATE TABLE IF NOT EXISTS `taolou_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `recommendation` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n',
  `companyShortName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `companyName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `CEO` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ceoPhoto` longtext COLLATE utf8_unicode_ci NOT NULL,
  `logo` longtext COLLATE utf8_unicode_ci NOT NULL,
  `location` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `memberSize` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `website` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `companyFB` longtext COLLATE utf8_unicode_ci NOT NULL,
  `createDate` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `detail` longtext COLLATE utf8_unicode_ci NOT NULL,
  `updateDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `taolou_company`
--

INSERT INTO `taolou_company` (`id`, `recommendation`, `companyShortName`, `companyName`, `CEO`, `ceoPhoto`, `logo`, `location`, `memberSize`, `website`, `companyFB`, `createDate`, `detail`, `updateDate`) VALUES
(1, 'y', 'test', 'taoloutest', 'yenchen', 'userObject/companyObject/1/ceoPhoto.png', 'userObject/companyObject/1/CompanyPhoto.jpeg', '宜蘭縣/員山鄉/264', '200~2000人', 'taolou.com', 'www.facebook.com', '2014年-08月', '456', '2014-12-20 09:29:47'),
(2, 'y', 'nnnnnn', 'CarryBazi', 'YYYYY', 'userObject/companyObject/2/ceoPhoto.jpeg', 'userObject/companyObject/2/CompanyPhoto.png', '宜蘭縣/員山鄉/264', '10', '4040', '', '2014年-12月', '', '2014-12-18 11:57:28'),
(3, 'y', 'sunflower', 'NewCompanyTest', 'SUN', 'userObject/companyObject/3/ceoPhoto.jpeg', 'userObject/companyObject/3/CompanyPhoto.jpeg', '桃園縣/觀音鄉/328', '50~200人', 'http://sunflower', 'http://www.facebook.com/sunflower', '2008年-2月', 'sunsun', '2014-12-28 10:22:04'),
(4, 'y', 'A_NCTU', 'NCTU_IIM', 'Mander', 'userObject/companyObject/4/ceoPhoto.jpeg', 'userObject/companyObject/4/CompanyPhoto.jpeg', '新竹市/東區/300', '2000人以上', 'http://www.nctu.edu.tw', 'http://www.facebook.com/nctu', '1991年-4月', 'A school', '2014-12-28 10:18:09');

-- --------------------------------------------------------

--
-- Table structure for table `taolou_company_finance`
--

CREATE TABLE IF NOT EXISTS `taolou_company_finance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `companyId` int(11) NOT NULL,
  `stage` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `date` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `createDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=18 ;

--
-- Dumping data for table `taolou_company_finance`
--

INSERT INTO `taolou_company_finance` (`id`, `companyId`, `stage`, `date`, `createDate`) VALUES
(3, 1, 'A輪', '2013年-2月', '2014-12-20 09:11:41'),
(8, 4, '已被收購', '2013年-3月', '2014-12-28 09:34:50'),
(17, 3, '尚未融資', '2014年-12月', '2014-12-28 10:22:04');

-- --------------------------------------------------------

--
-- Table structure for table `taolou_company_skill`
--

CREATE TABLE IF NOT EXISTS `taolou_company_skill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `companyId` int(11) NOT NULL,
  `skillList` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `updateDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `taolou_company_skill`
--

INSERT INTO `taolou_company_skill` (`id`, `companyId`, `skillList`, `updateDate`, `createDate`) VALUES
(1, 1, '1|2|9|8', '2014-12-20 09:29:47', '2014-12-18 12:15:41'),
(2, 2, '2|3', '2014-12-18 12:15:41', '2014-12-18 12:15:41'),
(3, 3, '3|2', '2014-12-28 10:22:04', '2014-12-28 10:12:06'),
(4, 4, '2|8', '2014-12-28 10:18:09', '2014-12-28 10:12:12');

-- --------------------------------------------------------

--
-- Table structure for table `taolou_job`
--

CREATE TABLE IF NOT EXISTS `taolou_job` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `postMemberId` int(11) NOT NULL,
  `title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `companyId` int(11) NOT NULL,
  `jobName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `location` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `jobType` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `jobNature` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `salary` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `stock_option` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `detail` longtext COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'y',
  `updateDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `taolou_job`
--

INSERT INTO `taolou_job` (`id`, `postMemberId`, `title`, `companyId`, `jobName`, `location`, `jobType`, `jobNature`, `salary`, `stock_option`, `detail`, `status`, `updateDate`, `createDate`) VALUES
(1, 3, 'show something title', 1, 'IOS工程師', '宜蘭縣/員山鄉/264', 'software', '全職', '50000', 'y', 'wcqwc', 'y', '2014-12-22 06:15:42', '2014-12-24 04:23:48'),
(2, 4, 'show something title', 2, 'Android工程師', '宜蘭縣/員山鄉/264', 'software', '兼職', '50000', 'y', 'dwqd', 'y', '2014-12-22 06:15:32', '2014-12-24 04:23:50'),
(3, 3, 'come on join us', 1, 'android', '新北市/深坑區/222', '技術相關', '全職', '50000', 'y', 'come on come on', 'y', '2014-12-26 06:28:54', '2014-12-26 06:28:54'),
(4, 3, 'asdasqwf', 1, 'marketing', '南投縣/埔里鎮/545', '營運相關', '兼職', '60000', 'y', '21e12e12e', 'y', '2014-12-26 06:29:35', '2014-12-26 06:29:35'),
(5, 8, 'Ido', 4, 'web develop', '新竹市/東區/300', '技術相關', '全職', '40000', 'y', 'come on', 'y', '2014-12-28 10:17:43', '2014-12-28 10:17:43'),
(6, 6, 'ppopopop', 3, 'marketingMan', '嘉義市/西區/600', '營運相關', '兼職', '6000', 'y', 'join us\n\n\nqwdqwd', 'y', '2014-12-28 10:22:40', '2014-12-28 10:22:40');

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
  `companyValid` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `facebook` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `google` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `taolou_member_detail`
--

INSERT INTO `taolou_member_detail` (`id`, `companyHr`, `companyId`, `companyValid`, `name`, `email`, `phone`, `facebook`, `google`, `photo`, `born`, `lastEducation`, `workYears`, `jobStatus`, `selfIntro`, `messageEmail`, `CVupdateEmail`, `updateDate`, `createDate`) VALUES
(1, 'n', 0, '', '', 'q123wer2002@gmail.com', '', '', '', '', '', '', '', '', '', 'y', 'y', '2014-12-12 14:36:01', '2014-11-23 17:22:10'),
(2, 'n', 0, '', 'SuperSaiYeiNin', 'q123wer2002@livemail.tw', '0911400733', '', '', 'userObject/q123wer2002@livemail.tw/profilePhoto/userPhoto.jpeg', '1991', '碩士', '1', '正在找工作', '0231567', 'y', 'n', '2014-12-14 09:39:19', '2014-11-23 17:25:35'),
(3, 'y', 1, 'Host', 'yoyoMan', 'q123wer2002@gmail', '', '', '', 'userObject/q123wer2002@gmail/profilePhoto/userPhoto.png', '', '', '', '', '', 'y', 'n', '2014-12-24 04:23:30', '2014-11-24 12:38:25'),
(4, 'y', 2, 'y', 'GG人', 'q123wer2002@gg.com', '0911400733', '', '', 'userObject/q123wer2002@gg.com/profilePhoto/userPhoto.png', '1994', '博士', '3', '正在找工作', '', 'y', 'y', '2014-12-24 04:23:42', '2014-11-27 10:01:07'),
(5, 'n', 0, '', '', 'test@test.com', '', '', '', '', '', '', '', '', '', 'y', 'y', '2014-12-12 14:36:07', '2014-12-02 13:39:23'),
(6, 'y', 3, 'y', 'POLO', 'q123wer2002@123.com', '', '', '', 'userObject/q123wer2002@123.com/profilePhoto/userPhoto.jpeg', '', '', '', '', '', 'y', 'y', '2014-12-28 10:24:50', '2014-12-28 09:02:20'),
(7, 'n', 0, '', '', 'q123wer2002@456.com', '+886911400733', '', '', '', '', '', '', '', '', 'y', 'y', '2014-12-28 09:14:02', '2014-12-28 09:12:40'),
(8, 'y', 4, 'Host', 'DannyLin,Yo', 'q123wer2002@789.com', '', '', '', 'userObject/q123wer2002@789.com/profilePhoto/userPhoto.jpeg', '', '', '', '', '', 'y', 'y', '2014-12-28 09:32:26', '2014-12-28 09:31:01');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `taolou_member_education`
--

INSERT INTO `taolou_member_education` (`id`, `memberId`, `educationBG`, `startYear`, `endYear`, `school`, `major`, `updateDate`, `createDate`) VALUES
(1, 2, '碩士', 2012, 2014, 'NCTU', 'IIM_and_IMF', '2014-12-13 16:52:01', '2014-12-05 07:16:46'),
(2, 2, '博士', 2010, 2014, 'LOL大學', '超級賽亞超級人', '2014-12-13 16:52:36', '2014-12-13 16:51:04');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `taolou_member_experience`
--

INSERT INTO `taolou_member_experience` (`id`, `memberId`, `name`, `year`, `continueTime`, `company`, `role`, `detail`, `updateDate`, `createDate`) VALUES
(2, 2, 'PPPPPPPPPPP', 2014, '一年以上', 'QQQQQQQQQQQ', 'RRRRRRRRRRRRR', 'BBBBBBBBBBBBB', '2014-12-13 05:16:15', '2014-12-13 05:16:15');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `taolou_member_jobmanage`
--

INSERT INTO `taolou_member_jobmanage` (`id`, `memberId`, `jobId`, `cvId`, `intelligence`, `status`, `createDate`) VALUES
(1, 2, 1, 0, 'y', 'wait', '2014-12-10 09:19:31'),
(2, 2, 2, 0, 'y', 'collect', '2014-12-10 09:21:58'),
(4, 2, 3, 0, 'n', '', '2014-12-26 06:31:52'),
(5, 2, 4, 0, 'n', 'wait', '2014-12-26 13:44:41'),
(6, 7, 1, 0, 'n', '', '2014-12-28 09:29:24');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=26 ;

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
(12, 2, 4, '123456', 'y', '2014-12-12 13:12:18'),
(13, 3, 2, '還有要來我們公司嗎？', 'y', '2014-12-13 03:54:11'),
(14, 2, 3, '好，謝謝你', 'y', '2014-12-13 03:54:47'),
(15, 3, 2, 'yoyo', 'y', '2014-12-13 05:32:08'),
(16, 2, 4, '0.0', 'y', '2014-12-13 16:51:35'),
(17, 2, 3, 'hi', 'y', '2014-12-13 16:51:50'),
(18, 2, 4, '093250948*', 'y', '2014-12-13 16:55:53'),
(19, 2, 4, '098850948*', 'y', '2014-12-13 16:56:10'),
(20, 2, 4, '098836782*', 'y', '2014-12-13 16:57:51'),
(21, 3, 2, 'hey', 'y', '2014-12-15 14:17:54'),
(25, 2, 6, 'hi,你好，我想要多多了解一下您所刊登的職位。謝謝你', 'y', '2014-12-28 11:57:24');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `taolou_member_specialskill`
--

INSERT INTO `taolou_member_specialskill` (`id`, `memberId`, `skillList`, `updateDate`, `createDate`) VALUES
(1, 1, '', '2014-11-30 13:51:13', '2014-11-30 13:51:13'),
(2, 2, '1|3|4|2', '2014-12-18 12:25:59', '2014-11-30 13:51:13'),
(3, 3, '', '2014-11-30 13:51:20', '2014-11-30 13:51:20'),
(4, 4, '', '2014-11-30 13:51:20', '2014-11-30 13:51:20'),
(5, 6, '', '2014-12-28 09:02:20', '2014-12-28 09:02:20'),
(6, 7, '', '2014-12-28 09:12:40', '2014-12-28 09:12:40');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `taolou_member_wantjob`
--

INSERT INTO `taolou_member_wantjob` (`id`, `memberId`, `name`, `jobType`, `leastSalary`, `stock_option`, `location`, `telework`, `updateDate`, `createDate`) VALUES
(1, 4, 'iOS develop', 'true|true|true', '40000', 'true', '1', 'true', '2014-11-30 07:50:28', '2014-11-27 10:13:25'),
(2, 1, '', '', '', 'true', '', 'true', '2014-11-27 10:13:41', '2014-11-27 10:13:41'),
(3, 2, 'Android', 'true|false|false', '40000', 'true', '1|2|3|5', 'true', '2014-11-29 06:38:49', '2014-11-27 10:13:41'),
(4, 3, '', '', '', 'true', '', 'true', '2014-11-27 10:13:46', '2014-11-27 10:13:46'),
(5, 6, '', '', '', '', '', '', '2014-12-28 09:02:20', '2014-12-28 09:02:20'),
(6, 7, '', '', '', '', '', '', '2014-12-28 09:12:40', '2014-12-28 09:12:40');

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
-- Table structure for table `taolou_system_companyskill`
--

CREATE TABLE IF NOT EXISTS `taolou_system_companyskill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `skillName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'y',
  `createDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `taolou_system_companyskill`
--

INSERT INTO `taolou_system_companyskill` (`id`, `skillName`, `status`, `createDate`) VALUES
(1, '搜尋', 'y', '2014-12-18 12:03:36'),
(2, '社交網路', 'y', '2014-12-18 12:03:36'),
(3, '移動互聯網', 'y', '2014-12-18 12:03:57'),
(4, '電子商務', 'y', '2014-12-18 12:03:57'),
(5, '遊戲', 'y', '2014-12-18 12:04:09'),
(6, '醫療健康', 'y', '2014-12-18 12:04:09'),
(7, '招聘', 'y', '2014-12-18 12:04:29'),
(8, '教育', 'y', '2014-12-18 12:04:29'),
(9, '智慧型手機', 'y', '2014-12-20 08:23:35');

-- --------------------------------------------------------

--
-- Table structure for table `taolou_system_jobtype`
--

CREATE TABLE IF NOT EXISTS `taolou_system_jobtype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `typeName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `createDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `taolou_system_jobtype`
--

INSERT INTO `taolou_system_jobtype` (`id`, `typeName`, `status`, `createDate`) VALUES
(1, '技術相關', 'y', '2014-12-15 15:31:06'),
(2, '產品相關', 'y', '2014-12-15 15:31:06'),
(3, '營運相關', 'y', '2014-12-15 15:31:22'),
(4, '設計相關', 'y', '2014-12-15 15:31:22'),
(5, '市場/銷售相關', 'y', '2014-12-15 15:31:58'),
(6, '職能相關', 'y', '2014-12-15 15:31:58');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

--
-- Dumping data for table `taolou_system_specialskill`
--

INSERT INTO `taolou_system_specialskill` (`id`, `classId`, `skill`, `status`, `createDate`) VALUES
(1, 0, 'PHP', 'y', '2014-12-05 07:06:43'),
(2, 0, 'MySQL', 'y', '2014-12-05 07:06:48'),
(3, 0, 'AngularJS', 'y', '2014-12-05 07:06:55'),
(4, 0, 'AVALON', 'y', '2014-12-13 16:50:10');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
