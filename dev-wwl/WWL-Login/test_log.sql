-- phpMyAdmin SQL Dump
-- version 4.0.10.18
-- https://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Dec 20, 2017 at 01:29 AM
-- Server version: 5.6.36-cll-lve
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `test_log`
--

-- --------------------------------------------------------

--
-- Table structure for table `charity`
--

CREATE TABLE IF NOT EXISTS `charity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `Contact_personnel` varchar(255) NOT NULL,
  `Phonenumber` varchar(255) NOT NULL,
  `Address` mediumtext NOT NULL,
  `Tax_ID` mediumtext NOT NULL,
  `non_profit_501c3` enum('No','Yes') NOT NULL,
  `Default` enum('No','Yes') NOT NULL,
  `Image` varchar(255) NOT NULL,
  `Description` mediumtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `charity`
--

INSERT INTO `charity` (`id`, `name`, `Contact_personnel`, `Phonenumber`, `Address`, `Tax_ID`, `non_profit_501c3`, `Default`, `Image`, `Description`) VALUES
(1, 'c', '', '', '', '', 'No', 'No', '', ''),
(8, 'Test', '', '', '', '', 'No', 'Yes', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `charity_under_user`
--

CREATE TABLE IF NOT EXISTS `charity_under_user` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `User_ID` int(11) NOT NULL,
  `Charity_ID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `Address` mediumtext NOT NULL,
  `Contact_personnel` varchar(255) NOT NULL,
  `Phonenumber` varchar(255) NOT NULL,
  `Tax_ID` mediumtext NOT NULL,
  `non_profit_501c3` enum('No','Yes') NOT NULL,
  `Approved` enum('No','Yes','Declined') NOT NULL,
  `Type` enum('user','default') NOT NULL,
  `Image` varchar(255) NOT NULL,
  `Description` mediumtext NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=294 ;

--
-- Dumping data for table `charity_under_user`
--

INSERT INTO `charity_under_user` (`ID`, `User_ID`, `Charity_ID`, `name`, `Address`, `Contact_personnel`, `Phonenumber`, `Tax_ID`, `non_profit_501c3`, `Approved`, `Type`, `Image`, `Description`) VALUES
(50, 50, 0, 'St. Judes', '12212', 'Jon', '57388329', 'sjkfjs', 'Yes', 'Yes', 'user', '', ''),
(224, 50, 0, 'alpha demo', '1234', 'Tim', '48384394339', 'ad3829', 'Yes', 'Yes', 'user', 'upload_images/charity/1504472370_00T0T_j6PC5cn9Sn5_600x450.jpg', ''),
(226, 50, 8, 'Test', '', '', '', '', 'No', 'Yes', 'default', '', ''),
(269, 50, 3, 'charity 1', 'test address', 'test contact', '656757575', '76587678', 'Yes', 'Yes', 'user', '', ''),
(279, 50, 0, 'F. Scott Jewell Fund for Life', '11961 Amherst Ct Plymouth Michigan 48170', 'Scott Jewell', '+1-720-841-0330', 'N/a', 'No', 'No', 'user', 'upload_images/charity/1513199781_scott.jpg', 'Help Scott Jewell Do Something?');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE IF NOT EXISTS `tbl_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(60) NOT NULL,
  `lastname` varchar(60) NOT NULL,
  `username` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(255) NOT NULL,
  `usertype` int(11) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=79 ;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`user_id`, `firstname`, `lastname`, `username`, `email`, `password`, `usertype`) VALUES
(50, 'Dash', 'D', 'dashd', 'dashd121@gmail.com', '$2y$10$vdhXRAn8THCAx/TW7hMZE.xeo0iudT43Ab2UvQ4qNqZZWnKMUNVua', 2),
(71, 'mayada', 'yehia', 'Mayada Yehia', 'mayada.yehia@gmail.com', '$2y$10$0UDzPsq57uAnEYUUVqwqhOi051T1ZJLqoaHciLRhtAfWfDsRHUKcu', 2),
(77, 'Sajjad', 'Saeed', 'sajjadsaeed', 'cb8882@gmail.com', '$2y$10$yidi1cvl44NsTEhSPo5/MuqCSTHL/9qiHbx5sfYiZWQlAHVKARuJe', 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
