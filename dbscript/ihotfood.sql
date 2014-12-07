-- phpMyAdmin SQL Dump
-- version 4.2.5
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Dec 06, 2014 at 11:02 PM
-- Server version: 5.5.38
-- PHP Version: 5.5.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `ihotfood`
--

-- --------------------------------------------------------

--
-- Table structure for table `albums`
--

CREATE TABLE `albums` (
  `id` int(11) NOT NULL
  `name` varchar(255) NOT NULL,
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `albums`
--
-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
`id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `type` int(2) NOT NULL COMMENT '0-normal;1-promotion/event (with validity period)',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `publish_time` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `abbrev` varchar(5) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`abbrev`, `description`) VALUES
('cd', 'Casual dining'),
('cf', 'Coffe shop'),
('ff', 'Fast food'),
('lx', 'Luxury'),
('pub', 'Pub');

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_sessions`
--
-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `review_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `publish_time` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `abbrev` varchar(3) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`abbrev`, `name`) VALUES
('be', 'Belgium'),
('en', 'England'),
('fr', 'France'),
('nl', 'Netherlands'),
('vn', 'Vietnam');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `abbrev` varchar(3) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`abbrev`, `name`) VALUES
('de', 'German'),
('en', 'English'),
('fr', 'French'),
('jp', 'Japanese'),
('nl', 'Dutch'),
('vn', 'Vietnamese');

-- --------------------------------------------------------

--
-- Table structure for table `medias`
--

CREATE TABLE `medias` (
`id` int(11) NOT NULL,
  `album_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL COMMENT 'name of the file ',
  `caption` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
`id` int(11) NOT NULL,
  `actor_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `object_id` int(11) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `count` int(11) DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1344 ;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `actor_id`, `subject_id`, `object_id`, `type_id`, `status`, `created_date`, `updated_date`, `count`) VALUES
(1126, 11, 88, 308, 1, 'unseen', '2014-12-03 21:30:38', '0000-00-00 00:00:00', 1),
(1127, 11, 89, 308, 1, 'unseen', '2014-12-04 21:06:44', '0000-00-00 00:00:00', 1),
(1128, 11, 90, 308, 1, 'unseen', '2014-12-04 21:06:56', '0000-00-00 00:00:00', 1),
(1129, 11, 91, 308, 1, 'unseen', '2014-12-04 21:12:37', '0000-00-00 00:00:00', 1),
(1130, 11, 92, 308, 1, 'unseen', '2014-12-04 21:13:42', '0000-00-00 00:00:00', 1),
(1131, 11, 93, 308, 1, 'unseen', '2014-12-04 21:14:29', '0000-00-00 00:00:00', 1),
(1132, 11, 94, 308, 1, 'unseen', '2014-12-04 21:15:09', '0000-00-00 00:00:00', 1),
(1133, 11, 95, 308, 1, 'unseen', '2014-12-04 21:20:42', '0000-00-00 00:00:00', 1),
(1134, 11, 96, 308, 1, 'unseen', '2014-12-04 21:21:13', '0000-00-00 00:00:00', 1),
(1135, 11, 97, 308, 1, 'unseen', '2014-12-04 21:21:26', '0000-00-00 00:00:00', 1),
(1136, 11, 98, 308, 1, 'unseen', '2014-12-04 21:22:57', '0000-00-00 00:00:00', 1),
(1137, 11, 99, 308, 1, 'unseen', '2014-12-04 21:29:55', '0000-00-00 00:00:00', 1),
(1138, 11, 100, 308, 1, 'unseen', '2014-12-04 21:32:10', '0000-00-00 00:00:00', 1),
(1139, 11, 101, 308, 1, 'unseen', '2014-12-04 21:50:27', '0000-00-00 00:00:00', 1),
(1140, 11, 102, 308, 1, 'unseen', '2014-12-04 21:52:27', '0000-00-00 00:00:00', 1),
(1141, 11, 103, 308, 1, 'unseen', '2014-12-04 21:52:50', '0000-00-00 00:00:00', 1),
(1142, 11, 104, 308, 1, 'unseen', '2014-12-04 21:53:10', '0000-00-00 00:00:00', 1),
(1143, 11, 105, 308, 1, 'unseen', '2014-12-04 21:59:55', '0000-00-00 00:00:00', 1),
(1144, 11, 106, 308, 1, 'unseen', '2014-12-04 22:09:04', '0000-00-00 00:00:00', 1),
(1145, 11, 107, 308, 1, 'unseen', '2014-12-04 22:14:20', '0000-00-00 00:00:00', 1),
(1146, 12, 108, 308, 1, 'unseen', '2014-12-04 22:15:30', '0000-00-00 00:00:00', 1),
(1147, 12, 109, 308, 1, 'unseen', '2014-12-04 22:15:37', '0000-00-00 00:00:00', 1),
(1148, 12, 110, 308, 1, 'unseen', '2014-12-04 22:15:53', '0000-00-00 00:00:00', 1),
(1149, 12, 111, 308, 1, 'unseen', '2014-12-04 22:16:03', '0000-00-00 00:00:00', 1),
(1150, 11, 112, 308, 1, 'unseen', '2014-12-04 22:16:11', '0000-00-00 00:00:00', 1),
(1151, 12, 113, 308, 1, 'unseen', '2014-12-04 22:18:39', '0000-00-00 00:00:00', 1),
(1152, 11, 114, 308, 1, 'unseen', '2014-12-04 22:19:03', '0000-00-00 00:00:00', 1),
(1153, 11, 115, 308, 1, 'unseen', '2014-12-04 22:19:11', '0000-00-00 00:00:00', 1),
(1154, 11, 116, 308, 1, 'unseen', '2014-12-04 22:19:18', '0000-00-00 00:00:00', 1),
(1155, 11, 117, 308, 1, 'unseen', '2014-12-04 22:19:27', '0000-00-00 00:00:00', 1),
(1156, 11, 118, 308, 1, 'unseen', '2014-12-04 22:19:36', '0000-00-00 00:00:00', 1),
(1157, 11, 119, 308, 1, 'unseen', '2014-12-04 22:19:45', '0000-00-00 00:00:00', 1),
(1158, 11, 120, 308, 1, 'unseen', '2014-12-04 22:19:52', '0000-00-00 00:00:00', 1),
(1159, 12, 121, 308, 1, 'unseen', '2014-12-04 22:19:58', '0000-00-00 00:00:00', 1),
(1160, 12, 122, 308, 1, 'unseen', '2014-12-04 22:20:10', '0000-00-00 00:00:00', 1),
(1161, 11, 123, 308, 1, 'unseen', '2014-12-04 22:59:37', '0000-00-00 00:00:00', 1),
(1162, 11, 124, 308, 1, 'unseen', '2014-12-04 23:00:07', '0000-00-00 00:00:00', 1),
(1163, 11, 125, 308, 1, 'unseen', '2014-12-04 23:00:30', '0000-00-00 00:00:00', 1),
(1164, 11, 126, 308, 1, 'unseen', '2014-12-04 23:00:36', '0000-00-00 00:00:00', 1),
(1165, 11, 127, 308, 1, 'unseen', '2014-12-04 23:01:13', '0000-00-00 00:00:00', 1),
(1166, 11, 128, 308, 1, 'unseen', '2014-12-04 23:07:26', '0000-00-00 00:00:00', 1),
(1167, 12, 129, 308, 1, 'unseen', '2014-12-04 23:07:36', '0000-00-00 00:00:00', 1),
(1168, 12, 130, 308, 1, 'unseen', '2014-12-04 23:08:09', '0000-00-00 00:00:00', 1),
(1169, 12, 131, 308, 1, 'unseen', '2014-12-04 23:08:14', '0000-00-00 00:00:00', 1),
(1170, 11, 132, 308, 1, 'unseen', '2014-12-04 23:25:31', '0000-00-00 00:00:00', 1),
(1171, 11, 133, 308, 1, 'unseen', '2014-12-04 23:26:48', '0000-00-00 00:00:00', 1),
(1172, 12, 134, 308, 1, 'unseen', '2014-12-04 23:27:04', '0000-00-00 00:00:00', 1),
(1173, 12, 135, 308, 1, 'unseen', '2014-12-04 23:27:22', '0000-00-00 00:00:00', 1),
(1174, 12, 136, 308, 1, 'unseen', '2014-12-04 23:27:42', '0000-00-00 00:00:00', 1),
(1175, 11, 137, 308, 1, 'unseen', '2014-12-04 23:33:17', '0000-00-00 00:00:00', 1),
(1176, 11, 138, 308, 1, 'unseen', '2014-12-04 23:33:48', '0000-00-00 00:00:00', 1),
(1177, 12, 139, 308, 1, 'unseen', '2014-12-05 09:54:30', '0000-00-00 00:00:00', 1),
(1178, 11, 140, 308, 1, 'unseen', '2014-12-05 09:54:42', '0000-00-00 00:00:00', 1),
(1179, 11, 141, 308, 1, 'unseen', '2014-12-05 09:55:04', '0000-00-00 00:00:00', 1),
(1180, 11, 142, 308, 1, 'unseen', '2014-12-05 09:55:09', '0000-00-00 00:00:00', 1),
(1181, 11, 143, 308, 1, 'unseen', '2014-12-05 09:55:21', '0000-00-00 00:00:00', 1),
(1182, 11, 144, 308, 1, 'unseen', '2014-12-05 09:58:47', '0000-00-00 00:00:00', 1),
(1183, 11, 145, 325, 1, 'unseen', '2014-12-05 10:17:03', '0000-00-00 00:00:00', 1),
(1184, 11, 146, 325, 1, 'unseen', '2014-12-05 10:19:06', '0000-00-00 00:00:00', 1),
(1185, 11, 147, 324, 1, 'unseen', '2014-12-05 10:34:05', '0000-00-00 00:00:00', 1),
(1186, 11, 148, 324, 1, 'unseen', '2014-12-05 10:34:28', '0000-00-00 00:00:00', 1),
(1187, 12, 149, 308, 1, 'unseen', '2014-12-05 10:39:16', '0000-00-00 00:00:00', 1),
(1188, 12, 150, 324, 1, 'unseen', '2014-12-05 10:39:51', '0000-00-00 00:00:00', 1),
(1189, 11, 151, 320, 1, 'unseen', '2014-12-05 11:29:48', '0000-00-00 00:00:00', 1),
(1190, 11, 152, 320, 1, 'unseen', '2014-12-05 11:29:55', '0000-00-00 00:00:00', 1),
(1191, 11, 153, 320, 1, 'unseen', '2014-12-05 11:30:03', '0000-00-00 00:00:00', 1),
(1192, 11, 154, 320, 1, 'unseen', '2014-12-05 11:30:24', '0000-00-00 00:00:00', 1),
(1193, 12, 155, 320, 1, 'unseen', '2014-12-05 11:31:03', '0000-00-00 00:00:00', 1),
(1194, 12, 156, 320, 1, 'unseen', '2014-12-05 11:31:17', '0000-00-00 00:00:00', 1),
(1195, 12, 157, 320, 1, 'unseen', '2014-12-05 11:31:27', '0000-00-00 00:00:00', 1),
(1196, 12, 158, 320, 1, 'unseen', '2014-12-05 11:31:31', '0000-00-00 00:00:00', 1),
(1197, 11, 159, 320, 1, 'unseen', '2014-12-05 11:31:39', '0000-00-00 00:00:00', 1),
(1198, 11, 160, 320, 1, 'unseen', '2014-12-05 11:31:45', '0000-00-00 00:00:00', 1),
(1199, 11, 161, 320, 1, 'unseen', '2014-12-05 11:31:50', '0000-00-00 00:00:00', 1),
(1200, 12, 162, 320, 1, 'unseen', '2014-12-05 11:57:31', '0000-00-00 00:00:00', 1),
(1201, 12, 163, 320, 1, 'unseen', '2014-12-05 11:57:39', '0000-00-00 00:00:00', 1),
(1202, 11, 164, 320, 1, 'unseen', '2014-12-05 11:57:46', '0000-00-00 00:00:00', 1),
(1203, 11, 165, 320, 1, 'unseen', '2014-12-05 11:57:50', '0000-00-00 00:00:00', 1),
(1204, 11, 166, 320, 1, 'unseen', '2014-12-05 11:58:04', '0000-00-00 00:00:00', 1),
(1205, 11, 167, 320, 1, 'unseen', '2014-12-05 12:00:28', '0000-00-00 00:00:00', 1),
(1206, 11, 168, 320, 1, 'unseen', '2014-12-05 12:14:15', '0000-00-00 00:00:00', 1),
(1207, 11, 169, 320, 1, 'unseen', '2014-12-05 12:14:30', '0000-00-00 00:00:00', 1),
(1208, 11, 170, 320, 1, 'unseen', '2014-12-05 12:15:14', '0000-00-00 00:00:00', 1),
(1209, 11, 171, 320, 1, 'unseen', '2014-12-05 12:16:46', '0000-00-00 00:00:00', 1),
(1210, 11, 172, 320, 1, 'unseen', '2014-12-05 12:18:05', '0000-00-00 00:00:00', 1),
(1211, 11, 173, 320, 1, 'unseen', '2014-12-05 12:22:54', '0000-00-00 00:00:00', 1),
(1212, 11, 174, 320, 1, 'unseen', '2014-12-05 12:24:14', '0000-00-00 00:00:00', 1),
(1213, 11, 175, 320, 1, 'unseen', '2014-12-05 12:25:31', '0000-00-00 00:00:00', 1),
(1214, 11, 176, 320, 1, 'unseen', '2014-12-05 12:38:29', '0000-00-00 00:00:00', 1),
(1215, 11, 177, 309, 1, 'unseen', '2014-12-05 15:13:34', '0000-00-00 00:00:00', 1),
(1216, 12, 178, 309, 1, 'unseen', '2014-12-05 15:14:27', '0000-00-00 00:00:00', 1),
(1217, 11, 179, 309, 1, 'unseen', '2014-12-05 15:14:42', '0000-00-00 00:00:00', 1),
(1218, 11, 180, 309, 1, 'unseen', '2014-12-05 15:31:50', '0000-00-00 00:00:00', 1),
(1219, 11, 181, 309, 1, 'unseen', '2014-12-05 15:31:57', '0000-00-00 00:00:00', 1),
(1220, 11, 182, 309, 1, 'unseen', '2014-12-05 15:32:04', '0000-00-00 00:00:00', 1),
(1221, 12, 183, 361, 1, 'unseen', '2014-12-05 20:29:24', '0000-00-00 00:00:00', 1),
(1222, 10, 184, 361, 1, 'unseen', '2014-12-05 20:40:04', '0000-00-00 00:00:00', 1),
(1223, 12, 185, 361, 1, 'unseen', '2014-12-05 20:40:13', '0000-00-00 00:00:00', 1),
(1224, 12, 186, 361, 1, 'unseen', '2014-12-05 20:43:43', '0000-00-00 00:00:00', 1),
(1225, 10, 187, 361, 1, 'unseen', '2014-12-05 20:47:34', '0000-00-00 00:00:00', 1),
(1226, 12, 188, 361, 1, 'unseen', '2014-12-05 22:36:34', '0000-00-00 00:00:00', 1),
(1227, 12, 189, 361, 1, 'unseen', '2014-12-05 22:36:41', '0000-00-00 00:00:00', 1),
(1228, 12, 190, 361, 1, 'unseen', '2014-12-05 22:36:48', '0000-00-00 00:00:00', 1),
(1229, 10, 191, 361, 1, 'unseen', '2014-12-05 22:36:55', '0000-00-00 00:00:00', 1),
(1230, 10, 192, 361, 1, 'unseen', '2014-12-05 22:42:38', '0000-00-00 00:00:00', 1),
(1231, 12, 193, 361, 1, 'unseen', '2014-12-05 22:42:44', '0000-00-00 00:00:00', 1),
(1232, 12, 194, 361, 1, 'unseen', '2014-12-05 22:59:50', '0000-00-00 00:00:00', 1),
(1233, 10, 195, 361, 1, 'unseen', '2014-12-05 23:02:15', '0000-00-00 00:00:00', 1),
(1234, 11, 196, 361, 1, 'unseen', '2014-12-06 08:55:18', '0000-00-00 00:00:00', 1),
(1235, 12, 197, 361, 1, 'unseen', '2014-12-06 08:55:45', '0000-00-00 00:00:00', 1),
(1236, 11, 198, 361, 1, 'unseen', '2014-12-06 09:15:32', '0000-00-00 00:00:00', 1),
(1237, 12, 199, 361, 1, 'unseen', '2014-12-06 09:15:57', '0000-00-00 00:00:00', 1),
(1238, 12, 200, 361, 1, 'unseen', '2014-12-06 09:17:21', '0000-00-00 00:00:00', 1),
(1239, 11, 201, 361, 1, 'unseen', '2014-12-06 09:27:03', '0000-00-00 00:00:00', 1),
(1240, 11, 202, 361, 1, 'unseen', '2014-12-06 09:27:39', '0000-00-00 00:00:00', 1),
(1241, 12, 203, 361, 1, 'unseen', '2014-12-06 09:38:29', '0000-00-00 00:00:00', 1),
(1242, 12, 204, 361, 1, 'unseen', '2014-12-06 09:38:43', '0000-00-00 00:00:00', 1),
(1243, 11, 205, 361, 1, 'unseen', '2014-12-06 09:38:55', '0000-00-00 00:00:00', 1),
(1244, 11, 206, 361, 1, 'unseen', '2014-12-06 09:39:39', '0000-00-00 00:00:00', 1),
(1245, 11, 207, 361, 1, 'unseen', '2014-12-06 09:39:42', '0000-00-00 00:00:00', 1),
(1246, 12, 208, 361, 1, 'unseen', '2014-12-06 09:39:51', '0000-00-00 00:00:00', 1),
(1247, 12, 209, 361, 1, 'unseen', '2014-12-06 09:40:34', '0000-00-00 00:00:00', 1),
(1248, 12, 210, 361, 1, 'unseen', '2014-12-06 09:42:11', '0000-00-00 00:00:00', 1),
(1249, 12, 211, 361, 1, 'unseen', '2014-12-06 09:42:32', '0000-00-00 00:00:00', 1),
(1250, 12, 212, 361, 1, 'unseen', '2014-12-06 09:42:48', '0000-00-00 00:00:00', 1),
(1251, 12, 213, 361, 1, 'unseen', '2014-12-06 09:42:59', '0000-00-00 00:00:00', 1),
(1252, 12, 214, 361, 1, 'unseen', '2014-12-06 09:43:22', '0000-00-00 00:00:00', 1),
(1253, 12, 215, 361, 1, 'unseen', '2014-12-06 09:43:35', '0000-00-00 00:00:00', 1),
(1254, 12, 216, 361, 1, 'unseen', '2014-12-06 09:44:17', '0000-00-00 00:00:00', 1),
(1255, 12, 217, 361, 1, 'unseen', '2014-12-06 09:44:28', '0000-00-00 00:00:00', 1),
(1256, 12, 218, 361, 1, 'unseen', '2014-12-06 09:45:11', '0000-00-00 00:00:00', 1),
(1257, 12, 219, 361, 1, 'unseen', '2014-12-06 09:45:55', '0000-00-00 00:00:00', 1),
(1258, 12, 220, 361, 1, 'unseen', '2014-12-06 09:46:12', '0000-00-00 00:00:00', 1),
(1259, 12, 221, 361, 1, 'unseen', '2014-12-06 09:46:20', '0000-00-00 00:00:00', 1),
(1260, 12, 222, 361, 1, 'unseen', '2014-12-06 09:48:37', '0000-00-00 00:00:00', 1),
(1261, 12, 223, 361, 1, 'unseen', '2014-12-06 09:48:50', '0000-00-00 00:00:00', 1),
(1262, 12, 224, 361, 1, 'unseen', '2014-12-06 09:49:07', '0000-00-00 00:00:00', 1),
(1263, 12, 225, 361, 1, 'unseen', '2014-12-06 09:50:47', '0000-00-00 00:00:00', 1),
(1264, 12, 226, 361, 1, 'unseen', '2014-12-06 09:54:20', '0000-00-00 00:00:00', 1),
(1265, 12, 227, 361, 1, 'unseen', '2014-12-06 09:54:52', '0000-00-00 00:00:00', 1),
(1266, 12, 228, 361, 1, 'unseen', '2014-12-06 09:54:58', '0000-00-00 00:00:00', 1),
(1267, 12, 229, 361, 1, 'unseen', '2014-12-06 09:55:04', '0000-00-00 00:00:00', 1),
(1268, 12, 230, 361, 1, 'unseen', '2014-12-06 09:55:09', '0000-00-00 00:00:00', 1),
(1269, 12, 231, 361, 1, 'unseen', '2014-12-06 09:55:14', '0000-00-00 00:00:00', 1),
(1270, 12, 232, 361, 1, 'unseen', '2014-12-06 09:55:42', '0000-00-00 00:00:00', 1),
(1271, 12, 233, 324, 1, 'unseen', '2014-12-06 09:58:05', '0000-00-00 00:00:00', 1),
(1272, 12, 234, 324, 1, 'unseen', '2014-12-06 09:58:10', '0000-00-00 00:00:00', 1),
(1273, 12, 235, 324, 1, 'unseen', '2014-12-06 10:18:39', '0000-00-00 00:00:00', 1),
(1274, 12, 236, 324, 1, 'unseen', '2014-12-06 10:42:17', '0000-00-00 00:00:00', 1),
(1275, 12, 237, 324, 1, 'unseen', '2014-12-06 10:45:02', '0000-00-00 00:00:00', 1),
(1276, 12, 238, 324, 1, 'unseen', '2014-12-06 10:45:07', '0000-00-00 00:00:00', 1),
(1277, 12, 239, 324, 1, 'unseen', '2014-12-06 11:06:44', '0000-00-00 00:00:00', 1),
(1278, 11, 240, 324, 1, 'unseen', '2014-12-06 11:07:43', '0000-00-00 00:00:00', 1),
(1279, 11, 241, 324, 1, 'unseen', '2014-12-06 11:13:13', '0000-00-00 00:00:00', 1),
(1280, 11, 242, 324, 1, 'unseen', '2014-12-06 11:13:29', '0000-00-00 00:00:00', 1),
(1281, 11, 243, 324, 1, 'unseen', '2014-12-06 11:13:46', '0000-00-00 00:00:00', 1),
(1282, 11, 244, 324, 1, 'unseen', '2014-12-06 11:14:10', '0000-00-00 00:00:00', 1),
(1283, 12, 245, 324, 1, 'unseen', '2014-12-06 11:26:52', '0000-00-00 00:00:00', 1),
(1284, 11, 246, 324, 1, 'unseen', '2014-12-06 11:27:27', '0000-00-00 00:00:00', 1),
(1285, 12, 247, 324, 1, 'unseen', '2014-12-06 11:27:43', '0000-00-00 00:00:00', 1),
(1286, 12, 248, 324, 1, 'unseen', '2014-12-06 11:32:20', '0000-00-00 00:00:00', 1),
(1287, 12, 249, 324, 1, 'unseen', '2014-12-06 11:32:30', '0000-00-00 00:00:00', 1),
(1288, 12, 250, 324, 1, 'unseen', '2014-12-06 11:33:24', '0000-00-00 00:00:00', 1),
(1289, 12, 251, 324, 1, 'unseen', '2014-12-06 11:34:23', '0000-00-00 00:00:00', 1),
(1290, 12, 252, 324, 1, 'unseen', '2014-12-06 11:34:35', '0000-00-00 00:00:00', 1),
(1291, 12, 253, 324, 1, 'unseen', '2014-12-06 11:35:28', '0000-00-00 00:00:00', 1),
(1292, 12, 254, 324, 1, 'unseen', '2014-12-06 11:36:22', '0000-00-00 00:00:00', 1),
(1293, 12, 255, 324, 1, 'unseen', '2014-12-06 11:42:42', '0000-00-00 00:00:00', 1),
(1294, 12, 256, 324, 1, 'unseen', '2014-12-06 11:43:23', '0000-00-00 00:00:00', 1),
(1295, 12, 257, 324, 1, 'unseen', '2014-12-06 11:43:45', '0000-00-00 00:00:00', 1),
(1296, 12, 258, 324, 1, 'unseen', '2014-12-06 11:44:26', '0000-00-00 00:00:00', 1),
(1297, 12, 259, 324, 1, 'unseen', '2014-12-06 11:45:10', '0000-00-00 00:00:00', 1),
(1298, 12, 260, 324, 1, 'unseen', '2014-12-06 11:45:44', '0000-00-00 00:00:00', 1),
(1299, 12, 261, 324, 1, 'unseen', '2014-12-06 11:45:51', '0000-00-00 00:00:00', 1),
(1300, 12, 262, 324, 1, 'unseen', '2014-12-06 11:46:18', '0000-00-00 00:00:00', 1),
(1301, 12, 263, 324, 1, 'unseen', '2014-12-06 11:46:28', '0000-00-00 00:00:00', 1),
(1302, 12, 264, 324, 1, 'unseen', '2014-12-06 11:46:41', '0000-00-00 00:00:00', 1),
(1303, 12, 265, 324, 1, 'unseen', '2014-12-06 11:47:23', '0000-00-00 00:00:00', 1),
(1304, 12, 266, 324, 1, 'unseen', '2014-12-06 11:48:12', '0000-00-00 00:00:00', 1),
(1305, 12, 267, 324, 1, 'unseen', '2014-12-06 11:48:28', '0000-00-00 00:00:00', 1),
(1306, 12, 268, 324, 1, 'unseen', '2014-12-06 11:48:35', '0000-00-00 00:00:00', 1),
(1307, 12, 269, 324, 1, 'unseen', '2014-12-06 11:48:57', '0000-00-00 00:00:00', 1),
(1308, 12, 270, 359, 1, 'unseen', '2014-12-06 11:49:21', '0000-00-00 00:00:00', 1),
(1309, 12, 271, 359, 1, 'unseen', '2014-12-06 11:49:43', '0000-00-00 00:00:00', 1),
(1310, 12, 272, 359, 1, 'unseen', '2014-12-06 11:50:01', '0000-00-00 00:00:00', 1),
(1311, 11, 273, 359, 1, 'unseen', '2014-12-06 11:53:33', '0000-00-00 00:00:00', 1),
(1312, 12, 274, 359, 1, 'unseen', '2014-12-06 11:53:41', '0000-00-00 00:00:00', 1),
(1313, 11, 275, 359, 1, 'unseen', '2014-12-06 11:53:51', '0000-00-00 00:00:00', 1),
(1314, 12, 276, 359, 1, 'unseen', '2014-12-06 11:53:56', '0000-00-00 00:00:00', 1),
(1315, 12, 277, 359, 1, 'unseen', '2014-12-06 11:54:04', '0000-00-00 00:00:00', 1),
(1316, 11, 278, 359, 1, 'unseen', '2014-12-06 12:03:10', '0000-00-00 00:00:00', 1),
(1317, 11, 279, 359, 1, 'unseen', '2014-12-06 12:03:15', '0000-00-00 00:00:00', 1),
(1318, 11, 280, 359, 1, 'unseen', '2014-12-06 12:10:22', '0000-00-00 00:00:00', 1),
(1319, 11, 281, 359, 1, 'unseen', '2014-12-06 12:10:30', '0000-00-00 00:00:00', 1),
(1320, 12, 282, 359, 1, 'unseen', '2014-12-06 12:11:20', '0000-00-00 00:00:00', 1),
(1321, 12, 283, 359, 1, 'unseen', '2014-12-06 12:11:59', '0000-00-00 00:00:00', 1),
(1322, 12, 284, 308, 1, 'unseen', '2014-12-06 13:01:08', '0000-00-00 00:00:00', 1),
(1323, 11, 285, 308, 1, 'unseen', '2014-12-06 13:01:16', '0000-00-00 00:00:00', 1),
(1324, 11, 286, 308, 1, 'unseen', '2014-12-06 13:02:03', '0000-00-00 00:00:00', 1),
(1325, 11, 287, 308, 1, 'unseen', '2014-12-06 13:02:15', '0000-00-00 00:00:00', 1),
(1326, 11, 288, 308, 1, 'unseen', '2014-12-06 13:02:21', '0000-00-00 00:00:00', 1),
(1327, 12, 289, 351, 1, 'unseen', '2014-12-06 13:03:00', '0000-00-00 00:00:00', 1),
(1328, 11, 290, 351, 1, 'unseen', '2014-12-06 13:03:15', '0000-00-00 00:00:00', 1),
(1329, 11, 291, 351, 1, 'unseen', '2014-12-06 13:03:23', '0000-00-00 00:00:00', 1),
(1330, 11, 292, 351, 1, 'unseen', '2014-12-06 13:03:37', '0000-00-00 00:00:00', 1),
(1331, 11, 293, 351, 1, 'unseen', '2014-12-06 13:03:42', '0000-00-00 00:00:00', 1),
(1332, 11, 294, 351, 1, 'unseen', '2014-12-06 13:03:49', '0000-00-00 00:00:00', 1),
(1333, 11, 295, 351, 1, 'unseen', '2014-12-06 13:03:54', '0000-00-00 00:00:00', 1),
(1334, 11, 296, 351, 1, 'unseen', '2014-12-06 13:04:45', '0000-00-00 00:00:00', 1),
(1335, 11, 297, 351, 1, 'unseen', '2014-12-06 13:04:52', '0000-00-00 00:00:00', 1),
(1336, 11, 298, 351, 1, 'unseen', '2014-12-06 13:05:05', '0000-00-00 00:00:00', 1),
(1337, 11, 299, 351, 1, 'unseen', '2014-12-06 13:05:13', '0000-00-00 00:00:00', 1),
(1338, 11, 300, 351, 1, 'unseen', '2014-12-06 13:06:43', '0000-00-00 00:00:00', 1),
(1339, 11, 301, 351, 1, 'unseen', '2014-12-06 13:07:20', '0000-00-00 00:00:00', 1),
(1340, 11, 302, 351, 1, 'unseen', '2014-12-06 13:11:32', '0000-00-00 00:00:00', 1),
(1341, 11, 303, 351, 1, 'unseen', '2014-12-06 13:11:43', '0000-00-00 00:00:00', 1),
(1342, 11, 304, 351, 1, 'unseen', '2014-12-06 13:11:57', '0000-00-00 00:00:00', 1),
(1343, 11, 305, 311, 1, 'unseen', '2014-12-06 20:25:12', '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notification_subscribe`
--

CREATE TABLE `notification_subscribe` (
`id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `channel_id` int(11) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=19 ;

--
-- Dumping data for table `notification_subscribe`
--

INSERT INTO `notification_subscribe` (`id`, `user_id`, `channel_id`) VALUES
(1, 11, 308),
(2, 12, 308),
(4, 11, 325),
(5, 11, 324),
(6, 12, 324),
(7, 11, 320),
(8, 12, 320),
(9, 11, 309),
(10, 12, 309),
(11, 12, 361),
(12, 10, 361),
(13, 11, 361),
(14, 12, 359),
(15, 11, 359),
(16, 12, 351),
(17, 11, 351),
(18, 11, 311);

-- --------------------------------------------------------

--
-- Table structure for table `restaurants`
--

CREATE TABLE `restaurants` (
`id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address_number` int(11) DEFAULT NULL,
  `address_street` varchar(255) NOT NULL,
  `address_ward` varchar(255) NOT NULL,
  `address_city` varchar(255) NOT NULL,
  `zipcode` varchar(10) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `capacity` int(11) NOT NULL,
  `opening_hour` int(2) unsigned NOT NULL,
  `closing_hour` int(2) unsigned NOT NULL,
  `lowest_price` int(10) unsigned DEFAULT NULL,
  `highest_price` int(10) unsigned DEFAULT NULL,
  `description` text NOT NULL,
  `album_id` int(11) NOT NULL,
  `restaurantscol` varchar(45) DEFAULT NULL,
  `address` varchar(45) DEFAULT NULL,
  `rating` float DEFAULT NULL,
  `latlong` varchar(255) DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL,
  `address_country` varchar(45) DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=739 ;

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_category_links`
--

CREATE TABLE `restaurant_category_links` (
  `restaurant_id` int(11) NOT NULL,
  `category_abbrev` varchar(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `restaurant_category_links`
--

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_country_links`
--

CREATE TABLE `restaurant_country_links` (
  `restaurant_id` int(11) NOT NULL,
  `country_abbrev` varchar(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `restaurant_country_links`
--


-- --------------------------------------------------------

--
-- Table structure for table `restaurant_language_links`
--

CREATE TABLE `restaurant_language_links` (
  `restaurant_id` int(11) NOT NULL,
  `language_abbrev` varchar(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_owners`
--

CREATE TABLE `restaurant_owners` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address` text NOT NULL,
  `phone_number` varchar(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
`id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `restaurant_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `album_id` int(11) NOT NULL,
  `rating` int(1) NOT NULL COMMENT 'value range 1-5',
  `publish_time` datetime NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=559 ;

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `user_id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `super_users`
--

CREATE TABLE `super_users` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
`id` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=133 ;

-- --------------------------------------------------------

--
-- Table structure for table `tag_restaurant`
--

CREATE TABLE `tag_restaurant` (
`id` int(11) NOT NULL,
  `tag_id` int(11) DEFAULT NULL,
  `restaurant_id` int(11) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4716 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
`id` int(11) unsigned zerofill NOT NULL COMMENT 'User ID',
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL COMMENT 'User''s password (encrypted string)',
  `email` varchar(255) NOT NULL,
  `account_type` int(2) unsigned NOT NULL COMMENT '0- owner; 1-superuser',
  `fullname` varchar(255) DEFAULT NULL,
  `gender` varchar(1) NOT NULL COMMENT '''M''- male; ''F''-Female',
  `dob` date DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL COMMENT 'name of the photo stored in the database',
  `facebookID` varchar(50) DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `account_type`, `fullname`, `gender`, `dob`, `profile_picture`, `facebookID`) VALUES
(00000000010, 'newbiettn', '$2y$10$aQb5CD/er2JRVGPPpiJfpuRmq5sJwD5ei/VFAY2/MmGYDlYBAqKjG', 'newbiettn@gmail.com', 0, '0', '', NULL, NULL, NULL),
(00000000011, 'newbiettn1', '$2y$10$kqmZJ8jjsmz8MFHIv/h.X.0YBxe.d2Im0akufCc9RHwSG3ZdsIWGS', 'ngoc@gmail.com', 0, '0', '', NULL, NULL, NULL),
(00000000012, 'newbiettn2', '$2y$10$ocUKhbDBLYxew4X4Se3eHeZsOi22BPMwP84nobHRLbTir0I/NoNwe', 'new@ngoc.mail', 0, '0', '', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `albums`
--
ALTER TABLE `albums`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
 ADD PRIMARY KEY (`id`), ADD KEY `restaurant_id` (`restaurant_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
 ADD PRIMARY KEY (`abbrev`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
 ADD PRIMARY KEY (`id`), ADD KEY `user_id` (`user_id`,`review_id`), ADD KEY `review_id` (`review_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
 ADD PRIMARY KEY (`abbrev`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
 ADD PRIMARY KEY (`abbrev`);

--
-- Indexes for table `medias`
--
ALTER TABLE `medias`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `name` (`name`), ADD KEY `album_id` (`album_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_subscribe`
--
ALTER TABLE `notification_subscribe`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restaurants`
--
ALTER TABLE `restaurants`
 ADD PRIMARY KEY (`id`), ADD KEY `owner_id` (`owner_id`), ADD KEY `address_city` (`address_city`);

--
-- Indexes for table `restaurant_category_links`
--
ALTER TABLE `restaurant_category_links`
 ADD KEY `restaurant_id` (`restaurant_id`), ADD KEY `category_abbrev` (`category_abbrev`);

--
-- Indexes for table `restaurant_country_links`
--
ALTER TABLE `restaurant_country_links`
 ADD KEY `restaurant_id` (`restaurant_id`), ADD KEY `country_abbrev` (`country_abbrev`);

--
-- Indexes for table `restaurant_language_links`
--
ALTER TABLE `restaurant_language_links`
 ADD KEY `restaurant_id` (`restaurant_id`), ADD KEY `language_abbrev` (`language_abbrev`);

--
-- Indexes for table `restaurant_owners`
--
ALTER TABLE `restaurant_owners`
 ADD PRIMARY KEY (`id`), ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
 ADD PRIMARY KEY (`id`), ADD KEY `user_id` (`user_id`,`restaurant_id`), ADD KEY `restaurant_id` (`restaurant_id`), ADD KEY `user_id_2` (`user_id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
 ADD PRIMARY KEY (`user_id`,`restaurant_id`), ADD KEY `subscription_restaurant_fk` (`restaurant_id`);

--
-- Indexes for table `super_users`
--
ALTER TABLE `super_users`
 ADD PRIMARY KEY (`id`), ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id_UNIQUE` (`id`), ADD UNIQUE KEY `name_UNIQUE` (`name`);

--
-- Indexes for table `tag_restaurant`
--
ALTER TABLE `tag_restaurant`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `facebookID_UNIQUE` (`facebookID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `albums`
--
ALTER TABLE `albums`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `medias`
--
ALTER TABLE `medias`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1344;
--
-- AUTO_INCREMENT for table `notification_subscribe`
--
ALTER TABLE `notification_subscribe`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `restaurants`
--
ALTER TABLE `restaurants`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=739;
--
-- AUTO_INCREMENT for table `restaurant_owners`
--
ALTER TABLE `restaurant_owners`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=559;
--
-- AUTO_INCREMENT for table `super_users`
--
ALTER TABLE `super_users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=133;
--
-- AUTO_INCREMENT for table `tag_restaurant`
--
ALTER TABLE `tag_restaurant`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4716;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT COMMENT 'User ID',AUTO_INCREMENT=13;