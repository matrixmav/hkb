-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 10, 2015 at 03:32 PM
-- Server version: 5.5.43-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `hkbase`
--

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE IF NOT EXISTS `city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `country_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `country_id` (`country_id`,`state_id`),
  KEY `state_id` (`state_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `commission`
--

CREATE TABLE IF NOT EXISTS `commission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type` tinyint(4) NOT NULL COMMENT '1:Direct 2: Binary,',
  `rp` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE IF NOT EXISTS `contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `country_id` int(11) NOT NULL,
  `phone` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `country_id` (`country_id`),
  KEY `country_id_2` (`country_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE IF NOT EXISTS `country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `code` varchar(10) NOT NULL,
  `phone_code` varchar(5) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gateway`
--

CREATE TABLE IF NOT EXISTS `gateway` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `request_url` varchar(255) NOT NULL,
  `response_url` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `genealogy`
--

CREATE TABLE IF NOT EXISTS `genealogy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `placement` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `sponsor_user_id` int(11) NOT NULL,
  `position` varchar(100) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`sponsor_user_id`),
  KEY `sponsor_user_id` (`sponsor_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `mail`
--

CREATE TABLE IF NOT EXISTS `mail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `to_user_id` int(11) NOT NULL,
  `from_user_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `attachment` varchar(255) NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '2' COMMENT '1: Inbox, 2: compose,3: sent,4:trash',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` date NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `to_user_id` (`to_user_id`,`from_user_id`),
  KEY `from_user_id` (`from_user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `mail`
--

INSERT INTO `mail` (`id`, `to_user_id`, `from_user_id`, `subject`, `message`, `attachment`, `type`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'Test 12345', 'I am new to Yii Framework and need help with the same thing. Although the link mentioned in the previous messages with the answer is no longer available or does not open for me. Could someone please guide me to some other place with the same answer.', '', 2, 1, '2015-05-08', '2015-05-09 05:43:50'),
(2, 1, 2, 'Test cool', 'MBI — What if you''re going the other way? I want to get a module model to make a relationship with a model from the main structure. How do I import the main structure? Or do I need to?', '', 2, 1, '2015-05-08', '2015-05-09 05:43:50'),
(7, 2, 1, 'Test cool 123456789', 'sdafsdfsdaf', '', 2, 1, '2015-05-09', '2015-05-09 06:16:26'),
(8, 1, 1, '', 'sdafsdaf', '', 2, 1, '2015-05-09', '2015-05-09 07:29:00'),
(9, 1, 1, 'Cool testing', 'Testing Ram            \r\n\r\n===>\r\n            ramhemareddy@gmail.com : 2015-05-09 12:59:00\r\nsdafsdaf', '', 2, 1, '2015-05-09', '2015-05-09 09:16:58');

-- --------------------------------------------------------

--
-- Table structure for table `money_transfer`
--

CREATE TABLE IF NOT EXISTS `money_transfer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `to_user_id` int(11) NOT NULL,
  `from_user_id` int(11) NOT NULL,
  `fund_type` tinyint(4) NOT NULL COMMENT '1:RP,2:Amount',
  `comment` varchar(100) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` date NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `to_user_id` (`to_user_id`,`from_user_id`),
  KEY `to_user_id_2` (`to_user_id`),
  KEY `from_user_id` (`from_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE IF NOT EXISTS `order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `web_builder_url` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` date NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`package_id`,`transaction_id`),
  KEY `transaction_id` (`transaction_id`),
  KEY `package_id` (`package_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `package`
--

CREATE TABLE IF NOT EXISTS `package` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `coupon_code` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` date NOT NULL,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `referral_banner`
--

CREATE TABLE IF NOT EXISTS `referral_banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL,
  `size` varchar(100) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `referral_banner`
--

INSERT INTO `referral_banner` (`id`, `name`, `url`, `size`, `status`, `created_at`, `updated_at`) VALUES
(1, 'dsdafsdaf', 'sdafsdf', '343', 1, '2015-05-09', '2015-05-07 18:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

CREATE TABLE IF NOT EXISTS `state` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `country_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `country_id` (`country_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `summary`
--

CREATE TABLE IF NOT EXISTS `summary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `wallet_type` tinyint(4) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`transaction_id`),
  KEY `transaction_id` (`transaction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE IF NOT EXISTS `transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `mode` varchar(30) NOT NULL,
  `gateway_id` int(11) NOT NULL,
  `actual_amount` int(11) NOT NULL,
  `paid_amount` int(11) NOT NULL,
  `total_rp` int(11) NOT NULL,
  `used_rp` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `gateway_id` (`gateway_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sponsor_id` varchar(100) NOT NULL,
  `name` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL,
  `position` varchar(30) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `country_id` int(11) NOT NULL,
  `country_code` varchar(5) NOT NULL,
  `phone` int(11) NOT NULL,
  `data_of_birth` date NOT NULL,
  `skype_id` varchar(100) NOT NULL,
  `facebook_id` varchar(100) NOT NULL,
  `twitter_id` varchar(100) NOT NULL,
  `master_pin` int(6) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `sponsor_id`, `name`, `password`, `position`, `full_name`, `email`, `country_id`, `country_code`, `phone`, `data_of_birth`, `skype_id`, `facebook_id`, `twitter_id`, `master_pin`, `status`, `created_at`, `updated_at`) VALUES
(1, '12345', 'ramhemareddy', '734379e382de4feb0dce07cb1061ef48', 'right', 'Ram Hemareddy', 'ramhemareddy@gmail.com', 1, '91', 2147483647, '2015-05-07', 'ramhemareddy', '', '', 12345, 1, '2015-05-07', '2015-05-07 10:55:34'),
(2, '76543', 'Amogh', '734379e382de4feb0dce07cb1061ef48', 'right', 'Amogh Hemareddy', 'amogh@gmail.com', 2, '23', 424131312, '2013-05-17', '', '', '', 0, 0, '2015-05-08', '2015-05-08 11:25:51');

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

CREATE TABLE IF NOT EXISTS `user_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `street` varchar(100) NOT NULL,
  `city_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `zip_code` varchar(10) NOT NULL,
  `id_proof` varchar(100) NOT NULL,
  `address_proff` varchar(100) NOT NULL,
  `referral_banner_id` int(11) NOT NULL,
  `testimonials` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`city_id`,`state_id`,`country_id`),
  KEY `referral_banner_id` (`referral_banner_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `user_profile`
--

INSERT INTO `user_profile` (`id`, `user_id`, `address`, `street`, `city_id`, `state_id`, `country_id`, `zip_code`, `id_proof`, `address_proff`, `referral_banner_id`, `testimonials`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Bangalore', 'bangalore', 1, 3, 1, '12345', '', '', 1, 'teadsafds', 1, '2015-05-08', '2015-05-07 18:30:00'),
(2, 2, 'HSR', 'Bangalore', 2, 3, 1, '54543', '', '', 1, 'sdafsd  fdsa fd saf sd sa', 1, '2015-05-08', '2015-05-07 18:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `wallet`
--

CREATE TABLE IF NOT EXISTS `wallet` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `fund` float NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:cash,2:RP Wallet,3:Commission',
  `status` tinyint(4) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `city`
--
ALTER TABLE `city`
  ADD CONSTRAINT `city_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `city_ibfk_2` FOREIGN KEY (`state_id`) REFERENCES `state` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `commission`
--
ALTER TABLE `commission`
  ADD CONSTRAINT `commission_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `genealogy`
--
ALTER TABLE `genealogy`
  ADD CONSTRAINT `genealogy_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `genealogy_ibfk_2` FOREIGN KEY (`sponsor_user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mail`
--
ALTER TABLE `mail`
  ADD CONSTRAINT `mail_ibfk_1` FOREIGN KEY (`to_user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `mail_ibfk_2` FOREIGN KEY (`from_user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `money_transfer`
--
ALTER TABLE `money_transfer`
  ADD CONSTRAINT `money_transfer_ibfk_1` FOREIGN KEY (`to_user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `money_transfer_ibfk_2` FOREIGN KEY (`from_user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_ibfk_2` FOREIGN KEY (`package_id`) REFERENCES `package` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_ibfk_3` FOREIGN KEY (`transaction_id`) REFERENCES `transaction` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `state`
--
ALTER TABLE `state`
  ADD CONSTRAINT `state_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `summary`
--
ALTER TABLE `summary`
  ADD CONSTRAINT `summary_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `summary_ibfk_2` FOREIGN KEY (`transaction_id`) REFERENCES `transaction` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transaction_ibfk_2` FOREIGN KEY (`gateway_id`) REFERENCES `gateway` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD CONSTRAINT `user_profile_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_profile_ibfk_2` FOREIGN KEY (`referral_banner_id`) REFERENCES `referral_banner` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wallet`
--
ALTER TABLE `wallet`
  ADD CONSTRAINT `wallet_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
