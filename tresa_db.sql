-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 15, 2024 at 09:02 PM
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
  `ta_post_images` tinyblob NOT NULL,
  `ta_post_anon` varchar(45) NOT NULL,
  `FK_user_ta_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `tag_id` int(11) NOT NULL,
  `tag_name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tags_for_post`
--

CREATE TABLE `tags_for_post` (
  `tags_tag_id` int(11) NOT NULL,
  `post_ta_post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
-- Indexes for dumped tables
--

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`ta_post_id`,`FK_user_ta_user_id`),
  ADD KEY `fk_post_user_idx` (`FK_user_ta_user_id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`tag_id`);

--
-- Indexes for table `tags_for_post`
--
ALTER TABLE `tags_for_post`
  ADD PRIMARY KEY (`tags_tag_id`,`post_ta_post_id`),
  ADD KEY `fk_tags_has_post_post1_idx` (`post_ta_post_id`),
  ADD KEY `fk_tags_has_post_tags1_idx` (`tags_tag_id`);

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
  MODIFY `ta_post_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `ta_user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `fk_post_user` FOREIGN KEY (`FK_user_ta_user_id`) REFERENCES `user` (`ta_user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tags_for_post`
--
ALTER TABLE `tags_for_post`
  ADD CONSTRAINT `fk_tags_has_post_post1` FOREIGN KEY (`post_ta_post_id`) REFERENCES `post` (`ta_post_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tags_has_post_tags1` FOREIGN KEY (`tags_tag_id`) REFERENCES `tags` (`tag_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
