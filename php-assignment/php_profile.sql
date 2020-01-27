-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 27, 2020 at 03:47 PM
-- Server version: 5.7.28-0ubuntu0.18.04.4
-- PHP Version: 7.2.24-0ubuntu0.18.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `php_profile`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `check_demo` ()  BEGIN SELECT * FROM demo; END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `demo_case_last_name` (`last` VARCHAR(30))  BEGIN  UPDATE demo SET last_name =  CONCAT(LCASE(LEFT(last_name,1)) , UCASE(SUBSTRING(last_name,2)))  WHERE last_name=last; END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `demo`
--

CREATE TABLE `demo` (
  `id` int(11) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) DEFAULT NULL,
  `trigger_before` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `trigger_after` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `demo`
--

INSERT INTO `demo` (`id`, `first_name`, `last_name`, `trigger_before`, `trigger_after`) VALUES
(1, 'adil', 'Hussain', '2020-01-23 06:00:33', '2020-01-23 06:00:33'),
(2, 'pawan', 'kHATRI', '2020-01-23 06:16:00', '2020-01-23 06:16:00'),
(3, 'pawan', 'kHATRI', '2020-01-23 06:16:34', '2020-01-23 06:16:34'),
(4, 'pawan', NULL, '2020-01-23 06:16:59', '2020-01-23 06:16:59'),
(5, 'pawan', NULL, '2020-01-23 06:18:30', '2020-01-23 06:18:30'),
(6, 'pawan', NULL, '2020-01-23 06:19:35', '2020-01-23 06:19:35'),
(7, 'pawan', NULL, '2020-01-23 06:22:58', '2020-01-23 06:22:58'),
(8, 'aDIL', NULL, '2020-01-23 09:00:03', '2020-01-23 09:00:03'),
(9, 'hELLO', 'WORLD', '2020-01-23 09:43:23', '2020-01-23 09:43:23');

-- --------------------------------------------------------

--
-- Table structure for table `demo_time`
--

CREATE TABLE `demo_time` (
  `before_stamp` datetime DEFAULT NULL,
  `after_stamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `demo_time`
--

INSERT INTO `demo_time` (`before_stamp`, `after_stamp`) VALUES
('2020-01-23 11:52:58', NULL),
(NULL, '2020-01-23 11:52:58'),
('2020-01-23 14:30:03', NULL),
(NULL, '2020-01-23 14:30:03'),
('2020-01-23 15:13:23', NULL),
(NULL, '2020-01-23 15:13:23');

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `id` int(11) NOT NULL,
  `skill` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`id`, `skill`) VALUES
(2, 'CSS'),
(3, 'JAVA'),
(4, 'C'),
(5, 'PYTHON'),
(6, 'JAVASCRIPT');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `state_id` int(11) NOT NULL,
  `state_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`state_id`, `state_name`) VALUES
(0, 'NONE'),
(1, 'ANDAMAN AND NICOBAR ISLANDS'),
(2, 'ANDHRA PRADESH'),
(3, 'ARUNACHAL PRADESH'),
(4, 'ASSAM'),
(5, 'BIHAR'),
(6, 'CHATTISGARH'),
(7, 'CHANDIGARH'),
(8, 'DAMAN AND DIU'),
(9, 'DELHI'),
(10, 'DADRA AND NAGAR HAVELI'),
(11, 'GOA'),
(12, 'GUJARAT'),
(13, 'HIMACHAL PRADESH'),
(14, 'HARYANA'),
(15, 'JAMMU AND KASHMIR'),
(16, 'JHARKHAND'),
(17, 'KERALA'),
(18, 'KARNATAKA'),
(19, 'LAKSHADWEEP'),
(20, 'MEGHALAYA'),
(21, 'MAHARASHTRA'),
(22, 'MANIPUR'),
(23, 'MADHYA PRADESH'),
(24, 'MIZORAM'),
(25, 'NAGALAND'),
(26, 'ORISSA'),
(27, 'PUNJAB'),
(28, 'PONDICHERRY'),
(29, 'RAJASTHAN'),
(30, 'SIKKIM'),
(31, 'TAMIL NADU'),
(32, 'TRIPURA'),
(33, 'UTTARAKHAND'),
(34, 'UTTAR PRADESH'),
(35, 'WEST BENGAL'),
(36, 'TELANGANA');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(30) DEFAULT NULL,
  `last_name` varchar(30) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `modified_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `email` varchar(30) DEFAULT NULL,
  `mobile_number` varchar(10) DEFAULT NULL,
  `state_id` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `image_address` varchar(100) DEFAULT NULL,
  `resume_address` varchar(100) DEFAULT NULL,
  `sex` enum('M','F') DEFAULT NULL,
  `prefix` enum('Mr','Mrs','Miss') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `age`, `modified_on`, `email`, `mobile_number`, `state_id`, `created_on`, `image_address`, `resume_address`, `sex`, `prefix`) VALUES
(12, 'Adil hussain', NULL, 26, '2020-01-27 15:25:26', 'vivaansahoo003@gmail.com', '9861196607', 1, '2020-01-23 17:29:05', '/profileImages/phpsWymrd', '/profileResume/phpoaMBgf', 'M', 'Mr'),
(14, 'Adil Hussain', NULL, 27, '2020-01-24 18:36:31', 'vivaansahoo003@gmail.com', '9861196600', 10, '2020-01-23 13:37:22', '/profileImages/phpzU7EDe', '/profileResume/phpKGMkY2', 'F', NULL),
(16, NULL, NULL, NULL, '2020-01-23 13:38:34', NULL, NULL, 0, '2020-01-23 13:38:34', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_credentials`
--

CREATE TABLE `user_credentials` (
  `id` int(11) NOT NULL,
  `password` varchar(500) NOT NULL,
  `user_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_credentials`
--

INSERT INTO `user_credentials` (`id`, `password`, `user_name`) VALUES
(12, '$2y$10$7gASq4tOQy9zHANIarqJMOW6rMPvDqSbbb2MjcxrW35nqNMTqhVQW', 'adil'),
(14, '$2y$10$e73q4dEoMEE20Brnd.D5w.sdBRgVU9LOvGTiXF2e9YjVFRzMzXjFK', 'test'),
(16, '$2y$10$tfyhn8FQ3Zd.JzTd6p35g.WpY/G08XJ3NqFYm8gi.Pyt6czBycMjK', 'test2');

--
-- Triggers `user_credentials`
--
DELIMITER $$
CREATE TRIGGER `set_profile` AFTER INSERT ON `user_credentials` FOR EACH ROW INSERT INTO users(id,modified_on,created_on,state_id) VALUES (NEW.id,NOW(),NOW(),0)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `user_skills`
--

CREATE TABLE `user_skills` (
  `user_id` int(11) NOT NULL,
  `skill_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_skills`
--

INSERT INTO `user_skills` (`user_id`, `skill_id`) VALUES
(12, 2),
(14, 4),
(12, 5),
(14, 5),
(12, 6),
(14, 6);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `demo`
--
ALTER TABLE `demo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`state_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `state_id` (`state_id`);

--
-- Indexes for table `user_credentials`
--
ALTER TABLE `user_credentials`
  ADD UNIQUE KEY `user_name` (`user_name`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `id_2` (`id`);

--
-- Indexes for table `user_skills`
--
ALTER TABLE `user_skills`
  ADD PRIMARY KEY (`user_id`,`skill_id`),
  ADD KEY `skill_id` (`skill_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `demo`
--
ALTER TABLE `demo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `user_credentials`
--
ALTER TABLE `user_credentials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_3` FOREIGN KEY (`id`) REFERENCES `user_credentials` (`id`);

--
-- Constraints for table `user_skills`
--
ALTER TABLE `user_skills`
  ADD CONSTRAINT `user_skills_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_skills_ibfk_2` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`),
  ADD CONSTRAINT `user_skills_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_skills_ibfk_4` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
