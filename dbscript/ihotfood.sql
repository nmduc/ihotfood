-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2014 at 02:37 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ihotfood`
--

-- --------------------------------------------------------

--
-- Table structure for table `albums`
--

CREATE TABLE IF NOT EXISTS `albums` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `albums`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `restaurant_id` int(11) NOT NULL,
  `type` int(2) NOT NULL COMMENT '0-normal;1-promotion/event (with validity period)',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `publish_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `restaurant_id` (`restaurant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `abbrev` varchar(5) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`abbrev`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `review_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `publish_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`review_id`),
  KEY `review_id` (`review_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `abbrev` varchar(3) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`abbrev`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

CREATE TABLE IF NOT EXISTS `languages` (
  `abbrev` varchar(3) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`abbrev`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

CREATE TABLE IF NOT EXISTS `medias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `album_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL COMMENT 'name of the file ',
  `caption` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`filename`),
  KEY `album_id` (`album_id`),
  KEY `name_2` (`filename`),
  KEY `album_id_2` (`album_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `restaurants`
--

CREATE TABLE IF NOT EXISTS `restaurants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address_number` int(11) DEFAULT NULL,
  `address_street` varchar(255) NOT NULL,
  `address_ward` varchar(255) NOT NULL,
  `address_city` varchar(255) NOT NULL,
  `zipcode` varchar(10) NOT NULL,
  `latlong` varchar(255) NOT NULL,
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
  PRIMARY KEY (`id`),
  KEY `owner_id` (`owner_id`),
  KEY `address_city` (`address_city`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `restaurants`
--
-- --------------------------------------------------------

--
-- Table structure for table `restaurant_category_links`
--

CREATE TABLE IF NOT EXISTS `restaurant_category_links` (
  `restaurant_id` int(11) NOT NULL,
  `category_abbrev` varchar(5) NOT NULL,
  KEY `restaurant_id` (`restaurant_id`),
  KEY `category_abbrev` (`category_abbrev`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `restaurant_category_links`
--
-- --------------------------------------------------------

--
-- Table structure for table `restaurant_country_links`
--

CREATE TABLE IF NOT EXISTS `restaurant_country_links` (
  `restaurant_id` int(11) NOT NULL,
  `country_abbrev` varchar(3) NOT NULL,
  KEY `restaurant_id` (`restaurant_id`),
  KEY `country_abbrev` (`country_abbrev`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `restaurant_country_links`
--

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_language_links`
--

CREATE TABLE IF NOT EXISTS `restaurant_language_links` (
  `restaurant_id` int(11) NOT NULL,
  `language_abbrev` varchar(3) NOT NULL,
  KEY `restaurant_id` (`restaurant_id`),
  KEY `language_abbrev` (`language_abbrev`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `restaurant_language_links`
--

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_owners`
--

CREATE TABLE IF NOT EXISTS `restaurant_owners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `address` text NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE IF NOT EXISTS `reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `album_id` int(11) NOT NULL,
  `rating` int(1) NOT NULL COMMENT 'value range 1-5',
  `publish_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`restaurant_id`),
  KEY `restaurant_id` (`restaurant_id`),
  KEY `user_id_2` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=59 ;

--
-- Dumping data for table `reviews`
--

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE IF NOT EXISTS `subscriptions` (
  `user_id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`restaurant_id`),
  KEY `subscription_restaurant_fk` (`restaurant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `super_users`
--

CREATE TABLE IF NOT EXISTS `super_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'User ID',
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL COMMENT 'User''s password (encrypted string)',
  `email` varchar(255) NOT NULL,
  `account_type` int(2) unsigned NOT NULL COMMENT '0- owner; 1-superuser',
  `fullname` varchar(255) DEFAULT NULL,
  `gender` varchar(1) NOT NULL COMMENT '''M''- male; ''F''-Female',
  `dob` date DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL COMMENT 'name of the photo stored in the database',
  `facebookID` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`,`email`),
  UNIQUE KEY `facebookID_2` (`facebookID`),
  KEY `account_type` (`account_type`),
  KEY `facebookID` (`facebookID`),
  KEY `facebookID_3` (`facebookID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `users`
--

--
-- Constraints for dumped tables
--

--
-- Constraints for table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `article_restaurant_fk` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comment_review_fk` FOREIGN KEY (`review_id`) REFERENCES `reviews` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `medias`
--
ALTER TABLE `medias`
  ADD CONSTRAINT `medias_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `media_album_fk` FOREIGN KEY (`album_id`) REFERENCES `albums` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `restaurants`
--
ALTER TABLE `restaurants`
  ADD CONSTRAINT `restaurant_owner_fk` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `restaurant_category_links`
--
ALTER TABLE `restaurant_category_links`
  ADD CONSTRAINT `restaurant_category_links_ibfk_1` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `restaurant_category_links_ibfk_2` FOREIGN KEY (`category_abbrev`) REFERENCES `categories` (`abbrev`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `restaurant_country_links`
--
ALTER TABLE `restaurant_country_links`
  ADD CONSTRAINT `restaurant_country_links_ibfk_1` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `restaurant_country_links_ibfk_2` FOREIGN KEY (`country_abbrev`) REFERENCES `countries` (`abbrev`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `restaurant_language_links`
--
ALTER TABLE `restaurant_language_links`
  ADD CONSTRAINT `restaurant_language_links_ibfk_1` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `restaurant_language_links_ibfk_2` FOREIGN KEY (`language_abbrev`) REFERENCES `languages` (`abbrev`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `restaurant_owners`
--
ALTER TABLE `restaurant_owners`
  ADD CONSTRAINT `restaurant_owner_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `review_restaurant_fk` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `review_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD CONSTRAINT `subscription_restaurant_fk` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `subscription_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `super_users`
--
ALTER TABLE `super_users`
  ADD CONSTRAINT `super_user_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
