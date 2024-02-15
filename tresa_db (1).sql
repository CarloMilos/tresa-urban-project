-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 15, 2024 at 11:13 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tresa_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `ta_post_id` int(11) NOT NULL,
  `ta_post_add` varchar(45) NOT NULL,
  `ta_post_desc` varchar(1000) NOT NULL,
  `ta_post_dim` float NOT NULL,
  `ta_dim_unit` varchar(10) DEFAULT NULL,
  `ta_post_images` tinyblob NOT NULL,
  `ta_post_anon` varchar(45) NOT NULL,
  `FK_user_ta_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`ta_post_id`, `ta_post_add`, `ta_post_desc`, `ta_post_dim`, `ta_dim_unit`, `ta_post_images`, `ta_post_anon`, `FK_user_ta_user_id`) VALUES
(4, 'ad', '1221', 12, 'cm2', 0x666f726d696d616765732f444c2e706e67, '1', 10),
(5, 'ad', '1221', 12, 'cm2', 0x666f726d696d616765732f444c2e706e67, '1', 11),
(6, '1212', '12211', 1221, 'cm2', 0x666f726d696d616765732f636d7a2e706e67, '1', 12),
(7, 'mayb', 'dsdsa', 12, 'cm2', 0x666f726d696d616765732f636d7a2e706e67, '1', 13);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `ta_user_id` int(11) NOT NULL,
  `ta_user_name` varchar(155) NOT NULL,
  `ta_user_email` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`ta_user_id`, `ta_user_name`, `ta_user_email`) VALUES
(9, 'ok', 'not@gmai.c'),
(10, 'das', 'adssd@gmail.com'),
(11, 'das', 'adssd@gmail.com'),
(12, 'wait', 'asda@gmail.com'),
(13, 'workk', 'wae@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`ta_post_id`,`FK_user_ta_user_id`),
  ADD KEY `fk_post_user_idx` (`FK_user_ta_user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ta_user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `ta_post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `ta_user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `fk_post_user` FOREIGN KEY (`FK_user_ta_user_id`) REFERENCES `user` (`ta_user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
