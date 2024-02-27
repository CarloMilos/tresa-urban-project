-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 27, 2024 at 05:28 PM
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
-- Database: `tresadb`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(90) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(1, 'Trees'),
(2, 'Flowers'),
(3, 'Hedges'),
(4, 'Birds'),
(5, 'Insects');

-- --------------------------------------------------------

--
-- Table structure for table `category_has_post`
--

CREATE TABLE `category_has_post` (
  `FK_post_id` int(11) NOT NULL,
  `FK_category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category_has_post`
--

INSERT INTO `category_has_post` (`FK_post_id`, `FK_category_id`) VALUES
(10, 1),
(10, 2),
(10, 3),
(11, 1),
(11, 2),
(12, 1);

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `post_id` int(11) NOT NULL,
  `post_lat` float NOT NULL,
  `post_long` float NOT NULL,
  `post_desc` varchar(2000) NOT NULL,
  `post_dimens` varchar(45) NOT NULL,
  `post_land_type` varchar(45) NOT NULL,
  `post_anon` varchar(45) NOT NULL,
  `FK_user_id` int(11) NOT NULL,
  `validated` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`post_id`, `post_lat`, `post_long`, `post_desc`, `post_dimens`, `post_land_type`, `post_anon`, `FK_user_id`, `validated`) VALUES
(10, 51.4412, -2.57114, 'not even a garden', '100', 'private', '1', 12, 1),
(11, 51.4416, -2.5796, 'dasds', '118', 'private', '1', 13, 1),
(12, 51.4412, -2.57845, 'dasas', '12', 'public', '1', 14, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(512) NOT NULL,
  `user_email` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_email`) VALUES
(12, 'TryAgain', 'carlog@gmail.com'),
(13, 'Carlo', 'carlmol@gmail.com'),
(14, 'car', 'dsaas@Gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `category_has_post`
--
ALTER TABLE `category_has_post`
  ADD PRIMARY KEY (`FK_post_id`,`FK_category_id`),
  ADD KEY `fk_category_has_post_post1_idx` (`FK_post_id`),
  ADD KEY `fk_category_has_post_category_idx` (`FK_category_id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`,`FK_user_id`),
  ADD KEY `fk_post_user1_idx` (`FK_user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `category_has_post`
--
ALTER TABLE `category_has_post`
  ADD CONSTRAINT `fk_category_has_post_category` FOREIGN KEY (`FK_category_id`) REFERENCES `category` (`category_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_category_has_post_post1` FOREIGN KEY (`FK_post_id`) REFERENCES `post` (`post_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `fk_post_user1` FOREIGN KEY (`FK_user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
